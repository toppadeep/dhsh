<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\CourceTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'showCource']); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->only('destroy'); // Использовать посредник только для одного метода
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacher = Teacher::all();
        $teacher = TeacherResource::collection($teacher);
        return response()->json($teacher);
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
            $imagePath = $request->avatar->move('uploads/teachers', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }else {
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', 'uploads/teachers/default.png');
        }
        $fileFullPath = [];
        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->move('uploads/teacherImages', $fileName);
            $fileFullPath[] =  [
                'path' => 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/',  $filePath),
            ];
        }

        $teacher = Teacher::create([
            "name" => $request->name,
            "description" => $request->description,
            "role" => $request->role,
            "education" => $request->education,
            "files" =>  json_encode($fileFullPath, true),
            "avatar" => $imageFullPath,
        ]);

        return response()->json(["code" => 201, "message" => "Учитель успешно создан" ,$teacher]);
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
            return response()->json(["status" => false, "message" => "teacher not found"], 404);
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
            return response()->json(["status" => false, "message" => "teacher not found"], 404);
        }

        $imageFullPath = "";
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalExtension(); // Создаем имя для картинки
            $imagePath = $request->avatar->move('uploads', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }

        $teacher->update([
            "name" => $request->name,
            "description" => $request->description,
            "role"=> $request->role,
            "education" => $request->education,
            "avatar" =>  $imageFullPath,
        ]);

        return response()->json(["status" => true, "message" => "teacher updated", 'teacher' => $teacher]);
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
            return response()->json(["status" => false, "message" => "Teacher has`t delete"]);
        }

        $teacher->delete();

        return response()->json(["status" => true, "message" => "Teacher has be deleted"]);
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

    public function teacherCount()
    {
        $teacherCount = Teacher::all()->count();
        if (!$teacherCount) {
            return response()->json(0);
        }
        return response()->json($teacherCount);
    }

}
