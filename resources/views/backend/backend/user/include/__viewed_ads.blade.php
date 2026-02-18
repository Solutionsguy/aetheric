@if(request('tab') == 'viewed-ads')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'viewed-ads'
    ])
    id="pills-deposit"
    role="tabpanel"
    aria-labelledby="pills-deposit-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Viewed Ads') }}</h4>
                </div>
                <div class="site-card-body table-responsive">

                    <div class="site-table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Ads') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('View Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($ads_histories as $history)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.ads.edit',$history->ads_id) }}">{{ $history->ads?->title }}</a>
                                    </td>
                                    <td>{{ $currencySymbol.$history->amount }}</td>
                                    <td>{{ $history->created_at->format('d M Y h:i A') }}</td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $ads_histories->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
