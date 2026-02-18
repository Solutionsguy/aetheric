@if(request('tab') == 'ads')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'ads'
    ])
    id="pills-deposit"
    role="tabpanel"
    aria-labelledby="pills-deposit-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Ads') }}</h4>
                </div>
                <div class="site-card-body table-responsive">

                    <div class="site-table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Max Views') }}</th>
                                <th>{{ __('Total Views') }}</th>
                                <th>{{ __('Remaining Views') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($ads as $ad)
                                    <tr>
                                        <td>
                                            <strong>
                                                <a href="{{ route('admin.ads.edit',$ad->id) }}">{{ Str::limit($ad->title,30) }}</a>
                                            </strong>
                                        </td>
                                        <td>
                                            @if($ad->type == App\Enums\AdsType::Link)
                                                <div class="site-badge success"> {{ __('Link') }}</div>
                                            @elseif($ad->type == App\Enums\AdsType::Script)
                                                <div class="site-badge danger">{{ __('Script') }}</div>
                                            @elseif($ad->type == App\Enums\AdsType::Image)
                                                <div class="site-badge pending">{{ __('Image') }}</div>
                                            @elseif($ad->type == App\Enums\AdsType::Youtube)
                                                <div class="site-badge danger">{{ __('Youtube') }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $ad->duration }} {{ __('Sec') }}</td>
                                        <td>{{ $currencySymbol.$ad->amount }}</td>
                                        <td>{{ $ad->max_views }}</td>
                                        <td>{{ $ad->total_views }}</td>
                                        <td>{{ $ad->remaining_views }}</td>
                                        <td>
                                            @if($ad->status == App\Enums\AdsStatus::Active)
                                                <div class="site-badge success">{{ __('Active') }}</div>
                                            @elseif($ad->status == App\Enums\AdsStatus::Inactive)
                                                <div class="site-badge danger">{{ __('Inactive') }}</div>
                                            @elseif($ad->status == App\Enums\AdsStatus::Pending)
                                                <div class="site-badge pending">{{ __('Pending') }}</div>
                                            @elseif($ad->status == App\Enums\AdsStatus::Rejected)
                                                <div class="site-badge danger">{{ __('Rejected') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="10" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $ads->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif