<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->except('index', 'show'); // Использовать посредник только для одного метода
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
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
        $category = Category::create([
            "name" => $request->name,
        ]);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["status" => false, "message" => "Category not found"], 404);
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
            return response()->json(["status" => false, "message" => "Category not found"], 404);
        }

        $category->update([
            "name"=> $request->name,
        ]);

        return response()->json(["status" => true, "message" => "Category updated", 'category' => $category->name]);
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
            return response()->json(["status" => false, "message" => "Category has`t delete"]);
        }

        $category->delete();

        return response()->json(["status" => true, "message" => "Category has be deleted"]);
    }

    public function categoryCount()
    {
        $categoryCount = Category::all()->count();
        if (!$categoryCount) {
            return response()->json(0);
        }
        return response()->json($categoryCount);
    }

}
