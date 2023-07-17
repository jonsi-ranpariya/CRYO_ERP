<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BillingTemplateItemsMaster;
use App\Models\Master\BillingTemplateMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingTemplateMasterController extends Controller
{
    private $statusActive = 1;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = BillingTemplateMaster::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $billingTerms = $dataInsert['billingTerms'];
        $response = BillingTemplateMaster::saveData($dataInsert);

        if (is_array($billingTerms) and count($billingTerms) > 0) {
            foreach ($billingTerms as $billingTerm) {
                $billingTerm['templateId'] = $response->_id;
                BillingTemplateItemsMaster::saveData($billingTerm);
            }
        }

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = BillingTemplateMaster::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
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
        $dataUpdate = $request->all();
        $response = BillingTemplateMaster::updateData($id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BillingTemplateMaster::destroy($id);
        BillingTemplateItemsMaster::deleteData(['templateId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    public function getBillingTemplateMasterOptions()
    {
        $fechData = BillingTemplateMaster::getData(['companyId' => 1, 'status' => $this->statusActive]);

        foreach ($fechData as $key => $value) {
            $response[$key]['label'] = $value->templateName;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }
}
