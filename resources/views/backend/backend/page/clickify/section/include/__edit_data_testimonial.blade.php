<h3 class="title mb-4">{{ __('Update Testimonial') }}</h3>

<div class="site-tab-bars">
    <ul class="nav nav-pills" id="pills-tab-render" role="tablist">
        @foreach($languages as $language)
            <li class="nav-item" role="presentation">
                <a
                    href=""
                    class="nav-link  {{ $loop->index == 0 ?'active' : '' }}"
                    id="pills-render-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#{{$language->locale}}-render"
                    type="button"
                    role="tab"
                    aria-controls="pills-render"
                    aria-selected="true"
                ><i data-lucide="languages"></i>{{$language->name}}</a
                >
            </li>
        @endforeach
    </ul>
</div>


<div class="tab-content" id="pills-tabContent">
    @foreach($languages as $key => $language)
        <div
            class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}"
            id="{{$language->locale}}-render"
            role="tabpanel"
            aria-labelledby="pills-render-tab"
        >

            <div class="row">
                <div class="col-xl-12">
                    <form action="{{ route('admin.page.testimonial.update',$testimonial->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        @if($key == 0)
                        <div class="site-input-groups"> 
                            <label for="" class="box-input-label">{{ __('Picture') }}</label>
                            <div class="wrap-custom-file">
                                <input type="file" name="picture" id="pictureField" accept=".gif, .jpg, .png" />
                                <label for="pictureField" @if($testimonial->picture) class="file-ok"  style="background-image: url({{ asset($testimonial->picture) }})" @endif>
                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="" />
                                    <span>{{ __('Upload') }}</span>
                                </label>
                            </div>
                        </div>
                        @endif

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>
                            <input type="text" name="{{ $language->locale }}[name]" class="box-input mb-0" placeholder="Name" value="{{ data_get($locales,$language->locale.'.'.'name',$testimonial->name)  }}"
                                required="" />
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Designation:') }}</label>
                            <input type="text" name="{{ $language->locale }}[designation]" class="box-input mb-0" placeholder="Designation"
                                value="{{ data_get($locales,$language->locale.'.'.'designation',$testimonial->designation) }}" required="" />
                        </div>

                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Feedback:') }}</label>
                            <textarea name="{{ $language->locale }}[message]" class="form-textarea" placeholder="Feedback">{{ data_get($locales,$language->locale.'.'.'message',$testimonial->message) }}</textarea>
                        </div>
                    
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Update') }}
                            </button>
                            <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
