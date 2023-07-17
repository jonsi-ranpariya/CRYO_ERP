<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesEnquiry;
use App\Models\SalesCrm\SalesHistory;
use App\Models\SalesCrm\SalesItemDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SalesEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = SalesEnquiry::all();
        //$fetchData = SalesEnquiry::with(['city','state','country'])->get();

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
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $latest = SalesEnquiry::latest()->first();
        $EnqNo = '';
        if (!$latest) {
            $EnqNo = 'E00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->enquiryNo);
            $EnqNo = 'E' . sprintf('%05d', $string + 1);
        }
        $dataInsert['enquiryNo'] = $EnqNo;
        $party_master = SalesEnquiry::saveData($dataInsert);
        $data['message'] = "Sales Enquiry Saved";
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
        $response = SalesEnquiry::getDataFromId($id);

        $data['message'] = "Sales Enquiry found";
        $data['status'] = 200;
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
        $updateData = $request->all();

        if (isset($updateData['isConfirmationTab']) && $updateData['isConfirmationTab'] === true) {
            $fetchData = SalesEnquiry::getDataFromId($id, true);
            $fetchData['confirmationData'] = $updateData;
            $updateData = $fetchData;
        }

        if (isset($updateData['isLetterTab']) && $updateData['isLetterTab'] === true) {
            $fetchData = SalesEnquiry::getDataFromId($id, true);
            $fetchData['letterData'] = $updateData;
            $updateData = $fetchData;
        }

        $response = SalesEnquiry::updateData($id, $updateData);

        $data['message'] = "Sales Enquiry Updated";
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
        SalesEnquiry::destroy($id);
        SalesItemDetails::deleteData(['salesIqID' => $id]);
        SalesHistory::deleteData(['salesIqID' => $id]);

        $data['message'] = "Sales Enquiry Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getInquiryOptions()
    {
        $fetchData = SalesEnquiry::getData();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->enquiryNo . ' - ' . $value->customerName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Sales Enquiry Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getInquiryWithItems($id)
    {
        $fetchData = SalesEnquiry::getFindRelationData($id, [
            'city:_id,city',
            'state:_id,state',
            'country:_id,country',
            'kindAttnDetails:_id,personName,mobileNo,email',
            'partyDetails:_id,partyCurrencyType'
        ]);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInquiryWithFilter(Request $request)
    {

        $postData = $request->all();

        $myfilter = [];

        if(!empty($postData)){

            foreach($postData as $key => $value){

                if (!empty($value)){

                    $myfilter[$key] = $value;

                }

            }
        }


        $fetchData = SalesEnquiry::getData($myfilter);

        $data['message'] = "Sales Enquiry Found";
        $data['status'] = 200;
        //$data['totalRecords'] = 3;
        $data['data'] = $fetchData;
        return jsonData($data);

    }


    /**
     * @param SalesEnquiry $salesEnquiry
     * @return JsonResponse
     */
    public function getSalesEnquiryItemList(SalesEnquiry $salesEnquiry): JsonResponse
    {
        $response = $salesEnquiry->getData(['loginData.stage' => 'Approved']);
        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
