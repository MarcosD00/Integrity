/*global $, jQuery, ajaxcalls_vars, document, control_vars, window, control_vars,Modernizr,mapfunctions_vars,wpestate_open_menu,grecaptcha,wpestate_show_no_results,wpestate_load_on_demand_pins,get_custom_value,wpestate_enable_half_map_pin_action,wpestate_lazy_load_carousel_property_unit,Chart,widgetId1,widgetId2,widgetId3,widgetId4,wpestate_get_custom_value_tab_search*/
///////////////////////////////////////////////////////////////////////////////////////////

function wpestate_load_stats_tabs(listing_id) {
    "use strict";
    var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_tab_stats').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_load_stats_property',
            'postid': listing_id,
            'security': nonce,
        },
        success: function (data) {
            wpestate_show_prop_stat_graph_tab(data.array_values, data.labels, listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax
}



function wpestate_show_prop_stat_graph_tab(values, labels, listing_id) {
    if (!document.getElementById('myChart')) {
        return;
    }

    var ctx = jQuery("#myChart").get(0).getContext("2d");
    var myNewChart = new Chart(ctx);
    // var labels      =   '';
    var traffic_data = '  ';

    // labels          =   jQuery.parseJSON ( wpestate_property_vars.singular_label);
    traffic_data = values;

    var data = {
        labels: labels,
        datasets: [
            {
                label: ajaxcalls_vars.property_views,
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: traffic_data
            },
        ]
    };

    var options = {
        title: 'page views',
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,

        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,

        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth: 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke: true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,

        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };

    // var myBarChart = new Chart(ctx).Bar(data, options);
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}



function wpestate_load_stats(listing_id) {
    "use strict";
    var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_tab_stats').val();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_load_stats_property',
            'postid': listing_id,
            'security': nonce,
        },
        success: function (data) {
            wpestate_show_prop_stat_graph(data.array_values, data.labels, listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax
}

function wpestate_show_prop_stat_graph(values, labels, listing_id) {
    "use strict";

    var ctx = jQuery("#myChart_" + listing_id).get(0).getContext('2d');
    var myNewChart = new Chart(ctx);
    var data = {
        labels: labels,
        datasets: [
            {
                label: ajaxcalls_vars.property_views,
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: values
            },
        ]
    };

    var options = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    };

    // var myBarChart = new Chart(ctx).Bar(data, options);
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}


//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_start_filtering_ajax(newpage) {
    "use strict";

    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl, postid, halfmap, all_checkers;
    action = jQuery('#adv_actions').attr('data-value');
    category = jQuery('#adv_categ').attr('data-value');
    city = jQuery('#advanced_city').attr('data-value');
    area = jQuery('#advanced_area').attr('data-value');
    rooms = parseFloat(jQuery('#adv_rooms').val(), 10);
    baths = parseFloat(jQuery('#adv_bath').val(), 10);
    min_price = parseFloat(jQuery('#price_low').val(), 10);
    price_max = parseFloat(jQuery('#price_max').val(), 10);
    postid = parseFloat(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var order = jQuery('#a_filter_order').attr('data-value');
    halfmap = 0;

    var nonce = jQuery('#wpestate_ajax_filtering').val();

    if (jQuery('#google_map_prop_list_sidebar').length) {
        halfmap = 1;
    }

    postid = 1;
    if (document.getElementById('search_wrapper')) {
        postid = parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }

    all_checkers = '';
    jQuery('.search_wrapper .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
        }
    });

    halfmap = 0;

    if (jQuery('#google_map_prop_list_sidebar').length) {
        halfmap = 1;
    }

    var geo_lat = '';
    var geo_long = '';
    var geo_rad = '';

    if (jQuery("#geolocation_search").length > 0) {
        geo_lat = jQuery('#geolocation_lat').val();
        geo_long = jQuery('#geolocation_long').val();
        geo_rad = jQuery('#geolocation_radius').val();

    }
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_ajax_filter_listings_search',
            'action_values': action,
            'category_values': category,
            'city': city,
            'area': area,
            'advanced_rooms': rooms,
            'advanced_bath': baths,
            'price_low': min_price,
            'price_max': price_max,
            'newpage': newpage,
            'postid': postid,
            'halfmap': halfmap,
            'all_checkers': all_checkers,
            'geo_lat': geo_lat,
            'geo_long': geo_long,
            'geo_rad': geo_rad,
            'order': order,
            'security': nonce
        },
        success: function (data) {

            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.pagination_nojax').hide();
            //jQuery('#listing_ajax_container').empty().append(data);
            jQuery('.entry-title.title_prop').addClass('half_results').text(data.no_founs);

            jQuery('#listing_ajax_container').empty().append(data.cards);


            wpestate_restart_js_after_ajax();

        },
        error: function (errorThrown) {}
    });//end ajax
}


//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_custom_search_start_filtering_ajax(newpage) {
    "use strict";


    var initial_array_last_item, temp_val, array_last_item, how_holder, slug_holder, val_holder, ajaxurl, postid, slider_min, slider_max, halfmap, all_checkers, term_id;

    array_last_item = parseInt(mapfunctions_vars.fields_no, 10);
    initial_array_last_item = array_last_item;

    val_holder = [];
    slug_holder = [];
    how_holder = [];


    //slug_holder         =   mapfunctions_vars.slugs;
    slug_holder = JSON.parse(JSON.stringify(mapfunctions_vars.slugs));

    // how_holder          =   mapfunctions_vars.hows;
    how_holder = JSON.parse(JSON.stringify(mapfunctions_vars.hows));
    var term_counter = 0;



    if (mapfunctions_vars.slider_price === 'yes') {
        slider_min = jQuery('#price_low').val();
        slider_max = jQuery('#price_max').val();
    }

    if(jQuery('.wpresidence-component3-min-price_input_class').length>0){
        slider_min = jQuery('.wpresidence-component3-min-price_input_class').val();
        slider_max = jQuery('.wpresidence-component3-max-price_input_class').val();
    }



    term_counter = jQuery('.tab-pane.active').find('.term_counter').val();


    if ((mapfunctions_vars.adv_search_type === '6' || mapfunctions_vars.adv_search_type === '7')) { // &&  !jQuery('.halfsearch')[0]

        term_id = jQuery('.tab-pane.active .term_id_class').val();


        if (mapfunctions_vars.slider_price === 'yes') {
            slider_min = jQuery('#price_low_' + term_id).val();
            slider_max = jQuery('#price_max_' + term_id).val();
        }


        if(jQuery('.tab-pane.active .wpresidence-component3-min-price_input_class').length>0){
            slider_min = jQuery('.tab-pane.active .wpresidence-component3-min-price_input_class').val();
            slider_max = jQuery('.tab-pane.active .wpresidence-component3-max-price_input_class').val();
        }

        

        var start_counter = term_counter * mapfunctions_vars.fields_no;
        if (term_counter > 0) {
            array_last_item = (array_last_item * term_counter) + array_last_item;
        }


        for (var i = start_counter; i < array_last_item; i++) {
            if (how_holder[i] == 'date bigger' || how_holder[i] == 'date smaller') {
                temp_val = wpestate_get_custom_value_tab_search(term_id + slug_holder[i]);
            } else {
                temp_val = wpestate_get_custom_value_tab_search(slug_holder[i]);
            }

            if (typeof (temp_val) === 'undefined') {
                temp_val = '';
            }
            val_holder.push(temp_val);
        }

    } else {
        for (var i = 0; i < array_last_item; i++) {
            temp_val = wpestate_get_custom_value(slug_holder[i]);
            if (typeof (temp_val) === 'undefined') {
                temp_val = '';
            }
            val_holder.push(temp_val);
        }

    }


    if ((mapfunctions_vars.adv_search_type === '6' || mapfunctions_vars.adv_search_type === '7' || mapfunctions_vars.adv_search_type === '8' || mapfunctions_vars.adv_search_type === '9')) {
        var tab_tax = jQuery('.adv_search_tab_item.active').attr('data-tax');

        if (jQuery('.halfsearch')[0]) {
            tab_tax = jQuery('.halfsearch').attr('data-tax');
        }


        if (tab_tax === 'property_category') {
            slug_holder[array_last_item] = 'adv_categ';
        } else if (tab_tax === 'property_action_category') {
            slug_holder[array_last_item] = 'adv_actions';
        } else if (tab_tax === 'property_city') {
            slug_holder[array_last_item] = 'advanced_city';
        } else if (tab_tax === 'property_area') {
            slug_holder[array_last_item] = 'advanced_area';
        } else if (tab_tax === 'property_county_state') {
            slug_holder[array_last_item] = 'county-state';
        }

        how_holder[array_last_item] = 'like';

        if (jQuery('.halfsearch')[0] && mapfunctions_vars.adv_search_type === '8') {
            val_holder[array_last_item] = jQuery('#' + slug_holder[array_last_item]).parent().find('input:hidden').val();
        } else {
            val_holder[initial_array_last_item] = jQuery('.adv_search_tab_item.active').attr('data-term');
        }

    }


    all_checkers = '';

    if (mapfunctions_vars.adv_search_type === '6') {
        jQuery('.tab-pane.active .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
            if (jQuery(this).is(":checked")) {
                all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
            }
        });
    } else {

        jQuery('.search_wrapper .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
            if (jQuery(this).is(":checked")) {
                all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
            }
        });
    }





    halfmap = 0;

    if (jQuery('#google_map_prop_list_sidebar').length) {
        halfmap = 1;
    }
    postid = 1;
    if (document.getElementById('search_wrapper')) {
        postid = parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    ajaxurl = ajaxcalls_vars.wpestate_ajax;



    var filter_search_action10 = '';
    var adv_location10 = '';

    if (mapfunctions_vars.adv_search_type === '10') {
        filter_search_action10 = jQuery('#adv_actions').attr('data-value');
        adv_location10 = jQuery('#adv_location').val();
    }


    var filter_search_action11 = '';
    var filter_search_categ11 = '';
    var keyword_search = '';
    keyword_search = jQuery('#keyword').val();
    if (mapfunctions_vars.adv_search_type === '11') {
        filter_search_action11 = jQuery('#adv_actions').attr('data-value');
        filter_search_categ11 = jQuery('#adv_categ').attr('data-value');
        keyword_search = jQuery('#keyword_search').val();
    }
    var geo_lat = '';
    var geo_long = '';
    var geo_rad = '';
    var componentsbeds = '';
    var componentsbaths= '';

    if (jQuery("#geolocation_search").length > 0) {
        geo_lat = jQuery('#geolocation_lat').val();
        geo_long = jQuery('#geolocation_long').val();
        geo_rad = jQuery('#geolocation_radius').val();

    }

    if (jQuery('.tab-pane.active .geolocation_search_item').length>0){
        
        geo_lat = jQuery('.tab-pane.active .geolocation_lat').val();
        geo_long = jQuery('.tab-pane.active .geolocation_long').val();
        geo_rad = jQuery('.tab-pane.active #geolocation_radius').val();
    }

    if (jQuery('.wpestate-beds-baths-popoup-component').length>0){
        componentsbeds = jQuery('.wpresidence-componentsbeds').val();
        componentsbaths = jQuery('.wpresidence-componentsbaths').val();
    }


    if (jQuery('.tab-pane.active .wpestate-beds-baths-popoup-component').length>0){
        componentsbeds = jQuery('.tab-pane.active .wpresidence-componentsbeds').val();
        componentsbaths = jQuery('.tab-pane.active .wpresidence-componentsbaths').val();
    }




    var nonce = jQuery('#wpestate_ajax_filtering').val();
    var order = jQuery('#a_filter_order').attr('data-value');

    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_custom_adv_ajax_filter_listings_search',
            'val_holder': val_holder,
            'newpage': newpage,
            'postid': postid,
            'slider_min': slider_min,
            'slider_max': slider_max,
            'halfmap': halfmap,
            'all_checkers': all_checkers,
            'filter_search_action10': filter_search_action10,
            'adv_location10': adv_location10,
            'filter_search_action11': filter_search_action11,
            'filter_search_categ11': filter_search_categ11,
            'keyword_search': keyword_search,
            'geo_lat': geo_lat,
            'geo_long': geo_long,
            'geo_rad': geo_rad,
            'order': order,
            'term_counter': term_counter,
            'componentsbeds'            :   componentsbeds,
            'componentsbaths'           :   componentsbaths,
            'security': nonce,
        },
        success: function (data) {

    

            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.entry-title.title_prop').addClass('half_results').text(data.no_founs);

            jQuery('#listing_ajax_container').empty().append(data.cards);



            wpestate_restart_js_after_ajax();
            jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function () {
                jQuery(this).parent().addClass('wrap_custom_image');
            });
            
            if (data.saved_search !== null) {
                jQuery(".search_param").html(data.saved_search);
                jQuery("#search_args").val( JSON.stringify(data.args) );
                jQuery("#meta_args").val(  JSON.stringify(data.search_meta) );

            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}


function wpestate_js_pagination_ajax(){
    "use strict";

    jQuery('.pagination_ajax a').on('click', function (event) {
        event.preventDefault();
        var newpage = parseInt(jQuery(this).attr('data-future'), 10);
        wpestate_start_filtering(newpage);
    });

}


////////////////////////////////////////////////////////////////////////////////////////////
/// redo js after ajax calls - jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_restart_js_after_ajax() {
    "use strict";
    wpestate_lazy_load_carousel_property_unit();
    wpestate_card_unit_contact_actions();


    // wpestate_enable_half_map_pin_action();
    if (typeof wpestate_enable_half_map_pin_action == 'function') {
        wpestate_enable_half_map_pin_action();
    }
    var newpage, post_id, post_image, to_add, icon;

    jQuery('.pagination_ajax_search a').on('click', function (event) {
        event.preventDefault();

        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        if (mapfunctions_vars.custom_search === 'yes') {
            wpestate_custom_search_start_filtering_ajax(newpage);  // should be custom
        } else {
            wpestate_start_filtering_ajax(newpage);//
        }
    });

    jQuery('.pagination_ajax a').on('click', function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        wpestate_start_filtering(newpage);
    });



    jQuery('.property_listing').on('click', function (event) {
        if (event.target.classList.contains('demo-icon')) {
            return;
        }


        if (control_vars.property_modal === '1' && !Modernizr.mq('only all and (max-width: 1024px)')) {
            event.preventDefault();
            event.stopPropagation();
            scroll_modal_save = scroll_modal;

            var listing_id = jQuery(this).parent().attr('data-listid');
            var main_img_url = jQuery(this).parent().attr('data-main-modal');
            var main_title = jQuery(this).parent().attr('data-modal-title');
            var link = jQuery(this).parent().attr('data-modal-link');
            wpestate_enable_property_modal(listing_id, main_img_url, main_title, link);
        } else {
            if (control_vars.new_page_link === '_blank') {
                return;
            }
            var link;
            link = jQuery(this).attr('data-link');

            window.open(link, '_self');
        }
    });





    jQuery('.share_unit').on('click', function (event) {
        event.stopPropagation();
    });

    var already_in = [];

    jQuery('.compare-action').unbind('click');
    jQuery('.compare-action').on('click', function (event) {
        event.stopPropagation();
        jQuery('.prop-compare').animate({
            right: "0px"
        });
        post_id = jQuery(this).attr('data-pid');
        for (var i = 0; i < already_in.length; i++) {
            if (already_in[i] === post_id) {
                return;
            }
        }

        already_in.push(post_id);
        post_image = jQuery(this).attr('data-pimage');

        to_add = '<div class="items_compare ajax_compare" style="display:none;"><img src="' + post_image + '" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        jQuery('div.items_compare:first-child').css('background', 'red');
        if (parseInt(jQuery('.items_compare').length, 10) > 3) {
            jQuery('.items_compare:first').remove();
        }
        jQuery('#submit_compare').before(to_add);
        jQuery('.items_compare').fadeIn(800);
    });

    jQuery('#submit_compare').unbind('click');
    jQuery('#submit_compare').on('click', function (event) {
        jQuery('#form_compare').trigger('submit');
    });

    jQuery('.icon-fav').on('click', function (event) {
        event.stopPropagation();
        icon = jQuery(this);
        wpestate_add_remove_favorite(icon);
    });

    jQuery(".share_list, .icon-fav, .compare-action,.property_listing_details_v7_item").on('mouseenter', function () {
        jQuery(this).tooltip('show');
    })
            .on('mouseleave', function () {
                jQuery(this).tooltip('hide');
            });


    jQuery('.share_list').on('click', function (event) {
        event.stopPropagation();
        var sharediv = jQuery(this).parent().find('.share_unit');
        sharediv.toggle();
        jQuery(this).toggleClass('share_on');
    });

    wpestate_grid_list_controls();
    wpestate_enable_share_unit();
    wpestate_enable_not_logged_favorites();
}





/*
*
* Remove/Add to favorites(property page)  when login is not required
*
*/

function wpestate_add_remove_favorite_local_storage_single(icon,post_id){
    var current_favorites = window.localStorage.getItem('wpestate_favorites');
    post_id=parseInt(post_id);


    if(icon.hasClass('isnotfavorite')){

        if ( current_favorites ) {
            current_favorites=current_favorites + ',' + post_id;
            window.localStorage.setItem('wpestate_favorites',current_favorites );
        } else {
            current_favorites=post_id;
            window.localStorage.setItem('wpestate_favorites', current_favorites);
        }

        setCookie('wpestate_favorites',current_favorites,10);

        jQuery('#add_favorites').removeClass('isnotfavorite').addClass('isfavorite').attr('data-original-title', ajaxcalls_vars.remove_favorite);
        jQuery('#add_favorites').html('<i class="fas fa-heart"></i>' + ajaxcalls_vars.favorite);
  
    }else{

        var prop_ids = jQuery.map(current_favorites.split(','), function(value){
						return parseInt(value);
					});

               
        const index = prop_ids.indexOf( post_id );      
      
        if (index > -1) {
            prop_ids.splice(index, 1);      
            window.localStorage.setItem('wpestate_favorites', prop_ids);
            setCookie('wpestate_favorites',prop_ids,10);
        }


        jQuery('#add_favorites').removeClass('isfavorite').addClass('isnotfavorite').attr('data-original-title', ajaxcalls_vars.add_favorite);
        jQuery('#add_favorites').html('<i class="far fa-heart"></i>' + ajaxcalls_vars.favorite);

    }

    current_favorites = window.localStorage.getItem('wpestate_favorites');
}



/*
*
* Remove/Add to favorites when login is not required
*
*/


function wpestate_add_remove_favorite_local_storage(icon,post_id){
    var current_favorites = window.localStorage.getItem('wpestate_favorites');
    post_id=parseInt(post_id);

    if(icon.hasClass('icon-fav-off')){

        if ( current_favorites ) {
            current_favorites=current_favorites+','+post_id;
            window.localStorage.setItem('wpestate_favorites', current_favorites);
        } else {
            current_favorites=post_id;
            window.localStorage.setItem('wpestate_favorites', current_favorites);
        }

        setCookie('wpestate_favorites',current_favorites,10);

        icon.removeClass('icon-fav-off').addClass('icon-fav-on');
        icon.attr('data-original-title', ajaxcalls_vars.remove_fav);

    }else{

        var prop_ids = jQuery.map(current_favorites.split(','), function(value){
						return parseInt(value);
					});
           
        const index = prop_ids.indexOf( post_id );      
  
        if (index > -1) {
            prop_ids.splice(index, 1);
            window.localStorage.setItem('wpestate_favorites', prop_ids);
            setCookie('wpestate_favorites',prop_ids,10);
        }

        if (icon.hasClass('remove_fav_dash')) {
            icon.parents('.property_wrapper_dash').remove();
            icon.parents('.listing_wrapper').remove();
        }

        icon.removeClass('icon-fav-on').addClass('icon-fav-off');
        icon.attr('data-original-title', ajaxcalls_vars.add_favorite);
    }

    current_favorites = window.localStorage.getItem('wpestate_favorites');
}



/*
*
* Remove/Add to favorites
*
*/

function wpestate_add_remove_favorite(icon) {

    "use strict";
    var post_id, securitypass, ajaxurl;
    post_id = icon.attr('data-postid');
    securitypass = jQuery('#security-pass').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_ajax_filtering').val();
    var use_favorite_login  =   ajaxcalls_vars.favorites_login;

    if(use_favorite_login=="no"){
        wpestate_add_remove_favorite_local_storage(icon,post_id);
        return;
    }

    if (parseInt(ajaxcalls_vars.userid, 10) === 0) {

        if (!Modernizr.mq('only all and (max-width: 768px)')) {
            jQuery('.login-links').show();
            jQuery('#modal_login_wrapper').show();
            jQuery('#modal_login_wrapper').find('[autofocus]').focus();
            jQuery('#loginpop').val('1');
        } else {
            jQuery('.mobile-trigger-user').trigger('click');
        }


    } else {
        icon.toggleClass('icon-fav-off');
        icon.toggleClass('icon-fav-on');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action': 'wpestate_ajax_add_fav',
                'post_id': post_id,
                'security': nonce
            },
            success: function (data) {
                if (data.added) {
                    icon.removeClass('icon-fav-off').addClass('icon-fav-on');
                    icon.attr('data-original-title', ajaxcalls_vars.remove_fav);
                } else {

                    if (icon.hasClass('remove_fav_dash')) {
                        icon.parents('.property_wrapper_dash').remove();
                    }
                    icon.removeClass('icon-fav-on').addClass('icon-fav-off');
                    icon.attr('data-original-title', ajaxcalls_vars.add_favorite);
                }
            },
            error: function (errorThrown) {

            }
        });//end ajax
    }// end login use
}

