<?php
/**
 * All the widgets live here
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <spam2014@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014 Matt Manning
 */



/**
 * Clinic Service Location Map Widget
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Location_Map extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_location_map_widget', 'description' => __('Displays a map on a location taxonomy page', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_location_map_widget' );

        $this->WP_Widget( 'mjm_clinic_location_map_widget', 'MJM Clinic: Location Map', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;


        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Map', 'mjm-clinic'); }



        if (  is_tax('mjm_clinic_location') ) {
            $location = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


            if($location) {
                $location_meta = get_option( "taxonomy_$location->term_id" );
                if(empty($location_meta['map_link']) || !strstr($location_meta['map_link'],',')){
                    return false;
                }
                $latlng = explode(',',$location_meta['map_link']);
                $lat = trim($latlng[0]);
                $lng = trim($latlng[1]);

                if(!is_numeric($lat) || !is_numeric($lng)){
                    return false;
                }

                wp_enqueue_script( 'mjm-clinic-map-script', 'https://maps.googleapis.com/maps/api/js' );
                wp_enqueue_script( 'mjm-clinic-map-init-script', plugins_url( 'mjm-clinic/js/map.js'));


                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }
                ?>
                <div class="mjm_clinic_location_map_widget_output_container">
                    <div id="mjm_clinic_location_map_widget_output_map-canvas"></div>
                    <script type="text/javascript">
                        function mjm_clinic_location_map_widget_init() {
                            var mapCanvas = document.getElementById('mjm_clinic_location_map_widget_output_map-canvas');
                            var myLatlng = new google.maps.LatLng(<?=$lat?>, <?=$lng?>);
                            var mapOptions = {
                                center: myLatlng,
                                zoom: 15,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            }
                            var map = new google.maps.Map(mapCanvas, mapOptions)

                            var marker = new google.maps.Marker({
                                position: myLatlng,
                                map: map,
                                title: '<?=$location->name?>'
                            });
                        }
                    </script>
                    <style>
                        #mjm_clinic_location_map_widget_output_map-canvas {
                            width: 100%;
                            height: 250px;
                        }
                    </style>
                </div>

                <? echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Map', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);

        $values = array(
            array('id' => false, 'text' => __('No', 'mjm-clinic')),
            array('id' => true, 'text' => __('Yes', 'mjm-clinic')));

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }

        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>

    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }
}


/**
 * Clinic Service Indication Tag Widget
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Indication_Tags extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_indication_tags_widget', 'description' => __('Displays a list of indication tags for service, condition, feedback and case study single posts', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_indication_tags_widget' );

        $this->WP_Widget( 'mjm_clinic_indication_tags_widget', 'MJM Clinic: Indication Tags', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show
       
        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Related Indications', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-service' ) || is_singular( 'mjm-clinic-condition' ) || is_singular( 'mjm-clinic-feedback' ) || is_singular( 'mjm-clinic-casestudy' ) ) {

            $indications = get_the_terms($this_post->ID, 'mjm_clinic_indication');

            if($indications) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }
                ?>
                <div class="mjm_clinic_indication_tags_widget_output_entry-container">

                <i class="fa fa-tags"></i>
                        <?
                        $tags = '';
                        foreach ($indications as $indication_tag) {
                            $tags .= '<a class="mjm_clinic_indication_tags_widget_output_link" href="' . get_term_link($indication_tag) . '">
                                            ' . $indication_tag->name . '
                                             </a>';
                        }
                        echo $tags;
                        ?>
                </div>

                <? echo $args['after_widget'];
            }
       }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Related Indications', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);

        $values = array(
            array('id' => false, 'text' => __('No', 'mjm-clinic')),
            array('id' => true, 'text' => __('Yes', 'mjm-clinic')));

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}



/**
 * Clinic Service Locations
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Service_Locations extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_service_locations_widget', 'description' => __('Displays clinic locations for a service post', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_service_locations_widget' );

        $this->WP_Widget( 'mjm_clinic_service_locations_widget', 'MJM Clinic: Clinic Location(s)', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show
       
        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Location', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-service' )) {



            $service_locations = get_the_terms( $this_post->ID, 'mjm_clinic_location' );

            if($service_locations){
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }
                foreach ($service_locations as $location) {
                    $location_meta = get_option( "taxonomy_$location->term_id" );
                    ?>
                    <div class="mjm_clinic_service_locations_widget_output_entry-container">

                        <span class="mjm_clinic_service_locations_widget_output_location-name">
                            <i class="fa fa-hospital-o"></i> <?= wp_strip_all_tags($location->name) ?>
                        </span>

                        <span class="mjm_clinic_service_locations_widget_output_location-description">
                            <?= wpautop($location->description) ?>
                        </span>


                        <? if(!empty($location_meta['open_hours'])){?>
                        <span class="mjm_clinic_service_locations_widget_output_open-hours">
                            <?= wpautop($location_meta['open_hours']) ?>
                        </span>
                        <? } ?>


                        <? if(!empty($location_meta['tel'])){?>
                            <a class="mjm_clinic_service_locations_widget_output_tel-link"
                               href="tel:<?=wp_strip_all_tags($location_meta['tel'])?>">
                                <i class="fa fa-phone"></i> <?=wp_strip_all_tags($location_meta['tel'])?>
                            </a>
                        <? } ?>
                        <? if(!empty($location_meta['contact_link'])){
                            $link = str_replace('{service_id}',$this_post->ID, wp_strip_all_tags($location_meta['contact_link']));
                            $link = str_replace('{service_name}',urlencode($this_post->post_title), $link);
                            ?>
                            <a href="<?=$link?>"
                               class="mjm_clinic_service_locations_widget_output_booking-link">
                                <i class="fa fa-calendar"></i> Book Appointment
                            </a>
                        <? } else if(!empty($location_meta['email'])){?>
                            <a href="mailto:<?=antispambot(wp_strip_all_tags($location_meta['email']))?>"
                               class="mjm_clinic_service_locations_widget_output_booking-link">
                                <i class="fa fa-envelope"></i> Book Appointment
                            </a>
                        <? } ?>

                        <? if(!empty($location_meta['map_link'])){?>
                            <a class="mjm_clinic_service_locations_widget_output_map-link" href="<?= wp_strip_all_tags($location_meta['map_link']) ?>">
                                <i class="fa fa-map-marker"></i> Map
                            </a>
                        <? } ?>
                    </div>
                <?
                }
                echo $args['after_widget'];
            }

        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Location', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}

/**
 * Clinic Service Session Info
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Service_Session_Info extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_service_session_info_widget', 'description' => __('Displays a services session info, price', 'mjm-clinic') );
        $control_options = array( 'id_base' => 'mjm_clinic_service_session_info_widget' );
        $this->WP_Widget( 'mjm_clinic_service_session_info_widget', 'MJM Clinic: Service Session Info', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;
        $this_post = $wp_query->post;
        extract($args);
        // count is the number of items to show
        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Session Info', 'mjm-clinic'); }
        if (  is_singular( 'mjm-clinic-service' )) {
            echo $args['before_widget'];
            ?>
            <div class="mjm_clinic_service_session_info_widget_output_entry-container">
            <?
            //if only one location for this session, show big booking button
            $service_locations = get_the_terms( $this_post->ID, 'mjm_clinic_location' );

            if(is_array($service_locations) && count($service_locations) == 1){
                foreach($service_locations as $location){
                    $location_meta = get_option( "taxonomy_$location->term_id" );

                    if(!empty($location_meta['contact_link'])){
                        $link = str_replace('{service_id}',$this_post->ID, wp_strip_all_tags($location_meta['contact_link']));
                        $link = str_replace('{service_name}',urlencode($this_post->post_title), $link);
                        ?>
<!--                        <a href="--><?//=$link?><!--"-->
<!--                           class="mjm_clinic_service_session_info_widget_booking-link">-->
<!--                            BOOK APPOINTMENT-->
<!--                        </a>-->
                    <? } else if(!empty($location_meta['email'])){?>
<!--                        <a href="mailto:--><?//=antispambot(wp_strip_all_tags($location_meta['email']))?><!--"-->
<!--                           class="mjm_clinic_service_session_info_widget_booking-link">-->
<!--                            BOOK APPOINTMENT-->
<!--                        </a>-->
                    <? }
                }
            }

            if(!empty($this_post->session_info)){
                ?>
                <div class="mjm_clinic_service_session_info_widget_output_session-info-container">
                <?
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }?>
                    <div class="mjm_clinic_service_session_info_widget_output_session-info">
                    <?=wpautop($this_post->session_info)?>
                    </div>

                </div>
                <?
            }

            ?>
            </div>
            <?
            echo $args['after_widget'];
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Session Info', 'mjm-clinic'));
        $instance = wp_parse_args((array) $instance, $defaults);
        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}


/**
 * Clinic Assigned Services Widget
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Assigned_Services extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_assigned_services_widget', 'description' => __('Displays a list of services that were specifically assigned to a health condition, patient feedback or case study', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_assigned_services_widget' );

        $this->WP_Widget( 'mjm_clinic_assigned_services_widget', 'MJM Clinic: Assigned Services', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Assigned Services', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (is_singular( 'mjm-clinic-condition' ) || is_singular( 'mjm-clinic-feedback' ) || is_singular( 'mjm-clinic-casestudy' ) ) {

            $services = mjm_clinic_get_assigned_services($this_post, $count);
            if($services){
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }
                ?>

                    <?
                    foreach($services as $service) { ?>
                        <div class="mjm_clinic_assigned_services_widget_output_entry-container">
                            <i class="fa fa-plus-square"></i> <a class="mjm_clinic_assigned_services_widget_output_title-link" href="<?=get_post_permalink($service->ID)?>"><?=$service->post_title?></a>
                        </div>
                    <?}?>

                <? echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Recommended Therapies', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);

        $values = array(
            array('id' => false, 'text' => __('No', 'mjm-clinic')),
            array('id' => true, 'text' => __('Yes', 'mjm-clinic')));

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}

/**
 * Clinic Assigned Patient Feedback
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Assigned_Patient_Feedback extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_assigned_patient_feedback_widget', 'description' => __('Displays a related feedback for condition and service single posts', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_assigned_patient_feedback_widget' );

        $this->WP_Widget( 'mjm_clinic_assigned_patient_feedback_widget', 'MJM Clinic: Assigned Patient Feedback', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show
        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Locations', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-service' ) || is_singular( 'mjm-clinic-condition' ) ) {


            $feedback = mjm_clinic_get_assigned_feedback($this_post, $count);
            if($feedback){
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($feedback as $feedback_entry){
                    $permalink = get_post_permalink($feedback_entry->ID);
                    ?>
                    <div class="mjm_clinic_assigned_patient_feedback_widget_output_entry-container">
                        <i class="fa fa-quote-left"></i>
                            <span class="mjm_clinic_assigned_patient_feedback_widget_output_excerpt">
                                <?=$feedback_entry->post_excerpt?>
                            </span>
                        <i class="fa fa-quote-right"></i>
                        <a class="mjm_clinic_assigned_patient_feedback_widget_output_patient-name"  href="<?=$permalink?>">
                            - <?=$feedback_entry->mjm_clinic_patient_name?>
                        </a>
                        <a class="mjm_clinic_assigned_patient_feedback_widget_output_more-link"  href="<?=$permalink?>">
                            <i class="fa fa-link"></i> read more
                        </a>
                    </div>
                <?
                }
                echo $args['after_widget'];
            }


        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Patient Feedback', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}



/**
 * Clinic Assigned Related Case Studies
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Assigned_Case_Studies extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_assigned_case_studies_widget', 'description' => __('Displays a related case studies for condition and service single posts', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_assigned_case_studies_widget' );

        $this->WP_Widget( 'mjm_clinic_assigned_case_studies_widget', 'MJM Clinic: Assigned Case Studies', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Case Studies', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-service' ) || is_singular( 'mjm-clinic-condition' ) ) {

            //related casestudies
            $studies = mjm_clinic_get_assigned_case_studies($this_post,$count);
            if($studies){
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($studies as $study){
                    $permalink = get_post_permalink($study->ID);
                    ?>
                    <div class="mjm_clinic_assigned_case_studies_widget_output_entry-container">

                        <a class="mjm_clinic_assigned_case_studies_widget_output_title-link"
                           href="<?=$permalink?>">
                            <?=$study->mjm_clinic_case_name?>
                        </a>

                        <span class="mjm_clinic_assigned_case_studies_widget_output_excerpt">
                            <?=$study->post_excerpt?>
                        </span>

                        <a class="mjm_clinic_assigned_case_studies_widget_output_more-link" href="<?=$permalink?>">
                            <i class="fa fa-link"></i> read more
                        </a>
                    </div>
                <?
                }
                echo $args['after_widget'];
            }


        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Case Studies', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}


/**
 * Clinic Assigned Conditions
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Assigned_Conditions extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_assigned_conditions_widget', 'description' => __('Displays the related condition for feedback and case study single posts', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_assigned_conditions_widget' );

        $this->WP_Widget( 'mjm_clinic_assigned_conditions_widget', 'MJM Clinic: Assigned Conditions', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Assigned Condition', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-feedback' ) || is_singular( 'mjm-clinic-casestudy' ) ) {


            $conditions = mjm_clinic_get_assigned_conditions($this_post,$count);
            if($conditions){
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($conditions as $condition){
                    $permalink = get_post_permalink($condition->ID);
                    ?>
                    <div class="mjm_clinic_assigned_conditions_widget_output_entry-container">

                        <a class="mjm_clinic_assigned_conditions_widget_output_title-link"
                           href="<?=$permalink?>">
                            <?=$condition->post_title?>
                        </a>

                        <span class="mjm_clinic_assigned_conditions_widget_output_excerpt">
                            <?=$condition->post_excerpt?>
                        </span>

                        <a class="mjm_clinic_assigned_conditions_widget_output_more-link" href="<?=$permalink?>">
                            <i class="fa fa-link"></i> read more
                        </a>
                    </div>
                <?
                }
                echo $args['after_widget'];
            }


        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Assigned Condition', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}



/**
 * Clinic Conditions shared symptoms (indication tags)
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Shared_Symptoms extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_shared_symptoms_widget', 'description' => __('Displays other conditions that share symptoms (indication tags)', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_shared_symptoms_widget' );

        $this->WP_Widget( 'mjm_clinic_shared_symptoms_widget', 'MJM Clinic: Shared Symptoms', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;

        $this_post = $wp_query->post;

        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Case Studies', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-condition' ) ) {


            $taxonomy = 'mjm_clinic_indication';
            $terms = wp_get_post_terms( $this_post->ID, $taxonomy);
            $related_conditions = mjm_clinic_get_post_related_posts($this_post, 'mjm-clinic-condition', $taxonomy, $count, $terms);
            if(count($related_conditions) > 0) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($related_conditions as $related_condition ) { ?>
                    <div class="mjm_clinic_shared_symptoms_widget_output_entry-container">

                        <a class="mjm_clinic_shared_symptoms_widget_output_title-link"
                           href="<?=get_post_permalink($related_condition->ID)?>">
                            <?= $related_condition->post_title ?>
                        </a>

                        <span class="mjm_clinic_shared_symptoms_widget_output_entry-tag-container">
                       <?foreach($terms as $term) {
                            if(has_term( $term, $taxonomy, $related_condition )) {?>
                               <a class="mjm_clinic_shared_symptoms_widget_output_tag-link" href="<?=get_term_link( $term, $taxonomy )?>">
                                   <i class="fa fa-tag"></i> <?=$term->name?>
                               </a>
                            <?}
                        }?>
                        </span>

                    </div>
                <?}
                echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Shared Symptoms', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}



/**
 * Clinic Related Services (by indication tags)
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Related_Services extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_related_services_widget', 'description' => __('Displays services on single tax and post pages that share indications', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_related_services_widget' );

        $this->WP_Widget( 'mjm_clinic_related_services_widget', 'MJM Clinic: Related Services', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;



        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Related Services', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular( 'mjm-clinic-condition' ) || is_singular('mjm-clinic-casestudy') || is_singular('mjm-clinic-feedback')
              || is_tax('mjm_clinic_indication')) {

            $taxonomy = 'mjm_clinic_indication';
            $ignore_ids = array();

            if(is_tax('mjm_clinic_indication')){
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $terms = array($term);

            } else {
                $this_post = $wp_query->post;
                $terms = wp_get_post_terms( $this_post->ID, $taxonomy);
                $ignore_ids = array($this_post->ID);
            }

            $related_services = mjm_clinic_get_posts_related_to_terms('mjm-clinic-service', $taxonomy, $terms, $count, $ignore_ids);

            if(count($related_services) > 0) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($related_services as $related_service ) { ?>
                    <div class="mjm_clinic_related_services_widget_output_entry-container">

                        <i class="fa fa-plus-square"></i>
                        <a class="mjm_clinic_related_services_widget_output_title-link"
                           href="<?=get_post_permalink($related_service->ID)?>">
                            <?=$related_service->post_title?>
                        </a>

                    </div>
                <?}
                echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Related Services', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}


/**
 * Clinic Related Health Conditions (by indication tags)
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Related_Conditions extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_related_conditions_widget', 'description' => __('Displays conditions on single tax and post pages that share indications', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_related_conditions_widget' );

        $this->WP_Widget( 'mjm_clinic_related_conditions_widget', 'MJM Clinic: Related Health Conditions', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;



        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Related Health Conditions', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular() || is_tax('mjm_clinic_indication')) {

            $taxonomy = 'mjm_clinic_indication';
            $ignore_ids = array();

            if(is_tax('mjm_clinic_indication')){
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $terms = array($term);

            } else {
                $this_post = $wp_query->post;
                $terms = wp_get_post_terms( $this_post->ID, $taxonomy);
                $ignore_ids = array($this_post->ID);
            }

            $related_conditions = mjm_clinic_get_posts_related_to_terms('mjm-clinic-condition', $taxonomy, $terms, $count, $ignore_ids);

            if(count($related_conditions) > 0) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($related_conditions as $related_condition ) { ?>
                    <div class="mjm_clinic_related_conditions_widget_output_entry-container">

                        <i class="fa fa-plus-square"></i>
                        <a class="mjm_clinic_related_conditions_widget_output_title-link"
                           href="<?=get_post_permalink($related_condition->ID)?>">
                            <?=$related_condition->post_title?>
                        </a>

                    </div>
                <?}
                echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Related Health Conditions', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}


/**
 * Clinic Related Feedback (by indication tags)
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Related_Feedback extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_related_feedback_widget', 'description' => __('Displays feedback on single tax and post pages that share indications', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_related_feedback_widget' );

        $this->WP_Widget( 'mjm_clinic_related_feedback_widget', 'MJM Clinic: Related Feedback', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;



        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Related Feedback', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular() || is_tax('mjm_clinic_indication')) {

            $taxonomy = 'mjm_clinic_indication';
            $ignore_ids = array();

            if(is_tax('mjm_clinic_indication')){
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $terms = array($term);

            } else {
                $this_post = $wp_query->post;
                $terms = wp_get_post_terms( $this_post->ID, $taxonomy);
                $ignore_ids = array($this_post->ID);
            }

            $related_feedback = mjm_clinic_get_posts_related_to_terms('mjm-clinic-feedback', $taxonomy, $terms, $count, $ignore_ids);

            if(count($related_feedback) > 0) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($related_feedback as $related_feedback ) { ?>
                    <div class="mjm_clinic_related_feedback_widget_output_entry-container">

                        <i class="fa fa-plus-square"></i>
                        <a class="mjm_clinic_related_feedback_widget_output_title-link"
                           href="<?=get_post_permalink($related_feedback->ID)?>">
                            <?=$related_feedback->post_title?>
                        </a>

                    </div>
                <?}
                echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Related Feedback', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}

/**
 * Clinic Related Casestudy (by indication tags)
 *
 * @since 	1.0.1
 */
