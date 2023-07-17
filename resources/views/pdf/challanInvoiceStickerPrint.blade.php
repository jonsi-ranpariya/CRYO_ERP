<!DOCTYPE html>
<html>
<body>
@php
    $nbsp = '<br>'.str_repeat('&nbsp;', 2);
@endphp
@forelse($printItems as $item)
    <div style="margin: 1px;">
        <p><b>{{ $challanData->company_details['companyName'] }}</b></p>
        <table>
            <tr>
                <td width="15%"><b>Customer</b></td>
                <td width="35%"><b>: {{ $challanData->dispatchDetails['dispatchName'] }}</b></td>
            </tr>
            @if($challanData['dispatchDetails']['dispatchAddress'])
                <tr>
                    <td width="15%"><b>Address</b></td>
                    <td width="35%"><b>: {!! $challanData['dispatchDetails']['dispatchAddress'] !!} {{ $challanData->dispatch_extra_data['city']['city'] }} - {{ $challanData->dispatch_extra_data['state']['state'] }} - {{ $challanData->dispatch_extra_data['country']['country'] }}</b></td>
                    <td width="50%"></td>
                </tr>
            @endif
            <tr>
                <td width="15%"><b>PO No.</b></td>
                <td width="35%"><b>: {{ $challanData->orderNo }}</b></td>
                <td width="50%"></td>
            </tr>
            <tr>
                <td width="15%"><b>PO Date</b></td>
                <td width="35%"><b>: {{ $challanData->orderDate }}</b></td>
                <td width="50%"></td>
            </tr>
            <tr>
                <td width="15%"><b>Item Desc.</b></td>
                <td width="35%"><b>: {!! ($item['itemDescription']) !!} </b></td>
                <td width="50%"></td>
            </tr>
            @if($item['itemAddDescription'])
                <tr>
                    <td width="15%"><b>Add. Desc</b></td>
                    <td width="35%"><b>: {!! ($item['itemAddDescription']) !!}</b></td>
                    <td width="50%"></td>
                </tr>
            @endif
            @if($item['itemCustomDescription'])
                <tr>
                    <td width="15%"><b>Cust. Desc</b></td>
                    <td width="35%"><b>: {!! ($item['itemCustomDescription']) !!}</b></td>
                    <td width="50%"></td>
                </tr>
            @endif
            @if($item['itemDrawingNo'])
                <tr>
                    <td width="15%"><b>Drg No./Rev.</b></td>
                    <td width="35%"><b>: {{ $item['itemDrawingNo'] }} / {{ $item['itemRevision'] }}</b></td>
                    <td width="50%"></td>
                </tr>
            @endif
            @if($item['itemRemark'])
                <tr>
                    <td width="15%"><b>Remark</b></td>
                    <td width="35%"><b>: {!! ($item['itemRemark']) !!}</b></td>
                    <td width="50%"></td>
                </tr>
            @endif
            <tr>
                <td width="15%"><b>Quantity</b></td>
                <td width="35%"><b>: {{ number_format($item['itemQuantity'],2) }} {{ $item['uom_details']['uom'] }}</b></td>
                <td width="50%"></td>
            </tr>
        </table>
    </div>
@empty
@endforelse
</body>
</html>
