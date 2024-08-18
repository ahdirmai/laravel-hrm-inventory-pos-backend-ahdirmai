<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $designations = Designation::where('company_id', Auth::user()->company_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $designations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching designations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $designation = Designation::create([
                'name' => $request->name,
                'description' => $request->description,
                'company_id' => Auth::user()->company_id,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Designation created successfully',
                'data' => $designation
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $designation = Designation::where('company_id', Auth::user()->company_id)->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $designation
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Designation not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $designation = Designation::where('company_id', Auth::user()->company_id)->findOrFail($id);
            $designation->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Designation updated successfully',
                'data' => $designation
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Designation not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $designation = Designation::where('company_id', Auth::user()->company_id)->findOrFail($id);
            $designation->delete();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Designation deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Designation not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
