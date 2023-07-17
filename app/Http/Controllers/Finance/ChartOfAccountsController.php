<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\ChartOfAccountsMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChartOfAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ChartOfAccountsMaster::all();

        $data['message'] = "Chart Of Accounts Found";
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
        $dataInsert['groupCode'] = generateGroupCode($dataInsert, new ChartOfAccountsMaster);
        $party_master = ChartOfAccountsMaster::saveData($dataInsert);

        $data['message'] = "Chart Of Accounts Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
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
        $response = ChartOfAccountsMaster::getDataFromId($id);

        $data['message'] = "Chart Of Accounts found";
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
        $updateData = ChartOfAccountsMaster::updateData($id, $request->all());

        $data['message'] = "Chart Of Accounts Updated";
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
        ChartOfAccountsMaster::destroy($id);

        $data['message'] = "Chart Of Accounts Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    public function getAllChartOfAccountsMode()
    {
        $fetchData = ChartOfAccountsMaster::query()
            ->where([
                'companyId' => 1,
                'addedFrom' => auth()->id()
            ])
            ->whereNull('parentGroupId')
            ->orderBy('groupName', 'ASC')
            ->get();

        $response = createTree($fetchData, new ChartOfAccountsMaster);
        $data['message'] = "Chart Of Accounts Master Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllSubChartAccount(Request $request)
    {
        $fetchData = ChartOfAccountsMaster::getData([
            'companyId' => 1,
            'parentGroupId' => $request->parent_group_id
        ]);

        $data['message'] = "Chart Of Accounts Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllChartOfAccounts()
    {
        $accounts = ChartOfAccountsMaster::all();

        foreach ($accounts as $key => $account) {
            $response[$key]['label'] = $account->groupName;
            $response[$key]['value'] = $account->_id;
        }

        $data['message'] = "Accounts Master List Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }
}
