<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionPlanning\IssueQtyForJobCardRequest;
use App\Models\ProductionPlanning\ShowIssueItems;
use App\Services\ProductionPlanning\JobCardMaterialIssueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowIssueItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = ShowIssueItems::all();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ShowIssueItems $showIssueItems
     * @return JsonResponse
     */
    public function store(Request $request, ShowIssueItems $showIssueItems): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $showIssueItems->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = ShowIssueItems::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ShowIssueItems $showIssueItems
     * @return JsonResponse
     */
    public function update(Request $request, ShowIssueItems $showIssueItems): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $showIssueItems->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param ShowIssueItems $showIssueItems
     * @return JsonResponse
     */
    public function destroy($id, ShowIssueItems $showIssueItems): JsonResponse
    {
        $response = $showIssueItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getShowProcessItems(Request $request): JsonResponse
    {
        $jobId = $request->jobCardId;
        $processId = $request->processId;

        $response = ShowIssueItems::getData(['processId' => $processId, 'jobId' => $jobId]);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getShowIssueItem($id): JsonResponse
    {
        $response = ShowIssueItems::where('jobId', $id)->where('issueItemPendingQty', '>', 0)->get();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param ShowIssueItems $showIssueItems
     * @return JsonResponse
     */
    public function getShowIssueItemsFilter(Request $request, ShowIssueItems $showIssueItems): JsonResponse
    {
        $issueItemCode = $request->issueItemCode;
        $issueItemDescription = $request->issueItemDescription;
        $issueItemDetailDescription = $request->issueItemDetailDescription;
        $issueItemDrawingNo = $request->issueItemDrawingNo;

        $itemDetails = $showIssueItems->with(['itemDetails' => function ($query) use($issueItemCode) {
            if ($issueItemCode) {
                $query->where('itemCode', 'LIKE', "%{$issueItemCode}%");
            }
        }]);

        if (!empty($issueItemDescription)) {
            $itemDetails->where('issueItemDescription', 'LIKE', "%{$issueItemDescription}%");
        }

        if (!empty($issueItemDetailDescription)) {
            $itemDetails->where('issueItemDetailDescription', 'LIKE', "%{$issueItemDetailDescription}%");
        }

        if (!empty($issueItemDrawingNo)) {
            $itemDetails->where('issueItemDrawingNo', 'LIKE', "%{$issueItemDrawingNo}%");
        }

        if (empty($issueItemCode) && empty($issueItemDescription) && empty($issueItemDetailDescription) && empty($issueItemDrawingNo)) {
            $itemList = [];
        } else {
            $items = $itemDetails->get();
            foreach ($items as $key => $item) {
                if ($item->itemDetails != null)
                    $itemList[$key] = $item;
            }
        }

        $data['message'] = "Show Issue Item List";
        $data['status'] = 200;
        $data['data'] = array_values($itemList ?? []);
        return jsonData($data);
    }

    /**
     * @param IssueQtyForJobCardRequest $request
     * @param JobCardMaterialIssueService $service
     * @return array
     */
    public function issueQuantityForJobCard(
        IssueQtyForJobCardRequest $request,
        JobCardMaterialIssueService $service
    ): array
    {
        return [
            'message' => 'Material Issue Successfully.',
            'data' => $service->handle($request)
        ];
    }
}
