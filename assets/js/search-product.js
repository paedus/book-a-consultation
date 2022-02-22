jQuery(document).ready(function($) {

    function create_result_item(prod_url, prod_title) {

        var result_item = $('<li>', {"class": 'result_item'}), // Creating result <li> tag
            result_item_link = $('<a>', {"href": prod_url, "class": 'body-txt result_item_link quar', 'target': '_parent'}); // Creating result <a> tag

        $(result_item_link).html(prod_title); // Setting bold title in <a> tag

        $(result_item).append($(result_item_link)); // Appending <a> tag in result item

        return result_item;

    }


    function append_results(products, search_value) {

        $.each(products, function(index, item) {

            var result_item = create_result_item(item['permalink'], item['post_title'], search_value);

            $("#search_result").append(result_item); // Appending item to results list

        })

    }


    function clear_result_block() {

        $("#search_result").empty(); // Empty result block

        $(".products_search_wrap").removeClass('showed_results')

    }

    function create_result_block() {

        $(".products_search_wrap").addClass('showed_results')

    }

    function send_search_request(search_value, post_type) {

        var current_lang = $('html').attr('lang');

        $.ajax({

            url: "/wp-admin/ajax-search",
            method: "GET",
            data: { post_type: post_type, title: search_value, lang: current_lang}

        }).done(function(response) {

            clear_result_block();

            const products = JSON.parse(response);

            if(!products) return false;

            create_result_block();

            append_results(products, search_value);

        });

    }


    $("#products_search").on("keyup", function() { // Search input change event

        const search_value = $(this).val(),
            post_type = $(this).data('post_type'); // Getting post type from input search data-post_type attribute

        if(search_value.length < 3) {

            clear_result_block();

            return false;

        }

        send_search_request(search_value, post_type); // Sending AJAX request

    });


    $('#search_results_close').click(function() {

        clear_result_block();

        return false;

    })

})