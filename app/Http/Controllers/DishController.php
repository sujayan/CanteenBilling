<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Employee;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::oldest()->filter(request(['search']))->paginate(5);;
        return view('dish.index', compact('dishes'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dish.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {
        $dish = Dish::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return response()->redirectToRoute('dish.index')->with('message', 'Dish Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        return view('dish.edit ', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        $dish->update($request->validated());

        return redirect(route('dish.index'))->with('message', 'Dish Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {       
        $dish->delete();
        return redirect(route('dish.index'))->with('message', 'Dish Deleted');
    }
}