////////////////////////////////////////////////////////////////////////////////////////////
/// resend listing for approval-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_resend_for_approval(prop_id, selected_div) {
    "use strict";
    var ajaxurl, normal_list_no;
    ajaxurl = control_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_property_actions').val();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_resend_for_approval',
            'propid': prop_id,
            'security': nonce
        },
        success: function (data) {

            if (data === 'pending') {
                selected_div.parent().empty().append('<span class="featured_prop">Sent for approval</span>');
                normal_list_no = parseInt(jQuery('#normal_list_no').text(), 10);
                jQuery('#normal_list_no').text(normal_list_no - 1);
            } else {
                selected_div.removeClass('resend_pending').html(data);
            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// make property featured-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_make_prop_featured(prop_id, selectedspan) {
    "use strict";
    var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_property_actions').val();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_make_prop_featured',
            'propid': prop_id,
            'security': nonce
        },
        success: function (data) {
            if (data.trim() === 'done') {
                selectedspan.empty().html('<span class="label label-success">' + ajaxcalls_vars.prop_featured + '</span>');
                var featured_list_no = parseInt(jQuery('#featured_list_no').text(), 10);
                jQuery('#featured_list_no').text(featured_list_no - 1);
            } else {
                selectedspan.empty().removeClass('make_featured').addClass('featured_exp').text(ajaxcalls_vars.no_prop_featured);
            }

        },
        error: function (errorThrown) {
        }

    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal recuring-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_recuring_pay_pack_via_paypal() {
    "use strict";
    var ajaxurl, packName, packId;
    ajaxurl = control_vars.admin_url + 'admin-ajax.php';

    packName = jQuery('.package_selected .pack-listing-title').text();
    packId = jQuery('.package_selected .pack-listing-title').attr('data-packid');

    var nonce = jQuery('#wpestate_payments_nonce').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_paypal_pack_recuring_generation_rest_api',
            'packName': packName,
            'packId': packId,
            'security': nonce
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

jQuery(".buypackage").click(function () {
    "use strict";
    var stripe_pack_id, stripetitle2, stripetitle, stripepay;


    jQuery(".pack-listing").removeClass("package_selected");
    jQuery(".pack-listing input").prop('checked', false);

    jQuery(this).find('.input_pak_check').prop('checked', true);
    jQuery(this).parent().addClass("package_selected");

    stripetitle = jQuery(this).parent().find('.pack-listing-title').attr('data-stripetitle');
    stripetitle2 = jQuery(this).parent().find('.pack-listing-title').attr('data-stripetitle2');
    stripepay = jQuery(this).parent().find('.pack-listing-title').attr('data-stripepay');
    stripe_pack_id = jQuery(this).parent().find('.pack-listing-title').attr('data-packid');

    jQuery('.stripe_buttons').attr("id", stripetitle2);
    jQuery('#stripe_script').attr("data-amount", stripepay);
    jQuery('#stripe_script').attr("data-description", stripetitle);

    jQuery('#pack_id').val(stripe_pack_id);
    jQuery('#pack_title').val(stripetitle2);
    jQuery('#pay_ammout').val(stripepay);
    jQuery('#stripe_form').attr('data-amount', stripepay);


    jQuery('.wpestate_stripe_pay_desc').html(control_vars.stripe_pay_for + " " + stripetitle2);
    jQuery('#wpestate_stripe_form_button_sumit').html(control_vars.stripe_pay + " " + stripepay / 100 + " " + control_vars.submission_curency);

    // enable stripe code


});



////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_pay_pack_via_paypal() {
    "use strict";
    var ajaxurl, packName, packId;
    ajaxurl = control_vars.admin_url + 'admin-ajax.php';
    packName = jQuery('.package_selected .pack-listing-title').text();
    packId = jQuery('.package_selected .pack-listing-title').attr('data-packid');
    var nonce = jQuery('#wpestate_payments_nonce').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_paypal_pack_generation',
            'packName': packName,
            'packId': packId,
            'security': nonce
        },
        success: function (data) {

            window.location.href = data;
        },
        error: function (errorThrown) {

        }
    });//end ajax

}
////////////////////////////////////////////////////////////////////////////////////////////
/// listing pay -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_listing_pay(prop_id, selected_div, is_featured, is_upgrade) {
    "use strict";
    var ajaxurl = control_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_payments_nonce').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_listing_pay',
            'propid': prop_id,
            'is_featured': is_featured,
            'is_upgrade': is_upgrade,
            'security': nonce
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// start filtering -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_start_filtering(newpage) {
    "use strict";
    jQuery('#gmap-loading').show();
    jQuery('#grid_view').addClass('icon_selected');
    jQuery('#list_view').removeClass('icon_selected');

    var action, category, county, city, area, order, ajaxurl, page_id;
    // get action vars
    action = jQuery('#a_filter_action').attr('data-value');
    // get category
    category = jQuery('#a_filter_categ').attr('data-value');

    // get county
    county = jQuery('#a_filter_county').attr('data-value');

    // get city
    city = jQuery('#a_filter_cities').attr('data-value');
    // get area
    area = jQuery('#a_filter_areas').attr('data-value');
    // get order
    order = jQuery('#a_filter_order').attr('data-value');
    ajaxurl = ajaxcalls_vars.wpestate_ajax;
    page_id = jQuery('#page_idx').val();

    var card_version = jQuery('.wpestate_filter_list_properties_wrapper').attr('data-card_version');
    var rownumber = jQuery('.wpestate_filter_list_properties_wrapper').attr('data-rownumber');
    var ishortcode = jQuery('.wpestate_filter_list_properties_wrapper').attr('data-ishortcode');
    var number = jQuery('.wpestate_filter_list_properties_wrapper').attr('data-number');

    var align = '';
    if (jQuery('.wpestate_filter_list_properties_wrapper').length > 0) {
        jQuery('.wpestate_filter_list_properties_wrapper .listing_wrapper').remove();
        jQuery('.wpestate_filter_list_properties_wrapper .pagination_ajax').remove();
        jQuery('.wpestate_filter_list_properties_wrapper .no_results').remove();
        align = jQuery('.wpestate_filter_list_properties_wrapper').attr('data-align');

        jQuery('#listing_loader2').show();
    } else {
        jQuery('#listing_ajax_container').empty();
        jQuery('#listing_loader').show();

    }
    var nonce = jQuery('#wpestate_ajax_filtering').val();


    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_ajax_filter_listings',
            'action_values': action,
            'category_values': category,
            'county': county,
            'city': city,
            'area': area,
            'order': order,
            'newpage': newpage,
            'page_id': page_id,
            'align': align,
            'card_version': card_version,
            'rownumber': rownumber,
            'ishortcode': ishortcode,
            'number':number,
            'security': nonce
        },
        success: function (data) {

            jQuery('#listing_loader').hide();
            if (jQuery('.wpestate_filter_list_properties_wrapper').length > 0) {
                jQuery('#listing_loader2').hide();
                jQuery('.wpestate_filter_list_properties_wrapper').append(data.to_show);
            } else {
                jQuery('#listing_ajax_container').empty().append(data.to_show);
            }

            jQuery('.pagination_nojax').hide();
            wpestate_restart_js_after_ajax();

            // map update
            var no_results = parseInt(data.no_results);
            if (no_results !== 0) {
                wpestate_load_on_demand_pins(data.markers, no_results, 0);
            } else {
                wpestate_show_no_results();
            }

            jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function () {
                jQuery(this).parent().addClass('wrap_custom_image');
            });

            jQuery('#gmap-loading').hide();

        },
        error: function (errorThrown) {

        }
    });//end ajax
}


