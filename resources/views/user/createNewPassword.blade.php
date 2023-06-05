<x-app-layout>
    <div class="mt-6 max-w-sm mx-auto">
        <form method="POST" onsubmit="return confirm('Are you sure?')"
            action="{{ route('user.updatePassword', $user->id) }}"
            class="text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
            @csrf
            @method('patch')
            <h1 class="text-white flex justify-center"> Add New Password</h2>


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


                <div class="mt-5 flex justify-center">
                    <x-primary-button>
                        {{ __('Update password') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
