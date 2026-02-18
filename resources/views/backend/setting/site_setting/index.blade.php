@extends('backend.setting.index')
@section('setting-title')
    {{ __('Site Settings') }}
@endsection
@section('title')
    {{ __('Site Settings') }}
@endsection
@section('setting-content')

    @foreach(config('setting') as $section => $fields)

        @includeIf('backend.setting.site_setting.include.__'. $section)

    @endforeach
@endsection
@push('single-script')
    <script>
    (function($) {
        'use strict';

        var timezoneData = JSON.parse(@json(getJsonData('timeZone')));
        const convertedData = timezoneData.map(item => ({
            id: item.name,
            text: `${item.description} (${item.name})`
        }));

        $('.site-timezone').select2({
            data: convertedData
        });

        // Ads bonus visibility toggle
        function toggleAdsBonusVisibility()
        {
            // Get the selected value
            var ads_bonus = $('input[name="ads_bonus_system"]:checked').val();

            // Show or hide the delay area
            if (ads_bonus == 0) {
                $('#ads_bonus_delay_area').show();
            } else {
                $('#ads_bonus_delay_area').hide();
            }
        }

        // Initial toggle on page load
        toggleElementsVisibility();
        toggleFeesAmountVisibility();
        toggleAdsBonusVisibility();

        $('input[name="ads_bonus_system"]').on('change', function () {
            toggleAdsBonusVisibility();
        });
    })(jQuery);
    </script>
@endpush
