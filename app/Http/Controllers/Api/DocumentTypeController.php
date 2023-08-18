<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use PDF;
use App\Exceptions\DocumentTypeException;


class DocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $documentTypes = DocumentType::all();

            return response()->json($documentTypes);
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function show($id, DocumentType $documentType)
    {
        try {
            $document = DocumentType::find($id);
            if(empty($document)){
                throw new DocumentTypeException('Document Type not found');
            }
            return response()->json($document);
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'document_type' => 'required|string',
                'columns_and_fields' => 'required|array',
            ]);

            $data['version'] = '1';
            $data['columns_and_fields'] = json_encode($data['columns_and_fields']);

            $documentType = DocumentType::create($data);

            return response()->json([
                'message' => 'Document Type created successfully',
                'documentType' => $documentType
            ], 201);
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id, DocumentType $documentType)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'document_type' => 'required|string',
                'columns_and_fields' => 'required|array',
            ]);
            $document = DocumentType::find($id);
            if(!$document){
                throw new DocumentTypeException('Document Type not found');
            }
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'document_type' => $request->document_type,
                'columns_and_fields' =>  json_encode($request->columns_and_fields),
            ];

            $document->update($data);

            return response()->json([
                'message' => 'Document Type updated successfully',
                'documentType' => $document
            ], 200);
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id, DocumentType $documentType)
    {
        try {
            $document = DocumentType::find($id);
            if(!$document){
                throw new DocumentTypeException('Document Type not found');
            }
            $document->delete();

            return response()->json(null, 204);
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function downloadPdf($id)
    {
        try {
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
        }catch(DocumentTypeException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

}
