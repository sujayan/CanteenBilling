<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST" action="{{ route('employee.store') }}"
            class="text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
            @csrf
            <h1 class="text-white flex justify-center"> Add Employee</h2>
                <!-- Employee Id -->
                <div>
                    <x-input-label for="employee_company_id" :value="__('Employee Id')" />
                    <x-text-input id="employee_company_id" class="block mt-1 w-full" type="text" name="employee_company_id" :value="old('employee_company_id')"
                        required autofocus autocomplete="employee_company_id" />
                    <x-input-error :messages="$errors->get('employee_company_id')" class="mt-2" />
                </div>

                <!-- First Name -->
                <div class="mt-4">
                    <x-input-label for="fname" :value="__('First Name')" />
                    <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')"
                        required autofocus autocomplete="fname" />
                    <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <x-input-label for="lname" :value="__('Last Name')" />
                    <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname"
                        :value="old('lname')" required autofocus autocomplete="lname" />
                    <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                </div>


                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                    <!-- Number -->
                <div class="mt-4">
                    <x-input-label for="number" :value="__('Number')" />
                    <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')"
                        required autofocus autocomplete="number" />
                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                </div>
                <div class="mt-5 flex justify-center">
                    <x-primary-button>
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
