<?php

namespace App\Models\GST;

use App\Models\BaseModel;

class MasterGst extends BaseModel
{
    protected $collection = 'master_gst';

    protected $fillable = [
        'AckNo',
        'AckDt',
        'Irn',
        'SignedInvoice',
        'SignedQRCode',
        'Status',
        'EwbNo',
        'EwbDt',
        'EwbValidTill',
        'Remarks',
        'company_id',
        'challanInvoiceId',
        'salesReturnId',
        'purchaseReturnId',
        'CancelDate',
    ];
}
