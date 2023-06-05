<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_company_id',
        'employee_name',
        'pending',
        'paid',
        'total',
        'employeeStatus',
    ];



    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    //Filter
    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('employee_company_id', 'like', '%' . request('search') . '%')
                ->orWhere('employee_name', 'like', '%' . request('search') . '%');
        }
        if ($filters['filter'] ?? false) {
            if ($filters['filter'] == 'Unpaid') {
                $query->where('pending', '<>', 0);
            }
            if ($filters['filter'] == 'Not Employed') {
                $query->where('employeeStatus','Not Employed');
            }
            if ($filters['filter'] == 'Employed') {
                $query->where('employeeStatus','<>','Not Employed');
            }
            if ($filters['filter'] == 'Employed And Paid') {
                $query->where('employeeStatus','<>','Not Employed')
                ->where('pending',0);
            }
        }
    }
}
