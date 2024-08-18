<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
{
    public function index()
    {
        try {
            $payrolls = Payroll::all();
            return response()->json(['message' => 'Payrolls retrieved successfully', 'data' => $payrolls], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching payrolls', 'data' => null], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'company_id' => 'required|exists:companies,id',
                'month' => 'required|integer|min:1|max:12',
                'year' => 'required|integer|min:2000|max:2100',
                'basic_salary' => 'required|numeric|min:0',
                'net_salary' => 'required|numeric|min:0',
                'total_days' => 'required|integer|min:1|max:31',
                'total_working_days' => 'required|integer|min:0',
                'total_present_days' => 'required|integer|min:0',
                'total_office_time' => 'required|date_format:H:i:s',
                'total_worked_time' => 'required|date_format:H:i:s',
                'half_days' => 'required|integer|min:0',
                'late_days' => 'required|integer|min:0',
                'unpaid_leave' => 'required|integer|min:0',
                'paid_leave' => 'required|integer|min:0',
                'holiday_count' => 'required|integer|min:0',
                'payment_date' => 'required|date',
                'status' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'data' => $validator->errors()], 422);
            }

            DB::beginTransaction();
            $payroll = Payroll::create($request->all());
            DB::commit();

            return response()->json(['message' => 'Payroll created successfully', 'data' => $payroll], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating payroll', 'data' => null], 500);
        }
    }

    public function show($id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            return response()->json(['message' => 'Payroll retrieved successfully', 'data' => $payroll], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payroll not found', 'data' => null], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'exists:users,id',
                'company_id' => 'exists:companies,id',
                'month' => 'integer|min:1|max:12',
                'year' => 'integer|min:2000|max:2100',
                'basic_salary' => 'numeric|min:0',
                'net_salary' => 'numeric|min:0',
                'total_days' => 'integer|min:1|max:31',
                'total_working_days' => 'integer|min:0',
                'total_present_days' => 'integer|min:0',
                'total_office_time' => 'date_format:H:i:s',
                'total_worked_time' => 'date_format:H:i:s',
                'half_days' => 'integer|min:0',
                'late_days' => 'integer|min:0',
                'unpaid_leave' => 'integer|min:0',
                'paid_leave' => 'integer|min:0',
                'holiday_count' => 'integer|min:0',
                'payment_date' => 'date',
                'status' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'data' => $validator->errors()], 422);
            }

            DB::beginTransaction();
            $payroll = Payroll::findOrFail($id);
            $payroll->update($request->all());
            DB::commit();

            return response()->json(['message' => 'Payroll updated successfully', 'data' => $payroll], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating payroll', 'data' => null], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $payroll = Payroll::findOrFail($id);
            $payroll->delete();
            DB::commit();

            return response()->json(['message' => 'Payroll deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting payroll', 'data' => null], 500);
        }
    }
}
