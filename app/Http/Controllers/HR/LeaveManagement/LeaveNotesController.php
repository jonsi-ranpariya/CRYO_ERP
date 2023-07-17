<?php

namespace App\Http\Controllers\HR\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\HR\LeaveManagement\LeaveNotes;
use Illuminate\Http\Request;

class LeaveNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return LeaveNotes::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeaveNotes  $leaveNotes
     * @param Request  $request
     * @return null|object
     */
    public function store(LeaveNotes $leaveNotes, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $leaveNotes->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param LeaveNotes  $leaveNotes
     * @return null|object
     */
    public function show(LeaveNotes $leaveNotes)
    {
        return $leaveNotes;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param LeaveNotes $leaveNotes
     * @return null|object
     */
    public function update(Request $request, LeaveNotes $leaveNotes): Mixed
    {
        $dataUpdate = $request->all();
        return $leaveNotes->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeaveNotes  $leaveNotes
     * @return null|object
     */
    public function destroy(LeaveNotes $leaveNotes):bool
    {
        return $leaveNotes->delete();
    }

}
