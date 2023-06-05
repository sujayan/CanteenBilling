<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            <a href="{{ route('employee.index') }}">
                {{ __('Employees') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-5">
                    @include('partials._search')
                </div>

                <table class="ml-10 text-center">
                    @if (count($employees))
                        <tr>
                            <th>
                                Id
                            </th>
                            <th>
                                Name
                            </th>
                        </tr>
                    @endif
                    @forelse ($employees as $employee)
                        <tr>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                {{ $employee->employee_company_id }}
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                {{ $employee->fname }}
                                {{ $employee->lname }}
                            </td>

                            @if (auth()->user()->role == 'Finance')
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                        class="ml-5 underline">Edit</a>
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <form class="ml-2" action="{{ route('employee.destroy', $employee->id) }}"
                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                        @method('delete')
                                        @csrf
                                        <button class="underline">Delete</button>
                                    </form>
                                </td>
                            @elseif (auth()->user()->role == 'Canteen')
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="{{ route('cart.create', $employee->id) }}" class="ml-5 underline">Add
                                        expenses</a>
                                </td>
                            @endif
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="{{ route('expense.show', $employee->id) }}" class="ml-5 underline">Check
                                    expenses</a>
                            </td>
                        </tr>

                    @empty
                        <p>No Employee found</p>
                    @endforelse

            </div>
            </table>
        </div>
    </div>
    <div class="mt-6 p-10">
        {{-- paginate link --}}
        {{ $employees->withQueryString()->links() }}
    </div>
</x-app-layout>
