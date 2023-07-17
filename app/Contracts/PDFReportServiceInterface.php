<?php

namespace App\Contracts;

use Illuminate\View\View;

interface PDFReportServiceInterface
{
    /**
     * @param string $pdfName
     * @param View|string $pdfHtml
     * @param callable|null $headerCallable
     * @param callable|null $footerCallable
     * @return void
     */
    public function openPdf(
        string $pdfName,
        View|string $pdfHtml,
        ?callable $headerCallable = null,
        ?callable $footerCallable = null
    ): void;

    /**
     * Using This Method User Can Download PDF
     *
     * @param string $pdfName
     * @param View|string $pdfHtml
     * @return void
     */
    public function downloadPdf(
        string $pdfName,
        View|string $pdfHtml
    ): void;
}
