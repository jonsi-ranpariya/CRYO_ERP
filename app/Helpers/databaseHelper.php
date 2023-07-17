<?php

use App\Models\GST\MasterGst;
use App\Models\Inventory\MaterialIssue;
use App\Models\Item\ItemCategoryMaster;
use App\Models\Item\ItemGroupMaster;
use App\Models\Item\ItemHsnSacMaster;
use App\Models\Item\ItemMainSubGroupMaster;
use App\Models\Master\BranchMaster;
use App\Models\Master\BusinessTypeMaster;
use App\Models\Master\CityMaster;
use App\Models\Master\CountryMaster;
use App\Models\Master\CurrencyMaster;
use App\Models\Master\DepartmentMaster;
use App\Models\Master\DesignationMaster;
use App\Models\Master\IndustryTypeMaster;
use App\Models\Master\InvoiceTypeMaster;
use App\Models\Master\ItemMaster;
use App\Models\Master\PartyTypes;
use App\Models\Master\StateMaster;
use App\Models\Master\UnitMeasurment;
use App\Models\Partymaster\PartyMaster;
use App\Models\SalesCrm\SalesOrder;
use App\Models\User;

if (!function_exists('getMasterApiAuthToken')) {
    /**
     * @return mixed
     */
    function getMasterApiAuthToken(): mixed
    {
        $masterData = MasterGst::query()->latest()->first();
        return $masterData->data['AuthToken'];
    }
}

if (!function_exists('getUomIdFromName')) {
    /**
     * @param string|null $name
     * @return mixed
     */
    function getUomIdFromName(?string $name): mixed
    {
        if (empty($name)) {
            return null;
        }

        return UnitMeasurment::query()
            ->where('uom', 'LIKE', "%{$name}%")
            ->first()
            ->_id ?? null;
    }
}

if (!function_exists('getItemCategoryOptionByName')) {
    /**
     * @param string|null $name
     * @return array|null
     */
    function getItemCategoryOptionByName(?string $name): ?array
    {
        if (empty($name)) {
            return null;
        }

        $itemCategory = ItemCategoryMaster::query()
            ->where('itemDescription', $name)
            ->first();

        if (!empty($itemCategory)) {
            return [
                'label' => $itemCategory->itemDescription,
                'value' => $itemCategory->_id,
            ];
        } else {
            return null;
        }
    }
}

if (!function_exists('getItemGroupOptionByName')) {
    /**
     * @param string|null $description
     * @return array|null
     */
    function getItemGroupOptionByName(?string $description): ?array
    {
        if (empty($description)) {
            return null;
        }

        $itemGroup = ItemGroupMaster::query()
            ->where('groupCode', 'LIKE', "%{$description}%")
            ->first();

        if (!empty($itemGroup)) {
            return [
                'label' => $itemGroup->groupDescription . "(" . $itemGroup->groupCode . ")",
                'value' => $itemGroup->_id,
                'groupCode' => $itemGroup->groupCode
            ];
        } else {
            return null;
        }
    }
}

if (!function_exists('getItemMainGroupSubGroup')) {
    /**
     * @param string|null $description
     * @return mixed
     */
    function getItemMainGroupSubGroup(?string $description): mixed
    {
        if (empty($description)) {
            return null;
        }

        return ItemMainSubGroupMaster::query()
            ->where('groupDescription', 'LIKE', "%{$description}%")
            ->first()
            ->_id ?? null;
    }
}

