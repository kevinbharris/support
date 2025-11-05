<x-admin::layouts>
    <x-slot:title>
        @lang('Ticket Statuses')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Ticket Statuses')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.support.statuses.create') }}" class="primary-button">
                @lang('Create Status')
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-900 rounded box-shadow">
        <div class="table overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Name')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Code')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Color')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Sort Order')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Active')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Actions')
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($statuses as $status)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-950">
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $status->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $status->code }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $status->color }}; color: white;">
                                    {{ $status->color }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $status->sort_order }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $status->is_active ? __('Yes') : __('No') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.support.statuses.edit', $status->id) }}" class="text-blue-600 hover:underline text-sm">
                                    @lang('Edit')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $statuses->links() }}
        </div>
    </div>
</x-admin::layouts>
