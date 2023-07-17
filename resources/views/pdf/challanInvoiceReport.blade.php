@php
    $challanCalculation = new App\Services\challanAndInvoice\ChallanReportCalculation($challanData->_id);
    $billingTemplates = $challanCalculation->getBillingTemplate();

    if (empty($billingTemplates)){
        throw new Exception('Please fill billing term.');
    }
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Challan Report</title>
</head>
<body>
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: right;" width="55%"><h3>
                            <b><i>{{ strtoupper($challanData->invoiceType) }}</i></b>
                        </h3></td>
                    <td style="text-align: right;" width="45%"><p><b>{{ $copySelection }}</b></p></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td width="50%">
            <span><b>GSTIN: {{ $challanData->company_details->gstNumber }}</b></span><br>
            <span><b>Pan: {{ $challanData->company_details->panNumber ?? null }}</b></span><br>
            <span>Bank Name: {{ $challanData->company_details->bankName }}</span><br>
            <span>Add: {{ $challanData->company_details->branchName }}</span><br>
            <span>CC A/C No: {{ $challanData->company_details->accountNumber }}, IFSC Code:{{ $challanData->company_details->ifsCode }}</span><br>
            <span><b>{{ $challanData->company_details->companyName }}</b></span><br>
            <span>{{ $challanData->company_details->address }}, {{ $challanData->company_details->city_data['city'] }}.</span><br>
            <span>State: {{ $challanData->company_details->state_data['stateCode'] }}-{{ $challanData->company_details->state_data['state'] }}, {{ $challanData->company_details->country_data['country'] }}</span>
        </td>
        <td width="50%">
            <span><b>Invoice No.: {{ $challanData->invoiceNo }}</b></span><br>
            Invoice Date : {{ $challanData->invoiceDate }}<br>
            Challan No. : {{ $challanData->challanNo }} dtd.: {{ $challanData->challanDate }}
            <br>
            Cust PO. No. : {{ $challanData->orderNo }} dtd. {{ $challanData->orderDate }}<br>
            Reverse Charge: {{ $challanData->reverseCharge == 1 ? 'Yes' : 'No' }}<br>
            @if(isset($masterGst->EwbNo))
                EWay Bill No. : {{ $masterGst->EwbNo ?? null }}<br>
            @endif
            @if(isset($masterGst->AckNo))
                Ack No. : {{ $masterGst->AckNo ?? null }}<br>
            @endif
            @if(isset($masterGst->AckDt))
                Date : {{ $masterGst->AckDt ?? null }}<br>
            @endif
            @if(isset($masterGst->Irn))
                IRN : {{ $masterGst->Irn ?? null }}<br>
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
                    <td><b>GSTIN : {{ $challanData->buyerDetails['buyerGstinNo'] }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $challanData->buyerDetails['buyerName'] }}</b></td>
                </tr>
                <tr>
                    <td>{{ $challanData->buyerDetails['buyerAddress'] }} {{ $challanData->buyer_extra_data['city']['city'] .'-' .$challanData->buyerDetails['buyerPinCode'].', '.strtoupper($challanData->buyer_extra_data['state']['state']) }}
                        , {{ strtoupper($challanData->buyer_extra_data['country']['country']) }}.
                    </td>
                </tr>
                <tr>
                    <td><b>State : {{ $challanData->buyer_extra_data['state']['stateCode'] }}
                            - {{strtoupper($challanData->buyer_extra_data['state']['state'])}}</b></td>
                </tr>
                @if(!empty($challanData->buyerDetails) && isset($challanData->buyerDetails['partyPanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($challanData->buyerDetails['partyPanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($challanData->buyerDetails['buyerKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $challanData->buyerDetails['buyerKindAttnName'] }}</td>
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
                    <td><b>GSTIN : {{ $challanData->consigneeDetails['consigneeGstinNo'] }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $challanData->consigneeDetails['consigneeName'] }}</b></td>
                </tr>
                <tr>
                    <td>{{ $challanData->consigneeDetails['consigneeAddress'] }} {{ $challanData->consignee_extra_data['city']['city'] .'-' .$challanData->consigneeDetails['consigneePinCode'].', '.strtoupper($challanData->consignee_extra_data['state']['state']) }}
                        , {{ strtoupper($challanData->consignee_extra_data['country']['country']) }}.
                    </td>
                </tr>
                <tr>
                    <td><b>State : {{ $challanData->consignee_extra_data['state']['stateCode'] }}
                            - {{strtoupper($challanData->consignee_extra_data['state']['state'])}}</b></td>
                </tr>
                @if(!empty($challanData->consigneeDetails) && isset($challanData->consigneeDetails['consigneePanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($challanData->consigneeDetails['consigneePanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($challanData->consigneeDetails['consigneeKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $challanData->consigneeDetails['consigneeKindAttnName'] }}</td>
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
                    <td><b>GSTIN : {{ $challanData->dispatchDetails['dispatchGstinNo'] }}</b></td>
                </tr>
                <tr>
                    <td><b>M/ S. {{ $challanData->dispatchDetails['dispatchName'] }}</b></td>
                </tr>
                @if(is_array($challanData->dispatchDetails['dispatchCountry']))
                    <tr>
                        <td>{{ $challanData->dispatchDetails['dispatchAddress'] }} {{ $challanData->dispatchDetails['dispatchCity']['label'] .'-' .$challanData->dispatchDetails['dispatchPinCode'].', '.strtoupper($challanData->dispatchDetails['dispatchState']['label']) }}
                            ,{{ strtoupper($challanData->dispatchDetails['dispatchCountry']['label']) }}.
                        </td>
                    </tr>
                    <tr>
                        <td><b>State : {{ $challanData->dispatchDetails['dispatchState']['code'] }}
                                - {{strtoupper($challanData->dispatchDetails['dispatchState']['label'])}}</b></td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $challanData->dispatchDetails['dispatchAddress'] }} {{ $challanData->dispatch_extra_data['city']['city'] .'-' .$challanData->dispatchDetails['dispatchPinCode'].', '.strtoupper($challanData->dispatch_extra_data['state']['state']) }}
                            ,{{ strtoupper($challanData->dispatch_extra_data['country']['country']) }}.
                        </td>
                    </tr>
                    <tr>
                        <td><b>State : {{ $challanData->dispatch_extra_data['state']['stateCode'] }}
                                - {{strtoupper($challanData->dispatch_extra_data['state']['state'])}}</b></td>
                    </tr>
                @endif
                @if(!empty($challanData->dispatchDetails) && isset($challanData->dispatchDetails['dispatchPanNo']))
                    <tr>
                        <td>PAN No. : {{ strtoupper($challanData->dispatchDetails['dispatchPanNo']) }}</td>
                    </tr>
                @endif
                @if(!empty($challanData->dispatchDetails['dispatchKindAttnName']))
                    <tr>
                        <td><b>Kind Attn:</b> {{ $challanData->dispatchDetails['dispatchKindAttnName'] }}</td>
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

    @forelse($challanData->itemsDetail as $key => $item)
        <tr>
            <td width="5%">{{ $key + 1 }}</td>
            <td width="35%">
                <table>
                    <tr><td>{{ $item->itemCode }}</td></tr>
                    @php
                        if($item->itemCustomDescription){
                        $itemCustomDescription = nl2br($item->itemCustomDescription);
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
                            <td>VALVE SR NO. : {{ $item->serialNoCode ?? null}}</td>
                        </tr>
                    @endif
                    @if($item->itemCustPartNo)
                        <tr>
                            <td>Cust Part No. : {{ $item->itemCustPartNo ?? null}}</td>
                        </tr>
                    @endif
                </table>
            </td>
            <td width="10%" style="text-align: center;">{{ $item->itemHsnSacNo ?? null}}</td>
            @if(!isset($invoiceSelectionMode) || $invoiceSelectionMode === 0)
                <td width="8%" style="text-align: center;">
                    @php
                        if ($item->igstPercentage == 0){
                            $gstPercent = number_format((float)$item->cgstPercentage + (float)$item->sgstPercentage, 2);
                        }else{
                            $gstPercent = number_format((float)$item->igstPercentage, 2);
                        }
                        echo $gstPercent;
                    @endphp
                </td>
            @endif
            <td width="6%" style="text-align: center;">{{ $item->uom_details->uom ?? null}}</td>
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
                    <td><b>Transpoter</b>: {{ $challanData->transportExportData['transporter'] ?? null }}</td>
                </tr>
                <tr>
                    <td><b>Vehicle No.</b>: {{ $challanData->transportExportData['vehicalNo'] ?? null }}</td>
                </tr>
                <tr>
                    <td><b>L.R. No.</b>: {{ $challanData->transportExportData['lrNumber'] ?? null }},<b>Date:</b> {{ $challanData->transportExportData['lrDate'] ?? null }}</td>
                </tr>
                @forelse($termAndCondition as $value)
                    <tr>
                        <td><b>{{ $value->groupName }}:</b> {!! nl2br($value->termsCondition) !!} </td>
                    </tr>
                @empty
                @endforelse
            </table>
        </td>
        <td colspan="2">
            @if(!empty($masterGst->SignedQRCode))
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $masterGst->SignedQRCode?>&amp;size=100x100"
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
            <span><b>Amount in Words : {{ get_amount_words($challanCalculation->getGrandTotal()) }}</b></span><br>
            @if($challanCalculation->getCgstAmount() != 0)
                <span><b>CGST in Words : {{ get_amount_words($challanCalculation->getCgstAmount()) }}</b></span><br>
            @endif
            @if($challanCalculation->getSgstAmount() != 0)
                <span><b>SGST in Words : {{ get_amount_words($challanCalculation->getSgstAmount()) }}</b></span><br>
            @endif
            @if($challanCalculation->getIgstAmount() != 0)
                <span><b>IGST in Words : {{ get_amount_words($challanCalculation->getIgstAmount()) }}</b></span><br>
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
{{--<br pagebreak="true"/>--}}
{{--<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <span><b>GSTIN:{{ $challanData->company_details->gstNumber }}</b></span><br>
            <span>Bank Name: {{ $challanData->company_details->bankName }}</span><br>
            <span>Add: {{ $challanData->company_details->branchName }}</span><br>
            <span>CC A/C No: {{ $challanData->company_details->accountNumber }}, IFSC Code:{{ $challanData->company_details->ifsCode }}</span><br>
            <span><b>{{ $challanData->company_details->companyName }}</b></span><br>
            <span>{{ $challanData->company_details->address }}, {{ $challanData->company_details->city_data['city'] }}.</span><br>
            <span>State: {{ $challanData->company_details->state_data['stateCode'] }}-{{ $challanData->company_details->state_data['state'] }}</span><br>
            <span>{{ $challanData->company_details->country_data['country'] }}</span>
        </td>
        <td>
            <b>Invoice No.:{{ $challanData->invoiceNo }}</b><br>
            Invoice Date : {{ date('d/m/Y', strtotime($challanData->invoiceDate)) }}<br>
            Challan No. : {{ $challanData->challanNo }} dtd.: {{ date('d/m/Y', strtotime($challanData->challanDate)) }}
            <br>
            Order No. : {{ $challanData->orderNo }} dtd. {{ date('d/m/Y', strtotime($challanData->orderDate)) }}<br>
            @if(isset($masterGst->EwbNo))
                EWay Bill No. : {{ $masterGst->EwbNo ?? null }}<br>
            @endif
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <span>Bill to Party:</span><br>
            <span><b>GSTIN : {{ $challanData->partyDetails['partyGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->partyDetails['PartyName'] }}</b></span><br>
            <span style="text-align: justify">{{ $challanData->partyDetails['partyAddress'] }}</span><br>
            <span>{{ $challanData->party_extra_data['city']['city'] .'-' .$challanData->partyDetails['partyPinCode'].', '.strtoupper($challanData->party_extra_data['state']['state']) }}</span><br>
            <span><b>State : {{ $challanData->party_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->party_extra_data['state']['state'])}}</b></span><br>
            <span>{{ strtoupper($challanData->party_extra_data['country']['country']) }}</span><br>
            <span>PAN No. : {{ strtoupper($challanData->partyDetails['partyPinCode']) }}</span>
        </td>
        <td>
            <span>Ship to Party:</span><br>
            <span><b>GSTIN : {{ $challanData->buyerDetails['buyerGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->buyerDetails['buyerName'] }}</b></span><br>
            <span style="text-align: justify">{{ $challanData->buyerDetails['buyerAddress'] }}</span><br>
            <span>{{ $challanData->buyer_extra_data['city']['city'] .'-' .$challanData->buyerDetails['buyerPinCode'].', '.strtoupper($challanData->buyer_extra_data['state']['state']) }}</span><br>
            <span><b>State : {{ $challanData->buyer_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->buyer_extra_data['state']['state'])}}</b></span><br>
            <span>{{ strtoupper($challanData->buyer_extra_data['country']['country']) }}</span><br>
            <span>PAN No. : {{ strtoupper($challanData->buyerDetails['buyerPinCode']) }}</span>
        </td>
        <td>
            <span>Dispatch:</span><br>
            <span><b>GSTIN : {{ $challanData->dispatchDetails['dispatchGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->dispatchDetails['dispatchName'] }}</b></span><br>
            <span style="text-align: justify;">
                {{ str_replace(',','\n',$challanData->dispatchDetails['dispatchAddress']) }}
            </span><br>
            <span>{{ $challanData->dispatch_extra_data['city']['city'] .'-' .$challanData->dispatchDetails['dispatchPinCode'].', '.strtoupper($challanData->dispatch_extra_data['state']['state']) }}</span><br>
            <span><b>State : {{ $challanData->dispatch_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->dispatch_extra_data['state']['state'])}}</b></span><br>
            <span>{{ strtoupper($challanData->dispatch_extra_data['country']['country']) }}</span><br>
            <span>PAN No. : {{ strtoupper($challanData->dispatchDetails['dispatchPanNo']) }}</span>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <th width="5%">No.</th>
        <th width="30%">Item Details</th>
        <th width="10%">HSN/SAC</th>
        <th width="10%">GST%</th>
        <th width="10%">UOM</th>
        <th width="10%">Quantity</th>
        <th width="10%">Rate</th>
        <th width="15%">Amount(INR)</th>
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
</table>--}}
</body>
</html>
{{--<script>
    import Table from "../../js/src/views/table/bs-table/Table";
    export default {
        components: {Table}
    }
</script>--}}
