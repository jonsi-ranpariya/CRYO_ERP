<?php

namespace App\Http\Controllers\Purchase;

use App\Actions\Purchase\PurchaseCostingAddDataWithItemAction;
use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseCosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseCostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseCosting::with([
            'partyDetails:_id,partyCode,partyName',
            'cityDetail:_id,city',
            'stateDetail:_id,state',
            'countryDetail:_id,country'
        ])->get();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $response = PurchaseCostingAddDataWithItemAction::run($request);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param c $purchaseCosting
     * @return JsonResponse
     */
    public function show(PurchaseCosting $purchaseCosting)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseCosting;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseCosting $purchaseCosting
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseCosting $purchaseCosting)
    {
        $dataUpdated = $request->all();
        $response = $purchaseCosting->updateData($purchaseCosting->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseCosting $purchaseCosting
     * @return JsonResponse
     */
    public function destroy(PurchaseCosting $purchaseCosting)
    {
        $response = $purchaseCosting->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
