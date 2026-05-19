<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerPayrollController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'salary' => $user->owner_payroll_salary,
            'start_month' => optional($user->owner_payroll_start_month)->format('Y-m-d'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'salary' => 'sometimes|numeric|min:0',
            'start_month' => 'sometimes|date',
        ]);

        $user = $request->user();
        if (isset($data['salary'])) {
            $user->owner_payroll_salary = $data['salary'];
        }
        if (isset($data['start_month'])) {
            $user->owner_payroll_start_month = date('Y-m-01', strtotime($data['start_month']));
        }
        $user->save();

        return response()->json([
            'salary' => $user->owner_payroll_salary,
            'start_month' => optional($user->owner_payroll_start_month)->format('Y-m-d'),
        ]);
    }
}
