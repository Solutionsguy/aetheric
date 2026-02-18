@extends('backend.layouts.app')
@section('title')
    {{ __('Ads Reports') }}
@endsection
@section('content')
    <div class="main-content">

        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Ads Reports') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Ads') }}</th>
                                        <th scope="col">{{ __('Reported By') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $report)
                                            <tr>
                                                <td>
                                                    <a class="link" href="{{ route('admin.ads.edit',$report->ads_id) }}">{{ $report->ads?->title }}</a>
                                                </td>
                                                <td>
                                                    <a class="link" href="{{ route('admin.user.edit',$report->user_id) }}">{{ $report->user?->username }}</a>
                                                </td>
                                                <td>
                                                    @can('report-details')
                                                        <a href="#" class="round-icon-btn primary-btn" id="reportDetails" data-description="{{ $report->description }}" data-bs-toggle="tooltip" title="" data-bs-placement="top" data-bs-original-title="Report details">
                                                            <i data-lucide="eye"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                        <td colspan="4" class="text-center">{{ __('No Report Found!') }}</td>
                                        @endforelse
                                    </tbody>
                                </table>
                                @include('backend.ads.include.detailsModal')
                            </div>
                            {{ $reports->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('script')
    <script>
        (function ($) {
            "use strict";

            // Delete Modal
            $('body').on('click', '#reportDetails', function () {
                var description = $(this).data('description');
                $('.message-body').text(description);
                $('#reportModal').modal('show');
            });

        })(jQuery);
    </script>
@endsection