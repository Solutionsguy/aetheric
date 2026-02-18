<div class="sidebar-wrapper">
    <div class="sidebar-inner">
        <div class="user-sidebar">
            <div class="site-logo">
                <a href="{{ route('user.dashboard') }}" class="logo">
                    <img src="{{ asset(setting('site_logo','global')) }}" alt="{{ setting('site_title') }}">
                </a>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            </div>
            @php
                $ticket_running = App\Models\Ticket::Opened()->where('user_id',auth()->id())->count();
                $referral_counter = $user->referrals->count();
                $navigations = App\Models\UserNavigation::orderBy('position')->get();
            @endphp
            <div class="sidebar-nav">
                <nav class="user-nav">
                    <ul>
                        @foreach ($navigations as $navigation)
                            @php
                                $includeMenu = match ($navigation->type) {
                                    'referral' => setting('sign_up_referral', 'permission') && auth()->user()->referral_status,
                                    'deposit' => setting('user_deposit', 'permission') && auth()->user()->deposit_status,
                                    'withdraw' => setting('user_withdraw', 'permission') && auth()->user()->withdraw_status,
                                    'fund_transfer' => setting('transfer_status', 'permission') && auth()->user()->transfer_status,
                                    default => in_array($navigation->type, [
                                        'dashboard', 'subscriptions', 'subscription_history', 'earnings', 'my_ads', 
                                        'support', 'transactions', 'settings', 'logout'
                                    ]),
                                };
                            @endphp

                            @if ($includeMenu)
                                @include('frontend::include.__menu-item', ['navigation' => $navigation])
                            @endif
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <div class="sidebar-logout">
            <button type="submit" class="submit" href="#" form="logout-form"> 
                <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 19H3C2.46957 19 1.96086 18.7893 1.58579 18.4142C1.21071 18.0391 1 17.5304 1 17V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H7"
                            stroke="#F34141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 15L19 10L14 5" stroke="#F34141" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M19 10H7" stroke="#F34141" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span> 
                {{ __('Log Out') }} 
            </button>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
            </form>
        </div>
    </div>
</div>
