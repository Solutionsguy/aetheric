@extends('frontend::layouts.user')
@section('title')
{{ __('My Ads') }}
@endsection
@section('content')
<div class="ads-area">
    @include('frontend::user.ads.include.__step')
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <h3 class="site-card-title">@yield('title')</h3>
                        @if(setting('user_ads_post','permission'))
                        <a class="site-btn black-btn" href="{{ route('user.my.ads.create') }}"> <i class="icon-add-circle"></i>{{ __('Create Ads') }}</a>
                        @endif
                    </div>
                </div>
                <div class="my-ads-fields">
                    <form action="{{ route('user.my.ads.index') }}" method="GET">
                        <div class="my-ads-fields-wrapper">
                            <div class="input-field">
                                <input type="text" class="box-input" name="query" placeholder="{{ __('Ads Title') }}" value="{{ request('query') }}">
                            </div>
                            <div class="input-select">
                                <select name="type">
                                    <option value="" selected>{{ __('Select Type') }}</option>
                                    <option value="link" @selected(request('type') == 'link')>{{ __('Link/URL') }}</option>
                                    <option value="script" @selected(request('type') == 'script')>{{ __('Script/Code') }}</option>
                                    <option value="image" @selected(request('type') == 'image')>{{ __('Image/Banner') }}</option>
                                    <option value="youtube" @selected(request('type') == 'youtube')>{{ __('YouTube Link') }}</option>
                                </select>
                            </div>
                            <div class="input-select">
                                <select name="status">
                                    <option value="" selected>{{ __('Select Status') }}</option>
                                    <option value="pending" @selected(request('status') == 'pending')>{{ __('Pending') }}</option>
                                    <option value="active" @selected(request('status') == 'active')>{{ __('Active') }}</option>
                                    <option value="inactive" @selected(request('status') == 'inactive')>{{ __('Inactive') }}</option>
                                    <option value="rejected" @selected(request('status') == 'rejected')>{{ __('Rejected') }}</option>
                                </select>
                            </div>
                            <button class="site-btn" type="submit"> 
                                <span>
                                    <svg width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.6667 5.86669V14.1334C16.6667 15.4 16.55 16.3 16.25 16.9417C16.25 16.95 16.2417 16.9667 16.2333 16.975C16.05 17.2084 15.8083 17.325 15.525 17.325C15.0833 17.325 14.55 17.0334 13.975 16.4167C13.2917 15.6834 12.2416 15.7417 11.6416 16.5417L10.8 17.6584C10.4667 18.1084 10.025 18.3334 9.58333 18.3334C9.14167 18.3334 8.69998 18.1084 8.36665 17.6584L7.51668 16.5334C6.92502 15.7417 5.88333 15.6834 5.19999 16.4084L5.19165 16.4167C4.24998 17.425 3.41668 17.575 2.93335 16.975C2.92502 16.9667 2.91667 16.95 2.91667 16.9417C2.61667 16.3 2.5 15.4 2.5 14.1334V5.86669C2.5 4.60002 2.61667 3.70002 2.91667 3.05835C2.91667 3.05002 2.91668 3.04169 2.93335 3.03335C3.40835 2.42502 4.24998 2.57502 5.19165 3.58335L5.19999 3.59169C5.88333 4.31669 6.92502 4.25835 7.51668 3.46669L8.36665 2.34169C8.69998 1.89169 9.14167 1.66669 9.58333 1.66669C10.025 1.66669 10.4667 1.89169 10.8 2.34169L11.6416 3.45836C12.2416 4.25836 13.2917 4.31669 13.975 3.58335C14.55 2.96669 15.0833 2.67502 15.525 2.67502C15.8083 2.67502 16.05 2.80002 16.2333 3.03335C16.25 3.04169 16.25 3.05002 16.25 3.05835C16.55 3.70002 16.6667 4.60002 16.6667 5.86669Z"
                                                stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M6.66797 8.54169H13.3346" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.66797 11.4583H11.668" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="site-table ads-table table-responsive">
                    <table class="table">
                        <thead class="thead">
                            <tr>
                                <th scope="col">{{ __('Ads Title') }}</th>
                                <th scope="col">{{ __('Type') }}</th>
                                <th scope="col">{{ __('Duration') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Total Views') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ads as $ad)
                            <tr>
                                <td>{{ $ad->title }}</td>
                                <td>
                                    @if($ad->type == App\Enums\AdsType::Link)
                                        <div class="info-color"> {{ __('Link/URL') }}</div>
                                    @elseif($ad->type == App\Enums\AdsType::Script)
                                        <div class="yellow-color">{{ __('Script/Code') }}</div>
                                    @elseif($ad->type == App\Enums\AdsType::Image)
                                        <div class="black-color">{{ __('Image/Banner') }}</div>
                                    @elseif($ad->type == App\Enums\AdsType::Youtube)
                                        <div class="red-color">{{ __('Youtube') }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ $ad->duration }} {{ __('Seconds') }}
                                </td>
                                <td>
                                    {{ $currencySymbol.$ad->amount }}
                                </td>
                                <td>
                                    {{ $ad->total_views }}
                                </td>
                                <td>
                                    @if($ad->status == App\Enums\AdsStatus::Active)
                                        <div class="site-badge badge-success">{{ __('Active') }}</div>
                                    @elseif($ad->status == App\Enums\AdsStatus::Inactive)
                                        <div class="site-badge badge-failed">{{ __('Inactive') }}</div>
                                    @elseif($ad->status == App\Enums\AdsStatus::Pending)
                                        <div class="site-badge badge-pending">{{ __('Pending') }}</div>
                                    @elseif($ad->status == App\Enums\AdsStatus::Rejected)
                                        <div class="site-badge badge-failed">{{ __('Rejected') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.my.ads.edit',encrypt($ad->id)) }}" class="edit-btn">
                                        <span>
                                            <i class="icon-edit-2"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($ads) == 0)
                        @include('frontend::user.include.__no_data_found')
                    @endif
                </div>
                {{ $ads->links() }}
            </div>
        </div>
    </div>
</div> 
@endsection
