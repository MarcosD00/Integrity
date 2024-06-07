<?php
$use_schedule_tour                      = wpresidence_get_option('wp_estate_show_schedule_tour', '');
$use_schedule_tour_location             = wpresidence_get_option('wp_estate_show_schedule_tour_location', '');
$wp_estate_exclude_show_schedule_tour   = wpresidence_get_option('wp_estate_exclude_show_schedule_tour','');
$section_title = esc_html(wpresidence_get_option('wp_estate_property_schedule_tour_text'));
if (!isset($section_title)):
    $section_title = esc_html__('Schedule a tour','wpresidence');
endif;


if( is_array($wp_estate_exclude_show_schedule_tour) && !empty($wp_estate_exclude_show_schedule_tour) ):
    $result                 =   array();
    $terms_category         =   get_the_terms($post_id,    'property_category');
    $terms_action_category  =   get_the_terms($post_id,    'property_action_category');
    if($terms_category!==false  ){
      $result = array_merge($result, $terms_category);
    }
    if($terms_action_category!==false  ){
        $result = array_merge($result, $terms_action_category);
    }


    foreach ($result as $key => $term) {
        $temp=(array) $term;
        $term_id=intval($temp['term_id']);
        if( in_array($term_id, $wp_estate_exclude_show_schedule_tour ) ){
            $use_schedule_tour = 'no';
        }
    }

endif;



if ( $use_schedule_tour=='yes' && $use_schedule_tour_location=='content'){
    do_action('before_wpestate_schedule_tour');
    ?>

    <div class="panel-group property-panel wpestate_schedule_tour_wrapper">
        <h4><?php echo trim($section_title); ?></h4>
        <?php  
        
        include( locate_template ( 'templates/property_page/schedule_tour/schedule_tour_dates.php'));
        include( locate_template ( 'templates/property_page/schedule_tour/schedule_tour_options.php'));

        $context='schedule_section';
        include( locate_template ( 'templates/property_page/contact_form/property_page_contact_form.php'));
        ?>
    </div>

<?php
    do_action('after_wpestate_schedule_tour');
}
?> 