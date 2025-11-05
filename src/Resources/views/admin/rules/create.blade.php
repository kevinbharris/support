<x-admin::layouts>
    <x-slot:title>
        @lang('Create Automation Rule')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Create Automation Rule')
        </p>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.support.rules.store') }}" method="POST" class="bg-white dark:bg-gray-900 rounded box-shadow">
            @csrf

            <div class="p-4 space-y-4">
                <div>
                    <label for="name" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Name')
                    </label>
                    <input type="text" name="name" id="name" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>
                </div>

                <div>
                    <label for="description" class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Description')
                    </label>
                    <textarea name="description" id="description" class="flex w-full min-h-[75px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900"></textarea>
                </div>

                <div>
                    <label for="conditions" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Conditions (JSON)')
                    </label>
                    <textarea name="conditions" id="conditions" class="flex w-full min-h-[100px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 font-mono transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>{"field": "priority_id", "operator": "equals", "value": "1"}</textarea>
                    <small class="text-xs text-gray-500">@lang('Example: {"field": "priority_id", "operator": "equals", "value": "1"}')</small>
                </div>

                <div>
                    <label for="actions" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Actions (JSON)')
                    </label>
                    <textarea name="actions" id="actions" class="flex w-full min-h-[100px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 font-mono transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>{"action": "assign", "value": "1"}</textarea>
                    <small class="text-xs text-gray-500">@lang('Example: {"action": "assign", "value": "1"}')</small>
                </div>

                <div>
                    <label for="sort_order" class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Sort Order')
                    </label>
                    <input type="number" name="sort_order" id="sort_order" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="0">
                </div>

                <div>
                    <label class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                        @lang('Active')
                    </label>
                </div>
            </div>

            <div class="flex gap-2 justify-end p-4 border-t dark:border-gray-800">
                <a href="{{ route('admin.support.rules.index') }}" class="secondary-button">
                    @lang('Cancel')
                </a>
                <button type="submit" class="primary-button">
                    @lang('Create')
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts>
