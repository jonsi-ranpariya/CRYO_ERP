<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Challan Report</title>
    <style>
        .textUppercase {
            text-transform: uppercase;
        }
    </style>
</head>
@php
$nbsp = '<br>'.str_repeat('&nbsp;',2);
$totalQtyCount = [];
$netWeightCount = [];
$grossWeightCount = [];
@endphp
<body>
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: right;" width="55%"><h3><b><i>PACKING LIST</i></b></h3></td>
                    {{--<td style="text-align: right;" width="45%"><p><b>{{ $copySelection }}</b></p></td>--}}
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
            <span>CC A/C No: {{--{{ $challanData->company_details->accountNumber }}--}}35654099041, IFSC Code:{{ $challanData->company_details->ifsCode }}</span><br>
            <span><b>{{ $challanData->company_details->companyName }}</b></span><br>
            <span>{{ $challanData->company_details->address }}, {{ $challanData->company_details->city_data['city'] }}.</span><br>
            <span>State: {{ $challanData->company_details->state_data['stateCode'] }}-{{ $challanData->company_details->state_data['state'] }}</span><br>
            <span>{{ $challanData->company_details->country_data['country'] }}</span>
        </td>
        <td width="50%">
            <span><b>Invoice No.:{{ $challanData->invoiceNo }}</b></span><br>
            Invoice Date : {{ $challanData->invoiceDate }}<br>
            Challan No. : {{ $challanData->challanNo }} dtd.: {{ $challanData->challanDate }}
            <br>
            Order No. : {{ $challanData->orderNo }} dtd. {{ $challanData->orderDate }}<br>
            Vehicle No.: {{ $challanData->transportExportData['vehicalNo'] ?? null }}
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <td>
            <span>Buyer:</span><br>
            <span><b>GSTIN : {{ $challanData->partyDetails['partyGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->partyDetails['PartyName'] }}</b></span><br>
            <span>{{ $challanData->partyDetails['partyAddress'] }}</span><br>
            <span>{{ $challanData->party_extra_data['city']['city'] .'-' .$challanData->partyDetails['partyPinCode'].', '.strtoupper($challanData->party_extra_data['state']['state']) }}</span>,
            <span>{{ strtoupper($challanData->party_extra_data['country']['country']) }}</span><br>
            <span><b>State : {{ $challanData->party_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->party_extra_data['state']['state'])}}</b></span><br>
            @if(!empty($challanData->partyDetails) && isset($challanData->partyDetails['partyPanNo']))
                <span>PAN No. : {{ strtoupper($challanData->partyDetails['partyPanNo']) }}</span>
            @endif
        </td>
        <td>
            <span>Consingnee:</span><br>
            <span><b>GSTIN : {{ $challanData->buyerDetails['buyerGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->buyerDetails['buyerName'] }}</b></span><br>
            <span style="text-align: justify">{{ $challanData->buyerDetails['buyerAddress'] }}</span><br>
            <span>{{ $challanData->buyer_extra_data['city']['city'] .'-' .$challanData->buyerDetails['buyerPinCode'].', '.strtoupper($challanData->buyer_extra_data['state']['state']) }}</span>,
            <span>{{ strtoupper($challanData->buyer_extra_data['country']['country']) }}</span><br>
            <span><b>State : {{ $challanData->buyer_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->buyer_extra_data['state']['state'])}}</b></span><br>
            @if(!empty($challanData->buyerDetails) && isset($challanData->buyerDetails['partyPanNo']))
                <span>PAN No. : {{ strtoupper($challanData->buyerDetails['partyPanNo']) }}</span>
            @endif
        </td>
        <td>
            <span>Dispatch:</span><br>
            <span><b>GSTIN : {{ $challanData->dispatchDetails['dispatchGstinNo'] }}</b></span><br>
            <span><b>M/ S. {{ $challanData->dispatchDetails['dispatchName'] }}</b></span><br>
            <span style="text-align: justify;">{{ $challanData->dispatchDetails['dispatchAddress'] }}</span><br>
            <span>{{ $challanData->dispatch_extra_data['city']['city'] .'-' .$challanData->dispatchDetails['dispatchPinCode'].', '.strtoupper($challanData->dispatch_extra_data['state']['state']) }}</span>,
            <span>{{ strtoupper($challanData->dispatch_extra_data['country']['country']) }}</span><br>
            <span><b>State : {{ $challanData->dispatch_extra_data['state']['stateCode'] }} - {{strtoupper($challanData->dispatch_extra_data['state']['state'])}}</b></span><br>
            <span>PAN No. : {{ strtoupper($challanData->dispatchDetails['dispatchPanNo']) }}</span>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="5px">
    <tr>
        <th width="5%"><span class="textUppercase"><b>No</b></span></th>
        <th width="40%"><span class="textUppercase"><b>Description</b></span></th>
        <th width="10%"><span class="textUppercase" style="text-align: center"><b>MSN No.</b></span></th>
        <th width="10%"><span class="textUppercase" style="text-align: center"><b>Customer Part No</b></span></th>
        <th width="10%"><span class="textUppercase" style="text-align: center"><b>Qty</b></span></th>
        <th width="15%"><span class="textUppercase" style="text-align: center"><b>Size</b></span></th>
        <th width="10%"><span class="textUppercase" style="text-align: center"><b>Net Weight</b></span></th>
    </tr>
    @forelse($packingList as $key => $item)
        <tr>
            <td width="5%">{{ $key + 1 }}</td>
            <td width="40%">{{ $item->itemDescription }}</td>
            <td width="10%" style="text-align: center">{{ $item->msnNumber }}</td>
            <td width="10%" style="text-align: center">{{ $item->custPartNo }}</td>
            <td width="10%" style="text-align: center">{{ $item->totalQuantity }}</td>
            <td width="15%" style="text-align: center">{{ $item->dimOfBox }}</td>
            <td width="10%" style="text-align: center">{{ $item->totalNetWeight }} kg</td>
        </tr>
        @php
            array_push($totalQtyCount, $item->totalQuantity);
            array_push($netWeightCount, $item->totalNetWeight);
            array_push($grossWeightCount, $item->totalGsWeight);
        @endphp
    @empty
    @endforelse
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <span><b>Net Weight: </b>{{ array_sum($netWeightCount) }} kg</span><br>
            <span><b>Gross Weight: </b>{{ array_sum($grossWeightCount) }} kg</span><br>
            <span><b>Total Case: </b>{{ count($packingList) }}</span><br>
            <span><b>Qty: </b>{{ array_sum($totalQtyCount) }}</span>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <span><b>Receiver's Sign.</b></span>
        </td>
        <td width="50%">
            <span><b>For,IWI CRYOGENIC VAPORIZATION SYSTEMS (I) PVT. LTD.</b></span>
            <br><br><br><br>
            <span>Authorised Signatory</span>
        </td>
    </tr>
</table>
</body>
</html>
