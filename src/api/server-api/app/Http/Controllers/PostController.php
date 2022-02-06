<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('admin')->only('destroy');
        $this->middleware('cors')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::all();
        $posts = PostResource::collection($posts);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostStoreRequest $request)
    {
        $imageName = time() . '.' . $request->file('cover')->getClientOriginalExtension(); // Создаем имя для картинки
        $imagePath = $request->file('cover')->move('uploads/coverPosts', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Со
        $fileFullPath = [];
        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->move('uploads/postImages', $fileName);
            $fileFullPath[] =  [
                'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/',  $filePath),
            ];
        }
        $date = Carbon::now();
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        $hour = $date->hour + 7;
        $minute = $date->minute;
        $second = $date->second;
        $date = Carbon::create($year, $month, $day, $hour, $minute, $second);

        $user = User::where('token', $request->bearerToken())->first();
        $user_id = $user->id;

        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body,
            "subtitle" => $request->subtitle,
            "cover" => $imageFullPath,
            "files" =>  json_encode($fileFullPath, true),
            "date" => $date,
            "user_id" => $user_id,
            "category_id" => $request->category_id,
        ]);

        return response()->json(["code" => 201, "message" => "Пост успешно создан" ,$post, $post->files]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id); // Ищем пост по id
        if (!$post) {
            return response()->json(["status" => false, "message" => "Post not found"], 404);
        }

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(["status" => false, "message" => "Post not found"], 404);
        }

        $user = User::where('token', $request->bearerToken())->first();
        if ($post->user_id !== $user->id) {
            return response()->json(["status" => false, "message" => "Access denied"], 401);
        }


        $coverFullPath = "";
        if ($request->hasFile('cover')) {
            $coverName = time() . '.' . $request->cover->getClientOriginalExtension();
            $coverPath = $request->cover->move('uploads/coverPost', $coverName);
            $coverFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $coverPath);
        }


        $post->update([
            "title" => $request->title,
            "subtitle" => $request->subtitle,
            "body" => $request->body,
            "cover" => $coverFullPath,
            "images" => $imageFullPath,
            "category_id" => $request->category_id,
        ]);

        return response()->json(["code" => 201, "message" => "Пост успешно обновлён" ,$post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(["status" => false, "message" => "Post not found"], 404);
        }

        $post->delete();

        return response()->json(["status" => true]);
    }

    public function postCount()
    {
        $postCount = Post::all()->count('id');
        if (!$postCount) {
            return response()->json(0);
        }
        return response()->json($postCount);
    }

    public function counterViewed($id) {
        $post = Post::find($id);

        if($post) {
            $post = $post->viewed + 1;
            $post->save();
        }
    }

}
