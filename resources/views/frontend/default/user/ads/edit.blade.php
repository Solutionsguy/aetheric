@extends('frontend::layouts.user')
@section('title')
{{ __('Update Ads') }}
@endsection
@section('content')
<div class="ads-area">
    @include('frontend::user.ads.include.__step')
    <form action="{{ route('user.my.ads.update',encrypt($ads->id)) }}" method="post">
        @csrf
        <div class="row gy-30">
            <div class="col-xxl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                            <h3 class="site-card-title mb-0">@yield('title')</h3>
                            <a class="site-btn black-btn" href="{{ route('user.my.ads.index') }}"> <i class="icon-receipt-2"></i> {{ __('My Ads List') }}</a>
                        </div>
                    </div>
                    <div class="create-ads">
                        <div class="row gy-25">
                            <div class="col-xxl-12">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Ads Title') }}<span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="title" value="{{ $ads->title }}">
                                    </div>
                                </div>
                            </div>
                            {{-- @if(setting('ads_system','permission'))
                            <div class="col-xxl-4">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Plan') }}<span>*</span></label>
                                    <div class="input-select">
                                        <select name="type" id="adsType">
                                            <option selected disabled>{{ __('Select Plan') }}</option>
                                            @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" @selected($plan->id == $ads->plan_id)>{{ $plan->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                            <input type="hidden" id="adsType" value="{{ $ads->type }}">
                            <div class="col-xxl-6">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Ads Type') }}<span>*</span></label>
                                    <div class="site-badge badge-success">
                                        @if($ads->type == App\Enums\AdsType::Link)
                                        {{ __('Link/URL') }}
                                        @elseif($ads->type == App\Enums\AdsType::Script)
                                        {{ __('Script/Code') }}
                                        @elseif($ads->type == App\Enums\AdsType::Image)
                                        {{ __('Image/Banner') }}
                                        @elseif($ads->type == App\Enums\AdsType::Youtube)
                                        {{ __('Youtube') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6" id="typeValueField">
                                <div class="single-input d-none" id="link">
                                    <label class="input-label" for="">{{ __('URL/Link') }}<span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="link" value="{{ $ads->value }}">
                                    </div>
                                </div>
                                <div class="single-input d-none" id="youtube">
                                    <label class="input-label" for="">{{ __('Youtube Embed Link') }}<span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="youtube" value="{{ $ads->value }}">
                                    </div>
                                </div>
                                <div class="single-input d-none" id="script">
                                    <label class="input-label" for="">{{ __('Script/Code') }}<span>*</span></label>
                                    <div class="input-field">
                                        <textarea name="script" class="">{{ $ads->value }}</textarea>
                                    </div>
                                </div>
                                <div class="single-input d-none" id="image">
                                    <label class="input-label" for="">{{ __('Image/Banner') }}<span>*</span></label>
                                    <div class="upload-custom-file without-image">
                                        <input type="file" name="image" id="image" accept=".gif, .jpg, .png" onchange="showCloseButton(event)"/>
                                        <label for="image" @if($ads->type->value == 'image') class="file-ok"  style="background-image: url({{ asset($ads->value) }})" @endif>
                                            <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="" />
                                            <span> {{ __('Upload Image/Banner') }}</span>
                                        </label>
                                    </div>
                                    <button type="button" class="upload-thumb-close" onclick="removeUploadedFile(this)">
                                        <i class="icon-close-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Duration') }}<span>*</span></label>
                                    <div class="input-field input-group">
                                        <input type="number" name="duration" value="{{ $ads->duration }}">
                                        <span class="input-group-text">{{ __('Seconds') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12">
                <div class="input-btn-wrap">
                    <button class="input-btn btn-primary"><i class="icon-arrow-right-2"></i>{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="{{ asset('frontend/default/js/jquery.timepicker.min.js') }}"></script>
<script>
    "use strict";

    function dragNdrop(event) {
      var fileName = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("preview");
      var previewImg = document.createElement("img");
      previewImg.setAttribute("src", fileName);
      preview.innerHTML = "";
      preview.appendChild(previewImg);
    }

    function drag() {
      document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
    }

    function drop() {
      document.getElementById('uploadFile').parentNode.className = 'dragBox';
    }

    function removeUploadedFile(button) {
      var label = button.previousElementSibling.querySelector('label.file-ok');
      var input = button.previousElementSibling.querySelector('input[type="file"]');
      label.classList.remove('file-ok');
      label.removeAttribute('style');
      label.innerHTML = '<span>{{ __('Upload Image/Banner') }}</span>';
      input.value = ''; // Reset the input value
      button.style.display = 'none'; // Hide the close button
    }

    function showCloseButton(event) {
      var button = event.target.parentElement.nextElementSibling; // Get the close button
      button.style.display = 'block'; // Show the close button
    }

    $('#adsType').change(function() {
        var selectedType = $(this).val();
        visibilityField(selectedType);
    });

    var selectedType = $('#adsType').val();

    // Price List
    const linkAdsPrice = @json(setting('link_ads_price','fee'));
    const scriptAdsPrice = @json(setting('script_ads_price','fee'));
    const imageAdsPrice = @json(setting('image_ads_price','fee'));
    const youtubeAdsPrice = @json(setting('youtube_ads_price','fee'));

    var adsPrice = 0;

    visibilityField(selectedType);

    function visibilityField(selectedType)
    {
        $('#typeValueField > div').addClass('d-none'); // Hide all
        $('#' + selectedType).removeClass('d-none'); // Show selected

        if(selectedType == 'link'){
            $('#adsPrice').text(linkAdsPrice);
            adsPrice = linkAdsPrice;
        }else if(selectedType == 'script'){
            $('#adsPrice').text(scriptAdsPrice);
            adsPrice = scriptAdsPrice;
        }else if(selectedType == 'image'){
            $('#adsPrice').text(imageAdsPrice);
            adsPrice = imageAdsPrice;
        }else if(selectedType == 'youtube'){
            $('#adsPrice').text(youtubeAdsPrice);
            adsPrice = youtubeAdsPrice;
        }
    }

    $('input[name=max_show_limit]').on('keyup',function(){
        $('.total-charge').text(adsPrice * $(this).val());
    })

    // Function to initialize nice select plugin
    function initializeNiceSelect(element) {
        $(element).niceSelect();
    }

    // Function to initialize timepicker plugin
    function initializeTimepicker(element) {
        $(element).timepicker({
            timeFormat: "h:mm p",
        });
    }

    var counter = 1;

    // Function to add a new schedule item
    function addScheduleItem() {
        var newScheduleItem = $(`
                <div class="add-schedule-inputs">
                    <div class="single-input">
                        <div class="input-select">
                            <select name="schedules[`+counter+`][day]">
                                <option value="saturday">{{ __('Saturday') }}</option>
                                <option value="sunday">{{ __('Sunday') }}</option>
                                <option value="monday">{{ __('Monday') }}</option>
                                <option value="tuesday">{{ __('Tuesday') }}</option>
                                <option value="wednesday">{{ __('Wednesday') }}</option>
                                <option value="thursday">{{ __('Thursday') }}</option>
                                <option value="friday">{{ __('Friday') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="single-input">
                        <div class="input-field">
                            <input type="text" class="timepicker timepicker-with-dropdown"
                                placeholder="{{ __('Start time') }}" name="schedules[`+counter+`][start_time]">
                            <i class="icon-clock icon"></i>
                        </div>
                    </div>
                    <div class="single-input">
                        <div class="input-field">
                            <input type="text" class="timepicker timepicker-with-dropdown"
                                placeholder="{{ __('End time') }}" name="schedules[`+counter+`][end_time]">
                            <i class="icon-clock icon"></i>
                        </div>
                    </div>
                    <div class="action-btn-inner">
                        <button type="button" class="add-action-close">
                            <i class="icon-close-circle"></i>
                        </button>
                    </div>
                </div>
            `);

        // Append the new schedule item
        $('#schedule-items').append(newScheduleItem);

        // Initialize nice select plugin for the new select element
        initializeNiceSelect(newScheduleItem.find('select'));

        // Initialize timepicker plugin for the new timepicker inputs
        initializeTimepicker(newScheduleItem.find('.timepicker'));
    }

    // Event delegation for removing schedule items
    $('#schedule-items').on('click', '.add-action-close', function () {
        $(this).closest('.add-schedule-inputs').remove();
    });

    // Event listener for adding more schedule items
    $('#add-more').click(function () {
        addScheduleItem();
    });

    // Initialize nice select plugin for existing select elements
    initializeNiceSelect('.input-select select');

    // Initialize timepicker plugin for existing timepicker inputs
    initializeTimepicker('.timepicker');


  </script>
@endpush