<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Models\HrMaster\GroupMaster;
use hanneskod\classtools\Transformer\ReaderTest;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;

class GroupMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return GroupMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @param GroupMaster  $groupMaster
     * @return null|object
     */
    public function store(GroupMaster $groupMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $groupMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param GroupMaster  $groupMaster
     * @return null|object
     */
    public function show(GroupMaster $groupMaster)
    {
        return $groupMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param GroupMaster  $groupMaster
     * @return null|object
     */
    public function update(Request $request, GroupMaster $groupMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $groupMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GroupMaster  $groupMaster
     * @return null|object
     */
    public function destroy(GroupMaster $groupMaster):bool
    {
        return $groupMaster->delete();
    }

    public function getGroupMaster()
    {
        $fetchData = GroupMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->group;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