if (!function_exists('checkInvoiceType')) {
    /**
     * @param string $id
     * @param string $invoiceType
     * @return bool
     */
    function checkInvoiceType(string $id, string $invoiceType): bool
    {
        if (empty($id)) {
            return false;
        }

        $invoiceTypeMaster = InvoiceTypeMaster::query()->find($id);
        if ($invoiceTypeMaster->description == $invoiceType) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getStateOptionByName')) {
    /**
     * @param string|null $value
     * @return array|null
     */
    function getStateOptionByName(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        $stateMaster = StateMaster::query()->where('state', 'LIKE', "%{$value}%")->first();
        if (empty($stateMaster)) {
            return null;
        } else {
            return [
                'label' => $stateMaster->state,
                'value' => $stateMaster->_id,
                'code' => $stateMaster->stateCode
            ];
        }
    }
}

if (!function_exists('getCityOptionByName')) {
    /**
     * @param string|null $value
     * @return array|null
     */
    function getCityOptionByName(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        $cityMaster = CityMaster::query()->where('city', 'LIKE', "%{$value}%")->first();
        if (empty($cityMaster)) {
            return null;
        } else {
            return [
                'label' => $cityMaster->city,
                'value' => $cityMaster->_id
            ];
        }
    }
}

if (!function_exists('getCountryOptionByName')) {
    /**
     * @param string|null $value
     * @return array|null
     */
    function getCountryOptionByName(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        $countryMaster = CountryMaster::query()->where('country', 'LIKE',"%{$value}%")->first();
        if (empty($countryMaster)) {
            return null;
        } else {
            return [
                'label' => $countryMaster->country,
                'value' => $countryMaster->_id
            ];
        }
    }
}

if (!function_exists('getPartyTypeIdByName')) {

    /**
     * @param string|null $value
     * @return mixed
     */
    function getPartyTypeIdByName(?string $value): mixed
    {
        if (empty($value)) {
            return null;
        }

        return PartyTypes::query()
            ->where('partyType', 'LIKE', "%{$value}%")
            ->first()
            ?->_id ?? null;
    }
}

if (!function_exists('getPartyBusinessTypeIdByName')) {
    /**
     * @param string $value
     * @return string|null
     */
    function getPartyBusinessTypeIdByName(string $value): ?string
    {
        $businessType = BusinessTypeMaster::query()
            ->where('businessType', 'LIKE', "%{$value}%")
            ->first();

        if (empty($businessType)) {
            return null;
        } else {
            return $businessType->_id;
        }
    }
}

if (!function_exists('getPartyIndustryTypeIdByName')) {
    /**
     * @param string|null $value
     * @return string|null
     */
    function getPartyIndustryTypeIdByName(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $industryType = IndustryTypeMaster::query()
            ->where('industryType', 'LIKE', "%{$value}%")
            ->first();

        if (empty($industryType)) {
            return null;
        } else {
            return $industryType->_id;
        }
    }
}

if (!function_exists('getDesignationMasterByName')) {
    /**
     * @param string|null $value
     * @return object|null
     */
    function getDesignationMasterByName(?string $value): ?object
    {
        if (empty($value)){
            return null;
        }

        return DesignationMaster::with('departmentDetail')
            ->where('designation', 'LIKE', "%{$value}%")
            ->first();
    }
}

if (!function_exists('getDepartmentByName')){
    /**
     * @param string|null $name
     * @return object|null
     */
    function getDepartmentByName(?string $name): ?object
    {
        if (empty($name)){
            return null;
        }

        return DepartmentMaster::query()
            ->where('department', 'LIKE',"%{$name}%")
            ->first() ?? null;
    }
}

if (!function_exists('getSalesOrderNumberFromId')) {
    /**
     * @param string|null $salesOrderId
     * @return mixed
     */
    function getSalesOrderNumberFromId(?string $salesOrderId): mixed
    {
        if (empty($salesOrderId)){
            return null;
        }

        return SalesOrder::find($salesOrderId)?->salesOrderNo ?? null;
    }
}

if (!function_exists('getHsnSacDetailsByNumber')) {
    /**
     * @param string|int|null $number
     * @return mixed
     */
    function getHsnSacDetailsByNumber(string|int|null $number): mixed
    {
        if (empty($number)) {
            return null;
        }

        return ItemHsnSacMaster::query()
            ->where('codeNo', 'LIKE', "%{$number}%")
            ->first();
    }
}

if (!function_exists('getUserIdByEmail')) {
    /**
     * @param string|null $email
     * @return mixed
     */
    function getUserIdByEmail(?string $email): mixed
    {
        if (empty($email)) {
            return null;
        }

        return User::query()
            ->where('email', $email)
            ->first()
            ?->_id ?? null;
    }
}

if (!function_exists('getPartyBranchOptionFromName')) {
    /**
     * @param string|null $name
     * @return array|null
     */
    function getPartyBranchOptionFromName(?string $name): ?array
    {
        if (empty($name)) {
            return null;
        }

        $branch = BranchMaster::query()
            ->where('branchName', 'LIKE', "%{$name}%")
            ->first();

        if (empty($branch)) {
            return null;
        }

        return [
            'label' => $branch->branchName,
            'value' => $branch->_id,
        ];
    }
}


if (!function_exists('getPartyGroupIdByName')) {
    /**
     * @param string|null $name
     * @return mixed
     */
    function getPartyGroupIdByName(?string $name): mixed
    {
        if (empty($name)) {
            return null;
        }

        return \App\Models\Partymaster\PartyGroupMaster::query()
            ->where('groupName', 'LIKE', "%{$name}%")
            ->first()
            ?->_id ?? null;
    }
}

if (!function_exists('getCurrencyIdByName')) {
    /**
     * @param string|null $name
     * @return mixed
     */
    function getCurrencyIdByName(?string $name): mixed
    {
        if (empty($name)) {
            return null;
        }

        return CurrencyMaster::query()
            ->where('currencyCode', 'LIKE', "%{$name}%")
            ->first()
            ?->_id ?? null;
    }
}

if (!function_exists('getItemMasterIdByItemCode')){
    /**
     * @param string $itemCode
     * @return string|null
     */
    function getItemMasterIdByItemCode(string $itemCode): ?string
    {
        return ItemMaster::query()
            ->where('itemCode', $itemCode)
            ->first()
            ?->_id ?? null;
    }
}

if (!function_exists('getPartyNameFromPartyCode')) {
    /**
     * @param string|null $partyCode
     * @return string|null
     */
    function getPartyNameFromPartyCode(?string $partyCode): ?string
    {
        if (is_null($partyCode)) return null;
        return PartyMaster::query()
            ->where('partyCode', $partyCode)
            ->value('partyName') ?? null;
    }
}
