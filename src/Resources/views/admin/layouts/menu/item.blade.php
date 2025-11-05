@if ($menu['icon'] == 'icon-ticket')
    <img src="{{ asset('vendor/support/assets/icons/ticket.svg') }}" alt="{{ $menu['name'] }}" class="w-6 h-6 inline-block" />
@else
    <i class="{{ $menu['icon'] }}"></i>
@endif
