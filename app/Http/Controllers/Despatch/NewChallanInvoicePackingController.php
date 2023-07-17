<?php

namespace App\Http\Controllers\Despatch;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoicePacking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewChallanInvoicePackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = NewChallanInvoicePacking::all();

        $data['data'] = $response;
        $data['message'] = 'Data Found';
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
        $response = NewChallanInvoicePacking::saveData($dataInsert);

        $data['data'] = $response;
        $data['message'] = 'Data Saved';
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param NewChallanInvoicePacking $newChallanInvoicePacking
     * @return JsonResponse
     */
    public function show(NewChallanInvoicePacking $newChallanInvoicePacking)
    {
        $data['data'] = $newChallanInvoicePacking;
        $data['message'] = 'Data Found';
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NewChallanInvoicePacking $newChallanInvoicePacking
     * @return JsonResponse
     */
    public function update(Request $request, NewChallanInvoicePacking $newChallanInvoicePacking)
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoicePacking->updateData($newChallanInvoicePacking['_id'], $dataUpdate);

        $data['data'] = $response;
        $data['message'] = 'Data Update';
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NewChallanInvoicePacking $newChallanInvoicePacking
     * @return JsonResponse
     */
    public function destroy(NewChallanInvoicePacking $newChallanInvoicePacking)
    {
        $response = $newChallanInvoicePacking->delete();

        $data['data'] = $response;
        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getNewChallanInvoicePackingList($id)
    {
        $response = NewChallanInvoicePacking::getData(['challanInvoiceId' => $id]);

        $data['data'] = $response;
        $data['message'] = 'Data Found';
        return jsonData($data);
    }
}
