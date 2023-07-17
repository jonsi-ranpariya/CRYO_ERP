<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\SubContractorRateParameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubContractorRateParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if($request->has('flag')){
            $flag = $request->get('flag');
            $response = SubContractorRateParameter::getData(['flag' => (int)$flag]);
        }else{
            $response = SubContractorRateParameter::all();
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = SubContractorRateParameter::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  SubContractorRateParameter  $subContractorRateParameter
     * @return JsonResponse
     */
    public function show(SubContractorRateParameter $subContractorRateParameter)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $subContractorRateParameter;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubContractorRateParameter $subContractorRateParameter
     * @return JsonResponse
     */
    public function update(Request $request, SubContractorRateParameter $subContractorRateParameter)
    {
        $dataUpdated = $request->all();
        $response = $subContractorRateParameter->updateData($subContractorRateParameter->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubContractorRateParameter $subContractorRateParameter
     * @return JsonResponse
     */
    public function destroy(SubContractorRateParameter $subContractorRateParameter)
    {
        $response = $subContractorRateParameter->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

//    /**
//     * Display a listing of the resource for particular order.
//     *
//     * @param $id
//     * @param SubContractorRateParameter $subContractorRateParameter
//     * @return JsonResponse
//     */
//    public function getSubRateParameter($id, SubContractorRateParameter $subContractorRateParameter)
//    {
//        $response = $subContractorRateParameter->getData(['rateId' => $id]);
//
//        $data['message'] = 'Data Found';
//        $data['data'] = $response;
//        return jsonData($data);
//    }

}
