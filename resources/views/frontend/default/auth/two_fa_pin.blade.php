@extends('frontend::layouts.auth')
@section('title')
{{ __('2FA Security') }}
@endsection
@section('content')
<!-- verification area start -->
<section class="verification-area">
    <div class="auth-wrapper">
        <div class="contents-inner">
            <div class="content">
                <div class="top-content">
                    <h3 class="title">{{ __('2FA Security') }}</h3>
                    <p class="description">
                        {{ __('Please enter the') }}
                        <strong>{{ __('OTP') }}</strong> {{ __('generated on your Authenticator App.') }}
                        <br>
                        {{ __('Ensure you submit the current one because it refreshes every 30 seconds.') }}
                    </p>
                </div>
                <form action="{{ route('user.setting.2fa.verify') }}" method="POST">
                    @csrf

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="inputs">
                        <div class="verification">
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off" autofocus>
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off">
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off">
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off">
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off">
                            <input type="tel" maxlength="1" name="one_time_password[]" pattern="[0-9]" class="control-form" autocomplete="off">
                        </div>
                    </div>
                    <div class="inputs">
                        <button type="submit" class="site-btn primary-btn w-100">
                            {{ __('Authenticate Now') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<!-- verification area end -->
@endsection

@push('js')
<script>
    (function ($) {
      'use strict';

      // password hide show
      const form = document.querySelector('form')
      const inputs = form.querySelectorAll('input')
      const KEYBOARDS = {
        backspace: 8,
        arrowLeft: 37,
        arrowRight: 39,
      }

      function handleInput(e) {
        const input = e.target
        const nextInput = input.nextElementSibling
        if (nextInput && input.value) {
          nextInput.focus()
          if (nextInput.value) {
            nextInput.select()
          }
        }
      }

      function handlePaste(e) {
        e.preventDefault()
        const paste = e.clipboardData.getData('text')
        inputs.forEach((input, i) => {
          input.value = paste[i] || ''
        })
      }

      function handleBackspace(e) {
        const input = e.target
        if (input.value) {
          input.value = ''
          return
        }

        input.previousElementSibling.focus()
      }

      function handleArrowLeft(e) {
        const previousInput = e.target.previousElementSibling
        if (!previousInput) return
        previousInput.focus()
      }

      function handleArrowRight(e) {
        const nextInput = e.target.nextElementSibling
        if (!nextInput) return
        nextInput.focus()
      }

      form.addEventListener('input', handleInput)
      inputs[0].addEventListener('paste', handlePaste)

      inputs.forEach(input => {
        input.addEventListener('focus', e => {
          setTimeout(() => {
            e.target.select()
          }, 0)
        })

        input.addEventListener('keydown', e => {
          switch (e.keyCode) {
            case KEYBOARDS.backspace:
              handleBackspace(e)
              break
            case KEYBOARDS.arrowLeft:
              handleArrowLeft(e)
              break
            case KEYBOARDS.arrowRight:
              handleArrowRight(e)
              break
            default:
          }
        })
      })

    })(jQuery);
  </script>
@endpush
