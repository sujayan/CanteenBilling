<?php

namespace App\Http\Controllers;


use App\Models\Dish;
use App\Models\Expense;
use App\Models\Employee;

use Illuminate\Http\Request;
use App\Models\EmployeeExpense;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {  
        $expenses= Expense::filter(request(['search','to','from','filter']))->get();
        $pendingTotal = 0;
        $paidTotal = 0;
        foreach ($expenses as $expense) {
            if($expense->status=='Unpaid'){
                $pendingTotal= $expense->total+$pendingTotal;
            }
            else{
                 $paidTotal = $expense->total+$paidTotal;
            }                   
        }
        $employees = Employee::all();

        $employeeExpenses= EmployeeExpense::filter(request(['search','filter']))->paginate(5);
        
        return view('expense.index', compact('employees','expenses','paidTotal','pendingTotal','employeeExpenses'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $expenses= $employee->expenses()->filter(request(['search','to','from']))->get();
        $pendingTotal = 0;
        $paidTotal = 0;
        foreach ($expenses as $expense) {
            if($expense->status=='Unpaid'){
                $pendingTotal= $expense->total+$pendingTotal;
            }
            else{
                 $paidTotal = $expense->total+$paidTotal;
            }                   
        }
        $expenses = $employee->expenses()->filter(request(['status', 'from', 'to']))->paginate(5);

        return view('expense.show', compact('employee','expenses','paidTotal', 'pendingTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        $carts = session()->get('cart');

        $formFields = $request->validate([
            'employee_id' => 'required',
            'employee_company_id' => 'required',
            'employee_name' => 'required',
        ]);
        foreach ($carts as $cart) {
            $dish_name = Dish::find($cart['dish_id'])->name;
            Expense::create([
                'employee_id' => $formFields['employee_id'],
                'employee_company_id' => $formFields['employee_company_id'],
                'employee_name' => $formFields['employee_name'],
                'dish_id' => $cart['dish_id'],
                'dish_name' => $dish_name,
                'quantity' =>  $cart['quantity'],
                'total' => $cart['total'],
                'user_id' => auth()->user()->id,
                'canteen_name' => auth()->user()->name,
                'status' => 'Unpaid'
            ]);
            $this->employeeExpenseCreateOrUpdate($formFields['employee_id'], $cart['total']);
        }

        session()->put('cart');

        return response()->redirectToRoute('dashboard')->with('message', 'Order added');
    }

    public function employeeExpenseCreateOrUpdate($employee_id, $total)
    {
        $employee = Employee::find($employee_id);
        $oldTotal = 0;
        $oldPending = 0;
        $expenses = $employee->employeeExpenses;

        foreach ($expenses as $expense) {
            $oldTotal = $expense->total;
            $oldPending = $expense->pending;
        }

        EmployeeExpense::updateOrCreate(
            ['employee_id' => $employee_id],
            [
                'employee_name' => $employee->fname . ' ' . $employee->lname,
                'employee_company_id' => $employee->employee_company_id,
                'paid' => $oldTotal - $oldPending,
                'pending' => $total + $oldPending,
                'total' => $total + $oldTotal,
            ]
        );
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function pay(Expense $expense)
    {

        $expense->update(
            [
                'status' => 'Paid',
                'status_changed_by_name' => auth()->user()->name,
                'status_changed_by_id' => auth()->user()->id
            ]
        );
        $oldPaid = 0;
        $paid = $expense->total;

        $employeeExpenses = $expense->employee->employeeExpenses;

        foreach ($employeeExpenses as $employeeExpense) {
            $oldPaid = $employeeExpense->paid;
            $oldPending = $employeeExpense->pending;
            $employeeExpense->update(
                [
                    'pending' => $oldPending - $paid,
                    'paid' => $oldPaid + $paid,
                ]
            );
        }


        return redirect()->back()->with('message', 'Expense Paid');;
    }
    public function payAll(Employee $employee, Request $request)
    {
        $oldPending = 0;
        $oldPaid = 0;
        $paid = 0;
        $expenses = $employee->expenses()->filter(request(['status', 'from', 'to']))->get();
        foreach ($expenses as $expense) {
            $expense->update(
                [
                    'status' => 'Paid',
                    'status_changed_by_id' => auth()->user()->id,
                    'status_changed_by_name' => auth()->user()->name
                ]
            );
            $paid = $expense->total + $paid;
        }

        $employeeExpenses = $expense->employee->employeeExpenses;

        foreach ($employeeExpenses as $employeeExpense) {
            $oldPaid = $employeeExpense->paid;
            $oldPending = $employeeExpense->pending;
            $employeeExpense->update(
                [
                    'pending' => $oldPending - $paid,
                    'paid' => $oldPaid + $paid,
                ]
            );
        }
        return redirect()->back()->with('message', 'Expenses Paid');;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
