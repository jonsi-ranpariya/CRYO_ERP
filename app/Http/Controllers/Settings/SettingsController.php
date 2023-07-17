<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\SettingsMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;

class SettingsController extends Controller
{
    public function addUpdateSettings(Request $request)
    {
        if (empty($request->id)) {
            $model = new SettingsMaster();
        } else {
            $model = SettingsMaster::getDataFromId($request->id);
        }

        $model->settingKey = $request->settingKey;
        $model->budgetValidationOn = $request->budgetValidationOn;
        $model->ifBudgetExceeded = $request->ifBudgetExceeded;
        $model->autoForex = $request->autoForex;
        $model->companyId = 1;
        $model->addedFrom = auth()->id();
        $model->save();

        $data['message'] = "Setting Master Data Saved";
        $data['status'] = 200;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSettingsByKey(Request $request)
    {
        $response = SettingsMaster::getFirstData([
            'companyId' => 1,
            'settingKey' => $request->setting_key
        ]);

        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }
}
