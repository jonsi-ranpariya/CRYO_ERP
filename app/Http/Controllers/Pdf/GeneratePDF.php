<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoicePacking;
use App\Models\Despatch\NewChallanInvoiceTermCondition;
use App\Models\GST\MasterGst;
use App\Models\Partymaster\PartyMaster;
use App\Models\Purchase\PurchaseReturn;
use App\Models\Purchase\PurchaseReturnItem;
use App\Models\Purchase\PurchaseReturnTermCondition;
use App\Models\SalesCrm\SalesReturn;
use App\Models\SalesCrm\SalesReturnItems;
use Elibyy\TCPDF\Facades\TCPDF;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GeneratePDF extends Controller
{
    /**
     * Generate E-Invoice PDF
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generatePdf(Request $request): JsonResponse
    {
        try {
            $type = $request->type;

            $challanInvoiceId = $request->newChallanInvoiceId;
            $copySelection = $request->copySelection;
            $invoiceSelectionMode = $request->invoiceSelectionMode;
            $challanData = NewChallanInvoice::getFirstDataWithRelation(['_id' => $challanInvoiceId], ['itemsDetail']);
            $masterGst = MasterGst::query()->where(['challanInvoiceId' => $challanInvoiceId])->latest()->first();
            $termAndCondition = NewChallanInvoiceTermCondition::getData(['challanInvoiceId' => $challanInvoiceId]);

            if ($challanData->consigneeDetails['consigneeCode'] === null) {
                return jsonData(['msg' => 'Please Fill Consignee Details.'], Response::HTTP_BAD_REQUEST);
            }

            if ($challanData->dispatchDetails['dispatchCode'] === null) {
                return jsonData(['msg' => 'Please Fill Dispatch Details.'], Response::HTTP_BAD_REQUEST);
            }

            if ($challanData->itemsDetail->isEmpty()) {
                return jsonData(['msg' => 'Please Fill Items Details.'], Response::HTTP_BAD_REQUEST);
            }

            $html = view('pdf/' . $type,
                compact('challanData',
                    'masterGst',
                    'termAndCondition',
                    'copySelection',
                    'invoiceSelectionMode'
                )
            );

            if (!file_exists(public_path('uploads/pdf'))) {
                mkdir(public_path('uploads/pdf'), 0777, true);
            }
            $name = Str::random() . '.pdf';
            $pdf = new TCPDF();
            $pdf::SetTitle('E-Invoice');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::SetMargins(5, 30, 7);
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
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
            $data['path'] = asset('uploads/pdf/' . $name);
            $data['name'] = $name;
            return jsonData($data);
        } catch (Exception $e) {
            return jsonData(['msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deletePDF(Request $request): JsonResponse
    {
        File::delete(public_path('uploads/pdf/' . $request->filename));
        $data['message'] = "Deleted";
        $data['status'] = 200;
        $data['data'] = '';
        return jsonData($data);
    }

    /**
     * Generate Packaging List
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function challanInvoicePackageList(Request $request): JsonResponse
    {
        $challanInvoiceId = $request->challanInvoiceId;
        $packingList = NewChallanInvoicePacking::getRelationData(['challanInvoiceId' => $challanInvoiceId], ['itemDetails']);
        $challanData = NewChallanInvoice::getDataFromId($challanInvoiceId);

        if ($packingList->isEmpty()) {
            $data['message'] = 'Please fill packing items';
            return jsonData($data, Response::HTTP_BAD_REQUEST);
        }

        $html = view('pdf/challanPackingList', compact('packingList', 'challanData'));

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = Str::random(16) . '.pdf';
        $pdf = new TCPDF();
        $pdf::SetTitle('Packing List');
        $pdf::SetFont('helvetica', '', 8);
        $pdf::SetMargins(5, 30, 7);
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
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;
        return jsonData($data);

    }

    /**
     * Generate Envelope Print
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getChallanInvoiceEnvelopePreview(Request $request): JsonResponse
    {
        //1: Party
        //2: Buyer
        //3: Consignee
        //4: Dispatch
        $type = $request->type;
        $challanInvoiceId = $request->challanInvoiceId;
        $challanInvoiceData = NewChallanInvoice::getDataFromId($challanInvoiceId);

        $data['companyName'] = null;
        $data['kindAttnName'] = null;
        $data['kindAttnNumber'] = null;
        $data['address'] = null;
        $data['city'] = null;
        $data['state'] = null;
        $data['country'] = null;
        $data['pincode'] = null;
        $data['email'] = null;
        $data['website'] = null;
        $data['phoneNumber'] = null;
        $data['phoneCode'] = null;
        switch ($type) {
            case 1:
                $data['companyName'] = $challanInvoiceData->partyDetails['PartyName'] ?? null;
                $data['kindAttnName'] = $challanInvoiceData->partyDetails['partyKindAttnName'] ?? null;
                $data['address'] = $challanInvoiceData->partyDetails['partyAddress'] ?? null;
                $data['city'] = $challanInvoiceData->party_extra_data['city']['city'] ?? null;
                $data['state'] = $challanInvoiceData->party_extra_data['state']['state'] ?? null;
                $data['country'] = $challanInvoiceData->party_extra_data['country']['country'] ?? null;
                $data['pincode'] = $challanInvoiceData->partyDetails['partyPinCode'] ?? null;
                $data['email'] = $challanInvoiceData->partyDetails['partyEmailId'] ?? null;
                $data['website'] = $challanInvoiceData->partyDetails['partyWebSite'] ?? null;
                $data['phoneNumber'] = $challanInvoiceData->partyDetails['partyPhoneNo'] ?? null;
                $data['phoneCode'] = $challanInvoiceData->partyDetails['partyPhoneCountry'] ?? null;
                $data['kindAttnNumber'] = $challanInvoiceData->partyDetails['partyKindAttnMobile'] ?? null;
                break;
            case 2:
                $data['companyName'] = $challanInvoiceData->buyerDetails['buyerName'] ?? null;
                $data['kindAttnName'] = $challanInvoiceData->buyerDetails['buyerKindAttnName'] ?? null;
                $data['address'] = $challanInvoiceData->buyerDetails['buyerAddress'] ?? null;
                $data['city'] = $challanInvoiceData->buyer_extra_data['city']['city'] ?? null;
                $data['state'] = $challanInvoiceData->buyer_extra_data['state']['state'] ?? null;
                $data['country'] = $challanInvoiceData->buyer_extra_data['country']['country'] ?? null;
                $data['pincode'] = $challanInvoiceData->buyerDetails['buyerPinCode'] ?? null;
                $data['email'] = $challanInvoiceData->buyerDetails['buyerEmailId'] ?? null;
                $data['website'] = $challanInvoiceData->buyerDetails['buyerWebSite'] ?? null;
                $data['phoneNumber'] = $challanInvoiceData->buyerDetails['buyerPhoneNo'] ?? null;
                $data['phoneCode'] = $challanInvoiceData->buyerDetails['buyerPhoneCountry'] ?? null;
                $data['kindAttnNumber'] = $challanInvoiceData->buyerDetails['buyerKindAttnMobile'] ?? null;
                break;
            case 3:
                $data['companyName'] = $challanInvoiceData->consigneeDetails['consigneeName'] ?? null;
                $data['kindAttnName'] = $challanInvoiceData->consigneeDetails['consigneeKindAttnName'] ?? null;
                $data['address'] = $challanInvoiceData->consigneeDetails['consigneeAddress'] ?? null;
                $data['city'] = $challanInvoiceData->consignee_extra_data['city']['city'] ?? null;
                $data['state'] = $challanInvoiceData->consignee_extra_data['state']['state'] ?? null;
                $data['country'] = $challanInvoiceData->consignee_extra_data['country']['country'] ?? null;
                $data['pincode'] = $challanInvoiceData->consigneeDetails['consigneePinCode'] ?? null;
                $data['email'] = $challanInvoiceData->consigneeDetails['consigneeEmailId'] ?? null;
                $data['website'] = $challanInvoiceData->consigneeDetails['consigneeWebSite'] ?? null;
                $data['phoneNumber'] = $challanInvoiceData->consigneeDetails['consigneePhoneNo'] ?? null;
                $data['phoneCode'] = $challanInvoiceData->consigneeDetails['consigneePhoneCountry'] ?? null;
                $data['kindAttnNumber'] = $challanInvoiceData->consigneeDetails['consigneeKindAttnMobile'] ?? null;
                break;
            case 4:
                $data['companyName'] = $challanInvoiceData->dispatchDetails['dispatchName'] ?? null;
                $data['kindAttnName'] = $challanInvoiceData->dispatchDetails['dispatchKindAttnName'] ?? null;
                $data['address'] = $challanInvoiceData->dispatchDetails['dispatchAddress'] ?? null;
                $data['city'] = $challanInvoiceData->dispatch_extra_data['city']['city'] ?? null;
                $data['state'] = $challanInvoiceData->dispatch_extra_data['state']['state'] ?? null;
                $data['country'] = $challanInvoiceData->dispatch_extra_data['country']['country'] ?? null;
                $data['pincode'] = $challanInvoiceData->dispatchDetails['dispatchPinCode'] ?? null;
                $data['email'] = $challanInvoiceData->dispatchDetails['dispatchEmailId'] ?? null;
                $data['website'] = $challanInvoiceData->dispatchDetails['dispatchWebSite'] ?? null;
                $data['phoneNumber'] = $challanInvoiceData->dispatchDetails['dispatchPhoneNo'] ?? null;
                $data['phoneCode'] = $challanInvoiceData->dispatchDetails['dispatchPhoneCountry'] ?? null;
                $data['kindAttnNumber'] = $challanInvoiceData->dispatchDetails['dispatchKindAttnMobile'] ?? null;
                break;

            default:
                break;
        }

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = Str::random(16) . '.pdf';
        $pdf = new TCPDF();

        $html = view('pdf/challanInvoiceEnvelope', compact('data'));
        $pdf::SetTitle('E-Invoice');
        $pdf::SetFont('helvetica', '', 10);
        $pdf::SetMargins(5, 20, 7);
        $pdf::AddPage('L', [279.4, 127]);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;
        return jsonData($data);
    }

    /**
     * Generate Sticker Print
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function stickerPrintPreview(Request $request): JsonResponse
    {
        $challanInvoiceId = $request->challanInvoiceId;
        $challanData = NewChallanInvoice::getDataFromId($challanInvoiceId, false, [
            'company',
            'companyId',
            'orderNo',
            'orderDate',
            'dispatchDetails'
        ]);
        $challanData->setAppends(['dispatch_extra_data', 'company_details']);
        $printItems = $request->printItems;

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = 'sticker_' . Str::random(8) . '.pdf';
        $pdf = new TCPDF();

        $html = view('pdf/challanInvoiceStickerPrint', compact('challanData', 'printItems'));
        $pdf::SetTitle('Sticker Printing');
        $pdf::SetFont('helvetica', 'B', 9);
        $pdf::SetMargins(10, 0, 10);
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;

        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function creditNoteInvoice(Request $request): JsonResponse
    {
        $salesReturnId = $request->salesReturnId;
        $salesReturnData = SalesReturn::getDataFromId($salesReturnId);
        $salesReturnItems = SalesReturnItems::getData(['salesReturnId' => $salesReturnId]);

        if (empty($salesReturnItems)){
            return jsonData(['message' => 'Please Add Items.'], Response::HTTP_BAD_REQUEST);
        }

        $html = view('/pdf/salesReturnCreditNote',
            compact(
                'salesReturnData',
                'salesReturnItems',
                'salesReturnId'
            )
        );

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = 'credit-note-'.Str::random(8) . '.pdf';
        $pdf = new TCPDF();
        $pdf::SetTitle('Sales Return - Credit Note');
        $pdf::SetFont('helvetica', '', 8);
        $pdf::SetMargins(5, 30, 7);
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
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function purchaseReturnEInvoicePreview(Request $request): JsonResponse
    {
        $purchaseReturnId = $request->purchaseReturnId;
        $copySection = $request->copySection;
        $invoiceSelectionMode = $request->invoiceSelectionMode;

        $purchaseReturnData = PurchaseReturn::getDataFromId($purchaseReturnId);
        $purchaseReturnItems = PurchaseReturnItem::getData(['purchaseReturnId' => $purchaseReturnId]);
        $termAndCondition = PurchaseReturnTermCondition::getData(['purchaseReturnId' => $purchaseReturnId]);

        $html = view('/pdf/purchaseReturnInvoice',
            compact(
                'purchaseReturnData',
                'purchaseReturnItems',
                'invoiceSelectionMode',
                'termAndCondition'
            )
        );

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = 'debit-note-'.Str::random(8) . '.pdf';
        $pdf = new TCPDF();
        $pdf::SetTitle('Purchase Return (Debit Note)');
        $pdf::SetFont('helvetica', '', 8);
        $pdf::SetMargins(5, 30, 7);
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
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;
        return jsonData($data);
    }

    public function partyMasterEnvelopePrint(Request $request)
    {
        $type = $request->type;
        $partyId = $request->partyId;
        $partyMaster = PartyMaster::find($partyId);

        if (!file_exists(public_path('uploads/pdf'))) {
            mkdir(public_path('uploads/pdf'), 0777, true);
        }
        $name = 'party-env-'.Str::random(8) . '.pdf';
        $pdf = new TCPDF();

        $html = view('pdf/partyMasterEnvelope', compact('partyMaster','type'));
        $pdf::SetTitle('E-Invoice');
        $pdf::SetFont('helvetica', '', 10);
        $pdf::SetMargins(5, 20, 7);
        $pdf::AddPage('L', [279.4, 127]);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path('uploads/pdf/' . $name), 'F');
        $data['path'] = asset('uploads/pdf/' . $name);
        $data['name'] = $name;
        return jsonData($data);
    }
}
