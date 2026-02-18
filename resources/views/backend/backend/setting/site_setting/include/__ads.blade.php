<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')

            <div class="site-input-groups row">
                <label for="" class="col-sm-4 col-label">{{ __('Ads Bonus') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input type="radio" id="active1-yes" name="ads_bonus_system"
                                value="1" @checked(oldSetting('ads_bonus_system', 'ads' ) == 1 ) />
                            <label for="active1-yes">{{ __('Instant') }}</label>
                            <input type="radio" id="disable0-no" name="ads_bonus_system"
                                value="0" @checked(oldSetting('ads_bonus_system', 'ads' ) == 0 ) />
                            <label for="disable0-no">{{ __('Delay') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-input-groups row" id="ads_bonus_delay_area">
                <label for="" class="col-sm-4 col-label">{{ __('Delay Hours') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" class="form-control" name="ads_bonus_delay_hours"
                               value="{{ oldSetting('ads_bonus_delay_hours','ads') }}">
                        <span class="input-group-text">{{ __('Hours') }}</span>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row mb-0">
                <div class="col-sm-4 col-label">{{ __('URL Ads') }}</div>
                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Ads Price:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="link_ads_price"
                                           value="{{ oldSetting('link_ads_price','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Amount For User:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="link_ads_amount"
                                           value="{{ oldSetting('link_ads_amount','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row mb-0">
                <div class="col-sm-4 col-label">{{ __('Image Ads') }}</div>
                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Ads Price:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="image_ads_price"
                                           value="{{ oldSetting('image_ads_price','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Amount For User:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="image_ads_amount"
                                           value="{{ oldSetting('image_ads_amount','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row mb-0">
                <div class="col-sm-4 col-label">{{ __('Script Ads') }}</div>
                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Ads Price:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="script_ads_price"
                                           value="{{ oldSetting('script_ads_price','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Amount For User:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="script_ads_amount"
                                           value="{{ oldSetting('script_ads_amount','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row mb-0">
                <div class="col-sm-4 col-label">{{ __('YouTube Ads') }}</div>
                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Ads Price:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="youtube_ads_price"
                                           value="{{ oldSetting('youtube_ads_price','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Amount For User:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="youtube_ads_amount"
                                           value="{{ oldSetting('youtube_ads_amount','ads') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row" id="ads_bonus_delay_area">
                <label for="" class="col-sm-4 col-label">{{ __('Ads Limit for Free User') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" class="form-control" name="ads_limit_free_user"
                               value="{{ oldSetting('ads_limit_free_user','ads') }}">
                        <span class="input-group-text">{{ __('Ads') }}</span>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row" id="ads_bonus_delay_area">
                <label for="" class="col-sm-4 col-label">{{ __('Referral Level for Free User') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" class="form-control" name="referral_level_free_user"
                               value="{{ oldSetting('referral_level_free_user','ads') }}">
                        <span class="input-group-text">{{ __('Levels') }}</span>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row" id="ads_bonus_delay_area">
                <label for="" class="col-sm-4 col-label">{{ __('Withdraw Limit for Free User') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" class="form-control" name="withdraw_limit_free_user"
                               value="{{ oldSetting('withdraw_limit_free_user','ads') }}">
                        <span class="input-group-text">{{ $currency }}</span>
                    </div>
                </div>
            </div>

            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>

