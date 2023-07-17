<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Ledger</title>
</head>
<body>
<!-- Start Main Title -->
<table border="1px" cellpadding="3px">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="text-align: center;" width="100%"><h2><b>Stock Ledger</b></h2></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Main Title -->
<!-- Start Items Area -->
<table border="1px" cellpadding="3px">
    <tr>
        <th style="text-align: center;"><b>No.</b></th>
        <th><b>Transaction</b></th>
        <th><b>Doc. No.</b></th>
        <th style="text-align: center;"><b>Doc. Date</b></th>
        <th style="text-align: center;"><b>W.O/P.O No.</b></th>
        <th style="text-align: center;"><b>Quantity</b></th>
        <th style="text-align: center;"><b>Rate</b></th>
        <th style="text-align: center;"><b>Amount</b></th>
        <th style="text-align: center;"><b>Balance Qty</b></th>
    </tr>
    @forelse($transactionItems as $key => $item)
        @php $lastKey = $key + 1 @endphp
        <tr>
            <th style="text-align: center;">{{ $lastKey }}</th>
            <th>{{ $item->transactionType }}</th>
            <th>{{ $item->documentNo }}</th>
            <th style="text-align: center;">{{ $item->documentDate }}</th>
            <th style="text-align: center;">{{ $item->woPoNo }}</th>
            <th style="text-align: center;">{{ $item->transactionQty }}</th>
            <th style="text-align: center;">{{ $item->rate }}</th>
            <th style="text-align: center;">{{ abs($item->value) }}</th>
            <th style="text-align: center;">{{ $item?->stockLedger?->qty }}</th>
        </tr>
    @empty
    @endforelse
    @if($transactionItems->isNotEmpty())
        <tr>
            <th style="text-align: center;">{{ $lastKey + 1 }}</th>
            <th>Closing Stock</th>
            <th></th>
            <th style="text-align: center;">{{ now()->format('d/m/Y') }}</th>
            <th style="text-align: center;"></th>
            <th style="text-align: center;"></th>
            <th style="text-align: center;">{{ number_format($transactionItems->avg('rate'), 2) }}</th>
            <th style="text-align: center;">{{  number_format($transactionItems->avg('rate') * $item?->stockLedger?->assignLot?->sum('quantity'), 2) }}</th>
            <!--//$transactionItems->sum('value')-->
            <th style="text-align: center;">{{ $item?->stockLedger?->assignLot?->sum('quantity') }}</th>
        </tr>
    @endif
</table>
</body>
</html>
