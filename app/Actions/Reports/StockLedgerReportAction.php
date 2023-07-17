<?php

namespace App\Actions\Reports;

use App\Contracts\RequestServiceInterface;
use App\Http\Controllers\PDFReportController;
use App\Models\Inventory\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class StockLedgerReportAction extends PDFReportController implements RequestServiceInterface
{
    use AsAction;

    public function handle(Request $request)
    {
        $itemCode = $request->itemCode;

        $transaction = Transaction::with(['stockLedger']);
        if ($request->filled('itemCode')){
            $transaction->where("itemId", $itemCode);
        }
        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $transaction->whereBetween('created_at', [Carbon::parse($request->fromDate), Carbon::parse($request->toDate)]);
        }
        $transactionItems = $transaction->get();

        $pdfName = 'SL-'.Str::random().'.pdf';
        //testDie($transactionItems->toArray());
        $html = view('reports/stockLedgerReport', compact('transactionItems'));

        Config::set('tcpdf.page_title', 'Stock Ledger');
        Config::set('tcpdf.margin_header_top', 15);
        Config::set('tcpdf.font_size_main', 8);

        self::openPdf(
            pdfName: $pdfName,
            pdfHtml: $html,
            headerCallable: fn($pdfHeader): array => [
                $pdfHeader->SetY(7),
                $pdfHeader->SetFont('helvetica', 'B', 12),
                $pdfHeader->Cell(0, 15, 'CRYOGAS EQUIPMENT PRIVATE LIMITED (DTA)', 0, false, 'C', 0, '', 0, false, 'M', 'M'),
                $pdfHeader->Ln(),
                $pdfHeader->Line(6.5, 13, 203, 13, ['width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]])
            ]
        );
    }
}
