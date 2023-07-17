<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\BudgetMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BudgetMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = BudgetMaster::getData(['addedFrom' => auth()->id()]);

        foreach ($fetchData as $key => $value) {
            $fetchData[$key]['accountGroup'] = $value->accountGroup['label'];
        }

        $data['message'] = "Budget Master List";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $dataInsert['year'] = date('Y');

        $budgetCount = BudgetMaster::getCount([
            'accountGroup' => $dataInsert['accountGroup'],
            'year' => $dataInsert['year'],
            'addedFrom' => auth()->id()
        ]);

        if ($budgetCount === 0) {
            $response = BudgetMaster::saveData($dataInsert);
            $data['message'] = "Budget Added Successfully";
            $data['status'] = 200;
            $data['data'] = $response;
        } else {
            $data['message'] = "Budget Already Exist";
            $data['status'] = 400;
            $data['data'] = [];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = BudgetMaster::find($id);

        $data['message'] = "Budget Master Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $dataInsert = $request->all();
        unset($dataInsert['id']);
        $updateData = BudgetMaster::updateData($id, $dataInsert);

        $data['message'] = "Budget Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BudgetMaster::destroy($id);

        $data['message'] = "Budget Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
