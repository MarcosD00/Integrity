<?php

/*
 *
 * Display ooverview ittem
 * 
 *
 */

if (!function_exists('wpestate_display_overview_item')):
function wpestate_display_overview_item($itemKey,$value){
    
    $overview_details = array(


        'bedrooms'    =>array(
                        'label' => esc_html__('Bedrooms','wpresidence'),
                        'icon'=>'templates/svg_icons/single_bedrooms.html'
                        ),
        'bathrooms'    =>array(
                        'label' => esc_html__('Bathrooms','wpresidence'),
                         'icon'=>'templates/svg_icons/single_bath.html'
                        ),
        'rooms'    =>array(
                        'label' => esc_html__('Rooms','wpresidence'),
                        'icon'=>'templates/svg_icons/single_rooms_overview.html'
        ),
        'garages'=>array(
                        'label' => esc_html__('Garages','wpresidence'),
                        'icon'=>'templates/svg_icons/single_garage.html'
        ),
        'size'       =>array(
                        'label' => '',
                        'label2' => esc_html__('Property Size','wpresidence'),
                        'icon'=>'templates/svg_icons/single_floor_plan.html'
                        ),
        'lot_size'    =>array(
                        'label' => '',
                        'label2' => esc_html__('Property Lot Size','wpresidence'),
                        'icon'=>'templates/svg_icons/single_lot_size.html'
        ),
        'year_built' =>array(
                        'label' => esc_html__('Year Built:','wpresidence'),
                        'icon'=>'templates/svg_icons/single_calendar.html',
                        'reverse'=>'yes'
                    ),
        'property_category'=>array(
                        'label' => esc_html__('Category','wpresidence'),
                        'icon'=>'',
                        'class1'=>"first_overview_left",
                        'class2'=>'first_overview_date'
                       
                    ),
        'property_id'=>array(
                        'label' => esc_html__('Property ID','wpresidence'),
                        'icon'=>'',
                        'class1'=>"first_overview_left",
                        'class2'=>'first_overview_date'
                    ),
    
       

    );

    $designType=wpresidence_get_option('wp_estate_overview_elements_design');

    $return_string='';
    if( isset($overview_details[$itemKey]) ){

        $class1 =    $overview_details[$itemKey]['class1'] ?? '';
        $class2 =    $overview_details[$itemKey]['class2'] ?? '';
        $icon   =   '';
        if(isset($overview_details[$itemKey]['icon']) && '' !== $overview_details[$itemKey]['icon']){
            ob_start();
            include ( locate_template($overview_details[$itemKey]['icon'])   );
            $icon = ob_get_contents();
            ob_end_clean();
        }
       
        $label = $overview_details[$itemKey]['label']??'';
        $label2 = $overview_details[$itemKey]['label2']??'';



        switch ($designType) {

            case 'type1':
                $return_string.='  <ul class="overview_element">';
                        $return_string.='<li class="first_overview '.esc_attr($class1).'">';
                        
                            if($icon!==''){
                                $return_string.=$icon;
                            }

                            if('property_category' === $itemKey  || 'property_id'=== $itemKey ){
                                $return_string.=$overview_details[$itemKey]['label'];
                            }

                        $return_string.='</li>';

                        $return_string.='<li class="'.esc_attr($class2).'">';
                        if(!isset($overview_details[$itemKey]['reverse']) ){
                            $return_string.= $value;
                        }
                        if(isset($overview_details[$itemKey]['label']) && '' !== $overview_details[$itemKey]['label'] && 'property_category'!== $itemKey  && 'property_id'!== $itemKey ){
                            $return_string.= ' '.$label;
                        }   
                        if(isset($overview_details[$itemKey]['reverse']) && 'yes' === $overview_details[$itemKey]['reverse'] ){
                            $return_string.= $value;
                        }
                        
                        $return_string.='</li>';
                $return_string.='</ul>';
                break;
            case 'type2':
                $return_string.='  <ul class="overview_element overview_element_type2">';
                        $return_string.='<li class="first_overview '.esc_attr($class1).'">';
                        
                            if($label!==''){
                                $return_string.=$label;
                            }

                            if($label2!==''){
                                $return_string.=$label2;
                            }
                            
                        $return_string.='</li>';

                        $return_string.='<li class=" first_overview_date '.esc_attr($class2).'">';
                       
                        if($icon!==''){
                        $return_string.=$icon;
                        }
                        $return_string.=$value;

                        
                        $return_string.='</li>';
                $return_string.='</ul>';
                break;
            case 'type3':
                $return_string.='  <ul class="overview_element overview_element_type3">';
                        $return_string.='<li class="first_overview '.esc_attr($class1).'">';
                            if($icon!==''){
                                $return_string.=$icon;
                            }
                            $return_string.=$value;

                           
                            
                        $return_string.='</li>';

                        $return_string.='<li class=" first_overview_date '.esc_attr($class2).'">';
                       
                        if($label!==''){
                            $return_string.=$label;
                        }

                        if($label2!==''){
                            $return_string.=$label2;
                        }

                        
                        $return_string.='</li>';
                $return_string.='</ul>';
                break;
                case 'type4':
                    $return_string.='  <ul class="overview_element overview_element_type3">';
                            $return_string.='<li class="first_overview '.esc_attr($class1).'">';
                              
                                $return_string.=$value;
    
                               
                                
                            $return_string.='</li>';
    
                            $return_string.='<li class=" first_overview_date '.esc_attr($class2).'">';
                           
                            if($label!==''){
                                $return_string.=$label;
                            }
    
                            if($label2!==''){
                                $return_string.=$label2;
                            }
    
                            
                            $return_string.='</li>';
                    $return_string.='</ul>';
                    break;
            }   
    }

  return $return_string;
               

}
endif;










/*
 * Social links
 *
 *
 * 
 *
 */


 if (!function_exists('wpestate_return_social_links_icons')):

    function wpestate_return_social_links_icons() {
        
        $defaults = array( 
            'facebook'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_facebook_link',
                                    'icon'              =>  '<i class="fab fa-facebook-f"></i>'
                                ),

            'whatsup'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_whatsapp_link',
                                    'icon'              =>  '<i class="fab fa-whatsapp"></i>'
                                ),      
                                
            'telegram'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_telegram_link',
                                    'icon'              =>  '<i class="fab fa-telegram-plane"></i>'
                                ),

            'tiktok'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_tiktok_link',
                                    'icon'              =>  '<i class="fab fa-tiktok"></i>'
                                ),                          

            'rss'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  '',
                                    'icon'              =>  '<i class="fas fa-rss fa-fw"></i>'
                                ),      
                                
            'twitter'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_twitter_link',
                                    'icon'              =>  '<i class="fa-brands fa-x-twitter"></i>'
                                ),

            'dribbble'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_dribbble_link',
                                    'icon'              =>  '<i class="fab fa-dribbble  fa-fw"></i>'
                                ),                          

            'google'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_google_link',
                                    'icon'              =>  '<i class="fab fa-google"></i>'
                                ),      
                                
            'linkedIn'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_linkedin_link',
                                    'icon'              =>  '<i class="fab fa-linkedin-in"></i>'
                                ),

            'tumblr'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  '',
                                    'icon'              =>  '<i class="fab fa-tumblr  fa-fw"></i>'
                                ),                          

            'pinterest'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_pinterest_link',
                                    'icon'              =>  '<i class="fab fa-pinterest-p  fa-fw"></i>'
                                ),      
                                
            'youtube'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_youtube_link',
                                    'icon'              =>  '<i class="fab fa-youtube  fa-fw"></i>'
                                ),

            'vimeo'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_vimeo_link',
                                    'icon'              =>  '<fab fa-vimeo-v  fa-fw"></i>'
                                ),        
            'instagram'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_instagram_link',
                                    'icon'              =>  '<i class="fab fa-instagram  fa-fw"></i>'
                                ),      
                                
            'foursquare'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_foursquare_link',
                                    'icon'              =>  '<i class="fab  fa-foursquare  fa-fw"></i>'
                                ),

            'line'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_line_link',
                                    'icon'              =>  '<i class="fab fa-line"></i>'
                                ),        
  
      
            'wechat'      =>  array(
                                    'developer_option'  =>  '',
                                    'agency_option'     =>  '',
                                    'agent_option'      =>  '',
                                    'contact_option'    =>  'wp_estate_wechat_link',
                                    'icon'              =>  '<i class="fab fa-weixin"></i>'
                                ),   


     
           
        );
        
        return $defaults;
    }
endif;

/*
 * check if map marker should be hidden
 *
 *
 *
 *
 */

if (!function_exists('wpestate_check_show_map_marker')):

    function wpestate_check_show_map_marker() {
    
        global $post;
        $property_hide_map_marker='';
        if( isset($post->ID) ){
            $property_hide_map_marker=  ( get_post_meta($post->ID, 'property_hide_map_marker',  true));
        }
        
        if($property_hide_map_marker==1){
            return false;
        }else if( wpresidence_get_option('wp_estate_hide_marker_pin')=='yes'){
            if(!is_singular('estate_property')){
                return true;
            }else{
                return false;
            }
        }
        return true;


    }

endif;

/*
 * return favoriters
 *
 *
 *
 *
 */
if (!function_exists('wpestate_return_favorite_listings_per_user')):

    function wpestate_return_favorite_listings_per_user() {
        $curent_fav='';
        if(wpresidence_get_option('wp_estate_favorites_login')=='yes'){
            $current_user = wp_get_current_user();
            $userID = $current_user->ID;
            $user_option = 'favorites' . $userID;
            $curent_fav = get_option($user_option);
        }else{
            if(isset($_COOKIE['wpestate_favorites'] )){
                $curent_fav_text = sanitize_text_field( $_COOKIE['wpestate_favorites'] );
                $curent_fav=explode(',',$curent_fav_text);
            }
        }

        $curent_fav_return='';
        if(is_array($curent_fav)){
            $curent_fav_return = array_filter( $curent_fav, "wpestate_favorites_array_filter" )  ;
        }


        return $curent_fav_return;

    }

endif;


function wpestate_favorites_array_filter($value){
    if(!is_null($value) && $value !== ''){
        return $value;
    }
}




/*
 * return agent list
 *
 *
 *
 *
 */
if (!function_exists('wpestate_return_agent_list')):

    function wpestate_return_agent_list() {
        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $agent_list = (array) get_user_meta($userID, 'current_agent_list', true);
        $agent_list[] = $userID;
        $agent_list = array_filter($agent_list);
        return $agent_list;
    }

endif;


/*
 * return status data for wp_query properties
 *
 *
 *
 *
 */
if (!function_exists('wpestate_set_status_parameter_property')):

    function wpestate_set_status_parameter_property($status) {
        $status = intval($status);
        $return_status = array('any');

        switch ($status) {
            case 0:
                $return_status = array('any');
                break;
            case 1:
                $return_status = array('publish');
                break;
            case 2:
                $return_status = array('disabled');
                break;
            case 3:
                $return_status = array('expired');
                break;
            case 4:
                $return_status = array('draft');
                break;
            case 5:
                $return_status = array('pending');
                break;
        }

        return $return_status;
    }

endif;






/*
 * return orderby data for wp query properties
 *
 *
 *
 *
 */

if (!function_exists('wpestate_set_order_parameter_property')):

    function wpestate_set_order_parameter_property($order) {
        $order = intval($order);
        $return = array();
        $meta_order = 'prop_featured';
        $meta_directions = 'DESC';
        $order_by = 'meta_value';

        switch ($order) {
            case 0:
                $meta_order = 'prop_featured';
                $meta_directions = 'DESC';
                $order_by = 'meta_value';
                break;
            case 1:
                $meta_order = 'property_price';
                $meta_directions = 'DESC';
                $order_by = 'meta_value_num';
                break;
            case 2:
                $meta_order = 'property_price';
                $meta_directions = 'ASC';
                $order_by = 'meta_value_num';
                break;
            case 3:
                $meta_order = '';
                $meta_directions = 'DESC';
                $order_by = 'ID';
                break;
            case 4:
                $meta_order = '';
                $meta_directions = 'ASC';
                $order_by = 'ID';
                break;
            case 5:
                $meta_order = 'property_bedrooms';
                $meta_directions = 'DESC';
                $order_by = 'meta_value_num';
                break;
            case 6:
                $meta_order = 'property_bedrooms';
                $meta_directions = 'ASC';
                $order_by = 'meta_value_num';
                break;
            case 7:
                $meta_order = 'property_bathrooms';
                $meta_directions = 'DESC';
                $order_by = 'meta_value_num';
                break;
            case 8:
                $meta_order = 'property_bathrooms';
                $meta_directions = 'ASC';
                $order_by = 'meta_value_num';
                break;
        }


        $return ['meta_key'] = $meta_order;
        $return ['orderby'] = $order_by;
        $return ['order'] = $meta_directions;

        return $return;
    }

endif;

/*
 * return custom ajax handler
 *
 *
 *
 *
 */


if (!function_exists('wpestate_return_ajax_handler')):

    function wpestate_return_ajax_handler() {

        if (get_option('wp_estate_use_custom_ajaxhandler') == 'no') {
            //$handler = get_admin_url().'admin-ajax.php';
            $handler = 'wp_ajax';
        } else {
            $handler = 'wpestate_ajax_handler';
        }

        return $handler;
    }

endif;







if (!function_exists('wpestate_filter_for_location_ajax')):

    function wpestate_filter_for_location_ajax($args, $adv_location10) {
        $args['tax_query'] = (array) wpestate_clear_tax($args['tax_query']);
        $allowed_html = array();
        $action_array = array();
        $location_array = array();

        if (isset($adv_location10) && $adv_location10 != '') {

            $value = stripslashes(sanitize_text_field($adv_location10));
            $location_array = array(
                'key' => 'hidden_address',
                'value' => $value,
                'compare' => 'LIKE',
                'type' => 'char',
            );
        }




        if (!empty($action_array)) {
            if (!is_array($args['tax_query'])) {
                $args['tax_query'] = array();
            }

            $args['tax_query'][] = $action_array;
        }

        if (!empty($location_array)) {
            if (!is_array($args['meta_query'])) {
                $args['meta_query'] = array();
            }

            $args['meta_query'][] = $location_array;
        }



        return ($args);
    }

endif;




if (!function_exists('wpestate_filter_for_location')):

    function wpestate_filter_for_location($args) {
        $args['tax_query'] = wpestate_clear_tax($args['tax_query']);
        $allowed_html = array();
        $action_array = array();
        $location_array = array();


        if (isset($_GET['adv_location']) && $_GET['adv_location'] != '') {

            $value = stripslashes(sanitize_text_field($_GET['adv_location']));
            $location_array = array(
                'key' => 'hidden_address',
                'value' => $value,
                'compare' => 'LIKE',
                'type' => 'char',
            );
        }




        if (!empty($action_array)) {
            if (gettype($args['tax_query']) == 'string') {
                $args['tax_query'] = array();
            }
            $args['tax_query'][] = $action_array;
        }

        if (!empty($location_array)) {

            if (gettype($args['meta_query']) == 'string') {
                $args['meta_query'] = array();
            }
            $args['meta_query'][] = $location_array;
        }




        return $args;
    }

endif;




if (!function_exists('wpestate_topbar_classes')):

    function wpestate_topbar_classes() {
        global $post;

        $topbar_class = 'topbar_show_mobile_' . wpresidence_get_option('wp_estate_show_top_bar_user_menu_mobile', '');


        if( wpresidence_get_option('wp_estate_mobile_sticky_header') == 'yes'){
            $topbar_class = 'topbar_show_mobile_no';
        }


        $topbar_transparent_page_global = wpresidence_get_option('wp_estate_topbar_transparent', '');
        if (isset($post->ID) && !is_tax() && !is_category()) {
            $topbar_transparent_page = get_post_meta($post->ID, 'topbar_transparent', true);
            if ($topbar_transparent_page == "global" || $topbar_transparent_page == "") {
                if ($topbar_transparent_page_global == 'yes') {
                    $topbar_class .= ' transparent_topbar ';
                }
            } else if ($topbar_transparent_page == "yes") {
                $topbar_class .= ' transparent_topbar ';
            }
        } else {
            if ($topbar_transparent_page_global == 'yes') {
                $topbar_class .= ' transparent_topbar ';
            }
        }




        $topbar_border_global = wpresidence_get_option('wp_estate_topbar_border', '');
        if (isset($post->ID) && !is_tax() && !is_category()) {
            $topbar_border_page = get_post_meta($post->ID, 'topbar_border_transparent', true);
            if ($topbar_border_page == "global" || $topbar_border_page == "") {
                if ($topbar_border_global == 'yes') {
                    $topbar_class .= ' transparent_border_topbar ';
                }
            } else if ($topbar_border_page == "yes") {
                $topbar_class .= ' transparent_border_topbar ';
            }
        } else {
            if ($topbar_border_global == 'yes') {
                $topbar_class .= ' transparent_border_topbar ';
            }
        }









        return $topbar_class;
    }

endif;






if (!function_exists('wpestate_header_classes')):

    function wpestate_header_classes() {
   
        global $post;
        $return = array();

        $wpestate_is_user_dashboard     =   wpestate_is_user_dashboard() ;
        if( isset($post->ID) ){
            $wpestate_half_map_conditions   =   wpestate_half_map_conditions($post->ID);
        }else{
            $wpestate_half_map_conditions   =   wpestate_half_map_conditions(0);
        }
       
        $page_template='';
        if(isset($post->ID)){
           $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        }
         
        $wide_class = ' is_boxed ';
        $wide_status = esc_html(wpresidence_get_option('wp_estate_wide_status', ''));
        if ($wide_status == '') {
            $wide_status = 1;
        }
        if ($wide_status == 1 || $page_template == 'splash_page.php' ) {
            $wide_class = " wide ";
        }

        if (isset($post->ID) && $wpestate_half_map_conditions ) {
            $wide_class = "wide fixed_header ";
        }


        $halfmap_body_class = '';
        if (isset($post->ID) && $wpestate_half_map_conditions ) {
            $halfmap_body_class = " half_map_body ";
        }

        if (esc_html(wpresidence_get_option('wp_estate_show_top_bar_user_menu', '')) == "yes") {
            $halfmap_body_class .= " has_top_bar ";
        }

        $logo_header_type = wpresidence_get_option('wp_estate_logo_header_type', '');
        if ($logo_header_type == '') {
            $logo_header_type = 'type1';
        }


        $wpestate_logo_header_align = wpresidence_get_option('wp_estate_logo_header_align', '');
        $wide_header = wpresidence_get_option('wp_estate_wide_header', '');
        $wide_header_class = '';
        if ($wide_header == 'yes' || $page_template==  'splash_page.php' ) {
            $wide_header_class = " full_width_header ";
        }

        $top_menu_hover_type = wpresidence_get_option('wp_estate_top_menu_hover_type', '');
        $header_transparent_class = '';
        $header_transparent = wpresidence_get_option('wp_estate_header_transparent', '');


        if (isset($post->ID) && !is_tax() && !is_category()) {
            $header_transparent_page = get_post_meta($post->ID, 'header_transparent', true);
            if ($header_transparent_page == "global" || $header_transparent_page == "") {
                if ($header_transparent == 'yes') {
                    $header_transparent_class = ' header_transparent ';
                }
            } else if ($header_transparent_page == "yes") {
                $header_transparent_class = ' header_transparent ';
            }
        } else {
            if ($header_transparent == 'yes') {
                $header_transparent_class = ' header_transparent ';
            }
        }







        $logo = wpresidence_get_option('wp_estate_logo_image', 'url');
        $stikcy_logo_image = wpresidence_get_option('wp_estate_stikcy_logo_image', 'url');

        $transparent_logo = esc_html(wpresidence_get_option('wp_estate_transparent_logo_image', 'url'));
        $show_top_bar_user_login = esc_html(wpresidence_get_option('wp_estate_show_top_bar_user_login', ''));

        if ($show_top_bar_user_login == '') {
            $show_top_bar_user_login = 'yes';
        }
        
       
        
        if ( ( trim($header_transparent_class) == 'header_transparent' || $page_template== 'splash_page.php'  ) && $transparent_logo != '') {
          $logo = $transparent_logo;
        }

        $text_header_align_select = wpresidence_get_option('wp_estate_text_header_align', '');
        $show_header_dashboard = wpresidence_get_option('wp_estate_show_header_dashboard', '');

        if ($wpestate_is_user_dashboard && $show_header_dashboard == 'no') {
            $halfmap_body_class .= " dash_no_header ";
            $logo_header_type = '';
        }

        if ($wpestate_is_user_dashboard && $show_header_dashboard == 'yes') {
            $wide_class = " wide ";
            $logo_header_type = "type1  ";
            $wide_header_class = " full_width_header ";
            $header_transparent_class = '';
        }


        $show_top_bar_user_login_class = '';
        if ($show_top_bar_user_login != 'yes') {
            $show_top_bar_user_login_class = " no_user_submit ";
        }
        $show_submit_symbol = esc_html(wpresidence_get_option('wp_estate_show_submit', ''));

        $show_submit_symbol_class = '';
        if ($show_submit_symbol != 'yes') {
            $show_submit_symbol_class = " no_property_submit";
        }



        $topbar_transparent_page_global = wpresidence_get_option('wp_estate_header_transparent', '');
        if (isset($post->ID) && !is_tax() && !is_category()) {
            $topbar_transparent_page = get_post_meta($post->ID, 'topbar_transparent', true);
            if ($topbar_transparent_page == "global" || $topbar_transparent_page == "") {
                if ($topbar_transparent_page_global == 'yes') {
                    $header_transparent_class .= " topbar_transparent ";
                }
            } else if ($topbar_transparent_page == "yes") {
                $header_transparent_class .= " topbar_transparent ";
            }
        } else {
            if ($topbar_transparent_page_global == 'yes') {
                $header_transparent_class .= " topbar_transparent ";
            }
        }


        $header_transparent_class .= " topbar_transparent ";

        $main_wrapper_class = '';
        $main_wrapper_class .= $wide_class;
        $main_wrapper_class .= ' has_header_' . esc_attr($logo_header_type) . ' ';
        $main_wrapper_class .= ' ' . esc_attr($header_transparent_class) . ' ';
        $main_wrapper_class .= ' ' . 'contentheader_' . esc_attr($wpestate_logo_header_align) . ' ';
        $main_wrapper_class .= ' ' . 'cheader_' . esc_attr($wpestate_logo_header_align) . ' ';

        $master_header_class = '';
        $master_header_class .= ' ' . esc_attr($wide_class);
        $master_header_class .= ' ' . esc_attr($header_transparent_class);
        $master_header_class .= ' ' . esc_attr($wide_header_class);

        $header_wrapper_class = '';
        $header_wrapper_class .= ' ' . esc_attr($show_top_bar_user_login_class);
        $header_wrapper_class .= ' ' . 'header_' . esc_attr($logo_header_type);
        $header_wrapper_class .= ' ' . 'header_' . esc_attr($wpestate_logo_header_align);
        $header_wrapper_class .= ' ' . 'hover_type_' . esc_attr($top_menu_hover_type);
        $header_wrapper_class .= ' ' . 'header_alignment_text_' . esc_attr($text_header_align_select);
        $header_wrapper_class .= ' ' . esc_attr($show_submit_symbol_class);

        $header_wrapper_inside_class = '';
        $header_wrapper_inside_class .= ' ' . esc_attr($wide_header_class);


        $return['main_wrapper_class'] = $main_wrapper_class;
        $return['master_header_class'] = $master_header_class;
        $return['header_wrapper_class'] = $header_wrapper_class;
        $return['header_wrapper_inside_class'] = $header_wrapper_inside_class;
        $return['stikcy_logo_image'] = $stikcy_logo_image;
        $return ['logo'] = $logo;

  
        return $return;
    }

