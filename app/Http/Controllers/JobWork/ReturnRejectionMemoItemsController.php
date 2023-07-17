<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\ReturnRejectionMemoItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReturnRejectionMemoItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = ReturnRejectionMemoItems::all();
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
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
        $response = ReturnRejectionMemoItems::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = ReturnRejectionMemoItems::getDataFromId($id);

        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param ReturnRejectionMemoItems $returnRejectionMemoItems
     * @return JsonResponse
     */
    public function update($id, Request $request, ReturnRejectionMemoItems $returnRejectionMemoItems)
    {
        $dataUpdate = $request->all();
        $response = $returnRejectionMemoItems->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param ReturnRejectionMemoItems $returnRejectionMemoItems
     * @return JsonResponse
     */
    public function destroy($id, ReturnRejectionMemoItems $returnRejectionMemoItems)
    {
        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = $returnRejectionMemoItems->destroyData($id);
        return jsonData($data);
    }


    /**
    /**
     * @param $id
     * @return JsonResponse
     */
    public function getRejectionMemoItem($id)
    {
        $response = ReturnRejectionMemoItems::getData(['memoId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
