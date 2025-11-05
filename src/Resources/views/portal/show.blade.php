<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="Ticket #{{ $ticket->ticket_number }}"
    />
    <meta
        name="keywords"
        content="Support, Ticket, Helpdesk"
    />
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        Ticket #{{ $ticket->ticket_number }}
    </x-slot:title>

    <div class="container mt-20 max-1180:px-5 max-md:mt-12">
        <!-- Company Logo -->
        <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
            <a
                href="{{ route('shop.home.index') }}"
                class="m-[0_auto_20px_auto]"
                aria-label="@lang('shop::app.customers.signup-form.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
        </div>	
	
        <div class="m-auto w-full max-w-[1000px] rounded-xl border border-zinc-200 p-16 px-[60px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
            @if (session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Ticket Details Card -->
            <div class="rounded-xl border bg-white dark:bg-gray-900 mb-8 p-8">
                <h2 class="text-2xl font-bold mb-4">
                    Ticket #{{ $ticket->ticket_number }}
                </h2>
                <h4 class="mb-2">{{ $ticket->subject }}</h4>

                <div class="grid gap-2 grid-cols-1 max-md:grid-cols-1 md:grid-cols-2">
                    <div>
                        <strong>Status:</strong>
                        <span class="badge px-2 py-1" style="background-color: {{ $ticket->status->color }};">
                            {{ $ticket->status->name }}
                        </span>
                    </div>
                    <div>
                        <strong>Priority:</strong>
                        <span class="badge px-2 py-1" style="background-color: {{ $ticket->priority->color }};">
                            {{ $ticket->priority->name }}
                        </span>
                    </div>
                </div>
                <div class="mt-2 mb-2">
                    <strong>Category:</strong> {{ $ticket->category->name }}
                </div>
                <div class="mb-2">
                    <strong>Created:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}
                </div>
                <hr class="my-3">
                <h5 class="font-semibold mb-2">Description</h5>
                <p class="mb-0">{{ $ticket->description }}</p>
            </div>

            <!-- Conversation Card -->
            <div class="rounded-xl border bg-white dark:bg-gray-900 mb-8 p-8">
                <h4 class="text-xl font-bold mb-5">Conversation</h4>
                @foreach($ticket->notes as $note)
                    <div class="note mb-3 p-3 bg-zinc-50 rounded">
                        <div class="note-header mb-2 flex items-center justify-between">
                            <strong>{{ $note->created_by_name }}</strong>
                            <span class="text-muted text-sm">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="note-content text-base text-zinc-800">
                            {{ $note->content }}
                        </div>
                    </div>
                @endforeach

                <hr class="my-6">

                <!-- Reply Form -->
                <x-shop::form :action="route('support.portal.reply', $ticket->access_token)">
                    @csrf
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label>
                            Add Reply
                        </x-shop::form.control-group.label>
                        <textarea
                            name="content"
                            id="content"
                            class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
                            rows="4"
                            required
                            aria-label="Add Reply"
                        ></textarea>
                        <x-shop::form.control-group.error control-name="content" />
                    </x-shop::form.control-group>

                    <!-- Captcha -->
                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <x-shop::form.control-group class="mt-5">
                            {!! \Webkul\Customer\Facades\Captcha::render() !!}
                            <x-shop::form.control-group.error control-name="g-recaptcha-response" />
                        </x-shop::form.control-group>
                    @endif

                    <div class="mt-6">
                        <button
                            class="primary-button block w-full max-w-[300px] rounded-2xl px-8 py-3 text-center text-base"
                            type="submit"
                        >
                            Reply
                        </button>
                    </div>
                </x-shop::form>
            </div>

            <div class="text-center">
                <p class="text-zinc-500 text-sm">
                    Bookmark this page to access your ticket anytime.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush
</x-shop::layouts>
