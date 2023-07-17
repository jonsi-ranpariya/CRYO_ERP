<?php

namespace App\Http\Controllers\Partymaster;

use App\Http\Controllers\Controller;
use App\Models\Partymaster\ContactPerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $partyMaster = ContactPerson::all();
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyMaster;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDataPartyWise($id)
    {
        $partyData = ContactPerson::getData(['partyId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPartyWiseContactOptions($id)
    {
        $fetchData = ContactPerson::getData(['partyId' => $id]);

        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = ucfirst($value->personName);
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $response = ContactPerson::saveData($insertData);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $partyMaster = ContactPerson::getDataFromId($id);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyMaster;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->all();
        $response = ContactPerson::updateData($id, $updateData);
        $data['message'] = "Data Update Successfully";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ContactPerson::destroy($id);
        $data['message'] = "Data deleted Successfully";
        $data['status'] = 200;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getAllContactOptions()
    {
        $fetchData = ContactPerson::all();

        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = ucfirst($value->personName);
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
