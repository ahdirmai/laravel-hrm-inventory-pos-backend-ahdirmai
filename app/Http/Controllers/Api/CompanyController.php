<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:191',
            'website' => 'nullable|url|max:191',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:1000',
            'status' => 'required|string|max:191',
            'total_users' => 'required|integer',
            'clock_in_time' => 'required|date_format:H:i:s',
            'clock_out_time' => 'required|date_format:H:i:s',
            'early_clock_in_time' => 'nullable|integer',
            'allow_clock_out_till' => 'nullable|integer',
            'self_clocking' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileName = Str::slug($$request->name) . '.' . $extension;
            $logoPath = $request->file('logo')->storeAs('company_logos', $fileName, 'public');
            $data['logo'] = $logoPath;
        }

        $company = Company::create($data);
        return response()->json($company, 201);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:191',
            'website' => 'nullable|url|max:191',
            'logo' => 'nullable|string|max:191',
            'address' => 'nullable|string|max:1000',
            'status' => 'sometimes|required|string|max:191',
            'total_users' => 'sometimes|required|integer',
            'clock_in_time' => 'sometimes|required|date_format:H:i:s',
            'clock_out_time' => 'sometimes|required|date_format:H:i:s',
            'early_clock_in_time' => 'nullable|integer',
            'allow_clock_out_till' => 'nullable|integer',
            'self_clocking' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company->update($request->all());
        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, 204);
    }
}
