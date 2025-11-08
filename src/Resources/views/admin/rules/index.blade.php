<x-admin::layouts>
    <x-slot:title>
        @lang('Automation Rules')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Automation Rules')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.support.rules.create') }}" class="primary-button">
                @lang('Create Rule')
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
                            @lang('From Status')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('To Status')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('After Hours')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Enabled')
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                            @lang('Actions')
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($rules as $rule)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-950">
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $rule->name }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $rule->fromStatus->color }}; color: white;">
                                    {{ $rule->fromStatus->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $rule->toStatus->color }}; color: white;">
                                    {{ $rule->toStatus->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $rule->after_hours }}h
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $rule->is_enabled ? __('Yes') : __('No') }}
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('admin.support.rules.edit', $rule->id) }}" class="text-blue-600 hover:underline text-sm">
                                    @lang('Edit')
                                </a>
                                <form action="{{ route('admin.support.rules.destroy', $rule->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this rule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        @lang('Delete')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $rules->links() }}
        </div>
    </div>
</x-admin::layouts>
