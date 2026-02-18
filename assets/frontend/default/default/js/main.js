/*---------------------------------
  Ptc main jQuery
---------------------------------*/

(function ($) {
    'use strict';

    // Lucide Icons Activation
    lucide.createIcons();

    // Nice Select
    $('.lang-select, .page-count, .input-select select').niceSelect();

    // Data CSS JS
    $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
    });

    // Bootstrap Tooltip Initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Dynamic Width
    $("[data-width]").each(function () {
        $(this).css("width", $(this).attr("data-width"));
    });

    // Dynamic Background Color
    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

    // Image Preview
    $(document).on('change', 'input[type="file"]', function (event) {
        var $file = $(this),
            $label = $file.next('label'),
            $labelText = $label.find('span'),
            labelDefault = $labelText.text();

        var fileName = $file.val().split('\\').pop(),
            tmppath = URL.createObjectURL(event.target.files[0]);

        // Check successful selection
        if (fileName) {
            $label.addClass('file-ok').css('background-image', 'url(' + tmppath + ')');
            $labelText.text(fileName);
        } else {
            $label.removeClass('file-ok');
            $labelText.text(labelDefault);
        }
    });

    // Timepicker Initialization
    if ($('.timepicker').length) {
        $('input.timepicker').timepicker({});
    }

    // Datepicker Active
    if ($('#d_today').length) {
        const d_today = new Datepicker(document.querySelector('#d_today'), {
            buttonClass: 'btn',
            todayHighlight: true
        });
    }

    // Language Toggle
    $(document).on('click', '#header-lang-toggle', function (e) {
        e.stopPropagation();
        $(".header-lang ul").toggleClass("lang-list-open");
    });

    // Click Outside Handler for Language Dropdown
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#header-lang-toggle, .header-lang ul').length) {
            $(".header-lang ul").removeClass("lang-list-open");
        }
    });

    // Odometer
    var odo = $('.odometer');
    odo.each(function () {
        $(this).appear(function () {
            var countNumber = $(this).attr('data-count');
            $(this).html(countNumber);
        });
    });

    // FAQ Active Item
    $(document).on('click', '.select-gateway .label-radio', function () {
        $('.select-gateway .label-radio').removeClass('active');
        $(this).addClass('active');
    });

    // Close Notification
    $('#notifyCloseBtn').on('click', function () {
        var notifyBox = this.closest('.notify-box');
        notifyBox.style.opacity = '0';
        notifyBox.style.transform = 'translateY(-20px)';
        setTimeout(function () {
            notifyBox.style.display = 'none';
        }, 500);
    });

    // Auto Hide Notification Toaster After 5 Seconds
    setTimeout(() => {
        var parent = $('.notify-box');
        parent.slideUp("slow", function () {
            $(this).remove();
        });
    }, 5000);

    // Accordion Item Active
    $(document).on('click', '.accordion-item', function () {
        $('.accordion-item').removeClass('active');
        $(this).addClass('active');
    });

})(jQuery);

// Cookie Alert Management
(function () {
    "use strict";

    var cookieAlert = document.querySelector(".cookiealert");
    var acceptCookies = document.querySelector(".acceptcookies");

    if (!cookieAlert) return;

    // Show alert if no "acceptCookies" cookie found
    if (!getCookie("acceptCookies")) {
        cookieAlert.removeAttribute("hidden");
    }

    // Set cookie and hide the alert on accept
    acceptCookies.addEventListener("click", function () {
        setCookie("acceptCookies", true, 365);
        cookieAlert.setAttribute("hidden", true);

        // Dispatch the accept event
        window.dispatchEvent(new Event("cookieAlertAccept"));
    });

    // Set Cookie Function
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    // Get Cookie Function
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
})();
