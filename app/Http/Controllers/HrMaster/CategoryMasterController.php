<?php

namespace App\Http\Controllers\HrMaster;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\OperatorController;
use App\Models\HrMaster\CategoryMaster;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;

class CategoryMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return CategoryMaster::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryMaster  $categoryMaster
     * @param Request  $request
     * @return null|object
     */
    public function store(CategoryMaster $categoryMaster, Request $request): ?object
    {
        $dataInsert = $request->all();
        return $categoryMaster->saveData($dataInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param CategoryMaster  $categoryMaster
     * @return null|object
     */
    public function show(CategoryMaster $categoryMaster)
    {
        return $categoryMaster;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param CategoryMaster $categoryMaster
     * @return null|object
     */
    public function update(Request $request, CategoryMaster $categoryMaster): Mixed
    {
        $dataUpdate = $request->all();
        return $categoryMaster->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryMaster  $categoryMaster
     * @return null|object
     */
    public function destroy(CategoryMaster $categoryMaster):bool
    {
        return $categoryMaster->delete();
    }

    public function getCategoryMaster()
    {
        $fetchData = CategoryMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->category;
            $response[$key]['value'] = $value->_id;
        }
        return $response?? [];
    }
}
