<?php

namespace App\Http\Controllers\Despatch;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoiceTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewChallanInvoiceTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = NewChallanInvoiceTermCondition::all();
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
        $response = NewChallanInvoiceTermCondition::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  NewChallanInvoiceTermCondition  $newChallanInvoiceTermCondition
     * @return JsonResponse
     */
    public function show(NewChallanInvoiceTermCondition $newChallanInvoiceTermCondition)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $newChallanInvoiceTermCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  NewChallanInvoiceTermCondition  $newChallanInvoiceTermCondition
     * @return JsonResponse
     */
    public function update(Request $request, NewChallanInvoiceTermCondition $newChallanInvoiceTermCondition)
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoiceTermCondition->updateData($dataUpdate['_id'],$dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param NewChallanInvoiceTermCondition $newChallanInvoiceTermCondition
     * @return JsonResponse
     */
    public function destroy($id, NewChallanInvoiceTermCondition $newChallanInvoiceTermCondition)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $newChallanInvoiceTermCondition->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getTermAndCondition($id)
    {
        $response = NewChallanInvoiceTermCondition::getData(['challanInvoiceId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