endif;



if (!function_exists('wpestate_display_logo')):

    function wpestate_display_logo($logo,$classes='') {
        global $post;
        $page_template='';
        if(isset($post->ID)){
           $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        }
        $logo_margin = intval(wpresidence_get_option('wp_estate_logo_margin', ''));
        $return = '<div class="logo '.esc_attr($classes).'" >
            <a href="';
        $splash_page_logo_link = wpresidence_get_option('wp_estate_splash_page_logo_link', '');
        if ($page_template=='splash_page.php' && $splash_page_logo_link != '') {
            $return .= esc_url($splash_page_logo_link);
        } else {
            $return .= esc_url(home_url('', 'login'));
        }
        $return .= '">';

        if ($logo != '') {
            $return .= '<img id="logo_image" style="margin-top:' . intval($logo_margin) . 'px;" src="' . esc_url($logo) . '" class="img-responsive retina_ready" alt="' . esc_html__('company logo', 'wpresidence') . '"/>';
        } else {
            $return .= '<img id="logo_image" class="img-responsive retina_ready" src="' . get_theme_file_uri('/img/logo.png') . '" alt="' . esc_html__('company logo', 'wpresidence') . '"/>';
        }

        $return .= '</a></div>';

        return $return;
    }

endif;

/*
*
* Check if modal
*
*/


