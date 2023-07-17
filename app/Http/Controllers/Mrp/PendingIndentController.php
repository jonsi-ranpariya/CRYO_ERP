<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\MRP\MrpIndent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingIndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function index(MrpIndent $mrpIndent)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $mrpIndent->all();
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function show($id, MrpIndent $mrpIndent)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $mrpIndent->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function update($id, Request $request, MrpIndent $mrpIndent)
    {
        $dataUpdate = $request->all();
        $response = $mrpIndent->updateData($id, $dataUpdate);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function getIndentWithFilter(Request $request, MrpIndent $mrpIndent)
    {
        $response = $mrpIndent->where('loginDetails.stage',2)->get();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