class MJM_Clinic_Related_Casestudy extends WP_Widget {
    public function __construct() {
        $widget_options = array( 'classname' => 'mjm_clinic_related_casestudy_widget', 'description' => __('Displays casestudy on single tax and post pages that share indications', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_related_casestudy_widget' );

        $this->WP_Widget( 'mjm_clinic_related_casestudy_widget', 'MJM Clinic: Related Casestudy', $widget_options, $control_options );
    }

    public function widget( $args, $instance ) {
        global $wp_query;



        extract($args);
        // count is the number of items to show

        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = __('Related Casestudy', 'mjm-clinic'); }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = -1; }


        if (  is_singular() || is_tax('mjm_clinic_indication')) {

            $taxonomy = 'mjm_clinic_indication';
            $ignore_ids = array();

            if(is_tax('mjm_clinic_indication')){
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $terms = array($term);

            } else {
                $this_post = $wp_query->post;
                $terms = wp_get_post_terms( $this_post->ID, $taxonomy);
                $ignore_ids = array($this_post->ID);
            }

            $related_casestudy = mjm_clinic_get_posts_related_to_terms('mjm-clinic-casestudy', $taxonomy, $terms, $count, $ignore_ids);

            if(count($related_casestudy) > 0) {
                echo $args['before_widget'];
                if(!empty($title)) {
                    echo $args['before_title'] . esc_html($title) . $args['after_title'];
                }

                foreach($related_casestudy as $related_casestudy ) { ?>
                    <div class="mjm_clinic_related_casestudy_widget_output_entry-container">

                        <i class="fa fa-plus-square"></i>
                        <a class="mjm_clinic_related_casestudy_widget_output_title-link"
                           href="<?=get_post_permalink($related_casestudy->ID)?>">
                            <?=$related_casestudy->post_title?>
                        </a>

                    </div>
                <?}
                echo $args['after_widget'];
            }
        }
    }

