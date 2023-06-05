<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST" action="{{ route('dish.update', $dish->id) }}"
            class="text-white dark:bg-gray-800 mt-10 px-4 py-4 shadow-md  sm:rounded-lg">
            @csrf
            @method('patch')
            <h1 class="text-white flex justify-center"> Update Dish</h2>
             
                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full"  oninput="this.value = this.value.toUpperCase()" type="text" name="name" :value="old('name')"
                        required value="{{$dish->name}}"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

               
                    <!-- Price -->
                <div class="mt-4">
                    <x-input-label for="price" :value="__('Price(in Rs)')" />
                    <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')"
                    required value="{{$dish->price}}" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div class="mt-5 flex justify-center">
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
