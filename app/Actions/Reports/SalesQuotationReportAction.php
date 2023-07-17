<?php

namespace App\Actions\Reports;

use App\Contracts\RequestServiceInterface;
use App\Http\Controllers\PDFReportController;
use App\Models\SalesCrm\SalesQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use function Composer\Autoload\includeFile;

class SalesQuotationReportAction extends PDFReportController implements RequestServiceInterface
{
    use AsAction;

    /**
     * @inheritDoc
     */
    public function handle(Request $request)
    {
        $salesQuotation = SalesQuotation::with([
            'itemDetails',
            'billingTerms'
        ])->find($request->salesQuoationId)->setAppends([]);

        if (!empty($salesQuotation->salesPersonData)) {
            $salesAgents = implode(',',collect($salesQuotation->salesPersonData)->pluck('salesAgent.label')->toArray());
        } else {
            $salesAgents = null;
        }

        $pdfName = 'Q-' . Str::random(8) . '.pdf';
        $pdfHtml = view('reports/salesQuotationReport', compact('salesQuotation', 'salesAgents', 'request'));

        self::openPdf(
            pdfName: $pdfName,
            pdfHtml: $pdfHtml
        );
    }
}
