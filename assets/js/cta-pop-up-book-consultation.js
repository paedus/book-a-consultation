jQuery(document).ready(function ($) {

    var continue_btn = $(".form-continue-btn"),
        form_container = $(".stepped-form-container"),
        form_content = $('.stepped-form-content'),
        active_screen = $(".stepped-form-screen-content.active-screen"),
        form = $(".stepped-form-content").find("form"),
        load_by_page = (form_container.data('load_by_page') === 'true');

    //Disabling continue button if form exist
    if( form.length > 0 ) if( !continue_btn.hasClass('disabled') ) continue_btn.addClass('disabled');


    function listen_for_click() {

        form.click(function() {

            if( is_first_screen() && form.valid() ) {
                
                continue_btn.removeClass('disabled');

                if( !load_by_page ) continue_btn.attr('data-next', form.find('input[type="radio"]:checked').val());

            }

        })

    }


    if( is_first_screen() ) {

        listen_for_click();

    }


    function is_first_screen() {

        return form_container.hasClass('stepped-form-main-screen');

    }


    function update_html_tags_vars() {

        continue_btn = $(".form-continue-btn"),
        form_container = $(".stepped-form-container"),
        form_content = $('.stepped-form-content'),
        active_screen = $(".stepped-form-screen-content.active-screen"),
        form = $(".stepped-form-content").find("form"),
        load_by_page = (form_container.data('load_by_page') === 'true');

    }


    function main_screen_change_callback() {

        var book_type = form_content.find('input[type="radio"]:checked').val()

        form_container.removeClass('stepped-form-main-screen');

        change_screen();

    }


    // On Continue Button Click Event
    continue_btn.click(function(event) {

        event.preventDefault();

        if( $(this).hasClass('disabled') ) return false;

        if( form_container.hasClass('stepped-form-main-screen') ) return main_screen_change_callback();

        change_screen();

    })


    function change_screen_by_load() {

        return true;

    }


    function get_next_screen(currentScreen) {

        if(currentScreen.data('next')) return $(".stepped-form-screen-content." + currentScreen.data('next'));

        if(continue_btn.data('next')) return $(".stepped-form-screen-content." + continue_btn.data('next'));

    }

    $("#phone_field").intlTelInput({
        preferredCountries: ["cz","us" ],
        separateDialCode: true
    });


    function disable_continue_btn() {

        var form = active_screen.find("form");

        if(!form.valid() && !continue_btn.hasClass('disabled')) continue_btn.addClass('disabled');

    }


    function launch_form_listening_function() {

        if(is_first_screen()) return false;

        active_screen.find('input').on('change', function() {

            if( active_screen.find('form').valid() ) return continue_btn.removeClass('disabled');

            if( ! continue_btn.hasClass('disabled') ) continue_btn.addClass('disabled');

        })

    }


    function screen_change_callback() {

        update_html_tags_vars();

        disable_continue_btn();

        launch_form_listening_function();

    }


    function change_screen() {

        if( form.length > 0 && !form.valid() ) return false;

        if(load_by_page) change_screen_by_load();

        var current_screen = $(".active-screen"),
            next_screen    = get_next_screen(current_screen);

        current_screen.removeClass('active-screen');

        next_screen.addClass('active-screen');

        screen_change_callback();

    }


    $(".form-radio-button").click(function() {

        var radio = $(this).find('input[type="radio"]');

        radio.prop('checked', true);

        radio.val(radio.attr('value'));

        $(".selected-radio").removeClass('selected-radio');

        $(this).addClass('selected-radio')

    })

})