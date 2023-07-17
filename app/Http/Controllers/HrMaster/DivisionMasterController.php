<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\DivisionMaster;
use Illuminate\Http\Request;

class DivisionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return DivisionMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DivisionMaster  $divisionMaster
     * @param Request  $request
     * @return null|object
     */
    public function store(DivisionMaster $divisionMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $divisionMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param DivisionMaster  $divisionMaster
     * @return null|object
     */
    public function show(DivisionMaster $divisionMaster)
    {
        return $divisionMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param DivisionMaster  $divisionMaster
     * @return null|object
     */
    public function update(Request $request, DivisionMaster $divisionMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $divisionMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DivisionMaster  $divisionMaster
     * @return null|object
     */
    public function destroy(DivisionMaster $divisionMaster):bool
    {
        return $divisionMaster->delete();
    }

    public function getDivisionMaster()
    {

        $fetchData = DivisionMaster::all();

        foreach($fetchData as $key => $value) {
            $response[$key]['label'] = $value->division;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
