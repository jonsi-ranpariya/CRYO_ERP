<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\ScrapReceiptEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScrapReceiptEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = ScrapReceiptEntry::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ScrapReceiptEntry $scrapReceiptEntry
     * @return JsonResponse
     */
    public function store(Request $request, ScrapReceiptEntry $scrapReceiptEntry)
    {
        $dataInsert = $request->all();
        $response = $scrapReceiptEntry->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ScrapReceiptEntry  $scrapReceiptEntry
     * @return JsonResponse
     */
    public function show(ScrapReceiptEntry $scrapReceiptEntry)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $scrapReceiptEntry;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ScrapReceiptEntry $scrapReceiptEntry
     * @return JsonResponse
     */
    public function update(Request $request, ScrapReceiptEntry $scrapReceiptEntry)
    {
        $dataUpdated = $request->all();
        $response = $scrapReceiptEntry->updateData($scrapReceiptEntry->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ScrapReceiptEntry $scrapReceiptEntry
     * @return JsonResponse
     */
    public function destroy(ScrapReceiptEntry $scrapReceiptEntry)
    {
        $response = $scrapReceiptEntry->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
