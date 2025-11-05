<x-admin::layouts>
    <x-slot:title>
        @lang('Edit Canned Response')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Edit Canned Response')
        </p>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.support.canned-responses.update', $cannedResponse->id) }}" method="POST" class="bg-white dark:bg-gray-900 rounded box-shadow">
            @csrf
            @method('PUT')

            <div class="p-4 space-y-4">
                <div>
                    <label for="title" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Title')
                    </label>
                    <input type="text" name="title" id="title" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ $cannedResponse->title }}" required>
                </div>

                <div>
                    <label for="shortcut" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Shortcut')
                    </label>
                    <input type="text" name="shortcut" id="shortcut" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ $cannedResponse->shortcut }}" required>
                </div>

                <div>
                    <label for="content" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Content')
                    </label>
                    <textarea name="content" id="content" class="flex w-full min-h-[100px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>{{ $cannedResponse->content }}</textarea>
                </div>

                <div>
                    <label class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="is_active" value="1" {{ $cannedResponse->is_active ? 'checked' : '' }} class="mr-2">
                        @lang('Active')
                    </label>
                </div>
            </div>

            <div class="flex gap-2 justify-end p-4 border-t dark:border-gray-800">
                <a href="{{ route('admin.support.canned-responses.index') }}" class="secondary-button">
                    @lang('Cancel')
                </a>
                <button type="submit" class="primary-button">
                    @lang('Update')
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts>
