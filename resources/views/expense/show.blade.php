<x-app-layout>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        <a href="{{ route('expense.show', $employee->id) }}">
            <h1 class="text-white flex justify-center text-4xl">Expenses</h1>
        </a>

        <div class="flex justify-between">
            <h1 class="text-white flex justify-center text-xl">Name: {{ $employee->fname }} {{ $employee->lname }}</h1>
            <h1 class="text-white flex justify-center text-xl">Employee id: {{ $employee->employee_company_id }}</h1>
        </div>


    </div>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        <form class="flex justify-around">
            <div>
                <x-input-label for="from" :value="__('From:')" />
                <x-text-input id="from" class="block mt-1 w-full" type="date" name="from" :value="Request::get('from')"
                    autofocus autocomplete="from" />
                <x-input-error :messages="$errors->get('from')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="to" :value="__('To:')" />
                <x-text-input id="to" class="block mt-1 w-full" type="date" name="to" :value="Request::get('to')"
                    autofocus autocomplete="to" />
                <x-input-error :messages="$errors->get('to')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="status" :value="__('Status')" />
                <select name="status"
                    class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="Unpaid" @if (Request::get('status') == 'Unpaid') selected @endif>Unpaid</option>
                    <option value="Paid" @if (Request::get('status') == 'Paid') selected @endif>Paid</option>
                    <option value="" @if (Request::get('status') == '') selected @endif>All</option>
                </select>
            </div>

            <x-primary-button class="mt-7">
                {{ __('Search') }}
            </x-primary-button>

        </form>
    </div>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        <div class="flex justify-between">
    
            <h1 class="text-white flex justify-center text-xl">Pending: Rs {{ $pendingTotal }}</h1>
            @if (Request::get('status') <> 'Unpaid')
            <h1 class="text-white flex justify-center text-xl">Paid: Rs {{ $paidTotal}}</h1>
            <h1 class="text-white flex justify-center text-xl">Total: Rs {{ $paidTotal +$pendingTotal }}</h1>
            @endif
        </div>
    </div>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        @if (count($expenses))

            <table class="w-full text-center">
                @if (count($expenses))

                    <tr>
                        <th>Date</th>
                        <th>Dish</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Canteen</th>
                        @if (auth()->user()->role == 'Finance')
                            <th>Finance</th>
                        @endif

                    </tr>
                @endif

                @foreach ($expenses as $expense)
                    <tr>

                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="date" :value="_($expense->created_at->toDateString())" />
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="name" :value="__($expense->dish_name)" />
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="quantity" :value="__($expense['quantity'])" />
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="total" :value="__('Rs ' . $expense['total'])" />
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="status" :value="__($expense['status'])" />
                        </td>

                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <x-input-label for="user_name" :value="__($expense->canteen_name)" />
                        </td>

                        @if (auth()->user()->role == 'Finance')
                            @if ($expense->status_changed_by_id)
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <x-input-label for="status_changed_by_id" :value="__($expense->status_changed_by_name)" />
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <x-input-label for="status_changed_by_id" :value="__('Paid')" />
                                </td>
                            @else
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <x-input-label for="status_changed_by_id" :value="__('Pending')" />
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <form method="post" action="{{ route('expense.pay', $expense->id) }}"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('patch')
                                        <x-primary-button>
                                          Pay
                                        </x-primary-button>
                                    </form>
                                  
                                </td>
                            @endif
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p class="text-center">No Expenses</p>
        @endif


    </div>
    @if ($pendingTotal && auth()->user()->role == 'Finance')
        <div class="flex justify-center mt-5">
            <form method="post" action="{{ route('expense.payAll', $employee->id) }}"
                onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('patch')
                <x-text-input id="from" class="mt-1" type="hidden" name="from" :value="Request::get('from')" />
                <x-text-input id="to" class="mt-1" type="hidden" name="to" :value="Request::get('to')" />
                <x-text-input id="status" class="mt-1" type="hidden" name="status" value="Unpaid" />
                <x-primary-button>PayAll</a></x-primary-button>
            </form>
        </div>
    @endif

    {{-- paginate link --}}
    <div class="mt-6 p-10">
        {{ $expenses->withQueryString()->links() }}
    </div>

</x-app-layout>
