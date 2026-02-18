<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')

            <div class="site-input-groups row">
                <label for="" class="col-sm-4 col-label">{{ __('Inactive Account Disable') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input type="radio" id="disable-yes" class="site-currency-type" name="inactive_account_disabled"
                                value="1" @checked(oldSetting('inactive_account_disabled', 'inactive_user' )==1 ) />
                            <label for="disable-yes">{{ __('Yes') }}</label>
                            <input type="radio" id="disable-no" name="inactive_account_disabled" class="site-currency-type"
                                value="0" @checked(oldSetting('inactive_account_disabled', 'inactive_user' )==0 ) />
                            <label for="disable-no">{{ __('No') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-input-groups row" id="inactive_days_sec">
                <label for="" class="col-sm-4 col-label">{{ __('Inactive Days') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" name="inactive_days"
                            class=" form-control {{ $errors->has('inactive_days') ? 'has-error' : '' }}"
                            value="{{ oldSetting('inactive_days','inactive_user') }}" />
                    </div>
                </div>
            </div>
            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>

