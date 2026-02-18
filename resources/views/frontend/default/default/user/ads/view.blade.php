<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ __('Viewing Ads') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon" />
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/default/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/fontawesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/styles.css') }}">
</head>

<body>
    @include('frontend::include.__notify')
    <div class="mt-5 d-none" id="warningArea">
        <div class="text-center">
            <h1 style="font-size: 150px">
                <i class="icon-danger text-danger text-md"></i>
            </h1>
            <h4 class="text-danger my-2">
                {{ __('Unable to view ads, try again.') }}
            </h4>

            <div class="my-4">
                <button type="button" class="input-btn btn-danger me-3" onclick="window.close();"> <i
                        class="icon-close-circle"></i> {{ __('Close Tab') }}</button>
                <a href="{{ route('user.ads.index') }}" class="input-btn btn-primary"><i class="icon-arrow-left"></i>
                    {{ __('Back') }}</a>
            </div>
        </div>
    </div>

    <div class="advertisement-area pt-20 pb-20">
        <div class="advertisement-card-wrapper d-flex flex-column gap-4">
            <div class="advertisement-card-item">
                <div class="container">
                    <form action="{{ route('user.ads.submit',encrypt($ads->id)) }}" method="post">
                        @csrf
                        <div class="advertisement-card-inner">
                            <div class="progress-advertisement-item fix">
                                <div class="progress-count-inner">
                                    <span class="progress-count">0%</span>
                                    <h4>100%</h4>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" data-width="100%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <div class="advertisement-calc d-none">
                                <input class="count" type="number" name="first_number" value="{{ $firstInt }}" readonly>
                                <div class="icon"><span>+</span></div>
                                <input class="count" type="number" name="seconds_number" value="{{ $secondInt }}"
                                    readonly>
                                <div class="icon"><span>=</span></div>
                                <input class="count" type="number" min="0" name="result">
                            </div>
                            <div class="input-btn-wrap d-none" id="submitArea">
                                <button class="input-btn btn-primary" type="submit">
                                    <span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.1" />
                                            <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    {{ __('Confirm Earn') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="input-btn-wrap mt-2" id="reportArea">
                        <button class="input-btn btn-danger" type="button" data-bs-toggle="modal"
                            data-bs-target="#reportModal">
                            <span>
                                <i class="icon-danger"></i>
                            </span>
                            {{ __('Report') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.ads.report.submit',encrypt($ads->id)) }}" method="post" id="reportForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('Report Ads') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="single-input">
                            <label class="input-label">{{ __('Report Category') }}</label>
                            <select name="category_id" class="form-select nice-select">
                                <option value="" selected disabled>{{ __('Select Report Category') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="single-input">
                            <label class="input-label" for="">{{ __('Description') }}</label>
                            <div class="input-field">
                                <textarea class="box-input" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="input-btn btn-primary m-3">{{ __('Submit Report') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="advertisement-field w-100 mt-2">
        @if($ads->type == App\Enums\AdsType::Link)
        <iframe src="{{ $ads->value }}"></iframe>
        @elseif($ads->type == App\Enums\AdsType::Image)
        <img src="{{ asset($ads->value) }}">
        @elseif($ads->type == App\Enums\AdsType::Youtube)
        {!! $ads->value !!}
        @elseif($ads->type == App\Enums\AdsType::Script)
        {!! $ads->value !!}
        @endif
    </div>

    <script src="{{ asset('frontend/default/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/default/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (function ($) {
            'use strict';

            // Notify
            $('#notifyCloseBtn').on('click', function () {
                "use strict";
                var parent = $('.notify-box');
                parent.fadeOut("slow", function () {
                    $(this).remove();
                });
            });

            setTimeout(() => {
                var parent = $('.notify-box');
                parent.fadeOut("slow", function () {
                    $(this).remove();
                });
            }, 5000);

            window.addEventListener("load", function () {
                const progressItems = document.querySelectorAll('.progress-advertisement-item');
                progressItems.forEach(item => {
                    let progress = 0;
                    const progressBar = item.querySelector('.progress-bar');
                    const progressCount = item.querySelector('.progress-count');
                    const durationInSeconds =
                    "{{ $ads->duration }}"; // Total duration of the animation in seconds
                    const intervalTimeInMilliseconds = durationInSeconds *
                    10; // Convert duration to match the interval logic

                    const intervalId = setInterval(calculateProgress, intervalTimeInMilliseconds);

                    function calculateProgress() {
                        if (progress >= 100) {
                            clearInterval(intervalId);
                            $('.advertisement-calc').removeClass('d-none');
                            $('#submitArea').removeClass('d-none');
                            $('#reportArea').removeClass('d-none');
                            $('form').attr('action',
                                "{{ route('user.ads.submit',['id' => encrypt($ads->id) ]) }}")
                        } else {
                            progress++;
                            progressBar.style.width = progress + '%';
                            progressCount.textContent = progress + '%';
                        }
                    }
                });
            });

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState == 'hidden') {
                    $('.advertisement-area').remove();
                    $('.advertisement-field').remove();
                    $('#warningArea').removeClass('d-none');
                }
            });

            let adsType = "{{ $ads->type->value }}";

            if (adsType == 'link' || adsType == 'youtube') {
                $(document).find('iframe').width($(window).width());
                $(document).find('iframe').height($(window).height());
            }

        })(jQuery);

    </script>
</body>

</html>
