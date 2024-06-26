<?php
//related listings
global $wpestate_property_unit_slider;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
global $wpestate_prop_unit;
global $post;

$not_in[]               =   $exclude=  $post->ID;
$wpestate_custom_unit_structure  =   wpresidence_get_option('wpestate_property_unit_structure');
$wpestate_uset_unit     =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row     =   intval( wpresidence_get_option('wp_estate_similar_prop_per_row', '') );
$wpestate_property_unit_slider   =   wpresidence_get_option('wp_estate_prop_list_slider','');
$counter                =   0;
$post_category          =   get_the_terms($post->ID, 'property_category');
$post_action_category   =   get_the_terms($post->ID, 'property_action_category');
$post_city_category     =   get_the_terms($post->ID, 'property_city');
$post_area_category     =   get_the_terms($post->ID, 'property_area');
$similar_no             =   wpresidence_get_option('wp_estate_similar_prop_no');
$order                  =   wpresidence_get_option('wp_estate_similar_listins_order');
$args                   =   '';
$items[]                =   '';
$items_actions[]        =   '';
$items_city[]           =   '';
$items_area[]           =   '';
$categ_array            =   '';
$action_array           =   '';
$city_array             =   '';
$area_array             =   '';
$not_in                 =   array();

$selected_categ= wpresidence_get_option('wp_estate_simialar_taxes');
     


////////////////////////////////////////////////////////////////////////////
/// compose taxomomy categ array
////////////////////////////////////////////////////////////////////////////

if ($post_category!=''):
    foreach ($post_category as $item) {
        $items[] = $item->term_id;
    }
    $categ_array=array(
            'taxonomy' => 'property_category',
            'field' => 'id',
            'terms' => $items
        );
endif;

////////////////////////////////////////////////////////////////////////////
/// compose taxomomy action array
////////////////////////////////////////////////////////////////////////////

if ($post_action_category!=''):
    foreach ($post_action_category as $item) {
        $items_actions[] = $item->term_id;
    }
    $action_array=array(
            'taxonomy' => 'property_action_category',
            'field' => 'id',
            'terms' => $items_actions
        );
endif;

////////////////////////////////////////////////////////////////////////////
/// compose taxomomy action city
////////////////////////////////////////////////////////////////////////////

if ($post_city_category!=''):
    foreach ($post_city_category as $item) {
        $items_city[] = $item->term_id;
    }
    $city_array=array(
            'taxonomy' => 'property_city',
            'field' => 'id',
            'terms' => $items_city
        );
endif;
////////////////////////////////////////////////////////////////////////////
/// compose taxomomy action area
////////////////////////////////////////////////////////////////////////////

if ($post_area_category!=''):
    foreach ($post_area_category as $item) {
        $items_area[] = $item->term_id;
    }
    $area_array=array(
            'taxonomy' => 'property_area',
            'field' => 'id',
            'terms' => $items_area
        );
endif;


////////////////////////////////////////////////////////////////////////////
/// compose wp_query
////////////////////////////////////////////////////////////////////////////
$order_array    =   wpestate_create_query_order_by_array($order);

$args=array(
    'showposts'             => $similar_no,
    'ignore_sticky_posts'   => 0,
    'post_type'             => 'estate_property',
    'post_status'           => 'publish',
    'post__not_in'          => array($exclude),
    'tax_query'             => array(
                                'relation'              => 'AND',
                              
                               )
);

$args =array_merge($args,$order_array['order_array']);

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
    if(in_array('property_area' , $selected_categ)){
        $args[ 'tax_query' ][]=$area_array;
   }    
}else{
    $args[ 'tax_query' ][]=$categ_array;
    $args[ 'tax_query' ][]=$action_array;
    $args[ 'tax_query' ][]=$city_array;
    $args[ 'tax_query' ][]=$area_array;
}



      



if( !empty($categ_array) || !empty($action_array)){

    $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
    $compare_submit     =   wpestate_get_template_link('compare_listings.php');
    $my_query           =   new WP_Query($args);

    $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }

    if ($my_query->have_posts()) { 
        $default    =  esc_html__('Similar Listings', 'wpresidence'); 
        $label      =   wpestate_property_page_prepare_label( 'wp_estate_property_similart_listings_text',$default );

        ?>

        <div class="mylistings" id="property_similar_listings">
            <?php 
            if( $is_tab!='yes'){ ?>
                <h3 class="agent_listings_title_similar" ><?php echo esc_html($label); ?></h3>
            <?php 
            }
            ?>



            <?php

            if( wpresidence_get_option('wp_estate_unit_md_similar')=="list" ) {
                global $is_shortcode;
                global $row_number_col;         
                $is_shortcode=1;
                $row_number_col=12;
            }


            while ($my_query->have_posts()):$my_query->the_post();
                   include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
            ?>
        </div>
    <?php
        $sticky_menu_array['property_similar_listings listings']= esc_html__('Similar Listings', 'wpresidence');
    } //endif have post
}//end if empty
?>


<?php
wp_reset_query();
?>
