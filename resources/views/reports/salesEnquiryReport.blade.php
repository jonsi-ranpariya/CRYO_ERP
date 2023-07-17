<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SALES Enquiry</title>
</head>
<body>
<!-- Start Main Title -->
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: center;" width="100%"><h3><b>SALES ENQUIRY</b></h3></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="1px" cellpadding="2px">
    <!-- Start Company & Quotation Details -->
    <tr>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td><b>M/S. {{ $salesEnquiry->customerName }}.</b><br>
                        @php echo str_repeat('&nbsp;', 5) @endphp {{ $salesEnquiry->customerAddress }},<br>
                        @php echo str_repeat('&nbsp;', 5) @endphp {{ $salesEnquiry?->city?->city }}-{{ $salesEnquiry->customerPinCode }},{{ $salesEnquiry?->state?->state }},{{ $salesEnquiry?->country?->country }}<br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td width="35%"><b>Kind Attn.</b></td>
                                <td width="75%">: {{ $salesEnquiry->contactPersonName }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table cellpadding="2px">
                <tr>
                    <td width="100%"><b>Enquiry No. : {{ $salesEnquiry->enquiryNo }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Enquiry Date : {{ $salesEnquiry->enquiryDate }}</b></td>
                </tr>
                <tr>
                    <td width="100%"><b>Reference : {{ $salesEnquiry->reference }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Main Title -->
<!-- Start Items Area -->
<table border="1px" cellpadding="2px">
    <tr>
        <th width="10%"><b>No.</b></th>
        <th width="50%"><b>Item Details</b></th>
        <th width="15%" style="text-align: center;"><b>UOM</b></th>
        <th style="text-align: center;"><b>Quantity</b></th>
    </tr>
    @forelse($salesEnquiry->itemDetails as $key => $item)
    <tr>
        <td width="10%">{{ $key+1 }}</td>
        <td width="50%">
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
                    if($item->detailDescription){
                    $itemDetailDescription = nl2br($item->detailDescription);
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
        </td>
        <td width="15%" style="text-align: center;">{{ $item?->uomDetails?->uom }}</td>
        <td style="text-align: center;">{{ $item->requireQty }}</td>
    </tr>
    @empty
    @endforelse
    <tr>
        <td colspan="3" style="text-align: right"><b>Total</b></td>
        <td colspan="1" style="text-align: center">{{ $salesEnquiry->itemDetails->sum('requireQty') }}</td>
    </tr>
</table>
</body>
</html>
