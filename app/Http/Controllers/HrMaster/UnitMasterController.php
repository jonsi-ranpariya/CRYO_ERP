<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\UnitMaster;
use Illuminate\Http\Request;

class UnitMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return UnitMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitMaster  $unitMaster
     * @param Request  $request
     * @return null|object
     */
    public function store(UnitMaster $unitMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $unitMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param UnitMaster  $unitMaster
     * @return null|object
     */
    public function show(UnitMaster $unitMaster)
    {
        return $unitMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param UnitMaster  $unitMaster
     * @return null|object
     */
    public function update(Request $request, UnitMaster $unitMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $unitMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UnitMaster  $unitMaster
     * @return null|object
     */
    public function destroy(UnitMaster $unitMaster): bool
    {
        return $unitMaster->delete();
    }

    public function getUnitMaster()
    {
        $fetchData = UnitMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->unit;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
