<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_company_id',
        'employee_name',
        'dish_id',
        'dish_name',
        'quantity',
        'total',
        'user_id',
        'canteen_name',
        'status',
        'status_changed_by_id',
        'status_changed_by_name',
        'finance_name'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    

   

    public function scopeFilter($query, array $filters)
    {
        $fromDate = array_key_exists('from',$filters) ? $filters['from'] : null;
        $toDate = array_key_exists('to',$filters) ? $filters['to'] : null;
   
        if ($filters['status'] ?? false) {
            $query->where('status', request('status'));
        } 
        if (isset($fromDate) && isset($toDate)) 
        {
            $query->whereBetween('created_at', [new DateTime($fromDate),new DateTime($toDate.'23:59:59')]);
        } elseif (isset($fromDate)) {
            $query->whereBetween('created_at', [new DateTime($fromDate),new DateTime($fromDate.'23:59:59')]);
        
        } elseif (isset($toDate)) {
            $query->whereBetween('created_at', [new DateTime($toDate),new DateTime($toDate.'23:59:59')]);
        }
        if ($filters['filter'] ?? false) {
            if ($filters['filter'] == 'Unpaid') {
                $query->where('status','Unpaid');
            }
            if ($filters['filter'] == 'Not Employed') {
                $employee_ids=EmployeeExpense::where('employeeStatus','Not Employed')->pluck('employee_id');
                $query->whereIn('employee_id',$employee_ids);
                
            }
            if ($filters['filter'] == 'Employed') {
                $employee_ids=EmployeeExpense::where('employeeStatus',null)->pluck('employee_id');
                $query->whereIn('employee_id',$employee_ids);
            }
            if ($filters['filter'] == 'Employed And Paid') {
                $employee_ids=EmployeeExpense::where('employeeStatus',null)
                ->where('pending',0)
                ->pluck('employee_id');
                $query->whereIn('employee_id',$employee_ids)
                ->where('status','Paid');
            }
        }
    }

    public static function getDate($date)
    {
        $date = Carbon::parse($date);
        return $date->format('Y-m-d');
    }
   

    public static function getPaidAmountByEmployeeId($employee_id,$from,$to){
        $filters=[
            'from'=>$from,
            'to'=>$to
        ];
        $expenses = Expense::where('employee_id',$employee_id)->filter($filters)->get();
       $paid=0;
       foreach($expenses as $expense)
       {
            if($expense->status =="Paid"){
                $paid=$expense->total+$paid;
            }
        
       }
       return $paid;
    }
    public static function getUnPaidAmountByEmployeeId($employee_id,$from,$to){
        $filters=[
            'from'=>$from,
            'to'=>$to
        ];
        $expenses = Expense::where('employee_id',$employee_id)->filter($filters)->get();
        $unpaid=0;
        foreach($expenses as $expense)
        {
             if($expense->status =="Unpaid"){
                 $unpaid=$expense->total+$unpaid;
             }
         
        }
        return $unpaid;
     }
     public function employee()
     {
         return $this->belongsTo(Employee::class);
     }
 
     public function employeeExpense()
     {
         return $this->belongsTo(EmployeeExpense::class);
     }

     public function dish()
     {
         return $this->belongsTo(Dish::class);
     }
}
