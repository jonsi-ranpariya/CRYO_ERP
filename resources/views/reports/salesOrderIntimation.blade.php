<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SALES ORDER ACKNOWLEDGEMENT</title>
</head>
<body>
<!-- Start Main Title -->
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: right;" width="65%"><h3><b>SALES ORDER INTIMATION</b></h3></td>
                    <td style="text-align: right;" width="35%"><p><b>CEPL-MKT-FRM07</b></p></td>
                </tr>
                <tr>
                    <td style="text-align: center;" width="100%"><p>(Product Order)</p></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Main Title -->
<!-- Start Top Area -->
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <table>
                <tr>
                    @if($request->print_customer_name == 1)
                        <td width="100%"><b>Customer
                                : {{ $salesOrder->sellToPartyCustomerCode .' - '. $salesOrder->sellToPartyCustomerName}}</b>
                        </td>
                    @endif
                    @if($request->print_customer_name == 2)
                        <td width="100%"><b>Customer
                                : {{ $salesOrder->sellToPartyCustomerCode }}</b>
                        </td>
                    @endif
                    @if($request->print_customer_name == 3)
                        <td width="100%"><b>Customer
                                : {{ $salesOrder->sellToPartyCustomerCode.' - '. $salesOrder->sellToPartyCustomerName }}</b>
                            <br>@php echo str_repeat('&nbsp;', 19) @endphp {{ $salesOrder?->partyDetail['partyDetailAddress'] ?? null }}
                            ,
                            <br>@php echo str_repeat('&nbsp;', 19) @endphp {{ $salesOrder?->partyDetail['partyDetailCity'] }}
                            - {{ $salesOrder?->partyDetail['partyDetailPinCode'] }}
                            , {{ $salesOrder?->partyDetail['partyDetailState'] }}
                            <br>@php echo str_repeat('&nbsp;', 19) @endphp {{ $salesOrder?->partyDetail['partyDetailCountry'] }}
                            <br>@php echo str_repeat('&nbsp;', 19) @endphp Phone No.
                            : {{ $salesOrder?->partyDetail['partyDetailPhoneNo'] }}
                            <br>@php echo str_repeat('&nbsp;', 19) @endphp Email
                            : {{ $salesOrder?->partyDetail['partyDetailEmailId'] }}
                            <br><b>Kind Attn. :</b> {{ $salesOrder->kindAttnName }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td width="100%">P.O. Number : {{ $salesOrder->customerPoNo }}</td>
                </tr>
                <tr>
                    <td width="100%">S.O. Number : {{ $salesOrder->salesOrderNo }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td width="100%"><b>City : {{ $salesOrder?->partyDetail['partyDetailCity'] ?? null }}</b></td>
                </tr>
                <tr>
                    <td width="100%">P.O. Date : {{ $salesOrder->salesOrderPoDate }}</td>
                </tr>
                <tr>
                    <td width="100%">S.O. Date : {{ $salesOrder->salesOrderDate }}</td>
                </tr>
                @if($request->filled('print_common_del'))
                    <tr>
                        <td width="100%">Del Date: {{ $salesOrder->salesOrderCommittedDate }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>
<!-- End Top Area -->
<!-- Start Items Area -->
<table border="1px" cellpadding="3px">
    <tr>
        <th width="5%" style="text-align: center;"><b>No.</b></th>
        <th width="15%"><b>Item Code</b></th>
        <th width="50%"><b>Item Details</b></th>
        <th width="15%" style="text-align: center;"><b>UOM</b></th>
        <th width="15%" style="text-align: center;"><b>Quantity</b></th>
    </tr>
    @forelse($salesOrder->salesOrderItemDetails as $key => $item)
        <tr>
            <td width="5%" style="text-align: center;">{{ $key + 1 }}</td>
            <td width="15%" style="text-align: center;">{{ $item->itemCode }}</td>
            <td width="50%">
                <table>
                    <tr>
                        <td width="100%">{{ $item->itemName }}</td>
                    </tr>
                    @php
                        if($item->itemCustomDescription){
                        $itemCustDescription = nl2br($item->itemCustomDescription);
                        $itemCustDescriptions = explode('<br />', $itemCustDescription);
                            foreach ($itemCustDescriptions as $value){
                                echo "<tr><td width='100%'>$value</td></tr>";
                            }
                        }
                    @endphp
                    @php
                        if($item->itemDetailDescription){
                        $itemDetailDescription = nl2br($item->itemDetailDescription);
                        $itemDetailDescriptions = explode('<br />', $itemDetailDescription);
                            foreach ($itemDetailDescriptions as $value){
                                echo "<tr><td width='100%'>$value</td></tr>";
                            }
                        }
                    @endphp
                    @if(!empty($item->itemDrawingNo))
                        <tr>
                            <td width="100%">Drg No. : {{ $item->itemDrawingNo }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->itemCustPartNo))
                        <tr>
                            <td width="100%">Part No. : {{ $item->itemCustPartNo }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->itemMsnNumber))
                        <tr>
                            <td width="100%">MSN No. : {{ $item->itemMsnNumber }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->itemNote))
                        <tr>
                            <td width="100%">Note : {{ $item->itemNote }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->itemInternalNote))
                        <tr>
                            <td width="100%">Internal Note : {{ $item->itemInternalNote }}</td>
                        </tr>
                    @endif
                </table>
            </td>
            <td width="15%" style="text-align: center;">{{ $item?->uom?->uom }}</td>
            <td width="15%" style="text-align: center;">{{ number_format($item->itemQuantity, 3) }}</td>
        </tr>
        @if($request->isNotFilled('print_common_del'))
            <!-- Start Delivery Schedule -->
            <tr>
                <td width="40%" style="text-align: right;">Delivery Schedule :</td>
                <td width="60%">
                    <table border="1px" cellpadding="5px">
                        <tr>
                            <th width="10%">No</th>
                            <th width="25%">Del. Date</th>
                            <th width="25%">Expected Arrival Date</th>
                            <th width="20%">Quantity</th>
                            <th width="20%">Pending Qty</th>
                        </tr>
                        @if($item->deliverySchedule->count())
                            @php $totalQty = 0; @endphp
                            @forelse($item->deliverySchedule as $index => $deliverySchedule)
                                <tr>
                                    <td width="10%">{{ $index + 1 }}</td>
                                    <td width="25%">{{ dateFormat($deliverySchedule->deliveryDate, 'd-m-Y') }}</td>
                                    <td width="25%">{{ dateFormat($deliverySchedule->expectedDate, 'd-m-Y') }}</td>
                                    <td width="20%">{{ number_format($deliverySchedule->quantity, 3) }}</td>
                                    <td width="20%">{{ number_format($deliverySchedule->pendingQuantity, 3) }}</td>
                                </tr>
                                @php $totalQty += $deliverySchedule->quantity; @endphp
                            @empty
                            @endforelse
                            <tr>
                                <td width="60%" style="text-align: right;">Total Quantity:</td>
                                <td width="40%">{{ number_format($totalQty, 3) ?? null }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
            <!-- End Delivery Schedule -->
        @endif
    @empty
    @endforelse
    <!-- Start Total Items Qty -->
    <tr>
        <td width="85%" style="text-align: right;"><b>Total:</b></td>
        <td width="15%" style="text-align: center;">
            <b>{{ number_format($salesOrder?->salesOrderItemDetails?->sum('itemQuantity') ?? 0, 3) }}</b>
        </td>
    </tr>
    <!-- End Total Items Qty -->
</table>
<!-- End Items Area -->
<!-- Start Note Area -->
@if(!empty($salesOrder->noteDetails['noteHeader'])
    || !empty($salesOrder->noteDetails['noteFooter'])
    || !empty($salesOrder->noteDetails['noteNote'])
    || !empty($salesOrder->noteDetails['noteNote2'])
    || !empty($salesOrder->noteDetails['noteInternalNote'])
)
    <table border="1px" cellpadding="2px">
        <tr>
            <td width="100%">
                <table cellpadding="1px">
                    <tr>
                        <td width="100%"><b>Notes :</b></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    @if(isset($salesOrder->noteDetails['noteHeader']) && !empty($salesOrder->noteDetails['noteHeader']))
                        <tr>
                            <td width="24%"><b>Header Note </b></td>
                            <td width="1%">:</td>
                            <td width="75%">{{ $salesOrder->noteDetails['noteHeader'] }}</td>
                        </tr>
                    @endif
                    @if(isset($salesOrder->noteDetails['noteFooter']) && !empty($salesOrder->noteDetails['noteFooter']))
                        <tr>
                            <td width="24%"><b>Footer Note </b></td>
                            <td width="1%">:</td>
                            <td width="75%">{{ $salesOrder->noteDetails['noteFooter'] }}</td>
                        </tr>
                    @endif
                    @if(isset($salesOrder->noteDetails['noteNote']) && !empty($salesOrder->noteDetails['noteNote']))
                        <tr>
                            <td width="24%"><b>Note </b></td>
                            <td width="1%">:</td>
                            <td width="75%">{{ $salesOrder->noteDetails['noteNote'] }}</td>
                        </tr>
                    @endif
                    @if(isset($salesOrder->noteDetails['noteNote2']) && !empty($salesOrder->noteDetails['noteNote2']))
                        <tr>
                            <td width="24%"><b>Note 2</b></td>
                            <td width="1%">:</td>
                            <td width="75%">{{ $salesOrder->noteDetails['noteNote2'] }}</td>
                        </tr>
                    @endif
                    @if(isset($salesOrder->noteDetails['noteInternalNote']) && !empty($salesOrder->noteDetails['noteInternalNote']))
                        <tr>
                            <td width="24%"><b>Internal Note</b></td>
                            <td width="1%">:</td>
                            <td width="75%">{{ $salesOrder->noteDetails['noteInternalNote'] }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
@endif
<!-- End Note Area -->
<!-- Start Term & Condition -->
<table border="1px" cellpadding="2px">
    <tr>
        <td width="100%">
            <table cellpadding="1px">
                <tr>
                    <td width="100%"><b>Terms & Condition :</b></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                @forelse($salesOrder->termAndCondition as $termCondition)
                    <tr>
                        <td width="24%"><b>{{ $termCondition->termGroupName }} </b></td>
                        <td width="1%">:</td>
                        <td width="75%">{{ $termCondition->termDetail }}</td>
                    </tr>
                @empty
                @endforelse
            </table>
        </td>
    </tr>
</table>
<!-- End Term & Condition -->
<!-- Start Signature Area -->
<table border="1px">
    <tr rowspan="3">
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>
            <table cellpadding="10px">
                <tr>
                    <td width="100%">Issue By : {{ $salesOrder?->loginDetail['createdBy'] ?? null }}</td>
                </tr>
                <tr>
                    <td width="100%">Date : {{ $salesOrder?->loginDetail['createdDateTime'] ?? null }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table cellpadding="10px">
                <tr>
                    <td width="100%">Authorised By
                        : {{ $salesOrder?->SalesOrderStageDetail['approveUser'] ?? null }}</td>
                </tr>
                <tr>
                    <td width="100%">Date : {{ $salesOrder?->SalesOrderStageDetail['approveDateTime'] ?? null }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table cellpadding="10px">
                <tr>
                    <td width="100%">Received By : _______________________</td>
                </tr>
                <tr>
                    <td width="100%">Date : ______________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Signature Area -->
