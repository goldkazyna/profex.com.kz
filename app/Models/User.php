<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'provider',
        'provider_id',
        'language',
        'theme',
        'tax_rate',
        'owner_payroll_salary',
        'owner_payroll_start_month',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tax_rate' => 'decimal:2',
            'owner_payroll_salary' => 'decimal:2',
            'owner_payroll_start_month' => 'date:Y-m-d',
        ];
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if ($user->owner_payroll_start_month === null) {
                $user->owner_payroll_start_month = date('Y-m-01');
            }
        });
    }
}
