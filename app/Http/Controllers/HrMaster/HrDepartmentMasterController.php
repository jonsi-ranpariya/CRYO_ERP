<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\HrDepartmentMaster;
use Illuminate\Http\Request;

class HrDepartmentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return HrDepartmentMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @param HrDepartmentMaster  $hrDepartmentMaster
     * @return null|object
     */
    public function store(HrDepartmentMaster $hrDepartmentMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $hrDepartmentMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param HrDepartmentMaster  $hrDepartmentMaster
     * @return null|object
     */
    public function show(HrDepartmentMaster $hrDepartmentMaster)
    {
        return $hrDepartmentMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  HrDepartmentMaster  $hrDepartmentMaster
     * @return null|object
     */
    public function update(Request $request, HrDepartmentMaster $hrDepartmentMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $hrDepartmentMaster->updateData($dataUpdate['_id'],$dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HrDepartmentMaster  $hrDepartmentMaster
     * @return null|object
     */
    public function destroy(HrDepartmentMaster $hrDepartmentMaster): bool
    {
        return $hrDepartmentMaster->delete();
    }

    public function getHrDepartmentMaster()
    {
        $fetchData = HrDepartmentMaster::all();

        foreach($fetchData as $key => $value) {
            $response[$key]['label'] = $value->department;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
