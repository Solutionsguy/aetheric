@extends('backend.layouts.app')
@section('title')
    {{ __('Investment Plans') }}
@endsection
@section('content')
    <div class="main-content">

        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Investment Plans') }}</h2>
                            <a href="{{ route('admin.investment.plan.create') }}" class="title-btn"><i data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
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
                                        <th scope="col">{{ __('Min Amount') }}</th>
                                        <th scope="col">{{ __('Max Amount') }}</th>
                                        <th scope="col">{{ __('ROI') }}</th>
                                        <th scope="col">{{ __('Frequency') }}</th>
                                        <th scope="col">{{ __('Duration') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($plans as $plan)
                                            <tr>
                                                <td>
                                                    <strong>{{$plan->name}}</strong>
                                                </td>
                                                <td>{{ $currencySymbol.$plan->min_amount }}</td>
                                                <td>{{ $currencySymbol.$plan->max_amount }}</td>
                                                <td>{{ $plan->roi }}%</td>
                                                <td>{{ ucwords($plan->frequency) }}</td>
                                                <td>{{ $plan->duration == 0 ? __('Lifetime') : $plan->duration . ' ' . __('Times') }}</td>
                                                <td>
                                                    @if($plan->status)
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.investment.plan.edit',$plan->id) }}" class="round-icon-btn primary-btn" id="edit" data-bs-toggle="tooltip" title="" data-bs-placement="top" data-bs-original-title="Edit Plan">
                                                        <i data-lucide="edit-3"></i>
                                                    </a>
                                                    <a href="#" class="round-icon-btn red-btn" id="deleteBtn" data-id="{{ $plan->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete Plan">
                                                        <i data-lucide="trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        <td colspan="8" class="text-center">{{ __('No Data Found!') }}</td>
                                        @endforelse
                                    </tbody>
                                </table>
                                @include('backend.investment_plan.include.__delete_modal')
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
                var url = '{{ route("admin.investment.plan.delete", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

        })(jQuery);
    </script>
@endsection
