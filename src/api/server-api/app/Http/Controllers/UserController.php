<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only('destroy'); // Использовать посредник только для одного метода
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('token', $request->bearerToken())->first();
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegisterRequest $request)
    {
        $imageName = time() . '.' . $request->avatar->getClientOriginalExtension(); // Создаем имя для картинки
        $imagePath = $request->avatar->move('uploads', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки

        $user = User::create([ // Создаем и заносим пользователя в таблицу
            "name" => $request->name,
            "login" => $request->login,
            "password" => $request->password,
            "avatar" => $imageFullPath
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user = User::where('login', $request->login)->first();
        if (
            !$user ||
            $user->password !== $request->password
        ) {
            return response()->json(["status" => false, "message" => "Incorrect login or password"])->setStatusCode(400, 'Incorrect login or password');
        }

        $token = Str::random(150); // Генерируем токен
        $user->token = $token; // Задаем токен
        $user->save(); // Сохраняем изменения

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $user = User::where('token', $request->bearerToken())->first(); // Делаем поиск по токену и забираем первую строку
        $user->token = null; // Присваиваем токену null
        $user->save(); // Сохраняем изменения

        return response()->json(["status" => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
