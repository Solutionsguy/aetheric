<div class="col-xl-12 col-md-12">
    <div class="frontend-editor-data">
        {!! $paymentDetails !!}
    </div>
</div>
@foreach( json_decode($fieldOptions, true) as $key => $field)

@if($field['type'] == 'file')
<div class="single-input">
    <label class="input-label" for="">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span> @endif</label>
    <div class="upload-custom-file without-image">
        <input type="file" name="manual_data[{{$field['name']}}]" id="manual_data[{{$field['name']}}]" accept=".gif, .jpg, .png" onchange="showCloseButton(event)" @if($field['validation']=='required' ) required @endif/>
        <label for="manual_data[{{$field['name']}}]">
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
    <label class="input-label" for="">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span> @endif</label>
    <div class="input-field">
        <textarea class="box-input" name="manual_data[{{$field['name']}}]" @if($field['validation']=='required' ) required @endif> </textarea>
    </div>
</div>
@else
<div class="single-input">
    <label class="input-label" for="">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span> @endif</label>
    <div class="input-field">
      <input type="text" class="box-input" name="manual_data[{{$field['name']}}]" @if($field['validation']=='required' ) required
      @endif >
    </div>
</div>
@endif 
@endforeach
