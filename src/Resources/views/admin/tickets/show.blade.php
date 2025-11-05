<x-admin::layouts>
    <x-slot:title>
        @lang('Ticket #:number', ['number' => $ticket->ticket_number])
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('Ticket #:number', ['number' => $ticket->ticket_number])
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.support.tickets.edit', $ticket->id) }}" class="primary-button">
                @lang('Edit Ticket')
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="p-4 border-b dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $ticket->subject }}</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">@lang('Customer'):</span>
                        <span class="text-gray-800 dark:text-white">{{ $ticket->customer_name }} ({{ $ticket->customer_email }})</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">@lang('Status'):</span>
                        <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $ticket->status->color }}; color: white;">
                            {{ $ticket->status->name }}
                        </span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">@lang('Priority'):</span>
                        <span class="px-2 py-1 text-xs rounded" style="background-color: {{ $ticket->priority->color }}; color: white;">
                            {{ $ticket->priority->name }}
                        </span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">@lang('Category'):</span>
                        <span class="text-gray-800 dark:text-white">{{ $ticket->category->name }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">@lang('Created'):</span>
                        <span class="text-gray-800 dark:text-white">{{ $ticket->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @if($ticket->sla_due_at)
                        <div class="text-sm">
                            <span class="font-medium text-gray-600 dark:text-gray-300">@lang('SLA Due'):</span>
                            <span class="{{ $ticket->isOverdue() ? 'text-red-600' : 'text-green-600' }}">
                                {{ $ticket->sla_due_at->format('Y-m-d H:i') }}
                                @if($ticket->isOverdue())
                                    (@lang('OVERDUE'))
                                @endif
                            </span>
                        </div>
                    @endif
                    <div class="pt-3 border-t dark:border-gray-800">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">@lang('Description')</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $ticket->description }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="p-4 border-b dark:border-gray-800">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('Notes & Replies')</h4>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($ticket->notes as $note)
                        <div class="p-3 rounded {{ $note->is_internal ? 'bg-yellow-50 dark:bg-yellow-900/20' : 'bg-gray-50 dark:bg-gray-800' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <strong class="text-gray-800 dark:text-white">{{ $note->created_by_name }}</strong>
                                    @if($note->is_internal)
                                        <span class="ml-2 px-2 py-1 text-xs bg-yellow-500 text-white rounded">@lang('Internal')</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $note->content }}
                            </div>
                            @if($note->attachments->count() > 0)
                                <div class="mt-2 pt-2 border-t dark:border-gray-700">
                                    <strong class="text-xs text-gray-600 dark:text-gray-300">@lang('Attachments'):</strong>
                                    @foreach($note->attachments as $attachment)
                                        <div class="text-xs text-gray-600 dark:text-gray-300">{{ $attachment->name }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="pt-4 border-t dark:border-gray-800">
                        <form action="{{ route('admin.support.tickets.notes.add', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                                    @lang('Add Note')
                                </label>
                                <textarea name="content" class="flex w-full min-h-[100px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" required></textarea>
                            </div>
                            <div>
                                <label class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <input type="checkbox" name="is_internal" value="1" class="mr-2">
                                    @lang('Internal Note (not visible to customer)')
                                </label>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-300 font-medium">
                                    @lang('Attachments')
                                </label>
                                <input type="file" name="attachments[]" class="flex w-full py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900" multiple>
                            </div>
                            <button type="submit" class="primary-button">
                                @lang('Add Note')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="p-4 border-b dark:border-gray-800">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('Watchers')</h4>
                </div>
                <div class="p-4 space-y-2">
                    @foreach($ticket->watchers as $watcher)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-800 dark:text-white">{{ $watcher->name ?? $watcher->email }}</span>
                            <form action="{{ route('admin.support.tickets.watchers.remove', [$ticket->id, $watcher->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs">@lang('Remove')</button>
                            </form>
                        </div>
                    @endforeach

                    <div class="pt-3 border-t dark:border-gray-800">
                        <form action="{{ route('admin.support.tickets.watchers.add', $ticket->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <div>
                                <input type="email" name="email" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" placeholder="@lang('Email')" required>
                            </div>
                            <div>
                                <input type="text" name="name" class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900" placeholder="@lang('Name (optional)')">
                            </div>
                            <button type="submit" class="secondary-button w-full">
                                @lang('Add Watcher')
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="p-4 border-b dark:border-gray-800">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">@lang('Activity Log')</h4>
                </div>
                <div class="p-4 space-y-2">
                    @foreach($ticket->activityLogs as $log)
                        <div class="text-sm">
                            <div class="text-xs text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</div>
                            <div class="text-gray-800 dark:text-white">
                                <strong>{{ $log->action }}</strong>: {{ $log->description }}
                                @if($log->user_name)
                                    <span class="text-gray-600 dark:text-gray-300">by {{ $log->user_name }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>
