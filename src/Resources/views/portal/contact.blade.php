<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="Contact Support"
    />
    <meta
        name="keywords"
        content="Contact, Support, Helpdesk"
    />
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        Contact Support
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
	
        <!-- Form Container -->
        <div class="m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-16 px-[90px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
            <h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                Contact Support
            </h1>

            <p class="mt-4 text-xl text-zinc-500 max-sm:mt-0 max-sm:text-sm">
                Please use the form below to submit your support request.
            </p>

            <div class="mt-14 rounded max-sm:mt-8">
                <x-shop::form :action="route('support.portal.submit')">

                    <!-- Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Your Name
                        </x-shop::form.control-group.label>
                        <input
                            type="text"
                            name="customer_name"
                            id="customer_name"
							class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
                            placeholder="Last, First"
                            value="{{ old('customer_name') }}"
                            required
                            aria-label="Your Name"
                        />
                        <x-shop::form.control-group.error control-name="customer_name" />
                    </x-shop::form.control-group>

                    <!-- Email -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Your Email
                        </x-shop::form.control-group.label>
                        <input
                            type="email"
                            name="customer_email"
                            id="customer_email"
                            class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
			    value="{{ old('customer_email') }}"
                            placeholder="your-email@domain.com"
                            required
                            aria-label="Your Email"
                        />
                        <x-shop::form.control-group.error control-name="customer_email" />
                    </x-shop::form.control-group>

                    <!-- Category -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Category
                        </x-shop::form.control-group.label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
                            required
                            aria-label="Category"
                        >
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-shop::form.control-group.error control-name="category_id" />
                    </x-shop::form.control-group>

                    <!-- Subject -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Subject
                        </x-shop::form.control-group.label>
                        <input
                            type="text"
                            name="subject"
                            id="subject"
                            class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
			    value="{{ old('subject') }}"
                            Placeholder="How do I start a return and get a refund?"
                            required
                            aria-label="Subject"
                        />
                        <x-shop::form.control-group.error control-name="subject" />
                    </x-shop::form.control-group>

                    <!-- Description -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            Description
                        </x-shop::form.control-group.label>
                        <textarea
                            name="description"
                            id="description"
                            rows="5"
                            class="border hover:border-red-500 mb-1.5 w-full rounded-lg border px-5 py-3 text-base font-normal text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 max-sm:px-4 max-md:py-2 max-sm:text-sm px-6 py-4 max-md:py-3 max-sm:py-2"
                            required
			    aria-label="Description"
                            placeholder="Explanation of the problem here."
                        >{{ old('description') }}</textarea>
                        <x-shop::form.control-group.error control-name="description" />
                    </x-shop::form.control-group>

                    <!-- Captcha -->
                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <x-shop::form.control-group>
                            {!! \Webkul\Customer\Facades\Captcha::render() !!}
                            <x-shop::form.control-group.error control-name="g-recaptcha-response" />
                        </x-shop::form.control-group>
                    @endif

                    <div class="mt-8 flex flex-wrap items-center gap-9 max-sm:justify-center max-sm:gap-5">
                        <button
                            class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                            type="submit"
                        >
                            Submit Ticket
                        </button>
                    </div>
                </x-shop::form>
            </div>
        </div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush

</x-shop::layouts>
