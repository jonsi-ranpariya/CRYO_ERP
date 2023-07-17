<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\GateInwardReceipt;
use App\Models\Inventory\StockLedger;
use App\Models\Inventory\Transaction;
use App\Services\Inventory\StockLedgerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = Transaction::all();

        $data['Message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param StockLedgerService $stockLedgerService
     * @return JsonResponse
     */
    public function store(Request $request, StockLedgerService $stockLedgerService): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $stockLedgerService->transactionStoreService(dataInsert: $dataInsert);

        return jsonData([
            'message' => $response ? 'Data Saved' : 'Material Quantity Not available.',
            'data' => $response
        ], $response ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = Transaction::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $transaction->updateData($dataUpdate['_id'], $dataUpdate);

        $data['Message'] = 'Data Update';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->destroy();

        $data['Message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }
}
