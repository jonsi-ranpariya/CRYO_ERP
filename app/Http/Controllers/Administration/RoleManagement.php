<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maklad\Permission\Models\Role;

class RoleManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): JsonResponse
    {
        $roles = Role::where('guard_name', get_guard())->get();

        return jsonData([
            'data' => $roles,
            'message' => 'Roles Found'
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
            Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            Role::create([
                'name' => $request->name,
                'guard_name' => 'api',
            ]);

            return jsonData([
                'message' => 'Data Saved'
            ]);
        } catch (\Exception $e) {
            return jsonData([
                'message' => 'A role `'.$request->name.'` already exists.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $roleDetails = Role::with('permissions')->find($id);
        return jsonData([
            'message' => 'Data Found',
            'data' => $roleDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $permissions = $request->permissions;
        $name = $request->name;
        $id = $request->_id;

        try {
            $roleDetails = Role::find($id);
            $roles = Role::query()->where('name',$roleDetails->name)->get();
            $roles->each(function ($role) use ($name, $permissions) {
                $role->syncPermissions($permissions);
                $role->name = $name;
                $role->update();
            });

            return jsonData([
                'message' => 'Data Updated'
            ]);
        } catch (\Exception $e) {
            return jsonData([
                'message' => 'A role `'.$name.'` already exists.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->revokePermissionTo($role->permissions);
        $role->delete();

        return jsonData([
            'message' => 'Data Deleted'
        ]);
    }

    public function getAllRoleOptions(): JsonResponse
    {
        $roles = Role::where('guard_name', get_guard())->get();
        $response = $roles->map(fn ($role): array => [
            'label' => $role->name,
            'value' => $role->name
        ]);

        return jsonData([
            'message' => 'Data Found',
            'data' => $response
        ]);
    }
}
