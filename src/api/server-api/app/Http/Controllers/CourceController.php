<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourceRequest;
use App\Http\Resources\CourceResource;
use App\Models\Category;
use App\Models\Cource;
use Illuminate\Http\Request;
/* public function __construct()
    {
        $this->middleware('auth')->except('index'); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->only('destroy'); // Использовать посредник только для одного метода
    } */

class CourceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Cource::all();
        $courses = CourceResource::collection($courses);
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourceRequest $request)
    {
        $coverName = $request->file('cover')->getClientOriginalName();
        $coverPath = $request->file('cover')->move('courses/images', $coverName);
        $coverFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $coverPath);
        $images = [];
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = $file->getClientOriginalName();
                $imagePath = $file->move('courses/images', $imageName);
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
                $documentPath = $file->move('courses/documents', $documentName); // Создаем путь для документа
                $documents[] = [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath),
                    'size' => $documentSizeFull,
                    'extension' =>  $documentExtension,
                    'name' => $documentName
                ];
            }
        }

        Cource::create([
            "title" => $request->title,
            "body" => $request->body,
            "cover" =>  $coverFullPath,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "payment"=> $request->payment,
        ]);

        return response()->json(['status' => true, 'message' => 'Курс успешно добавлен']);
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
            return response()->json(["status" => false, "message" => "Курс не найден"], 404);
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
            return response()->json(["status" => false, "message" => "Курс не найден"], 404);
        }

        if ($request->hasFile('cover')) {
            $coverName = time() . '.' . $request->cover->getClientOriginalExtension();
            $coverPath = $request->cover->move('courses/images', $coverName);
            $coverFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $coverPath);
        }else {
            $coverFullPath = Cource::find($id)->cover;
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = $file->getClientOriginalName();
                $imagePath = $file->move('courses/images', $imageName);
                $images[] =  [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/',  $imagePath),
                ];
            }
        }else {
            $oldFiles = json_decode(Cource::find($id)->images, true);
            $images =  $oldFiles;
        }

        if ($request->file('documents')) {
            foreach ($request->file('documents') as $file) {
                $documentSize =  $file->getSize();
                $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
                $documentExtension = $file->getClientOriginalExtension();
                $documentName =  $file->getClientOriginalName();
                $documentPath = $file->move('courses/documents', $documentName); // Создаем путь для документа
                $documents[] = [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath),
                    'size' => $documentSizeFull,
                    'extension' =>  $documentExtension,
                    'name' => $documentName
                ];
            }
        }else {
            $oldFiles = Cource::find($id)->documents;
            $documents =  $oldFiles;
        }

        $cource->update([
            "title" => $request->title,
            "body" => $request->body,
            "cover" =>  $coverFullPath,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "payment" => $request->payment
        ]);

        return response()->json(["status" => true, "message" => "Курс успешно обновлён"]);
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
            return response()->json(["status" => false, "message" => "Курс не найден"]);
        }

        $cource->delete();

        return response()->json(["status" => true, "message" => "Курс успешно удалён"]);
    }

}
