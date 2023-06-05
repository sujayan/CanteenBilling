<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

                <a href="{{ route('dish.index') }}">
                    {{ __('Dishes') }}
                </a>
            </h2>
            <a href="{{ route('dish.create') }}" class="ml-5 underline text-white">Add Dish</a>
        </div>
    </x-slot>

    <div class="py-12  text-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-5">
                        @include('partials._search')
                    </div>
                    <table class="w-full text-center ">
                        @if(count($dishes))
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                        @endif
                        

                        @forelse ($dishes as $dish)
                            <tr>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">{{ $dish->name }}</td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">Rs {{ $dish->price }}
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="{{ route('dish.edit', $dish->id) }}" class="ml-5 underline">Edit</a>
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <form class="ml-2" action="{{ route('dish.destroy', $dish->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @method('delete')
                                        @csrf
                                        <x-primary-button>Delete</x-primary-button>
                                    </form>
                                </td>
                            </tr>




                        @empty
                            <p>No dishes found</p>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 p-10">
        {{-- paginate link --}}
        {{ $dishes->withQueryString()->links() }}
    </div>
</x-app-layout>