if (!function_exists('wpestate_is_property_modal')):

    function wpestate_is_property_modal() {
       global $post;
        $page_template='';
        if(isset($post->ID)){
           $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        }
        $use_modal = wpresidence_get_option('wp_estate_use_property_modal', '');
        if ($use_modal == 'yes') {

            if (is_tax() ||
                    is_archive() ||
                    $page_template== 'property_list.php' ||
                    $page_template == 'property_list_directory.php' ||
                    $page_template=='property_list_half.php' ||
                    $page_template=='advanced_search_results.php' ) {

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

endif;

/*
*
* Return Property documents
*
*/

if (!function_exists('wpestare_return_documents')):

    function wpestare_return_documents($post_id) {
        $args = array(
            'post_mime_type' => 'application/pdf',
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post_id
        );
        $return = '';
        $attachments = get_posts($args);
        if ($attachments) {
            
            foreach ($attachments as $attachment) {
                $return .= '<div class="document_down">';
                ob_start();
                include (locate_template('templates/svg_icons/pdf_icon.html'));
                $icon=ob_get_contents();
                ob_end_clean();

              $return .= $icon.'<a href="' . esc_url(wp_get_attachment_url($attachment->ID)) . '" target="_blank">' . esc_html($attachment->post_title) . '</a></div>';
            }
        }
        wp_reset_postdata();
        return $return;
    }

endif;




/*
*
* Return Property Status
*
*/

if (!function_exists('wpestate_return_property_status')):

    function wpestate_return_property_status($post_id, $return_type = '') {
        $property_status = get_the_terms($post_id, 'property_status');
        $to_return = '';


        if ($return_type == 'pin') {
            if (!empty($property_status)) {
                foreach ($property_status as $key => $term) {
                    $to_return .= esc_html($term->name) . ',';
                }
            }
            $to_return = substr($to_return, 0, -1);
            return $to_return;
        } else if ($return_type == 'verticalstatus' || $return_type == 'horizontalstatus') {
            if (!empty($property_status)) {
                foreach ($property_status as $key => $term) {
                    if ($term->slug != 'normal') {
                        $ribbon_class = str_replace(' ', '-', $term->name);
                        $to_return .= '<div class="slider-property-status ' . esc_attr($return_type) . ' ribbon-wrapper-' . esc_attr($ribbon_class) . ' ' . esc_attr($ribbon_class) . '">' . esc_html($term->name) . '</div>';
                    }
                }
            }

            return '<div class="status-wrapper '. esc_attr($return_type).'">' . $to_return . '</div>';
        } else if ($return_type == 'unit') {
            if (!empty($property_status)) {
                foreach ($property_status as $key => $term) {
                    if ($term->slug != 'normal') {
                        $ribbon_class = str_replace(' ', '-', $term->name);
                        $to_return .= '<div class="ribbon-inside ' . esc_attr($ribbon_class) . '">' . esc_html($term->name) . '</div>';
                    }
                }
            }
            return $to_return;
        } else {
            if (!empty($property_status)) {
                foreach ($property_status as $key => $term) {
                    if ($term->slug != 'normal') {
                        $ribbon_class = str_replace(' ', '-', $term->name);
                        $to_return .= '<div class="ribbon-wrapper-default ribbon-wrapper-' . $ribbon_class . '"><div class="ribbon-inside ' . $ribbon_class . '">' . esc_html($term->name) . '</div></div>';
                    }
                }
            }

            return '<div class="status-wrapper">' . $to_return . '</div>';
        }
    }

endif;

function wpestate_check_mandatory_fields($prop_category = '', $prop_action_category = '') {

    $all_submission_fields = wpestate_return_all_fields();
    $mandatory_fields = wpresidence_get_option('wp_estate_mandatory_page_fields', '');
    $errors = array();

    $prop_category = intval($_POST['prop_category']);
    $prop_action_category = intval($_POST['prop_action_category']);

    $property_county    = sanitize_text_field($_POST['property_county']);
    $property_area      = sanitize_text_field($_POST['property_area']);
    $property_city      = sanitize_text_field($_POST['property_city']);

    $i=0;
    $custom_fields      =   wpresidence_get_option( 'wp_estate_custom_fields', '');
    if( !empty($custom_fields)){
        while($i< count($custom_fields) ){
           $name    =   $custom_fields[$i][0];
           $type    =   $custom_fields[$i][1];
           $slug    =   str_replace(' ','_',$name);
           $slug    =   wpestate_limit45(sanitize_title( $name ));
           $slug    =   sanitize_key($slug);
       
            $custom_fields_array[$slug]=  sanitize_text_field( $_POST[$slug]);
        
           $i++;
        }
    }






  

    if (is_array($mandatory_fields)) {

        foreach ($mandatory_fields as $key => $value) {

            if (isset($all_submission_fields[$value]) && term_exists($all_submission_fields[$value], 'property_features')) {
                $value_post = strtolower(sanitize_key($value));
                $value_post = str_replace('%', '', $value_post);
            } else {
                $value_post = wpestate_limit45(sanitize_title($value));
                $value_post = str_replace('%', '', $value_post);
            }


            $check_categs = 0;
            if (($value_post == 'prop_category' && is_numeric($prop_category) && $prop_category == -1) || ($value_post == 'prop_action_category' && is_numeric($prop_action_category) && $prop_action_category == -1)) {
                $check_categs = 1;
            }

            if ( $value_post == 'property_county' && is_numeric($property_county) && $property_county == -1)  {
                $check_categs = 1;
            }

            if ( $value_post == 'property_city' && ( $property_city == 'none' || $property_city == 'all' || $property_city == esc_html__('all','wpresidence') ) )  {
                $check_categs = 1;
            }
            if ( $value_post == 'property_area' && ( $property_area == 'none' || $property_area == 'all' || $property_city == esc_html__('all','wpresidence') ) ) {
                $check_categs = 1;
            }
          
            if( array_key_exists($value_post, $custom_fields_array) && $_POST[$value_post]==esc_html__('Not Available','wpresidence')  ){
                $check_categs = 1;
            }



            if (!isset($_POST[$value_post]) || $_POST[$value_post] == '' || $check_categs == 1) {

                if (isset($all_submission_fields[$value])) {
                    $string = $all_submission_fields[$value] . ' ';
                } else {
                    $value_new = ( str_replace('-', '_', $value));
                    $string = $all_submission_fields[$value_new] . ' ';
                }
                
  

                $string = esc_html__('Please submit the', 'wpresidence') . ' ' . $string . ' ' . esc_html__('field', 'wpresidence');
                $errors[] = $string;
            }
        }
    }
    return $errors;
}

if (!function_exists('wpestate_request_transient_cache')):

    function wpestate_request_transient_cache($transient_name) {

        if (wpresidence_get_option('wp_estate_disable_theme_cache') == 'yes') {
            return false;
        } else {
            return get_transient($transient_name);
        }
    }

endif;

function wpestate_set_transient_cache($transient_name, $value, $time) {
    if (wpresidence_get_option('wp_estate_disable_theme_cache') !== 'yes') {
        set_transient($transient_name, $value, $time);
    }
}

add_action('customize_save_after', 'wpresidence_customizer_savesettings', 10);

function wpresidence_customizer_savesettings() {
    if (has_site_icon()) {
        $values = array();
        $values['id'] = get_option('site_icon');
        $values['url'] = get_site_icon_url();
        if (function_exists('wpestate_residence_functionality_loaded')) {
            require_once WPESTATE_PLUGIN_PATH . 'admin/admin-init.php';
            Redux::init("wpresidence_admin");
            Redux::setOption('wpresidence_admin', 'wp_estate_favicon_image', $values); //front
        }
    }
}

if (!function_exists('wpestate_sorting_function')):

    function wpestate_sorting_function($a, $b) {
        return $a[3] - $b[3];
    }

endif;



/*
*
*
*
*/


if (!function_exists('wpresidence_return_class_leaflet')):

    function wpresidence_return_class_leaflet($tip = '') {
        $what_map = intval(wpresidence_get_option('wp_estate_kind_of_map'));
        if ($what_map == 2) {
            return ' with_open_street ';
        } else {
            return '';
        }
    }

endif;

/*
*
*
*
*/



if (!function_exists('wpresidence_get_option')):

    function wpresidence_get_option($theme_option, $option = false, $in_case_not = false) {

        global $wpresidence_admin;
        $theme_option = trim($theme_option);

        if ($theme_option == 'wpestate_currency') {
            $return = wpestate_reverse_convert_redux_wp_estate_multi_curr();
            return $return;
        } else if ($theme_option == 'wpestate_custom_fields_list' || $theme_option == 'wp_estate_custom_fields') {
            $return = wpestate_reverse_convert_redux_wp_estate_custom_fields();
            return $return;
        } else if ($theme_option == 'wp_estate_url_rewrites') {
            $return = get_option('wp_estate_url_rewrites', true);
            return $return;
        }


        if (isset($wpresidence_admin[$theme_option]) && $wpresidence_admin[$theme_option] != '') {
            $return = $wpresidence_admin[$theme_option];
            if ($option) {
                $return = $wpresidence_admin[$theme_option][$option];
            }
        } else {
            $return = $in_case_not;
        }

        return $return;
    }

endif;
/*
*
*
*
*/

if (!function_exists('wpestate_fields_type_select_redux')):

    function wpestate_fields_type_select_redux($name_drop, $real_value) {

        $select = '<select   name="' . $name_drop . '"   style="width:140px;">';
        $values = array('short text', 'long text', 'numeric', 'date', 'dropdown');

        foreach ($values as $option) {
            $select .= '<option value="' . $option . '"';
            if ($option == $real_value) {
                $select .= ' selected="selected"  ';
            }
            $select .= ' > ' . $option . ' </option>';
        }
        $select .= '</select>';
        return $select;
    }

endif;





/*
*
*
*
*/



add_action('admin_post_wpestate_purge_cache', 'wpestate_purge_cache');


if (!function_exists('wpestate_purge_cache')):

    function wpestate_purge_cache() {
        if (isset($_GET['action'], $_GET['_wpnonce'])) {

            if (!wp_verify_nonce($_GET['_wpnonce'], 'theme_purge_cache')) {
                wp_nonce_ays('');
            }

            wpestate_delete_cache();
            wp_redirect(wp_get_referer());
            die();
        }
    }

endif;
/*
*
*
*
*/

if (!function_exists('wpestate_purge_cache_sidebar')):

    function wpestate_purge_cache_sidebar() {
        if (isset($_GET['action'], $_GET['_wpnonce'])) {

            wpestate_delete_cache();
            wp_redirect(esc_url(admin_url()));
            die();
        }
    }

endif;


/*
*
*
*
*/

if (!function_exists('wpestate_replace_server_global')):

    function wpestate_replace_server_global($link) {
        return str_replace(array('http://', 'https://'), '', $link);
    }

endif;
/*
*
*
*
*/

if (!function_exists('wpestate_return_sending_email')):

    function wpestate_return_sending_email() {
        $name_email = wpresidence_get_option('wp_estate_send_name_email_from', '');
        $from_email = wpresidence_get_option('wp_estate_send_email_from', '');

        $return_string = $name_email.'  <'. $from_email.'>';
        return $return_string;
    }

endif;
/*
*
*
*
*/


if (!function_exists('wpestate_delete_cache')):

    function wpestate_delete_cache() {
        global $wpdb;
        $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE %s
            ORDER BY `option_name`";


        $wild = '%';
        $find = 'transient_';
        $like = $wild . $wpdb->esc_like($find) . $wild;

        $results = $wpdb->get_results($wpdb->prepare($sql, $like));
        $transients = array();




        foreach ($results as $result) {
            if (0 === strpos($result->name, '_transient_wpestate')) {
                $transient_name = str_replace('_transient_', '', $result->name);
                delete_transient($transient_name);
            }
        }

        delete_transient('envato_purchase_code_7896392_demos');
    }

endif;

if (!function_exists('wpestate_delete_cache_for_links')):

    function wpestate_delete_cache_for_links() {
        global $wpdb;
        $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE %s
            ORDER BY `option_name`";

        $wild = '%';
        $find = 'wpestate_get_template_link_';
        $like = $wild . $wpdb->esc_like($find) . $wild;

        $results = $wpdb->get_results($wpdb->prepare($sql, $like));


        foreach ($results as $result) {

            if (0 === strpos($result->name, '_transient_wpestate_get_template_link_')) {

                $transient_name = str_replace('_transient_', '', $result->name);
                delete_transient($transient_name);
            }
        }
    }

endif;


if (!function_exists('wpestate_convert_meta_to_postin')):

    function wpestate_convert_meta_to_postin($meta_query) {
        global $table_prefix;
        global $wpdb;
        $searched = 0;

        $feature_list_array = array();
        $allowed_html = array();


        foreach ($meta_query as $checker => $query) {
            //if ($value != '') {
            //    $searched = 1;
            //}


            $input_name = wpestate_limit45(sanitize_title($query['key']));
            $input_name = sanitize_key($input_name);



            if ($query['compare'] == 'BETWEEN') {
                if (trim($input_name) != '') {
                    $min = 0;
                    if ($query['value'][0] != 0) {
                        $min = $query['value'][0];
                    }
                    $potential_ids[$checker] = array_unique(
                            wpestate_get_ids_by_query(
                                    $wpdb->prepare("
                            SELECT DISTINCT post_id
                            FROM " . $table_prefix . "postmeta
                            WHERE meta_key = '%s'
                            AND CAST(meta_value AS SIGNED)  BETWEEN '%f' AND '%f'
                        ", array($input_name, $min, $query['value'][1])))
                    ); //a
                }
            } else if ($query['compare'] == 'LIKE') {
                if (trim($input_name) != '') {
                    $potential_ids[$checker] = array_unique(
                            wpestate_get_ids_by_query(
                                    $wpdb->prepare("
                            SELECT DISTINCT post_id
                            FROM " . $table_prefix . "postmeta
                            WHERE meta_key = '%s'
                            AND meta_value LIKE %s
                            ", array($input_name, $query['value'])))
                    ); //a
                }
            }
        }

        $ids = [];

        foreach ($potential_ids as $key => $temp_ids) {
            if (count($ids) == 0) {
                $ids = $temp_ids;
            } else {
                $ids = array_intersect($ids, $temp_ids);
            }
        }


        if (empty($ids) && $searched == 1) {
            $ids[] = 0;
        }
        return $ids;
    }

endif;




////////////////////////////////// reviews
add_action('wp_ajax_wpestate_edit_review', 'wpestate_edit_review');
if (!function_exists('wpestate_edit_review')):

    function wpestate_edit_review() {
        check_ajax_referer('wpestate_review_nonce', 'security');
        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $user_login = $current_user->user_login;
        $allowed_html = array();

        if (!is_user_logged_in()) {
            exit('ko');
        }
        if ($userID === 0) {
            exit('out pls');
        }
        $comment_ID = intval($_POST['coment']);
        $coment = get_comment($comment_ID);
        print intval($userID) . '/ ' . intval($coment->user_id);
        if ($coment->user_id != $userID) {
            exit('no');
        }


        $listing_id = intval($_POST['listing_id']);
        $stars = intval($_POST['stars']);
        $content = wp_kses($_POST['content'], $allowed_html);
        $title = wp_kses($_POST['title'], $allowed_html);



        update_comment_meta($comment_ID, 'review_title', $title);
        update_comment_meta($comment_ID, 'review_stars', $stars);
        update_comment_meta($comment_ID, 'comment_content', $content);

        $commentarr = array();
        $commentarr['comment_ID'] = $comment_ID;
        $commentarr['comment_content'] = $content;
        $comment_approved = 0;
        if (wpresidence_get_option('wp_estate_admin_approves_reviews', '') == 'no') {
            $comment_approved = 1;
        }
        $commentarr['comment_approved'] = $comment_approved;
        wp_update_comment($commentarr);


        $arguments = array(
            'agent_name' => get_the_title($listing_id),
            'user_post' => $user_login
        );
        wpestate_select_email_type(get_option('admin_email'), 'agent_review', $arguments);


        die();
    }

endif;






add_action('wp_ajax_wpestate_post_review', 'wpestate_post_review');
if (!function_exists('wpestate_post_review')):

    function wpestate_post_review() {
        check_ajax_referer('wpestate_review_nonce', 'security');
        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $allowed_html = array();

        if (!is_user_logged_in()) {
            exit('ko');
        }
        if ($userID === 0) {
            exit('out pls');
        }

        $userID = $current_user->ID;
        $user_login = $current_user->user_login;
        $user_email = $current_user->user_email;
        $listing_id = intval($_POST['listing_id']);

        $stars = intval($_POST['stars']);
        $content = wp_kses($_POST['content'], $allowed_html);
        $title = wp_kses($_POST['title'], $allowed_html);
        $time = time();
        $time = current_time('mysql');

        $comment_approved = 0;
        if (wpresidence_get_option('wp_estate_admin_approves_reviews', '') == 'no') {
            $comment_approved = 1;
        }


        $data = array(
            'comment_post_ID' => $listing_id,
            'comment_author' => $user_login,
            'comment_author_email' => $user_email,
            'comment_author_url' => '',
            'comment_content' => $content,
            'comment_type' => 'comment',
            'comment_parent' => 0,
            'user_id' => $userID,
            'comment_author_IP' => '127.0.0.1',
            'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
            'comment_date' => $time,
            'comment_approved' => $comment_approved,
        );



        $comment_id = wp_insert_comment($data);
        add_comment_meta($comment_id, 'review_title', $title);
        add_comment_meta($comment_id, 'review_stars', $stars);

        $arguments = array(
            'agent_name' => get_the_title($listing_id),
            'user_post' => $user_login
        );
        wpestate_select_email_type(get_option('admin_email'), 'agent_review', $arguments);

        die();
    }

endif;




if (!function_exists('wpestate_splash_page_header')):

    function wpestate_splash_page_header() {

        $spash_header_type = wpresidence_get_option('wp_estate_spash_header_type', '');

        if ($spash_header_type == 'image') {
            wpestate_header_image('');
        } else if ($spash_header_type == 'video') {
            wpestate_video_header();
        } else if ($spash_header_type == 'image slider') {
            wpestate_splash_slider();
        }
    }

endif;


if (!function_exists('wpestate_splash_slider')):

    function wpestate_splash_slider() {
        $splash_slider_gallery = esc_html(wpresidence_get_option('wp_estate_splash_slider_gallery', ''));
        $splash_slider_transition = esc_html(wpresidence_get_option('wp_estate_splash_slider_transition', ''));

        $splash_slider_gallery_array = explode(',', $splash_slider_gallery);

        $slider = '<div id="splash_slider_wrapper" class="carousel slide" data-ride="carousel" data-interval="' . esc_attr($splash_slider_transition) . '">';
        $i = 0;
        if (is_array($splash_slider_gallery_array)) {
            foreach ($splash_slider_gallery_array as $image_id) {
                $image_id = intval($image_id);
                if ($image_id != '' && $image_id != 0) {
                    $i++;
                    if ($i == 1) {
                        $class_active = ' active ';
                    } else {
                        $class_active = '  ';
                    }
                    $preview = wp_get_attachment_image_src($image_id, 'full');
                    $slider .= '<div class="item splash_slider_item';
                    $slider .= $class_active . ' "  style="background-image:url(' . esc_url($preview[0]) . ');" >


                </div>';
                }
            }
        }

        $slider .= '</div>';

        $page_header_overlay_val = esc_html(wpresidence_get_option('wp_estate_splash_overlay_opacity', ''));
        $page_header_overlay_color = esc_html(wpresidence_get_option('wp_estate_splash_overlay_color', ''));
        $wp_estate_splash_overlay_image = esc_html(wpresidence_get_option('wp_estate_splash_overlay_image', 'url'));
        $page_header_title_over_image = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_title', '')));
        $page_header_subtitle_over_image = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_subtitle', '')));

        if (is_page_template('splash_page.php')) {
            if ($page_header_overlay_color != '' || $wp_estate_splash_overlay_image != '') {
                $slider .= '<div class="wpestate_header_image_overlay" style="background-color:' . $page_header_overlay_color . ';opacity:' . $page_header_overlay_val . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
            }
        }

        if ($page_header_overlay_color != '' || $wp_estate_splash_overlay_image != '') {
            $slider .= '<div class="wpestate_header_image_overlay" style="background-color:#' . $page_header_overlay_color . ';opacity:' . $page_header_overlay_val . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
        }

        if ($page_header_title_over_image != '') {
            $slider .= '<div class="heading_over_image_wrapper" >';
            $slider .= '<h1 class="heading_over_image">' . $page_header_title_over_image . '</h1>';

            if ($page_header_subtitle_over_image != '') {
                $slider .= '<div class="subheading_over_image">' . $page_header_subtitle_over_image . '</div>';
            }

            $slider .= '</div>';
        }


        $slider .= '<a class="left  carousel-control"  href="#splash_slider_wrapper"  data-slide="prev">
            <i class="demo-icon icon-left-open-big"></i>
        </a>

        <a class="right  carousel-control"  href="#splash_slider_wrapper" data-slide="next">
            <i class="demo-icon icon-right-open-big"></i>
        </a>';


        print trim($slider);
    }

endif;



if (!function_exists('wpestate_video_header')):

    function wpestate_video_header() {

        global $post;
        $paralax_header = wpresidence_get_option('wp_estate_paralax_header', '');
        if (isset($post->ID)) {
            if (is_page_template('splash_page.php')) {
                $page_custom_video = esc_html(wpresidence_get_option('wp_estate_splash_video_mp4', 'url'));
                $page_custom_video_webm = esc_html(wpresidence_get_option('wp_estate_splash_video_webm', 'url'));
                $page_custom_video_ogv = esc_html(wpresidence_get_option('wp_estate_splash_video_ogv', 'url'));
                $page_custom_video_cover_image = esc_html(wpresidence_get_option('wp_estate_splash_video_cover_img', 'url'));
                $img_full_screen = 'no';
                $page_header_title_over_video = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_title', '')));
                $page_header_subtitle_over_video = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_subtitle', '')));
                $page_header_video_height = '';
                $page_header_overlay_color_video = esc_html(wpresidence_get_option('wp_estate_splash_overlay_color', ''));
                $page_header_overlay_val_video = esc_html(wpresidence_get_option('wp_estate_splash_overlay_opacity', ''));
                $wp_estate_splash_overlay_image = esc_html(wpresidence_get_option('wp_estate_splash_overlay_image', 'url'));
            } else {
                $page_custom_video = esc_html(get_post_meta($post->ID, 'page_custom_video', true));
                $page_custom_video_webm = esc_html(get_post_meta($post->ID, 'page_custom_video_webbm', true));
                $page_custom_video_ogv = esc_html(get_post_meta($post->ID, 'page_custom_video_ogv', true));
                $page_custom_video_cover_image = esc_html(get_post_meta($post->ID, 'page_custom_video_cover_image', true));
                $img_full_screen = esc_html(get_post_meta($post->ID, 'page_header_video_full_screen', true));
                $page_header_title_over_video = stripslashes(esc_html(get_post_meta($post->ID, 'page_header_title_over_video', true)));
                $page_header_subtitle_over_video = stripslashes(esc_html(get_post_meta($post->ID, 'page_header_subtitle_over_video', true)));
                $page_header_video_height = floatval(get_post_meta($post->ID, 'page_header_video_height', true));
                $page_header_overlay_color_video = esc_html(get_post_meta($post->ID, 'page_header_overlay_color_video', true));
                $page_header_overlay_val_video = esc_html(get_post_meta($post->ID, 'page_header_overlay_val_video', true));
                $wp_estate_splash_overlay_image = '';
            }


            if ($page_header_overlay_val_video == '') {
                $page_header_overlay_val_video = 1;
            }
            if ($page_header_video_height == 0) {
                $page_header_video_height = 580;
            }


            print '<div class="wpestate_header_video full_screen_' . $img_full_screen . ' parallax_effect_' . $paralax_header . '" style="';
            print ' height:' . $page_header_video_height . 'px; ';
            print '">';


            print '<video id="hero-vid" class="header_video" poster="' . $page_custom_video_cover_image . '" width="100%" height="100%" autoplay playsinline';
            if (wp_is_mobile()) {
                print ' controls ';
            }
            print' muted loop>
			<source src="' . esc_url($page_custom_video) . '" type="video/mp4" />
			<source src="' . esc_url($page_custom_video_webm) . '" type="video/webm" />
                        <source src="' . esc_url($page_custom_video_ogv) . '" type="video/ogg"/>

		</video>';

            if (is_page_template('splash_page.php')) {
                if ($page_header_overlay_color_video != '' || $wp_estate_splash_overlay_image != '') {
                    print '<div class="wpestate_header_video_overlay" style="background-color:' . $page_header_overlay_color_video . ';opacity:' . $page_header_overlay_val_video . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
                }
            }

            if ($page_header_overlay_color_video != '' || $wp_estate_splash_overlay_image != '') {
                print '<div class="wpestate_header_video_overlay" style="background-color:#' . $page_header_overlay_color_video . ';opacity:' . $page_header_overlay_val_video . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
            }

            if ($page_header_title_over_video != '') {
                print '<div class="heading_over_video_wrapper" >';
                print '<h1 class="heading_over_video">' . $page_header_title_over_video . '</h1>';

                if ($page_header_subtitle_over_video != '') {
                    print '<div class="subheading_over_video">' . $page_header_subtitle_over_video . '</div>';
                }

                print '</div>';
            }


            print'</div>';
        }
    }

endif;










if (!function_exists('wpestate_header_image')):

    function wpestate_header_image($image) {
        global $post;
        $paralax_header = wpresidence_get_option('wp_estate_paralax_header', '');
        if (is_category() || is_tax() || is_archive()) {
            print '<div class="wpestate_header_image " style="background-image:url(' . esc_url($image) . ')"></div>';
        } else if (isset($post->ID)) {

            if (is_page_template('splash_page.php')) {
                $header_type = 20;
                $image = esc_html(wpresidence_get_option('wp_estate_splash_image', 'url'));
                $img_full_screen = 'no';
                $img_full_back_type = '';
                $page_header_title_over_image = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_title', '')));
                $page_header_subtitle_over_image = stripslashes(esc_html(wpresidence_get_option('wp_estate_splash_page_subtitle', '')));
                $page_header_image_height = 600;
                $page_header_overlay_val = esc_html(wpresidence_get_option('wp_estate_splash_overlay_opacity', ''));
                $page_header_overlay_color = esc_html(wpresidence_get_option('wp_estate_splash_overlay_color', ''));
                $wp_estate_splash_overlay_image = esc_html(wpresidence_get_option('wp_estate_splash_overlay_image', 'url'));
            } else {
                $header_type = get_post_meta($post->ID, 'header_type', true);

                if ($header_type == 0) {
                    $img_full_screen = esc_html(wpresidence_get_option('wp_estate_global_header', 'url'));
                    $img_full_back_type = '';
                    $page_header_title_over_image = '';
                    $page_header_subtitle_over_image = '';
                    $page_header_image_height = '';
                    $page_header_overlay_val = '';
                    $page_header_overlay_color = '';
                    $wp_estate_splash_overlay_image = '';
                } else {
                    $img_full_screen = esc_html(get_post_meta($post->ID, 'page_header_image_full_screen', true));
                    $img_full_back_type = esc_html(get_post_meta($post->ID, 'page_header_image_back_type', true));
                    $page_header_title_over_image = stripslashes(esc_html(get_post_meta($post->ID, 'page_header_title_over_image', true)));
                    $page_header_subtitle_over_image = stripslashes(esc_html(get_post_meta($post->ID, 'page_header_subtitle_over_image', true)));
                    $page_header_image_height = floatval(get_post_meta($post->ID, 'page_header_image_height', true));
                    $page_header_overlay_val = esc_html(get_post_meta($post->ID, 'page_header_overlay_val', true));
                    $page_header_overlay_color = esc_html(get_post_meta($post->ID, 'page_header_overlay_color', true));
                    $wp_estate_splash_overlay_image = '';
                }
            }




            if ($page_header_overlay_val == '') {
                $page_header_overlay_val = 1;
            }
            if ($page_header_image_height == 0) {
                $page_header_image_height = 580;
            }

            print '<div class="wpestate_header_image full_screen_' . $img_full_screen . ' parallax_effect_' . $paralax_header . '" style="background-image:url(' . esc_url($image) . ');';
            if ($page_header_image_height != 0) {
                print ' height:' . $page_header_image_height . 'px; ';
            }
            if ($img_full_back_type == 'contain') {
                print '  background-size: contain; ';
            }
            print '">';

            if (is_page_template('splash_page.php')) {
                if ($page_header_overlay_color != '' || $wp_estate_splash_overlay_image != '') {
                    print '<div class="wpestate_header_image_overlay" style="background-color:' . $page_header_overlay_color . ';opacity:' . $page_header_overlay_val . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
                }
            }

            if ($page_header_overlay_color != '' || $wp_estate_splash_overlay_image != '') {
                print '<div class="wpestate_header_image_overlay" style="background-color:#' . $page_header_overlay_color . ';opacity:' . $page_header_overlay_val . ';background-image:url(' . esc_url($wp_estate_splash_overlay_image) . ');"></div>';
            }

            if ($page_header_title_over_image != '') {
                print '<div class="heading_over_image_wrapper" >';
                print '<h1 class="heading_over_image">' . $page_header_title_over_image . '</h1>';

                if ($page_header_subtitle_over_image != '') {
                    print '<div class="subheading_over_image">' . $page_header_subtitle_over_image . '</div>';
                }

                print '</div>';
            }


            print'</div>';
        } else {

            print '<div class="wpestate_header_image " style="background-image:url(' . esc_url($image) . ')"></div>';
        }
    }

endif;

if (!function_exists('wpestate_show_advanced_search')):

    function wpestate_show_advanced_search($post_id) {


        if (is_category() || is_tax() || is_archive()) {

            if (is_tax() && wpresidence_get_option('wp_estate_property_list_type') == 2) {
                return;
            }
            if (wpresidence_get_option('wp_estate_show_adv_search_general', '') == 'yes') {
                if (!wpestate_float_search_placement('') && !wpestate_half_map_conditions('')) {

                    include( locate_template('templates/advanced_search.php') );
                }
            }
        } else if (!wpestate_float_search_placement($post_id) && !wpestate_half_map_conditions($post_id)) {
            if (!wpestate_is_user_dashboard()) {

                include( locate_template('templates/advanced_search.php') );
            }
        }
    }

endif;




if (!function_exists('wpestate_float_search_placement_new')):

    function wpestate_float_search_placement_new() {
        global $post;
        $post_id = '';
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
        $float_form_top_local = '';
        $float_search_form = wpestate_retrive_float_search_placement($post_id);
        $search_float_type = 0;


        if (isset($post->ID)) {
            $search_float_type = intval(get_post_meta($post->ID, 'use_float_search_form_local_set', true));
        }
        if (is_404() || is_category() || is_tax() || is_archive() || is_search()) {
            $float_search_form = esc_html(wpresidence_get_option('wp_estate_use_float_search_form', ''));
        }

        if (wpestate_half_map_conditions($post_id)) {
            return false;
        }

        if ($search_float_type == 0 && $float_search_form == 'yes') {
            return true;
        } else if ($search_float_type == 2) {
            return true;
        } else {
            return false;
        }
    }

endif;




if (!function_exists('wpestate_float_search_placement')):

    function wpestate_float_search_placement($post_id) {
        global $post;
        $float_form_top_local = '';
        $float_search_form = wpestate_retrive_float_search_placement($post_id);
        $search_float_type = 0;


        if (isset($post->ID)) {
            $search_float_type = intval(get_post_meta($post->ID, 'use_float_search_form_local_set', true));
        }


        if (wpestate_half_map_conditions($post_id)) {
            return false;
        }

        if ($search_float_type == 0 && $float_search_form == 'yes') {
            return true;
        } else if ($search_float_type == 2) {
            return true;
        } else {
            return false;
        }
    }

endif;


if (!function_exists('wpestate_retrive_float_search_placement')):

    function wpestate_retrive_float_search_placement($post_id) {
        $page_use_float_search = '';
        if (isset($post_id)) {
            $page_use_float_search = get_post_meta($post_id, 'page_use_float_search', true);
        }
        if (is_404() || is_category() || is_tax() || is_archive() || is_search()) {
            return esc_html(wpresidence_get_option('wp_estate_use_float_search_form', ''));
        }
        if ($page_use_float_search == 'global') {
            return esc_html(wpresidence_get_option('wp_estate_use_float_search_form', ''));
        } else {
            return $page_use_float_search;
        }
    }

endif;




if (!function_exists('wpestate_search_float_position')):

    function wpestate_search_float_position($post_id) {
        $return = '';
        if (isset($post_id)) {
            $page_use_float_search = get_post_meta($post_id, 'page_use_float_search', true);
            if ($page_use_float_search == 'yes') {
                $return = ' style="top:' . get_post_meta($post_id, 'page_wp_estate_float_form_top', true) . ';" ';
            }
        }
        return $return;
    }

endif;





if (!function_exists('wpestate_show_poi_onmap')):

    function wpestate_show_poi_onmap($where = '') {
        global $post;
        if (!is_singular('estate_property') || wpresidence_get_option('wp_estate_kind_of_map') == 2) {
            return;
        }


        $points = array(
            'transport'     => esc_html__('Transport', 'wpresidence'),
            'supermarkets'  => esc_html__('Supermarkets', 'wpresidence'),
            'schools'       => esc_html__('Schools', 'wpresidence'),
            'restaurant'    => esc_html__('Restaurants', 'wpresidence'),
            'pharma'        => esc_html__('Pharmacies', 'wpresidence'),
            'hospitals'     => esc_html__('Hospitals', 'wpresidence'),
        );

        $unique_id=rand(1,9999);
        $return_value = '<div class="google_map_poi_marker">';
        foreach ($points as $key => $value) {
            $return_value .= '<div class="google_poi' .esc_attr($where).'" data-value="'.esc_attr($key).'" id="'.esc_attr($key.'_'.$unique_id).'"><img src="' . get_theme_file_uri('/css/css-images/poi/' . $key . '_icon.png') . '" class="dashboad-tooltip" alt="' . esc_attr($value) . '" data-placement="right"  data-original-title="' . esc_attr($value) . '" ></div>';
        }
        $return_value .= '</div>';
        return $return_value;
    }

endif;






/*
*
* Price Pin converter for pins
*
*/

if (!function_exists('wpestate_price_short_converter')):
    function wpestate_price_short_converter($pin_price) {

        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($pin_price != 0) {

               // $pin_price = $pin_price * $custom_fields[$i][2];
                $wpestate_currency = $custom_fields[$i][0];
                $where_currency = $custom_fields[$i][3];
            } else {
                $pin_price = '';
            }
        }

        $pin_price = floatval($pin_price);
        if (10000 < $pin_price && $pin_price < 1000000) {
            $pin_price = round($pin_price / 1000, 1);
            $pin_price = $pin_price . '' . esc_html__('K', 'wpresidence');
        } else if ($pin_price >= 1000000) {
            $pin_price = round($pin_price / 1000000, 1);
            $pin_price = $pin_price . '' . esc_html__('M', 'wpresidence');
        }


        return $pin_price;
    }
endif;


/*
*
* Price Pin converter for pins
*
*/

if (!function_exists('wpestate_price_pin_converter')):
    function wpestate_price_pin_converter($pin_price, $where_currency, $wpestate_currency,$simple='') {

        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($pin_price != 0) {

                $pin_price = $pin_price * $custom_fields[$i][2];
                $wpestate_currency = $custom_fields[$i][0];
                $where_currency = $custom_fields[$i][3];
            } else {
                $pin_price = '';
            }
        }

        $pin_price = floatval($pin_price);
        if (10000 < $pin_price && $pin_price < 1000000) {
            $pin_price = round($pin_price / 1000, 1);
            $pin_price = $pin_price . '' . esc_html__('K', 'wpresidence');
        } else if ($pin_price >= 1000000) {
            $pin_price = round($pin_price / 1000000, 1);
            $pin_price = $pin_price . '' . esc_html__('M', 'wpresidence');
        }



        if($simple==''):
            if ($where_currency == 'before') {
                $pin_price = $wpestate_currency . ' ' . $pin_price;
            } else {
                $pin_price = $pin_price . ' ' . $wpestate_currency;
            }
        endif;

        return $pin_price;
    }
endif;



/*
*
* 
*
*/



if (!function_exists('wpestate_add_allowed_tags')):

    function wpestate_add_allowed_tags($tags) {

        $allowed_html_desc = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'ul' => array('li'),
            'li' => array(),
            'code' => array(),
            'ol' => array('li'),
            'del' => array(
                'datetime' => array()
            ),
            'blockquote' => array(),
            'ins' => array(),
        );
        return $allowed_html_desc;
    }

endif;



if (!function_exists('wpestate_strip_array')):

    function wpestate_strip_array($key) {

        $string = htmlspecialchars(stripslashes(($key)), ENT_QUOTES);

        return wp_specialchars_decode($string);
    }

endif;




if (!function_exists('wpestate_yelp_details')):

    function wpestate_yelp_details($post_id) {


        $yelp_terms_array = array(
                    'active' => array('category' => esc_html__('Active Life', 'wpresidence'),
                        'category_sign' => 'fa fa-bicycle'),
                    'arts' => array('category' => esc_html__('Arts & Entertainment', 'wpresidence'),
                        'category_sign' => 'fa fa-music'),
                    'auto' => array('category' => esc_html__('Automotive', 'wpresidence'),
                        'category_sign' => 'fa fa-car'),
                    'beautysvc' => array('category' => esc_html__('Beauty & Spas', 'wpresidence'),
                        'category_sign' => 'fa fa-female'),
                    'education' => array('category' => esc_html__('Education', 'wpresidence'),
                        'category_sign' => 'fa fa-graduation-cap'),
                    'eventservices' => array('category' => esc_html__('Event Planning & Services', 'wpresidence'),
                        'category_sign' => 'fa fa-birthday-cake'),
                    'financialservices' => array('category' => esc_html__('Financial Services', 'wpresidence'),
                        'category_sign' => 'fa fa-money'),
                    'food' => array('category' => esc_html__('Food', 'wpresidence'),
                        'category_sign' => 'fa fa fa-cutlery'),
                    'health' => array('category' => esc_html__('Health & Medical', 'wpresidence'),
                        'category_sign' => 'fa fa-medkit'),
                    'homeservices' => array('category' => esc_html__('Home Services ', 'wpresidence'),
                        'category_sign' => 'fa fa-wrench'),
                    'hotelstravel' => array('category' => esc_html__('Hotels & Travel', 'wpresidence'),
                        'category_sign' => 'fa fa-bed'),
                    'localflavor' => array('category' => esc_html__('Local Flavor', 'wpresidence'),
                        'category_sign' => 'fa fa-coffee'),
                    'localservices' => array('category' => esc_html__('Local Services', 'wpresidence'),
                        'category_sign' => 'fa fa-dot-circle-o'),
                    'massmedia' => array('category' => esc_html__('Mass Media', 'wpresidence'),
                        'category_sign' => 'fa fa-television'),
                    'nightlife' => array('category' => esc_html__('Nightlife', 'wpresidence'),
                        'category_sign' => 'fa fa-glass'),
                    'pets' => array('category' => esc_html__('Pets', 'wpresidence'),
                        'category_sign' => 'fa fa-paw'),
                    'professional' => array('category' => esc_html__('Professional Services', 'wpresidence'),
                        'category_sign' => 'fa fa-suitcase'),
                    'publicservicesgovt' => array('category' => esc_html__('Public Services & Government', 'wpresidence'),
                        'category_sign' => 'fa fa-university'),
                    'realestate' => array('category' => esc_html__('Real Estate', 'wpresidence'),
                        'category_sign' => 'fa fa-building-o'),
                    'religiousorgs' => array('category' => esc_html__('Religious Organizations', 'wpresidence'),
                        'category_sign' => 'fa fa-cloud'),
                    'restaurants' => array('category' => esc_html__('Restaurants', 'wpresidence'),
                        'category_sign' => 'fa fa-cutlery'),
                    'shopping' => array('category' => esc_html__('Shopping', 'wpresidence'),
                        'category_sign' => 'fa fa-shopping-bag'),
                    'transport' => array('category' => esc_html__('Transportation', 'wpresidence'),
                        'category_sign' => 'fa fa-bus')
        );
        //$yelp_to_display  =   wpestate_request_transient_cache('wpestate_yelp_'.$post_id);
        $yelp_to_display = get_transient('wpestate_yelp_' . $post_id);
        $yelp_to_display=false;
        if ($yelp_to_display === false) {
            $yelp_terms         = wpresidence_get_option('wp_estate_yelp_categories', '');
            $yelp_results_no    = wpresidence_get_option('wp_estate_yelp_results_no', '');
            $yelp_dist_measure  = wpresidence_get_option('wp_estate_yelp_dist_measure', '');

            $yelp_client_id         = wpresidence_get_option('wp_estate_yelp_client_id', '');
            $yelp_client_secret     = wpresidence_get_option('wp_estate_yelp_client_secret', '');
            $yelp_client_api_key_2018 = wpresidence_get_option('wp_estate_yelp_client_api_key_2018', '');
            if ($yelp_client_id == '' || $yelp_client_api_key_2018 == '') {
                return;
            }

            //$location= "times square";
            $property_address       = esc_html(get_post_meta($post_id, 'property_address', true));
            $property_city_array    = get_the_terms($post_id, 'property_city');

            if (empty($property_city_array)) {
                return;
            }

            $property_city = $property_city_array[0]->name;
            $location = $property_address . ',' . $property_city;

            $start_lat = get_post_meta($post_id, 'property_latitude', true);
            $start_long = get_post_meta($post_id, 'property_longitude', true);


            $yelp_to_display = '';

            $stored_yelp = get_post_meta($post_id, 'stored_yelp', true);
            $stored_yelp_date = get_post_meta($post_id, 'stored_yelp_data', true);
            $now = time();


            foreach ($yelp_terms as $key => $term) {

                $category_name = $yelp_terms_array[$term]['category'];
                $category_icon = $yelp_terms_array[$term]['category_sign'];

                $args = array(
                    'term' => $term,
                    'limit' => $yelp_results_no,
                    'location' => $location
                );

                $details = wpestate_query_api($term, $location);

                if( isset($details->error)  ){
                    $yelp_to_display= esc_html__('There are no results found for this property address. ','wpresidence');
                }else if (isset($details->businesses)) {
                    $category = $details->businesses;

                    $yelp_to_display .= '<div class="yelp_bussines_wrapper"><div class="yelp_icon"><i class="' . $category_icon . '"></i></div> <h4 class="yelp_category">' . $category_name . '</h4>';
                    foreach ($category as $unit) {


                        $yelp_to_display .= '<div class="yelp_unit">';
                        $yelp_to_display .= '<h5 class="yelp_unit_name">' . $unit->name . '</h5>';

                        if (isset($unit->coordinates->latitude) && isset($unit->coordinates->longitude)) {
                            $yelp_to_display .= ' <span class="yelp_unit_distance"> ' . wpestate_calculate_distance_geo($unit->coordinates->latitude, $unit->coordinates->longitude, $start_lat, $start_long, $yelp_dist_measure) . '</span>';
                        }

                        $image_path = (string) $unit->rating;
                        $image_path = str_replace('.5', '_half', $image_path);
                        $yelp_to_display .= '<img class="yelp_stars" src="' . get_theme_file_uri('/img/yelp_small/small_' . $image_path . '.png') . '" alt="' . esc_attr($unit->name) . '">';

                        $yelp_to_display .= '</div>';
                    }
                    $yelp_to_display .= '</div>';
                }
            }// end forearch
            //wpestate_set_transient_cache('wpestate_yelp_'.$post_id,$yelp_to_display,24*60*60);
            set_transient('wpestate_yelp_' . $post_id, $yelp_to_display, 24 * 60 * 60);
        }
        print trim($yelp_to_display);
    }

endif;




if (!function_exists('wpestate_calculate_distance_geo')):

    function wpestate_calculate_distance_geo($lat, $long, $start_lat, $start_long, $yelp_dist_measure) {

        $angle = $start_long - $long;
        $distance = sin(deg2rad($start_lat)) * sin(deg2rad($lat)) + cos(deg2rad($start_lat)) * cos(deg2rad($lat)) * cos(deg2rad($angle));
        $distance = acos($distance);
        $distance = rad2deg($distance);

        if ($yelp_dist_measure == 'miles') {
            $distance_miles = $distance * 60 * 1.1515;
            return '(' . round($distance_miles, 2) . ' ' . esc_html__('miles', 'wpresidence') . ')';
        } else {
            $distance_miles = $distance * 60 * 1.1515 * 1.6;
            return '(' . round($distance_miles, 2) . ' ' . esc_html__('km', 'wpresidence') . ')';
        }
    }

endif;

if (!function_exists('wpestate_show_related_listings')):

    function wpestate_show_related_listings($postid, $similar_no = 3, $settings_elementor = '') {
        global $wpestate_property_unit_slider;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        global $post;
        
        $selected_categ= wpresidence_get_option('wp_estate_simialar_taxes');

        $section_title = esc_html__('Similar Listings', 'wpresidence');
        if (isset($settings_elementor['section_title']) && $settings_elementor['section_title'] !== '') {
            $section_title = $settings_elementor['section_title'];
        }

        $wpestate_options = wpestate_page_details($post->ID);
        $wpestate_no_listins_per_row = intval(wpresidence_get_option('wp_estate_listings_per_row', ''));

        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));

        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider', '');
        $counter = 0;
        $post_category = get_the_terms($postid, 'property_category');
        $post_action_category = get_the_terms($postid, 'property_action_category');
        $post_city_category = get_the_terms($postid, 'property_city');
        $args = '';
        $items[] = '';
        $items_actions[] = '';
        $items_city[] = '';
        $categ_array = '';
        $action_array = '';
        $city_array = '';
        $not_in = array();
        $not_in[] = $postid;
        $return_string = '';

        $property_card_type = intval(wpresidence_get_option('wp_estate_unit_card_type'));
        if (isset($settings_elementor['unit_type']) && $settings_elementor['unit_type'] !== '') {
            $property_card_type = $settings_elementor['unit_type'];
        }

        $property_card_type_string = '';
        if ($property_card_type == 0) {
            $property_card_type_string = '';
        } else {
            $property_card_type_string = '_type' . $property_card_type;
        }

        ////////////////////////////////////////////////////////////////////////////
        /// compose taxomomy categ array
        ////////////////////////////////////////////////////////////////////////////

        if ($post_category != ''):
            foreach ($post_category as $item) {
                $items[] = $item->term_id;
            }
            $categ_array = array(
                'taxonomy' => 'property_category',
                'field' => 'id',
                'terms' => $items
            );
        endif;

        ////////////////////////////////////////////////////////////////////////////
        /// compose taxomomy action array
        ////////////////////////////////////////////////////////////////////////////

        if ($post_action_category != ''):
            foreach ($post_action_category as $item) {
                $items_actions[] = $item->term_id;
            }
            $action_array = array(
                'taxonomy' => 'property_action_category',
                'field' => 'id',
                'terms' => $items_actions
            );
        endif;

        ////////////////////////////////////////////////////////////////////////////
        /// compose taxomomy action city
        ////////////////////////////////////////////////////////////////////////////

        if ($post_city_category != ''):
            foreach ($post_city_category as $item) {
                $items_city[] = $item->term_id;
            }
            $city_array = array(
                'taxonomy' => 'property_city',
                'field' => 'id',
                'terms' => $items_city
            );
        endif;

        ////////////////////////////////////////////////////////////////////////////
        /// compose wp_query
        ////////////////////////////////////////////////////////////////////////////
        $similar_no = wpresidence_get_option('wp_estate_similar_prop_no');
        if (isset($settings_elementor['post_number'])) {
            $similar_no = $settings_elementor['post_number'];
        }
        $wpestate_no_listins_per_row = 3;
        if (isset($settings_elementor['post_number_per_row'])) {
            $wpestate_no_listins_per_row = $settings_elementor['post_number_per_row'];
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if(class_exists( 'Elementor\Plugin')){
                if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                    $wpestate_no_listins_per_row = $settings_elementor['post_number_per_row'] + 1;
                }
            }
        }




        $args = array(
            'posts_per_page' => $similar_no,
            'ignore_sticky_posts' => 0,
            'post_type' => 'estate_property',
            'post_status' => 'publish',
            'post__not_in' => $not_in,
            'tax_query' => array(
                'relation' => 'AND',
            
            )
        );

        if(is_array($selected_categ)){
            if(in_array('property_category'  , $selected_categ)){
                $args[ 'tax_query' ][]=$categ_array;
            }         

            if(in_array('property_action_category' , $selected_categ)){
                 $args[ 'tax_query' ][]=$action_array;
            }     

            if(in_array('property_city' , $selected_categ)){
                 $args[ 'tax_query' ][]=$city_array;
            }     
        }else{
            $args[ 'tax_query' ][]=$categ_array;
            $args[ 'tax_query' ][]=$action_array;
            $args[ 'tax_query' ][]=$city_array;
        }





        $compare_submit = wpestate_get_template_link('compare_listings.php');
        $my_query = new WP_Query($args);


        if ($my_query->have_posts()) {


            $return_string .= '
        <div class="mylistings">
            <h3 class="agent_listings_title_similar" >' . $section_title . '</h3>';
            ob_start();
            while ($my_query->have_posts()):$my_query->the_post();
                global $post;
                include( locate_template('templates/property_unit' . $property_card_type_string . '.php') );
            endwhile;
            $temp = ob_get_contents();
            ob_end_clean();
            $return_string .= $temp . '
        </div>';
        } //endif have post



        wp_reset_query();
        wp_reset_postdata();
        return $return_string;
    }

endif;





if (!function_exists('wpestate_sizes_no_format')):

    function wpestate_sizes_no_format($value, $return = 0) {
        $th_separator = wpresidence_get_option('wp_estate_prices_th_separator', '');
        $return = stripslashes(number_format((floatval($value)), 0, '.', $th_separator));
        return $return;
    }

endif;


if (!function_exists('wpestate_half_map_conditions')):

    function wpestate_half_map_conditions($pos_id) {
        $page_template = get_post_meta( $pos_id ,'_wp_page_template', true );
        if (!is_category() && !is_tax() && $page_template == 'property_list_half.php') {
            return true;
        } else if (( is_tax('') ) && wpresidence_get_option('wp_estate_property_list_type', '') == 2) {
            $taxonomy = get_query_var('taxonomy');
            if ($taxonomy == 'property_category_agent' ||
                    $taxonomy == 'property_action_category_agent' ||
                    $taxonomy == 'property_city_agent' ||
                    $taxonomy == 'property_area_agent' ||
                    $taxonomy == 'property_county_state_agent' ||
                    $taxonomy == 'category_agency' ||
                    $taxonomy == 'action_category_agency' ||
                    $taxonomy == 'city_agency' ||
                    $taxonomy == 'area_agency' ||
                    $taxonomy == 'county_state_agency' ||
                    $taxonomy == 'property_category_developer' ||
                    $taxonomy == 'property_action_developer' ||
                    $taxonomy == 'property_city_developer' ||
                    $taxonomy == 'property_area_developer' ||
                    $taxonomy == 'property_county_state_developer'
            ) {
                return false;
            } else {
                return true;
            }
        } else if ($page_template=='advanced_search_results.php' && wpresidence_get_option('wp_estate_property_list_type_adv', '') == 2) {
            return true;
        } else {
            return false;
        }
    }

endif;
//////////////////////////////////////////////////////////////////////////////////////
// show price bookign for invoice - 1 currency only
///////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_show_price_booking_for_invoice')):

    function wpestate_show_price_booking_for_invoice($price, $wpestate_currency, $where_currency, $has_data = 0, $return = 0) {


        $price_label = '';
        $th_separator = wpresidence_get_option('wp_estate_prices_th_separator', '');
        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');


        if ($price != 0) {
            $price = floatval($price);
            $price = number_format(($price), 2, '.', $th_separator);
            if ($has_data == 1) {
                $price = '<span class="inv_data_value">' . $price . '</span>';
            }

            if ($where_currency == 'before') {
                $price = $wpestate_currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $wpestate_currency;
            }
        } else {
            $price = '';
        }



        if ($return == 0) {
            print trim($price . ' ' . $price_label);
        } else {
            return trim($price . ' ' . $price_label);
        }
    }

endif;


if (!function_exists('wpestate_show_price_custom_invoice')):

    function wpestate_show_price_custom_invoice($price) {
        $price_label = '';
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_submission_curency', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $th_separator = wpresidence_get_option('wp_estate_prices_th_separator', '');
        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');

        if ($price != 0) {
            $price = number_format($price, 2, '.', $th_separator);

            if ($where_currency == 'before') {
                $price = $wpestate_currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $wpestate_currency;
            }
        } else {
            $price = '';
        }


        return $price . ' ' . $price_label;
    }

endif;

/////////////////////////////////////////////////////////////////////////////////
// datepcker_translate
///////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_date_picker_translation')):

    function wpestate_date_picker_translation($selector) {
        $date_lang_status = esc_html(wpresidence_get_option('wp_estate_date_lang', ''));
        print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                        jQuery("#' . $selector . '").datepicker({
                                dateFormat : "yy-mm-dd"
                        },jQuery.datepicker.regional["' . $date_lang_status . '"]).datepicker("widget").wrap(\'<div class="ll-skin-melon"/>\');
                });
                //]]>
            </script>';
    }

