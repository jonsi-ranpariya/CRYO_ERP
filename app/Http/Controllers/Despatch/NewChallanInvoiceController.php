<?php

namespace App\Http\Controllers\Despatch;

use App\Actions\Dispatch\NewChallanInvoiceInsertAction;
use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\Despatch\NewChallanInvoiceTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewChallanInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = NewChallanInvoice::all();

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
    public function store(Request $request): JsonResponse
    {
        $response = NewChallanInvoiceInsertAction::run($request);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param NewChallanInvoice $newChallanInvoice
     * @return JsonResponse
     */
    public function show($id, NewChallanInvoice $newChallanInvoice): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $newChallanInvoice->getFindRelationData($id, ['masterGstDetails' => function ($q) {
            $q->latest();
            $q->first();
        }, 'itemsDetail', 'billingTerms']);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NewChallanInvoice $newChallanInvoice
     * @return JsonResponse
     */
    public function update(Request $request, NewChallanInvoice $newChallanInvoice): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoice->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param NewChallanInvoice $newChallanInvoice
     * @return JsonResponse
     */
    public function destroy($id, NewChallanInvoice $newChallanInvoice): JsonResponse
    {
        $response = $newChallanInvoice->destroyData($id);
        NewChallanInvoiceItems::deleteData(['challanInvoiceId' => $id]);
        NewChallanInvoiceBillingTerm::deleteData(['challanInvoiceId' => $id]);
        NewChallanInvoiceTermCondition::deleteData(['challanInvoiceId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getInvoiceFromParty(string $id): JsonResponse
    {
        $invoices = NewChallanInvoice::getData(['SellToParty' => $id]);

        foreach ($invoices as $key => $invoice) {
            $response[$key]['label'] = "($invoice->invoiceNo) - $invoice->sellToDescription";
            $response[$key]['value'] = $invoice->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getAllInvoiceList(): JsonResponse
    {
        $response = NewChallanInvoice::all(['_id', 'SellToParty', 'invoiceNo', 'invoice', 'orderNo', 'invoiceNo', 'invoiceDate']);

        $data['message'] = 'Data Found';
        $data['data'] = $response->each(function ($item) {
            if (!empty($item)) {
                $item->setAppends(['sell_to_party_details']);
            }
        });
        return jsonData($data);
    }
}
