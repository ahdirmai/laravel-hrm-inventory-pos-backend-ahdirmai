<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{

    // index
    public function index()
    {
        $leaves = Leave::with(['company', 'user', 'leaveType'])->get();
        return response()->json([
            'message' => 'Leaves fetched successfully',
            'data' => $leaves
        ], 200);
    }

    // store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'is_half_day' => 'required|boolean',
            'reason' => 'nullable|string',
            'is_paid' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $leave = Leave::create([
                'company_id' => 1,
                'user_id' => $request->user_id,
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_days' => $request->total_days,
                'is_half_day' => $request->is_half_day,
                'status' => 'pending',
                'reason' => $request->reason,
                'is_paid' => $request->is_paid,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Leave created successfully',
                'data' => $leave
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // show
    public function show($id)
    {
        $leave = Leave::with(['company', 'user', 'leaveType'])->find($id);
        if (!$leave) {
            return response()->json([
                'message' => 'Leave not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Leave fetched successfully',
            'data' => $leave
        ], 200);
    }

    // update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'is_half_day' => 'required|boolean',
            'status' => 'required',
            'reason' => 'nullable|string',
            'is_paid' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $leave = Leave::find($id);
        if (!$leave) {
            return response()->json([
                'message' => 'Leave not found',
            ], 404);
        }

        try {
            DB::beginTransaction();

            $leave->update($request->all());

            DB::commit();

            return response()->json([
                'message' => 'Leave updated successfully',
                'data' => $leave
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // destroy
    public function destroy($id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            return response()->json([
                'message' => 'Leave not found',
            ], 404);
        }

        try {
            DB::beginTransaction();

            $leave->delete();

            DB::commit();

            return response()->json([
                'message' => 'Leave deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
