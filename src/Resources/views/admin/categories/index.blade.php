<x-admin::layouts>
    <x-slot:title>
        @lang('Ticket Categories')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Ticket Categories')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.support.categories.create') }}" class="primary-button">
                @lang('Create Category')
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
                            @lang('Slug')
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
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-950">
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $category->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $category->slug }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $category->sort_order }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $category->is_active ? __('Yes') : __('No') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.support.categories.edit', $category->id) }}" class="text-blue-600 hover:underline text-sm">
                                    @lang('Edit')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-admin::layouts>
