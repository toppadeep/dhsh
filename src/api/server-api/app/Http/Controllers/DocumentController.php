<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); // Использовать посредник для всех методов, кроме ....
        $this->middleware('admin')->only('destroy'); // Использовать посредник только для одного метода
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

        if (!$documents) {
            return response()->json(["status" => false, "message" => 'Document not found']);
        }

        return response()->json(["status" => true, "message" => $documents]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension(); // Создаем имя для картинки
        $imagePath = $request->image->move('uploads', $imageName); // Создаем путь для картинки
        $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath);
        $documentSize = $request->document->getSize();
        $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
        $documentExtension = $request->document->getClientOriginalExtension();
        $documentName = $request->title . '.' . $documentExtension;
        $documentPath = $request->document->move('documents', $documentName); // Создаем путь для документа
        $document = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath);

        $document = Document::create([
            "title" => $request->title,
            "filesize" => $documentSizeFull,
            "filetype" =>  $documentExtension,
            "image" => $imageFullPath,
            "document" => $document,
        ]);


        return response()->json(["status" => true, "document" => $document], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json(["status" => false, "message" => 'Document not found']);
        }

        return response()->json(["status" => true, "message" => $document]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(["status" => false, "message" => "Document not found"], 404);
        }

        $imageFullPath = "";
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension(); // Создаем имя для картинки
            $imagePath = $request->image->move('uploads', $imageName); // Создаем путь для картинки
            $imageFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $imagePath); // Создали абсолютный путь для картинки
        }

        if ($request->hasFile('document')) {
            $documentSize = $request->document->getSize();
            $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
            $documentExtension = $request->document->getClientOriginalExtension();
            $documentName = $request->title . '.' . $documentExtension;
            $documentPath = $request->document->move('documents', $documentName); // Создаем путь для документа
            $documentFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath);
        }

        $document->update([
            "title" => $request->title,
            "filesize" => $documentSizeFull,
            "filetype" => $documentExtension,
            "image" => $imageFullPath,
            "document" => $documentFullPath,
        ]);

        return response()->json(["status" => true, "message" => "Document updated", 'document' => $document]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json(["status" => false, "message" => "Document not found"]);
        }

        $document->delete();

        return response()->json(["status" => true, "message" => "Document has be deleted"]);
    }

    public function documentCount()
    {
        $documentCount = Document::all()->count();
        if (!$documentCount) {
            return response()->json(0);
        }
        return response()->json($documentCount);
    }

}
