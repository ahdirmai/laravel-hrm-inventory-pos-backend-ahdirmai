<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $departments = Department::all();
        return response()->json([
            'message' => 'Departments retrieved successfully',
            'data' => $departments
        ], 200);
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
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string|max:191|unique:departments',
                'company_id' => 'required|exists:companies,id',
                'description' => 'nullable|string',
            ]);

            $validatedData['created_by'] = Auth::id();

            $department = Department::create($validatedData);

            DB::commit();

            return response()->json([
                'message' => 'Department created successfully',
                'data' => $department
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while creating the department',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $department = Department::findOrFail($id);
        return response()->json([
            'message' => 'Department retrieved successfully',
            'data' => $department
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $department = Department::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:191|unique:departments,name,' . $id,
                'company_id' => 'sometimes|required|exists:companies,id',
                'description' => 'nullable|string',
            ]);

            $validatedData['updated_by'] = Auth::id();

            $department->update($validatedData);

            DB::commit();

            return response()->json([
                'message' => 'Department updated successfully',
                'data' => $department
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while updating the department',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully',
            'data' => null
        ], 200);
    }
}
