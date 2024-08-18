<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json(
            [
                'message' => 'Roles fetched successfully',
                'data' => $roles,
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // validate
            $request->validate([
                'name' => 'required|unique:roles|max:255',
                'display_name' => 'nullable|max:255',
                'description' => 'nullable|max:255',
            ]);

            // create
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'company_id' => 1,
            ]);

            DB::commit();

            return response()->json(
                [
                    'message' => 'Role created successfully',
                    'data' => $role,
                ],
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => 'Failed to create role',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(
                [
                    'message' => 'Role not found',
                ],
                404
            );
        }

        return response()->json(
            [
                'message' => 'Role fetched successfully',
                'data' => $role,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            // validate
            $request->validate([
                'name' => 'required|unique:roles|max:255',
                'permissionsIds' => 'required|array',
            ]);

            // update
            $role = Role::find($id);
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            $role->permissions()->sync($request->permissionsIds);

            DB::commit();

            return response()->json(
                [
                    'message' => 'Role updated successfully',
                    'data' => $role,
                ],
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => 'Failed to update role',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
