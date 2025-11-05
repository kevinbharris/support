<x-admin::layouts>
    <x-slot:title>
        @lang('Support Tickets')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Support Tickets')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.support.tickets.create') }}" class="primary-button">
                @lang('Create Ticket')
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 bg-white dark:bg-gray-900 rounded box-shadow">
        <div class="p-4 border-b dark:border-gray-800">
            <form method="GET" action="{{ route('admin.support.tickets.index') }}" class="flex gap-4 items-end flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Search')
                    </label>
                    <input type="text" name="search" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" placeholder="@lang('Search...')" value="{{ request('search') }}">
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Status')
                    </label>
                    <select name="status" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800">
                        <option value="">@lang('All Statuses')</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Priority')
                    </label>
                    <select name="priority" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800">
                        <option value="">@lang('All Priorities')</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ request('priority') == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Category')
                    </label>
                    <select name="category" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800">
                        <option value="">@lang('All Categories')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="secondary-button">
                        @lang('Filter')
                    </button>
                    <a href="{{ route('admin.support.tickets.index') }}" class="secondary-button">
                        @lang('Reset')
                    </a>
                </div>
            </form>
        </div>

        <div class="table overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Ticket #')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Subject')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Customer')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Status')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Priority')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Category')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Created')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Actions')
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-950">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ticket_ids[]" value="{{ $ticket->id }}">
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $ticket->ticket_number }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.support.tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">
                                    {{ $ticket->subject }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $ticket->customer_name }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $ticket->status->color }}; color: white;">
                                    {{ $ticket->status->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $ticket->priority->color }}; color: white;">
                                    {{ $ticket->priority->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $ticket->category->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $ticket->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" class="text-blue-600 hover:underline text-sm">
                                    @lang('Edit')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $tickets->links() }}
        </div>
    </div>
</x-admin::layouts>