endif;


if (!function_exists('wpestate_date_picker_translation_return')):

    function wpestate_date_picker_translation_return($selector) {
        $date_lang_status = esc_html(wpresidence_get_option('wp_estate_date_lang', ''));
        return '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                        jQuery("#' . $selector . '").datepicker({
                                dateFormat : "yy-mm-dd",
                                changeMonth: true,
                                changeYear: true,
                                yearRange: "-100:+50",
                        },jQuery.datepicker.regional["' . $date_lang_status . '"]).datepicker("widget").wrap(\'<div class="ll-skin-melon"/>\');
                });
                //]]>
            </script>';
    }

endif;


/**
 *  Format price of property
 *
 * 
 *
 *
 */
if (!function_exists('wpestate_format_number_price')):

    function wpestate_format_number_price($price, $th_separator) {
        $price = floatval($price);
        $decimal_points       =  intval(  wpresidence_get_option('wp_estate_prices_decimal_poins','') );
        $decimal_separator    =  esc_html(  wpresidence_get_option('wp_estate_prices_decimal_poins_separator','') );
        
        $use_short_price= wpresidence_get_option('wp_estate_use_short_like_price','');
         
           



        $indian_format = esc_html(wpresidence_get_option('wp_estate_price_indian_format', ''));
        if ($indian_format == 'yes') {
            if($use_short_price=='no'){
                $price = wpestate_moneyFormatIndia($price);
            }else{
                $price = wpestate_moneyFormatIndia_short($price);
            }
        } else {
            if($use_short_price=='no'){
                if ($price == intval($price)) {
                    $price = number_format($price, 0, '.', $th_separator);
                } else {
                    $price = number_format($price, $decimal_points,  $decimal_separator , $th_separator);
                }
                
            }else{
               
                $price= wpestate_price_short_converter($price);
            }
        }

        return $price;
    }

endif;

/**
 *
 * Function to convert price in indian format
 *
 *
 *
 */
function wpestate_moneyFormatIndia($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

/**
 *
 * Function to convert price in indian format - short price
 *
 *
 *
 */
function wpestate_moneyFormatIndia_short($number) {
 
    if($number == 0) {
        return ' ';
    }else {
        $number_length =  strlen($number); 
        switch ($number_length) {
            case 3:
                $val = $number/100;
                $val = round($val, 2);
                $finalval =  $val ." hundred";
                break;
            case 4:
                $val = $number/1000;
                $val = round($val, 2);
                $finalval =  $val ." thousand";
                break;
            case 5:
                $val = $number/1000;
                $val = round($val, 2);
                $finalval =  $val ." thousand";
                break;
            case 6:
                $val = $number/100000;
                $val = round($val, 2);
                $finalval =  $val ." lakh";
                break;
            case 7:
                $val = $number/100000;
                $val = round($val, 2);
                $finalval =  $val ." lakh";
                break;
            case 8:
                $val = $number/10000000;
                $val = round($val, 2);
                $finalval =  $val ." crore";
                break;
            case 9:
                $val = $number/10000000;
                $val = round($val, 2);
                $finalval =  $val ." crore";
                break;
            default:
                $val = $number/10000000;
                $val = round($val, 2);
                $finalval =  $val ." crore";
                break;
        }
        return $finalval;
    }
}







/**
 *
 * FUnction to display price all over the tempalte
 *
 *
 *
 */
if (!function_exists('wpestate_show_price')):

    function wpestate_show_price($post_id, $wpestate_currency, $where_currency, $return = 0,$second="no") {

        $price_label = '<span class="price_label">' . esc_html(get_post_meta($post_id, 'property_label', true)) . '</span>';
        $price_label_before = get_post_meta($post_id, 'property_label_before', true);
        if ($price_label_before != '') {
            $price_label_before = '<span class="price_label price_label_before">' . esc_html($price_label_before) . '</span>';
        }
        $price = floatval(get_post_meta($post_id, 'property_price', true));


        if($second=='yes'){
            $price_label = '<span class="price_label">' . esc_html(get_post_meta($post_id, 'property_second_price_label', true)) . '</span>';
            $price_label_before = get_post_meta($post_id, 'property_label_before_second_price', true);
            if ($price_label_before != '') {
                $price_label_before = '<span class="price_label price_label_before">' . esc_html($price_label_before) . '</span>';
            }
            $price = floatval(get_post_meta($post_id, 'property_second_price', true));
        }



        $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');

        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($price != 0) {

                $price = $price * $custom_fields[$i][2];
                $price = wpestate_format_number_price($price, $th_separator);
                $wpestate_currency = $custom_fields[$i][0];

                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            if ($price != 0) {
                $price = wpestate_format_number_price($price, $th_separator);
                if ($where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }



        if ($return == 0) {
            print trim($price_label_before . ' ' . $price . ' ' . $price_label);
        } else {
            return trim($price_label_before . ' ' . $price . ' ' . $price_label);
        }
    }

endif;

/**
 *
 * 
 *
 *
 *
 */

if (!function_exists('wpestate_show_price_from_all_details')):

    function wpestate_show_price_from_all_details($post_id,$wpestate_currency, $where_currency, $return = 0, $wpestate_prop_all_details = '',$second='no') {

        $price_label            =   get_post_meta($post_id, 'property_label', true) ;
        $price_label_before     =   get_post_meta($post_id, 'property_label_before', true) ;
        $price              =  floatval(get_post_meta($post_id, 'property_price', true));
    
        if($second=='yes'){
            $price_label            = get_post_meta($post_id, 'property_second_price_label', true);
            $price_label_before     = get_post_meta($post_id, 'property_label_before_second_price', true);
            $price = floatval(get_post_meta($post_id, 'property_second_price', true));
        }


        $price_label = '<span class="price_label">' . esc_html($price_label) . '</span>';

        if ($price_label_before != '') {
            $price_label_before = '<span class="price_label price_label_before">' . esc_html($price_label_before) . '</span>';
        }


        $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');

        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($price != 0) {
                $price = $price * $custom_fields[$i][2];
                $price = wpestate_format_number_price($price, $th_separator);

                $wpestate_currency = $custom_fields[$i][0];

                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            if ($price != 0) {

                $price = wpestate_format_number_price($price, $th_separator);

                if ($where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }



        if ($return == 0) {
            print trim($price_label_before . ' ' . $price . ' ' . $price_label);
        } else {
            return trim($price_label_before . ' ' . $price . ' ' . $price_label);
        }
    }

endif;


/**
 *
 * Function to display price in floor plans
 *
 *
 *
 */
if (!function_exists('wpestate_show_price_floor')):

    function wpestate_show_price_floor($price, $wpestate_currency, $where_currency, $return = 0) {



        $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
        $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');


        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($price != 0) {

                $price = $price * $custom_fields[$i][2];


                $price = wpestate_format_number_price($price, $th_separator);
                $wpestate_currency = $custom_fields[$i][0];

                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            if ($price != 0) {
                $price = wpestate_format_number_price($price, $th_separator);

                if ($where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }

        if ($return == 0) {
            print trim($price);
        } else {
            return trim($price);
        }
    }

endif;


if (!function_exists('wpestate_virtual_tour_details')):

    function wpestate_virtual_tour_details($post_id) {
        print get_post_meta($post_id, 'embed_virtual_tour', true);
    }

endif;

/////////////////////////////////////////////////////////////////////////////////
// walscore api
///////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_walkscore_details')):

    function wpestate_walkscore_details($post_id, $wpestate_prop_all_details = '') {
        $walkscore_api = esc_html(wpresidence_get_option('wp_estate_walkscore_api', ''));

        $property_city      =   get_the_term_list($post_id, 'property_city', '', ', ', '');
        $property_state     =   get_the_term_list($post_id, 'property_county_state', '', ', ', '');
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if (preg_match_all("/$regexp/siU", $property_city, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $property_city = $match[3];
            }
        }
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if (preg_match_all("/$regexp/siU", $property_state, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $property_state = $match[3];
            }
        }


        $property_address   =   esc_html(get_post_meta($post_id, 'property_address', true));
        $property_zip       =   esc_html(get_post_meta($post_id, 'property_zip', true));
        $property_location  =   $property_address.','.$property_zip.','.$property_city.','.$property_state;
        
        print '<div id="ws-walkscore-tile"></div>';
        $walkscore_data = "var ws_wsid    = '" . esc_html( $walkscore_api  ) . "';
        var ws_address = '" . esc_html( $property_location ) . "';
        var ws_format  = 'wide';
        var ws_width   = '650';
        var ws_width   = '100%';
        var ws_height  = '400';";
        wp_enqueue_script( 'wpestate-walkscore', 'https://www.walkscore.com/tile/show-walkscore-tile.php', array(), null, true );
        wp_add_inline_script( 'wpestate-walkscore', $walkscore_data, 'before' );




    }

endif;




/////////////////////////////////////////////////////////////////////////////////
// order by filter featured
///////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_measure_unit')):

    function wpestate_get_measure_unit() {
        $measure_sys = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));

        if ($measure_sys == 'feet') {
            return 'ft<sup>2</sup>';
        } else {
            return 'm<sup>2</sup>';
        }
    }

endif;


////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination
/////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_pagination')):

    function wpestate_pagination($pages = '', $range = 2) {

        $showitems = ($range * 2) + 1;
        global $paged;
        if (empty($paged))
            $paged = 1;


        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages && $pages != 0) {
            print '<ul class="pagination pagination_nojax">';
            print "<li class=\"roundleft\"><a href='" . get_pagenum_link($paged - 1) . "'><i class=\"fas fa-angle-left\"></i></a></li>";

            $last_page = get_pagenum_link($pages);
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    if ($paged == $i) {
                        print '<li class="active"><a href="' . esc_url(get_pagenum_link($i)) . '" >' . $i . '</a><li>';
                    } else {
                        print '<li><a href="' . esc_url(get_pagenum_link($i)) . '" >' . $i . '</a><li>';
                    }
                }
            }

            $prev_page = get_pagenum_link($paged + 1);
            if (($paged + 1) > $pages) {
                $prev_page = get_pagenum_link($paged);
            } else {
                $prev_page = get_pagenum_link($paged + 1);
            }


            print "<li class=\"roundright\"><a href='" . $prev_page . "'><i class=\"fas fa-angle-right\"></i></a><li>";

            print "<li class=\"roundright\"><a href='" . $last_page . "'><i class=\"fa fa-angle-double-right\"></i></a><li>";

            print "</ul>";
        }
    }

endif; // end   wpestate_pagination
////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination Ajax
/////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_pagination_agent')):

    function wpestate_pagination_agent($pages = '', $range = 2) {

        $showitems = ($range * 2) + 1;
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        if (empty($paged))
            $paged = 1;

        if (1 != $pages && $pages != 0) {
            $prev_pagex = str_replace('page/', '', get_pagenum_link($paged - 1));
            print '<ul class="pagination pagination_nojax">';
            print "<li class=\"roundleft\"><a href='" . $prev_pagex . "'><i class=\"fas fa-angle-left\"></i></a></li>";
            $last_page = get_pagenum_link($pages);
            for ($i = 1; $i <= $pages; $i++) {
                $cur_page = str_replace('page/', '', get_pagenum_link($i));
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    if ($paged == $i) {
                        print '<li class="active"><a href="' . esc_url($cur_page) . '" >' . $i . '</a><li>';
                    } else {
                        print '<li><a href="' . esc_url($cur_page) . '" >' . $i . '</a><li>';
                    }
                }
            }

            $prev_page = str_replace('page/', '', get_pagenum_link($paged + 1));
            if (($paged + 1) > $pages) {
                $prev_page = str_replace('page/', '', get_pagenum_link($paged));
            } else {
                $prev_page = str_replace('page/', '', get_pagenum_link($paged + 1));
            }


            print "<li class=\"roundright\"><a href='" . $prev_page . "'><i class=\"fas fa-angle-right\"></i></a><li>";
            print "<li class=\"roundright\"><a href='" . $last_page . "'><i class=\"fa fa-angle-double-right\"></i></a><li>";
            print "</ul>";
        }
    }

endif; // end   wpestate_pagination
////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination Custom
/////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_pagination_ajax_newver')):

    function wpestate_pagination_ajax_newver($pages, $range, $paged, $where, $order) {
        $showitems = ($range * 2) + 1;

        if (1 != $pages && $pages != 0) {
            print '<ul class="pagination c ' . $where . '">';
            if ($paged != 1) {
                $prev_page = $paged - 1;
            } else {
                $prev_page = 1;
            }

            $prev_link = get_pagenum_link($paged - 1);
            $prev_link = add_query_arg('order', $order, $prev_link);
            $last_page = get_pagenum_link($pages);
            $last_page = add_query_arg('order', $order, $last_page);
            print "<li class=\"roundleft\"><a href='" . $prev_link . "' data-future='" . esc_attr($prev_page) . "'><i class=\"fas fa-angle-left\"></i></a></li>";

            for ($i = 1; $i <= $pages; $i++) {
                $page_link = get_pagenum_link($i);
                $page_link = add_query_arg('order', $order, $page_link);
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    if ($paged == $i) {
                        print '<li class="active"><a href="' . esc_url($page_link) . '" data-future="' . esc_attr($i) . '">' . esc_html($i) . '</a><li>';
                    } else {
                        print '<li><a href="' . esc_url($page_link) . '" data-future="' . esc_attr($i) . '">' . esc_html($i) . '</a><li>';
                    }
                }
            }

            $next_page = get_pagenum_link($paged + 1);
            if (($paged + 1) > $pages) {
                $next_page = get_pagenum_link($paged);
                $next_page = add_query_arg('order', $order, $next_page);
                print "<li class=\"roundright\"><a href='" . esc_url($next_page) . "' data-future='" . esc_attr($paged) . "'><i class=\"fas fa-angle-right\"></i></a><li>";
            } else {
                $next_page = get_pagenum_link($paged + 1);
                $next_page = add_query_arg('order', $order, $next_page);
                print "<li class=\"roundright\"><a href='" . esc_url($next_page) . "' data-future='" . esc_attr($paged + 1) . "'><i class=\"fas fa-angle-right\"></i></a><li>";
            }
            print "<li class=\"roundright\"><a href='" . $last_page . "'  data-future='" . esc_attr( $pages ) . "' ><i class=\"fa fa-angle-double-right\"></i></a><li>";
            print "</ul>\n";
        }
    }

