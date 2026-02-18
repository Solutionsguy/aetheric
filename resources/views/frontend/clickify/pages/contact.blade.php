@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
<?php
$contact = \App\Models\Page::where('code', 'contact')->where('locale', app()->getLocale())->first();
$contactData = $contact ? json_decode($contact->data, true) : null;

?>
@section('page-content')
    <!-- Contact form area start -->
    <Section class="contact-form-area section-space-top">
        <div class="container">
            <div class="row align-items-center gy-50 justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="contact-form-content" data-aos="fade-up" data-aos-duration="1500">
                        <div class="section-title-wrapper">
                            <h2 class="section-title mb-30">{{ $contactData['title_small'] }}</h2>
                            <p class="description">
                                {{ $contactData['title_big'] }}
                            </p>
                        </div>
                        <div class="contact-info style-two">
                            <div class="item">
                                <div class="icon">
                                    <span><i class="{{ $contactData['contact_one_icon'] }}"></i></span>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{ $contactData['contact_one_title'] }}</h3>
                                    <span class="info"><a
                                            href="{{ $contactData['contact_one_value'] }}">{{ $contactData['contact_one_value'] }}</a></span>
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <span><i class="{{ $contactData['contact_two_icon'] }}"></i></span>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{ $contactData['contact_two_title'] }}</h3>
                                    <span class="info"><a
                                            href="{{ $contactData['contact_two_value'] }}">{{ $contactData['contact_two_value'] }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="contact-form include-bg"
                        data-background="{{ asset($contactData['form_background_img']) }}">
                        <form action="{{ route('mail-send') }}" method="POST">
                            @csrf
                            <div class="contact-input-wrapper">
                                <div class="row">
                                    <div class="col-xxl-6">
                                        <div class="contact-input-box">
                                            <div class="contact-input">
                                                <input name="name" id="name" type="text" placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6">
                                        <div class="contact-input-box">
                                            <div class="contact-input">
                                                <input name="email" id="email" type="email" placeholder=" Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input">
                                                <input name="subject" id="subject" type="text" placeholder="Subject">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input">
                                                <textarea name="msg" placeholder="Write a message..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-btn">
                                <button class="site-btn warning-btn btn-xs"
                                    type="submit">{{ $contactData['form_button_title'] }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <!-- Contact form area end -->

    <!-- Newsletter section start -->
    @include('frontend::pages.newsletter')
    <!-- Newsletter section end -->
@endsection
