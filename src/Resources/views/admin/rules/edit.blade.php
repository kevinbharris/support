<x-admin::layouts>
    <x-slot:title>
        @lang('Edit Automation Rule')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Edit Automation Rule')
        </p>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.support.rules.update', $rule->id) }}" method="POST" class="bg-white dark:bg-gray-900 rounded box-shadow">
            @csrf
            @method('PUT')

            <div class="p-4 space-y-4">
                <div>
                    <label for="name" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Name')
                    </label>
                    <input type="text" name="name" id="name" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('name', $rule->name) }}" required>
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Description')
                    </label>
                    <textarea name="description" id="description" class="flex w-full min-h-[75px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900">{{ old('description', $rule->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="from_status_id" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('From Status')
                    </label>
                    <select name="from_status_id" id="from_status_id" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>
                        <option value="">@lang('Select Status')</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('from_status_id', $rule->from_status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('from_status_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="to_status_id" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('To Status')
                    </label>
                    <select name="to_status_id" id="to_status_id" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>
                        <option value="">@lang('Select Status')</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('to_status_id', $rule->to_status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('to_status_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="after_hours" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('After Hours')
                    </label>
                    <input type="number" name="after_hours" id="after_hours" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('after_hours', $rule->after_hours) }}" min="1" required>
                    <small class="text-xs text-gray-500">@lang('Number of hours to wait before transitioning status')</small>
                    @error('after_hours')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="is_enabled" value="1" {{ old('is_enabled', $rule->is_enabled) ? 'checked' : '' }} class="mr-2">
                        @lang('Enabled')
                    </label>
                </div>
            </div>

            <div class="flex gap-2 justify-end p-4 border-t dark:border-gray-800">
                <a href="{{ route('admin.support.rules.index') }}" class="secondary-button">
                    @lang('Cancel')
                </a>
                <button type="submit" class="primary-button">
                    @lang('Update')
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts>
