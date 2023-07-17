<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maklad\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return jsonData([
            'message' => 'Data Found',
            'data' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            return jsonData([
                'message' => 'Data Saved',
                'data' => Permission::create($request->all())
            ]);
        } catch (\Exception $e) {
            return jsonData([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(string $id ,Permission $permission): JsonResponse
    {
        return jsonData([
            'message' => 'Data Found',
            'data' => $permission->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @param Request $request
     * @param Permission $permission
     * @return JsonResponse
     */
    public function update(string $id, Request $request, Permission $permission): JsonResponse
    {
        try {
            return jsonData([
                'message' => 'Data Update',
                'data' => $permission->find($id)->update($request->all())
            ]);
        } catch (\Exception $e) {
            return jsonData([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(string $id, Permission $permission): JsonResponse
    {
        return jsonData([
            'message' => 'Data Deleted',
            'data' => $permission->destroy($id)
        ]);
    }

    public function getAllPermissions(): JsonResponse
    {
        $permissions = Permission::where('guard_name', get_guard())->get();

        $response = $permissions->map(fn ($permission) => [
            'label' => $permission->name,
            'value' => $permission->name
        ]);

        return jsonData([
            'message' => 'Data Found',
            'data' => $response
        ]);
    }
}
