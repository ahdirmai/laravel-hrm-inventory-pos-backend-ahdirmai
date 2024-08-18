<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserHasRole;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roleUsers = UserHasRole::with(['user', 'role'])->get();
            return response()->json([
                'message' => 'Role users retrieved successfully',
                'data' => $roleUsers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving role users',
                'data' => null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ], 422);
            }

            $roleUser = UserHasRole::create($request->all());

            return response()->json([
                'message' => 'Role user created successfully',
                'data' => $roleUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating role user',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $roleUser = UserHasRole::with(['user', 'role'])->findOrFail($id);
            return response()->json([
                'message' => 'Role user retrieved successfully',
                'data' => $roleUser
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Role user not found',
                'data' => null
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ], 422);
            }

            $roleUser = UserHasRole::findOrFail($id);
            $roleUser->update($request->all());

            return response()->json([
                'message' => 'Role user updated successfully',
                'data' => $roleUser
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating role user',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $roleUser = UserHasRole::findOrFail($id);
            $roleUser->delete();

            return response()->json([
                'message' => 'Role user deleted successfully',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting role user',
                'data' => null
            ], 500);
        }
    }
}