////////////////////////////////////////////////////////////////////////////////////////////
/// change pass on profile-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_change_pass_profile() {
    "use strict";
    var oldpass, newpass, renewpass, securitypass, ajaxurl;
    oldpass = jQuery('#oldpass').val();
    newpass = jQuery('#newpass').val();
    renewpass = jQuery('#renewpass').val();
    securitypass = jQuery('#security-pass').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_update_pass',
            'oldpass': oldpass,
            'newpass': newpass,
            'renewpass': renewpass,
            'security-pass': securitypass
        },
        success: function (data) {
            jQuery('#profile_pass').empty().append('<div class="login-alert">' + data + '<div>');
            jQuery('#oldpass, #newpass, #renewpass').val('');
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// user register -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////

function wpestate_register_user(type) {
    "use strict";
    var capthca, user_login_register, user_email_register, user_pass, user_pass_retype, nonce, ajaxurl, new_user_type;
    /* 1- topbar
     * 2- widget
     * 3- shortcode
     * 4- modal !?
     * 5 -mobile
     */

    capthca = '';

    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">' + control_vars.procesing + '</div>');

    if (type === 1) {
        if (control_vars.usecaptcha === 'yes') {
            capthca = grecaptcha.getResponse(
                    widgetId1
                    );
        }

        user_login_register = jQuery('#user_login_register_topbar').val();
        user_email_register = jQuery('#user_email_register_topbar').val();
        nonce = jQuery('#security-register-topbar').val();
        if (ajaxcalls_vars.userpass === 'yes') {
            user_pass = jQuery('#user_password_topbar').val();
            user_pass_retype = jQuery('#user_password_topbar_retype').val();
        }


        new_user_type = jQuery('#new_user_type_topbar').val();

        if (!jQuery('#user_terms_register_topbar').is(":checked")) {
            jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">' + control_vars.terms_cond + '</div>');
            return;
        }

        if(jQuery('#new_user_type_topbar').length>0 ){
            var user_type_value= parseInt (jQuery('#new_user_type_topbar').val(),10);

            if( user_type_value===0 ){
                jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">' + control_vars.user_type_warn + '</div>');
                return;
            }
        }


    } else if (type === 2) {

        if (control_vars.usecaptcha === 'yes') {
            capthca = grecaptcha.getResponse(
                    widgetId3
                    );
        }

        user_login_register = jQuery('#user_login_register_wd').val();
        user_email_register = jQuery('#user_email_register_wd').val();
        nonce = jQuery('#security-register').val();
        if (ajaxcalls_vars.userpass === 'yes') {
            user_pass = jQuery('#user_password_wd').val();
            user_pass_retype = jQuery('#user_password_wd_retype').val();
        }

        new_user_type = jQuery('#new_user_type_wd').val();

        if (!jQuery('#user_terms_register_wd').is(":checked")) {
            jQuery('#register_message_area_wd').empty().append('<div class="login-alert">' + control_vars.terms_cond + '</div>');
            return;
        }

        if(jQuery('#new_user_type_wd').length>0 ){
            var user_type_value= parseInt (jQuery('#new_user_type_wd').val(),10);

            if( user_type_value===0 ){
                jQuery('#register_message_area_wd').empty().append('<div class="login-alert">' + control_vars.user_type_warn + '</div>');
                return;
            }
        }


    } else if (type === 3) {

        if (control_vars.usecaptcha === 'yes') {
            capthca = grecaptcha.getResponse(
                    widgetId4
                    );
        }

        user_login_register = jQuery('#user_login_register').val();
        user_email_register = jQuery('#user_email_register').val();
        nonce = jQuery('#security-register').val();
        if (ajaxcalls_vars.userpass === 'yes') {
            user_pass = jQuery('#user_password').val();
            user_pass_retype = jQuery('#user_password_retype').val();
        }

        new_user_type = jQuery('#new_user_type').val();

        if (!jQuery('#user_terms_register_sh').is(":checked")) {
            jQuery('#register_message_area').empty().append('<div class="login-alert">' + control_vars.terms_cond + '</div>');
            return;
        }

        if(jQuery('#new_user_type').length>0 ){
            var user_type_value= parseInt (jQuery('#new_user_type').val(),10);

            if( user_type_value===0 ){
                jQuery('#register_message_area').empty().append('<div class="login-alert">' + control_vars.user_type_warn + '</div>');
                return;
            }
        }



    } else if (type === 5) {

        if (control_vars.usecaptcha === 'yes') {
            capthca = grecaptcha.getResponse(
                    widgetId2
                    );
        }
        user_login_register = jQuery('#user_login_register_mobile').val();
        user_email_register = jQuery('#user_email_register_mobile').val();
        nonce = jQuery('#security-register-mobile').val();
        if (ajaxcalls_vars.userpass === 'yes') {
            user_pass = jQuery('#user_password_mobile').val();
            user_pass_retype = jQuery('#user_password_mobile_retype').val();
        }

        new_user_type = jQuery('#new_user_type_mobile').val();




        if (!jQuery('#user_terms_register_mobile').is(":checked")) {
            jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">' + control_vars.terms_cond + '</div>');
            return;
        }

        if(jQuery('#new_user_type_mobile').length>0 ){
            var user_type_value= parseInt (jQuery('#new_user_type_mobile').val(),10);

            if( user_type_value===0 ){
                jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">' + control_vars.user_type_warn + '</div>');
                return;
            }
        }

    }


    var nonce = jQuery('#wpestate_ajax_log_reg').val();

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_register_user',
            'user_login_register': user_login_register,
            'user_email_register': user_email_register,
            'user_pass': user_pass,
            'user_pass_retype': user_pass_retype,
            'type': type,
            'security': nonce,
            'capthca': capthca,
            'new_user_type': new_user_type
        },

        success: function (data) {
            // This outputs the result of the ajax request
            
            var extra_class='';
            if (data.register === true) {
                extra_class='wpestate_succes';
            }

            if (type === 1) {
                jQuery('#register_message_area_topbar').empty().append('<div class="login-alert  '+extra_class+' ">' + data.message + '</div>');
                jQuery('#user_login_register_topbar').val('');
                jQuery('#user_email_register_topbar').val('');
                jQuery('#user_password_topbar').val('');
                jQuery('#user_password_topbar_retype').val('');
                jQuery('#new_user_type_topbar').val('0');
                if(data.register==true ){
                    setTimeout(function(){ jQuery('#widget_login_topbar').trigger('click') }, 1500);
                }

            } else if (type === 2) {
                jQuery('#register_message_area_wd').empty().append('<div class="login-alert '+extra_class+'">' + data.message + '</div>');
                jQuery('#user_login_register_wd').val('');
                jQuery('#user_email_register_wd').val('');
                jQuery('#user_password_wd').val('');
                jQuery('#user_password_wd_retype').val('');
                jQuery('#new_user_type_wd').val('0');
                if(data.register==true ){
                    setTimeout(function(){ jQuery('#widget_login_sw').trigger('click') }, 1500);
                }
            } else if (type === 3) {
                jQuery('#register_message_area').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '</div>');
                jQuery('#user_login_register').val('');
                jQuery('#user_email_register').val('');
                jQuery('#user_password').val('');
                jQuery('#user_password_retype').val('');
                jQuery('#new_user_type').val('0');
            } else if (type === 5) {
                jQuery('#register_message_area_mobile').empty().append('<div class="login-alert '+extra_class+'">' + data.message + '</div>');
                jQuery('#user_login_register_mobile').val('');
                jQuery('#user_email_register_mobile').val('');
                jQuery('#user_password_mobile').val('');
                jQuery('#user_password_mobile_retype').val('');
                jQuery('#new_user_type_mobile').val('0');
                if(data.register==true ){
                    setTimeout(function(){ jQuery('#widget_login_mobile').trigger('click') }, 1500);
                }
                
            }
        },
        error: function (errorThrown) {
        }
    });
}





////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_forgot(type) {
    "use strict";

    var forgot_email, securityforgot, postid, ajaxurl;
    postid = jQuery('#postid').val();

    if (type === 1) {
        forgot_email = jQuery('#forgot_email').val();
        securityforgot = jQuery('#security-forgot').val();
    }
    if (type === 2) {
        forgot_email = jQuery('#forgot_email_topbar').val();
        securityforgot = jQuery('#security-forgot-topbar').val();
    }
    if (type === 3) {
        forgot_email = jQuery('#forgot_email_shortcode').val();
        securityforgot = jQuery('#security-login-forgot_wd').val();
    }
    if (type === 5) {
        forgot_email = jQuery('#forgot_email_mobile').val();
        securityforgot = jQuery('#security-forgot-mobile').val();
        postid = jQuery('#postid-mobile').val();
    }

    postid = jQuery('#postid').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_ajax_log_reg').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action': 'wpestate_ajax_forgot_pass',
            'forgot_email': forgot_email,
            'security': nonce,
            'postid': postid,
            'type': type,
            'security': nonce
        },

        success: function (data) {
            var extra_class='';
            if (data.reset === true) {
                extra_class='wpestate_succes';
            }
            if (type === 1) {
                jQuery('#forgot_email').val('');
                jQuery('#forgot_pass_area').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '<div>');
            }
            if (type === 2) {
                jQuery('#forgot_email_topbar').val('');
                jQuery('#forgot_pass_area_topbar').empty().append('<div class="login-alert  '+extra_class+'">' + data.message + '<div>');
            }
            if (type === 3) {
                jQuery('#forgot_email_shortcode').val('');
                jQuery('#forgot_pass_area_shortcode').empty().append('<div class="login-alert  '+extra_class+'">' + data.message + '<div>');
            }
            if (type === 5) {
                jQuery('#forgot_email_mobile').val('');
                jQuery('#forgot_pass_area_mobile').empty().append('<div class="login-alert  '+extra_class+' ">' + data.message + '<div>');
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_login_wd() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user = jQuery('#login_user_wd').val();
    login_pwd = jQuery('#login_pwd_wd').val();
    security = jQuery('#security-login').val();
    ispop = jQuery('#loginpop_wd').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    var nonce = jQuery('#wpestate_ajax_log_reg').val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_loginx_form',
            'login_user': login_user,
            'login_pwd': login_pwd,
            'ispop': ispop,
            'security': nonce
        },

        success: function (data) {
            var extra_class='';
            if (data.loggedin === true) {
                extra_class='wpestate_succes';
            }
   

            jQuery('#login_message_area_wd').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#ajax_login_container').remove();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {

        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_login_topbar() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security, ispop;

    login_user = jQuery('#login_user_topbar').val();
    login_pwd = jQuery('#login_pwd_topbar').val();
    security = jQuery('#security-login-topbar').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    ispop = jQuery('#loginpop').val();

    if (jQuery('#loginpop_submit').val() === '3') {
        ispop = 3;
    }




    jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    var nonce = jQuery('#wpestate_ajax_log_reg').val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_loginx_form_topbar',
            'login_user': login_user,
            'login_pwd': login_pwd,
            'ispop': ispop,
            'security': nonce
        },

        success: function (data) {

            var extra_class='';
            if (data.loggedin === true) {
                extra_class='wpestate_succes';
            }
            jQuery('#login_message_area_topbar').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '<div>');
            
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {

                    ajaxcalls_vars.userid = data.newuser;

                    jQuery('#user_menu_u.user_not_loged').unbind('click');
                    jQuery('#user_menu_u').removeClass('user_not_loged').addClass('user_loged');
                    jQuery('#modal_login_wrapper').hide();
                    wp_estate_update_menu_bar(data.newuser);
                    wpestate_open_menu();
                } else if (parseInt(data.ispop, 10) === 2) {
                    location.reload();
                } else if (parseInt(data.ispop, 10) === 3) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#user_menu_u.user_not_loged').unbind('click');
                    jQuery('#user_menu_u').removeClass('user_not_loged').addClass('user_loged');
                    jQuery('#modal_login_wrapper').hide();
                    wp_estate_update_menu_bar(data.newuser);
                    wpestate_open_menu();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }


            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {

        }
    });
}


function wpestate_login_mobile() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security,ispop;

    login_user = jQuery('#login_user_mobile').val();
    login_pwd = jQuery('#login_pwd_mobile').val();
    security = jQuery('#security-login-mobile').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    if (jQuery('#loginpop_submit').val() === '3') {
        ispop = 3;
    }



    jQuery('#login_message_area_mobile').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    var nonce = jQuery('#wpestate_ajax_log_reg').val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_loginx_form_mobile',
            'login_user': login_user,
            'login_pwd': login_pwd,
            'ispop': ispop,
            'security': nonce
        },

        success: function (data) {
         
            var extra_class='';
            if (data.loggedin === true) {
                extra_class='wpestate_succes';
            }
   
            jQuery('#login_message_area_mobile').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '<div>');
            if (data.loggedin === true) {   
          

                if (parseInt(jQuery('#loginpop').val(), 10) === 2) {
                    location.reload();
                } else if (parseInt(data.ispop, 10) === 3) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#user_menu_u.user_not_loged').unbind('click');
                    jQuery('#user_menu_u').removeClass('user_not_loged').addClass('user_loged');
                    jQuery('#modal_login_wrapper').hide();
                
                    wp_estate_update_menu_bar_mobile(data.newuser);
                    //wpestate_open_menu();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
            } else {
                jQuery('#login_user_mobile').val('');
                jQuery('#login_pwd_mobile').val('');
            }
        },
        error: function (errorThrown) {

        }
    });
}

//////////////////////////////////////////////////////////////////////////////////
// login function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_login() {
    "use strict";
    var login_user, login_pwd, security, ispop, ajaxurl;
    login_user = jQuery('#login_user').val();
    login_pwd = jQuery('#login_pwd').val();
    security = jQuery('#security-login').val();
    ispop = jQuery('#loginpop').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    var nonce = jQuery('#wpestate_ajax_log_reg').val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_loginx_form',
            'login_user': login_user,
            'login_pwd': login_pwd,
            'ispop': ispop,
            'security': nonce
        },
        success: function (data) {
            
            var extra_class='';
            if (data.loggedin === true) {
                extra_class='wpestate_succes';
            }
  
            jQuery('#login_message_area').empty().append('<div class="login-alert '+extra_class+' ">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {

                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#loginmodal').modal('hide');
                    wp_estate_update_menu_bar(data.newuser);
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}



////////////////////////////////////////////////////////////////////////////////
// update bar after login -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wp_estate_update_menu_bar(newuser) {
    "use strict";
    var usericon, ajaxurl;
    ajaxurl = control_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_ajax_filtering').val();

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': "wpestate_update_menu_bar",
            'newuser': newuser,
            'security': nonce
        },
        success: function (data) {

            jQuery('#user_menu_u').after(data.menu);

            usericon = '<a class="navicon-button x"><div class="navicon"></div></a><div class="menu_user_picture" style="background-image: url(' + data.picture + ')"></div>';
            jQuery('#user_menu_u').append(usericon).addClass('user_loged');
            jQuery('.submit_action').remove();
            jQuery('.submit_listing').remove();
            jQuery('#agent_property_ajax_nonce').val(data.nonce_contact);


        },
        error: function (errorThrown) {
        }
    });//end ajax
}


