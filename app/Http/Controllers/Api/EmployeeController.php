<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'opvr_enabled' => 'sometimes|boolean',
            'hire_month' => 'sometimes|date',
        ]);

        $data['hire_month'] = isset($data['hire_month'])
            ? $this->normalizeMonth($data['hire_month'])
            : date('Y-m-01');

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
            'opvr_enabled' => 'sometimes|boolean',
            'hire_month' => 'sometimes|date',
        ]);

        if (isset($data['hire_month'])) {
            $data['hire_month'] = $this->normalizeMonth($data['hire_month']);

            $terminated = $employee->terminated_month;
            if ($terminated !== null && $data['hire_month'] > $terminated->format('Y-m-01')) {
                return response()->json([
                    'message' => 'Hire month cannot be later than the termination month.',
                ], 422);
            }
        }

        $employee->update($data);

        return response()->json($employee);
    }

    public function terminate(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'terminated_month' => 'required|date',
        ]);

        $terminatedMonth = $this->normalizeMonth($data['terminated_month']);

        if ($terminatedMonth < $employee->hire_month->format('Y-m-01')) {
            return response()->json([
                'message' => 'Termination month cannot be earlier than the hire month.',
            ], 422);
        }

        $employee->update([
            'terminated_month' => $terminatedMonth,
        ]);

        return response()->json($employee);
    }

    public function restore(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $employee->update(['terminated_month' => null]);

        return response()->json($employee);
    }

    public function destroy(Request $request, Employee $employee)
    {
        if ($employee->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($employee->terminated_month === null) {
            return response()->json([
                'message' => 'Cannot delete an active employee. Terminate the employee first.',
            ], 422);
        }

        $employee->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function normalizeMonth(string $date): string
    {
        return date('Y-m-01', strtotime($date));
    }
}
