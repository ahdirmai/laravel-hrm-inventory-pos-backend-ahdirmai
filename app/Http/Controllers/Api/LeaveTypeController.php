<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return response()->json([
            'message' => 'Leave Types fetched successfully',
            'data' => $leaveTypes
        ], 200);
    }

    // store
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required|string|max:255',
            'is_paid' => 'required',
            'total_leave' => 'required|integer',
            'max_leave_per_month' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            $leaveType = LeaveType::create([
                'name' => $request->name,
                'is_paid' => $request->is_paid,
                'total_leave' => $request->total_leave,
                'max_leave_per_month' => $request->max_leave_per_month,
                'company_id' => 1,
                'created_by' => $request->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Leave Type created successfully',
                'data' => $leaveType
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave Type creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // show
    public function show($id)
    {
        $leaveType = LeaveType::find($id);
        // if not found
        if (!$leaveType) {
            return response()->json([
                'message' => 'Leave Type not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Leave Type fetched successfully',
            'data' => $leaveType
        ], 200);
    }

    // update
    public function update(Request $request, $id)
    {
        // validate
        $request->validate([
            'name' => 'required|string|max:255',
            'is_paid' => 'required',
            'total_leave' => 'required|integer',
            'max_leave_per_month' => 'required|integer',
        ]);

        // find leave type
        $leaveType = LeaveType::find($id);
        // if not found
        if (!$leaveType) {
            return response()->json([
                'message' => 'Leave Type not found',
            ], 404);
        }

        try {
            DB::beginTransaction();

            $leaveType->update([
                'name' => $request->name,
                'is_paid' => $request->is_paid,
                'total_leave' => $request->total_leave,
                'max_leave_per_month' => $request->max_leave_per_month,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Leave Type updated successfully',
                'data' => $leaveType
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave Type update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // destroy
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $leaveType = LeaveType::find($id);

            // if not found
            if (!$leaveType) {
                return response()->json([
                    'message' => 'Leave Type not found',
                ], 404);
            }

            $leaveType->delete();

            DB::commit();

            return response()->json([
                'message' => 'Leave Type deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Leave Type deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
