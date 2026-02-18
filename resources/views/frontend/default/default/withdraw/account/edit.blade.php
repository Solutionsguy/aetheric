<div class="single-input">
    <label class="input-label" for="">{{ __('Gateway') }}</label>
    <div class="input-select">
        <select name="withdraw_method_id" id="editSelectMethod">
            <option disabled selected>{{ __('Select Gateway') }}</option>
            @foreach($withdrawMethods as $raw)
                <option value="{{ $raw->id }}" @selected($raw->id == $withdrawAccount->withdraw_method_id)>{{ $raw->name }}
                    ({{ ucwords($raw->type) }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="single-input">
    <label class="input-label" for="">{{ __('Method Name') }}<span>*</span></label>
    <div class="input-field">
        <input type="text" class="box-input" name="method_name" value="{{ $withdrawAccount->method_name }}">
    </div>
</div>
@foreach(json_decode($withdrawAccount->credentials, true) as $key => $field)
    <input type="hidden" name="credentials[{{ $field['name']}}][name]" value="{{ $field['name'] }}">
    <input type="hidden" name="credentials[{{ $field['name']}}][type]" value="{{ $field['type'] }}">
    <input type="hidden" name="credentials[{{ $field['name']}}][validation]" value="{{ $field['validation'] }}">

    @if($field['type'] == 'file')
    <div class="single-input">
        <label class="input-label" for="">{{ $field['name'] }}</label>
        <div class="upload-custom-file without-image">
            <input type="file" name="credentials[{{$field['name']}}][value]" id="credentials[{{$field['name']}}]" accept=".gif, .jpg, .png" onchange="showCloseButton(event)" @if($field['validation'] == 'required' ) required @endif/>
            <label for="credentials[{{$field['name']}}]" class="file-ok" style="background-image: url({{ asset( data_get($field,'value') ) }})">
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
            <textarea class="box-input" name="credentials[{{$field['name']}}][value]" @if($field['validation']=='required' ) required @endif>{{ $field['value'] }}</textarea>
        </div>
    </div>
    @else
    <div class="single-input">
        <label class="input-label" for="">{{ $field['name'] }}</label>
        <div class="input-field">
        <input type="text" class="box-input" name="credentials[{{$field['name']}}][value]" value="{{ $field['value'] }}" @if($field['validation']=='required' ) required
        @endif >
        </div>
    </div>
    @endif
@endforeach