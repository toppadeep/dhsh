<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\CourceTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();
        $teachers = TeacherResource::collection($teachers);
        return response()->json($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalExtension(); // Создаем имя для картинки
            $imagePath = $request->avatar->move('teacher/images', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }else {
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', 'uploads/teachers/default.png');
        }

        $images = [];
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = $file->getClientOriginalName();
                $imagePath = $file->move('teachers/images', $imageName);
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
                $documentPath = $file->move('teachers/documents', $documentName); // Создаем путь для документа
                $documents[] = [
                    'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath),
                    'size' => $documentSizeFull,
                    'extension' =>  $documentExtension,
                    'name' => $documentName
                ];
            }
        }

        Teacher::create([
            "name" => $request->name,
            "description" => $request->description,
            "role" => $request->role,
            "education" => $request->education,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "avatar" => $imageFullPath,
        ]);

        return response()->json(["status" => true, "message" => "Учитель успешно создан"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json(["status" => false, "message" => "Учитель не найден"], 404);
        }

        return response()->json([$teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json(["status" => false, "message" => "Учитель не найден"], 404);
        }

        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalExtension(); // Создаем имя для картинки
            $imagePath = $request->avatar->move('teachers/images', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }else {
            $imageFullPath = Teacher::find($id)->avatar;
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
            $oldFiles = json_decode(Teacher::find($id)->images, true);
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
            $oldFiles = json_decode(Teacher::find($id)->documents, true);;
            $documents =  $oldFiles;
        }

        $teacher->update([
            "name" => $request->name,
            "description" => $request->description,
            "role"=> $request->role,
            "education" => $request->education,
            "images" =>  json_encode($images, true),
            "documents" =>  json_encode($documents, true),
            "avatar" =>  $imageFullPath,
        ]);

        return response()->json(["status" => true, "message" => "Обновлено"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json(["status" => false, "message" => "Учитель не найден"]);
        }

        $teacher->delete();

        return response()->json(["status" => true, "message" => "Учитель успешно удалён"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */

    public function showCource($id)
    {
        $cource = CourceTeacher::select('cource_id')->where('teacher_id',$id)->get();
        if (!$cource) {
            return response()->json(["status" => false, "message" => "Связанных курсов не найдено"]);
        }
        return response()->json($cource);
    }

}
