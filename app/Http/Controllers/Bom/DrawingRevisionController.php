<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use App\Models\Bom\DrawingRevision;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DrawingRevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = DrawingRevision::all();

        $data['message'] = "Drawing Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $party_master = DrawingRevision::saveData($dataInsert);

        $data['message'] = "Drawing Master Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = DrawingRevision::getDataFromId($id);

        $data['message'] = "Drawing Master found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->all();

        $response = DrawingRevision::updateData($id,$updateData);

        $data['message'] = "Drawing Master Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        DrawingRevision::destroy($id);

        $data['message'] = "Drawing Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDrawingRevision($id)
    {
        $partyData = DrawingRevision::getData(['drawingId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
