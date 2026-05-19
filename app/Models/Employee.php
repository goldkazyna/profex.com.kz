<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'net_salary',
        'opvr_enabled',
        'hire_month',
        'terminated_month',
    ];

    protected function casts(): array
    {
        return [
            'net_salary' => 'decimal:2',
            'opvr_enabled' => 'boolean',
            'hire_month' => 'date:Y-m-d',
            'terminated_month' => 'date:Y-m-d',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
