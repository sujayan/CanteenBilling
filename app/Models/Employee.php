<?php

namespace App\Models;

use DateTime;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_company_id',
        'email',
        'fname',
        'lname',
        'number',
    ];
    


    //Filter
    public function scopeFilter($query, array $filters)
    {
       if($filters['search'] ?? false)
       {
            $query ->where('employee_company_id','like','%'. request('search').'%')
            ->orWhere('fname','like','%'. request('search').'%')
            ->orWhere('lname','like','%'. request('search').'%'); 
       }

        if ($filters['due'] ?? false) {
         $query->where('due', '<>',0);
     } 
       
     } 

    public function expenses()
   {
      return $this->hasMany(Expense::class);
   }
   public function employeeExpenses()
   {
      return $this->hasMany(EmployeeExpense::class);
   }
}
