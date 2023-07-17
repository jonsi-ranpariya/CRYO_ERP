<?php

namespace App\Http\Controllers\Partymaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Partymaster\PartyGroupMaster;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PartygroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $party_master = PartyGroupMaster::all();

        $data['message'] = "Party Group Master Found";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $party_master = PartyGroupMaster::saveData($dataInsert);

        $data['message'] = "Party Group Master Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $party_master = PartyGroupMaster::getDataFromId($id);

        $data['message'] = "Party Group Master found";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $party_master = PartyGroupMaster::updateData($id, $request->all());

        $data['message'] = "Party Group Master found";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PartyGroupMaster::destroyData($id);

        $data['message'] = "Party Group Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getAllPartyGroup()
    {
        $fetchData = PartyGroupMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->groupName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Group Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }
}
