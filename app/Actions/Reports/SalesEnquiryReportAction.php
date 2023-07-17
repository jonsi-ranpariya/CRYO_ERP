<?php

namespace App\Actions\Reports;

use App\Contracts\RequestServiceInterface;
use App\Http\Controllers\PDFReportController;
use App\Models\SalesCrm\SalesEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class SalesEnquiryReportAction extends PDFReportController implements RequestServiceInterface
{
    use AsAction;

    /**
     * @inheritDoc
     */
    public function handle(Request $request)
    {
        $salesEnquiry = SalesEnquiry::with('itemDetails')->find($request->salesEnquiryId)->setAppends([]);

        $pdfName = 'ENQ-' . Str::random(8) . '.pdf';
        $pdfHtml = view('reports/salesEnquiryReport', compact('salesEnquiry', 'request'));

        self::openPdf(
            pdfName: $pdfName,
            pdfHtml: $pdfHtml
        );
    }
}
