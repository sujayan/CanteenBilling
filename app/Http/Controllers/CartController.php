<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Employee;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //    
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        $count = 1;
      
        $dishes = Dish::oldest()->filter(request(['search']))->paginate(5);
        return view('cart.create', compact('dishes', 'employee', 'count'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'dish_id' => 'required',
            'quantity' => 'required'
        ]);

        $dish = Dish::find($formFields['dish_id']);

        $cart = session()->get('cart');

        if (isset($cart[$formFields['dish_id']])) {
            $cart[$formFields['dish_id']] = [
                'dish_id'=>$formFields['dish_id'],
                'name' => $dish->name,
                'price' =>  intval($dish->price),
                'quantity' =>  intval($cart[$formFields['dish_id']]['quantity'] + $request['quantity']),
                'total'=> intval(($dish->price) *($cart[$formFields['dish_id']]['quantity'] + $request['quantity']))
            ];
        } else {
            $cart[$formFields['dish_id']] = [
                'dish_id'=>$formFields['dish_id'],
                'name' => $dish->name,
                'price' => intval($dish->price),
                'quantity' => intval($formFields['quantity']),
                'total'=> intval($dish->price) * intval($formFields['quantity'])
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('message', "$dish->name ADDED TO CART");
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $count = 1;
        $dishes = Dish::all();
        $carts = session()->get('cart');
        return view('cart.show', compact('employee', 'dishes', 'count', 'carts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        // return view('dish.edit ', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        $cart[$id]['quantity'] = intval($request->quantity);
        $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
        session()->put('cart', $cart);

        return redirect()->back()->with('message', 'Quantity Updated');;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cart = session()->get('cart');

        unset($cart[$id]);
       
        session()->put('cart', $cart);

        return redirect()->back()->with('message', 'Order Removed From Cart');;
    }
}
