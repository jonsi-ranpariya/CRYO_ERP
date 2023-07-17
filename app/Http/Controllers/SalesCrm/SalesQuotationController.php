<?php

namespace App\Http\Controllers\SalesCrm;

use App\Actions\Sales\SalesQuotationItemAction;
use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesQuotation;
use App\Models\SalesCrm\SalesQuotationBillingTerms;
use App\Models\SalesCrm\SalesQuotationItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SalesQuotation $salesQuotation
     * @return JsonResponse
     */
    public function index(SalesQuotation $salesQuotation)
    {
        $fetchData = $salesQuotation->getRelationData([], ['createdBy:_id,first_name,last_name']);

        $data['message'] = "Sales Enquiry Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param SalesQuotation $salesQuotation
     * @param SalesQuotationItemAction $quotationAction
     * @return JsonResponse
     */
    public function store(Request $request, SalesQuotation $salesQuotation, SalesQuotationItemAction $quotationAction)
    {
        $dataInsert = $request->all();

        $itemDetailsData = $dataInsert['itemDetailsData'];
        $billingTermsData = $dataInsert['billingTermsData'];

        $dataInsert['quotationNo'] = generateCodes(new SalesQuotation(), 'Q00001', 'quotationNo','Q');
        $party_master = $salesQuotation->saveData($dataInsert);

        $insertedId = $party_master->_id;
        $quotationAction->createQuotationItems($insertedId, $itemDetailsData);
        $quotationAction->createBillingTermsData($insertedId, $billingTermsData, new SalesQuotationBillingTerms);

        $data['message'] = "Sales Quotation Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
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
        $response = SalesQuotation::getFindRelationData($id,
            [
                'createdBy:_id,first_name,last_name',
                'updatedBy:_id,first_name,last_name'
            ]
        );

        $data['message'] = "Sales Quotation found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param SalesQuotationItemAction $salesQuotationItemAction
     * @return JsonResponse
     */
    public function update(Request $request, $id, SalesQuotationItemAction $salesQuotationItemAction)
    {
        $updateData = $request->all();

        $response = SalesQuotation::updateData($id, $updateData);

        if (isset($updateData['item_details'])) {
            $itemDetails = $updateData['item_details'];
            unset($updateData['item_details']);
            $salesQuotationItemAction->updateQuotationItems($id, $itemDetails);
        }

        if (isset($updateData['billing_terms'])) {
            $billingTerms = $updateData['billing_terms'];
            unset($updateData['billing_terms']);
            $salesQuotationItemAction->updateQuotationBillingTerms($id, $billingTerms);
        }

        $data['message'] = "Sales Quotation Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        SalesQuotation::destroy($id);
        SalesQuotationItemAction::make()->deleteSalesQuotationItems(new SalesQuotationItems, $id);
        SalesQuotationItemAction::make()->deleteSalesQuotationBillingTerms(new SalesQuotationBillingTerms, $id);

        $data['message'] = "Sales Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteSalesQuotationItem($id)
    {
        $item = SalesQuotationItems::query()->find($id);
        if ($item) {
            $item->delete();
        }
        $data['message'] = "Sales Item Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getApproveQuotationList()
    {
        $response = SalesQuotation::getData(
            ['quotationStatus' => 1],
            ['quotationNo', '_id', 'created_at', 'enquiryNo', 'status', 'sales']
        );

        $data['message'] = "Sales Quotation List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getApproveSalesQuotationList()
    {
        $response = SalesQuotation::getData(
            ['quotationStatus' => 1],
        );

        $data['message'] = "Sales Quotation List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getQuotationItemList(Request $request)
    {
        $response = SalesQuotationItems::whereInData('_id', $request->ids);

        $data['message'] = "Sales Quotation Items";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPartyQuotations($id)
    {
        $response = SalesQuotation::getData(
            ['partyId' => $id],
            ['quotationNo', 'quotationDate', 'enquiryNo', 'status', 'sales']
        );

        $data['message'] = "Sales Quotations Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getPendingQuotations(SalesQuotation $salesQuotation)
    {
        $fetchData = $salesQuotation->with(['createdBy:_id,first_name,last_name'])
            ->whereIn('loginData.stage', [1, 3])
            ->get();

        $data['message'] = "Sales Enquiry Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuotationWithFilter(Request $request)
    {

        $postData = $request->all();

        $myfilter = [];

        if(!empty($postData)){

            if(!empty($postData['partyId'])){

                $myfilter['partyId'] = $postData['partyId'];
            }

            if(!empty($postData['customerCity'])){

                $myfilter['customerDetailsData.cityId'] = $postData['customerCity'];
            }

            if(!empty($postData['customerState'])){

                $myfilter['customerDetailsData.stateId'] = $postData['customerState'];
            }

            if(!empty($postData['customerCountry'])){

                $myfilter['customerDetailsData.countryId'] = $postData['customerCountry'];
            }

            if(!empty($postData['branch'])){

                $myfilter['branch'] = $postData['branch'];
            }

            if(!empty($postData['sales'])){

                $myfilter['sales'] = $postData['sales'];
            }

            if(!empty($postData['salesType'])){

                $myfilter['salesType'] = $postData['salesType'];
            }

            if(!empty($postData['status'])){

                $myfilter['status'] = $postData['status'];
            }

            if(!empty($postData['addedFrom'])){

                $myfilter['addedFrom'] = $postData['addedFrom'];
            }

            if(!empty($postData['qtnType'])){

                $myfilter['qtnType'] = $postData['qtnType'];
            }

            if(!empty($postData['qtnStage'])){

                $myfilter['qtnStage'] = $postData['qtnStage'];
            }

            if(!empty($postData['stage'])){

                $myfilter['loginData.stage'] = $postData['stage'];
            }

            /*foreach($postData as $key => $value){

                if (!empty($value)){

                    $myfilter[$key] = $value;

                }

            }*/
        }


        $fetchData = SalesQuotation::getData($myfilter);

        $data['message'] = "Sales Enquiry Found";
        $data['status'] = 200;
        //$data['totalRecords'] = 3;
        $data['data'] = $fetchData;
        return jsonData($data);

    }
}
