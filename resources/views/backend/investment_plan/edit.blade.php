@extends('backend.layouts.app')
@section('title')
    {{ __('Update Investment Plan') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Update Investment Plan') }}</h2>
                        <a href="{{ route('admin.investment.plan.index') }}" class="title-btn"><i data-lucide="arrow-left"></i>{{ __('Back') }}</a>
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
                        <form action="{{ route('admin.investment.plan.update', $plan->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" class="box-input mb-0" value="{{ old('name', $plan->name) }}" required/>
                                    </div>
                                </div>
                                <div class="col-xxl-8">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Description') }}</label>
                                        <input type="text" name="description" class="box-input mb-0" value="{{ old('description', $plan->description) }}"/>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Minimum Amount') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" step="0.01" name="min_amount" class="form-control" value="{{ old('min_amount', $plan->min_amount) }}" required/>
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Maximum Amount') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" step="0.01" name="max_amount" class="form-control" value="{{ old('max_amount', $plan->max_amount) }}" required/>
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('ROI (Return on Investment)') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" step="0.01" name="roi" class="form-control" value="{{ old('roi', $plan->roi) }}" required/>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Frequency') }}</label>
                                        <select name="frequency" class="form-select" required>
                                            <option value="hourly" @selected(old('frequency', $plan->frequency) == 'hourly')>{{ __('Hourly') }}</option>
                                            <option value="daily" @selected(old('frequency', $plan->frequency) == 'daily')>{{ __('Daily') }}</option>
                                            <option value="weekly" @selected(old('frequency', $plan->frequency) == 'weekly')>{{ __('Weekly') }}</option>
                                            <option value="monthly" @selected(old('frequency', $plan->frequency) == 'monthly')>{{ __('Monthly') }}</option>
                                            <option value="yearly" @selected(old('frequency', $plan->frequency) == 'yearly')>{{ __('Yearly') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Duration') }} <i data-lucide="info" data-bs-toggle="tooltip" data-bs-original-title="How many times ROI will be paid. Enter 0 for Lifetime."></i></label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="duration" class="form-control" value="{{ old('duration', $plan->duration) }}" required/>
                                            <span class="input-group-text">{{ __('Times') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Return Capital') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="return_capital_yes" name="return_capital" value="1" @checked(old('return_capital', $plan->return_capital) == 1)/>
                                            <label for="return_capital_yes">{{ __('Yes') }}</label>
                                            <input type="radio" id="return_capital_no" name="return_capital"value="0" @checked(old('return_capital', $plan->return_capital) == 0)/>
                                            <label for="return_capital_no">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="status_active" name="status" value="1" @checked(old('status', $plan->status) == 1)/>
                                            <label for="status_active">{{ __('Active') }}</label>
                                            <input type="radio" id="status_inactive" name="status"value="0" @checked(old('status', $plan->status) == 0)/>
                                            <label for="status_inactive">{{ __('Inactive') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Update Plan') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
