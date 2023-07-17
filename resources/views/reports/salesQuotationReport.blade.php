<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SALES Quotation</title>
</head>
<body>
<!-- Start Main Title -->
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    @if($request->isNotFilled('report_without_rate'))
                    <td style="text-align: center;" width="100%"><h3><b><i>Quotation</i></b></h3></td>
                    @else
                        <td style="text-align: center;" width="100%"><h3><b>NON PRICED QUOTATION</b></h3></td>
                    @endif
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Main Title -->
<!-- Start Top Area -->
<table border="1px" cellpadding="2px">
    <!-- Start Company & Quotation Details -->
    <tr>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td><b>M/S. IWI CRYOGENIC VAPORIZATION SYSTEM (I) PVT. LTD.</b><br>
                        @php echo str_repeat('&nbsp;', 5) @endphp PLOT NO| 338, G.I.D.C. INDUSTRIAL ESTATE,<br>
                        @php echo str_repeat('&nbsp;', 5) @endphp WAGHODIA,<br>
                        @php echo str_repeat('&nbsp;', 5) @endphp VADODARA-391760,GUJARAT,INDIA<br>
                    </td>
                </tr>
                <tr>
                    <td>
                        @php echo str_repeat('&nbsp;', 5) @endphp Ph.No.: 0265-262095<br>
                        @php echo str_repeat('&nbsp;', 5) @endphp Email: iwistore@cryogasindustries.com<br>
                        @php echo str_repeat('&nbsp;', 5) @endphp <b>GSTIN: 24AAACI4408BIZA</b><br>
                    </td>
                </tr>
                <tr>
                    <td><b>Your Ref. @php echo str_repeat('&nbsp;', 3) @endphp
                            : {{ $salesQuotation?->customerDetailsData['reference'] ?? 'Email' }}</b></td>
                </tr>
                <tr>
                    <td><b>Our Ref. @php echo str_repeat('&nbsp;', 5) @endphp
                            : {{ $salesQuotation?->customerDetailsData['ourReference'] ?? 'Email' }}</b></td>
                </tr>
            </table>
        </td>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td width="100%"><b>Quotation No. : {{ $salesQuotation->quotationNo }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Quotation Date. : {{ $salesQuotation->quotationDate }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Due Date. : {{ $salesQuotation->dueDate }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Ref. Date.
                            : {{ $salesQuotation?->customerDetailsData['referenceDate'] ?? null }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- End Company & Quotation Details -->
    <!-- Start Contact Details & Sales Person Details -->
    <tr>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td><b>Kind Attn. @php echo str_repeat('&nbsp;', 2) @endphp
                            : {{ $salesQuotation?->customerDetailsData['personName'] ?? null }}</b></td>
                </tr>
                <tr>
                    <td>Contact No. : {{ $salesQuotation?->customerDetailsData['mobileNo'] ?? null }}</td>
                </tr>
                <tr>
                    <td>Email Id @php echo str_repeat('&nbsp;', 6) @endphp
                        : {{ $salesQuotation?->customerDetailsData['emailId'] ?? null }}</td>
                </tr>
            </table>
        </td>
        @if($request->filled('print_quotation_salesPerson'))
            <td>
                <table cellpadding="2px">
                    <tr>
                        <td><b>Sales Person : {{ $salesAgents }} </b></td>
                    </tr>
                </table>
            </td>
        @endif
    </tr>
    <!-- End Contact Details & Sales Person Details -->
</table>
<!-- End Top Area -->
<!-- Start Header Area -->
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td><b>Subject @php echo str_repeat('&nbsp;', 6) @endphp
                            : {{ $salesQuotation?->headerOrFooterData['subject'] ?? null }}</b></td>
                </tr>
                <tr>
                    <td>{!! nl2br($salesQuotation?->headerOrFooterData['header'] ?? null) !!}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Header Area -->
<!-- Start Items Area -->
<table border="1px" cellpadding="2px">
    <tr>
        <th width="5%"><b>No.</b></th>
        @if($request->isNotFilled('report_without_rate'))
           @php $width = 35; @endphp
        @else
            @php $width = 45; @endphp
        @endif
        <th width="{{$width}}%"><b>Item Details</b></th>
        <th width="10%" style="text-align: center;"><b>UOM</b></th>
        <th style="text-align: center;"><b>Quantity</b></th>
        <th style="text-align: center;"><b>Rate</b></th>
        @if($request->isNotFilled('report_without_rate'))
            <th style="text-align: center;"><b>Amount</b></th>
        @endif
    </tr>
    @forelse($salesQuotation->itemDetails as $key => $item)
        <tr>
            <th width="5%">{{ $key + 1 }}</th>
            <th width="{{$width}}%">
                <table>
                    <tr>
                        <td width="100%">{{ $item->itemCode['label'] ?? null }}</td>
                    </tr>
                    @php
                        if($item->itemDescCust){
                        $itemCustDescription = nl2br($item->itemDescCust);
                        $itemCustDescriptions = explode('<br />', $itemCustDescription);
                            foreach ($itemCustDescriptions as $value){
                                echo "<tr><td width='100%'>$value</td></tr>";
                            }
                        }
                    @endphp
                    @php
                        if($item->itemDescription){
                        $itemDetailDescription = nl2br($item->itemDescription);
                        $itemDetailDescriptions = explode('<br />', $itemDetailDescription);
                            foreach ($itemDetailDescriptions as $value){
                                echo "<tr><td width='100%'>$value</td></tr>";
                            }
                        }
                    @endphp
                    @if(!empty($item->drawingNumber))
                        <tr>
                            <td width="100%">Drg No. : {{ $item->drawingNumber }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->custPartNo))
                        <tr>
                            <td width="100%">Part No. : {{ $item->custPartNo }}</td>
                        </tr>
                    @endif
                    @if(!empty($item->itemNote))
                        <tr>
                            <td width="100%">Note : {{ $item->itemNote }}</td>
                        </tr>
                    @endif
                </table>
            </th>
            <th width="10%" style="text-align: center;">{{ $item->uom_details['uom'] ?? null }}</th>
            <th style="text-align: right;">{{ $item->requireQty }}</th>
            @if($request->isNotFilled('report_without_rate'))
                <th style="text-align: right;">{{ number_format($item->rate, 2) }}</th>
            @else
                <th style="text-align: right;">Quoted</th>
            @endif
            @if($request->isNotFilled('report_without_rate'))
                <th style="text-align: right;">{{ $item->netAmount }}</th>
            @endif
        </tr>
    @empty
    @endforelse
    @if($request->isNotFilled('report_without_rate'))
        <!-- Start Billing Term -->
        <tr>
            <td width="65%"><p></p></td>
            <td width="35%">
                <table>
                    @forelse($salesQuotation->billingTerms as $billingTerm)
                        @if($billingTerm->calculateAmount > 0)
                            <tr>
                                <td width="50%"><strong>{{ $billingTerm->description }}</strong></td>
                                <td width="50%" style="text-align: right;"
                                >{{ number_format($billingTerm->calculateAmount, 2) }}</td>
                            </tr>
                        @endif
                    @empty
                    @endforelse
                </table>
            </td>
        </tr>
        <!-- End Billing Term -->
        @if($request->isNotFilled('report_without_totalAmount'))
            <!-- Start Billing Term Total in Word -->
            <tr>
                <td width="100%"><b>Amount in Words
                        : {{ get_amount_words($salesQuotation->billingTerms()->latest()->first()?->calculateAmount) }}</b>
                </td>
            </tr>
            <!-- End Billing Term Total in Word -->
        @endif
    @endif

    <!-- Start Term & Condition -->
    <tr>
        <td width="100%">
            <table cellpadding="1px">
                @if(!empty($salesQuotation->noteData['quotationNote']))
                    <tr>
                        <td width="25%"><b>Note </b></td>
                        <td width="75%">: {{ $salesQuotation->noteData['quotationNote'] }}</td>
                    </tr>
                @endif
                <tr>
                    <td width="100%"><b>Terms & Condition :</b></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                @forelse($salesQuotation->termAndConditionData as $termCondition)
                    <tr>
                        <td width="25%"><b>{{ $termCondition['groupName'] }} </b></td>
                        <td width="75%">: {{ $termCondition['termAndCondition'] }}</td>
                    </tr>
                @empty
                @endforelse
            </table>
        </td>
    </tr>
    <!-- End Term & Condition -->
</table>
<!-- End Items Area -->
<!-- Start Footer Area -->
<table border="1px" cellpadding="2px">
    <tr>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td>{!! nl2br($salesQuotation->headerOrFooterData['footer'] ?? null) !!}</td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Start Company Details & Signature Area -->
    <tr>
        <td width="50%">
            <table>
                <tr>
                    <td width="100%">GST IN No.: 24AAACI4408BIZA</td>
                </tr>
                <tr>
                    <td width="100%">PAN No.: AAACI4408B</td>
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
                    <td><b>For, {{ $salesQuotation?->companyDetails?->companyName }}</b></td>
                </tr>
            </table>
            @php echo str_repeat('<br>', 4) @endphp
            <table>
                <tr>
                    <td width="50%" style="text-align: center">Prepared By</td>
                    <td width="50%" style="text-align: center">Approved By</td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center">
                        ({{ ucwords($salesQuotation?->loginData['createdBy'] ?? null) }})
                    </td>
                    <td width="50%" style="text-align: center">
                        ({{ ucwords($salesQuotation?->loginData['approvedBy'] ?? null) }})
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- End Company Details & Signature Area -->
</table>
<!-- End Footer Area -->
</body>
