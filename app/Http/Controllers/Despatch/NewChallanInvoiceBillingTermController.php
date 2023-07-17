<?php

namespace App\Http\Controllers\Despatch;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class NewChallanInvoiceBillingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = NewChallanInvoiceBillingTerm::all();

        return jsonData($data);
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
        $response = NewChallanInvoiceBillingTerm::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  NewChallanInvoiceBillingTerm  $newChallanInvoiceBillingTerm
     * @return JsonResponse
     */
    public function show(NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $newChallanInvoiceBillingTerm;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  NewChallanInvoiceBillingTerm  $newChallanInvoiceBillingTerm
     * @return JsonResponse
     */
    public function update(Request $request, NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm)
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoiceBillingTerm->updateData($dataUpdate['_id'],$dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm
     * @return JsonResponse
     */
    public function destroy($id, NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm)
    {
        $response = $newChallanInvoiceBillingTerm->destroyData($id);
        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm
     * @return JsonResponse
     */
    public function getBillingTerm($id, NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm): JsonResponse
    {
        $response = $newChallanInvoiceBillingTerm->query()
            ->where(['challanInvoiceId' => $id])
            ->oldest('srNo')
            ->get();


        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm
     * @return JsonResponse
     */
    public function deleteBillingTerm($id, NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm): JsonResponse
    {
        $response = $newChallanInvoiceBillingTerm->deleteData(['challanInvoiceId' => $id]);

        $data['message'] = 'Data deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function bulkInsertChallanBillingTerm(Request $request, NewChallanInvoiceBillingTerm $newChallanInvoiceBillingTerm): JsonResponse
    {
        $billingTerm = collect($request->billingTerm);

        $response = false;
        if ($billingTerm->count() > 0) {
            $items = $billingTerm->map(callback: function ($item) {
                $item['created_at'] = new UTCDateTime(now()->format('Uv'));
                $item['addedFrom'] = auth()->id();
                return $item;
            });

            $response = $newChallanInvoiceBillingTerm
                ->query()
                ->insert($items->toArray());
        }

        $data['message'] = $response ? 'Data Saved' : 'Data Not Saved';
        $data['data'] = $response;
        return jsonData($data);
    }
}
