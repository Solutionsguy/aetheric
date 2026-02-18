
<li
    @class([
        'active' => request()->url() == url($navigation->url),
        'logout' => $navigation->type == 'logout'
    ])
    >
    <a href="{{ url($navigation->url) }}">
        <i class="{{ $navigation->icon }}"></i>
        <span>{{ $navigation->name }}</span>
        @if($navigation->type == 'referral' && $referral_counter > 0 )
        <b class="count-number">{{ $referral_counter }}</b>
        @elseif($navigation->type == 'support' && $ticket_running > 0 )
        <b class="count-number">{{ $ticket_running }}</b>
        @endif
    </a>
</li>