    public function form( $instance ) {
        $defaults = array( 'title' => __('Related Casestudy', 'mjm-clinic'), 'count' => -1 );
        $instance = wp_parse_args((array) $instance, $defaults);


        if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = $defaults['title']; }
        if ( isset( $instance['count'] ) ) { $count = $instance['count']; } else { $count = $defaults['count']; }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <span class="description"><?php _e('The title that displays above the widget.', 'mjm-clinic'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('count'); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
            <span class="description"><?php _e( 'How many listings to display.','mjm-clinic'); ?></span>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

        return $instance;
    }
}

/**
 * Service Categories widget
 *
 * @since 1.0.1
 */

class MJM_Clinic_Service_Categories extends WP_Widget {

    public function __construct() {

        $widget_options = array( 'classname' => 'mjm_clinic_service_categories_widget', 'description' => __('A list or dropdown of clinic service categories.', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_service_categories_widget' );

        $this->WP_Widget( 'mjm_clinic_service_categories_widget', 'MJM Clinic: Service Categories', $widget_options, $control_options );

    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Service Categories' ) : $instance['title'], $instance, $this->id_base );

        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $selected = null;
        if(is_tax('mjm_clinic_service_category')) {
            $selected   = get_query_var('mjm_clinic_service_category');
        }

        if(is_single()){
            $selected = wp_get_post_terms( get_the_ID(), 'mjm_clinic_service_category');

            //if a service has multiple categories how do you choose? Only if one.
            if(count($selected) == 1) {
                $selected = $selected[0]->slug;
            }

        }

        $dropdown_args = array(
            'taxonomy'      => 'mjm_clinic_service_category',
            'name'          => 'mjm_csc_dropdown_widget',
            'show_option_none'  => 'Select category',
            'show_count'        => $c,
            'orderby'       => 'name',
            'hierarchical'      => $h,
            'echo'          => 1,
            'selected'      => $selected,
            'walker'            => new MJM_Walker_SlugValueCategoryDropdown);


        if ( $d ) {
            $dropdown_args['show_option_none'] = __('Select Category');
            wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $dropdown_args ) );
            ?>

            <script type='text/javascript'>
                /* <![CDATA[ */
                var dropdown = document.getElementById("mjm_csc_dropdown_widget");
                function onCatChange() {
                    if ( dropdown.options[dropdown.selectedIndex].value != -1 ) {
                        location.href = "<?php echo home_url(); ?>/?mjm_clinic_service_category="+dropdown.options[dropdown.selectedIndex].value;
                    }
                }
                dropdown.onchange = onCatChange;
                /* ]]> */
            </script>

        <?php
        } else {
            ?>
            <ul>
                <?php
                $dropdown_args['title_li'] = '';

                /**
                 * Filter the arguments for the Categories widget.
                 *
                 * @since 2.8.0
                 *
                 * @param array $dropdown_args An array of Categories widget options.
                 */
                wp_list_categories( apply_filters( 'widget_categories_args', $dropdown_args ) );
                ?>
            </ul>
        <?php
        }

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
    <?php
    }

}