endif; // end   wpestate_pagination

if (!function_exists('wpestate_pagination_ajax')):

    function wpestate_pagination_ajax($pages, $range, $paged, $where) {
        $showitems = ($range * 2) + 1;

        if (1 != $pages && $pages != 0) {
            print '<ul class="pagination c ' . $where . '">';
            if ($paged != 1) {
                $prev_page = $paged - 1;
            } else {
                $prev_page = 1;
            }
            print "<li class=\"roundleft\"><a href='" . esc_url(get_pagenum_link($paged - 1)) . "' data-future='" . esc_attr($prev_page) . "'><i class=\"fas fa-angle-left\"></i></a></li>";
            $last_page = get_pagenum_link($pages);
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    if ($paged == $i) {
                        print '<li class="active"><a href="' . esc_url(get_pagenum_link($i)) . '" data-future="' . esc_attr($i) . '">' . esc_html($i) . '</a><li>';
                    } else {
                        print '<li><a href="' . esc_url(get_pagenum_link($i)) . '" data-future="' . esc_attr($i) . '">' . esc_html($i) . '</a><li>';
                    }
                }
            }

            $prev_page = get_pagenum_link($paged + 1);
            if (($paged + 1) > $pages) {
                $prev_page = get_pagenum_link($paged);
                print "<li class=\"roundright\"><a href='" . esc_url($prev_page) . "' data-future='" . esc_attr($paged) . "'><i class=\"fas fa-angle-right\"></i></a><li>";
            } else {
                $prev_page = get_pagenum_link($paged + 1);
                print "<li class=\"roundright\"><a href='" . esc_url($prev_page) . "' data-future='" . esc_attr($paged + 1) . "'><i class=\"fas fa-angle-right\"></i></a><li>";
            }

            print "<li class=\"roundright\"><a data-future='".esc_attr($pages)."' href='" . $last_page . "'><i class=\"fa fa-angle-double-right\"></i></a><li>";

            print "</ul>\n";
        }
    }

endif; // end   wpestate_pagination
////////////////////////////////////////////////////////////////////////////////
/// force html5 validation -remove category list rel atttribute
////////////////////////////////////////////////////////////////////////////////

add_filter('wp_list_categories', 'wpestate_remove_category_list_rel');
add_filter('the_category', 'wpestate_remove_category_list_rel');

if (!function_exists('wpestate_remove_category_list_rel')):

    function wpestate_remove_category_list_rel($output) {
        // Remove rel attribute from the category list
        return str_replace(' rel="category tag"', '', $output);
    }

endif; // end   wpestate_remove_category_list_rel
////////////////////////////////////////////////////////////////////////////////
/// avatar url
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_avatar_url')):

    function wpestate_get_avatar_url($get_avatar) {
        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        return $matches[1];
    }

endif; // end   wpestate_get_avatar_url
////////////////////////////////////////////////////////////////////////////////
///  get current map height
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_current_map_height')):

    function wpestate_get_current_map_height($post_id) {

        if ($post_id == '' || is_home()) {
            $min_height = intval(wpresidence_get_option('wp_estate_min_height', ''));
        } else {
            $min_height = intval((get_post_meta($post_id, 'min_height', true)));
            if ($min_height == 0) {
                $min_height = intval(wpresidence_get_option('wp_estate_min_height', ''));
            }
        }
        return $min_height;
    }

endif; // end   wpestate_get_current_map_height
////////////////////////////////////////////////////////////////////////////////
///  get  map open height
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('get_map_open_height')):

    function wpestate_get_map_open_height($post_id) {

        if ($post_id == '' || is_home()) {
            $max_height = intval(wpresidence_get_option('wp_estate_max_height', ''));
        } else {
            $max_height = intval((get_post_meta($post_id, 'max_height', true)));
            if ($max_height == 0) {
                $max_height = intval(wpresidence_get_option('wp_estate_max_height', ''));
            }
        }

        return $max_height;
    }

endif; // end   get_map_open_height
////////////////////////////////////////////////////////////////////////////////
///  get  map open/close status
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_map_open_close_status')):

    function wpestate_get_map_open_close_status($post_id) {
        if ($post_id == '' || is_home()) {
            $keep_min = esc_html(wpresidence_get_option('wp_estate_keep_min', ''));
        } else {
            $keep_min = esc_html((get_post_meta($post_id, 'keep_min', true)));
        }

        if ($keep_min == 'yes') {
            $keep_min = 1; // map is forced at closed
        } else {
            $keep_min = 0; // map is free for resize
        }

        return $keep_min;
    }

endif; // end   wpestate_get_map_open_close_status
////////////////////////////////////////////////////////////////////////////////
///  get  map  longitude
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_get_page_long')):

    function wpestate_get_page_long($post_id) {
        $header_type = get_post_meta($post_id, 'header_type', true);
        if ($header_type == 5) {
            $page_long = esc_html(get_post_meta($post_id, 'page_custom_long', true));
        } else {
            $page_long = esc_html(wpresidence_get_option('wp_estate_general_longitude', ''));
        }
        return $page_long;
    }

endif; // end   wpestate_get_page_long
////////////////////////////////////////////////////////////////////////////////
///  get  map  lattitudine
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_page_lat')):

    function wpestate_get_page_lat($post_id) {
        $header_type = get_post_meta($post_id, 'header_type', true);
        if ($header_type == 5) {
            $page_lat = esc_html(get_post_meta($post_id, 'page_custom_lat', true));
        } else {
            $page_lat = esc_html(wpresidence_get_option('wp_estate_general_latitude', ''));
        }
        return $page_lat;
    }

endif; // end   wpestate_get_page_lat
////////////////////////////////////////////////////////////////////////////////
///  get  map  zoom
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_page_zoom')):

    function wpestate_get_page_zoom($post_id) {
        $header_type = get_post_meta($post_id, 'header_type', true);
        if ($header_type == 5) {
            $page_zoom = get_post_meta($post_id, 'page_custom_zoom', true);
        } else {
            $page_zoom = esc_html(wpresidence_get_option('wp_estate_default_map_zoom', ''));
        }
        return $page_zoom;
    }

endif; // end   wpestate_get_page_zoom
///////////////////////////////////////////////////////////////////////////////////////////
// get template link
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_template_link')):

    function wpestate_get_template_link($template_name, $bypass = 0) {
        $transient_name = $template_name;

        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }


        $template_link = wpestate_request_transient_cache('wpestate_get_template_link_' . $transient_name);

        if ($template_link === false || $bypass == 1) {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => $template_name
            ));

            if ($pages) {
                $template_link = esc_url(get_permalink($pages[0]->ID));
            } else {
                $template_link = esc_url(home_url('/'));
            }


            wpestate_set_transient_cache('wpestate_get_template_link_' . $transient_name, $template_link, 60 * 60 * 24);
        }



        return esc_url($template_link);
    }

endif; // end

wpestate_get_template_link('user_dashboard_favorite.php');


///////////////////////////////////////////////////////////////////////////////////////////
// return video divs for sliders
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_custom_vimdeo_video')):

    function wpestate_custom_vimdeo_video($video_id) {
        $protocol = is_ssl() ? 'https' : 'http';
        return $return_string = '
        <div style="max-width:100%;" class="video">
           <iframe id="player_1" src="' . $protocol . '://player.vimeo.com/video/' . $video_id . '?api=1&amp;player_id=player_1"      allowFullScreen></iframe>
        </div>';
    }

endif; // end   wpestate_custom_vimdeo_video


if (!function_exists('wpestate_custom_youtube_video')):

    function wpestate_custom_youtube_video($video_id) {
        $protocol = is_ssl() ? 'https' : 'http';
        return $return_string = '
        <div style="max-width:100%;" class="video">
            <iframe id="player_2" title="YouTube video player" src="' . $protocol . '://www.youtube.com/embed/' . $video_id . '?wmode=transparent&amp;rel=0" allowfullscreen ></iframe>
        </div>';
    }

endif; // end   wpestate_custom_youtube_video


if (!function_exists('wpestate_get_video_thumb')):

    function wpestate_get_video_thumb($post_id) {
        $video_id = esc_html(get_post_meta($post_id, 'embed_video_id', true));
        $video_type = esc_html(get_post_meta($post_id, 'embed_video_type', true));
        $protocol = is_ssl() ? 'https' : 'http';
        if ($video_type == 'vimeo') {
            $hash2 = ( wp_remote_get($protocol . "://vimeo.com/api/v2/video/$video_id.php") );
            $pre_tumb = (unserialize($hash2['body']) );
            $video_thumb = $pre_tumb[0]['thumbnail_medium'];
        } else {
            $video_thumb = $protocol . '://img.youtube.com/vi/' . $video_id . '/0.jpg';
        }
        return $video_thumb;
    }

endif;


if (!function_exists('wpestate_generateRandomString')):

    function wpestate_generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

endif;



///////////////////////////////////////////////////////////////////////////////////////////
/////// Return country list for adv search
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_country_list_adv_search')):

    function wpestate_country_list_adv_search($appendix, $slug) {
        $country_list = wpestate_country_list_search($slug);
        $allowed_html = array();
        if (isset($_GET['advanced_country']) && $_GET['advanced_country'] != '' && $_GET['advanced_country'] != 'all') {
            $advanced_country_value = esc_html(wp_kses($_GET['advanced_country'], $allowed_html));
            $advanced_country_value1 = '';
        } else {
            $advanced_country_value = esc_html__('All Countries', 'wpresidence');
            $advanced_country_value1 = 'all';
        }

        $return_string = wpestate_build_dropdown_adv($appendix, 'adv-search-country', 'advanced_country', $advanced_country_value, $advanced_country_value1, 'advanced_country', $country_list);
        return $return_string;
    }

endif;

///////////////////////////////////////////////////////////////////////////////////////////
/////// Return price form  for adv search
//////////////////////////////
if (!function_exists('wpestate_price_form_adv_search')):

    function wpestate_price_form_adv_search($position, $slug, $label,$fields_visible='') {
        $show_slider_price = wpresidence_get_option('wp_estate_show_slider_price', '');

        if ($position == 'mainform' || $position == 'elementor') {
            $slider_id = 'slider_price';
            $price_low_id = 'price_low';
            $price_max_id = 'price_max';
            $ammount_id = 'amount';
        } else if ($position == 'sidebar') {
            $slider_id = 'slider_price_widget';
            $price_low_id = 'price_low_widget';
            $price_max_id = 'price_max_widget';
            $ammount_id = 'amount_wd';
        } else if ($position == 'shortcode') {
            $slider_id = 'slider_price_sh';
            $price_low_id = 'price_low_sh';
            $price_max_id = 'price_max_sh';
            $ammount_id = 'amount_sh';
        } else if ($position == 'mobile') {
            $slider_id = 'slider_price_mobile';
            $price_low_id = 'price_low_mobile';
            $price_max_id = 'price_max_mobile';
            $ammount_id = 'amount_mobile';
        } else if ($position == 'half') {
            $slider_id = 'slider_price';
            $price_low_id = 'price_low';
            $price_max_id = 'price_max';
            $ammount_id = 'amount';
        }


        if ($show_slider_price === 'yes') {
            $min_price_slider = ( floatval(wpresidence_get_option('wp_estate_show_slider_min_price', '')) );
            $max_price_slider = ( floatval(wpresidence_get_option('wp_estate_show_slider_max_price', '')) );
            $label_value='';

            if (isset($_GET['price_low'])) {
                $min_price_slider = floatval($_GET['price_low']);
            }

            if (isset($_GET['price_low'])) {
                $max_price_slider = floatval($_GET['price_max']);
            }

            if(isset($_GET['price_label_component']) ){
                $label_value=sanitize_text_field( $_GET['price_label_component']);
            }

            $where_currency     = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
            $wpestate_currency  = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
          

            $price_slider_label_data=   wpestate_show_price_label_slider_v2($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency);


            $price_slider_label         =   $price_slider_label_data['label'];
            $price_slider_label_min     =   $price_slider_label_data['label_min'];
            $price_slider_label_max     =   $price_slider_label_data['label_max'];


            $return_string = '';
            if ($position == 'half') {
                $return_string .= '<div class="col-md-6 adv_search_slider">';
            } else {
                $return_string .= '<div class="adv_search_slider">';
            }

            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
                $i = intval($_COOKIE['my_custom_curr_pos']);

                if (!isset($_GET['price_low']) && !isset($_GET['price_max'])) {
                    $min_price_slider = $min_price_slider * $custom_fields[$i][2];
                    $max_price_slider = $max_price_slider * $custom_fields[$i][2];
                }
            }



            if(isset($fields_visible) && $fields_visible=='visible'){
                $return_string.='<div class="wpestate_pricev2_component_adv_search_wrapper">
                <input type="text" id="component_'.$price_low_id.'" class="component_adv_search_elementor_price_low price_active wpestate-price-popoup-field-low"   value="'.$price_slider_label_min.'" data-value="'.esc_attr($price_slider_label_min).'" />
                <input type="text" id="component_'.$price_max_id.'" class="component_adv_search_elementor_price_max price_active wpestate-price-popoup-field-max"   value="'.$price_slider_label_max.'" data-value="'.esc_attr($price_slider_label_max).'" />
                </div>
            ';
            }



            $return_string .= '
                    <p>
                        <label>' . esc_html__('Price range:', 'wpresidence') . '</label>
                        <span id="' . esc_attr($ammount_id) . '" class="wpresidence_slider_price"  data-default="'.esc_attr($price_slider_label).'">' . $price_slider_label . '</span>
                    </p>
                    <div id="' . $slider_id . '"></div>';
          
            $return_string .= '
                    <input type="hidden" id="' . $price_low_id . '"  name="price_low"  class="single_price_low" data-value="' . floatval($min_price_slider) . '" value="' . floatval($min_price_slider) . '"/>
                    <input type="hidden" id="' . $price_max_id . '"  name="price_max"  class="single_price_max" data-value="' . floatval($max_price_slider) . '" value="' . floatval($max_price_slider) . '"/>
                    <input type="hidden"  class="price_label_component" name="price_label_component"   value="'.esc_html($label_value).'" />';
              
            $return_string .= '   </div>';
        } else {
            $return_string = '';
            if ($position == 'half') {
                $return_string .= '<div class="col-md-3">';
            }

            $return_string .= '<input type="text" id="' . $slug . '"  name="' . $slug . '" placeholder="' . $label . '" value="';
            if (isset($_GET[$slug])) {
                $allowed_html = array();
                $return_string .= esc_attr($_GET[$slug]);
            }
            $return_string .= '" class="advanced_select form-control" />';

            if ($position == 'half') {
                $return_string .= '</div>';
            }
        }
        return $return_string;
    }
  
    
endif;




/*
*
*
*
*
*/


if (!function_exists('wpestate_return_title_from_slug')):

    function wpestate_return_title_from_slug($get_var, $getval) {
        if ($get_var == 'filter_search_type') {
            if ($getval !== 'All') {
                $taxonomy = "property_category";
                $term = get_term_by('slug', $getval, $taxonomy);
                return $term->name;
            } else {
                return $getval;
            }
        } else if ($get_var == 'filter_search_action') {
            $taxonomy = "property_action_category";
            if ($getval !== 'All') {
                $term = get_term_by('slug', $getval, $taxonomy);
                return $term->name;
            } else {
                return $getval;
            }
        } else if ($get_var == 'advanced_city') {
            $taxonomy = "property_city";
            if ($getval !== 'All') {
                $term = get_term_by('slug', $getval, $taxonomy);
                return $term->name;
            } else {
                return $getval;
            }
        } else if ($get_var == 'advanced_area') {
            $taxonomy = "property_area";
            if ($getval !== 'All') {
                $term = get_term_by('slug', $getval, $taxonomy);
                return $term->name;
            } else {
                return $getval;
            }
        } else if ($get_var == 'advanced_contystate') {
            $taxonomy = "property_county_state";
            if ($getval !== 'All') {
                $term = get_term_by('slug', $getval, $taxonomy);
                return $term->name;
            } else {
                return $getval;
            }
        } else if ($get_var == 'property_status') {
            $taxonomy = "property_status";
            if ($getval !== 'All') {
                $term = get_term_by('slug', $getval, $taxonomy);
                return ucwords($term->name);
            } else {
                return $getval;
            }
        } else {
            return $getval;
        }
    }

;
endif;

///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search fields
///////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_build_dropdown_adv')):

    function wpestate_build_dropdown_adv($appendix, $ul_id, $toogle_id, $values, $values1, $get_var, $select_list, $active = '') {
        $extraclass = '';
        $caret_class = '';
        $wrapper_class = '';
        $return_string = '';
        $is_half = 0;
        $allowed_html = array();

        if ($appendix == '') {
            $extraclass = ' filter_menu_trigger  ';
            $caret_class = ' caret_filter ';
        } else if ($appendix == 'sidebar-') {
            $extraclass = ' sidebar_filter_menu  ';
            $caret_class = ' caret_sidebar ';
        } else if ($appendix == 'shortcode-') {
            $extraclass = ' filter_menu_trigger  ';
            $caret_class = ' caret_filter ';
            $wrapper_class = 'listing_filter_select';
        } else if ($appendix == 'mobile-') {
            $extraclass = ' filter_menu_trigger  ';
            $caret_class = ' caret_filter ';
            $wrapper_class = '';
        } else if ($appendix == 'half-') {
            $extraclass = ' filter_menu_trigger  ';
            $caret_class = ' caret_filter ';
            $wrapper_class = '';
            $return_string = '<div class="col-md-3">';
            $appendix = '';
            $is_half = 1;
        }
        $adv_search_type = wpresidence_get_option('wp_estate_adv_search_type', '');
        if ($adv_search_type == 6) {
            $return_string = '';
        }


        if ($get_var == 'filter_search_type' || $get_var == 'filter_search_action') {
            if (isset($_GET[$get_var]) && trim($_GET[$get_var][0]) != '' && $active != 'noactive') {
                $getval = ucwords(esc_html($_GET[$get_var][0]));
                $real_title = wpestate_return_title_from_slug($get_var, $getval);
                $getval = str_replace('-', ' ', $getval);
                $show_val = $real_title;
                $current_val = $getval;
                $current_val1 = $real_title;
            } else {
                $current_val = $values;
                $show_val = $values;
                $current_val1 = $values1;
            }
        } else {
            $get_var = sanitize_key($get_var);

            if (isset($_GET[$get_var]) && trim($_GET[$get_var]) != '' && $active != 'noactive') {
                $getval = ucwords(esc_html(wp_kses($_GET[$get_var], $allowed_html)));
                $real_title = wpestate_return_title_from_slug($get_var, $getval);
                $getval = str_replace('-', ' ', $getval);
                $current_val = $getval;
                $show_val = $real_title;
                $current_val1 = $real_title;
            } else {
                $current_val = $values;
                $show_val = $values;
                $current_val1 = $values1;
            }
        }


        $return_string .= '<div class="dropdown form-control ' . $wrapper_class . '">
        <div data-toggle="dropdown" id="' . sanitize_key($appendix . $toogle_id) . '" class="' . $extraclass . '" xx maca caca' . $values1 . ' ' . $values . ' data-value="' . ( esc_attr($current_val1) ) . '">';

        if ($get_var == 'filter_search_type' || $get_var == 'filter_search_action' || $get_var == 'advanced_city' || $get_var == 'advanced_area' || $get_var == 'advanced_conty' || $get_var == 'advanced_contystate') {
            if ($show_val == 'All') {
                //sorry for this ugly fix
                if ($get_var == 'filter_search_type') {
                    $return_string .= esc_html__('Categories', 'wpresidence');
                } else if ($get_var == 'filter_search_action') {
                    $return_string .= esc_html__('Types', 'wpresidence');
                } else if ($get_var == 'advanced_city') {
                    $return_string .= esc_html__('Cities', 'wpresidence');
                } else if ($get_var == 'advanced_area') {
                    $return_string .= esc_html__('Areas', 'wpresidence');
                } else if ($get_var == 'advanced_conty') {
                    $return_string .= esc_html__('Types', 'wpresidence');
                } else if ($get_var == 'advanced_contystate') {
                    $return_string .= esc_html__('States', 'wpresidence');
                } else if ($get_var == 'advanced_status') {
                    $return_string .= esc_html__('Property Status', 'wpresidence');
                }
            } else {
                $return_string .= $show_val;
            }
        } else {
            if (function_exists('icl_translate')) {
                $show_val = apply_filters('wpml_translate_single_string', trim($show_val), 'custom field value', 'custom_field_value' . $show_val);
            }
            if ($show_val == 'all' || $show_val == 'All') {
                $return_string .= $values;
            } else {
                $return_string .= $show_val;
            }
        }


        $return_string .= '
            <span class="caret ' . $caret_class . '"></span>
            </div>';


        if ($get_var == 'filter_search_type' || $get_var == 'filter_search_action') {
            $return_string .= ' <input type="hidden" name="' . $get_var . '[]"   value="';
            if (isset($_GET[$get_var][0])) {
                $return_string .= strtolower(esc_attr($_GET[$get_var][0]));
            }
        } else {
            $return_string .= ' <input type="hidden" doithere name="' . sanitize_key($get_var) . '" value="';
            if (isset($_GET[$get_var])) {
                $return_string .= strtolower(esc_attr($_GET[$get_var]));
            }
        }

        $return_string .= '">
                <ul  id="' . $appendix . $ul_id . '" class="dropdown-menu filter_menu" role="menu" aria-labelledby="' . $appendix . $toogle_id . '">
                    ' . $select_list . '
                </ul>
            </div>';

        if ($is_half == 1 && $adv_search_type != 6) {
            $return_string .= '</div>';
        }
        return $return_string;
    }

endif;
















