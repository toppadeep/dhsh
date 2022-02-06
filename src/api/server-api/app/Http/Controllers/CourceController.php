<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourceRequest;
use App\Http\Resources\CourceResource;
use App\Models\Cource;
use Illuminate\Http\Request;

class CourceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index'); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->only('destroy'); // Использовать посредник только для одного метода
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cources = Cource::all();
        $cources = CourceResource::collection($cources);
        return response()->json($cources);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourceRequest $request)
    {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension(); // Создаем имя для картинки
        $imagePath = $request->image->move('uploads/cources', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath);

        $cource = Cource::create([
            "title" => $request->title,
            "body" => $request->body,
            "payment"=> $request->payment,
            "image" =>  $imageFullPath,
        ]);

        return response()->json($cource);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cource  $cource
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cource = Cource::find($id);
        if (!$cource) {
            return response()->json(["status" => false, "message" => "Cource not found"], 404);
        }

        $cource = new CourceResource($cource);

        return response()->json(["status" => true, "cource" => $cource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cource  $cource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cource = Cource::find($id);
        if (!$cource) {
            return response()->json(["status" => false, "message" => "cource not found"], 404);
        }
        $imageFullPath = "";

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension(); // Создаем имя для картинки
            $imagePath = $request->image->move('uploads', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }

        $cource->update([
            "title" => $request->title,
            "body" => $request->body,
            "image" => $imageFullPath,
            "payment" => $request->payment
        ]);

        return response()->json(["status" => true, "message" => "Cource updated", 'cource' => $cource]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cource  $cource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cource = Cource::find($id);

        if (!$cource) {
            return response()->json(["status" => false, "message" => "Cource has`t delete"]);
        }

        $cource->delete();

        return response()->json(["status" => true, "message" => "Cource has be deleted", "Удалённый курс"=>$cource->id]);
    }

    public function courceCount()
    {
        $courceCount = Cource::all()->count();
        if (!$courceCount) {
            return response()->json(0);
        }
        return response()->json($courceCount);
    }

}
