@extends('backend.layouts.app')
@section('title')
    {{ __('Invite Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Invite Section') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-tab-bars">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                @foreach($languages as $language)
                    <li class="nav-item" role="presentation">
                        <a
                            href=""
                            class="nav-link  {{ $loop->index == 0 ?'active' : '' }}"
                            id="pills-informations-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#{{$language->locale}}"
                            type="button"
                            role="tab"
                            aria-controls="pills-informations"
                            aria-selected="true"
                        ><i icon-name="languages"></i>{{$language->name}}</a
                        >
                    </li>
                @endforeach


            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">

            @foreach($groupData as $key => $value)

                @php
                    $data = new Illuminate\Support\Fluent($value);
                @endphp

                <div class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}" id="{{$key}}" role="tabpanel"
                    aria-labelledby="pills-informations-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="site-card">
                                <div class="site-card-header">
                                    <h3 class="title">{{ __('Titles and Image') }}</h3>
                                </div>
                                <div class="site-card-body">
                                    <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section_code" value="invite">
                                        <input type="hidden" name="section_locale" value="{{$key}}">

                                        @if($key == 'en')
                                            <div class="site-input-groups row">
                                                <label for=""
                                                       class="col-sm-3 col-label pt-0">{{ __('Section Activity') }}<i
                                                        icon-name="info" data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Manage Section Visibility"></i></label>
                                                <div class="col-sm-3">
                                                    <div class="site-input-groups">
                                                        <div class="switch-field">
                                                            <input type="radio" id="active" name="status"
                                                                   @checked($status) value="1"/>
                                                            <label for="active">{{ __('Show') }}</label>
                                                            <input type="radio" id="deactivate" name="status"
                                                                   @checked(!$status) value="0"/>
                                                            <label for="deactivate">{{ __('Hide') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="site-input-groups row">
                                            <label for=""
                                                   class="col-sm-3 col-label">{{ __('Invite Title Small') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title_small" class="box-input"
                                                       value="{{ $data->title_small }}">
                                            </div>
                                        </div>
                                        <div class="site-input-groups row">
                                            <label for=""
                                                   class="col-sm-3 col-label">{{ __('Invite Title Big') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title_big" class="box-input"
                                                       value="{{ $data->title_big }}">
                                            </div>
                                        </div>

                                        <div class="site-input-groups row">
                                            <label for="" class="col-sm-3 col-label">{{ __('Left Bottom Text') }}<i
                                                        data-lucide="info" data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Don't need this title? Leave it blank"></i></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="left_bottom_text" class="box-input"
                                                       value="{{ $data->left_bottom_text }}">
                                            </div>
                                        </div>

                                        <div class="site-input-groups row">
                                            <label for="" class="col-sm-3 col-label">{{ __('Invite Button') }}<i
                                                        data-lucide="info" data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                            <div class="col-sm-9">
                                                <div class="form-row">
                                                    @if($key == 'en')
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="site-input-groups">
                                                                <label for="" class="box-input-label">{{ __('Button Icon') }}
                                                                    <a class="link" href="https://fontawesome.com/icons" target="_blank">{{ __('Font Awesome') }} /</a>
                                                                    <a class="link" href="{{ asset('frontend/default/fonts/demo.html') }}" target="_blank">{{ __('Icommon') }}</a>:
                                                                </label>
                                                                <input type="text" name="invite_button_icon" class="box-input"
                                                                       value="{{ $data->invite_button_icon }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for=""
                                                                   class="box-input-label">{{ __('Button Label') }}</label>
                                                            <input type="text" name="invite_button_level" class="box-input"
                                                                   value="{{ $data->invite_button_level }}">
                                                        </div>
                                                    </div>
                                                    @if($key == 'en')
                                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="site-input-groups">
                                                                <label for="" class="box-input-label">{{ __('Button URL') }}</label>
                                                                <div class="site-input-groups">
                                                                    <div class="site-input-groups">
                                                                        <input type="text" name="invite_button_url" class="box-input"
                                                                               value="{{ $data->invite_button_url }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="site-input-groups">
                                                                <label for="" class="box-input-label">{{ __('Target') }}</label>
                                                                <div class="site-input-groups">
                                                                    <select name="invite_button_target" class="form-select">
                                                                        <option @if($data->invite_button_target == '_self') selected
                                                                                @endif value="_self">{{ __('Same Tab') }}</option>
                                                                        <option @if($data->invite_button_target == '_blank') selected
                                                                                @endif value="_blank">{{ __('Open In New Tab') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if($key == 'en')
                                            <div class="site-input-groups row">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                                    {{ __(' Invite Left Image') }}
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                                    <div class="wrap-custom-file">
                                                        <input type="file" name="invite_left_img" id="InviteLeftImg"
                                                               accept=".gif, .jpg, .png"/>
                                                        <label for="InviteLeftImg" id="InviteLeftImg"
                                                               @if($data->invite_left_img) class="file-ok"
                                                               style="background-image: url({{ asset($data->invite_left_img) }})" @endif>
                                                            <img class="upload-icon"
                                                                 src="{{ asset('global/materials/upload.svg') }}"
                                                                 alt=""/>
                                                            <span>{{ __('Update Image') }}</span>
                                                        </label>
                                                        @removeimg($data->left_top_img,left_top_img)
                                                    </div>
                                                </div>


                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                                    {{ __(' Invite Right Image') }}
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                                    <div class="wrap-custom-file">
                                                        <input type="file" name="invite_right_img" id="InviteRightImg"
                                                               accept=".gif, .jpg, .png"/>
                                                        <label for="InviteRightImg" id="InviteRightImg"
                                                               @if($data->invite_right_img) class="file-ok"
                                                               style="background-image: url({{ asset($data->invite_right_img) }})" @endif>
                                                            <img class="upload-icon"
                                                                 src="{{ asset('global/materials/upload.svg') }}"
                                                                 alt=""/>
                                                            <span>{{ __('Update Image') }}</span>
                                                        </label>
                                                        @removeimg($data->left_top_img,left_top_img)
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit"
                                                        class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    @include('backend.page.section.include.__section_image_remove')
@endsection