///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search form - custom fileds
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_show_search_field_with_tabs')):

  //                   wpestate_show_search_field($label, $position, $search_field, $action_select_list, $categ_select_list, $select_city_list, $select_area_list, $key, $select_county_state_list, $term_counter_elementor = '', $placeholder = '', $elementor_label = '', $item_field_how = '', $price_array_data = '') {
    function wpestate_show_search_field_with_tabs($label, $active, $position, $search_field, $action_select_list, $categ_select_list, $select_city_list, $select_area_list, $key, $select_county_state_list, $use_name, $term_id, $adv_search_fields_no, $term_counter) {
        $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');
        $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
        $adv_search_how = wpresidence_get_option('wp_estate_adv_search_how', '');
        $adv6_max_price = wpresidence_get_option('wp_estate_adv6_max_price');
        $adv6_min_price = wpresidence_get_option('wp_estate_adv6_min_price');
 
        $adv6_taxonomy_terms = wpresidence_get_option('wp_estate_adv6_taxonomy_terms');

        $adv_search_what = array_slice($adv_search_what, ($term_counter * $adv_search_fields_no), $adv_search_fields_no);
        $adv_search_label = array_slice($adv_search_label, ($term_counter * $adv_search_fields_no), $adv_search_fields_no);
        $adv_search_how = array_slice($adv_search_how, ($term_counter * $adv_search_fields_no), $adv_search_fields_no);


        $allowed_html = array();
        if ($position == 'mainform') {
            $appendix = '';
        } else if ($position == 'sidebar') {
            $appendix = 'sidebar-';
        } else if ($position == 'shortcode') {
            $appendix = 'shortcode-';
        } else if ($position == 'mobile') {
            $appendix = 'mobile-';
        } else if ($position == 'half') {
            $appendix = 'half-';
        }

        $elementor_label='';


        $return_string = '';
        if ($search_field == 'none') {
            $return_string = '';
        } else if ($search_field == 'beds-baths') {

         
          
            $return_string  .=  wpestate_show_beds_baths_component($appendix,$label,$elementor_label, $term_id,$position,$active);

        } else if ($search_field == 'property-price-v2') {
           
            $show_dropdowns = wpresidence_get_option('wp_estate_show_dropdowns', '');
            $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
            $slug = sanitize_key($string);

            $label = $adv_search_label[$key];
            if (function_exists('icl_translate')) {
                $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $label, $label);
            }


          
          $return_string .= wpestate_show_price_v2_component_theme_search($position, $slug, $label, $use_name, $term_id, $adv6_taxonomy_terms, $adv6_min_price, $adv6_max_price,'yes');
        
        
        }else if ($search_field == 'property-price-v3') {
                $show_dropdowns = wpresidence_get_option('wp_estate_show_dropdowns', '');
                $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
                $slug = sanitize_key($string);

                $label = $adv_search_label[$key];
                if (function_exists('icl_translate')) {
                    $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $label, $label);
                }

                $wp_estate_adv6_max_price_dropdown_values= wpresidence_get_option('wp_estate_adv6_max_price_dropdown_values');
                $wp_estate_adv6_min_price_dropdown_values= wpresidence_get_option('wp_estate_adv6_min_price_dropdown_values');
                $price_array_data=array();
                $price_array_data['term_id'] =$term_id;
                $price_key      =   array_search($term_id,$adv6_taxonomy_terms);


                $price_array_data['min_price_values'] =$wp_estate_adv6_min_price_dropdown_values[$price_key];
                $price_array_data['max_price_values'] =$wp_estate_adv6_max_price_dropdown_values[$price_key];

              $return_string .= wpestate_show_price_v3_component($appendix,$slug,$label,$label,$elementor_label, $term_id,$position,$price_array_data);
           
             
        } else if ($search_field == 'geolocation') {
            $return_string .= wpestate_show_geolocation_field($appendix,$label,'', $term_counter,$position);
        } else if ($search_field == 'geolocation_radius') {
            $return_string .= wpestate_show_geolocation_radius_field($appendix,'','', $term_counter);
        } else if ($search_field == 'wpestate location') {
            $return_string .= wpestate_show_location_field($appendix, $term_counter);
        } else if ($search_field == 'property status') {                    
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);
      
        } else if ($search_field == 'types') {

            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);       
       
        } else if ($search_field == 'categories') {
                    
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);
       
       
        } else if ($search_field == 'cities') {
      
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);
        
        
        } else if ($search_field == 'areas') {

                    
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);
        
        
        } else if ($search_field == 'county / state') {
                    
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active);
    
        } else {
            $show_dropdowns = wpresidence_get_option('wp_estate_show_dropdowns', '');
            $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
            $slug = sanitize_key($string);

            $label = $adv_search_label[$key];
            if (function_exists('icl_translate')) {
                $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $label, $label);
            }

            if ($adv_search_what[$key] == 'property country') {
                ////////////////////////////////  show country list
                $return_string = wpestate_country_list_adv_search($appendix, $slug);
            } else if ($adv_search_what[$key] == 'property price') {
                ////////////////////////////////  show price form
                $return_string = wpestate_price_form_adv_search_with_tabs($position, $slug, $label, $use_name, $term_id, $adv6_taxonomy_terms, $adv6_min_price, $adv6_max_price);
            } else if ($show_dropdowns == 'yes' && ( $adv_search_what[$key] == 'property rooms' || $adv_search_what[$key] == 'property bedrooms' || $adv_search_what[$key] == 'property bathrooms')) {
              
                if (function_exists('icl_translate')) {
                    $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $adv_search_label[$key], $adv_search_label[$key]);
                } else {
                    $label = $adv_search_label[$key];
                }

                $rooms_select_list= wpestate_rooms_select_list_simple_dropdown($adv_search_what[$key], '',$label);

                
                $return_string = wpestate_build_dropdown_adv_new($appendix, 'search-' . $slug, $slug, $label, 'all', $slug, $rooms_select_list,$active);
            } else {
                $custom_fields = wpresidence_get_option('wp_estate_custom_fields', '');

                $i = 0;
                $found_dropdown = 0;
                ///////////////////////////////// dropdown check
                if (!empty($custom_fields)) {
                    while ($i < count($custom_fields)) {
                        $name = $custom_fields[$i][0];

                        $slug_drop = str_replace(' ', '-', $name);

                        if ($slug_drop == $adv_search_what[$key] && $custom_fields[$i][2] == 'dropdown') {

                            $found_dropdown = 1;
                            $front_name = sanitize_title($adv_search_label[$key]);
                            if (function_exists('icl_translate')) {
                                $initial_key = apply_filters('wpml_translate_single_string', trim($adv_search_label[$key]), 'custom field value', 'custom_field_value' . $adv_search_label[$key]);
                                $action_select_list = ' <li role="presentation" data-value="all"> ' . $initial_key . '</li>';
                            } else {
                                $action_select_list = ' <li role="presentation" data-value="all">' . $adv_search_label[$key] . '</li>';
                            }

                            $dropdown_values_array = explode(',', $custom_fields[$i][4]);

                            foreach ($dropdown_values_array as $drop_key => $value_drop) {
                                $original_value_drop = $value_drop;
                                if (function_exists('icl_translate')) {

                                    $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop), 'custom field value', 'custom_field_value' . $value_drop);
                                }
                                $action_select_list .= ' <li role="presentation" data-value="' . trim(esc_attr($original_value_drop)) . '">' . trim($value_drop) . '</li>';
                            }
                            $front_name = sanitize_title($adv_search_label[$key]);
                            if (isset($_GET[$front_name]) && $_GET[$front_name] != '' && $_GET[$front_name] != 'all') {
                                $advanced_drop_value = esc_attr(wp_kses($_GET[$front_name], $allowed_html));
                                $advanced_drop_value1 = '';
                            } else {
                                $advanced_drop_value = $label;
                                $advanced_drop_value1 = 'all';
                            }
                            $front_name = wpestate_limit45($front_name);
                            $return_string = wpestate_build_dropdown_adv($appendix, $front_name, $front_name, $advanced_drop_value, $advanced_drop_value1, $front_name, $action_select_list);
                        }
                        $i++;
                    }
                }
                ///////////////////// end dropdown check

                if ($found_dropdown == 0) {
                    //////////////// regular field
                    $return_string = '';
                    if ($position == 'half') {
                        // $return_string.='<div class="col-md-3">';
                        $appendix = '';
                    }

                    if ($adv_search_how[$key] == 'date bigger' || $adv_search_how[$key] == 'date smaller') {
                        $return_string .= '<input type="text" id="' . wp_kses($term_id . $appendix . $slug, $allowed_html) . '"  name="' . wp_kses($slug, $allowed_html) . '" placeholder="' . wp_kses($label, $allowed_html) . '" value="';
                    } else {
                        $return_string .= '<input type="text" id="' . wp_kses($appendix . $slug, $allowed_html) . '"  name="' . wp_kses($slug, $allowed_html) . '" placeholder="' . wp_kses($label, $allowed_html) . '" value="';
                    }

                    if (isset($_GET[$slug])) {
                        $return_string .= esc_attr($_GET[$slug]);
                    }
                    $return_string .= '" class="advanced_select form-control" />';

                    if ($position == 'half') {
                        //   $return_string.='</div>';
                    }
                    ////////////////// apply datepicker if is the case
                    if ($adv_search_how[$key] == 'date bigger' || $adv_search_how[$key] == 'date smaller') {
                        wpestate_date_picker_translation($term_id . $appendix . $slug);
                    }
                }
            }
        }
        print trim($return_string);
    }

endif; //






function wpestate_rooms_select_list_simple_dropdown($element,$search_field,$label){
  
    if($element === 'property rooms' || $search_field==='property rooms' ){
        $option='wp_estate_rooms_component_values';
    }else if( $element === 'property bedrooms'   || $search_field==='property bedrooms' ){
        $option='wp_estate_beds_component_values';
    }else if($element === 'property bathrooms'   || $search_field==='property bathrooms' ){
        $option='wp_estate_baths_component_values';
    }

    $component_values     = wpresidence_get_option($option, '');
    $component_values_array = explode(',', $component_values);



    $rooms_select_list = ' <li role="presentation" data-value="all">' . $label . '</li>';
    foreach($component_values_array as $key=>$value){
        $rooms_select_list .= '<li data-value="' . floatval($value) . '"  value="' . floatval($value) . '">' . esc_html($value) . '</li>';
    }

    return $rooms_select_list;



}











if (!function_exists('wpestate_show_search_field_tab_inject')):

    function wpestate_show_search_field_tab_inject($label, $position, $search_field, $action_select_list, $categ_select_list, $select_city_list, $select_area_list, $key, $select_county_state_list) {
        $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');
        $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
        $adv_search_how = wpresidence_get_option('wp_estate_adv_search_how', '');
        $allowed_html = array();
        if ($position == 'mainform') {
            $appendix = '';
        } else if ($position == 'sidebar') {
            $appendix = 'sidebar-';
        } else if ($position == 'shortcode') {
            $appendix = 'shortcode-';
        } else if ($position == 'mobile') {
            $appendix = 'mobile-';
        } else if ($position == 'half') {
            $appendix = 'half-';
        }

        $return_string = '';
        if ($search_field == 'none') {
            $return_string = '';
        } else if ($search_field == 'property status') {

            if (isset($_GET['property_status'][0]) && $_GET['property_status'] != '' && $_GET['property_status'] != 'all') {
                $full_name = get_term_by('slug', ( ( $_GET['property_status'][0] )), 'property_status');
                $adv_actions_value = $adv_actions_value1 = $full_name->name;
            } else {

                $adv_actions_value = $label;
                if ($label == '') {
                    $adv_actions_value = esc_html__('Property Status', 'wpresidence');
                }
                $adv_actions_value1 = 'all';
            }

            $status_select_list = wpestate_get_status_select_list(wpestate_get_select_arguments());
            $return_string .= wpestate_build_dropdown_adv_new($appendix, 'statuslist', 'adv_status', $adv_actions_value, $adv_actions_value1, 'property_status', $status_select_list);
        } else if ($search_field == 'types') {

            if (isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0] != '' && $_GET['filter_search_action'][0] != 'all') {
                $full_name = get_term_by('slug', ( ( $_GET['filter_search_action'][0] )), 'property_action_category');
                $adv_actions_value = $adv_actions_value1 = $full_name->name;
            } else {

                $adv_actions_value = $label;
                if ($label == '') {
                    $adv_actions_value = esc_html__('Types', 'wpresidence');
                }
                $adv_actions_value1 = 'all';
            }

            $return_string .= wpestate_build_dropdown_adv_new($appendix, 'actionslist', 'adv_actions', $adv_actions_value, $adv_actions_value1, 'filter_search_action', $action_select_list);
        } else if ($search_field == 'categories') {

            if (isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0] != '' && $_GET['filter_search_type'][0] != 'all') {
                $full_name = get_term_by('slug', esc_html(wp_kses($_GET['filter_search_type'][0], $allowed_html)), 'property_category');
                $adv_categ_value = $adv_categ_value1 = $full_name->name;
            } else {

                $adv_categ_value = $label;
                if ($label == '') {
                    $adv_categ_value = esc_html__('Categories', 'wpresidence');
                }
                $adv_categ_value1 = 'all';
            }
            $return_string = wpestate_build_dropdown_adv_new($appendix, 'categlist', 'adv_categ', $adv_categ_value, $adv_categ_value1, 'filter_search_type', $categ_select_list);
        } else if ($search_field == 'cities') {

            if (isset($_GET['advanced_city']) && $_GET['advanced_city'] != '' && $_GET['advanced_city'] != 'all') {
                $full_name = get_term_by('slug', esc_html(wp_kses($_GET['advanced_city'], $allowed_html)), 'property_city');
                $advanced_city_value = $advanced_city_value1 = $full_name->name;
            } else {

                $advanced_city_value = $label;
                if ($label == '') {
                    $advanced_city_value = esc_html__('Cities', 'wpresidence');
                }
                $advanced_city_value1 = 'all';
            }
            $return_string = wpestate_build_dropdown_adv_new($appendix, 'adv-search-city', 'advanced_city', $advanced_city_value, $advanced_city_value1, 'advanced_city', $select_city_list);
        } else if ($search_field == 'areas') {

            if (isset($_GET['advanced_area']) && $_GET['advanced_area'] != '' && $_GET['advanced_area'] != 'all') {
                $full_name = get_term_by('slug', esc_html(wp_kses($_GET['advanced_area'], $allowed_html)), 'property_area');
                $advanced_area_value = $advanced_area_value1 = $full_name->name;
            } else {

                $advanced_area_value = $label;
                if ($label == '') {
                    $advanced_area_value = esc_html__('Areas', 'wpresidence');
                }
                $advanced_area_value1 = 'all';
            }
            $return_string = wpestate_build_dropdown_adv_new($appendix, 'adv-search-area', 'advanced_area', $advanced_area_value, $advanced_area_value1, 'advanced_area', $select_area_list);
        } else if ($search_field == 'county / state') {

            if (isset($_GET['advanced_contystate']) && $_GET['advanced_contystate'] != '' && $_GET['advanced_contystate'] != 'all') {
                $full_name = get_term_by('slug', esc_html(wp_kses($_GET['advanced_contystate'], $allowed_html)), 'property_county_state');
                $advanced_county_value = $advanced_county_value1 = $full_name->name;
            } else {

                $advanced_county_value = $label;
                if ($label == '') {
                    $advanced_county_value = esc_html__('States', 'wpresidence');
                }
                $advanced_county_value1 = 'all';
            }
            $return_string = wpestate_build_dropdown_adv_new($appendix, 'adv-search-countystate', 'county-state', $advanced_county_value, $advanced_county_value1, 'advanced_contystate', $select_county_state_list);
        }
        print trim($return_string);
    }

endif; //









if (!function_exists('wpestate_show_search_field')):

    function wpestate_show_search_field($label, $position, $search_field, $action_select_list, $categ_select_list, $select_city_list, $select_area_list, $key, $select_county_state_list, $term_counter_elementor = '', $placeholder = '', $elementor_label = '', $item_field_how = '', $price_array_data = '') {
        $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');
        $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
        $adv_search_how = wpresidence_get_option('wp_estate_adv_search_how', '');
        $allowed_html = array();
        $args                       =   wpestate_get_select_arguments();
        $position_appendix_map = [
            'mainform'   => '',
            'sidebar'    => 'sidebar-',
            'shortcode'  => 'shortcode-',
            'mobile'     => 'mobile-',
            'half'       => 'half-',
        ];
        
        $appendix = isset($position_appendix_map[$position]) ? $position_appendix_map[$position] : '';
        



        $return_string = '';
        if ($search_field == 'none') {
            $return_string = '';
        } else if ($search_field == 'beds-baths') {
            $return_string .= wpestate_show_beds_baths_component($appendix,$placeholder,$elementor_label, $term_counter_elementor,$position,'active');
        } else if ($search_field == 'property-price-v2') {
            $string = '';
            if ($placeholder != '') {
                $string = wpestate_limit45(sanitize_title($elementor_label)); //is elementor
                $label = $placeholder;
            } else {
                if (isset($adv_search_label[$key])) {
                    $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
                    $label = $adv_search_label[$key];
                }
            }
            $slug = sanitize_key($string);
            $return_string .= wpestate_show_price_v2_component($appendix,$slug,$label,$placeholder,$elementor_label, $term_counter_elementor,$position,$price_array_data);
        
        }else if ($search_field == 'property-price-v3') {
                $string = '';
                if ($placeholder != '') {
                    $string = wpestate_limit45(sanitize_title($elementor_label)); //is elementor
                    $label = $placeholder;
                } else {
                    if (isset($adv_search_label[$key])) {
                        $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
                        $label = $adv_search_label[$key];
                    }
                }
                $slug = sanitize_key($string);
                $price_array_data=array();
                $price_array_data['min_price_values']      =   wpresidence_get_option('wp_estate_min_price_dropdown_values','');
                $price_array_data['max_price_values']      =    wpresidence_get_option('wp_estate_max_price_dropdown_values','');


                $return_string .= wpestate_show_price_v3_component($appendix,$slug,$label,$placeholder,$elementor_label, $term_counter_elementor,$position,$price_array_data);
           
        
        } else if ($search_field == 'geolocation') {
            $return_string .= wpestate_show_geolocation_field($appendix,$placeholder,$elementor_label, $term_counter_elementor,$position);
        } else if ($search_field == 'geolocation_radius') {
            $return_string .= wpestate_show_geolocation_radius_field($appendix,$placeholder,$elementor_label, $term_counter_elementor);
        } else if ($search_field == 'wpestate location') {
            $return_string .= wpestate_show_location_field($appendix, $term_counter_elementor);
        } else if ($search_field == 'property status') {
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');
        } else if ($search_field == 'types') {
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');
        } else if ($search_field == 'categories') {
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');
        } else if ($search_field == 'cities') {
             $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');
        } else if ($search_field == 'areas') {
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');

        } else if ($search_field == 'county / state') {
            $return_string .= wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,'active');

        } else {

            $show_dropdowns = wpresidence_get_option('wp_estate_show_dropdowns', '');
            $string = '';
            if ($placeholder != '') {
                $string = wpestate_limit45(sanitize_title($elementor_label)); //is elementor
                $label = $placeholder;
            } else {
                if (isset($adv_search_label[$key])) {
                    $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
                    $label = $adv_search_label[$key];
                }
            }
            $slug = sanitize_key($string);


            if (function_exists('icl_translate')) {
                $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $label, $label);
                if ($placeholder != '') {
                    $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $placeholder, $placeholder); // from elementor
                }
            }

            $adv_search_what_key = '';
            if (isset($adv_search_what['key'])) {
                $adv_search_what_key = $adv_search_what[$key];
            }


            if ($adv_search_what_key == 'property country' || $search_field == 'property country') {
                ////////////////////////////////  show country list
                $return_string = wpestate_country_list_adv_search($appendix, $slug);
            } else if ($adv_search_what_key == 'property price' || $search_field == 'property price') {
                ////////////////////////////////  show price form
                $return_string = wpestate_price_form_adv_search($position, $slug, $label);

                if ( is_array($price_array_data) && isset( $price_array_data['term_id'] ) ) {
                 
                    $return_string = wpestate_price_form_adv_search_with_tabs_elementor($position, $slug, $label, '', $price_array_data['term_id'], $price_array_data['term_slug'], $price_array_data['min_price'], $price_array_data['max_price']);
                } else {
            
                    $return_string = wpestate_price_form_adv_search($position, $slug, $label);
                }
            } else if ($show_dropdowns == 'yes' && ( $adv_search_what_key == 'property rooms' || $search_field == 'property rooms' || $adv_search_what_key == 'property bedrooms' || $search_field == 'property bedrooms' || $adv_search_what_key == 'property bathrooms' || $search_field == 'property bathrooms')) {
                $i = 0;
                if (function_exists('icl_translate')) {
                    $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $adv_search_label[$key], $adv_search_label[$key]);
                    if ($placeholder != '') {
                        $label = icl_translate('wpestate', 'wp_estate_custom_search_' . $placeholder, $placeholder); // from elementor
                    }
                } else {
                    $label='';
                    if(isset($adv_search_label[$key])){
                        $label = $adv_search_label[$key];
                    }
                    if ($placeholder != '') {
                        $label = $placeholder; // from elementor
                    }
                }
                $rooms_select_list= wpestate_rooms_select_list_simple_dropdown($adv_search_what_key,$search_field, $label);

                $return_string = wpestate_build_dropdown_adv($appendix, 'search-' . $slug, $slug, $label, 'all', $slug, $rooms_select_list);
            } else {
                $return_string=wpestate_search_generate_custom_field( $adv_search_what_key, $search_field,$label, $adv_search_label, $placeholder, $position, $slug, $allowed_html, $appendix, $item_field_how, $elementor_label,$key);
                
            }
        }
        print trim($return_string);
    }

endif;








if (!function_exists('show_extended_search')):

    function show_extended_search($tip, $usename = '') {
        print '<div class="adv_extended_options_text" id="adv_extended_options_text_' . $tip . '">' . esc_html__('More Search Options', 'wpresidence') . '</div>';
        print '<div class="extended_search_check_wrapper">';
        print '<span id="adv_extended_close_' . $tip . '" class="adv_extended_close_button" ><i class="fas fa-times"></i></span>';

        $advanced_exteded = wpresidence_get_option('wp_estate_advanced_exteded', '');
        $featured_terms = wpresidence_redux_advanced_exteded();


        if (is_array($advanced_exteded)):
            foreach ($advanced_exteded as $slug) {
                if (isset($featured_terms[$slug])) {
                    $input_name = str_replace('%', '', $slug);
                    $item_title = $featured_terms[$slug];

                    if ($slug != 'none') {
                        $check_selected = '';
                        if (isset($_GET[$input_name]) && $_GET[$input_name] == '1') {
                            $check_selected = ' checked ';
                        }
                        print

                                '<div class="extended_search_checker">
                                <input type="checkbox" id="' . $input_name . $tip . $usename . '" name="' . $input_name . '" name-title="' . $item_title . '" value="1" ' . $check_selected . '>
                                <label for="' . $input_name . $tip . $usename . '">' . esc_html($item_title) . '</label>
                            </div>';
                    }
                }
            }
        endif;
        print '</div>';
    }

endif;






////////////////////////////////////////////////////////////////////////////////
/// get select arguments
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_get_select_arguments')):

    function wpestate_get_select_arguments() {
        $args = array(
            'hide_empty' => true,
            'hierarchical' => false,
            'pad_counts ' => true,
            'parent' => 0
        );

        $show_empty_city_status = esc_html(wpresidence_get_option('wp_estate_show_empty_city', ''));
        if ($show_empty_city_status == 'yes') {
            $args = array(
                'hide_empty' => false,
                'hierarchical' => false,
                'pad_counts ' => true,
                'parent' => 0
            );
        }
        return $args;
    }

endif;

////////////////////////////////////////////////////////////////////////////////
/// show hieracy action
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_status_select_list')):

    function wpestate_get_status_select_list($args) {
        $categ_select_list = wpestate_request_transient_cache('wpestate_get_status_select_list');
        if ($categ_select_list === false) {
            $taxonomy = 'property_status';
            $categories = get_terms($taxonomy, $args);

            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');
            
            $key='';
            if(is_array($adv_search_what)){
                $key = intval(array_search('property status', $adv_search_what));
            }

            if ($key === '' || $adv_search_label[$key] == '') {
                $label = esc_html__('Property Status', 'wpresidence');
            } else {
                $label = $adv_search_label[$key];
            }




            $categ_select_list = ' <li role="presentation" data-value="all">' . $label . '</li>';
            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);
                    $counter = $categ->count;
                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name))  . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }
            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_status_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;

function wpestate_return_default_label($adv_search_what, $adv_search_label, $taxonomy, $default_label) {
    $key='';
    if(is_array($adv_search_what)){
            $key = (array_search($taxonomy, $adv_search_what));
    }

    if ($key == '' || $adv_search_label[$key] == '') {
        $label = $default_label;
    } else {
        $label = $adv_search_label[$key];
    }
    return $label;
}

////////////////////////////////////////////////////////////////////////////////
/// show hieracy action
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_action_select_list')):

    function wpestate_get_action_select_list($args) {
        $categ_select_list = wpestate_request_transient_cache('wpestate_get_action_select_list');

        if ($categ_select_list === false) {
            $taxonomy = 'property_action_category';
            $categories = get_terms($taxonomy, $args);

            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

            $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'types', esc_html__('Types', 'wpresidence'));



            $categ_select_list = ' <li role="presentation" data-value="all">' . $label . '</li>';
            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);
                    $counter = $categ->count;
                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }
            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_action_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;


////////////////////////////////////////////////////////////////////////////////
/// universal function to get taxonomy dropdown
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_get_taxonomy_select_list')):

    function wpestate_get_taxonomy_select_list($args, $taxonomy, $non_option_title) {

        $data_value = array();

        $categories = get_terms($taxonomy, $args);
        $categ_select_list = '<li role="presentation" data-value="all">' . $non_option_title . '</li>';
        if (is_array($categories)) {
            foreach ($categories as $categ) {
                $data_value[] = array('slug' => $categ->slug, 'text' => ucwords(urldecode($categ->name)));
                $counter = $categ->count;
                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);

                if (isset($received['count'])) {
                    $counter = $counter + $received['count'];
                }

                $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name)) . ' (' . $counter . ')' . '</li>';
                if (isset($received['html'])) {
                    $categ_select_list .= $received['html'];
                }
            }
        }
        return array('text' => $categ_select_list, 'values' => $data_value);
    }

endif;








////////////////////////////////////////////////////////////////////////////////
/// show hieracy categ
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_get_category_select_list')):

    function wpestate_get_category_select_list($args) {
        $categ_select_list = wpestate_request_transient_cache('wpestate_get_category_select_list');

        if ($categ_select_list === false) {

            $taxonomy = 'property_category';
            $categories = get_terms($taxonomy, $args);
            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

            $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'categories', esc_html__('Categories', 'wpresidence'));



            $categ_select_list = '<li role="presentation" data-value="all">' . $label . '</li>';

            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $counter = $categ->count;
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);


                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }

            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_category_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy categeg
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_hierarchical_category_childen')):

    function wpestate_hierarchical_category_childen($taxonomy, $cat, $args, $base = 1, $level = 1) {
        $level++;
        $args['parent'] = $cat;
        $children = get_terms($taxonomy, $args);
        $return_array = array();
        $total_main[$level] = 0;
        $children_categ_select_list = '';
        foreach ($children as $categ) {

            $area_addon = '';
            $city_addon = '';
            $county_addon='';

            if ($taxonomy == 'property_city') {

                $term_meta = get_option("taxonomy_$categ->term_id");

                $string_county = '';
                if (isset($term_meta['stateparent'])) {
                    $string_county = wpestate_limit45(sanitize_title($term_meta['stateparent']));
                }
                $slug_county = sanitize_key($string_county);


                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $city_addon = '  data-parentcounty="' . esc_attr($slug_county) . '" data-value2="' . esc_attr($slug) . '" ';
            }

            if ($taxonomy == 'property_county_state') {

               

                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $county_addon = '  data-value2="' . esc_attr($slug) . '" ';
            }



            if ($taxonomy == 'property_area') {
                $term_meta = get_option("taxonomy_$categ->term_id");
                $string = wpestate_limit45(sanitize_title($term_meta['cityparent']));
                $slug = sanitize_key($string);
                $area_addon = ' data-parentcity="' . esc_attr($slug) . '" ';
            }

            $hold_base = $base;
            $base_string = '';
            $base++;
            $hold_base = $base;

            if ($level == 2) {
                $base_string = '-';
            } else {
                $i = 2;
                $base_string = '';
                while ($i <= $level) {
                    $base_string .= '-';
                    $i++;
                }
            }


            if ($categ->parent != 0) {
                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args, $base, $level);
            }


            $counter = $categ->count;
            if (isset($received['count'])) {
                $counter = $counter + $received['count'];
            }

            $children_categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '"  '.$county_addon.' '.$city_addon.' '.$area_addon.'>' . $base_string . ' ' . ucwords(urldecode($categ->name)) . '</li>';

            if (isset($received['html'])) {
                $children_categ_select_list .= $received['html'];
            }

            $total_main[$level] = $total_main[$level] + $counter;

            $return_array['count'] = $counter;
            $return_array['html'] = $children_categ_select_list;
        }
        $return_array['count'] = $total_main[$level];


        return $return_array;
    }

endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy city
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_city_select_list')):

    function wpestate_get_city_select_list($args) {
        $categ_select_list = wpestate_request_transient_cache('wpestate_get_city_select_list');

        if ($categ_select_list === false) {


            $taxonomy = 'property_city';
            $categories = get_terms($taxonomy, $args);
            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

            $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'cities', esc_html__('Cities', 'wpresidence'));


            $categ_select_list = '<li role="presentation" data-value="all" data-value2="all">' . $label . '</li>';

            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $string = wpestate_limit45(sanitize_title($categ->slug));
                    $slug = sanitize_key($string);
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);
                    $counter = $categ->count;
                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }
                    $slug_county = '';
                    $term_meta = get_option("taxonomy_$categ->term_id");
                    if (isset($term_meta['stateparent'])) {
                        $string_county = wpestate_limit45(sanitize_title($term_meta['stateparent']));
                        $slug_county = sanitize_key($string_county);
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '" data-value2="' . esc_attr($slug) . '" data-parentcounty="' . $slug_county . '">' . ucwords(urldecode($categ->name)) . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }
            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_city_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;



////////////////////////////////////////////////////////////////////////////////
/// show hieracy area county state
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_county_state_select_list')):

    function wpestate_get_county_state_select_list($args) {

        $categ_select_list = wpestate_request_transient_cache('wpestate_get_county_state_select_list');

        if ($categ_select_list === false) {

            $taxonomy = 'property_county_state';
            $categories = get_terms($taxonomy, $args);
            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

            $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'county / state', esc_html__('States', 'wpresidence'));


            $categ_select_list = '<li role="presentation" data-value="all" data-value2="all">' . $label . '</li>';

            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $string = wpestate_limit45(sanitize_title($categ->slug));
                    $slug = sanitize_key($string);
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);
                    $counter = $categ->count;
                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '" ax data-value2="' . esc_attr($slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }
            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_county_state_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy area
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_area_select_list')):

    function wpestate_get_area_select_list($args) {
        $categ_select_list = wpestate_request_transient_cache('wpestate_get_area_select_list');
        if ($categ_select_list === false) {



            $taxonomy = 'property_area';
            $categories = get_terms($taxonomy, $args);
            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

            $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'areas', esc_html__('Areas', 'wpresidence'));


            $categ_select_list = '<li role="presentation" data-value="all">' . $label . '</li>';


            if (is_array($categories)) {
                foreach ($categories as $categ) {
                    $term_meta = get_option("taxonomy_$categ->term_id");
                    $string = '';
                    if (isset($term_meta['cityparent'])) {
                        $string = wpestate_limit45(sanitize_title($term_meta['cityparent']));
                    }
                    $slug = sanitize_key($string);
                    $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id, $args);
                    $counter = $categ->count;
                    if (isset($received['count'])) {
                        $counter = $counter + $received['count'];
                    }

                    $categ_select_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '" data-parentcity="' . esc_attr($slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                    if (isset($received['html'])) {
                        $categ_select_list .= $received['html'];
                    }
                }
            }

            $transient_appendix = '';
            if (defined('ICL_LANGUAGE_CODE')) {
                $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
            }
            wpestate_set_transient_cache('wpestate_get_area_select_list' . $transient_appendix, $categ_select_list, 4 * 60 * 60);
        }
        return $categ_select_list;
    }

endif;


////////////////////////////////////////////////////////////////////////////////
/// show name on saved searches
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_custom_field_name')):

    function wpestate_get_custom_field_name($query_name, $adv_search_what, $adv_search_label) {
        $i = 0;


        if (is_array($adv_search_what) && !empty($adv_search_what)) {
            foreach ($adv_search_what as $key => $term) {
                $term = str_replace(' ', '_', $term);
                $slug = wpestate_limit45(sanitize_title($term));
                $slug = sanitize_key($slug);

                if ($slug == $query_name) {
                    return $adv_search_label[$key];
                }
                $i++;
            }
        }


        $advanced_exteded = wpresidence_get_option('wp_estate_advanced_exteded', '');
        if (is_array($advanced_exteded)) {
            foreach ($advanced_exteded as $checker => $value) {
                $post_var_name = str_replace(' ', '_', trim($value));
                $input_name = wpestate_limit45(sanitize_title($post_var_name));
                $input_name = sanitize_key($input_name);
                if ($input_name == $query_name) {
                    return $value;
                }
            }
        }


        return $query_name;
    }

endif;

////////////////////////////////////////////////////////////////////////////////
/// get author
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpsestate_get_author')):

    function wpsestate_get_author($post_id = 0) {
        $post = get_post($post_id);
        wp_reset_postdata();
        wp_reset_query();
        return $post->post_author;
    }

endif;

////////////////////////////////////////////////////////////////////////////////
/// show stripe form per listing
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_show_stripe_form_per_listing')):

    function wpestate_show_stripe_form_per_listing($stripe_class, $post_id, $price_submission, $price_featured_submission) {



        $processor_link = wpestate_get_template_link('stripecharge.php');
        $submission_curency_status = esc_html(wpresidence_get_option('wp_estate_submission_curency', ''));
        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $user_email = $current_user->user_email;

        $price_submission_total = $price_submission + $price_featured_submission;
        $price_submission_total = $price_submission_total;
        $price_submission = $price_submission;


        print '<div class="stripe-wrapper ' . $stripe_class . '" id="stripe_form_simple"> ';
        global $wpestate_global_payments;
        $metadata = array(
            'listing_id' => $post_id,
            'user_id' => $userID,
            'featured_pay' => 0,
            'is_upgrade' => 0,
            'pay_type' => 2,
            'message' => esc_html__('Pay Submission Fee', 'wpresidence')
        );

        $wpestate_global_payments->stripe_payments->wpestate_show_stripe_form($price_submission, $metadata);
        print'
    </div>';
    }

endif;



////////////////////////////////////////////////////////////////////////////////
/// show stripe form membership
////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_show_stripe_form_membership')):

    function wpestate_show_stripe_form_membership() {

        $current_user = wp_get_current_user();
        //  get_currentuserinfo();
        $userID = $current_user->ID;
        $user_login = $current_user->user_login;
        $user_email = get_the_author_meta('user_email', $userID);

        $is_stripe_live = esc_html(wpresidence_get_option('wp_estate_enable_stripe', ''));
        if ($is_stripe_live == 'yes') {
            $stripe_secret_key = esc_html(wpresidence_get_option('wp_estate_stripe_secret_key', ''));
            $stripe_publishable_key = esc_html(wpresidence_get_option('wp_estate_stripe_publishable_key', ''));
        }
        $pay_ammout = '0';
        $pack_id = '0';

        $processor_link = wpestate_get_template_link('stripecharge.php');




        print '
        <form action="' . $processor_link . '" method="post" id="stripe_form">';
        wp_nonce_field('wpestate_stripe_payments', 'wpestate_stripe_payments_nonce');

        global $wpestate_global_payments;
        $metadata = array(
            'user_id' => $userID,
            'pay_type' => 3
        );
        $price_submission = '';


        $wpestate_global_payments->stripe_payments->wpestate_show_stripe_form($price_submission, $metadata);


        print'<input type="hidden" id="pack_id" name="pack_id" value="' . $pack_id . '">
            <input type="hidden" id="pack_title" name="pack_title" value="">
            <input type="hidden" name="userID" value="' . $userID . '">
            <input type="hidden" id="pay_ammout" name="pay_ammout" value="' . $pay_ammout . '">';
        print'
        </form>';
    }

endif;




if (!function_exists('wpestate_get_stripe_buttons')):

    function wpestate_get_stripe_buttons($stripe_pub_key, $user_email, $submission_curency_status) {
        wp_reset_query();
        $buttons = '';
        $args = array(
            'post_type' => 'membership_package',
            'meta_query' => array(
                array(
                    'key' => 'pack_visible',
                    'value' => 'yes',
                    'compare' => '=',
                )
            )
        );
        $pack_selection = new WP_Query($args);
        $i = 0;
        while ($pack_selection->have_posts()) {
            $pack_selection->the_post();
            $postid = get_the_ID();

            $pack_price = get_post_meta($postid, 'pack_price', true) * 100;
            $title = get_the_title();
            if ($i == 0) {
                $visible_stripe = " visible_stripe ";
            } else {
                $visible_stripe = '';
            }
            $i++;
            $buttons .= '
                        <div class="stripe_buttons ' . esc_attr($visible_stripe) . ' " id="' . sanitize_title($title) . '">
                            <script src="https://checkout.stripe.com/checkout.js" id="stripe_script"
                            class="stripe-button"
                            data-key="' . esc_attr($stripe_pub_key) . '"
                            data-amount="' . esc_attr($pack_price) . '"
                            data-email="' . esc_attr($user_email) . '"
                            data-currency="' . esc_attr($submission_curency_status) . '"
                            data-zip-code="true"
                            data-locale="auto"
                            data-billing-address="true"
                            data-label="' . esc_html__('Pay with Credit Card', 'wpresidence') . '"
                            data-description="' . esc_attr($title) . ' ' . esc_html__('Package Payment', 'wpresidence') . '">
                            </script>
                        </div>';
        }
        wp_reset_query();
        return $buttons;
    }

endif;





if (!function_exists('wpestate_email_to_admin')):

    function wpestate_email_to_admin($onlyfeatured) {


        $headers = 'From: '.wpestate_return_sending_email() . '>' . "\r\n";
        $message = esc_html__('Hi there,', 'wpresidence') . "\r\n\r\n";

        if ($onlyfeatured == 1) {

            $arguments = array();
            wpestate_select_email_type(get_option('admin_email'), 'featured_submission', $arguments);
        } else {

            $arguments = array();
            wpestate_select_email_type(get_option('admin_email'), 'paid_submissions', $arguments);
        }
    }

endif;



if (!function_exists('wpestate_show_stripe_form_upgrade')):

    function wpestate_show_stripe_form_upgrade($stripe_class, $post_id, $price_submission, $price_featured_submission) {
        $is_stripe_live = esc_html(wpresidence_get_option('wp_estate_enable_stripe', ''));
        if ($is_stripe_live == 'yes') {


            print '<div class="stripe_upgrade">';
            $current_user = wp_get_current_user();
            $userID = $current_user->ID;
            $user_email = $current_user->user_email;
            $submission_curency_status = esc_html(wpresidence_get_option('wp_estate_submission_curency', ''));
            $price_featured_submission = $price_featured_submission;

            global $wpestate_global_payments;
            $metadata = array(
                'listing_id' => $post_id,
                'user_id' => $userID,
                'featured_pay' => 0,
                'is_upgrade' => 1,
                'pay_type' => 2,
                'message' => esc_html__('Upgrade to Featured', 'wpresidence')
            );

            $wpestate_global_payments->stripe_payments->wpestate_show_stripe_form($price_featured_submission, $metadata);
            print '</div>';
        }
    }

endif;




///////////////////////////////////////////////////////////////////////////////////////////
// dasboaord search link
///////////////////////////////////////////////////////////////////////////////////////////



if (!function_exists('wpestate_get_dasboard_searches_link')):

    function wpestate_get_dasboard_searches_link() {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user_dashboard_search_result.php'
        ));

        if ($pages) {
            $dash_link = esc_url(get_permalink($pages[0]->ID));
        } else {
            $dash_link = esc_url(home_url('/'));
        }

        return $dash_link;
    }

endif; // end







if (!function_exists('wpestate_get_meaurement_unit_formated')):

    function wpestate_get_meaurement_unit_formated($show_default = 0) {
        $measure_unit = '';
        $basic_measure = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));
        if (isset($_COOKIE['my_measure_unit'])) {
            $selected_measure = esc_html($_COOKIE['my_measure_unit']);
        } else {
            $selected_measure = $basic_measure;
        }

        if ($show_default == 1) {
            $selected_measure = $basic_measure;
        }

        $measure_array = array(
            array('name' => esc_html__('feet', 'wpresidence'), 'unit' => esc_html__('ft', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('meters', 'wpresidence'), 'unit' => esc_html__('m', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('acres', 'wpresidence'), 'unit' => esc_html__('ac', 'wpresidence'), 'is_square' => 1),
            array('name' => esc_html__('yards', 'wpresidence'), 'unit' => esc_html__('yd', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('hectares', 'wpresidence'), 'unit' => esc_html__('ha', 'wpresidence'), 'is_square' => 1),
        );


        // getting unit
        foreach ($measure_array as $single_unit) {
            if ($single_unit['unit'] == $selected_measure) {
                if ($single_unit['is_square'] === 1) {
                    $measure_unit = $single_unit['unit'];
                } else {
                    $measure_unit = $single_unit['unit'] . '<sup>2</sup>';
                }
            }
        }
        return $measure_unit;
    }

endif;


if (!function_exists('wpestate_return_measurement_sys')):

    function wpestate_return_measurement_sys() {
        if (isset($_COOKIE['my_measure_unit'])) {
            $to_return = ' ' . esc_html($_COOKIE['my_measure_unit']);
            if ($_COOKIE['my_measure_unit'] == 'ft' || $_COOKIE['my_measure_unit'] == 'm' || $_COOKIE['my_measure_unit'] == 'yd') {
                $to_return .= '<sup>2</sup>';
                return $to_return;
            }
            if ($_COOKIE['my_measure_unit'] == 'ac' || $_COOKIE['my_measure_unit'] == 'ha') {

                return $to_return;
            }
        } else {
            $measure = wpresidence_get_option('wp_estate_measure_sys', '');
            if ($measure == 'ft' || $measure == 'm' || $measure == 'yd') {
                $measure .= '<sup>2</sup>';
            }
            return $measure;
        }
    }

endif;

if (!function_exists('wpestate_convert_measure')):

    function wpestate_convert_measure($value, $reverse = '') {
        $value=floatval($value);
        $recalculation_table = array(
            'ftft' => 1,
            'ftm' => 0.092903,
            'ftac' => 0.000022957,
            'ftyd' => 0.111111,
            'ftha' => 0.0000092903,
            'mm' => 1,
            'mft' => 10.7639,
            'mac' => 0.000247105,
            'myd' => 1.19599,
            'mha' => 0.0001,
            'acac' => 1,
            'acft' => 43560,
            'acm' => 4046.86,
            'acyd' => 4840,
            'acha' => 0.404686,
            'ydyd' => 1,
            'ydft' => 9,
            'ydm' => 0.836127,
            'ydac' => 0.000206612,
            'ydha' => 0.000083613,
            'haha' => 1,
            'haft' => 107639,
            'ham' => 10000,
            'haac' => 2.47105,
            'hayd' => 11959.9,
        );

        $recalculation_table = array(
            esc_html__('ft', 'wpresidence') . esc_html__('ft', 'wpresidence') => 1,
            esc_html__('ft', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.092903,
            esc_html__('ft', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000022957,
            esc_html__('ft', 'wpresidence') . esc_html__('yd', 'wpresidence') => 0.111111,
            esc_html__('ft', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0000092903,
            esc_html__('m', 'wpresidence') . esc_html__('m', 'wpresidence') => 1,
            esc_html__('m', 'wpresidence') . esc_html__('ft', 'wpresidence') => 10.7639,
            esc_html__('m', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000247105,
            esc_html__('m', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1.19599,
            esc_html__('m', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0001,
            esc_html__('ac', 'wpresidence') . esc_html__('ac', 'wpresidence') => 1,
            esc_html__('ac', 'wpresidence') . esc_html__('ft', 'wpresidence') => 43560,
            esc_html__('ac', 'wpresidence') . esc_html__('m', 'wpresidence') => 4046.86,
            esc_html__('ac', 'wpresidence') . esc_html__('yd', 'wpresidence') => 4840,
            esc_html__('ac', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.404686,
            esc_html__('yd', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1,
            esc_html__('yd', 'wpresidence') . esc_html__('ft', 'wpresidence') => 9,
            esc_html__('yd', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.836127,
            esc_html__('yd', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000206612,
            esc_html__('yd', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.000083613,
            esc_html__('ha', 'wpresidence') . esc_html__('ha', 'wpresidence') => 1,
            esc_html__('ha', 'wpresidence') . esc_html__('ft', 'wpresidence') => 107639,
            esc_html__('ha', 'wpresidence') . esc_html__('m', 'wpresidence') => 10000,
            esc_html__('ha', 'wpresidence') . esc_html__('ac', 'wpresidence') => 2.47105,
            esc_html__('ha', 'wpresidence') . esc_html__('yd', 'wpresidence') => 11959.9,
        );

        $basic_measure = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));
        if (isset($_COOKIE['my_measure_unit'])) {
            $selected_measure = esc_html($_COOKIE['my_measure_unit']);
        } else {
            $selected_measure = $basic_measure;
        }
        $size_value=1;
        if( isset($recalculation_table[( $basic_measure . $selected_measure )]) ){
            $size_value = $value * $recalculation_table[( $basic_measure . $selected_measure )];
        }
     
        if ($reverse == 1) {
            $size_value = $value * $recalculation_table[$selected_measure . $basic_measure];
        }

        return $size_value;
    }

endif;





if (!function_exists('wpestate_get_converted_measure')):

    function wpestate_get_converted_measure($post_id, $meta_key, $wpestate_prop_all_details = '') {

        if ($wpestate_prop_all_details == '') {
            $size_value = get_post_meta($post_id, $meta_key, true);
        } else {
            $size_value = wpestate_return_custom_field($wpestate_prop_all_details, $meta_key);
        }

        if ($size_value == '' || !$size_value) {
            return false;
        }
        $size_value = floatval($size_value);
        $measure_array = array(
            array('name' => esc_html__('feet', 'wpresidence'), 'unit' => esc_html__('ft', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('meters', 'wpresidence'), 'unit' => esc_html__('m', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('acres', 'wpresidence'), 'unit' => esc_html__('ac', 'wpresidence'), 'is_square' => 1),
            array('name' => esc_html__('yards', 'wpresidence'), 'unit' => esc_html__('yd', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('hectares', 'wpresidence'), 'unit' => esc_html__('ha', 'wpresidence'), 'is_square' => 1),
        );


        $recalculation_table = array(
            esc_html__('ft', 'wpresidence') . esc_html__('ft', 'wpresidence') => 1,
            esc_html__('ft', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.092903,
            esc_html__('ft', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000022957,
            esc_html__('ft', 'wpresidence') . esc_html__('yd', 'wpresidence') => 0.111111,
            esc_html__('ft', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0000092903,
            esc_html__('m', 'wpresidence') . esc_html__('m', 'wpresidence') => 1,
            esc_html__('m', 'wpresidence') . esc_html__('ft', 'wpresidence') => 10.7639,
            esc_html__('m', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000247105,
            esc_html__('m', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1.19599,
            esc_html__('m', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0001,
            esc_html__('ac', 'wpresidence') . esc_html__('ac', 'wpresidence') => 1,
            esc_html__('ac', 'wpresidence') . esc_html__('ft', 'wpresidence') => 43560,
            esc_html__('ac', 'wpresidence') . esc_html__('m', 'wpresidence') => 4046.86,
            esc_html__('ac', 'wpresidence') . esc_html__('yd', 'wpresidence') => 4840,
            esc_html__('ac', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.404686,
            esc_html__('yd', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1,
            esc_html__('yd', 'wpresidence') . esc_html__('ft', 'wpresidence') => 9,
            esc_html__('yd', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.836127,
            esc_html__('yd', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000206612,
            esc_html__('yd', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.000083613,
            esc_html__('ha', 'wpresidence') . esc_html__('ha', 'wpresidence') => 1,
            esc_html__('ha', 'wpresidence') . esc_html__('ft', 'wpresidence') => 107639,
            esc_html__('ha', 'wpresidence') . esc_html__('m', 'wpresidence') => 10000,
            esc_html__('ha', 'wpresidence') . esc_html__('ac', 'wpresidence') => 2.47105,
            esc_html__('ha', 'wpresidence') . esc_html__('yd', 'wpresidence') => 11959.9,
        );


        $basic_measure = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));  
        $basic_measure_lot_size = esc_html(wpresidence_get_option('wp_estate_measure_sys_lot_size', ''));
        if($meta_key=='property_lot_size' && $basic_measure_lot_size!=''){
            $basic_measure=$basic_measure_lot_size;
        }
        if (isset($_COOKIE['my_measure_unit'])) {
            $selected_measure = esc_html($_COOKIE['my_measure_unit']);
        } else {
            $selected_measure = $basic_measure;
        }

        // getting unit
        $measure_unit = '';
        foreach ($measure_array as $single_unit) {
            if ($single_unit['unit'] == $selected_measure) {
                if ($single_unit['is_square'] === 1) {
                    $measure_unit = $single_unit['unit'];
                } else {
                    $measure_unit = $single_unit['unit'] . '<sup>2</sup>';
                }
            }
        }
        if (isset($recalculation_table[$basic_measure . $selected_measure])) {
            $size_value = $size_value * $recalculation_table[$basic_measure . $selected_measure];
        }

        $size_value = wpestate_property_size_number_format($size_value);

        return '<span>'.$size_value . ' ' . $measure_unit.'</span>';
    }

endif;






if (!function_exists('wpestate_limit64')):

    function wpestate_limit64($stringtolimit) {
        return mb_substr($stringtolimit, 0, 64);
    }

endif;


if (!function_exists('wpestate_limit54')):

    function wpestate_limit54($stringtolimit) {
        return mb_substr($stringtolimit, 0, 54);
    }

endif;

if (!function_exists('wpestate_limit50')):

    function wpestate_limit50($stringtolimit) { // 14
        return mb_substr($stringtolimit, 0, 50);
    }

endif;

if (!function_exists('wpestate_limit45')):

    function wpestate_limit45($stringtolimit) { // 19
        return mb_substr($stringtolimit, 0, 45);
    }

endif;

if (!function_exists('wpestate_limit27')):

    function wpestate_limit27($stringtolimit) { // 27
        return mb_substr($stringtolimit, 0, 27);
    }

endif;



//////////////////////////////////////////////////////////////////////////////////////////////
// page details : setting sidebar position etc...
//////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_page_details')):

    function wpestate_page_details($post_id) {

        $return_array = array();

        if ($post_id != '' && !is_home() && !is_tax()) {
            $sidebar_name = esc_html(get_post_meta($post_id, 'sidebar_select', true));
            $sidebar_status = esc_html(get_post_meta($post_id, 'sidebar_option', true));
        } else {
            $sidebar_name = esc_html(wpresidence_get_option('wp_estate_blog_sidebar_name', ''));
            $sidebar_status = esc_html(wpresidence_get_option('wp_estate_blog_sidebar', ''));
        }

        if ('estate_agent' == get_post_type() && $sidebar_name == '' & $sidebar_status == '') {
            $sidebar_status = esc_html(wpresidence_get_option('wp_estate_agent_sidebar', ''));
            $sidebar_name = esc_html(wpresidence_get_option('wp_estate_agent_sidebar_name', ''));
        }

        if ($post_id != '') {
            if ('estate_property' == get_post_type() && ($sidebar_status == '' || $sidebar_status == 'global' )) {
                $sidebar_status = esc_html(wpresidence_get_option('wp_estate_property_sidebar', ''));
                $sidebar_name = esc_html(wpresidence_get_option('wp_estate_property_sidebar_name', ''));
            }
        }


        if ('' == $sidebar_name) {
            $sidebar_name = 'primary-widget-area';
        }
        if ('' == $sidebar_status) {
            $sidebar_status = 'right';
        }



        if ('left' == $sidebar_status) {
            $return_array['content_class'] = 'col-md-9 col-md-push-3 rightmargin';
            $return_array['sidebar_class'] = 'col-md-3 col-md-pull-9 ';
        } else if ($sidebar_status == 'right') {
            $return_array['content_class'] = 'col-md-9 rightmargin';
            $return_array['sidebar_class'] = 'col-md-3';
        } else {
            $return_array['content_class'] = 'col-md-12';
            $return_array['sidebar_class'] = 'none';
        }

        $return_array['sidebar_name'] = $sidebar_name;

        return $return_array;
    }

endif; // end   wpestate_page_details




if (!function_exists('wpestate_show_advanced_search_options_redux')):

    function wpestate_show_advanced_search_options_redux($adv_search_what_value) {
        $return_string = '';

        $admin_submission_array = array('Location' => esc_html('Location', 'wpresidence'),
            'check_in' => esc_html('check_in', 'wpresidence'),
            'check_out' => esc_html('check_out', 'wpresidence'),
            'property_category' => esc_html('First Category', 'wpresidence'),
            'property_action_category' => esc_html('Second Category', 'wpresidence'),
            'property_city' => esc_html('Cities', 'wpresidence'),
            'property_area' => esc_html('Areas', 'wpresidence'),
            'guest_no' => esc_html('guest_no', 'wpresidence'),
            'property_price' => esc_html('Price', 'wpresidence'),
            'property_size' => esc_html('Size', 'wpresidence'),
            'property_rooms' => esc_html('Rooms', 'wpresidence'),
            'property_bedrooms' => esc_html('Bedroms', 'wpresidence'),
            'property_bathrooms' => esc_html('Bathrooms', 'wpresidence'),
            'property_address' => esc_html('Address', 'wpresidence'),
            'property_county' => esc_html('County', 'wpresidence'),
            'property_state' => esc_html('State', 'wpresidence'),
            'property_zip' => esc_html('Zip', 'wpresidence'),
            'property_country' => esc_html('Country', 'wpresidence'),
        );

        foreach ($admin_submission_array as $key => $value) {

            $return_string .= '<option value="' . $key . '" ';
            if ($adv_search_what_value == $key) {
                $return_string .= ' selected="selected" ';
            }
            $return_string .= '>' . $value . '</option>';
        }

        $i = 0;

        $custom_fields = get_option('wpestate_custom_fields_list');

        if (!empty($custom_fields)) {
            while ($i < count($custom_fields['add_field_name'])) {

                $data = wpresidence_prepare_non_latin($custom_fields['add_field_name'][$i], $custom_fields['add_field_label'][$i]);


                $return_string .= '<option value="' . $data['key'] . '" ';
                if ($adv_search_what_value == $data['key']) {
                    $return_string .= ' selected="selected" ';
                }
                $return_string .= '>' . $data['label'] . '</option>';
                $i++;
            }
        }




        $slug = 'none';
        $name = 'none';
        $return_string .= '<option value="' . $slug . '" ';
        if ($adv_search_what_value == $slug) {
            $return_string .= ' selected="selected" ';
        }
        $return_string .= '>' . $name . '</option>';


        return $return_string;
    }

endif; // end   wpestate_show_advanced_search_options


if (!function_exists('wpestate_show_advanced_search_how_redux')):

    function wpestate_show_advanced_search_how_redux($adv_search_how_value) {
        $return_string = '';
        $curent_value = '';

        $admin_submission_how_array = array('equal',
            'greater',
            'smaller',
            'like',
            'date bigger',
            'date smaller');

        foreach ($admin_submission_how_array as $value) {
            $return_string .= '<option value="' . $value . '" ';
            if ($adv_search_how_value == $value) {
                $return_string .= ' selected="selected" ';
            }
            $return_string .= '>' . $value . '</option>';
        }
        return $return_string;
    }

endif; // end   wpestate_show_advanced_search_how


if (!function_exists('wpestate_return_all_fields')):

    function wpestate_return_all_fields($is_mandatory = 0) {

        $submission_page_fields = ( get_option('wp_estate_submission_page_fields', '') );



        $all_submission_fields = $all_mandatory_fields = array(
            'wpestate_description' => esc_html__('Description', 'wpresidence'),
            'property_price' => esc_html__('Property Price', 'wpresidence'),
            'property_label' => esc_html__('Property Price Label', 'wpresidence'),
            'property_label_before' => esc_html__('Property Price Label Before', 'wpresidence'),

            'property_second_price' => esc_html__('Additional Price Info', 'wpresidence'),
            'property_second_price_label' => esc_html__('After Label for Additional Price info', 'wpresidence'),
            'property_label_before_second_price' => esc_html__('Before Label for Additional Price Info', 'wpresidence'),
            'prop_category' => esc_html__('Property Category Submit', 'wpresidence'),
            'prop_action_category' => esc_html__('Property Action Category', 'wpresidence'),
            'attachid' => esc_html__('Property Media', 'wpresidence'),
            'property_address' => esc_html__('Property Address', 'wpresidence'),
            'property_city' => esc_html__('Property City', 'wpresidence'),
            'property_area' => esc_html__('Property Area', 'wpresidence'),
            'property_zip' => esc_html__('Property Zip', 'wpresidence'),
            'property_county' => esc_html__('Property County', 'wpresidence'),
            'property_country' => esc_html__('Property Country', 'wpresidence'),
            'property_map' => esc_html__('Property Map', 'wpresidence'),
            'property_latitude' => esc_html__('Property Latitude', 'wpresidence'),
            'property_longitude' => esc_html__('Property Longitude', 'wpresidence'),
            'google_camera_angle' => esc_html__('Google Camera Angle', 'wpresidence'),
            'property_google_view' => esc_html__('Property Google View', 'wpresidence'),
            'property_hide_map_marker' => esc_html__('Hide Map Marker', 'wpresidence'),
            'property_size' => esc_html__('property Size', 'wpresidence'),
            'property_lot_size' => esc_html__('Property Lot Size', 'wpresidence'),
            'property_rooms' => esc_html__('Property Rooms', 'wpresidence'),
            'property_bedrooms' => esc_html__('Property Bedrooms', 'wpresidence'),
            'property_bathrooms' => esc_html__('Property Bathrooms', 'wpresidence'),
            'owner_notes' => esc_html__('Owner Notes', 'wpresidence'),
            'property_status' => esc_html__('property status', 'wpresidence'),
            'embed_video_id' => esc_html__('Embed Video Id', 'wpresidence'),
            'embed_video_type' => esc_html__('Embed Video Type', 'wpresidence'),
            'embed_virtual_tour' => esc_html__('Embed Virtual Tour', 'wpresidence'),
            'property_subunits_list' => esc_html__('Property Subunits', 'wpresidence'),
            'energy_class' => esc_html__('Energy Class', 'wpresidence'),
            'energy_index' => esc_html__('Energy Index', 'wpresidence'),
            'co2_class' => esc_html__('Greenhouse gas emissions Class', 'wpresidence'),
            'co2_index' => esc_html__('Greenhouse gas emissions Index', 'wpresidence'),
            'renew_energy_index' => esc_html__('Renewable energy performance index', 'wpresidence'),
            'building_energy_index' => esc_html__('Energy performance of the building', 'wpresidence'),
            'epc_current_rating' => esc_html__('EPC current rating', 'wpresidence'),
            'epc_potential_rating' => esc_html__('EPC Potential Rating', 'wpresidence'),
        );

        if ($is_mandatory == 1) {
            unset($all_submission_fields['property_subunits_list']);
        }



        $i = 0;

        $custom_fields = wpresidence_get_option('wp_estate_custom_fields', '');
        if (!empty($custom_fields)) {
            while ($i < count($custom_fields)) {
                $name = stripslashes($custom_fields[$i][0]);
                $slug = str_replace(' ', '_', $name);
                if ($is_mandatory == 1) {
                    $slug = str_replace(' ', '-', $name);
                    unset($all_submission_fields['property_map']);
                }
                $label = stripslashes($custom_fields[$i][1]);

                $slug = htmlspecialchars($slug, ENT_QUOTES);

                $all_submission_fields[$slug] = $label;
                $i++;
            }
        }

        $terms = get_terms(array(
            'taxonomy' => 'property_features',
            'hide_empty' => false,
        ));
        foreach ($terms as $checker => $term) {
            if (isset($term->slug)) {
                $all_submission_fields[$term->slug] = $term->name;
            }
        }




        return $all_submission_fields;
    }

endif;




if (!function_exists('wpestate_morgage_calculator')):

    function wpestate_morgage_calculator($post_id, $wpestate_prop_all_details='') {
        $wpestate_currency      =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $label_before = '';
        $label_after = '';
        if ($where_currency == 'before') {
            $label_before = $wpestate_currency . ' ';
        } else {
            $label_after = ' ' . $wpestate_currency;
        }


        if ($wpestate_prop_all_details == '') {
            $price = floatval(get_post_meta($post_id, 'property_price', true));
            $property_tax_percent = floatval(get_post_meta($post_id, 'property_year_tax', true));
            if ($property_tax_percent == 0) {
                $property_tax_percent = floatval(wpresidence_get_option('wp_estate_morg_default_tax', ''));
            }
            $hoo_fees = floatval(get_post_meta($post_id, 'property_hoa', true));
        } else {
            $price = floatval(wpestate_return_custom_field($wpestate_prop_all_details, 'property_price'));
            $property_tax_percent = floatval(wpestate_return_custom_field($wpestate_prop_all_details, 'property_year_tax'));
            if ($property_tax_percent == 0) {
                $property_tax_percent = floatval(wpestate_return_custom_field($wpestate_prop_all_details, 'wp_estate_morg_default_tax'));
            }
            $hoo_fees = floatval(wpestate_return_custom_field($wpestate_prop_all_details, 'property_hoa'));
        }


        $price_down_percent = floatval(wpresidence_get_option('wp_estate_morg_default_price_down_per', ''));
        $price_down = floatval($price / 100 * $price_down_percent);
        $morgage_interest = floatval(wpresidence_get_option('wp_estate_morg_default_morg_interest', ''));
        $morgage_term = floatval(wpresidence_get_option('wp_estate_morg_default_morg_term', ''));
        $principal = $price - $price_down;
        $monthly_interest_rate = $morgage_interest / 12 / 100;
        $no_monthly_payments = 12 * $morgage_term;


        $a = (($morgage_interest / 100 / 12) * $principal);
        $b = ( 1 + ($morgage_interest / 100 / 12));
        $pmt = $a / (1 - ( $b ** (-1 * $morgage_term * 12)));

        $monthly_property_tax = $price / 100 * $property_tax_percent / 12;
        $total_monthly = $pmt + $monthly_property_tax + $hoo_fees;

        if ($total_monthly == 0) {
            $total_monthly = 1;
        }
        $percent_principal = $pmt * 100 / $total_monthly;
        $percent_hoa = $hoo_fees * 100 / $total_monthly;
        $percent_tax = $monthly_property_tax * 100 / $total_monthly;

        print '


    <div class="morgage_chart_wrapper onfirst">
        <div id="canvas-holder">
            <canvas id="morgage_chart"></canvas>
            <div class="morg_momth_pay"> <div class="morg_month_wrap">' . $label_before . '<span id="morg_month_total">' . number_format($total_monthly, 2) . '</span>' . $label_after . '</div><span id="morg_per_month">' . esc_html__('per month', 'wpresidence') . '</span></div>

        </div>
      
        <ul class="morgage_legend">
            <li>' . esc_html__('Principal and Interest', 'wpresidence') . '</li>
            <li>' . esc_html__('Property Tax', 'wpresidence') . '</li>
            <li>' . esc_html__('HOA fee', 'wpresidence') . '</li>
        </ul>

    </div>

    <div class="morgage_chart_wrapper">
        <label>' . esc_html__('Principal and Interest', 'wpresidence') . '</label>' . $label_before . ' <span data-per="' . $percent_principal . '" id="morg_principal">' . number_format($pmt, 2) . '</span>' . $label_after . '
        <label>' . esc_html__('Property Tax', 'wpresidence') . '</label>
        <input type="text" id="monthly_property_tax" data-per="' . $percent_tax . '" value="' . $monthly_property_tax . '">

        <label>' . esc_html__('Homeowners Association Fee', 'wpresidence') . '</label>
        <input type="text" id="hoo_fees" data-per="' . $percent_hoa . '" value="' . $hoo_fees . '">


    </div>';

        print '<div class=" morgage_data_wrapper onfirst">';
        ?>
        <label><?php esc_html_e('Home Price', 'wpresidence'); ?></label>
        <input type="text" name="morgage_home_price" class="morgage_inputdata" data-price="<?php echo esc_attr($price); ?>" id="morgage_home_price" value="<?php echo esc_attr($price); ?>">

        <label><?php esc_html_e('Down Payment', 'wpresidence'); ?></label>
        <input type="text" name="morgage_down_payment" class="morgage_inputdata" id="morgage_down_payment" data-price="<?php echo esc_attr($price_down); ?>" value="<?php echo esc_attr($price_down); ?>">
        <input type="text" name="morgage_down_payment_percent" class="morgage_inputdata" id="morgage_down_payment_percent"  data-down-pay=""<?php echo esc_attr($price_down_percent); ?> value="<?php echo esc_attr($price_down_percent); ?>">

        </div>
        <div class=" morgage_data_wrapper">

            <label><?php esc_html_e('Term(*in years)', 'wpresidence'); ?></label>
            <input type="text" name="morgage_term" class="morgage_inputdata" id="morgage_term" value="<?php echo esc_attr($morgage_term); ?>">

            <label><?php esc_html_e('Interest', 'wpresidence'); ?></label>
            <input type="text" name="morgage_interest" class="morgage_inputdata" id="morgage_interest" value="<?php echo esc_attr($morgage_interest); ?>">



        <?php
        print '</div>';
    }

endif;



if (!function_exists('wpestate_header_phone')):

    function wpestate_header_phone() {
        $return = '';
        $phone_no = wpresidence_get_option('wp_estate_header_phone_no', '');
        if ($phone_no != '') {
            $return = ' <div class="header_phone">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" version="1.1" style="shape-rendering:geometricPrecision;text-rendering:geometricPrecision;image-rendering:optimizeQuality;" viewBox="0 0 295.64 369.5375" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd"><defs></defs><g><path class="fil0" d="M231.99 189.12c18.12,10.07 36.25,20.14 54.37,30.21 7.8,4.33 11.22,13.52 8.15,21.9 -15.59,42.59 -61.25,65.07 -104.21,49.39 -87.97,-32.11 -153.18,-97.32 -185.29,-185.29 -15.68,-42.96 6.8,-88.62 49.39,-104.21 8.38,-3.07 17.57,0.35 21.91,8.15 10.06,18.12 20.13,36.25 30.2,54.37 4.72,8.5 3.61,18.59 -2.85,25.85 -8.46,9.52 -16.92,19.04 -25.38,28.55 18.06,43.98 55.33,81.25 99.31,99.31 9.51,-8.46 19.03,-16.92 28.55,-25.38 7.27,-6.46 17.35,-7.57 25.85,-2.85z"/></g></svg>
            <a href="tel:' . $phone_no . '" >' . $phone_no . '</a>
        </div>';
        }
        return $return;
    }

endif;

/*
 * fields for custom unit
 *
 *
 *
 *
 */
if (!function_exists('redux_wpestate_return_custom_unit_fields')):

    function redux_wpestate_return_custom_unit_fields($select_name, $selected_val, $for = '') {

        $all_fields = array(
            'none' => __('Leave Blank', 'wpresidence'),
            'property_category' => __('Category', 'wpresidence'),
            'property_action_category' => __('Action Category', 'wpresidence'),
            'property_city' => __('Property City', 'wpresidence'),
            'property_area' => __('Property Area', 'wpresidence'),
            'property_county_state' => __('Property County/State', 'wpresidence'),
            'property_status' => __('Property Status', 'wpresidence'),
            'property_year_tax' => __('Yearly Tax Rate', 'wpresidence'),
            'property_hoa' => __('Homeowners Association Fee(Monthly)', 'wpresidence'),
            'property_size' => __('Property Size', 'wpresidence'),
            'property_lot_size' => __('Property Lot Size', 'wpresidence'),
            'property_rooms' => __('Property Rooms', 'wpresidence'),
            'property_bedrooms' => __('Property Bedrooms', 'wpresidence'),
            'property_bathrooms' => __('Property Bathrooms', 'wpresidence'),
            'property_address' => __('Property Address', 'wpresidence'),
            'property_zip' => __('Property Zip', 'wpresidence'),
            'property_country' => __('Property Country', 'wpresidence'),
            'energy_index' => __('Energy Index in kWh/m2a', 'wpresidence'),
            'energy_class' => __('Energy Class', 'wpresidence'),
            'co2_index' => __('Greenhouse gas emissions kgCO2/m2a', 'wpresidence'),
            'co2_class' => __('Greenhouse gas emissions index class ', 'wpresidence'),
            'renew_energy_index' => __('Renewable energy performance index ', 'wpresidence'),
            'building_energy_index' => __('Energy performance of the building', 'wpresidence'),
            'epc_current_rating' => __('EPC current rating', 'wpresidence'),
            'epc_potential_rating' => __('EPC potential rating', 'wpresidence'),
        );

        if ($for == '_infobox') {
            unset($all_fields['property_category']);
            unset($all_fields['property_action_category']);
            unset($all_fields['property_price']);
       
        }

        if ($for == '_property') {
            unset($all_fields['property_price']);
        }


        $i = 0;
        $custom_fields = wpresidence_get_option('wpestate_custom_fields_list', '');

        if (!empty($custom_fields)) {
            while ($i < count($custom_fields)) {
                $name = stripslashes($custom_fields[$i][0]);
                $slug = str_replace(' ', '-', $name);
                $label = stripslashes($custom_fields[$i][1]);
                $slug = htmlspecialchars($slug, ENT_QUOTES);

                $all_fields[strtolower($slug)] = $label;
                $i++;
            }
        }

        $return_options = '<select id="unit_field_value" name="' . $select_name . '" style="width:140px;">';
        foreach ($all_fields as $key => $checker) {
            $return_options .= '<option value="' . $key . '" ';
            if ($key === htmlspecialchars(stripslashes($selected_val), ENT_QUOTES)) {
                $return_options .= ' selected ';
            }
            $return_options .= '>' . $checker . '</option>';
        }
        $return_options .= '</select>';
        return $return_options;
    }

endif;
?>
