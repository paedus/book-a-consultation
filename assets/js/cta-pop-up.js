jQuery(document).ready(function ($) {


    var trigger_button = $(".cta-button-trigger"),

        close_button = $(".cta-pop-up-close");

    trigger_button.click(function(event) { // Popup show event

        var popup_id = $(this).data('popup'),
            popup = $("#cta-pop-up-" + popup_id);

        event.preventDefault(); // Disable all other events

        popup.show()

        popup.addClass('oppened-popup');

    })


    close_button.click(function (event) { // Popup hide event

        event.preventDefault(); // Disable all other events

        $(".oppened-popup").hide().removeClass('oppened-popup');

    })





})