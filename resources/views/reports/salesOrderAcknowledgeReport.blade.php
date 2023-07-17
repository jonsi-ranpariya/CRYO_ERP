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
                    <td style="text-align: center;" width="100%"><h3>
                            <b><i>SALES ORDER ACKNOWLEDGEMENT</i></b>
                        </h3>
                        <p>(Product Order)</p></td>
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
                    <td width="100%"><b>Sales Order Ackn No. : {{ $salesOrder?->salesOrderNo }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Date. : {{ $salesOrder?->salesOrderDate }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><p></p></td>
                </tr>
                <tr>
                    <td width="100%"><b>Buyer's Name & Address</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>M/S. {{ $salesOrder?->buyerDetail['buyerDetailName'] }}</b></td>
                </tr>
                <tr>
                    <td width="100%">{{ $salesOrder?->buyerDetail['buyerDetailAddress'] }}
                        {{ $salesOrder?->buyerDetail['buyerDetailCity'] }}
                        -{{ $salesOrder?->buyerDetail['buyerDetailPinCode'] }}
                        ,{{ $salesOrder?->buyerDetail['buyerDetailState'] }}
                        {{ $salesOrder?->buyerDetail['buyerDetailCountry'] }}
                    </td>
                </tr>
                <tr>
                    <td width="100%">GSTIN : {{ $salesOrder?->buyerDetail['buyerDetailGstNo'] }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td width="100%"><b>Cust. PO No. : {{ $salesOrder?->customerPoNo }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Date. : {{ $salesOrder?->salesOrderPoDate }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><p></p></td>
                </tr>
                <tr>
                    <td width="100%"><b>Consignee's Name & Address</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>M/S. {{ $salesOrder?->consigneeDetail['consigneeDetailName'] }}</b></td>
                </tr>
                <tr>
                    <td width="100%">{{ $salesOrder?->consigneeDetail['consigneeDetailAddress'] }}
                        {{ $salesOrder?->consigneeDetail['consigneeDetailCity'] }}
                        -{{ $salesOrder?->consigneeDetail['consigneeDetailPinCode'] }}
                        ,{{ $salesOrder?->consigneeDetail['consigneeDetailState'] }} {{ $salesOrder?->consigneeDetail['consigneeDetailCountry'] }}
                    </td>
                </tr>
                <tr>
                    <td width="100%">GSTIN : {{ $salesOrder?->consigneeDetail['consigneeDetailGstNo'] }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                @if($request->filled('print_common_del'))
                    <tr>
                        <td width="100%"><b>Del Date: {{ $salesOrder->salesOrderCommittedDate }}</b></td>
                    </tr>
                @else
                    <tr>
                        <td width="100%"><p></p></td>
                    </tr>
                @endif
                @php
                    echo str_repeat('<tr>
                        <td width="100%"><p></p></td>
                    </tr>', 2)
                @endphp
                <tr>
                    <td width="100%"><b>Dispatch Name & Address</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>M/S. {{ $salesOrder?->dispatchDetail['dispatchDetailName'] }}</b></td>
                </tr>
                <tr>
                    <td width="100%">{{ $salesOrder?->dispatchDetail['dispatchDetailAddress'] }}
                        {{ $salesOrder?->dispatchDetail['dispatchDetailCity'] }}
                        -{{ $salesOrder?->dispatchDetail['dispatchDetailPinCode'] }}
                        ,{{ $salesOrder?->dispatchDetail['dispatchDetailState'] }} {{ $salesOrder?->dispatchDetail['dispatchDetailCountry'] }}
                    </td>
                </tr>
                <tr>
                    <td width="100%">GSTIN : {{ $salesOrder?->dispatchDetail['dispatchDetailGstNo'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <table>
                <tr>
                    <td width="100%"><b>Kind Attn. : MR. {{ $salesOrder->kindAttnName }}</b></td>
                </tr>
                <tr>
                    <td width="100%">Contact No. : +91-{{ $salesOrder->kindAttnMobile }}</td>
                </tr>
                <tr>
                    <td width="100%">Email Id : {{ $salesOrder->kindAttnEmail }}</td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table>
                <tr>
                    <td width="100%"><b>Sales Person : {{ $agent }}</b></td>
                </tr>

            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <tr>
        <td><p>Dear Sir, <br>We thank you for your above enquiry and are pleased to quote as under.</p></td>
    </tr>
</table>
<!-- End Top Area -->
<table border="1px" cellpadding="5px">
    <!-- Start Items -->
    @php
        $itemWidth = 35;
        if($request->isNotFilled('with_hasn_sac')) {
            $itemWidth += 10;
        }
        if($request->isNotFilled('with_gst')) {
            $itemWidth += 8;
        }
    @endphp
    <tr>
        <th width="5%"><b>No.</b></th>
        <th width="{{$itemWidth}}%"><b>Item Details</b></th>
        @if($request->filled('with_hasn_sac'))
        <th width="10%" style="text-align: center;"><b>HSN/SAC</b></th>
        @endif
        @if($request->filled('with_gst'))
        <th width="8%" style="text-align: center;"><b>GST%</b></th>
        @endif
        <th width="6%" style="text-align: center;"><b>UOM</b></th>
        <th width="10%" style="text-align: center;"><b>Quantity</b></th>
        <th width="12%" style="text-align: center;"><b>Rate</b></th>
        <th width="14%" style="text-align: center;"><b>Amount(INR)</b></th>
    </tr>
    @forelse($salesOrder->salesOrderItemDetails as $key => $item)
        <tr>
            <td width="5%">{{ $key + 1 }}</td>
            <td width="{{$itemWidth}}%">
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
                    @if(!empty($item->itemNote))
                        <tr>
                            <td width="100%">Note : {{ $item->itemNote }}</td>
                        </tr>
                    @endif
                </table>
            </td>
            @if($request->filled('with_hasn_sac'))
            <td width="10%" style="text-align: center;">{{ $item->itemHsnSacNumber }}</td>
            @endif
            @if($request->filled('with_gst'))
            @php
                if ($item->itemIgstPercentage > 0) {
                    $gst = $item->itemIgstPercentage;
                } else {
                    $gst = (float)$item->itemCgstPercentage + (float)$item->itemSgstPercentage;
                }
            @endphp
            <td width="8%" style="text-align: center;">{{ $gst }}</td>
            @endif
            <td width="6%" style="text-align: center;">{{ $item->uom_details['uom'] ?? null }}</td>
            <td width="10%" style="text-align: center;">{{ number_format($item->itemQuantity, 3) }}</td>
            <td width="12%" style="text-align: center;">{{ number_format($item->itemRate, 2) }}</td>
            <td width="14%" style="text-align: center;">{{ number_format($item->itemNetAmount, 2) }}</td>
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
    <!-- End Items -->
    <!-- Start Total Items Qty -->
    <tr>
        <td width="64%" style="text-align: right;"><b>Total:</b></td>
        <td width="36%"><b>{{ number_format($salesOrder?->salesOrderItemDetails?->sum('itemQuantity') ?? 0, 3) }}</b>
        </td>
    </tr>
    <!-- End Total Items Qty -->
    <!-- Start Billing Term -->
    <tr>
        <td width="64%"><p></p></td>
        <td width="36%">
            <table>
                @forelse($salesOrder->billingTerm as $billingTerm)
                    @if($billingTerm->calculatedAmount > 0)
                        <tr>
                            <td width="50%"><strong>{{ $billingTerm->billingName }}</strong></td>
                            <td width="50%" style="text-align: right;">{{ number_format($billingTerm->calculatedAmount, 2) }}</td>
                        </tr>
                    @endif
                @empty
                @endforelse
            </table>
        </td>
    </tr>
    <!-- End Billing Term -->
    <!-- Start Billing Term Total in Word -->
    <tr>
        <td width="100%"><b>Amount in Words
                : {{ get_amount_words($salesOrder->billingTerm()->latest('srNo')->first()?->calculatedAmount) }}</b>
        </td>
    </tr>
    <!-- End Billing Term Total in Word -->
    <!-- Start Term & Condition -->
    <tr>
        <td width="100%">
            <table cellpadding="1px">
                <tr>
                    <td width="100%"><b>Terms & Condition :</b></td>
                </tr>
                <tr><td></td></tr>
                @forelse($salesOrder->termAndCondition as $termCondition)
                    <tr>
                        <td width="24%"><b>{{ $termCondition->termGroupName }} </b> </td>
                        <td width="1%">:</td>
                        <td width="75%">{{ $termCondition->termDetail }}</td>
                    </tr>
                @empty
                @endforelse
            </table>
        </td>
    </tr>
    <!-- End Term & Condition -->
    <!-- Start Company Details & Signature Area -->
    <tr>
        <td width="50%">
            <table>
                <tr>
                    <td width="100%">GST IN No.: {{ $salesOrder->companyDetails?->gstNumber }}</td>
                </tr>
                <tr>
                    <td width="100%">PAN No.: {{ $salesOrder->companyDetails?->panNumber }}</td>
                </tr>
                <tr>
                    <td width="100%">ARN No.: AA2412160039869</td>
                </tr>
                <tr>
                    <td width="100%">IEC No.: 3409005072</td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table>
                <tr>
                    <td><b>For, {{ $salesOrder->companyDetails?->companyName }}</b></td>
                </tr>
            </table>
            @php echo str_repeat('<br>', 7) @endphp
            <table>
                <tr>
                    <td width="50%" style="text-align: center">Prepared By</td>
                    <td width="50%" style="text-align: center">Approved By</td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center">({{ ucwords($salesOrder->loginDetail['createdBy']) ?? null }})</td>
                    <td width="50%" style="text-align: center">({{ ucwords($salesOrder->SalesOrderStageDetail['preparedBy']) ?? null }})</td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- End Company Details & Signature Area -->
</table>
</body>
</html>
