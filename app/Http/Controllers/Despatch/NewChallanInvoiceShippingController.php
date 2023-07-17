<?php

namespace App\Http\Controllers\Despatch;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoiceShipping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewChallanInvoiceShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = NewChallanInvoiceShipping::all();

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
        $dataInsert = $request->all();
        $response = NewChallanInvoiceShipping::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param NewChallanInvoiceShipping $newChallanInvoiceShipping
     * @return JsonResponse
     */
    public function show(NewChallanInvoiceShipping $newChallanInvoiceShipping)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $newChallanInvoiceShipping;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NewChallanInvoiceShipping $newChallanInvoiceShipping
     * @return JsonResponse
     */
    public function update(Request $request, NewChallanInvoiceShipping $newChallanInvoiceShipping)
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoiceShipping->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NewChallanInvoiceShipping $newChallanInvoiceShipping
     * @return JsonResponse
     */
    public function destroy(NewChallanInvoiceShipping $newChallanInvoiceShipping)
    {
        $response = $newChallanInvoiceShipping->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getShippingList($id)
    {
        $response = NewChallanInvoiceShipping::getRelationData(['challanInvoiceId' => $id],
            ['itemDetails' => function ($query) {
                $query->select(['_id','itemCode']);
            }]
        );

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
