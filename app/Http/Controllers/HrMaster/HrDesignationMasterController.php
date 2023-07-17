<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\HrDesignationMaster;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;

class HrDesignationMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return HrDesignationMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @param HrDesignationMaster  $hrDesignationMaster
     * @return null|object
     */
    public function store(HrDesignationMaster $hrDesignationMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $hrDesignationMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param HrDesignationMaster  $hrDesignationMaster
     * @return null|object
     */
    public function show(HrDesignationMaster $hrDesignationMaster)
    {
        return $hrDesignationMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param HrDesignationMaster  $hrDesignationMaster
     * @return null|object
     */
    public function update(Request $request, HrDesignationMaster $hrDesignationMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $hrDesignationMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HrDesignationMaster  $hrDesignationMaster
     * @return null|object
     */
    public function destroy(HrDesignationMaster $hrDesignationMaster): bool
    {
        return $hrDesignationMaster->delete();
    }

    public function getHrDesignationMaster()
    {
        $fetchData = HrDesignationMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->designation;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
