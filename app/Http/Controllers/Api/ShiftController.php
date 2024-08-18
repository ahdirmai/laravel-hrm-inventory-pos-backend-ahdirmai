<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $shifts = Shift::all();
            return response()->json([
                'message' => 'Shifts retrieved successfully',
                'data' => ['shifts' => $shifts]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching shifts: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching shifts',
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
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'clock_in_time' => 'required|date_format:H:i',
                'clock_out_time' => 'required|date_format:H:i',
                'late_mark_after' => 'required|date_format:H:i',
                'early_clock_in_time' => 'required|date_format:H:i',
                'allow_clock_out_till' => 'required|date_format:H:i',
                'company_id' => 'required|exists:companies,id',
            ]);

            $shift = Shift::create($validatedData);

            DB::commit();
            return response()->json([
                'message' => 'Shift created successfully',
                'data' => ['shift' => $shift]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating shift: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while creating the shift',
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
            $shift = Shift::findOrFail($id);
            return response()->json([
                'message' => 'Shift retrieved successfully',
                'data' => ['shift' => $shift]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching shift: ' . $e->getMessage());
            return response()->json([
                'message' => 'Shift not found',
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
            DB::beginTransaction();

            $shift = Shift::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'clock_in_time' => 'required|date_format:H:i',
                'clock_out_time' => 'required|date_format:H:i',
                'late_mark_after' => 'date_format:H:i',
                'early_clock_in_time' => 'date_format:H:i',
                'allow_clock_out_till' => 'date_format:H:i',
                'company_id' => 'exists:companies,id',
            ]);

            $shift->update($validatedData);

            DB::commit();
            return response()->json([
                'message' => 'Shift updated successfully',
                'data' => ['shift' => $shift]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating shift: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the shift',
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
            DB::beginTransaction();

            $shift = Shift::findOrFail($id);
            $shift->delete();

            DB::commit();
            return response()->json([
                'message' => 'Shift deleted successfully',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting shift: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the shift',
                'data' => null
            ], 500);
        }
    }
}