/**
 * Booking Form Widget
 *
 * @since 1.0.1
 */

class MJM_Clinic_Booking_Form extends WP_Widget {

    public function __construct() {

        $widget_options = array( 'classname' => 'mjm_clinic_service_categories_widget', 'description' => __('A list or dropdown of clinic service categories.', 'mjm-clinic') );

        $control_options = array( 'id_base' => 'mjm_clinic_service_categories_widget' );

        $this->WP_Widget( 'mjm_clinic_service_categories_widget', 'MJM Clinic: Service Categories', $widget_options, $control_options );

    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Service Categories' ) : $instance['title'], $instance, $this->id_base );

        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $selected = null;
        if(is_tax('mjm_clinic_service_category')) {
            $selected   = get_query_var('mjm_clinic_service_category');
        }

        if(is_single()){
            $selected = wp_get_post_terms( get_the_ID(), 'mjm_clinic_service_category');

            //if a service has multiple categories how do you choose? Only if one.
            if(count($selected) == 1) {
                $selected = $selected[0]->slug;
            }

        }

        $dropdown_args = array(
            'taxonomy'      => 'mjm_clinic_service_category',
            'name'          => 'mjm_csc_dropdown_widget',
            'show_option_none'  => 'Select category',
            'show_count'        => $c,
            'orderby'       => 'name',
            'hierarchical'      => $h,
            'echo'          => 1,
            'selected'      => $selected,
            'walker'            => new MJM_Walker_SlugValueCategoryDropdown);


        if ( $d ) {
            $dropdown_args['show_option_none'] = __('Select Category');
            wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $dropdown_args ) );
            ?>

            <script type='text/javascript'>
                /* <![CDATA[ */
                var dropdown = document.getElementById("mjm_csc_dropdown_widget");
                function onCatChange() {
                    if ( dropdown.options[dropdown.selectedIndex].value != -1 ) {
                        location.href = "<?php echo home_url(); ?>/?mjm_clinic_service_category="+dropdown.options[dropdown.selectedIndex].value;
                    }
                }
                dropdown.onchange = onCatChange;
                /* ]]> */
            </script>

        <?php
        } else {
            ?>
            <ul>
                <?php
                $dropdown_args['title_li'] = '';

                /**
                 * Filter the arguments for the Categories widget.
                 *
                 * @since 2.8.0
                 *
                 * @param array $dropdown_args An array of Categories widget options.
                 */
                wp_list_categories( apply_filters( 'widget_categories_args', $dropdown_args ) );
                ?>
            </ul>
        <?php
        }

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
    <?php
    }

}