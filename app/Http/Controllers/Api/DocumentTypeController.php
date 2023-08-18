<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use PDF;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $documentTypes = DocumentType::all();

        return response()->json($documentTypes);
    }

    public function show($id, DocumentType $documentType)
    {
        $document = DocumentType::find($id);
        return response()->json($document);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'document_type' => 'required|string',
            'columns_and_fields' => 'required|array',
        ]);

        $data['version'] = '1';
        $data['columns_and_fields'] = json_encode($data['columns_and_fields']);

        $documentType = DocumentType::create($data);

        return response()->json($documentType, 201);
    }

    public function update(Request $request, $id, DocumentType $documentType)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'document_type' => 'required|string',
            'columns_and_fields' => 'required|array',
        ]);
        $document = DocumentType::find($id);
        if(!$document){
            return response()->json([
                'message' => 'Document Type not found'
            ], 404);
        }
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'document_type' => $request->document_type,
            'columns_and_fields' =>  json_encode($request->columns_and_fields),
        ];

        $document->update($data);

        return response()->json($document);
    }

    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();

        return response()->json(null, 204);
    }

    public function downloadPdf($id)
    {
        $document = DocumentType::find($id);
        if(!$document){
            return response()->json([
                'message' => 'Document Type not found'
            ], 404);
        }
        $data['name'] = $document->name;
        $data['description'] = $document->description;
        $data['columns_and_fields'] = $document->columns_and_fields;

        $pdf = PDF::loadView('document_template', ['data' => $data]);

        return $pdf->stream('document_' . Date('YmdHis') . '.pdf');
    }

}
