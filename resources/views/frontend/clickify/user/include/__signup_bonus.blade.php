@if(Session::get('signup_bonus'))
    <div class="modal fade" id="signUpBonusModal" tabindex="-1" aria-labelledby="signUpBonusModalLabel" aria-hidden="true">
        <div class="modal-dialog profile-delete-modal modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-body">
                    <div class="profile-modal-wrapper text-center">
                        <div class="close-content" data-background="{{ asset('frontend/default/images/bg/modal-bg-2.png') }}">
                            <span class="close">
                                <svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.33398 9.16663V12.5C3.33398 15.2498 3.33398 16.6247 4.18826 17.479C5.04253 18.3333 6.41746 18.3333 9.16732 18.3333H10.834C13.5838 18.3333 14.9588 18.3333 15.813 17.479C16.6673 16.6247 16.6673 15.2498 16.6673 12.5V9.16663" stroke="#4A5CFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2.5 7.49992C2.5 6.87684 2.5 6.5653 2.66747 6.33325C2.77718 6.18123 2.93498 6.05499 3.125 5.96723C3.41506 5.83325 3.80449 5.83325 4.58333 5.83325H15.4167C16.1955 5.83325 16.5849 5.83325 16.875 5.96723C17.065 6.05499 17.2228 6.18123 17.3325 6.33325C17.5 6.5653 17.5 6.87684 17.5 7.49992C17.5 8.123 17.5 8.43453 17.3325 8.66659C17.2228 8.8186 17.065 8.94484 16.875 9.03261C16.5849 9.16659 16.1955 9.16659 15.4167 9.16659H4.58333C3.80449 9.16659 3.41506 9.16659 3.125 9.03261C2.93498 8.94484 2.77718 8.8186 2.66747 8.66659C2.5 8.43453 2.5 8.123 2.5 7.49992Z" stroke="#4A5CFF" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M5 3.15472C5 2.33287 5.66624 1.66663 6.4881 1.66663H6.78571C8.56092 1.66663 10 3.10571 10 4.88091V5.83329H7.67857C6.19924 5.83329 5 4.63406 5 3.15472Z" stroke="#4A5CFF" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M15 3.15472C15 2.33287 14.3338 1.66663 13.5119 1.66663H13.2143C11.4391 1.66663 10 3.10571 10 4.88091V5.83329H12.3214C13.8008 5.83329 15 4.63406 15 3.15472Z" stroke="#4A5CFF" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M10 9.16663L10 18.3333" stroke="#4A5CFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <h3>{{ __('Congratulations!') }}</h3>
                        </div>
                        <div class="bottom-content">
                            <p class="description">{{ __('You got a Signup Bonus') }} {{ Session::get('signup_bonus') }} {{ $currency }}</p>
                            <div class="btn-wrap justify-content-center">
                                <button type="button" class="site-btn danger-btn disable" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="icon-close-circle"></i>{{ __('Close') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php 
    Session::remove('signup_bonus'); 
    @endphp
    @push('js')
    <script>
        "use strict";
        $("[data-background").each(function () {
            $(this).css(
                "background-image",
                "url( " + $(this).attr("data-background") + "  )"
            );
        });

        var bonusModal = new bootstrap.Modal(document.getElementById('signUpBonusModal'));
        // Open the modal
        bonusModal.show();
    </script>
    @endpush
@endif