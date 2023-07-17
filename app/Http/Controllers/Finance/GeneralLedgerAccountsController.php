<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\GeneralLedgerAccountsMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralLedgerAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = GeneralLedgerAccountsMaster::all();

        $data['message'] = "General Ledger Accounts Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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
        $ledgerData = GeneralLedgerAccountsMaster::saveData($dataInsert);
        $data['message'] = "Ledger Master Saved";
        $data['status'] = 200;
        $data['data'] = $ledgerData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = GeneralLedgerAccountsMaster::getDataFromId($id);

        $data['message'] = "General Ledger Account Master Master found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = GeneralLedgerAccountsMaster::updateData($id, $dataInsert);

        $data['message'] = "General Ledger Accounts Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        GeneralLedgerAccountsMaster::destroyData($id);

        $data['message'] = "General Ledger Accounts Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getAccountLedgerOptions()
    {
        $fetchData = GeneralLedgerAccountsMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->accountName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "General Ledger Accounts Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }
}
