<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BomVersionProcess;
use App\Models\ProductionPlanning\ProcessSheetList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BomVersionProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = BomVersionProcess::all();

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = BomVersionProcess::saveData($request->all());

        $res['status'] = 200;
        $res['message'] = 'Data Saved';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = BomVersionProcess::getDataFromId($id);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = BomVersionProcess::updateData($id, $request->all());

        $res['status'] = 200;
        $res['message'] = 'Data Updated';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BomVersionProcess::destroyData($id);

        $res['status'] = 200;
        $res['message'] = 'Data Deleted';
        $res['data'] = [];
        return jsonData($res);
    }

    public function getBomVersionProcessData($bomId, $versionId)
    {
        $data = BomVersionProcess::getData([
            'bomId' => $bomId,
            'versionId' => $versionId
        ]);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * @param string $bomId
     * @return JsonResponse
     */
    public function getBomItemWiseProcessList(string $bomId)
    {
        $bom = BillOfMaterial::find($bomId)->setAppends(['item_name']);
        $processSheets = ProcessSheetList::query()->where('processItemId',$bom->itemCode)->get();

        foreach ($processSheets as $key => $processSheet) {
            $response[$key]['label'] = $processSheet->process_details->processSheetNo.' - '.$processSheet->processDesc;
            $response[$key]['value'] = $processSheet->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }
}
