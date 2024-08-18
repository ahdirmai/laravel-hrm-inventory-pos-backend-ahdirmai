    <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasicSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BasicSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $basicSalaries = BasicSalary::with(['user', 'company'])->get();
            return response()->json([
                'message' => 'Basic salaries retrieved successfully',
                'data' => $basicSalaries
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving basic salaries',
                'error' => $e->getMessage()
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
                'company_id' => 'required|exists:companies,id',
                'amount' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $basicSalary = BasicSalary::create($request->all());

            return response()->json([
                'message' => 'Basic salary created successfully',
                'data' => $basicSalary
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating basic salary',
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
            $basicSalary = BasicSalary::with(['user', 'company'])->findOrFail($id);
            return response()->json([
                'message' => 'Basic salary retrieved successfully',
                'data' => $basicSalary
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Basic salary not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $basicSalary = BasicSalary::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'user_id' => 'exists:users,id',
                'company_id' => 'exists:companies,id',
                'amount' => 'numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $basicSalary->update($request->all());

            return response()->json([
                'message' => 'Basic salary updated successfully',
                'data' => $basicSalary
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating basic salary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $basicSalary = BasicSalary::findOrFail($id);
            $basicSalary->delete();

            return response()->json([
                'message' => 'Basic salary deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting basic salary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
