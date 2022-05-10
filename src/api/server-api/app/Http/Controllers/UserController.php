<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
    public function index()
    {
        $users = UserResource::collection(User::all());
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */

    public function favorite($id, $postId) {

        $user = User::find($id);
        $post = Post::find($postId);

        if ($user->posts()->wherePivot('post_id', $postId)->exists() && $user->posts()->wherePivot('user_id', $id)->exists()) {
            $user->posts()->detach($post);
            return  response()->json(['favorites' =>  $user->posts()->get()]);
        }else {
            $user->posts()->attach($post);
            return  response()->json(['favorites' =>  $user->posts()->get()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $imageName = time() . '.' . $request->avatar->getClientOriginalExtension(); // Создаем имя для картинки
        $imagePath = $request->avatar->move('users/images', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки

        $user = User::create([ // Создаем и заносим пользователя в таблицу
            "name" => $request->name,
            "login" => $request->login,
            "password" => $request->password,
            "avatar" => $imageFullPath
        ]);

        return response()->json(['status' => true, 'user' => $user]);
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

        $user = new UserResource(User::where('login', $request->login)->first());

        return response()->json(['status' => true,'token' => $token, 'user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = new UserResource(User::where('token', $request->bearerToken())->first());

        if (!$user) {
            return response()->json(["status" => false, "message" => "Пользователь не найдён"], 404);
        }
        return response()->json($user);
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
