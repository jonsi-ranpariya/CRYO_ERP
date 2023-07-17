<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\ProformaInvoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProformaInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ProformaInvoice::all();

        $data['message'] = "Proforma Invoice Found";
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
        $latest = ProformaInvoice::query()->latest()->first();
        $CurrentYear = date('y');
        if (! $latest) {
            $EnqNo = $CurrentYear."00001";
        }else{
            $string = preg_replace("/[^0-9\.]/", '', $latest->pInvoiceNo);
            $EnqNo = sprintf('%05d', $string+1);
        }
        $dataInsert['pInvoiceNo'] = $EnqNo;
        $party_master = ProformaInvoice::saveData($dataInsert);

        $data['message'] = "Proforma Invoice Saved";
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
        $response = ProformaInvoice::getDataFromId($id);

        $data['message'] = "Proforma Invoice found";
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

        $response = ProformaInvoice::updateData($id,$updateData);

        $data['message'] = "Proforma Invoice Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return jsonResponse
     */
    public function destroy($id)
    {
        ProformaInvoice::destroy($id);

        $data['message'] = "Proforma Invoice Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }
}
