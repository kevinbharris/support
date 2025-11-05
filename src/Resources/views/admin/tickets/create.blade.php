<x-admin::layouts>
    <x-slot:title>
        @lang('Create Ticket')
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Create Ticket')
        </p>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.support.tickets.store') }}" method="POST" class="bg-white dark:bg-gray-900 rounded box-shadow">
            @csrf

            <div class="p-4 space-y-4">
                <div>
                    <label for="customer_name" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Customer Name')
                    </label>
                    <input type="text" name="customer_name" id="customer_name" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="customer_email" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Customer Email')
                    </label>
                    <input type="email" name="customer_email" id="customer_email" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('customer_email') }}" required>
                    @error('customer_email')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Subject')
                    </label>
                    <input type="text" name="subject" id="subject" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('subject') }}" required>
                    @error('subject')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Description')
                    </label>
                    <textarea name="description" id="description" class="flex w-full min-h-[100px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status_id" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Status')
                    </label>
                    <select name="status_id" id="status_id" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="priority_id" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Priority')
                    </label>
                    <select name="priority_id" id="priority_id" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800" required>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority_id')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs text-gray-600 dark:text-gray-300 font-medium required">
                        @lang('Category')
                    </label>
                    <select name="category_id" id="category_id" class="flex w-full min-h-[39px] py-2 px-3 bg-white dark:bg-gray-900 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="assigned_to" class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                        @lang('Assign To')
                    </label>
                    <input type="number" name="assigned_to" id="assigned_to" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" value="{{ old('assigned_to') }}">
                    @error('assigned_to')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2 justify-end p-4 border-t dark:border-gray-800">
                <a href="{{ route('admin.support.tickets.index') }}" class="secondary-button">
                    @lang('Cancel')
                </a>
                <button type="submit" class="primary-button">
                    @lang('Create Ticket')
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts>
