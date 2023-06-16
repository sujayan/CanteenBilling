<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\EmployeeExpense;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart');
        session()->put('cart');

        $employees = Employee::oldest()->filter(request(['search']))->paginate(5);
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = new Employee($request->validated());
    
        $employee->save();

        return redirect(route('employee.index'))->with('message', 'Employee added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit ', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect(route('employee.index'))->with('message', 'Employee Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employeeExpensesCount = $employee->employeeExpenses()
            ->where('pending', '!=', 0)
            ->count();

        if($employeeExpensesCount) {
            return back()->with('message', 'Clear Expenses first');
        }
       
        EmployeeExpense::query()->where('employee_id', $employee->id)->update([
            'employeeStatus' => 'Not Employed'
        ]);
        
        $employee->delete();
        return redirect(route('employee.index'))->with('message', 'Employee deleted');
    }
}
