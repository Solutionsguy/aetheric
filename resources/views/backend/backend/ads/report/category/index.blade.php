@extends('backend.layouts.app')
@section('title')
    {{ __('Report Category') }}
@endsection
@section('content')
    <div class="main-content">

        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Report Category') }}</h2>
                            @can('ads-report-category-create')
                                <a href="{{ route('admin.ads.report.category.create') }}" class="title-btn"><i data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
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
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>
                                                    <strong>{{ $category->name }}</strong>
                                                </td>
                                                <td>
                                                    @if($category->status == 1)
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('ads-report-category-edit')
                                                        <a href="{{ route('admin.ads.report.category.edit',$category->id) }}" class="round-icon-btn primary-btn" id="edit" data-bs-toggle="tooltip" title="" data-bs-placement="top" data-bs-original-title="Edit ads">
                                                            <i data-lucide="edit-3"></i>
                                                        </a>
                                                    @endcan
                                                    @can('ads-report-category-delete')
                                                        <a href="#" class="round-icon-btn red-btn" id="deleteBtn" data-id="{{ $category->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete ads">
                                                            <i data-lucide="trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                        <td colspan="10" class="text-center">{{ __('No Data Found!') }}</td>
                                        @endforelse
                                    </tbody>
                                </table>
                                @include('backend.ads.report.category.include.__delete_modal')
                            </div>
                            {{ $categories->links() }}
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
                var url = '{{ route('admin.ads.report.category.delete', ":id") }}';
                url = url.replace(':id', id);
                
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

        })(jQuery);
    </script>
@endsection