function wp_estate_update_menu_bar_mobile(newuser) {
    "use strict";

    var usericon, ajaxurl;
    ajaxurl = control_vars.admin_url + 'admin-ajax.php';
    var nonce = jQuery('#wpestate_ajax_filtering').val();

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': "wpestate_update_menu_bar_mobile",
            'newuser': newuser,
            'security': nonce
        },
        success: function (data) {
         
            jQuery('.login_sidebar').hide();
            jQuery('.mobilemenu-close-user').after(data.menu);
            jQuery('.submit_action').remove();
            jQuery('.submit_listing').remove();
            jQuery('#agent_property_ajax_nonce').val(data.nonce_contact);


            // for mobile
            jQuery('.mobilemenu-close-user').trigger('click');
            var mobile_user_icon = '<div class="menu_user_picture" style="background-image: url(' + data.picture + ');"></div>'
            jQuery('.mobile-trigger-user').empty().append(mobile_user_icon);
            jQuery('#login_message_area_mobile .login-alert').empty().hide();

        },
        error: function (errorThrown) {
        }
    });//end ajax
}
////////////////////////////////////////////////////////////////////////////////////////////
// on ready -jslint checked
//  developer listing on tab click !!
////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    "use strict";

    wpestate_add_to_favorites();
    wpestate_js_pagination_ajax();
    wpestate_enable_not_logged_favorites();
    wpestate_loade_agent_listings();


    $('.wpestate_social_login').on('click', function () {
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var social_type = $(this).attr('data-social');
        var nonce = $(this).parent().find('.wpestate_social_login_nonce').val();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_social_login_generate_link',
                'social_type': social_type,
                'nonce': nonce

            },
            success: function (data) {
                window.location.href = data;
            },
            error: function (errorThrown) {
            }
        });

    });

    $('.developer_listing .term_bar_item').on('click', function (event) {

        // display load more
        var listing_parent_pointer = $(this).parents('.single_listing_block');
        $('.load_more_ajax_cont .listing_load_more', listing_parent_pointer).fadeIn();

        $('.term_bar_item').removeClass('active_term');
        $(this).addClass('active_term');
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name = $(this).attr('data-term_name');
        var agency_id = $('.term_bar_wrapper').attr('data-agency_id');
        var post_id = $('.term_bar_wrapper').attr('data-post_id');
        var is_agency = 0;
        var nonce = jQuery('#wpestate_developer_listing_nonce').val();
        if ($('.single-estate_agency').length > 0) {
            is_agency = 1;
        }

        $('.agency_listings_wrapper').empty();
        $('#listing_loader').show();



        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_agency_listings',
                'term_name': term_name,
                'agency_id': agency_id,
                'post_id': post_id,
                'is_agency': is_agency,
                'security': nonce

            },
            success: function (data) {

                $('#listing_loader').hide();
                $('.agency_listings_wrapper').append(data);
                wpestate_restart_js_after_ajax();


            },
            error: function (errorThrown) {
            }
        });



    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    // agent page listing tabs processing
    ////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
