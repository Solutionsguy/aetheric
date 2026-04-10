@extends('frontend::layouts.user')
@section('title')
{{ __('Investment History') }}
@endsection
@section('content')
<div class="my-ads-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="my-ads-card">
                <div class="site-card">
                    <div class="site-card-header mb-4">
                        <h3 class="site-card-title">{{ __('Investment History') }}</h3>
                    </div>
                    <div class="site-custom-table-wrapper overflow-x-auto pt-4">
                        <div class="site-custom-table">
                            <div class="contents text-center">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">#</div>
                                    <div class="site-table-col">{{ __('Plan') }}</div>
                                    <div class="site-table-col">{{ __('Amount') }}</div>
                                    <div class="site-table-col">{{ __('ROI') }}</div>
                                    <div class="site-table-col">{{ __('Next Return') }}</div>
                                    <div class="site-table-col">{{ __('Installments') }}</div>
                                    <div class="site-table-col">{{ __('Status') }}</div>
                                </div>
                                @foreach ($investments as $investment)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold text-start">
                                            {{ $investment->plan->name ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ ucwords($investment->plan->frequency) }}</small>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold green-color">
                                            {{ $currencySymbol.number_format($investment->amount,2) }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $investment->plan->roi }}%
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $investment->next_return_at ? $investment->next_return_at->format('d M Y h:i A') : __('Completed') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $investment->installments_paid }} / {{ $investment->total_installments == 0 ? __('∞') : $investment->total_installments }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($investment->status == 'running')
                                            <div class="site-badge badge-success">{{ __('Running') }}</div>
                                        @elseif($investment->status == 'completed')
                                            <div class="site-badge badge-primary">{{ __('Completed') }}</div>
                                        @else
                                            <div class="site-badge badge-failed">{{ ucwords($investment->status) }}</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($investments) == 0)
                                <div class="text-center p-5">
                                    <p>{{ __('No investments found.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{ $investments->links() }}
        </div>
    </div>
</div>
@endsection
