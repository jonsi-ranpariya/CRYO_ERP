<?php

namespace App\Http\Controllers;

use App\Enums\UserTypeEnums;
use App\Http\Requests\Administrator\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Maklad\Permission\Models\Permission;
use Maklad\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userQuery = User::query();
        $query = $request->q;
        if ($request->filled('q')) {
            $userQuery->where('username', 'LIKE', "%$query%");
            $userQuery->where('email', 'LIKE', "%$query%");
            $userQuery->where('first_name', 'LIKE', "%$query%");
            $userQuery->where('last_name', 'LIKE', "%$query%");
            $userQuery->where('status_name', 'LIKE', "%$query%");
        }

        $page = $request->page;
        //$sortBy = $request->sortBy;
        $perPage = $request->perPage;
        if ($request->filled('perPage')) {
            $response = $userQuery->paginate($perPage);
        } else {
            $response = $userQuery->get();
        }


        $data['message'] = "Users Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $dataInsert = $request->validated();
        $dataInsert['password'] = Hash::make($dataInsert['password']);
        $dataInsert['ability'] = json_encode([
            ["action" => "read", "subject" => "Auth"],
            ["action" => "read", "subject" => "ACL"]
        ]);
        $dataInsert['userGeneralDetails'] = $request->userGeneralDetails;
        $dataInsert['userContactDetails'] = $request->userContactDetails;
        $dataInsert['userStatutoryDetails'] = $request->userStatutoryDetails;
        $dataInsert['userCheckListDetails'] = $request->userCheckListDetails;

        $user = User::saveData($dataInsert);
        $roles = Role::with('permissions')->where('name', $dataInsert['role'])->get();
        $roles->each(fn($role): array => [$user->permissions()->saveMany($role->permissions)]);

        $data['message'] = "User Saved";
        $data['status'] = 200;
        $data['data'] = $user;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = User::with('permissions')->find($id);

        $data['message'] = "User found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  $id
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $updateData = $request->all();
        $newPermissions = collect($request->newPermissions)->unique()->values();
        dd($newPermissions);

        $user = User::find($id);
        $user->update($updateData);

        if ($newPermissions->count() > 0) {
            $user->permissions()->sync([]);
            $permissions = Permission::query()->whereIn('name', $newPermissions)->get();
            $user->permissions()->saveMany($permissions);
        }

        $data['message'] = "User Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);
        $user->removeRole($user->role);
        $user->delete();

        $data['message'] = "User Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getAllUsers(): JsonResponse
    {
        $fetchData = User::all();

        $response = $fetchData->map(callback: fn($item): array => [
            'label' => $item->username . " - " . $item->first_name . " " . $item->last_name,
            'value' => $item->_id,
        ]);

        $data['message'] = "Users Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getUsersName(): JsonResponse
    {
        $fetchData = User::all();

        $response = $fetchData->map(callback: fn($item): array => [
            'label' => $item->first_name . " " . $item->last_name,
            'value' => $item->_id,
        ]);

        $data['message'] = "Users Name Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
}
