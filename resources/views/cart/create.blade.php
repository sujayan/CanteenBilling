<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

                <a href="{{ route('cart.create', $employee->id) }}">
                    {{ __('View Cart') }}
                </a>
            </h2>
            <a href="{{ route('cart.show', $employee->id) }}" class="ml-5 underline text-white">View Cart</a>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
    @include('partials._search')
    </div>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        
           
            <table class="w-full text-center">
                @if(count($dishes))
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Price(in Rs)</th>
                </tr>
                @endif

           

                @forelse ($dishes as $dish)
                    <form method="POST" action="{{ route('cart.store') }}">
                        @csrf
                        <tr>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg"> {{ $count++ }}
                            </td>
                           
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg"> 
                                {{ $dish->name }} </td>
                            <x-text-input id="dish_id" class="mt-1" type="hidden" name="dish_id"
                                value="{{ $dish->id }}" />
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">{{ $dish->price }}
                            </td>


                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-text-input id="quantity" class="mt-1" type="number" name="quantity"
                                    :value="old('quantity')" required autofocus autocomplete="Quantity" />
                                @error('quantity')
                                    <p class="">{{ $message }}</p>
                                @enderror
                                <x-primary-button type="submit">
                                    Add To Cart
                                </x-primary-button>
                            </td>


                        </tr>


                    </form>
                @empty
                    <p>No dish found</p>
                @endforelse
            </table>

    </div>
    <div class="mt-6 p-10">
        {{-- paginate link --}}
        {{ $dishes->links() }}
    </div>
</x-app-layout>
