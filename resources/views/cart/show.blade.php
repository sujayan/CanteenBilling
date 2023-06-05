<x-app-layout>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        <form method= "post" action="{{ route('expense.store') }}">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-white flex justify-center mb-5"> Cart: </h1>
                <a href="{{ route('cart.create', $employee->id) }}" class="underline">Add more to cart</a>
            </div>

            <div class="flex justify-between">
                <div class="flex">
                    <!-- Employee Id -->
                    <x-input-label for="employee_id" :value="__('Employee Id:')" />
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <input type="hidden" name="employee_company_id" value="{{ $employee->employee_company_id }}">
                    <x-input-label for="name_label" :value="__($employee->employee_company_id)" />
                </div>
                <div class="flex">
                    <!-- Name -->
                    <x-input-label for="name" :value="__('Name:')" />
                    <input type="hidden" name="employee_name" value="{{ $employee->fname . ' ' . $employee->lname}}">
                    <x-input-label for="name_label" :value="__($employee->fname . ' ' . $employee->lname)" />
                </div>
                <div class="flex justify-center">
                    @if ($carts)
                    <x-primary-button>
                        {{ __('Order') }}
                    </x-primary-button>
                      @endif
                </div>
              

            </div>
        </form>
        <!-- Order -->
        <x-input-label class="mt-4" for="Order" :value="__('Order:')" />
        <div class="mt-4">

            @if ($carts)
                <table class="w-full text-center">
                    <tr>
                        <th>Name</th>
                        <th>Price(in Rs)</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>

                    @foreach($carts as $cart)
                        <tr>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="dish_name" :value="__($cart['name'])" />
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="dish_price" :value="__($cart['price'])" />

                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="post" action="{{ route('cart.update', $cart['dish_id']) }}">
                                    @csrf
                                    @method ('patch')
                                    <div class="flex"><button type="submit" class="text-blue-400">
                                            Update Quantity
                                        </button>
                                        <x-text-input id="quantity" class="block mt-1 max-w-3xl mx-auto" type="number"
                                            name="quantity" :value="old('quantity')" required autofocus
                                            value="{{ $cart['quantity'] }}" />
                                    </div>
                                </form>
                               
                            </td>
                          
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="total" :value="__($cart['total']) " />
                            </td> 
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form class="ml-2" action="{{ route('cart.destroy', $cart['dish_id'] )}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="underline">Remove</button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                </table>
                
            @else
                <p>Cart Empty</p>
            @endif


        </div>

    </div>
</x-app-layout>
