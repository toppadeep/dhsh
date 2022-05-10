<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*  public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->except('index', 'show'); // Использовать посредник только для одного метода
    }  */

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories);
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category_slug = urldecode( Str::slug($request->name) );
        $category_slug = preg_replace('/([^a-z\d\-\_])/', '', $category_slug);

        Category::create([
            "name" => $request->name,
            "slug" => $category_slug
        ]);

        return response()->json(['status' => true, 'message' => 'Категория успешно создана']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Str  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $category = new CategoryResource(Category::where('slug', $slug)->first());

        if (!$category) {
            return response()->json(["status" => false, "message" => "Категория не найдёна"], 404);
        }
        return response()->json($category);
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
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["status" => false, "message" => "Категория не найдена"], 404);
        }

        $category->update([
            "name"=> $request->name,
        ]);

        return response()->json(["status" => true, "message" => "Категория обновлена"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["status" => false, "message" => "Категория не найдена"]);
        }

        $category->delete();

        return response()->json(["status" => true, "message" => "Категория была удалена"]);
    }

}
