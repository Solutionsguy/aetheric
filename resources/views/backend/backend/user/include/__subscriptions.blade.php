@if(request('tab') == 'subscriptions')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'subscriptions'
    ])
    id="pills-deposit"
    role="tabpanel"
    aria-labelledby="pills-deposit-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Subscription History') }}</h4>
                </div>
                <div class="site-card-body table-responsive">

                    <div class="site-table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Plan') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Validity At') }}</th>
                                <th>{{ __('Subscribed At') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->plan?->name }}</td>
                                        <td>{{ $currencySymbol.$subscription->amount }}</td>
                                        <td>{{ $subscription->validity_at->format('d M Y h:i A') }}</td>
                                        <td>{{ $subscription->created_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                @empty
                                <td colspan="10" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $subscriptions->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif