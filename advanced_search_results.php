<?php
// Template Name: Advanced Search Results
// Wp Estate Pack

if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}

if (    ! isset( $_GET['wpestate_regular_search_nonce'] )  || ! wp_verify_nonce( $_GET['wpestate_regular_search_nonce'], 'wpestate_regular_search' ) ) {
}

global $wpestate_keyword;
global $wpestate_included_ids;
wp_cache_flush();
get_header();
$current_user       =   wp_get_current_user();
$wpestate_options   =   wpestate_page_details($post->ID);
$show_compare       =   1;
$area_array         =   '';
$city_array         =   '';
$action_array       =   '';
$categ_array        =   '';
$id_array           =   '';
$countystate_array  =   '';

$compare_submit         =   wpestate_get_template_link('compare_listings.php');
$wpestate_currency      =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$prop_no                =   intval ( wpresidence_get_option('wp_estate_prop_no', '') );
$show_compare_link      =   'yes';
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.intval($userID);
$curent_fav             =   get_option($user_option);
$custom_advanced_search =   wpresidence_get_option('wp_estate_custom_advanced_search','');
$meta_query             =   array();
$adv_search_what        =   '';
$adv_search_how         =   '';
$adv_search_label       =   '';
$adv_search_type        =   '';
$adv_search_type        =   wpresidence_get_option('wp_estate_adv_search_type','');

$wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_unit_class    =   '';
$align_class        =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$adv_search_what    =   wpresidence_get_option('wp_estate_adv_search_what','');
$adv_search_how     =   wpresidence_get_option('wp_estate_adv_search_how','');
$adv_search_label   =   wpresidence_get_option('wp_estate_adv_search_label','');
$adv_search_type    =   wpresidence_get_option('wp_estate_adv_search_type','');

if(isset($_GET['elementor_form_id']) && intval($_GET['elementor_form_id'])!=0 ){
        $elementor_post_id              =   intval($_GET['elementor_form_id']);
        $elementor_search_name_how      =   "elementor_search_how_" . $elementor_post_id;
        $elementor_search_name_what     =   "elementor_search_what_" . $elementor_post_id;
        $elementor_search_name_label    =   "elementor_search_label_" . $elementor_post_id;
            
        $adv_search_what    =   get_option($elementor_search_name_what,true);
        $adv_search_how     =   get_option($elementor_search_name_how,true);
        $adv_search_label   =   get_option($elementor_search_name_label,true);
        
        if(isset($_GET['term_id']) && intval($_GET['term_id'])!=0 && isset($adv_search_what['use_tabs'])){
            $term_id_elementor  =   intval($_GET['term_id']);
            $adv_search_what    =   $adv_search_what[$term_id_elementor];
            $adv_search_how     =   $adv_search_how[$term_id_elementor];
            $adv_search_label   =   $adv_search_label[$term_id_elementor];
        }

}else{

    if(isset($_GET['term_counter'])){
        $adv_search_fields_no       =   floatval( wpresidence_get_option('wp_estate_adv_search_fields_no') );
        $term_counter               =   intval($_GET['term_counter']);

        $adv_search_what    =   array_slice($adv_search_what, ( $term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_how     =   array_slice($adv_search_how,    ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_label   =   array_slice($adv_search_label,  ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
    }

}


if( !isset($_GET['is2']) ){
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type1 or type 3
    //////////////////////////////////////////////////////////////////////////////////////
    if( $custom_advanced_search==='yes' ){
        $args = $mapargs    =   wpestate_search_results_custom ('search');

        $return_custom      =   wpestate_search_with_keyword($adv_search_what, $adv_search_label);
 
        if(isset($return_custom['keyword'])){
            $wpestate_keyword        =   $return_custom['keyword'];
        }

        if(isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array'];
        }

    }else{
        $args = $mapargs = wpestate_search_results_default ('search');
    }

}else{
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type 2 city.area,state
    //////////////////////////////////////////////////////////////////////////////////////

    $args                 = wpestated_advanced_search_tip2();
    $meta_query           = array();
    $features             = array();
    $features = wpestate_add_feature_to_search();
    if(!empty($features)){
      $args['tax_query'][]=$features;
    }

    $mapargs = array(
        'post_type'         =>  'estate_property',
        'post_status'       =>  'publish',
        'nopaging'          =>  'true',
        'cache_results'     =>  false,
        'paged'             =>  $paged,
        'posts_per_page'    =>  30,
    );
    $mapargs=$args;
}


if( isset($_GET['geolocation_lat'])     && $_GET['geolocation_lat']!='' && 
    isset($_GET['geolocation_long'])    && $_GET['geolocation_long']!='' 
   ){

    $geo_lat    = sanitize_text_field ( $_GET['geolocation_lat'] );
    $geo_long   = sanitize_text_field ( $_GET['geolocation_long'] );
    
    if(isset($_GET['geolocation_radius']) && $_GET['geolocation_radius']!=''){
        $geo_rad    =   sanitize_text_field ( $_GET['geolocation_radius'] );
    }else{
        $geo_rad    =   wpresidence_get_option('wp_estate_initial_radius','');
    }
    
    

    $args  =$mapargs     = wpestate_geo_search_filter_function($args, $geo_lat, $geo_long, $geo_rad);
}







if( ( isset($_GET['is10']) && intval($_GET['is10'])==10)  ){
    $args    =   wpestated_advanced_search_tip10($args);
    $mapargs =   $args;
}

if( isset($_GET['is11']) && intval($_GET['is11']) == 11 ){
    $allowed_html       =   array();
    $wpestate_keyword   =   esc_attr(  wp_kses ( $_GET['keyword_search'], $allowed_html));
    $args               =   wpestated_advanced_search_tip11($args);
    $mapargs            =   $args;
}


////////////////////////////////////////////////////////////////////////////////////////////
// order by on searhc pagination
////////////////////////////////////////////////////////////////////////////////////////////
$order = intval(wpresidence_get_option('wp_estate_property_list_type_adv_order',''));
if( isset($_GET['order_search']) && is_numeric($_GET['order_search'] ) ){
  $order= intval($_GET['order_search']);
}

$order_array    =   wpestate_create_query_order_by_array($order);
$args           =   array_merge($args,$order_array['order_array']);





////////////////////////////////////////////////////////////////////////////////////////////
// END order by on searhc pagination
////////////////////////////////////////////////////////////////////////////////////////////
$args['posts_per_page'] =   intval(wpresidence_get_option('wp_estate_prop_no_adv_search',''));


// remove sold listings
$args=wpestate_remove_sold_listings($args);






if( !empty($id_array)){
    $args=  array(  'post_type'     => 'estate_property',
                'p'           =>    $id_array
            );
    $prop_selection =   new WP_Query( $args);

}else{


    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');
    if(  $order==0 ){
        add_filter( 'posts_orderby', 'wpestate_my_order' );
    }
    if( !empty($wpestate_keyword) ){
        add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }

    $prop_selection =   new WP_Query($args);

    if(  $order==0){
        if(function_exists('wpestate_disable_filtering')){
            wpestate_disable_filtering( 'posts_orderby', 'wpestate_my_order' );
        }
    }

    if( !empty($wpestate_keyword) ){
        if(function_exists('wpestate_disable_filtering')){
            wpestate_disable_filtering( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
    }
}



$num                        =   $prop_selection->found_posts;
$property_list_type_status  =   esc_html(wpresidence_get_option('wp_estate_property_list_type_adv',''));
$half_map_results           =   0;



if ( $property_list_type_status == 2 ){
    include(locate_template('templates/half_map_core.php'));
    $half_map_results=1;
}else{
    include(locate_template('templates/normal_map_core.php'));
}

if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   intval(wpresidence_get_option('wp_estate_prop_no_adv_search',''));
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    $mapargs['fields']          =   'ids';
    $selected_pins              =   wpestate_listing_pins('blank',0,$mapargs,1,$wpestate_keyword,$id_array);//call the new pins

    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2',
        array(
            'markers2'           => $selected_pins,
            'half_map_results'   => $half_map_results
        )
    );


}
get_footer(); ?>