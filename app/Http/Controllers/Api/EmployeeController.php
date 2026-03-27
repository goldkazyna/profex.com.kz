<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->employees()->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'net_salary' => 'required|numeric|min:0',
        ]);

        $employee = $request->user()->employees()->create($data);

        return response()->json($employee, 201);
    }

    public function show(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'net_salary' => 'sometimes|numeric|min:0',
        ]);

        $employee->update($data);

        return response()->json($employee);
    }

    public function destroy(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $employee->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
