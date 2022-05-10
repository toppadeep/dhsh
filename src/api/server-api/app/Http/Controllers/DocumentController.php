<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();
        $documents = DocumentResource::collection($documents);
        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {

        if($request->file('document')) {
            foreach ($request->file('document') as $file) {
                $documentSize =  $file->getSize();
                $documentSizeFull = round(($documentSize / 1024) / 1024,2) . ' ' . 'mb';
                $documentExtension = $file->getClientOriginalExtension();
                $documentName =  $file->getClientOriginalName();
                $documentPath = $file->move('document', $documentName); // Создаем путь для документа
                $document = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath);
                Document::create([
                    "title" => $documentName,
                    "filesize" => $documentSizeFull,
                    "filetype" =>  $documentExtension,
                    "document" => $document,
                    "category" => $request->category,
                ]);
            }
        }

        return response()->json(["status" => true, "message" => 'Документ успешно добавлен']);
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

        if ($request->hasFile('document')) {
            $documentSize = $request->file('document')->getSize();
            $documentSizeFull = round($documentSize,1) . ' ' . 'mb';
            $documentExtension = $request->file('document')->getClientOriginalExtension();
            $documentName =  $request->file('document')->getClientOriginalName() . '.' . $documentExtension;
            $documentPath = $request->document->move('documents', $documentName); // Создаем путь для документа
            $documentFullPath = 'http://' . $request->getHost() . ':' . $request->getPort() . '/' . str_replace('\\', '/', $documentPath);
        }

        $document->update([
            "title" => $documentName,
            "filesize" => $documentSizeFull,
            "filetype" => $documentExtension,
            "document" => $documentFullPath,
        ]);

        return response()->json(["status" => true, "message" => $document]);
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

        return response()->json(["status" => true, "message" => "Документ удалён"]);
    }
}
