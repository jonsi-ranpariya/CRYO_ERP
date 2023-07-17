<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\ChequePrintingFormatMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChequePrintingFormatMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ChequePrintingFormatMaster::all();

        $data['message'] = "Cheque Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $party_master = ChequePrintingFormatMaster::saveData($dataInsert);

        $data['message'] = "Cheque Master Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = ChequePrintingFormatMaster::getDataFromId($id);

        $data['message'] = "Cheque Master found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = ChequePrintingFormatMaster::updateData($id, $request->all());

        $data['message'] = "Cheque Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ChequePrintingFormatMaster::destroyData($id);

        $data['message'] = "Cheque Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getChequePrintFormatList()
    {
        $formats = ChequePrintingFormatMaster::all();
        foreach ($formats as $key => $format) {
            $response[$key]['label'] = $format->formatName;
            $response[$key]['value'] = $format->_id;
        }
        $data['message'] = "Cheque Master Deleted";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }
}
