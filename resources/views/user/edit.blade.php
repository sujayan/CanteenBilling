<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST"  action="{{ route('user.update',$user->id) }}" class="text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg" >
        @csrf
        @method('patch')
        <h1 class="text-white flex justify-center"> Add User</h2>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name"  oninput="this.value = this.value.toUpperCase()" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required :value="$user->name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required :value="$user->email"  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4 w-full ">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" class = "border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="Canteen" @if ($user->role == "Canteen") selected @else @endif>Canteen</option>
                <option value="Finance" @if ($user->role == "Finance") selected @else @endif>Finance</option>
            </select>
        </div>
        

       

        <div class="mt-5 flex justify-center">
            <x-primary-button>
                {{ __('Update user') }}
            </x-primary-button>
        </div>
    </form>
</div>
</x-app-layout>
