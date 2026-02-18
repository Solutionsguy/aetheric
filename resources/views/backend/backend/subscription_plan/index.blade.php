@extends('backend.layouts.app')
@section('title')
    {{ __('Subscription Plans') }}
@endsection
@section('content')
    <div class="main-content">

        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Subscription Plans') }}</h2>
                            @can('plan-create')
                                <a href="{{ route('admin.subscription.plan.create') }}" class="title-btn"><i data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
                            @endcan
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
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Price') }}</th>
                                        <th scope="col">{{ __('Daily Ads Limit') }}</th>
                                        <th scope="col">{{ __('Validity') }}</th>
                                        <th scope="col">{{ __('Featured') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($plans as $plan)
                                            <tr>
                                                <td>
                                                    <strong>{{$plan->name}}</strong>
                                                </td>
                                                <td>{{ $currencySymbol.$plan->price }}</td>
                                                <td>{{ $plan->daily_limit }}</td>
                                                <td>{{ $plan->validity }} {{ __('Days') }}</td>
                                                <td>
                                                    @if($plan->is_featured)
                                                        <div class="site-badge success">{{ __('Yes') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('No') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('plan-edit')
                                                        <a href="{{ route('admin.subscription.plan.edit',$plan->id) }}" class="round-icon-btn primary-btn" id="edit" data-bs-toggle="tooltip" title="" data-bs-placement="top" data-bs-original-title="Edit Plan">
                                                            <i data-lucide="edit-3"></i>
                                                        </a>
                                                    @endcan
                                                    @can('plan-delete')
                                                        <a href="#" class="round-icon-btn red-btn" id="deleteBtn" data-id="{{ $plan->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete Plan">
                                                            <i data-lucide="trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                        <td colspan="6" class="text-center">{{ __('No Data Found!') }}</td>
                                        @endforelse
                                    </tbody>
                                </table>
                                @include('backend.subscription_plan.include.__delete_modal')
                            </div>
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
            $('body').on('click', '#deleteBtn', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.subscription.plan.delete", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

        })(jQuery);
    </script>
@endsection