// agent / developer load more processing
////////////////////////////////////////////////////////////////////////////////////////////

    $('body').on('click', '.listing_load_more', function (event) {

        var this_point = $(this);
        var listing_parent_pointer = $(this).parents('.single_listing_block');
        var loaded_items = $('.agency_listings_wrapper .listing_wrapper', listing_parent_pointer).length;
        var active_tab = $('.active_term', listing_parent_pointer);
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name = $(active_tab).attr('data-term_name');
        var agent_id = $('.term_bar_wrapper', listing_parent_pointer).attr('data-agent_id');
        var post_id = $('.term_bar_wrapper', listing_parent_pointer).attr('data-post_id');
        var agency_id = $('.term_bar_wrapper', listing_parent_pointer).attr('data-agency_id');
        var is_agency = 0;

        if ($('.single-estate_agency').length > 0) {
            is_agency = 1;
        }
        $('#listing_loader', listing_parent_pointer).fadeIn();


        if (agent_id) {

            var action_name = 'wpestate_agent_listings';
            var nonce = jQuery('#wpestate_agent_listings_nonce').val();
        }
        if (agency_id) {

            var action_name = 'wpestate_agency_listings';
            var nonce = jQuery('#wpestate_developer_listing_nonce').val();
        }



        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': action_name,
                'term_name': term_name,
                'agent_id': agent_id,
                'agency_id': agency_id,
                'post_id': post_id,
                'loaded': loaded_items,
                'is_agency': is_agency,
                'security': nonce
            },
            success: function (data) {

                $('#listing_loader', listing_parent_pointer).fadeOut();
                var count = (data.match(/is/g) || []).length;
                if (count === 0) {
                    this_point.fadeOut();
                } else {
                    $('.agency_listings_wrapper').append(data);
                }

                wpestate_restart_js_after_ajax();
            },
            error: function (errorThrown) {

            }
        });

    });





    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#stripe_cancel').on('click', function (event) {

        var stripe_user_id, ajaxurl;
        stripe_user_id = $(this).attr('data-stripeid');
        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $('#stripe_cancel').text(ajaxcalls_vars.saving);
        var nonce = jQuery('#wpestate_stripe_cancel_nonce').val();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_cancel_stripe',
                'stripe_customer_id': stripe_user_id,
                'security': nonce,

            },
            success: function (data) {
                $('#stripe_cancel').text(ajaxcalls_vars.stripecancel);
            },
            error: function (errorThrown) {
            }
        });
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    /// resend for approval
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.resend_pending').on('click', function (event) {

        var prop_id = $(this).attr('data-listingid');
        wpestate_resend_for_approval(prop_id, $(this));
    });



    jQuery('#wpestate_stripe_booking_recurring').on('click', function () {

        var modalid = jQuery(this).attr('data-modalid');
        var modal = jQuery('#' + modalid);
        
        modal.appendTo('body');
        
        modal.show();
        jQuery('#' + modalid + ' .wpestate_stripe_form_1').show();

        wpestate_start_stripe(1, modalid);
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  pack upgrade via paypal
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#pick_pack').on('click', function (event) {

        var pay_paypal;
        pay_paypal = '<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">' + ajaxcalls_vars.paypal + '</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();


        if ($('#pack_recuring').is(':checked')) {
            wpestate_recuring_pay_pack_via_paypal();
        } else {
            wpestate_pay_pack_via_paypal();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// listing pay via paypal
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.listing_submit_normal').on('click', function (event) {
        var prop_id, featured_checker, is_featured, is_upgrade, pay_paypal;
        pay_paypal = '<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">' + ajaxcalls_vars.paypal + '</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();


        prop_id = $(this).attr('data-listingid');
        featured_checker = $(this).parent().find('input');
        is_featured = 0;
        is_upgrade = 0;

        if (featured_checker.prop('checked')) {
            is_featured = 1;
        } else {
            is_featured = 0;
        }

        wpestate_listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });

    jQuery('.woo_pay_submit').on('click', function () {
        var pay_paypal, prop_id, book_id, invoice_id, is_featured, is_upgrade, ajaxurl, depozit, is_submit, pack_id;
        prop_id = jQuery(this).attr('data-propid');
        depozit = jQuery(this).attr('data-deposit');
        is_featured = jQuery(this).attr('data-is_featured');
        pack_id = jQuery('.package_selected').attr('data-id');
        is_upgrade = 0;
        is_submit = 1;
        if (jQuery('#open_packages').length > 0) {
            is_submit = 0;
        }
        book_id = '';
        invoice_id = '';

        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_woo_pay',
                'propid': prop_id,
                'depozit': depozit,
                'is_submit': is_submit,
                'is_featured': is_featured,
                'pack_id': pack_id,
                'book_id': book_id,
                'invoiceid': invoice_id,
//                    'price_pack'    :   price_pack,
//                    'security'      :   nonce,
            },
            success: function (data) {
                if (data !== false) {
                    window.location.href = ajaxcalls_vars.checkout_url;
                }
            },
            error: function (errorThrown) {}
        });//end ajax
    });

    $('.listing_upgrade').on('click', function (event) {
        var is_upgrade, is_featured, prop_id;
        is_upgrade = 1;
        is_featured = 0;
        prop_id = $(this).attr('data-listingid');
        wpestate_listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });



    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Property page  + ajax call on contact
    ///////////////////////////////////////////////////////////////////////////////////////////


    wpestate_agent_submit_email();

    wpestate_theme_slider_show_contact();
    wpestate_enable_schedule_contact();

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  property listing listing
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('.listing_filters_head li').on('click', function (event) {

        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        parent.find('input:hidden').val(value);

        wpestate_start_filtering(1);


    });




    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// advanced search filtering
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('.adv_listing_filters_head li').on('click', function (event) {

        var pick, value, parent, args, page_id, ajaxurl;
        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        args = $('#searcharg').val();
        page_id = $('#page_idx').val();
        $('#listing_ajax_container').empty();
        $('#listing_loader').show();
        var nonce = jQuery('#wpestate_search_nonce').val();
        $.ajax({
            type: 'POST',
            url: ajaxurl,

            data: {
                'action': 'wpestate_advanced_search_filters',
                'args': args,
                'value': value,
                'page_id': page_id,
                'security': nonce
            },
            success: function (data) {
                $('#listing_loader').hide();
                $('#listing_ajax_container').append(data);
                wpestate_restart_js_after_ajax();
                wpestate_add_pagination_orderby();
            },
            error: function (errorThrown) {
            }
        }); //end ajax
    });


    function wpestate_add_pagination_orderby() {

        var order = $('#a_filter_order').attr('data-value');
        jQuery('.pagination a').each(function () {
            var href = $(this).attr('href');
            href = href + "&order_search=" + order;
            $(this).attr('href', href);
        });
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  Ajax add to favorites on listing
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('.icon-fav,.remove_fav_dash').on('click', function (event) {
        event.stopPropagation();
        var icon = $(this);
        wpestate_add_remove_favorite(icon);
    });




    // remove from fav listing on user profile
    $('.icon-fav-on-remove').on('click', function (event) {
        event.stopPropagation();
        $(this).parent().parent().remove();

    });




    ////////////////////////////////////////////////////////////////////////////////
    // register calls and functions
    ////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register').on('click', function (event) {

        wpestate_register_user(3);
    });

    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(3);
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  WIDGET Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_wd').on('click', function () {

        wpestate_register_user(2);
    });

    $('#user_email_register_wd, #user_login_register_wd').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(2);
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  TOPBAR Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_topbar').on('click', function () {

        wpestate_register_user(1);
    });

    $('#user_email_register_topbar, #user_login_register_topbar, #user_password_topbar, #user_password_topbar_retype').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(1);
        }
    });

    $('#wp-submit-register_mobile').on('click', function () {

        wpestate_register_user(5);
    });

    $('#user_email_register_mobile, #user_login_register_mobile, #user_password_mobile, #user_password_mobile_retype').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(5);
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#forgot_pass').on('click', function (event) {

        event.preventDefault();
        $("#login-div").hide();
        $("#forgot-pass-div-sh").show();
    });

    $('#return_login').on('click', function (event) {

        event.preventDefault();
        $("#forgot-pass-div-sh").hide();
        $("#login-div").show();
    });


    $('#forgot_pass_topbar').on('click', function (event) {

        event.preventDefault();
        $("#login-div_topbar,#login-div-title-topbar,#register-div-topbar,#login-div_topbar,#register-div-title-topbar").hide();
        $("#forgot-div-title-topbar,#forgot-pass-div").show().find('[autofocus]').focus();
        $('#forgot_pass_topbar').hide();
    });


    $('#forgot_pass_mobile').on('click', function (event) {

        event.preventDefault();
        $("#login-div_mobile,#login-div-title-mobile").hide();
        $("#forgot-div-title-mobile,#forgot-pass-div-mobile").show().find('[autofocus]').focus();
    });


    $('#return_login_topbar').on('click', function (event) {

        event.preventDefault();
        $("#forgot-div-title-topbar,#forgot-pass-div").hide();
        $("#login-div_topbar,#login-div-title-topbar").show().find('[autofocus]').focus();
    });

    $('#return_login_mobile').on('click', function (event) {

        event.preventDefault();
        $("#forgot-div-title-mobile,#forgot-pass-div-mobile").hide();
        $("#login-div_mobile,#login-div-title-mobile").show().find('[autofocus]').focus();
    });

    $('#forgot_pass_widget').on('click', function (event) {

        event.preventDefault();
        $("#login-div-title,#login-div").hide();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").show().find('[autofocus]').focus();
    });

    $('#return_login_shortcode').on('click', function (event) {

        event.preventDefault();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").hide();
        $("#login-div-title,#login-div").show().find('[autofocus]').focus();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  forgot pass
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-forgot-but').on('click', function () {

        wpestate_forgot(1);
    });

    $('#wp-forgot-but-topbar').on('click', function () {
        wpestate_forgot(2);
    });

    $('#wp-forgot-but-mobile').on('click', function () {
        wpestate_forgot(5);
    });


    $('#wp-forgot-but_shortcode').on('click', function () {
        wpestate_forgot(3);
    });


    $('#forgot_email').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(1);
        }
    });

    $('#forgot_email_topbar').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(2);
        }
    });

    $('#forgot_email_topbar').keydown(function (e) {

        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(3);
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// TOPBAR  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#widget_register_topbar').on('click', function (event) {

        event.preventDefault();
        $('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
        $('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot_pass_topbar').show().find('[autofocus]').focus();


    });

    $('#widget_login_topbar').on('click', function (event) {

        event.preventDefault();
        $('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot_pass_topbar').show().find('[autofocus]').focus();
        $('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
    });

    $('#widget_register_mobile').on('click', function (event) {

        event.preventDefault();
        $('#login-div_mobile').hide();
        $('#register-div-mobile').show().find('[autofocus]').focus();
        $('#login-div-title-mobile').hide();
        $('#register-div-title-mobile').show();
    });

    $('#widget_login_mobile').on('click', function (event) {

        event.preventDefault();
        $('#login-div_mobile').show().find('[autofocus]').focus();
        $('#register-div-mobile').hide();
        $('#login-div-title-mobile').show();
        $('#register-div-title-mobile').hide();
    });




    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// WIDGET  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#widget_register_sw').on('click', function (event) {

        event.preventDefault();
        $('.loginwd_sidebar #login-div').hide();
        $('.loginwd_sidebar #register-div').show().find('[autofocus]').focus();
        $('.loginwd_sidebar #login-div-title').hide();
        $('.loginwd_sidebar #register-div-title').show();
    });

    $('#widget_login_sw').on('click', function (event) {

        event.preventDefault();
        $('.loginwd_sidebar #register-div').hide();
        $('.loginwd_sidebar #login-div').show().find('[autofocus]').focus();
        $('.loginwd_sidebar #register-div-title').hide();
        $('.loginwd_sidebar #login-div-title').show();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but').on('click', function () {
        wpestate_login();
    });

    $('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  WIDGET login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-wd').on('click', function () {
        wpestate_login_wd();
    });

    $('#login_pwd_wd, #login_user_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_wd();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  TOPBAR  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.show_hide_password').on('click', function(){
        var pass_field = jQuery(this).parent().find(':input');
        
      
        
        if (pass_field.attr('type') === "password") {
            pass_field.attr('type','text');
             jQuery(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            pass_field.attr('type','password');
          
            
             jQuery(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
    
    
    

    $('#wp-login-but-topbar').on('click', function () {
        wpestate_login_topbar();
    });

    $('#login_pwd_topbar, #login_user_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_topbar();
        }
    });

    $('#wp-login-but-mobile').on('click', function () {
        wpestate_login_mobile();
    });

    $('#login_pwd_mobile, #login_user_mobile').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_mobile();
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  Ajax update password
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#oldpass, #newpass, #renewpass').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_change_pass_profile();
        }
    });

    $('#change_pass').on('click', function (event) {
        wpestate_change_pass_profile();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ////////  update profile
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#register_agent').on('click', function (event) {
        var firstname = $('#firstname').val();
        var secondname = $('#secondname').val();
        var useremail = $('#useremail').val();
        var userphone = $('#userphone').val();
        var usermobile = $('#usermobile').val();
        var userskype = $('#userskype').val();
        var usertitle = $('#usertitle').val();
        var description = $('#about_me').val();
        var userfacebook = $('#userfacebook').val();
        var usertwitter = $('#usertwitter').val();
        var userlinkedin = $('#userlinkedin').val();
        var userpinterest = $('#userpinterest').val();
        var userinstagram = $('#userinstagram').val();
        var userurl = $('#website').val();
        var agent_username = $('#agent_username').val();
        var agent_password = $('#agent_password').val();
        var agent_repassword = $('#agent_repassword').val();
        var agent_category_submit = $('#agent_category_submit').val();
        var agent_action_submit = $('#agent_action_submit').val();
        var agent_city = $('#agent_city').val();
        var agent_county = $('#agent_county').val();
        var agent_member = $('#agent_member').val();
        var agent_address = $('#agent_address').val();

        var agent_youtube = $('#useryoutube').val();
        var agent_tiktok = $('#usertiktok').val();
        var agent_telegram = $('#usertelegram').val();
        var agent_vimeo = $('#uservimeo').val();
        var agent_private_notes = $('#agent_private_notes').val();

        var agent_area = $('#agent_area').val();
        var is_agent_edit = $('#is_agent_edit').val();
        var user_id = $('#user_id').val();
        var agent_id = $('#agent_id').val();
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var securityprofile = $('#security-profile').val();
        var upload_picture = $('#upload_picture').val();
        var profile_image_url = $('#profile-image').attr('data-profileurl');
        var profile_image_url_small = $('#profile-image').attr('data-smallprofileurl');

        // customparameters
        var agent_custom_label = [];
        $('.single_parameter_row .agent_custom_label').each(function () {
            agent_custom_label.push($(this).val());
        });

        var agent_custom_value = [];
        $('.single_parameter_row .agent_custom_value').each(function () {
            agent_custom_value.push($(this).val());
        });
        var nonce = jQuery('#wpestate_register_agent_nonce').val();

        window.scrollTo(0, 0);

        $('#profile_message').empty().append('<div class="login-alert">' + ajaxcalls_vars.saving + '<div>');


        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action': 'wpestate_ajax_register_agent',
                'agent_username': agent_username,
                'agent_password': agent_password,
                'agent_repassword': agent_repassword,
                'firstname': firstname,
                'secondname': secondname,
                'useremail': useremail,
                'userphone': userphone,
                'usermobile': usermobile,
                'userskype': userskype,
                'usertitle': usertitle,
                'description': description,
                'upload_picture': upload_picture,
                'security-profile': securityprofile,
                'profile_image_url': profile_image_url,
                'profile_image_url_small': profile_image_url_small,
                'userfacebook': userfacebook,
                'usertwitter': usertwitter,
                'userlinkedin': userlinkedin,
                'userpinterest': userpinterest,
                'userinstagram': userinstagram,
                'userurl': userurl,
                'agent_category_submit': agent_category_submit,
                'agent_action_submit': agent_action_submit,
                'agent_city': agent_city,
                'agent_county': agent_county,
                'agent_area': agent_area,
                'agentedit': is_agent_edit,
                'userid': user_id,
                'agentid': agent_id,
                'agent_member': agent_member,
                'agent_address': agent_address,
                'agent_youtube':agent_youtube,
                'agent_tiktok':agent_tiktok,
                'agent_telegram':agent_telegram,
                'agent_vimeo': agent_vimeo,
                'agent_private_notes': agent_private_notes,
                'agent_custom_label': agent_custom_label,
                'agent_custom_value': agent_custom_value,
                'security': nonce

            },
            success: function (data) {
                $('#profile_message').empty().append('<div class="login-alert">' + data.mesaj + '<div>');
                if (data.added) {
                    setTimeout(function () {
                        window.open(ajaxcalls_vars.agent_list, '_self', false);
                    }, 1500);
                }
            },
            error: function (errorThrown) {

            }
        });
    });


    $('#update_profile').on('click', function (event) {

        var firstname, secondname, userurl, usermobile, userinstagram, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        firstname = $('#firstname').val();
        secondname = $('#secondname').val();
        useremail = $('#useremail').val();
        userphone = $('#userphone').val();
        usermobile = $('#usermobile').val();
        userskype = $('#userskype').val();
        usertitle = $('#usertitle').val();
        description = $('#about_me').val();
        userfacebook = $('#userfacebook').val();
        usertwitter = $('#usertwitter').val();
        userlinkedin = $('#userlinkedin').val();
        userpinterest = $('#userpinterest').val();
        userinstagram = $('#userinstagram').val();
        userurl = $('#website').val();
        var hubspot_api = $('#hubspot_api').val();
        var agent_member = $('#agent_member').val();
        var agent_address= $('#agent_address').val();

        var agent_youtube = $('#useryoutube').val();
        var agent_tiktok = $('#usertiktok').val();
        var agent_telegram = $('#usertelegram').val();
        var agent_vimeo = $('#uservimeo').val();
        var agent_private_notes = $('#agent_private_notes').val();

        var agent_category_submit = $('#agent_category_submit').val();
        var agent_action_submit = $('#agent_action_submit').val();
        var agent_city = $('#agent_city').val();
        var agent_county = $('#agent_county').val();
        var agent_area = $('#agent_area').val();
        var nonce = jQuery('#wpestate_update_profile_nonce').val();

        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        securityprofile = $('#security-profile').val();
        upload_picture = $('#upload_picture').val();
        profile_image_url = $('#profile-image').attr('data-profileurl');
        profile_image_url_small = $('#profile-image').attr('data-smallprofileurl');

        // customparameters
        var agent_custom_label = [];
        $('.single_parameter_row .agent_custom_label').each(function () {
            agent_custom_label.push($(this).val());
        });

        var agent_custom_value = [];
        $('.single_parameter_row .agent_custom_value').each(function () {
            agent_custom_value.push($(this).val());
        });



        window.scrollTo(0, 0);
        $('#profile_message').append('<div class="login-alert">' + ajaxcalls_vars.saving + '<div>');
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_ajax_update_profile',
                'firstname': firstname,
                'secondname': secondname,
                'useremail': useremail,
                'userphone': userphone,
                'usermobile': usermobile,
                'userskype': userskype,
                'usertitle': usertitle,
                'description': description,
                'upload_picture': upload_picture,
                'security-profile': securityprofile,
                'profile_image_url': profile_image_url,
                'profile_image_url_small': profile_image_url_small,
                'userfacebook': userfacebook,
                'usertwitter': usertwitter,
                'userlinkedin': userlinkedin,
                'userpinterest': userpinterest,
                'userinstagram': userinstagram,
                'userurl': userurl,
                'agent_category_submit': agent_category_submit,
                'agent_action_submit': agent_action_submit,
                'agent_city': agent_city,
                'agent_county': agent_county,
                'agent_area': agent_area,
                'agent_member': agent_member,
                'agent_address':agent_address,
                'agent_youtube':agent_youtube,
                'agent_tiktok':agent_tiktok,
                'agent_telegram':agent_telegram,
                'agent_vimeo': agent_vimeo,
                'agent_private_notes': agent_private_notes,
                'agent_custom_label': agent_custom_label,
                'agent_custom_value': agent_custom_value,
                'hubspot_api': hubspot_api,
                'security': nonce,

            },
            success: function (data) {

                $('#profile_message').empty().append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0, 0);
            },
            error: function (errorThrown) {
            }
        });
    });



    $('#update_profile_agency').on('click', function () {

        var hubspot_api, agency_opening_hours, agency_license, agency_long, agency_lat, agency_address, agency_area, agency_county, agency_city, agency_action_submit, agency_action_submit, agency_category_submit, agency_taxes, agency_website, agency_languages, agency_name, userurl, usermobile, userinstagram, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        agency_name = $('#agency_title').val();
        useremail = $('#useremail').val();
        userphone = $('#userphone').val();
        usermobile = $('#usermobile').val();
        userskype = $('#userskype').val();

        description = $('#about_me').val();
        userfacebook = $('#userfacebook').val();
        usertwitter = $('#usertwitter').val();
        userlinkedin = $('#userlinkedin').val();
        userpinterest = $('#userpinterest').val();
        userinstagram = $('#userinstagram').val();

        var useryoutube = $('#useryoutube').val();
        var usertiktok = $('#usertiktok').val();
        var usertelegram = $('#usertelegram').val();
        var uservimeo = $('#uservimeo').val();
        var agency_private_notes = $('#agency_private_notes').val();



        agency_languages = $('#agency_languages').val();
        agency_website = $('#agency_website').val();
        agency_taxes = $('#agency_taxes').val();
        agency_license = $('#agency_license').val();


        agency_category_submit = $('#agency_category_submit').val();
        agency_action_submit = $('#agency_action_submit').val();
        agency_city = $('#agency_city').val();
        agency_county = $('#agency_county').val();
        agency_area = $('#agency_area').val();
        agency_address = $('#agency_address').val();
        agency_lat = $('#agency_lat').val();
        agency_long = $('#agency_long').val();
        agency_opening_hours = $('#agency_opening_hours ').val();
        hubspot_api = $('#hubspot_api ').val();
        securityprofile = $('#security-profile').val();
        upload_picture = $('#upload_picture').val();
        profile_image_url = $('#profile-image').attr('data-profileurl');
        profile_image_url_small = $('#profile-image').attr('data-smallprofileurl');


        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';

        var nonce = jQuery('#wpestate_update_profile_nonce').val();
        window.scrollTo(0, 0);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_ajax_update_profile_agency',
                'agency_name': agency_name,
                'useremail': useremail,
                'userphone': userphone,
                'usermobile': usermobile,
                'userskype': userskype,
                'usertitle': usertitle,
                'description': description,
                'upload_picture': upload_picture,
                'security-profile': securityprofile,
                'profile_image_url': profile_image_url,
                'profile_image_url_small': profile_image_url_small,
                'userfacebook': userfacebook,
                'usertwitter': usertwitter,
                'userlinkedin': userlinkedin,
                'userpinterest': userpinterest,
                'userinstagram': userinstagram,
                'useryoutube':useryoutube,
                'usertiktok':usertiktok,
                'usertelegram':usertelegram,
                'uservimeo':uservimeo,
                'agency_private_notes':agency_private_notes,
                'userurl': userurl,
                'agency_languages': agency_languages,
                'agency_website': agency_website,
                'agency_taxes': agency_taxes,
                'agency_license': agency_license,
                'agency_category_submit': agency_category_submit,
                'agency_action_submit': agency_action_submit,
                'agency_city': agency_city,
                'agency_county': agency_county,
                'agency_area': agency_area,
                'agency_address': agency_address,
                'agency_lat': agency_lat,
                'agency_opening_hours': agency_opening_hours,
                'agency_long': agency_long,
                'hubspot_api': hubspot_api,
                'security': nonce
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0, 0);
            },
            error: function (errorThrown) {
            }
        });
    });



