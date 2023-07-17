<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use App\Models\Bom\DrawingDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DrawingDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = DrawingDocuments::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['documentItem'] = $request->file('documentItem')->storePublicly('/public/drawing-master-document/');
        $response = DrawingDocuments::saveData($data);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = DrawingDocuments::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        dd($data);

        return jsonData([]);
    }

    /**
     * Remove the specified resource from storage.
     * -> DrawingDocumentObserver <- is use here for remove Real Item From storage
     * -> DrawingDocumentObserver <- This observer register in App\providers\EventServiceProvider
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        DrawingDocuments::destroyData($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        return jsonData($data);
    }

    public function getDocumentData($id)
    {
        $fetchData = DrawingDocuments::getData(['drawingId' => $id]);

        foreach ($fetchData as $key => $value) {
            $response[$key] = $value;
            $response[$key]['documentItem'] = Storage::url($value->documentItem);
        }

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }
}
