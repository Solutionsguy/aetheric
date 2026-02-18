

@canany(['deposit-action','withdraw-action','kyc-action',])

    @php
        $pending_count = pending_count();
    @endphp
    @if($pending_count['withdraw_count'] || $pending_count['kyc_count'] || $pending_count['deposit_count'])
        <div class="col-xl-12">
            <div class="admin-latest-announcements">
                <div class="content"><i
                        data-lucide="zap"></i>{{ __("Explore the important Requests to review first") }}</div>
                <div class="content">
                    @can('pending-transfers')
                        @if($pending_count['pending_ads'])
                            <a href="{{ route('admin.ads.pending') }}" class="site-btn-xs blue-btn"><i
                                    data-lucide="loader"
                                    class="spining-icon"></i>{{ __('Pending Ads') }}
                                ({{ $pending_count['pending_ads'] }})</a>
                        @endif
                    @endcan
                    @can('withdraw-action')
                        @if($pending_count['withdraw_count'])
                            <a href="{{ route('admin.withdraw.pending') }}" class="site-btn-xs red-btn"><i
                                    data-lucide="loader"
                                    class="spining-icon"></i>{{ __('Withdraw') }}
                                ({{ $pending_count['withdraw_count'] }})</a>
                        @endif
                    @endcan

                    @can('kyc-action')
                        @if($pending_count['kyc_count'])
                            <a href="{{ route('admin.kyc.pending') }}" class="site-btn-xs green-btn"><i
                                    data-lucide="loader" class="spining-icon"></i>{{ __('KYC') }}
                                ({{ $pending_count['kyc_count'] }})</a>
                        @endif
                    @endcan

                    @can('deposit-action')
                        @if($pending_count['deposit_count'])
                            <a href="{{ route('admin.deposit.manual.pending') }}"
                               class="site-btn-xs primary-btn"><i data-lucide="loader"
                                                                  class="spining-icon"></i>{{ __('Deposit') }}
                                ({{ $pending_count['deposit_count'] }})</a>
                        @endif
                    @endcan
                    @canany(['support-ticket-list','support-ticket-action'])
                    @if($pending_count['ticket_count'])
                            <a href="{{ route('admin.ticket.index') }}"
                               class="site-btn-xs green-btn"><i data-lucide="loader"
                                                                  class="spining-icon"></i>{{ __('Ticket') }}
                                ({{ $pending_count['ticket_count'] }})</a>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        @endif
    @endcanany
