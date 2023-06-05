<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', function () {

   if(auth()->user()->role == "Admin") {
       return redirect()->route('user.index');
    }
    else{
       return redirect()->route('employee.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware(['adminCheck'])->group(function () {
        //User Controller
        Route::resource('user', UserController::class);
        Route::get('/user/{user}/createNewPassword', [UserController::class, 'createNewPassword'])->name('user.createNewPassword');
        Route::patch('/user/{user}/updatePassword', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    });
    Route::middleware(['notAdminCheck'])->group(function () {
        Route::middleware(['canteenCheck'])->group(function () {
            //Dish Controller
            Route::resource('dish', DishController::class);
            //Cart Controller
            Route::get('/cart/{employee}/create', [CartController::class, 'create'])->name('cart.create');
            Route::get('/cart/{employee}/show', [CartController::class, 'show'])->name('cart.show');
            Route::patch('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
            Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
            Route::delete('/cart/{cart}/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
        });

        Route::middleware(['financeCheck'])->group(function () {
            Route::patch('/expense/{expense}/pay', [ExpenseController::class, 'pay'])->name('expense.pay');
            Route::patch('/expense/{employee}/payAll', [ExpenseController::class, 'payAll'])->name('expense.payAll');
        });

        //Employee Controller
        Route::resource('employee', EmployeeController::class);

        // Expense Controller
        Route::resource('expense', ExpenseController::class);
        Route::get('/expense/{employee}/show', [ExpenseController::class, 'show'])->name('expense.show');
    });
    // Profile Controller
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
