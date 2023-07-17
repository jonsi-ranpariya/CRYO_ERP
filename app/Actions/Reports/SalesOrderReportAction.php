<?php

namespace App\Actions\Reports;

use App\Contracts\RequestServiceInterface;
use App\Http\Controllers\PDFReportController;
use App\Models\SalesCrm\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Lorisleiva\Actions\Concerns\AsAction;

class SalesOrderReportAction extends PDFReportController implements RequestServiceInterface
{
    use AsAction;

    public function handle(Request $request)
    {
        $request->validate(['salesOrderId' => 'required']);
        $reportType = $request->sales_order_report_type;
        $pdfName = 'SO-' . Str::random() . '.pdf';

        switch ($reportType) {
            case '1':
                Config::set('tcpdf.margin_header_top', 15);
                Config::set('tcpdf.font_size_main', 8);
                $pdfHtml = $this->salesOrderIntimation($request);
                self::openPdf(
                    pdfName: $pdfName,
                    pdfHtml: $pdfHtml,
                    headerCallable: fn($pdfHeader): array => [
                        $pdfHeader->SetY(7),
                        $pdfHeader->SetFont('helvetica', 'B', 12),
                        $pdfHeader->Cell(0, 15, 'CRYOGAS EQUIPMENT PRIVATE LIMITED (DTA)', 0, false, 'C', 0, '', 0, false, 'M', 'M'),
                        $pdfHeader->Ln(),
                        $pdfHeader->Line(6.5, 13, 203, 13, ['width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]])
                    ]
                );
                break;
            case '2':
                Config::set('tcpdf.font_size_main', 8);
                $pdfHtml = $this->salesOrderAcknowledgement($request);
                self::openPdf(
                    pdfName: $pdfName,
                    pdfHtml: $pdfHtml,
                );
                break;
            case '3':
                Config::set('tcpdf.font_size_main', 8);
                $pdfHtml = $this->salesOrderAcknowWithDeviation($request);
                self::openPdf(
                    pdfName: $pdfName,
                    pdfHtml: $pdfHtml,
                );
                break;
            default:
                abort(404);
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    protected function salesOrderIntimation(Request $request): View
    {
        $salesOrder = SalesOrder::with([
            'companyDetails',
            'salesOrderItemDetails' => function($q) use ($request) {
                if ($request->filled('with_only_pending_item')) {
                    $q->onlyPendingItem();
                }
                $q->with('deliverySchedule');
            },
            'termAndCondition' => fn ($q) => [
                $q->printTermOnly()
            ],
        ])->find($request->salesOrderId);

        return view(
            view: 'reports/salesOrderIntimation',
            data: compact('salesOrder', 'request')
        );
    }

    /**
     * @param Request $request
     * @return View
     */
    protected function salesOrderAcknowledgement(Request $request): View
    {
        $salesOrder = SalesOrder::with([
            'companyDetails',
            'salesOrderItemDetails' => function($q) use ($request) {
                if ($request->filled('with_only_pending_item')) {
                    $q->onlyPendingItem();
                }
                $q->with('deliverySchedule');
            },
            'billingTerm',
            'termAndCondition' => fn ($q) => [
                $q->printTermOnly(),
                $q->invoiceWorkOrderOnly()
            ],
            'salesOrderAgent'
        ])->find($request->salesOrderId);

        $agents = $salesOrder->salesOrderAgent->pluck('salesAgent');
        if ($agents->count() > 0) {
            $agent = implode(', ', $agents->toArray());
        } else {
            $agent = null;
        }

        return view(
            view: 'reports/salesOrderAcknowledgeReport',
            data: compact('salesOrder', 'agent', 'request')
        );
    }

    /**
     * @param Request $request
     * @return View
     */
    protected function salesOrderAcknowWithDeviation(Request $request): View
    {
        $salesOrder = SalesOrder::with([
            'companyDetails',
            'salesOrderItemDetails' => function($q) use ($request) {
                if ($request->filled('with_only_pending_item')) {
                    $q->printTermOnly();
                }
                $q->with('deliverySchedule');
            },
            'billingTerm',
            'termAndCondition',
            'salesOrderAgent'
        ])->find($request->salesOrderId);

        $agents = $salesOrder->salesOrderAgent->pluck('salesAgent');
        if ($agents->count() > 0) {
            $agent = implode(', ', $agents->toArray());
        } else {
            $agent = null;
        }

        return view(
            view: 'reports/salesOrderAcknowledgeWithDeviationReport',
            data: compact('salesOrder', 'agent', 'request')
        );
    }
}
