<?php

namespace App\Http\Controllers\Partymaster;

use App\Enums\UserTypeEnums;
use App\Http\Controllers\Controller;
use App\Models\Partymaster\BillingTerm;
use App\Models\Partymaster\ContactPerson;
use App\Models\Partymaster\DeliveryAddress;
use App\Models\Partymaster\PartyMaster;
use App\Models\Partymaster\TermAndCondition;
use App\Models\Purchase\PurchaseEnquiry;
use App\Models\Purchase\PurchaseEnquiryVendorDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelIdea\Helper\App\Models\Partymaster\_IH_PartyMaster_C;

class PartyMasterController extends Controller
{
    /**
     * @return PartyMaster|Collection
     */
    public function index(): PartyMaster|Collection
    {
        return PartyMaster::all();
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
        $party_master = PartyMaster::saveData($dataInsert);

        $data['message'] = "Party Master Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show()
    {
        $partyMaster = PartyMaster::all();
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyMaster;
        return jsonData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $partyMaster = PartyMaster::getDataFromId($id);
        $data['status'] = 200;
        $data['message'] = "Data Found";
        $data['data'] = $partyMaster;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate(['id' => 'required']);
        $dataUpdate = $request->all();
        $id = $dataUpdate['id'];

        if (isset($dataUpdate['isPartyDetails']) && $dataUpdate['isPartyDetails'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['partyDetails'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        if (isset($dataUpdate['isPartyAddress']) && $dataUpdate['isPartyAddress'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['partyAddress'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        if (isset($dataUpdate['isTaxDetails']) && $dataUpdate['isTaxDetails'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['taxDetails'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        if (isset($dataUpdate['isBankDetails']) && $dataUpdate['isBankDetails'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['bankDetails'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        if (isset($dataUpdate['iscompanyProfile']) && $dataUpdate['iscompanyProfile'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['companyProfile'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        if (isset($dataUpdate['isGeneralData']) && $dataUpdate['isGeneralData'] === true) {
            $fetchUpdate = PartyMaster::getDataFromId($dataUpdate['id'], true);
            $fetchUpdate['generalData'] = $dataUpdate;
            $dataUpdate = $fetchUpdate;
        }

        $updateData = PartyMaster::updateData($id, $dataUpdate);
        $data['message'] = "Party Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (auth()->user()->role == UserTypeEnums::SUPER || auth()->user()->role == UserTypeEnums::ADMIN) {
            PartyMaster::destroy($id);
            ContactPerson::deleteData(['partyId' => $id]);
            BillingTerm::deleteData(['partyId' => $id]);
            DeliveryAddress::deleteData(['partyId' => $id]);
            TermAndCondition::deleteData(['partyId' => $id]);

            $data['message'] = "Party Master deleted";
            $data['status'] = 200;
        } else {
            $data['message'] = "Permission Denied";
            $data['status'] = 400;
        }
        return jsonData($data);
    }

    /**
     * @return JsonResponse
     */
    public function getPartyMasterOptions()
    {
        $fetchData = PartyMaster::getData();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['partyCode'] = $value->partyCode;
            $response[$key]['partyName'] = $value->partyName;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param PartyMaster $partyMaster
     * @return JsonResponse
     */
    public function getPoPartyTypeOptions(PartyMaster $partyMaster)
    {
        $fetchData = $partyMaster->query()
                            ->where('partyType', '!=' , 1)
                            ->get();
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['partyCode'] = $value->partyCode;
            $response[$key]['partyName'] = $value->partyName;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function checkPartyNameExist($name)
    {
        $exists = PartyMaster::checkExists(['partyName' => $name]);

        $data['status'] = 200;
        $data['message'] = 'Party Name check';
        $data['data'] = $exists;
        return jsonData($data);
    }

    public function checkPartyNameExistWithId($id, $name)
    {
        $exists = PartyMaster::checkExistsWithId($id, ['partyName' => $name]);

        $data['status'] = 200;
        $data['message'] = 'Party Name check';
        $data['data'] = $exists;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param PartyMaster $partyMaster
     * @return JsonResponse
     */

    public function getPartyMasterListFilter(Request $request, PartyMaster $partyMaster): JsonResponse
    {
        $partyCode = $request->partyCode ?? null;
        $partyName = $request->partyName ?? null;
        $partyType = $request->partyType ?? null;
        $partyStatus = $request->partyStatus ?? null;
        $partyCity = $request->partyCity ?? null;
        $partyState = $request->partyState ?? null;
        $partyBranch = $request->partyBranch ?? null;
        $profile = $request->profile ?? null;

        $itemDetails = $partyMaster->query();

        if ($partyCode) {
            $itemDetails->where('partyCode', $partyCode);
        }
        if ($partyName) {
            $itemDetails->where('partyName', $partyName);
        }
        if ($partyType) {
            $itemDetails->where('partyType', $partyType);
        }
        if ($partyStatus) {
            $itemDetails->where('partyStatus', $partyStatus);
        }
        if ($partyBranch) {
            $itemDetails->where('partyBranch', $partyBranch);
        }
        if ($partyCity) {
            $itemDetails->where('partyDetails.partyCity', $partyCity);
        }
        if ($partyState) {
            $itemDetails->where('partyDetails.partyState', $partyState);
        }
        if ($profile) {
            $itemDetails->where('companyProfile.profile', $profile);
        }
        if (($partyCode) && ($partyName) && ($partyType) && ($partyStatus) && ($partyBranch) && ($partyCity) && ($partyState) && ($profile)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Party Master List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);

    }

    public function getPartyMasterOnlyCustomerOptions()
    {
        $fetchData = PartyMaster::query()->onlyCustomer()->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getPartyMasterWithoutCustomerOptions()
    {
        $fetchData = PartyMaster::query()->onlyWithoutCustomer()->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getPartyMasterOnlyVendorOptions()
    {
        $fetchData = PartyMaster::query()->onlyVendor()->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getPartyMasterOnlyTransPorterOptions()
    {
        $fetchData = PartyMaster::query()->industryWise('TRANSPORTER')->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = "($value->partyCode) - " . $value->partyName;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Party Master Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }
}
