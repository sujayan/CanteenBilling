<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST" action="{{ route('dish.store') }}"
            class="text-white dark:bg-gray-800 mt-10 px-4 py-4 shadow-md  sm:rounded-lg">
            @csrf
            <x-input-label class="flex justify-center text-3xl" for="add_dish" :value="__('Add Dish')" />

             
                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name"  oninput="this.value = this.value.toUpperCase()" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

               
                    <!-- Price -->
                <div class="mt-4">
                    <x-input-label for="price" :value="__('Price(in Rs)')" />
                    <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')"
                        required autofocus autocomplete="price" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div class="mt-5 flex justify-center">
                    <x-primary-button>
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
