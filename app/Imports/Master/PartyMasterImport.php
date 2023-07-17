<?php

namespace App\Imports\Master;

use App\Enums\Master\PartyMaster\PartyBalanceTypeEnum;
use App\Enums\Master\PartyMaster\PartyDealInEnum;
use App\Enums\Master\PartyMaster\PartyStatusEnum;
use App\Enums\Master\PartyMaster\PartySupplyTypeEnum;
use App\Models\Partymaster\ContactPerson;
use App\Models\Partymaster\DeliveryAddress;
use App\Models\Partymaster\PartyMaster;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;

class PartyMasterImport implements WithBatchInserts, WithChunkReading, OnEachRow
{
    use Importable;

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onRow(Row $row): void
    {
        $rowIndex = $row->getIndex();
        $row = array_map('trim', $row->toArray());
        try {
            if ($rowIndex != 1) {
                $dataInsert['partyCode'] = $row[0] ?? null;
                $dataInsert['partyName'] = $row[1] ?? null;
                $dataInsert['partyType'] = getPartyTypeIdByName($row[2]) ?? null;
                $dataInsert['PartyTypeDealIn'] = PartyDealInEnum::getValue($row[3]) ?? null;
                $dataInsert['partyTypeStatus'] = null;
                $dataInsert['partyTypeBusinessType'] = getPartyBusinessTypeIdByName($row[4]) ?? null;
                $dataInsert['partyTypeIndustry'] = getPartyIndustryTypeIdByName($row[5]) ?? null;
                $dataInsert['partyBranch'] = getPartyBranchOptionFromName($row[6]) ?? null;
                $dataInsert['partySupplyType'] = !empty($row[7]) ? PartySupplyTypeEnum::getValue($row[7]) : null;
                $dataInsert['partyOpeningBalance'] = $row[8];
                $dataInsert['partyBalanceType'] = !empty($row[9]) ? PartyBalanceTypeEnum::getValue($row[9]) : null;
                $dataInsert['partyCreditLimit'] = $row[10];
                $dataInsert['partyGroup'] = !empty($row[11]) ? getPartyGroupIdByName($row[11]) : null;
                $dataInsert['partyCurrencyType'] = !empty($row[12]) ? getCurrencyIdByName($row[12]) : null;
                $dataInsert['partyStatus'] = PartyStatusEnum::getValue($row[13]) ?? null;
                $dataInsert['partyActive'] = 1;
                $response = PartyMaster::saveData($dataInsert);
                if ($response) {
                    /*PARTY DETAILS*/
                    $dataInsert['partyDetails']['id'] = $response->_id;
                    $dataInsert['partyDetails']['nsicNo'] = null;
                    $dataInsert['partyDetails']['lwfNo'] = null;
                    $dataInsert['partyDetails']['partyAddress'] = $row[14] ?? null;
                    $dataInsert['partyDetails']['partyAddress2'] = null;
                    if (getCityOptionByName($row[15])) {
                        $dataInsert['partyDetails']['partyCity']['label'] = getCityOptionByName($row[15])['label'] ?? null;
                        $dataInsert['partyDetails']['partyCity']['value'] = getCityOptionByName($row[15])['value'] ?? null;
                    } else {
                        $dataInsert['partyDetails']['partyCity'] = null;
                    }
                    $dataInsert['partyDetails']['partyArea'] = $row[18] ?? null;
                    $dataInsert['partyDetails']['partyPinCode'] = $row[19] ?? null;
                    if (getStateOptionByName($row[16])) {
                        $dataInsert['partyDetails']['partyState']['label'] = getStateOptionByName($row[16])['label'] ?? null;
                        $dataInsert['partyDetails']['partyState']['value'] = getStateOptionByName($row[16])['value'] ?? null;
                    } else {
                        $dataInsert['partyDetails']['partyState'] = null;
                    }
                    if (getCountryOptionByName($row[17])) {
                        $dataInsert['partyDetails']['partyCountry']['label'] = getCountryOptionByName($row[17])['label'] ?? null;
                        $dataInsert['partyDetails']['partyCountry']['value'] = getCountryOptionByName($row[17])['value'] ?? null;
                    } else {
                        $dataInsert['partyDetails']['partyCountry'] = null;
                    }
                    $dataInsert['partyDetails']['partyCountryCode'] = $row[20] ?? null;
                    $dataInsert['partyDetails']['partyPhoneNo'] = $row[21] ?? null;
                    $dataInsert['partyDetails']['partyFaxNo'] = $row[22] ?? null;
                    $dataInsert['partyDetails']['partyEmilId'] = $row[23] ?? null;
                    $dataInsert['partyDetails']['partyWebsite'] = $row[24] ?? null;
                    $dataInsert['partyDetails']['partyGroupName'] = null;
                    $dataInsert['partyDetails']['partyTdsApplicable'] = null;
                    $dataInsert['partyDetails']['partyGlTdsAC'] = null;
                    $dataInsert['partyDetails']['partyTdsPaymentType'] = null;
                    $dataInsert['partyDetails']['partyTdsPercentage'] = null;
                    $dataInsert['partyDetails']['fromQuotation'] = null;
                    $dataInsert['partyDetails']['fromSalesSupport'] = null;
                    $dataInsert['partyDetails']['partyGroupCode'] = null;
                    $dataInsert['partyDetails']['partyGlTdsACName'] = null;
                    $dataInsert['partyDetails']['isPartyDetails'] = true;
                    /*WORK ADDRESS*/
                    $dataInsert['partyAddress']['id'] = $response->_id;
                    $dataInsert['partyAddress']['isPartyAddress'] = true;
                    $dataInsert['partyAddress']['partyAddress'] = $row[25] ?? null;
                    if (getCountryOptionByName($row[28])) {
                        $dataInsert['partyAddress']['partyCountry']['label'] = getCountryOptionByName($row[28])['label'] ?? null;
                        $dataInsert['partyAddress']['partyCountry']['value'] = getCountryOptionByName($row[28])['value'] ?? null;
                    } else {
                        $dataInsert['partyAddress']['partyCountry'] = null;
                    }
                    if (getStateOptionByName($row[27])) {
                        $dataInsert['partyAddress']['partyState']['label'] = getStateOptionByName($row[27])['label'] ?? null;
                        $dataInsert['partyAddress']['partyState']['value'] = getStateOptionByName($row[27])['value'] ?? null;
                    } else {
                        $dataInsert['partyAddress']['partyState'] = null;
                    }
                    if (getCityOptionByName($row[26])) {
                        $dataInsert['partyAddress']['partyCity']['label'] = getCityOptionByName($row[26])['label'] ?? null;
                        $dataInsert['partyAddress']['partyCity']['value'] = getCityOptionByName($row[26])['value'] ?? null;
                    } else {
                        $dataInsert['partyAddress']['partyCity'] = null;
                    }
                    $dataInsert['partyAddress']['partyArea'] = $row[29] ?? null;
                    $dataInsert['partyAddress']['partyPinCode'] = $row[30] ?? null;
                    $dataInsert['partyAddress']['partyPhoneNoCode'] = $row[31] ?? null;
                    $dataInsert['partyAddress']['partyPhoneNo'] = $row[32] ?? null;
                    $dataInsert['partyAddress']['partyFaxNo'] = $row[33] ?? null;
                    $dataInsert['partyAddress']['partyEmilId'] = $row[34] ?? null;
                    $dataInsert['partyAddress']['partyWebsite'] = $row[35] ?? null;
                    /*TAX DETAILS*/
                    $dataInsert['taxDetails']['id'] = $response->_id;
                    $dataInsert['taxDetails']['isTaxDetails'] = true;
                    $dataInsert['taxDetails']['gstin'] = $row[36] ?? null;
                    $dataInsert['taxDetails']['cinNo'] = $row[38] ?? null;
                    $dataInsert['taxDetails']['tanNo'] = $row[39] ?? null;
                    $dataInsert['taxDetails']['udyamNo'] = $row[40] ?? null;
                    $dataInsert['taxDetails']['panNo'] = $row[37] ?? null;
                    $dataInsert['taxDetails']['uid'] = $row[41] ?? null;
                    $dataInsert['taxDetails']['arn'] = $row[42] ?? null;
                    $dataInsert['taxDetails']['tinVatNo'] = $row[43] ?? null;
                    $dataInsert['taxDetails']['tinCstNo'] = $row[44] ?? null;
                    $dataInsert['taxDetails']['eccNo'] = $row[45] ?? null;
                    $dataInsert['taxDetails']['range'] = $row[46] ?? null;
                    $dataInsert['taxDetails']['division'] = $row[47] ?? null;
                    $dataInsert['taxDetails']['serviceTaxNo'] = $row[48] ?? null;
                    $dataInsert['taxDetails']['nsicNo'] = $row[49] ?? null;
                    $dataInsert['taxDetails']['lwfNo'] = $row[50] ?? null;
                    /*BANK DETAILS*/
                    $dataInsert['bankDetails']['id'] = $response->_id;
                    $dataInsert['bankDetails']['isBankDetails'] = true;
                    $dataInsert['bankDetails']['beneficiaryName'] = $row[51] ?? null;
                    $dataInsert['bankDetails']['bankName'] = $row[52] ?? null;
                    $dataInsert['bankDetails']['accountNo'] = $row[53] ?? null;
                    $dataInsert['bankDetails']['branchName'] = $row[54] ?? null;
                    $dataInsert['bankDetails']['branchCode'] = $row[55] ?? null;
                    $dataInsert['bankDetails']['ifscCode'] = $row[56] ?? null;
                    $dataInsert['bankDetails']['micrCode'] = $row[57] ?? null;
                    $dataInsert['bankDetails']['swiftCode'] = $row[58] ?? null;
                    $dataInsert['bankDetails']['iBanNo'] = $row[59] ?? null;
                    /*GENERAL DETAILS*/
                    $dataInsert['generalData']['id'] = $response->_id;
                    $dataInsert['generalData']['isGeneralData'] = true;
                    $dataInsert['generalData']['workingHours'] = $row[60] ?? null;
                    $dataInsert['generalData']['vendorCode'] = $row[61] ?? null;
                    $dataInsert['generalData']['holiday'] = $row[62] ?? null;
                    $dataInsert['generalData']['ourConcernPerson'] = $row[63] ?? null;
                    $dataInsert['generalData']['allowMultiple'] = null;
                    /*Company PROFILE*/
                    $dataInsert['companyProfile']['id'] = $response->_id;
                    $dataInsert['companyProfile']['iscompanyProfile'] = true;
                    $dataInsert['companyProfile']['profile'] = $row[64] ?? null;
                    /*Login DETAILS*/
                    $dataInsert['loginDetails']['createdBy'] = 'Imported';
                    $dataInsert['loginDetails']['createdDateTime'] = now()->format('d/m/Y H:i');
                    $dataInsert['loginDetails']['modifiedBy'] = null;
                    $dataInsert['loginDetails']['modifiedDateTime'] = null;
                    $dataInsert['loginDetails']['approvedBy'] = null;
                    $dataInsert['loginDetails']['approvedDateTime'] = null;
                    $dataInsert['loginDetails']['stage'] = PartyStatusEnum::Created;
                    PartyMaster::updateData($response->_id, $dataInsert);

                    if (getDesignationMasterByName($row[66])) {
                        $person1Designation = getDesignationMasterByName($row[66])->designation;
                    }
                    if (getDepartmentByName($row[67])) {
                        $person1Department = getDepartmentByName($row[67])->department;
                    }

                    $contactPerson1 = [
                        'partyId' => $response->_id,
                        'personName' => $row[65] ?? null,
                        'designation' => $person1Designation ?? null,
                        'department' => $person1Department ?? null,
                        'division' => $row[68] ?? null,
                        'phoneNoCode' => $row[69] ?? null,
                        'phoneNo' => $row[70] ?? null,
                        'mobileNo' => $row[71] ?? null,
                        'mobileNoCode' => '+91',
                        'email' => $row[72] ?? null,
                        'faxNo' => $row[73] ?? null,
                        'extNumber' => $row[74] ?? null,
                        'note' => null,
                        'active' => 1,
                        'autoSms' => 0,
                        'autoEmail' => 0,
                    ];
                    if (!empty($contactPerson1['personName'])) {
                        ContactPerson::saveData($contactPerson1);
                    }

                    if (getDesignationMasterByName($row[76])) {
                        $person2Designation = getDesignationMasterByName($row[76])->designation;
                    }
                    if (getDepartmentByName($row[77])) {
                        $person2Department = getDepartmentByName($row[77])->department;
                    }

                    $contactPerson2 = [
                        'partyId' => $response->_id,
                        'personName' => $row[75] ?? null,
                        'designation' => $person2Designation ?? null,
                        'department' => $person2Department ?? null,
                        'division' => $row[78] ?? null,
                        'phoneNoCode' => $row[79] ?? null,
                        'phoneNo' => $row[80] ?? null,
                        'mobileNo' => $row[81] ?? null,
                        'mobileNoCode' => '+91',
                        'email' => $row[82] ?? null,
                        'faxNo' => $row[83] ?? null,
                        'extNumber' => $row[84] ?? null,
                        'note' => null,
                        'active' => 1,
                        'autoSms' => 0,
                        'autoEmail' => 0,
                    ];

                    if (!empty($contactPerson2['personName'])) {
                        ContactPerson::saveData($contactPerson2);
                    }

                    $deliveryAdd1['partyId'] = $response->_id;
                    if (getCountryOptionByName($row[87])) {
                        $deliveryAdd1['country']['label'] = getCountryOptionByName($row[87])['label'] ?? null;
                        $deliveryAdd1['country']['value'] = getCountryOptionByName($row[87])['value'] ?? null;
                    } else {
                        $deliveryAdd1['country'] = null;
                    }
                    if (getStateOptionByName($row[86])) {
                        $deliveryAdd1['state']['label'] = getStateOptionByName($row[86])['label'] ?? null;
                        $deliveryAdd1['state']['value'] = getStateOptionByName($row[86])['value'] ?? null;
                    } else {
                        $deliveryAdd1['state'] = null;
                    }
                    if (getCityOptionByName($row[85])) {
                        $deliveryAdd1['city']['label'] = getCityOptionByName($row[85])['label'] ?? null;
                        $deliveryAdd1['city']['value'] = getCityOptionByName($row[85])['value'] ?? null;
                    } else {
                        $deliveryAdd1['city'] = null;
                    }
                    $deliveryAdd1['pinCode'] = $row[88] ?? null;
                    $deliveryAdd1['address'] = $row[89] ?? null;
                    $deliveryAdd1['phoneNoCode'] = $row[90] ?? null;
                    $deliveryAdd1['phoneNo'] = $row[91] ?? null;
                    $deliveryAdd1['faxNo'] = $row[92] ?? null;
                    $deliveryAdd1['emailId'] = $row[93] ?? null;
                    $deliveryAdd1['website'] = $row[94] ?? null;
                    $deliveryAdd1['vatNo'] = $row[95] ?? null;
                    $deliveryAdd1['cstNo'] = $row[96] ?? null;
                    $deliveryAdd1['gstin'] = $row[97] ?? null;
                    if (!empty($deliveryAdd1['country'])) {
                        DeliveryAddress::saveData($deliveryAdd1);
                    }

                    $deliveryAdd2['partyId'] = $response->_id;
                    if (getCountryOptionByName($row[100])) {
                        $deliveryAdd2['country']['label'] = getCountryOptionByName($row[100])['label'] ?? null;
                        $deliveryAdd2['country']['value'] = getCountryOptionByName($row[100])['value'] ?? null;
                    } else {
                        $deliveryAdd2['country'] = null;
                    }
                    if (getStateOptionByName($row[99])) {
                        $deliveryAdd2['state']['label'] = getStateOptionByName($row[99])['label'] ?? null;
                        $deliveryAdd2['state']['value'] = getStateOptionByName($row[99])['value'] ?? null;
                    } else {
                        $deliveryAdd2['state'] = null;
                    }
                    if (getCityOptionByName($row[98])) {
                        $deliveryAdd2['city']['label'] = getCityOptionByName($row[98])['label'] ?? null;
                        $deliveryAdd2['city']['value'] = getCityOptionByName($row[98])['value'] ?? null;
                    } else {
                        $deliveryAdd2['city'] = null;
                    }
                    $deliveryAdd2['pinCode'] = $row[101] ?? null;
                    $deliveryAdd2['address'] = $row[102] ?? null;
                    $deliveryAdd2['phoneNoCode'] = $row[103] ?? null;
                    $deliveryAdd2['phoneNo'] = $row[104] ?? null;
                    $deliveryAdd2['faxNo'] = $row[105] ?? null;
                    $deliveryAdd2['emailId'] = $row[106] ?? null;
                    $deliveryAdd2['website'] = $row[107] ?? null;
                    $deliveryAdd2['vatNo'] = $row[108] ?? null;
                    $deliveryAdd2['cstNo'] = $row[109] ?? null;
                    $deliveryAdd2['gstin'] = $row[110] ?? null;

                    if (!empty($deliveryAdd2['country'])) {
                        DeliveryAddress::saveData($deliveryAdd2);
                    }
                }
            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }
}
