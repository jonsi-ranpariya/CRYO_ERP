@php
    $salesReturnBillingTerm = new \App\Services\sales\SalesReturnCalculation($salesReturnId);
@endphp
    <!DOCTYPE html>
<html>
<body>
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: center;" width="100%"><h3><b>CREDIT NOTE</b></h3></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td width="50%">
            <span><b>GSTIN: {{ $salesReturnData->company_detail->gstNumber }}</b></span><br>
            <span><b>Pan: {{ $salesReturnData->company_detail->panNumber ?? null }}</b></span><br>
            <span>Bank Name: {{ $salesReturnData->company_detail->bankName }}</span><br>
            <span>Add: {{ $salesReturnData->company_detail->branchName }}</span><br>
            <span>CC A/C No: {{ $salesReturnData->company_detail->accountNumber }}, IFSC Code:{{ $salesReturnData->company_detail->ifsCode }}</span><br>
            <span><b>{{ $salesReturnData->company_detail->companyName }}</b></span><br>
            <span>{{ $salesReturnData->company_detail->address }}, {{ $salesReturnData->company_detail->city_data['city'] }}.</span><br>
            <span>State: {{ $salesReturnData->company_detail->state_data['stateCode'] }}-{{ $salesReturnData->company_detail->state_data['state'] }}, {{ $salesReturnData->company_detail->country_data['country'] }}</span>
        </td>
        <td width="50%">
            <span><b>Credit Note No.:{{ $salesReturnData->salesReturnNo }}</b></span><br>
            Credit Note Date : {{ $salesReturnData->salesReturnDate }}<br>
            Original Inv No. : {{ $salesReturnData->salesReturnInvoiceNo ?? $salesReturnData->manualInvoiceNumber }}<br>
            Original Inv Date : {{ $salesReturnData->salesReturnInvoiceDate }}<br>
            Return Reason : {{ $salesReturnData->salesReturnReason }}<br><br>
            @if(isset($salesReturnData->master_gst['AckNo']))
                Ack No. : {{ $salesReturnData->master_gst['AckNo'] }}<br>
            @endif
            @if(isset($salesReturnData->master_gst['AckDt']))
                Date : {{ date("d/m/Y H:i:s", strtotime($salesReturnData->master_gst['AckDt'])) }}<br>
            @endif
            @if(isset($salesReturnData->master_gst['Irn']))
                IRN : {{ $salesReturnData->master_gst['Irn'] }}<br>
            @endif
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <td>
            <span>Buyer:</span><br>
            <span><b>GSTIN : {{ $salesReturnData->buyerDetails['buyerGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $salesReturnData->buyerDetails['buyerName'] }}</b></span><br>
            <span>{{ $salesReturnData->buyerDetails['buyerAddress'] }}</span><br>
            <span>{{ $salesReturnData->buyerDetails['buyerCityName'] .'-' .$salesReturnData->buyerDetails['buyerPinCode'].', '.strtoupper($salesReturnData->buyerDetails['buyerStateName']) }}</span>,
            <span>{{ strtoupper($salesReturnData->buyerDetails['buyerCountryName']) }}</span><br>
            <span><b>State : {{ $salesReturnData->buyerDetails['buyerStateCode'] }} - {{strtoupper($salesReturnData->buyerDetails['buyerStateName'])}}</b></span><br>
            @if(!empty($salesReturnData->buyerDetails) && isset($salesReturnData->buyerDetails['buyerPanNo']))
                <span>PAN No. : {{ strtoupper($salesReturnData->buyerDetails['buyerPanNo']) }}</span><br>
            @endif
            @if(!empty($salesReturnData->buyerDetails) && isset($salesReturnData->buyerDetails['buyerPhoneNo']))
                <span>Phone No. : {{ strtoupper($salesReturnData->buyerDetails['buyerPhoneNo']) }}</span><br>
            @endif
            @if(!empty($salesReturnData->buyerDetails['buyerKindAttnName']))
                <span><b>Kind Attn:</b> {{ $salesReturnData->buyerDetails['buyerKindAttnName'] }}</span><br>
            @endif
        </td>
        <td>
            <span>Consingnee:</span><br>
            <span><b>GSTIN : {{ $salesReturnData->consigneeDetails['consigneeGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $salesReturnData->consigneeDetails['consigneeName'] }}</b></span><br>
            <span style="text-align: justify">{{ $salesReturnData->consigneeDetails['consigneeAddress'] }}</span><br>
            <span>{{ $salesReturnData->consigneeDetails['consigneeCityName'] .'-' .$salesReturnData->consigneeDetails['consigneePinCode'].', '.strtoupper($salesReturnData->consigneeDetails['consigneeCityName']) }}</span>,
            <span>{{ strtoupper($salesReturnData->consigneeDetails['consigneeCountryName']) }}</span><br>
            <span><b>State : {{ $salesReturnData->consigneeDetails['consigneeStateCode'] }} - {{strtoupper($salesReturnData->consigneeDetails['consigneeStateName'])}}</b></span><br>
            @if(!empty($salesReturnData->consigneeDetails) && isset($salesReturnData->consigneeDetails['consigneePanNo']))
                <span>PAN No. : {{ strtoupper($salesReturnData->consigneeDetails['consigneePanNo']) }}</span><br>
            @endif
            @if(!empty($salesReturnData->consigneeDetails) && isset($salesReturnData->consigneeDetails['consigneePhoneNo']))
                <span>Phone No. : {{ strtoupper($salesReturnData->consigneeDetails['consigneePhoneNo']) }}</span><br>
            @endif
            @if(!empty($salesReturnData->consigneeDetails['consigneeKindAttnName']))
                <span><b>Kind Attn:</b> {{ $salesReturnData->consigneeDetails['consigneeKindAttnName'] }}</span><br>
            @endif
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <th width="5%" style="text-align: center"><b>No</b></th>
        <th width="35%"><b>Item Description</b></th>
        <th width="10%"><b>HSN/SAC</b></th>
        <th width="7%"><b>GST</b></th>
        <th width="7%"><b>UOM</b></th>
        <th width="10%" style="text-align: right"><b>Quantity</b></th>
        <th width="13%" style="text-align: right"><b>Rate</b></th>
        <th width="13%" style="text-align: right"><b>Amount</b></th>
    </tr>
    @forelse($salesReturnItems as $key => $item)
        <tr>
            <td width="5%" style="text-align: center">{{ $key+1 }}</td>
            <td width="35%">
                @php
                    if($item->itemCustomDescription){
                    $itemCustomDescription = nl2br($item->itemCustomDescription);
                    $itemCustomDescriptions = explode('<br />', $itemCustomDescription);
                        foreach ($itemCustomDescriptions as $value){
                            echo "<span> $value </span><br>";
                        }
                    }else{
                        echo "<span> $item->itemName </span><br>";
                    }
                @endphp
                @php
                    $itemDescription = nl2br($item->itemDetailDescription);
                    $itemDescriptions = explode('<br />', $itemDescription);
                @endphp
                @if(!empty($itemDescriptions))
                    @forelse($itemDescriptions as $index => $value)
                        <span>{{ $value }}</span><br>
                    @empty
                    @endforelse
                @endif
                @if($item->itemDrawingNo)
                    <span>Drg NO.: {{ $item->itemDrawingNo }}</span><br>
                @endif
                @if($item->serialNoCode)
                    <span>VALVE SR NO. : {{ $item->serialNoCode }}</span><br>
                @endif
                @if($item->itemCustPartNo)
                    <span>Cust Part No. : {{ $item->itemCustPartNo }}</span><br>
                @endif
                @if (!empty($item->itemMsnNumber))
                    <span>MSN No.: {{ $item->itemMsnNumber }}</span>
                @endif
            </td>
            <td width="10%">{{ $item->itemHsnSacNo }}</td>
            <td width="7%">
                @php
                    if($item->igstPercentage !== 0){
                        echo $item->igstPercentage."%";
                    }else{
                        echo $item->cgstPercentage + $item->sgstPercentage."%";
                    }
                @endphp
            </td>
            <td width="7%">{{ $item->uom_details->uom }}</td>
            <td width="10%" style="text-align: right">{{ round($item->itemQuantity,3) }}</td>
            <td width="13%" style="text-align: right">{{ number_format($item->itemRate,2) }}</td>
            <td width="13%" style="text-align: right">{{ number_format($item->itemAmount,2) }}</td>
        </tr>
    @empty
    @endforelse
    <tr>
        <td colspan="3">
            <span><b>Transpoter</b>: {{ $salesReturnData->transportExportData['transporter'] ?? null }}</span><br>
            <span><b>Vehicle No.</b>: {{ $salesReturnData->transportExportData['vehicalNo'] ?? null }}</span><br>
            <span><b>L.R. No.</b>: {{ $salesReturnData->transportExportData['lrNumber'] ?? null }}, <b>Date :</b> {{ $salesReturnData->transportExportData['lrDate'] }}</span><br>
        </td>
        <td colspan="2">
            @if(!empty($salesReturnData->master_gst['SignedQRCode']))
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $salesReturnData->master_gst['SignedQRCode']?>&amp;size=100x100"
                    alt="challan" width="70" height="70"
                    style="padding-right: 20px">
            @endif
        </td>
        <td colspan="2" style="text-align: right;">
            @forelse($salesReturnBillingTerm->salesReturnBillingTerm() as $key => $billingTemplate)
                @if($key == 'Basic Amount'|| $key == 'Grand Total')
                    {!! "<span><b>$key</b></span><br>" !!}
                @elseif($billingTemplate != 0)
                    {!! "<span>$key</span><br>" !!}
                @endif
            @empty
            @endforelse
        </td>
        <td style="text-align: right;">
            @forelse($salesReturnBillingTerm->salesReturnBillingTerm() as $key => $billingTemplate)
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
            <span><b>Amount in Words : {{ get_amount_words($salesReturnBillingTerm->getGrandTotal()) }}</b></span><br>
            @if($salesReturnBillingTerm->getCgstAmount() != 0)
                <span><b>CGST in Words : {{ get_amount_words($salesReturnBillingTerm->getCgstAmount()) }}</b></span><br>
            @endif
            @if($salesReturnBillingTerm->getSgstAmount() != 0)
                <span><b>SGST in Words : {{ get_amount_words($salesReturnBillingTerm->getSgstAmount()) }}</b></span><br>
            @endif
            @if($salesReturnBillingTerm->getIgstAmount() != 0)
                <span><b>IGST in Words : {{ get_amount_words($salesReturnBillingTerm->getIgstAmount()) }}</b></span><br>
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
        <td><span><b>For,IWI CRYOGENIC VAPORIZATION SYSTEMS (I) PVT. LTD.</b></span><br><br><br><br>
            <span>Authorised Signatory</span>
        </td>
    </tr>
</table>
</body>
</html>
