<x-app-layout>
    <x-flash-message />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            <a href="{{ route('user.index') }}">
                {{ __('Users') }}
            </a>
        </h2>
    </x-slot>
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-5">
                    @include('partials._search')
                </div>
                <table class='ml-3 text-center'>
                    @if(count($users))
                    <tr>
                        <th>
                            Name
                          
                        </th>
                        <th>  Role</th>
                    </tr>
                    @endif
             
                @forelse ($users as $user)
                <tr>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{$user->name}}
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                       {{$user->role}} 
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <a href="{{ route('user.edit', $user->id) }}" class="underline">Edit</a>
                           
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <form class="ml-2" action="{{ route('user.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @method('delete')
                            @csrf
                            <button class="underline">Delete</button>
                        </form>
                    </td>
                
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <a href="{{ route('user.createNewPassword', $user->id) }}" onclick="return confirm('Are you sure?')" class="underline">New password</a>
                               
                        </td>
                    </td>
                </tr>
              
                @empty
                    <p>No user found</p>
                @endforelse
            </table>
            </div>
        </div>
    </div>
    {{-- paginate link --}}
    <div class="mt-6 p-10">
       
         {{ $users->withQueryString()->links() }}
     </div>
</x-app-layout>
