<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class AttendanceController extends Controller
{


    /**
     * Display a listing of the attendances.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $attendances = Attendance::all();
            return response()->json(['data' => $attendances], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error retrieving attendances', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created attendance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'shift_id' => 'required|exists:shifts,id',
            'leave_id' => 'nullable|exists:leaves,id',
            'leave_type_id' => 'nullable|exists:leave_types,id',
            'holiday_id' => 'nullable|exists:holidays,id',
            'is_holiday' => 'boolean',
            'is_leave' => 'boolean',
            'date' => 'required|date',
            'clock_in_date_time' => 'nullable|date',
            'clock_out_date_time' => 'nullable|date',
            'total_duration' => 'nullable',
            'is_late' => 'boolean',
            'is_half_day' => 'boolean',
            'is_paid' => 'boolean',
            'status' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $attendance = Attendance::create([
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'shift_id' => $request->shift_id,
                'leave_id' => $request->leave_id,
                'leave_type_id' => $request->leave_type_id,
                'holiday_id' => $request->holiday_id,
                'is_holiday' => $request->is_holiday,
                'is_leave' => $request->is_leave,
                'date' => $request->date,
                'clock_in_date_time' => $request->clock_in_date_time,
                'clock_out_date_time' => $request->clock_out_date_time,
                'total_duration' => $request->total_duration,
                'is_late' => $request->is_late,
                'is_half_day' => $request->is_half_day,
                'is_paid' => $request->is_paid,
                'status' => $request->status,
                'reason' => $request->reason,
            ]);
            DB::commit();
            return response()->json(['message' => 'Attendance created successfully', 'data' => $attendance], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating attendance', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified attendance.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            return response()->json(['data' => $attendance], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Attendance not found', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified attendance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'company_id' => 'exists:companies,id',
            'shift_id' => 'exists:shifts,id',
            'leave_id' => 'nullable|exists:leaves,id',
            'leave_type_id' => 'nullable|exists:leave_types,id',
            'holiday_id' => 'nullable|exists:holidays,id',
            'is_holiday' => 'boolean',
            'is_leave' => 'boolean',
            'date' => 'date',
            'clock_in_date_time' => 'nullable|date',
            'clock_out_date_time' => 'nullable|date',
            'total_duration' => 'nullable',
            'is_late' => 'boolean',
            'is_half_day' => 'boolean',
            'is_paid' => 'boolean',
            'status' => 'string',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $attendance = Attendance::findOrFail($id);
            $attendance->update([
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'shift_id' => $request->shift_id,
                'leave_id' => $request->leave_id,
                'leave_type_id' => $request->leave_type_id,
                'holiday_id' => $request->holiday_id,
                'is_holiday' => $request->is_holiday,
                'is_leave' => $request->is_leave,
                'date' => $request->date,
                'clock_in_date_time' => $request->clock_in_date_time,
                'clock_out_date_time' => $request->clock_out_date_time,
                'total_duration' => $request->total_duration,
                'is_late' => $request->is_late,
                'is_half_day' => $request->is_half_day,
                'is_paid' => $request->is_paid,
                'status' => $request->status,
                'reason' => $request->reason,
            ]);
            DB::commit();
            return response()->json(['message' => 'Attendance updated successfully', 'data' => $attendance], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating attendance', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified attendance from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            DB::commit();
            return response()->json(['message' => 'Attendance deleted successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting attendance', 'error' => $e->getMessage()], 500);
        }
    }
}
