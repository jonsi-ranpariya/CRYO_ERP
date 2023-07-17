<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\HrBranchMaster;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;

class HrBranchMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index() : object
    {
        return HrBranchMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @param HrBranchMaster  $hrBranchMaster
     * @return null|object
     */
    public function store(HrBranchMaster $hrBranchMaster, Request $request) : ?object
    {
        $dataInsert = $request->all();
        return $hrBranchMaster->saveData($dataInsert);

    }

    /**
     * Display the specified resource.
     *
     * @param HrBranchMaster  $hrBranchMaster
     * @return null|object
     */
    public function show(HrBranchMaster $hrBranchMaster)
    {
        return $hrBranchMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  HrBranchMaster  $hrBranchMaster
     * @return null|object
     */
    public function update(Request $request, HrBranchMaster $hrBranchMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $hrBranchMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HrBranchMaster  $hrBranchMaster
     * @return null|object
     */
    public function destroy(HrBranchMaster $hrBranchMaster): bool
    {
        return $hrBranchMaster->delete();
    }

    public function getHrBranchMaster()
    {
        $fetchData = HrBranchMaster::all();

        foreach($fetchData as $key => $value){
            $response[$key]['label'] = $value->branch;
            $response[$key]['value'] = $value->_id;
        }
        return $response ?? [];
    }
}
