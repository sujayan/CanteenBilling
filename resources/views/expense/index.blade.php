<x-app-layout>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        <a href="{{ route('expense.index') }}">
            <h1 class="text-white flex justify-center text-4xl">Report</h1>
        </a>
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
                <x-input-label for="filer" :value="__('Filter')" />
                <select name="filter"
                    class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="Unpaid" @if (Request::get('filter') == 'Unpaid') selected @endif>Pending</option>
                    <option value="Not Employed" @if (Request::get('filter') == 'Not Employed') selected @endif>Not Employed</option>
                    <option value="Employed And Paid" @if (Request::get('filter') == 'Employed And Paid') selected @endif>Employed & No Due</option>
                    <option value="Employed" @if (Request::get('filter') == 'Employed') selected @endif>Employed</option>
                    <option value="" @if (Request::get('filter') == '') selected @endif>All</option>
                </select>
            </div>

            <x-primary-button class="mt-7">
                {{ __('Filter') }}
            </x-primary-button>

        </form>

    </div>
    <div
    class=" flex justify-between max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
    @if (Request::get('filter') <> 'Employed And Paid')
    <x-input-label for="dueTotal" :value="__('Due Amount :  Rs ' . $pendingTotal)" />
    @endif
    @if (Request::get('filter') <> 'Unpaid')
        <x-input-label for="paidTotal" :value="__('Paid Amount : Rs ' . $paidTotal)" />
        <x-input-label for="Total" :value="__('Total Amount : Rs ' . $pendingTotal + $paidTotal)" />
    @endif
    


</div>
<div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
    <div class="space-y-4">
        @include('partials._search')
        
    </div>
</div>
    <div class="max-w-3xl mx-auto text-white dark:bg-gray-800 mt-6 px-4 py-4 shadow-md  sm:rounded-lg">
        @if (count($expenses) && count($employeeExpenses) )

            <table class="w-full text-center">
                <tr>
        
                    <th>Employee Id</th>
                    <th>Employee</th>
                    <th>Total Paid</th>
                    <th>Pending</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

                @foreach ($employeeExpenses as $employeeExpense)
                    @php
                        $paid = App\Models\Expense::getPaidAmountByEmployeeId($employeeExpense->employee_id, Request::get('from'), Request::get('to'));
                        $unpaid = App\Models\Expense::getUnPaidAmountByEmployeeId($employeeExpense->employee_id, Request::get('from'), Request::get('to'));
                        $total = $unpaid + $paid;
                    @endphp
                    @if ($total != 0)
                        <tr>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="id" :value="$employeeExpense->employee_company_id" />
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="id" :value="$employeeExpense->employee_name" />
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="paid" :value="'Rs ' . $paid" />
                            </td>

                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="paid" :value="'Rs ' . $unpaid" />
                            </td>

                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-input-label for="total" :value="'Rs ' . $total" />
                            </td>
                            @if ($employeeExpense->employeeStatus)
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <x-input-label for="status" :value="$employeeExpense->employeeStatus" />
                                </td>
                            @else
                                <td class="px-4 underline py-8 border-t border-b border-gray-300">
                                    <a href="{{ route('expense.show', $employeeExpense->employee_id) }}"> Check Expense
                                    </a>
                                </td>
                            @endif


                        </tr>
                    @endif
                @endforeach
            </table>
        @else
            <p class="text-center">No Expenses</p>
        @endif


    </div>
  

    {{-- paginate link --}}
    <div class="mt-6 p-10">
        {{ $employeeExpenses->withQueryString()->links() }}
    </div>

</x-app-layout>
