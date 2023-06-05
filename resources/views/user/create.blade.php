<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST" action="{{ route('user.store') }}"
            class="text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
            @csrf
            <h1 class="text-white flex justify-center"> Add User</h2>
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input oninput="this.value = this.value.toUpperCase()" id="name" class="block mt-1 w-full"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>



                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Role -->
                <div class="mt-4 w-full ">
                    <x-input-label for="role" :value="__('Role')" />
                    <select name="role"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="Canteen">Canteen</option>
                        <option value="Finance">Finance</option>
                    </select>
                </div>
                
                <div class="mt-5 flex justify-center">
                    <x-primary-button>
                        {{ __('Add user') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
