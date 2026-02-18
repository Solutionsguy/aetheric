@extends('frontend::layouts.user')
@section('title')
    {{ $kyc->name }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')
    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="site-card-title">{{ $kyc->name }}</h3>
            </div>
            <div class="site-card-body">
                <div class="step-details-form">
                    <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="kyc_id" value="{{ encrypt($kyc->id) }}">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                @foreach(json_decode($kyc->fields, true) as $key => $field)
                                    @if($field['type'] == 'file')
                                    <div class="single-input">
                                        <label class="input-label" for="">{{ $field['name'] }}</label>
                                        <div class="upload-custom-file without-image">
                                            <input type="file" name="kyc_credential[{{$field['name']}}]" id="kyc_credential[{{$field['name']}}]" accept=".gif, .jpg, .png" onchange="showCloseButton(event)" @if($field['validation']=='required' ) required @endif/>
                                            <label for="kyc_credential[{{$field['name']}}]">
                                                <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="" />
                                                <span> {{ __('Upload').' '.$field['name'] }}</span>
                                            </label>
                                        </div>
                                        <button type="button" class="upload-thumb-close" onclick="removeUploadedFile(this)">
                                            <i class="icon-close-circle"></i>
                                        </button>
                                    </div>
                                    @elseif($field['type'] == 'textarea')
                                    <div class="single-input">
                                        <label class="input-label" for="">{{ $field['name'] }}</label>
                                        <div class="input-field">
                                            <textarea class="box-input" name="kyc_credential[{{$field['name']}}]" @if($field['validation']=='required' ) required @endif> </textarea>
                                        </div>
                                    </div>
                                    @else
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ $field['name'] }}</label>
                                            <div class="input-field">
                                              <input type="text" class="box-input" name="kyc_credential[{{$field['name']}}]" @if($field['validation']=='required' ) required
                                              @endif >
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <button type="submit" class="site-btn primary-btn">
                                    <span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.2"></circle>
                                          <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    {{ __('Submit Now') }} 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
