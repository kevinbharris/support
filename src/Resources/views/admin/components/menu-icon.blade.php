@props(['icon'])

@if ($icon == 'icon-ticket')
    <img src="{{ asset('vendor/support/assets/icons/ticket.svg') }}" alt="Ticket Icon" class="w-6 h-6" />
@else
    <i class="{{ $icon }}"></i>
@endif
