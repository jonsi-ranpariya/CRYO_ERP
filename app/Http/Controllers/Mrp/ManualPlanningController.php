<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\MRP\MrpIndent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManualPlanningController extends Controller
{
    /**
     * @param $mrpIndent
     * @return string
     */
    public function generateIndentNumber($mrpIndent)
    {
        $latest = $mrpIndent->query()->latest()->first();

        if (!$latest) {
            $newNumber = 'I00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->indentNo);
            $newNumber = 'I' . sprintf('%05d', $string + 1);
        }

        return $newNumber;
    }

    /**
     * Display a listing of the resource.
     *
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function index(MrpIndent $mrpIndent)
    {
        $response = $mrpIndent->getData(['indentCreatedMenuId' => 4]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function store(Request $request, MrpIndent $mrpIndent)
    {
        $dataInsert = $request->all();
        $dataInsert['indentNo'] = $this->generateIndentNumber($mrpIndent);
        $response = $mrpIndent->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function show($id, MrpIndent $mrpIndent)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $mrpIndent->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function update($id, Request $request, MrpIndent $mrpIndent)
    {
        $dataUpdate = $request->all();
        $response = $mrpIndent->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function destroy($id, MrpIndent $mrpIndent)
    {
        try {
            $response = $mrpIndent->destroyData($id);

            $data['message'] = 'Data Deleted';
            $data['data'] = $response;
            return jsonData($data);

        } catch (\Exception $exception) {

            $data['message'] = $exception->getMessage();
            $data['data'] = null;
            return jsonData($data);
        }
    }
}
