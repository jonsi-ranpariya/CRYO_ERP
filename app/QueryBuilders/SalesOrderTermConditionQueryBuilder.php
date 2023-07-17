<?php
/**
 * Created by Jaymeen Darji.
 * User: jaymeen
 * Date: 3/28/23
 * Time: 4:56 PM
 */

namespace App\QueryBuilders;

use App\Enums\TermAndConditionPrintForEnums;
use Jenssegers\Mongodb\Eloquent\Builder;

class SalesOrderTermConditionQueryBuilder extends Builder
{
    public function printTermOnly()
    {
        return $this->where('isPrint', '1');
    }

    public function generalOnly()
    {
        return $this->where('termConditionForName', TermAndConditionPrintForEnums::GENERAL);
    }

    public function generalWorkOrderOnly()
    {
        return $this->whereIn('termConditionForName', [
            TermAndConditionPrintForEnums::GENERAL,
            TermAndConditionPrintForEnums::WORK_ORDER
        ]);
    }

    public function workOrderOnly()
    {
        return $this->where('termConditionForName', TermAndConditionPrintForEnums::WORK_ORDER);
    }

    public function invoiceOnly()
    {
        return $this->where('termConditionForName', TermAndConditionPrintForEnums::INVOICE);
    }

    public function invoiceWorkOrderOnly()
    {
        return $this->whereIn('termConditionForName', [
            TermAndConditionPrintForEnums::INVOICE,
            TermAndConditionPrintForEnums::WORK_ORDER
        ]);
    }
}
