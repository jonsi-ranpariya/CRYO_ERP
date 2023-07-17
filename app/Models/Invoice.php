<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Invoice extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'invoice';
    protected $fillable = [
        'partyCode',
        'invoiceNo',
        'invoiceDate',
        'challanNo',
        'orderNo',
        'billToPartyGst',
        'billToPartyName',
        'billToPartyAddress',
        'billToPartyState',
        'billToPartyCountry',
        'billToPartyPanNo',
        'billToPartyAttn',
        'shipToPartyGst',
        'shipToPartyName',
        'shipToPartyAddress',
        'shipToPartyState',
        'shipToPartyCountry',
        'shipToPartyPanNo',
        'invoiceItemList',
        'cgstTax',
        'sgstTax',
        'igstTax',
        'ugstTax',
        'transporter',
        'vehicleNo',
        'lrNo',
        'paymentTerm',
        'basicTotalAmount',
        'subTotalAmount',
        'cgstTotalAmount',
        'sgstTotalAmount',
        'igstTotalAmount',
        'ugstTotalAmount',
        'subTotalAmount1',
        'grandTotalAmount',
    ];
    protected $hidden = ['updated_at'];
}
