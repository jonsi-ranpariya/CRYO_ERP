<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\GradeMaster;
use App\Models\Master\MachineMaster;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;

class GradeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index() : ?object
    {
        return GradeMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  GradeMaster $gradeMaster
     * @return null|object
     */
    public function store(Request $request, GradeMaster $gradeMaster) : ?object
    {
        $dataInsert = $request->all();
        return $gradeMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param GradeMaster  $gradeMaster
     * @return null|object
     */
    public function show(GradeMaster $gradeMaster)
    {
        return $gradeMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  GradeMaster  $gradeMaster
     * @return null|object
     */
    public function update(Request $request, GradeMaster $gradeMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $gradeMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GradeMaster  $gradeMaster
     * @return null|object
     */
    public function destroy(GradeMaster $gradeMaster): bool
    {
        return $gradeMaster->delete();
    }

    public function getGradeMasterOption()
    {
        $fetchData = GradeMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->grade;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
