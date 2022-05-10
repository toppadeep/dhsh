<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = PostResource::collection(Post::all());
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
        $imagePath = $request->file('cover')->move('posts/images', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Со

        $images = [];
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = $file->getClientOriginalName();
                $imagePath = $file->move('posts/images', $imageName);
                $images[] =  [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/',  $imagePath),
                ];
            }
        }

        $documents = [];
        if ($request->file('documents')) {
            foreach ($request->file('documents') as $file) {
                $documentSize =  $file->getSize();
                $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
                $documentExtension = $file->getClientOriginalExtension();
                $documentName =  $file->getClientOriginalName();
                $documentPath = $file->move('posts/documents', $documentName); // Создаем путь для документа
                $documents[] = [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath),
                    'size' => $documentSizeFull,
                    'extension' =>  $documentExtension,
                    'name' => $documentName
                ];
            }
        }

        $date = Carbon::now();
        $date = $date->locale('ru')->isoFormat('D MMMM, YYYY');

        $user = User::where('token', $request->bearerToken())->first();
        $user_id = $user->id;

        $post_slug = urldecode( Str::slug($request->title) );
        $post_slug = preg_replace('/([^a-z\d\-\_])/', '', $post_slug);

        Post::create([
            "title" => $request->title,
            "body" => $request->body,
            "subtitle" => $request->subtitle,
            "cover" => $imageFullPath,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "date" => $date,
            "user_id" => $user_id,
            "slug" => $post_slug,
            "category_id" => $request->category_id,
        ]);

        return response()->json(["status" => true, "message" => "Пост успешно создан"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Str  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $post = new PostResource(Post::where('slug', $slug)->first()); // Ищем пост по slug

        if (!$post) {
            return response()->json(["status" => false, "message" => "Пост не найдён"], 404);
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
            return response()->json(["status" => false, "message" => "Пост не найден"], 404);
        }

        $user = User::where('token', $request->bearerToken())->first();
        if (!$user) {
            return response()->json(["status" => false, "message" => "Токен запроса недействителен"]);
        }elseif ($post->user_id !== $user->id) {
            return response()->json(["status" => false, "message" => "Доступ запрещён"], 401);
        }


        if ($request->hasFile('cover')) {
            $coverName = time() . '.' . $request->cover->getClientOriginalExtension();
            $coverPath = $request->cover->move('posts/images', $coverName);
            $coverFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $coverPath);
        }else {
            $coverFullPath = Post::find($id)->cover;
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = $file->getClientOriginalName();
                $imagePath = $file->move('posts/images', $imageName);
                $images[] =  [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/',  $imagePath),
                ];
            }
        }else {
            $oldFiles = json_decode(Post::find($id)->images, true);
            $images =  $oldFiles;
        }

        if ($request->file('documents')) {
            foreach ($request->file('documents') as $file) {
                $documentSize =  $file->getSize();
                $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
                $documentExtension = $file->getClientOriginalExtension();
                $documentName =  $file->getClientOriginalName();
                $documentPath = $file->move('posts/documents', $documentName); // Создаем путь для документа
                $documents[] = [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath),
                    'size' => $documentSizeFull,
                    'extension' =>  $documentExtension,
                    'name' => $documentName
                ];
            }
        }else {
            $oldFiles = Post::find($id)->documents;
            $documents =  $oldFiles;
        }

        $post->update([
            "title" => $request->title,
            "subtitle" => $request->subtitle,
            "body" => $request->body,
            "cover" =>  $coverFullPath,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "category_id" => $request->category_id,
        ]);

        return response()->json(["status" => true, "message" => "Пост успешно обновлён"]);
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
            return response()->json(["status" => false, "message" => "Пост не найден"], 404);
        }

        $post->delete();

        return response()->json(["status" => true, "message" => "Пост удалён"]);
    }

}
