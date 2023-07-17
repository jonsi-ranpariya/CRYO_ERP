<?php

namespace App\Http\Controllers\Partymaster;

use App\Http\Controllers\Controller;
use App\Models\Partymaster\BillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = BillingTerm::all();

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (is_array($data['billingTerms']) and count($data['billingTerms']) > 0) {
            BillingTerm::deleteData(['partyId' => $data['partyId']]);

            foreach ($data['billingTerms'] as $billingTerm) {
                unset($billingTerm['_id']);
                $billingTerm['billing'] = $data['billing'];
                $billingTerm['partyId'] = $data['partyId'];
                BillingTerm::saveData($billingTerm);
            }
        }else{
            BillingTerm::saveData($data);
        }

        $res['status'] = 200;
        $res['message'] = 'Data Saved';
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $fetchData = BillingTerm::getDataFromId($id);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
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
        $data = $request->all();
        $response = BillingTerm::updateData($id, $data);

        $res['status'] = 200;
        $res['message'] = 'Data Updated';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BillingTerm::destroy($id);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPartyWiseBillingTerm($id)
    {
        $fetchData = collect(BillingTerm::getData(['partyId' => $id]));

        $fetchData->map(function ($item){
            $item->calculateAmount = $item->calculateAmount ?? 0;
        });

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }
}
