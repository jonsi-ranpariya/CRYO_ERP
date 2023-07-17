<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\ReturnRejectionMemo;
use App\Models\JobWork\ReturnRejectionMemoItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReturnRejectionMemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = ReturnRejectionMemo::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ReturnRejectionMemo $returnRejectionMemo
     * @return JsonResponse
     */
    public function store(Request $request, ReturnRejectionMemo $returnRejectionMemo)
    {
        $dataInsert = $request->all();
        $dataInsert['jobWorkReturnNo'] = generateCodes(new ReturnRejectionMemo(), 'R00001','jobWorkReturnNo', 'R');
        $response = $returnRejectionMemo->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ReturnRejectionMemo  $returnRejectionMemo
     * @return JsonResponse
     */
    public function show(ReturnRejectionMemo $returnRejectionMemo)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $returnRejectionMemo;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ReturnRejectionMemo $returnRejectionMemo
     * @return JsonResponse
     */
    public function update(Request $request, ReturnRejectionMemo $returnRejectionMemo)
    {
        $dataUpdated = $request->all();
        $response = $returnRejectionMemo->updateData($returnRejectionMemo->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ReturnRejectionMemo::destroyData($id);
        ReturnRejectionMemoItems::deleteData(['memoId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

}
