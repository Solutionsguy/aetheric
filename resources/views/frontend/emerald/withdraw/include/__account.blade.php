
<div class="single-input">
    <label class="input-label" for="">{{ __('Method Name') }}<span>*</span></label>
    <div class="input-field">
        <input type="text" class="box-input" name="method_name" value="{{ $withdrawMethod->name .'-'. $withdrawMethod->currency}}">
    </div>
</div>


@foreach( json_decode($withdrawMethod->fields, true) as $key => $field)

<input type="hidden" name="credentials[{{ $field['name']}}][name]" value="{{ $field['name'] }}">
<input type="hidden" name="credentials[{{ $field['name']}}][type]" value="{{ $field['type'] }}">
<input type="hidden" name="credentials[{{ $field['name']}}][validation]" value="{{ $field['validation'] }}">

@if($field['type'] == 'file')
<div class="single-input">
    <label class="input-label" for="">{{ $field['name'] }}</label>
    <div class="upload-custom-file without-image">
        <input type="file" name="credentials[{{$field['name']}}][value]" id="credentials[{{$field['name']}}]" accept=".gif, .jpg, .png" onchange="showCloseButton(event)" @if($field['validation']=='required' ) required @endif/>
        <label for="credentials[{{$field['name']}}]">
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
        <textarea class="box-input" name="credentials[{{$field['name']}}][value]" @if($field['validation']=='required' ) required @endif> </textarea>
    </div>
</div>
@else
<div class="single-input">
    <label class="input-label" for="">{{ $field['name'] }}</label>
    <div class="input-field">
      <input type="text" class="box-input" name="credentials[{{$field['name']}}][value]" @if($field['validation']=='required' ) required
      @endif >
    </div>
</div>
@endif

@endforeach


