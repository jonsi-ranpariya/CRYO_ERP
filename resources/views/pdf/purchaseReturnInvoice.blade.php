@php
    $purchaseReturnService = new \App\Services\purchase\PurchaseReturnService($purchaseReturnData->_id);
    $billingTemplates = $purchaseReturnService->salesReturnBillingTerm();
@endphp


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DEBIT NOTE</title>
</head>
<body>
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: right;" width="55%">
                        <h3>
                            <b><i>DEBIT NOTE</i></b>
                        </h3>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td width="50%">
            <span><b>GSTIN: {{ $purchaseReturnData->company_detail->gstNumber }}</b></span><br>
            <span><b>Pan: {{ $purchaseReturnData->company_detail->panNumber ?? null }}</b></span><br>
            <span>Bank Name: {{ $purchaseReturnData->company_detail->bankName }}</span><br>
            <span>Add: {{ $purchaseReturnData->company_detail->branchName }}</span><br>
            <span>CC A/C No: {{ $purchaseReturnData->company_detail->accountNumber }}, IFSC Code:{{ $purchaseReturnData->company_detail->ifsCode }}</span><br>
            <span><b>{{ $purchaseReturnData->company_detail->companyName }}</b></span><br>
            <span>{{ $purchaseReturnData->company_detail->address }}, {{ $purchaseReturnData->company_detail->city_data['city'] }}.</span><br>
            <span>State: {{ $purchaseReturnData->company_detail->state_data['stateCode'] }}-{{ $purchaseReturnData->company_detail->state_data['state'] }}, {{ $purchaseReturnData->company_detail->country_data['country'] }}</span>
        </td>
        <td width="50%">
            <span><b>Invoice No.: {{ $purchaseReturnData->prInvoiceNo }}</b></span><br>
            Invoice Date : {{ $purchaseReturnData->prInvoiceDate }}<br>
            Cust PO. No. : {{ $purchaseReturnData->prPurchaseBillNo }} dtd. {{ $purchaseReturnData->prPurchaseDate }}
            <br>
            Reverse Charge: {{ $purchaseReturnData->prReverseCharge == 1 ? 'Yes' : 'No' }}<br>
            @if(!empty($purchaseReturnData->prReason))
            Reason: {{ $purchaseReturnData->prReason }}<br>
            @endif
            @if(isset($purchaseReturnData->master_gst['EwbNo']))
                EWay Bill No. : {{ $purchaseReturnData->master_gst['EwbNo'] ?? null }}<br>
            @endif
            @if(isset($purchaseReturnData->master_gst['AckNo']))
                Ack No. : {{ $purchaseReturnData->master_gst['AckNo'] ?? null }}<br>
            @endif
            @if(isset($purchaseReturnData->master_gst['AckDt']))
                Date : {{ $purchaseReturnData->master_gst['AckDt'] ?? null }}<br>
            @endif
            @if(isset($purchaseReturnData->master_gst['Irn']))
                IRN : {{ $purchaseReturnData->master_gst['Irn'] ?? null }}<br>
            @endif
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <td>
            <table>
                <tr>
                    <td>Buyer:</td>
                </tr>
                <tr>
                    <td><b>GSTIN : {{ $purchaseReturnData->buyerDetails['buyerGstinNo'] }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $purchaseReturnData->buyerDetails['buyerName'] }}</b></td>
                </tr>
                <tr>
                    <td>{{ $purchaseReturnData->buyerDetails['buyerAddress'] }} {{ $purchaseReturnData->buyerDetails['buyerCityName'] .'-' .$purchaseReturnData->buyerDetails['buyerPinCode'].', '.strtoupper($purchaseReturnData->buyerDetails['buyerStateName']) }}
                        , {{ strtoupper($purchaseReturnData->buyerDetails['buyerCountryName']) }}.
                    </td>
                </tr>
                <tr>
                    <td><b>State : {{ $purchaseReturnData->buyerDetails['buyerStateCode'] }}
                            - {{$purchaseReturnData->buyerDetails['buyerStateName']}}</b></td>
                </tr>
                @if(!empty($purchaseReturnData->buyerDetails) && isset($purchaseReturnData->buyerDetails['partyPanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($purchaseReturnData->buyerDetails['partyPanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($purchaseReturnData->buyerDetails['buyerKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $purchaseReturnData->buyerDetails['buyerKindAttnName'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>Consingnee:</td>
                </tr>
                <tr>
                    <td><b>GSTIN : {{ $purchaseReturnData->consigneeDetails['consigneeGstinNo'] ?? null }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $purchaseReturnData->consigneeDetails['consigneeName'] }}</b></td>
                </tr>
                <tr>
                    <td>{{ $purchaseReturnData->consigneeDetails['consigneeAddress'] }}
                        {{ $purchaseReturnData->consigneeDetails['consigneeCityName'] .'-' .$purchaseReturnData->consigneeDetails['consigneePinCode'].', '.strtoupper($purchaseReturnData->consigneeDetails['consigneeStateName']) }}
                        , {{ strtoupper($purchaseReturnData->consigneeDetails['consigneeCountryName']) }}.
                    </td>
                </tr>
                <tr>
                    <td><b>State : {{ $purchaseReturnData->consigneeDetails['consigneeStateCode'] }}
                            - {{strtoupper($purchaseReturnData->consigneeDetails['consigneeStateName'])}}</b></td>
                </tr>
                @if(!empty($purchaseReturnData->consigneeDetails) && isset($purchaseReturnData->consigneeDetails['consigneePanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($purchaseReturnData->consigneeDetails['consigneePanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($purchaseReturnData->consigneeDetails['consigneeKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $purchaseReturnData->consigneeDetails['consigneeKindAttnName'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>Dispatch:</td>
                </tr>
                <tr>
                    <td><b>GSTIN : {{ $purchaseReturnData->dispatchDetails['dispatchGstinNo'] }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $purchaseReturnData->dispatchDetails['dispatchName'] }}</b></td>
                </tr>
                <tr>
                    <td>{{ $purchaseReturnData->dispatchDetails['dispatchAddress'] }} {{ $purchaseReturnData->dispatchDetails['dispatchCityName'] .'-' .$purchaseReturnData->dispatchDetails['dispatchPinCode'].', '.strtoupper($purchaseReturnData->dispatchDetails['dispatchStateName']) }}
                        ,{{ strtoupper($purchaseReturnData->dispatchDetails['dispatchCountryName']) }}.
                    </td>
                </tr>
                <tr>
                    <td><b>State : {{ $purchaseReturnData->dispatchDetails['dispatchStateCode'] }}
                            - {{strtoupper($purchaseReturnData->dispatchDetails['dispatchStateName'])}}</b></td>
                </tr>
                @if(!empty($purchaseReturnData->dispatchDetails) && isset($purchaseReturnData->dispatchDetails['dispatchPanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($purchaseReturnData->dispatchDetails['dispatchPanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($purchaseReturnData->dispatchDetails['dispatchKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $purchaseReturnData->dispatchDetails['dispatchKindAttnName'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <th width="5%"><b>No.</b></th>
        <th width="35%"><b>Item Details</b></th>
        <th width="10%" style="text-align: center;"><b>HSN/SAC</b></th>
        @if(!isset($invoiceSelectionMode) || $invoiceSelectionMode === 0)
            <th width="8%" style="text-align: center;"><b>GST%</b></th>
        @endif
        <th width="6%" style="text-align: center;"><b>UOM</b></th>
        <th width="10%" style="text-align: center;"><b>Quantity</b></th>
        <th width="12%" style="text-align: center;"><b>Rate</b></th>
        @if($invoiceSelectionMode === 1)
            <th width="8%" style="text-align: center;"><b>Discount</b></th>
        @endif
        <th width="14%" style="text-align: center;"><b>Amount(INR)</b></th>
    </tr>

    @forelse($purchaseReturnItems as $key => $item)
        <tr>
            <td width="5%">{{ $key + 1 }}</td>
            <td width="35%">
                <table>
                    @php
                        if($item->itemCustDescription){
                        $itemCustomDescription = nl2br($item->itemCustDescription);
                        $itemCustomDescriptions = explode('<br />', $itemCustomDescription);
                            foreach ($itemCustomDescriptions as $value){
                                echo "<tr><td>$value</td></tr>";
                            }
                        }else{
                            echo "<tr><td>$item->itemDescription</td></tr>";
                        }
                    @endphp
                    @if (!empty($item->itemMsnNumber))
                        <tr>
                            <td>MFG. SR. NO.: {{ $item->itemMsnNumber }}</td>
                        </tr>
                    @endif
                    @php
                        $itemDescription = nl2br($item->itemDetailDescription);
                        $itemDescriptions = explode('<br />', $itemDescription);
                    @endphp
                    @if(!empty($itemDescriptions))
                        @forelse($itemDescriptions as $newKey => $value)
                            @if(count($itemDescriptions) == $newKey+1)
                                <tr>
                                    <td>{{ $value }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endif
                        @empty
                        @endforelse
                    @endif
                    @if($item->itemDrawingNo)
                        <tr>
                            <td>Drg NO.: {{ $item->itemDrawingNo }}</td>
                        </tr>
                    @endif
                    @if($item->serialNoCode)
                        <tr>
                            <td>VALVE SR NO. : {{ $item->serialNoCode }}</td>
                        </tr>
                    @endif
                    @if($item->itemCustPartNo)
                        <tr>
                            <td>Cust Part No. : {{ $item->itemCustPartNo }}</td>
                        </tr>
                    @endif
                </table>
            </td>
            <td width="10%" style="text-align: center;">{{ $item->itemHsnNumber ?? null}}</td>
            @if(!isset($invoiceSelectionMode) || $invoiceSelectionMode === 0)
                <td width="8%" style="text-align: center;">
                    @php
                        if ($item->itemIgstPercent == 0){
                            $gstPercent = number_format((float)$item->itemCgstPercent + (float)$item->itemSgstPercent, 2);
                        }else{
                            $gstPercent = number_format((float)$item->itemIgstPercent, 2);
                        }
                        echo $gstPercent;
                    @endphp
                </td>
            @endif
            <td width="6%" style="text-align: center;">{{ $item->uom_detail->uom ?? null}}</td>
            <td width="10%" style="text-align: right;">{{ number_format((float)$item->itemQuantity, 3) }}</td>
            <td width="12%" style="text-align: right;">{{ number_format((float)$item->itemRate, 2) }}</td>
            @if($invoiceSelectionMode === 1)
                <td width="8%" style="text-align: center;">
                    {{ number_format((float)$item->itemDiscount, 2) }}%
                </td>
            @endif
            <td width="14%"
                style="text-align: right;">{{ number_format((float)($item->itemQuantity * $item->itemRate) - $item->itemDiscountValue, 2) }}</td>
        </tr>
    @empty
    @endforelse
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td><b>Transpoter</b>: {{ $purchaseReturnData->transportExportData['transporter'] ?? null }}</td>
                </tr>
                <tr>
                    <td><b>Vehicle No.</b>: {{ $purchaseReturnData->transportExportData['vehicalNo'] ?? null }}</td>
                </tr>
                <tr>
                    <td><b>L.R. No.</b>: {{ $purchaseReturnData->transportExportData['lrNumber'] ?? null }}, <b>Date
                            :</b> {{ $purchaseReturnData->transportExportData['lrDate'] ? date('d/m/Y', strtotime($purchaseReturnData->transportExportData['lrDate'])) : null }}
                    </td>
                </tr>
                @forelse($termAndCondition as $value)
                    <tr>
                        <td><b>{{ $value->groupName }}:</b> {!! nl2br($value->termAndCondition) !!} </td>
                    </tr>
                @empty
                @endforelse
            </table>
        </td>
        <td colspan="2">
            @if(!empty($purchaseReturnData->master_gst['SignedQRCode']))
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $purchaseReturnData->master_gst['SignedQRCode']?>&amp;size=100x100"
                    alt="challan" width="70" height="70"
                    style="padding-right: 20px">
            @endif
        </td>
        <td colspan="2" style="text-align: right;">
            @forelse($billingTemplates as $key => $billingTemplate)
                @if($key == 'Basic Amount'|| $key == 'Grand Total')
                    {!! "<span><b>$key</b></span><br>" !!}
                @elseif($billingTemplate != 0)
                    {!! "<span>$key</span><br>" !!}
                @endif
            @empty
            @endforelse
        </td>
        <td style="text-align: right;">
            @forelse($billingTemplates as $key => $billingTemplate)
                @if($key == 'Basic Amount'|| $key == 'Grand Total')
                    {!! "<span><b>". number_format((float)$billingTemplate,2)."</b></span><br>" !!}
                @elseif($billingTemplate != 0)
                    {!! "<span>". number_format((float)$billingTemplate,2)."</span><br>" !!}
                @endif
            @empty
            @endforelse
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <span><b>Amount in Words : {{ get_amount_words($purchaseReturnService->getGrandTotal()) }}</b></span><br>
            @if($purchaseReturnService->getCgstAmount() != 0)
                <span><b>CGST in Words : {{ get_amount_words($purchaseReturnService->getCgstAmount()) }}</b></span><br>
            @endif
            @if($purchaseReturnService->getSgstAmount() != 0)
                <span><b>SGST in Words : {{ get_amount_words($purchaseReturnService->getSgstAmount()) }}</b></span><br>
            @endif
            @if($purchaseReturnService->getIgstAmount() != 0)
                <span><b>IGST in Words : {{ get_amount_words($purchaseReturnService->getIgstAmount()) }}</b></span><br>
            @endif
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <span style="text-align: justify">
                Certified that Particulars given above are true and correct and the amount indecated represents the price
            actually charged and
            that there is no flow of additional consideratin directly or indirectly from the buyer. Subject to VADODARA
                Jurisdiction.
            </span>
        </td>
        <td><span><b>For,IWI CRYOGENIC VAPORIZATION SYSTEMS (I) PVT. LTD.</b></span><br><br><br><br><br><br><br>
            <span>Authorised Signatory</span>
        </td>
    </tr>
</table>
</body>
</html>
