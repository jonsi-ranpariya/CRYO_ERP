<?php

namespace App\Http\Controllers;

use App\Contracts\PDFReportServiceInterface;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\View\View;

abstract class PDFReportController implements PDFReportServiceInterface
{
    /**
     * @inheritdoc
     */
    public function openPdf(
        string      $pdfName,
        View|string $pdfHtml,
        ?callable   $headerCallable = null,
        ?callable   $footerCallable = null
    ): void
    {
        $pdf = new TCPDF();
        $pdf::SetCreator(config('tcpdf.creator'));
        $pdf::SetAuthor(config('tcpdf.author'));
        $pdf::SetTitle(config('tcpdf.page_title'));
        $pdf::SetFont('helvetica', '', config('tcpdf.font_size_main'));
        $pdf::SetMargins(5, config('tcpdf.margin_header_top'), 7);
        // set auto page breaks
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        if (is_null($headerCallable)) {
            $pdf::setHeaderCallBack(function ($pdfHeader) {
                $pdfHeader->SetMargins(8, 30, 8);
                //$headerHtml = '<img src="' . public_path('header_challan.jpg') . '">';
                $headerHtml = '<img src="' . public_path('IWI_INV_HEADER.JPG') . '">';
                $pdfHeader->writeHTML($headerHtml, true, false, true, false, '');
            });
        } else {
            $pdf::setHeaderCallBack($headerCallable);
        }
        if (is_null($footerCallable)) {
            $pdf::setFooterCallback(function ($pdfFooter) {
                $pdfFooter->setX(10);
                $pdfFooter->setY(-10);
                $pdfFooter->SetFont('helvetica', 'I', 10);
                $pdfFooter->SetTextColor(142, 142, 142);
                $pdfFooter->Ln(4);
                $pdfFooter->Cell(50, 0, 'Page ' . $pdfFooter->getAliasNumPage() . ' of ' . $pdfFooter->getAliasNbPages(), 0, 0, 'L', 0, '', 0, false, '', '');
            });
        } else {
            $pdf::setFooterCallback($footerCallable);
        }
        $pdf::AddPage();
        $pdf::writeHTML($pdfHtml, true, false, true, false, '');
        $pdf::Output($pdfName, 'I');
    }

    /**
     * @inheritdoc
     */
    public function downloadPdf(
        string      $pdfName,
        View|string $pdfHtml
    ): void
    {
        $pdf = new TCPDF();
        $pdf::SetCreator(config('tcpdf.creator'));
        $pdf::SetAuthor(config('tcpdf.author'));
        $pdf::SetTitle(config('tcpdf.page_title'));
        $pdf::SetFont('helvetica', '', config('tcpdf.font_size_main'));
        $pdf::SetMargins(5, config('tcpdf.margin_header_top'), 7);
        $pdf::setHeaderCallBack(function ($pdfHeader) {
            $pdfHeader->SetMargins(8, 30, 8);
            //$headerHtml = '<img src="' . public_path('header_challan.jpg') . '">';
            $headerHtml = '<img src="' . public_path('IWI_INV_HEADER.JPG') . '">';
            $pdfHeader->writeHTML($headerHtml, true, false, true, false, '');
        });
        $pdf::setFooterCallback(function ($pdfFooter) {
            $pdfFooter->setX(10);
            $pdfFooter->setY(-10);
            $pdfFooter->SetFont('helvetica', 'I', 10);
            $pdfFooter->SetTextColor(142, 142, 142);
            $pdfFooter->Ln(4);
            $pdfFooter->Cell(50, 0, 'Page ' . $pdfFooter->getAliasNumPage() . ' of ' . $pdfFooter->getAliasNbPages(), 0, 0, 'L', 0, '', 0, false, '', '');
        });
        $pdf::AddPage();
        $pdf::writeHTML($pdfHtml, true, false, true, false, '');
        $pdf::Output($pdfName, 'D');
    }
}