//    update developer profile
    $('#update_profile_developer').on('click', function () {

        var hubspot_api, developer_license, developer_long, developer_lat, developer_address, developer_area, developer_county, developer_city, developer_action_submit, developer_action_submit, developer_category_submit, developer_taxes, developer_website, developer_languages, developer_name, userurl, usermobile, userinstagram, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        developer_name = $('#developer_title').val();
        useremail = $('#useremail').val();
        userphone = $('#userphone').val();
        usermobile = $('#usermobile').val();
        userskype = $('#userskype').val();

        description = $('#about_me').val();
        userfacebook = $('#userfacebook').val();
        usertwitter = $('#usertwitter').val();
        userlinkedin = $('#userlinkedin').val();
        userpinterest = $('#userpinterest').val();
        userinstagram = $('#userinstagram').val();


       var useryoutube = $('#useryoutube').val();
       var usertiktok = $('#usertiktok').val();
       var usertelegram = $('#usertelegram').val();
       var  uservimeo = $('#uservimeo').val();
       var  developer_private_notes = $('#developer_private_notes').val();



        developer_languages = $('#developer_languages').val();
        developer_website = $('#developer_website').val();
        developer_taxes = $('#developer_taxes').val();
        developer_license = $('#developer_license').val();


        developer_category_submit = $('#developer_category_submit').val();
        developer_action_submit = $('#developer_action_submit').val();
        developer_city = $('#developer_city').val();
        developer_county = $('#developer_county').val();
        developer_area = $('#developer_area').val();
        developer_address = $('#developer_address').val();
        developer_lat = $('#developer_lat').val();
        developer_long = $('#developer_long').val();
        securityprofile = $('#security-profile').val();
        upload_picture = $('#upload_picture').val();
        profile_image_url = $('#profile-image').attr('data-profileurl');
        profile_image_url_small = $('#profile-image').attr('data-smallprofileurl');
        hubspot_api = $('#hubspot_api').val();

        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var nonce = jQuery('#wpestate_update_profile_nonce').val();
        window.scrollTo(0, 0);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_ajax_update_profile_developer',
                'developer_name': developer_name,
                'useremail': useremail,
                'userphone': userphone,
                'usermobile': usermobile,
                'userskype': userskype,
                'usertitle': usertitle,
                'description': description,
                'upload_picture': upload_picture,
                'security-profile': securityprofile,
                'profile_image_url': profile_image_url,
                'profile_image_url_small': profile_image_url_small,
                'userfacebook': userfacebook,
                'usertwitter': usertwitter,
                'userlinkedin': userlinkedin,
                'userpinterest': userpinterest,
                'userinstagram': userinstagram,
                'userurl': userurl,
                'developer_languages': developer_languages,
                'developer_website': developer_website,
                'developer_taxes': developer_taxes,
                'developer_license': developer_license,
                'developer_category_submit': developer_category_submit,
                'developer_action_submit': developer_action_submit,
                'developer_city': developer_city,
                'developer_county': developer_county,
                'developer_area': developer_area,
                'developer_address': developer_address,
                'developer_lat': developer_lat,
                'developer_long': developer_long,
                'hubspot_api': hubspot_api,
                'useryoutube':useryoutube,
                'usertiktok':usertiktok,
                'usertelegram':usertelegram,
                'uservimeo':uservimeo,
                'developer_private_notes':developer_private_notes,
                'security': nonce
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0, 0);
            },
            error: function (errorThrown) {
            }
        });
    });

    //delete profile

    $('#delete_profile').on('click', function (event) {
        var ajaxurl;
        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var nonce = jQuery('#wpestate_update_profile_nonce').val();
        var result = confirm(ajaxcalls_vars.delete_account);
        if (result) {
            //Logic to delete the item

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'wpestate_delete_profile',
                    'security': nonce,
                },
                success: function (data) {
                    window.location = '/';
                },
                error: function (errorThrown) {

                }
            });
        }
    });

    //end delete profile

}); // end ready jquery
//End ready ********************************************************************


function wpestate_add_to_favorites() {


    jQuery('#add_favorites').on('click', function (event) {

        var post_id, ajaxurl;
        post_id = jQuery('#add_favorites').attr('data-postid');
        var icon = jQuery('#add_favorites');
        ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var nonce = jQuery('#wpestate_ajax_filtering').val();
        var use_favorite_login  =   ajaxcalls_vars.favorites_login;
        if(use_favorite_login=="no"){
            wpestate_add_remove_favorite_local_storage_single(icon,post_id);
            return;
        }



        if (parseInt(ajaxcalls_vars.userid, 10) === 0) {
            if (!Modernizr.mq('only all and (max-width: 768px)')) {
                jQuery('#modal_login_wrapper').show();
                 jQuery('#modal_login_wrapper').find('[autofocus]').focus();
                jQuery('#loginpop').val('1');
            } else {
                jQuery('.mobile-trigger-user').trigger('click');
            }

        } else {
            jQuery('#add_favorites').text(ajaxcalls_vars.saving);
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action': 'wpestate_ajax_add_fav',
                    'post_id': post_id,
                    'security': nonce
                },
                success: function (data) {
                    if (data.added) {
                        jQuery('#add_favorites').removeClass('isnotfavorite').addClass('isfavorite').attr('data-original-title', ajaxcalls_vars.remove_favorite);
                        jQuery('#add_favorites').html('<i class="fas fa-heart"></i>' + ajaxcalls_vars.favorite);
                    } else {
                        jQuery('#add_favorites').removeClass('isfavorite').addClass('isnotfavorite').attr('data-original-title', ajaxcalls_vars.add_favorite);
                        jQuery('#add_favorites').html('<i class="far fa-heart"></i>' + ajaxcalls_vars.favorite);
                    }
                },
                error: function (errorThrown) {
                }
            }); //end ajax
        }// end check login
    });
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// Property page  + ajax call on contact
///////////////////////////////////////////////////////////////////////////////////////////
function wpestate_theme_slider_show_contact() {
    jQuery('.wpestate_theme_slider_contact_agent').on('click', function () {
        var acesta = jQuery(this).parent().parent();
        acesta.find('#show_contact').text(ajaxcalls_vars.contact_agent);
        acesta.find('.theme_slider_contact_form_wrapper').show('0').toggleClass('theme_slider_contact_form_wrapper_visible');
        jQuery('#estate-carousel').carousel('pause');
      
    });



    jQuery('.theme_slider_details_modal_close').on('click', function () {
        jQuery(this).parent().removeClass('theme_slider_contact_form_wrapper_visible');
                jQuery('#estate-carousel').carousel('cycle');
    });

    jQuery('.theme_slider_contact_form_wrapper').on('click', function (event) {
        event.stopPropagation();
    });


}




