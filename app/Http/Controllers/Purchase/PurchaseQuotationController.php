<?php

namespace App\Http\Controllers\Purchase;

use App\Actions\Purchase\PurchaseQuotationAddMultipleItemAction;
use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Purchase\PurchaseQuotation;
use App\Models\Purchase\PurchaseQuotationBillingTerm;
use App\Models\Purchase\PurchaseQuotationItems;
use App\Models\Purchase\PurchaseQuotationTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseQuotation::all();
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
        $itemIds = $dataInsert['itemIds'];

        $dataInsert['purchaseQtnNo'] = generateCodes(new PurchaseQuotation, 'PQ22230001', 'purchaseQtnNo', 'PQ');
        $response = PurchaseQuotation::saveData($dataInsert);
        PurchaseQuotationAddMultipleItemAction::run($response->_id, $itemIds);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function show(PurchaseQuotation $purchaseQuotation)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseQuotation;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseQuotation $purchaseQuotation)
    {
        $dataUpdate = $request->all();
        $response = $purchaseQuotation->updateData($purchaseQuotation->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function destroy(PurchaseQuotation $purchaseQuotation)
    {
        PurchaseQuotationItems::deleteData(['purchaseQuotationId' => $purchaseQuotation->_id]);
        PurchaseQuotationBillingTerm::deleteData(['purchaseQuotationId' => $purchaseQuotation->_id]);
        PurchaseQuotationTermCondition::deleteData(['purchaseQuotationId' => $purchaseQuotation->_id]);
        $response = $purchaseQuotation->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function getVendorOptions(PurchaseQuotation $purchaseQuotation)
    {
        $fetchData = $purchaseQuotation->all();

        foreach ($fetchData as $key => $quotation) {
            $response[$key]['label'] = '(' . $quotation->party_details->partyCode . ') - ' . $quotation->vendorDetails['vendorName'];
            $response[$key]['value'] = $quotation->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function getQuotationNumber(PurchaseQuotation $purchaseQuotation)
    {
        $fetchData = $purchaseQuotation->all();
        //$quotation->purchaseQtnNo .' - '.
        foreach ($fetchData as $key => $quotation) {
        $response[$key]['label'] = $quotation->vendorQtnNo;
        $response[$key]['value'] = $quotation->_id;
    }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param PurchaseQuotation $purchaseQuotation
     * @return JsonResponse
     */
    public function getPqRefernceNumber(PurchaseQuotation $purchaseQuotation)
    {
        $fetchData = $purchaseQuotation->all();

        foreach ($fetchData as $key => $quotation) {
            $response[$key]['label'] = $quotation->referenceNumber;
            $response[$key]['value'] = $quotation->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getReferenceNoByParty(string $poVendorId)
    {
        $data = PurchaseQuotation::query()->where('vendorDetails.vendorCode', $poVendorId)->get();
        foreach ($data as $key => $quotation) {
            $response[$key]['label'] = $quotation->referenceNumber;
            $response[$key]['value'] = $quotation->_id;
        }

        $data['data'] = array_values($response ?? []);
        $data['message'] = 'Data found';
        return jsonData($data);
    }

}
