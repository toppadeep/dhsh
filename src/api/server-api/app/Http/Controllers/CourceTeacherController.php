<?php

namespace App\Http\Controllers;

use App\Models\CourceTeacher;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CourceTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courceTeacher = CourceTeacher::all();

        if (!$courceTeacher) {
            return response()->json(['status'=>false, 'message' => 'CourceTeacher not found']);
        }

        return response()->json(['status'=>true, 'message' => $courceTeacher]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courceTeacher = CourceTeacher::create([
            "teacher_id" => $request->teacher_id,
            "cource_id" => $request->cource_id,
        ]);

        return response()->json(['status' => true, 'message' => 'Created', 'CourceTeacher' => $courceTeacher]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courceTeacher = CourceTeacher::find($id);

        if(!$courceTeacher) {
            return response()->json(['status' => false, 'message' => 'Not found relationship id']);
        }

        return response()->json(['status'=>true, 'message' => $courceTeacher]);
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
        $courceTeacher = CourceTeacher::find($id);

        $courceTeacher -> update ([
            "teacher_id" => $request->teacher_id,
            "cource_id" => $request->cource_id,
        ]);

        $courceTeacher -> save();

        return response()->json(['status' => true, 'message' => 'Updated', 'CourceTeacher' => $courceTeacher]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courceTeacher = CourceTeacher::find($id);

        $courceTeacher -> delete();

        return response()->json(['status' => true, 'message' => 'Deleted', 'CourceTeacher' => $courceTeacher]);
    }
}