function  wpestate_enable_schedule_contact() {

    jQuery('.schedule_meeting').on('click', function (event) {

        var parent = jQuery(this).parent(); var schedule_wrapper= parent.find('.schedule_wrapper');
        parent.find('.schedule_wrapper').slideToggle(400,function(){
                 
        if(schedule_wrapper.is(":visible")){
            schedule_wrapper.css('display', 'flex');
        }else{
           schedule_wrapper.css('display','none'); 
        }
        });
    

    
    });

    jQuery(".schedule_day,#schedule_day").datepicker({
        dateFormat: "yy-mm-dd",
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');
}


function wpestate_agent_submit_email() {
    jQuery('.wpresidence_elementor_form').on('submit', function (event) {
        event.preventDefault();
        var form_submit = jQuery('.wpresidence_elementor_form').find('.agent_submit_class_elementor');
        process_form_submit(form_submit);
    });

    jQuery('.agent_submit_class').on('click', function (event) {
        process_form_submit(jQuery(this));
    });
    
    jQuery('.message_submit').on('click', function (event) {
        process_form_submit(jQuery(this));
    });
}


function process_form_submit(form_submit) {

    var parent, contact_name, contact_email, contact_phone, contact_coment, agent_id, property_id, nonce, ajaxurl;
    parent          = form_submit.parent();
    var is_private_message='no';
    if(form_submit.hasClass('message_submit')){
        is_private_message='yes';
    }
    

    contact_name    = parent.find('#agent_contact_name').val();
    contact_email   = parent.find('#agent_user_email').val();
    contact_phone   = parent.find('#agent_phone').val();
    contact_coment  = parent.find('#agent_comment').val();
    agent_id        = parent.find('#agent_id').val();
    property_id     = parent.find('#agent_property_id').val();
    
    nonce   = parent.find('#agent_property_ajax_nonce').val();
    ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
    
    var schedule_day = parent.find('.schedule_day').val();
    var schedule_hour = parent.find('.schedule_hour').val();
    var schedule_mode ='in_person';



    if( parent.hasClass('wpestate_schedule_tour_wrapper_content') || 
        parent.hasClass('wpestate_shedule_tour_wrapper_type2_content') ||
        parent.hasClass('wpestate_schedule_tour_wrapper') ){

        schedule_day    =   parent.find('.shedule_day_option_selected').attr('data-scheudle-day');
        schedule_hour   =   parent.find('#wpestate_schedule_tour_time').val();

        var schedule_mode_button   =   parent.find('.shedule_option_selected');
        if( schedule_mode_button.hasClass('schedule_video_chat') ){
            schedule_mode ='video_chat';
        }       
    }


    var is_elementor = 0;
    if (form_submit.parents('.wpresidence_elementor_form').length) {
        parent                  =   form_submit.parents('.wpresidence_elementor_form');
        contact_name            =   parent.find('#form-field-name').val();
        contact_email           =   parent.find('#form-field-email').val();
        contact_coment          =   parent.find('#form-field-message').val();
        contact_phone           =   parent.find('input[name="phone"]').val();
        nonce                   =   parent.find('#agent_property_ajax_nonce').val();
        is_elementor            =   parent.find('#contact_form_elementor').val();
        var wpresidence_form_id =   parent.find('#wpresidence_form_id').val();
        var elementor_email_subject = parent.find('#elementor_email_subject').val();

        var temp_details;
        temp_details        = '';
        var elementor_form  = form_submit.parents('.wpresidence_elementor_form');
        var form_items      = elementor_form.find('.elementor-field');
        var label_name      ='';
        var labelElement;
        form_items.each(function () {

            labelElement=jQuery(this).parent().find('.elementor-field-label');
            
            if (labelElement.length > 0) {
                label_name = labelElement.text();
                label_name = label_name.replace('*', '');
            } else {
                label_name = jQuery(this).attr('name')
            }
  
            temp_details = temp_details + label_name + ": " + jQuery(this).val() + "/n";
        });

        contact_coment = temp_details ;

    }

    if (parent.find('.wpestate_agree_gdpr').length > 0) {
        if (!parent.find('.wpestate_agree_gdpr').is(':checked')) {
            parent.find('#alert-agent-contact').empty().append(ajaxcalls_vars.gdpr_terms);
            return;
        }
    }



    parent.find('#alert-agent-contact').empty().append(ajaxcalls_vars.sending);

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_agent_contact_form',
            'name': contact_name,
            'email': contact_email,
            'phone': contact_phone,
            'comment': contact_coment,
            'agent_id': agent_id,
            'propid': property_id,
            'schedule_day': schedule_day,
            'schedule_hour': schedule_hour,
            'schedule_mode':schedule_mode,
            'elementor_wpresidence_form_id': wpresidence_form_id,
            'elementor_email_subject': elementor_email_subject,
            'is_elementor': is_elementor,
            'is_private_message':is_private_message,
            'nonce': nonce
        },
        success: function (data) {

            if (data.sent) {
                parent.find('#agent_contact_name').val('');
                parent.find('#agent_user_email').val('');
                parent.find('#agent_phone').val('');
                parent.find('#agent_comment').val('');
                parent.find('.schedule_day').val('');
                parent.find('#schedule_hour').val('');
                parent.find('#alert-agent-contact').addClass(' wpestate-agent-contact-sent ').empty().append(data.response);


                if (typeof (form_items) !== 'undefined') {
                    form_items.each(function () {
                        jQuery(this).val('');
                    });
                }

            } else {
                parent.find('#alert-agent-contact').empty().append(data.response);
            }

        },
        error: function (errorThrown) {

        }
    });



    jQuery.ajax({
        type: 'POST',
        //  dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'wpestate_ajax_agent_contact_form_forcrm',
            'name': contact_name,
            'email': contact_email,
            'phone': contact_phone,
            'comment': contact_coment,
            'agent_id': agent_id,
            'propid': property_id,
            'schedule_day': schedule_day,
            'schedule_hour': schedule_hour,
            'schedule_mode':schedule_mode,
            'nonce': nonce
        },
        success: function (data) {
        },
        error: function (errorThrown) {

        }
    });


}


///////////////////////////////////////////////////////////////////////////////////////////
/////// Property page  + ajax call on contact
///////////////////////////////////////////////////////////////////////////////////////////


function wpestate_enable_share_unit(){
   
    jQuery('.share_list').unbind('click');
    jQuery('.share_list').on( 'click', function(event) {
        event.stopPropagation();   
        var sharediv=jQuery(this).parent().find('.share_unit');
        sharediv.toggle();
        jQuery(this).toggleClass('share_on');
    });
    
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }


function wpestate_enable_not_logged_favorites(){
   
    var use_favorite_login  =   ajaxcalls_vars.favorites_login;

    if(use_favorite_login=="yes"){
        return;
    }

    var current_favorites = window.localStorage.getItem('wpestate_favorites');
    setCookie('wpestate_favorites',current_favorites,10);
    var prop_ids='';

    if( current_favorites!==null ){
        prop_ids = jQuery.map(current_favorites.split(','), function(value){
            return parseInt(value);
        });
    }
  
    jQuery('.icon-fav').each(function(){
        var icon=jQuery(this);
        var property_id=icon.attr('data-postid');
        property_id=parseInt(property_id);
        var index = prop_ids.indexOf( property_id );    

        if (index > -1) {
            icon.removeClass('icon-fav-off').addClass('icon-fav-on');
            icon.attr('data-original-title', ajaxcalls_vars.remove_fav);
    
        }else{
            icon.removeClass('icon-fav-on').addClass('icon-fav-off');
            icon.attr('data-original-title', ajaxcalls_vars.add_favorite);
    
        }
    })
    

    if(jQuery('#add_favorites').length>0){
        var property_id=jQuery('#add_favorites').attr('data-postid');
        property_id=parseInt(property_id);
        var index = prop_ids.indexOf( property_id );    
       
        if (index > -1) {
            jQuery('#add_favorites').removeClass('isnotfavorite').addClass('isfavorite').attr('data-original-title', ajaxcalls_vars.remove_favorite);
            jQuery('#add_favorites').html('<i class="fas fa-heart"></i>' + ajaxcalls_vars.favorite);
    
        }  
    }
    
}

function wpestate_loade_agent_listings(){
    
    jQuery('.agent_listing .term_bar_item').on('click', function (event) {

        // display load more
        var listing_parent_pointer = jQuery(this).parents('.single_listing_block');
        jQuery('.load_more_ajax_cont .listing_load_more', listing_parent_pointer).fadeIn();
        jQuery('.term_bar_item').removeClass('active_term');
        jQuery(this).addClass('active_term');
        var ajaxurl     = ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name   = jQuery(this).attr('data-term_name');
        var agent_id    = jQuery('.term_bar_wrapper').attr('data-agent_id');
        var post_id     = jQuery('.term_bar_wrapper').attr('data-post_id');
        var nonce       = jQuery('#wpestate_agent_listings_nonce').val();
        jQuery('.agency_listings_wrapper').empty();
        jQuery('#listing_loader', listing_parent_pointer).show();

        var wpestate_no_listins_per_row=3;
        if( jQuery('.wpestate_single_agent_details_wrapper_type2').length>0 ){
            wpestate_no_listins_per_row=4;
        }


        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'wpestate_agent_listings',
                'term_name': term_name,
                'agent_id': agent_id,
                'post_id': post_id,
                'wpestate_no_listins_per_row':wpestate_no_listins_per_row,
                'security': nonce,
            },
            success: function (data) {

                jQuery('#listing_loader', listing_parent_pointer).hide();
                jQuery('.agency_listings_wrapper').append(data);
                wpestate_restart_js_after_ajax();


            },
            error: function (errorThrown) {
            }
        });



    });


}