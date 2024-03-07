<?php
/**
 * All the widgets live here
 *
 * @package   MJM_Clinic
 * @author    Matt Manning
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014 - 2024 Matt Manning
 */



/**
 * Clinic Conditions List
 *
 * @since    1.1.3
 */
class MJM_Clinic_Condition_List extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_condition_list_widget', 'description' => __( 'Displays a menu/list of health conditions', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_condition_list_widget' );
		parent::__construct( 'mjm_clinic_condition_list_widget', 'MJM Clinic: Condition List', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title    =  isset( $instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : null;
		$searchable_title       = isset( $instance['searchable_title'] ) ? $instance['searchable_title'] : 1;
		$searchable_excerpt       = isset( $instance['searchable_excerpt'] ) ? $instance['searchable_excerpt'] : 0;
		$searchable_tags     = isset( $instance['searchable_tags'] ) ? $instance['searchable_tags'] : 1;
		$show_excerpt      = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : 1;
		$show_indication_tags       = isset( $instance['show_indication_tags'] ) ? $instance['show_indication_tags'] : 1;
		$show_image       = isset( $instance['show_image'] ) ? $instance['show_image'] : 0;
		$paginate       = isset( $instance['paginate'] ) ? $instance['paginate'] : 0;

			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_condition_list">
			<?php
			if ( !empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}

			echo do_shortcode( '[mjm-clinic-condition-list searchable_title="'.$searchable_title.'" searchable_excerpt="' .$searchable_excerpt . '" searchable_tags="'.$searchable_tags.'" show_excerpt="'.$show_excerpt.'" show_indication_tags="'.$show_indication_tags.'" show_image="'.$show_image.'" paginate="'.$paginate.'"]' );
			echo '</div>';
			echo $args['after_widget'];

	}

	public function form( $instance ) {
		$defaults = array(
			'title' => __( 'Condition List', 'mjm-clinic' ),
			'searchable_title' => 1,
			'searchable_excerpt' => 0,
			'searchable_tags' => 1,
			'show_excerpt' => 1,
			'show_indication_tags' => 1,
			'show_image' => 0,
			'paginate' => 0,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$title        = apply_filters( 'widget_title', $instance['title'] );
		$searchable_title        = isset( $instance['searchable_title'] ) ? (bool) $instance['searchable_title'] : false;
		$searchable_excerpt = isset( $instance['searchable_excerpt'] ) ? (bool) $instance['searchable_excerpt'] : false;
		$searchable_tags        =  isset( $instance['searchable_tags'] ) ? (bool) $instance['searchable_tags'] : false;
		$show_excerpt     = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
		$show_indication_tags     = isset( $instance['show_indication_tags'] ) ? (bool) $instance['show_indication_tags'] : false;
		$show_image     = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
		$paginate       = ( isset( $instance['paginate'] ) && is_numeric( $instance['paginate'] ) ) ? $instance['paginate'] : 0;



		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'searchable_title' ); ?>" name="<?php echo $this->get_field_name( 'searchable_title' ); ?>"<?php checked( $searchable_title ); ?> />
			<label for="<?php echo $this->get_field_id( 'searchable_title' ); ?>"><?php _e( 'Searchable Title' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'searchable_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'searchable_excerpt' ); ?>"<?php checked( $searchable_excerpt ); ?> />
			<label for="<?php echo $this->get_field_id( 'searchable_excerpt' ); ?>"><?php _e( 'Searchable Excerpt' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'searchable_tags' ); ?>" name="<?php echo $this->get_field_name( 'searchable_tags' ); ?>"<?php checked( $searchable_tags ); ?> />
			<label for="<?php echo $this->get_field_id( 'searchable_tags' ); ?>"><?php _e( 'Searchable Tags' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>"<?php checked( $show_excerpt ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show Excerpt' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_indication_tags' ); ?>" name="<?php echo $this->get_field_name( 'show_indication_tags' ); ?>"<?php checked( $show_indication_tags ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_indication_tags' ); ?>"><?php _e( 'Show Indication Tags' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>"<?php checked( $show_image ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Image' ); ?></label>
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['searchable_title']        = !empty( $new_instance['searchable_title'] ) ? 1 : 0;
		$instance['searchable_excerpt'] = !empty( $new_instance['searchable_excerpt'] ) ? 1 : 0;
		$instance['searchable_tags'] = !empty( $new_instance['searchable_tags'] ) ? 1 : 0;
		$instance['show_excerpt'] = !empty( $new_instance['show_excerpt'] ) ? 1 : 0;
		$instance['show_indication_tags'] = !empty( $new_instance['show_indication_tags'] ) ? 1 : 0;
		$instance['show_image'] = !empty( $new_instance['show_image'] ) ? 1 : 0;
		return $instance;
	}
}


/**
 * Clinic Service Location Map Widget
 *
 * @since    1.0.1
 */
class MJM_Clinic_Location_Map extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_location_map_widget', 'description' => __( 'Displays a map on a location taxonomy page', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_location_map_widget' );
		parent::__construct( 'mjm_clinic_location_map_widget', 'MJM Clinic: Location Map', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {

		global $wp_query;
		extract( $args );
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$location_slug = $instance['location_slug'];
		$width_percent = isset( $instance['width']) && is_numeric($instance['width']) ? $instance['width'] : '100'; //%
		$height_px = isset( $instance['height']) && is_numeric($instance['height']) ? $instance['height'] : '200'; //px


		if(empty($location_slug) && is_tax( 'mjm_clinic_location' )){
			$location_slug = get_query_var( 'term' );
		}

		$location = get_term_by( 'slug', $location_slug, 'mjm_clinic_location' );


		if ( $location ) {

			echo $args['before_widget'];
			if ( !empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}

			echo do_shortcode( '[mjm-clinic-location-map id="location_map_widget" location="' . $location_slug . '"  height="'.$height_px.'px" width="'.$width_percent.'%"]' );
			echo $args['after_widget'];
		}

		return;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => __( 'Map', 'mjm-clinic' ),
			'width' => 100,
			'height' => 200,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = isset( $instance['title'] )? apply_filters( 'widget_title', $instance['title'] ) : $defaults['title'];
		$location_slug = $instance['location_slug'];
		$width = isset( $instance['width'] )? $instance['width'] : $defaults['width'];
		$height = isset( $instance['height'] )? $instance['height'] : $defaults['height'];


		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'location_slug' ); ?>"><?php _e( 'Location Slug :', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'location_slug' ); ?>" name="<?php echo $this->get_field_name( 'location_slug' ); ?>" type="text" value="<?php echo esc_attr( $location_slug ); ?>" />
			<span class="description"><?php _e( 'If specified widget will show selected location on any page. If not, widget will only show on location pages.', 'mjm-clinic' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'width' ); ?>"><?php _e( 'Width % :', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
			<span class="description"><?php _e( 'Enter width value (treated as %)', 'mjm-clinic' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'height' ); ?>"><?php _e( 'Height px :', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
			<span class="description"><?php _e( 'Enter height value (treated as %)', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['location_slug'] = $new_instance['location_slug'];
		$instance['width'] = !empty($new_instance['width']) ?  preg_replace("/[^0-9]/", "", $new_instance['width']) : 100;
		$instance['height'] = !empty($new_instance['height']) ?  preg_replace("/[^0-9]/", "", $new_instance['height']) : 200;

		return $instance;
	}
}


/**
 * Clinic Service Indication Tag Widget
 *
 * @since    1.0.1
 */
class MJM_Clinic_Indication_Tags extends WP_Widget {
	public function __construct() {

		$widget_options  = array( 'classname' => 'mjm_clinic_indication_tags_widget', 'description' => __( 'Displays a list of indication tags for service, condition, feedback and case study single posts', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_indication_tags_widget' );
		parent::__construct( 'mjm_clinic_indication_tags_widget', 'MJM Clinic: Indication Tags', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( ( !is_singular( 'mjm-clinic-service' ) &&
				!is_singular( 'mjm-clinic-condition' ) &&
				!is_singular( 'mjm-clinic-feedback' ) &&
				!is_singular( 'mjm-clinic-casestudy' ) ) ||
			!taxonomy_exists( 'mjm_clinic_indication' )
		) {
			return;
		}

		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title       = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count       = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$indications = get_the_terms( $this_post->ID, 'mjm_clinic_indication' );

		if ( $indications && count( $indications ) > 0 ) {
			echo $args['before_widget']; ?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_indication_tags">
			<?php
			if ( !empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}
			?>
            <div class="mjm_clinic_indication_tags_widget_output_entry-container">
                <i class="fa fa-tags"></i>
                <?php
                $tags = '';
                foreach ( $indications as $indication_tag ) {
                    $tags .= '<a class="mjm_clinic_indication_tags_widget_output_link" href="' . esc_url(get_term_link($indication_tag)) . '">
                                ' . esc_html($indication_tag->name) . '
                              </a>';
                }
                echo $tags;
                ?>
            </div>
			</div>
			<?php echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Related Indications', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$values = array(
			array( 'id' => false, 'text' => __( 'No', 'mjm-clinic' ) ),
			array( 'id' => true, 'text' => __( 'Yes', 'mjm-clinic' ) ) );

		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Service Locations
 *
 * @since    1.0.1
 */
class MJM_Clinic_Service_Locations extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_service_locations_widget', 'description' => __( 'Displays clinic locations for a service post', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_service_locations_widget' );

		parent::__construct( 'mjm_clinic_service_locations_widget', 'MJM Clinic: Clinic Location(s)', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !taxonomy_exists( 'mjm_clinic_location' ) || !is_singular( 'mjm-clinic-service' ) ) {
			return;
		}

		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title             = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count             = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$service_locations = get_the_terms( $this_post->ID, 'mjm_clinic_location' );

		if ( $service_locations ) { ?>
			<?php
			echo $args['before_widget'];
			?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_service_locations">
			<?php
			if ( !empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}
			$count = 0;

			foreach ( $service_locations as $location ) {
				$count ++;
				$location_meta = get_option( "taxonomy_$location->term_id" );

				if (locate_template('/mjm-clinic/widget-service-locations.php') == '') {
					include(plugin_dir_path(__FILE__) . '../views/templates/widget-service-locations.php');
				} else {
					include(get_stylesheet_directory(__FILE__) . '/mjm-clinic/widget-service-locations.php');
				}

			}
			echo '</div>';
			echo $args['after_widget'];

		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Location', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}

/**
 * Clinic Service Session Info
 *
 * @since    1.0.1
 */
class MJM_Clinic_Service_Session_Info extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_service_session_info_widget', 'description' => __( 'Displays a services session info, price', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_service_session_info_widget' );
		parent::__construct( 'mjm_clinic_service_session_info_widget', 'MJM Clinic: Service Session Info', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !is_singular( 'mjm-clinic-service' ) ) {
			return;
		}
		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		// count is the number of items to show
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Session Info', 'mjm-clinic' );

		echo $args['before_widget'];
		?>
		<div class="mjm_clinic_service_session_info_widget_output_entry-container mjm_clinic_widget_container">
			<?php
			//if only one location for this session, show big booking button
			$service_locations = get_the_terms( $this_post->ID, 'mjm_clinic_location' );

			if ( is_array( $service_locations ) && count( $service_locations ) == 1 ) {
				foreach ( $service_locations as $location ) {
					$location_meta = get_option( "taxonomy_$location->term_id" );

					if ( !empty( $location_meta['contact_link'] ) ) {
						$link = str_replace( '{service_id}', $this_post->ID, wp_strip_all_tags( $location_meta['contact_link'] ) );
						$link = str_replace( '{service_name}', urlencode( $this_post->post_title ), $link );
					}
				}
			}

			if ( !empty( $this_post->session_info ) ) {

				if (locate_template('/mjm-clinic/widget-service-session-info.php') == '') {
					include(plugin_dir_path(__FILE__) . '../views/templates/widget-service-session-info.php');
				} else {
					include(get_stylesheet_directory(__FILE__) . '/mjm-clinic/widget-service-session-info.php');
				}

			}

			?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Session Info', 'mjm-clinic' ) );
		$instance = wp_parse_args( (array) $instance, $defaults );
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


/**
 * Clinic Assigned Services Widget
 *
 * @since    1.0.1
 */
class MJM_Clinic_Assigned_Services extends WP_Widget {
	public function __construct() {
		$widget_options = array( 'classname' => 'mjm_clinic_assigned_services_widget', 'description' => __( 'Displays a list of services that were specifically assigned to a health condition, patient feedback, case study, staff member', 'mjm-clinic' ) );

		$control_options = array( 'id_base' => 'mjm_clinic_assigned_services_widget' );

		parent::__construct( 'mjm_clinic_assigned_services_widget', 'MJM Clinic: Assigned Services', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !is_singular( 'mjm-clinic-condition' ) &&
			!is_singular( 'mjm-clinic-feedback' ) &&
			!is_singular( 'mjm-clinic-casestudy')  &&
			!is_singular( 'mjm-clinic-staff' )
		) {
			return;
		}

		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count = isset( $instance['count'] ) ? $instance['count'] : - 1;

		$services = mjm_clinic_get_assigned_services( $this_post, $count );
		if ( $services ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_assigned_services">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $services as $service ) { ?>
					<div class="mjm_clinic_assigned_services_widget_output_entry-container">
						<i class="fa fa-plus-square"></i>
						<a class="mjm_clinic_assigned_services_widget_output_title-link" href="<?php echo esc_url( get_post_permalink( $service->ID ) ); ?>"><?php echo esc_html( $service->post_title ); ?></a>
					</div>
				<?php } ?>
			</div>
			<?php echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Recommended Therapies', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$values = array(
			array( 'id' => false, 'text' => __( 'No', 'mjm-clinic' ) ),
			array( 'id' => true, 'text' => __( 'Yes', 'mjm-clinic' ) ) );

		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}

/**
 * Clinic Assigned Patient Feedback
 *
 * @since    1.0.1
 */
class MJM_Clinic_Assigned_Patient_Feedback extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_assigned_patient_feedback_widget', 'description' => __( 'Displays a related feedback for condition and service single posts', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_assigned_patient_feedback_widget' );
		parent::__construct( 'mjm_clinic_assigned_patient_feedback_widget', 'MJM Clinic: Assigned Patient Feedback', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !post_type_exists( 'mjm-clinic-feedback' ) || ( !is_singular( 'mjm-clinic-service' ) && !is_singular( 'mjm-clinic-condition' ) ) ) {
			return;
		}

		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count    = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$feedback = mjm_clinic_get_assigned_feedback( $this_post, $count );

		if ( $feedback ) {
			echo $args['before_widget'];
			?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_assigned_patient_feedback">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $feedback as $feedback_entry ) {
					$permalink = get_post_permalink( $feedback_entry->ID );
					?>
						<div class="mjm_clinic_assigned_patient_feedback_widget_output_entry-container">
							<i class="fa fa-quote-left"></i>
							<span class="mjm_clinic_assigned_patient_feedback_widget_output_excerpt">
								<?php echo esc_html( $feedback_entry->post_excerpt ); ?>
							</span>
							<i class="fa fa-quote-right"></i>
							<a class="mjm_clinic_assigned_patient_feedback_widget_output_patient-name" href="<?php echo esc_url( $permalink ); ?>">
								- <?php echo esc_html( $feedback_entry->mjm_clinic_patient_name ); ?>
							</a>
							<a class="mjm_clinic_assigned_patient_feedback_widget_output_more-link" href="<?php echo esc_url( $permalink ); ?>">
								<i class="fa fa-link"></i> read more
							</a>
						</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Patient Feedback', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Assigned Related Case Studies
 *
 * @since    1.0.1
 */
class MJM_Clinic_Assigned_Case_Studies extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_assigned_case_studies_widget', 'description' => __( 'Displays a related case studies for condition and service single posts', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_assigned_case_studies_widget' );
		parent::__construct( 'mjm_clinic_assigned_case_studies_widget', 'MJM Clinic: Assigned Case Studies', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !post_type_exists( 'mjm-clinic-casestudy' ) || ( !is_singular( 'mjm-clinic-service' ) && !is_singular( 'mjm-clinic-condition' ) ) ) {
			return;
		}
		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count = isset( $instance['count'] ) ? $instance['count'] : - 1;

		//related casestudies
		$studies = mjm_clinic_get_assigned_case_studies( $this_post, $count );
		if ( $studies ) {
			echo $args['before_widget'];
			?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_assigned_case_studies">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $studies as $study ) {
					$permalink = get_post_permalink( $study->ID );
					?>
						<div class="mjm_clinic_assigned_case_studies_widget_output_entry-container">

							<a class="mjm_clinic_assigned_case_studies_widget_output_title-link"
							   href="<?php echo esc_url( $permalink ); ?>">
								<?php echo esc_html( $study->mjm_clinic_case_name ); ?>
							</a>

							<span class="mjm_clinic_assigned_case_studies_widget_output_excerpt">
								<?php echo esc_html( $study->post_excerpt ); ?>
							</span>

							<a class="mjm_clinic_assigned_case_studies_widget_output_more-link" href="<?php echo esc_url( $permalink ); ?>">
								<i class="fa fa-link"></i> read more
							</a>
						</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Case Studies', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Assigned Conditions
 *
 * @since    1.0.1
 */
class MJM_Clinic_Assigned_Conditions extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_assigned_conditions_widget', 'description' => __( 'Displays the related condition for feedback and case study single posts', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_assigned_conditions_widget' );
		parent::__construct( 'mjm_clinic_assigned_conditions_widget', 'MJM Clinic: Assigned Conditions', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !post_type_exists( 'mjm-clinic-condition' ) || ( !is_singular( 'mjm-clinic-feedback' ) && !is_singular( 'mjm-clinic-casestudy' ) && !is_singular( 'mjm-clinic-service' ) ) ) {
			return;
		}
		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count = isset( $instance['count'] ) ? $instance['count'] : - 1;

		$conditions = mjm_clinic_get_assigned_conditions( $this_post, $count );
		if ( $conditions ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_assigned_conditions">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $conditions as $condition ) {
					$permalink = get_post_permalink( $condition->ID );
					?>
						<div class="mjm_clinic_assigned_conditions_widget_output_entry-container">

							<a class="mjm_clinic_assigned_conditions_widget_output_title-link"
							   href="<?php echo esc_url( $permalink ); ?>">
								<?php echo esc_html( $condition->post_title ); ?>
							</a>

							<span class="mjm_clinic_assigned_conditions_widget_output_excerpt">
								<?php echo esc_html( $condition->post_excerpt ); ?>
							</span>

							<a class="mjm_clinic_assigned_conditions_widget_output_more-link" href="<?php echo esc_url( $permalink ); ?>">
								<i class="fa fa-link"></i> read more
							</a>
						</div>
				<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Assigned Condition', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Conditions shared symptoms (indication tags)
 *
 * @since    1.0.1
 */
class MJM_Clinic_Shared_Symptoms extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_shared_symptoms_widget', 'description' => __( 'Displays other conditions that share symptoms (indication tags)', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_shared_symptoms_widget' );
		parent::__construct( 'mjm_clinic_shared_symptoms_widget', 'MJM Clinic: Shared Symptoms', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !taxonomy_exists( 'mjm_clinic_indication' ) || ( !is_singular( 'mjm-clinic-condition' ) ) ) {
			return;
		}
		global $wp_query;
		$this_post = $wp_query->post;
		extract( $args );
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Assigned Services', 'mjm-clinic' );
		$count = isset( $instance['count'] ) ? $instance['count'] : - 1;

		$taxonomy           = 'mjm_clinic_indication';
		$terms              = wp_get_post_terms( $this_post->ID, $taxonomy );
		$related_conditions = mjm_clinic_get_post_related_posts( $this_post, 'mjm-clinic-condition', $taxonomy, $count, $terms );
		if ( count( $related_conditions ) > 0 ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_shared_symptoms">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}

				foreach ( $related_conditions as $related_condition ) { ?>
					<div class="mjm_clinic_shared_symptoms_widget_output_entry-container">

						<a class="mjm_clinic_shared_symptoms_widget_output_title-link"
						   href="<?php echo esc_url( get_post_permalink( $related_condition->ID ) ); ?>">
							<?php echo esc_html( $related_condition->post_title ); ?>
						</a>

						<span class="mjm_clinic_shared_symptoms_widget_output_entry-tag-container">
						   <?php foreach ( $terms as $term ) {
							   if ( has_term( $term, $taxonomy, $related_condition ) ) { ?>
								   <a class="mjm_clinic_shared_symptoms_widget_output_tag-link" href="<?php echo esc_url( get_term_link( $term, $taxonomy ) ); ?>">
									   <i class="fa fa-tag"></i> <?php echo esc_html( $term->name ); ?>
								   </a>
							   <?php }
						   } ?>
						</span>

					</div>
				<?php }
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Shared Symptoms', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 *
 * Clinic Related Services (by indication tags)
 *
 * @since    1.0.1
 */
class MJM_Clinic_Related_Services extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_related_services_widget', 'description' => __( 'Displays services on single tax and post pages that share indications', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_related_services_widget' );
		parent::__construct( 'mjm_clinic_related_services_widget', 'MJM Clinic: Related Services', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( ( !is_singular( 'mjm-clinic-condition' ) &&
				!is_singular( 'mjm-clinic-casestudy' ) &&
				!is_singular( 'mjm-clinic-feedback' ) &&
				!is_tax( 'mjm_clinic_indication' ) ) ||
			!taxonomy_exists( 'mjm_clinic_indication' )
		) {
			return;
		}

		global $wp_query;
		extract( $args );
		$title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Related Services', 'mjm-clinic' );
		$count      = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$taxonomy   = 'mjm_clinic_indication';
		$ignore_ids = array();

		if ( is_tax( 'mjm_clinic_indication' ) ) {
			$term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$terms = array( $term );
		} else {
			$this_post  = $wp_query->post;
			$terms      = wp_get_post_terms( $this_post->ID, $taxonomy );
			$ignore_ids = array( $this_post->ID );
		}


		if ( !is_array( $terms ) || count( $terms ) < 1 ) {
			return;
		}


		$related_services = mjm_clinic_get_posts_related_to_terms( 'mjm-clinic-service', $taxonomy, $terms, $count, $ignore_ids );

		if ( count( $related_services ) > 0 ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_related_services">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}

				foreach ( $related_services as $related_service ) { ?>
					<div class="mjm_clinic_related_services_widget_output_entry-container">
						<i class="fa fa-plus-square"></i>
						<a class="mjm_clinic_related_services_widget_output_title-link"
						   href="<?php echo esc_url( get_post_permalink( $related_service->ID ) ); ?>">
							<?php echo esc_html( $related_service->post_title ); ?>
						</a>
					</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Related Services', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );

		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Related Health Conditions (by indication tags)
 *
 * @since    1.0.1
 */
class MJM_Clinic_Related_Conditions extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_related_conditions_widget', 'description' => __( 'Displays conditions on single tax and post pages that share indications', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_related_conditions_widget' );
		parent::__construct( 'mjm_clinic_related_conditions_widget', 'MJM Clinic: Related Health Conditions', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( ( !is_singular( 'mjm-clinic-service' ) &&
				!is_singular( 'mjm-clinic-casestudy' ) &&
				!is_singular( 'mjm-clinic-feedback' ) &&
				!is_tax( 'mjm_clinic_indication' ) ) ||
			!taxonomy_exists( 'mjm_clinic_indication' )
		) {
			return;
		}
		global $wp_query;
		extract( $args );
		$title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Related Services', 'mjm-clinic' );
		$count      = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$taxonomy   = 'mjm_clinic_indication';
		$ignore_ids = array();

		if ( is_tax( 'mjm_clinic_indication' ) ) {
			$term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$terms = array( $term );

		} else {
			$this_post  = $wp_query->post;
			$terms      = wp_get_post_terms( $this_post->ID, $taxonomy );
			$ignore_ids = array( $this_post->ID );
		}

		if ( !is_array( $terms ) || count( $terms ) < 1 ) {
			return;
		}


		$related_conditions = mjm_clinic_get_posts_related_to_terms( 'mjm-clinic-condition', $taxonomy, $terms, $count, $ignore_ids );

		if ( count( $related_conditions ) > 0 ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_related_conditions">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $related_conditions as $related_condition ) { ?>
					<div class="mjm_clinic_related_conditions_widget_output_entry-container">
						<i class="fa fa-plus-square"></i>
						<a class="mjm_clinic_related_conditions_widget_output_title-link"
						   href="<?php echo esc_url( get_post_permalink( $related_condition->ID ) ); ?>">
							<?php echo esc_html( $related_condition->post_title ); ?>
						</a>
					</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Related Health Conditions', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}


/**
 * Clinic Related Feedback (by indication tags)
 *
 * @since    1.0.1
 */
class MJM_Clinic_Related_Feedback extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_related_feedback_widget', 'description' => __( 'Displays feedback on single tax and post pages that share indications', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_related_feedback_widget' );
		parent::__construct( 'mjm_clinic_related_feedback_widget', 'MJM Clinic: Related Feedback', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( ( !is_singular( 'mjm-clinic-service' ) &&
				!is_singular( 'mjm-clinic-casestudy' ) &&
				!is_singular( 'mjm-clinic-condition' ) &&
				!is_tax( 'mjm_clinic_indication' ) ) ||
			!taxonomy_exists( 'mjm_clinic_indication' )
		) {
			return false;
		}
		global $wp_query;
		extract( $args );
		$title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Related Services', 'mjm-clinic' );
		$count      = isset( $instance['count'] ) ? $instance['count'] : - 1;
		$taxonomy   = 'mjm_clinic_indication';
		$ignore_ids = array();

		if ( is_tax( 'mjm_clinic_indication' ) ) {
			$term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$terms = array( $term );

		} else {
			$this_post  = $wp_query->post;
			$terms      = wp_get_post_terms( $this_post->ID, $taxonomy );
			$ignore_ids = array( $this_post->ID );
		}


		if ( !is_array( $terms ) || count( $terms ) < 1 ) {
			return false;
		}


		$related_feedback = mjm_clinic_get_posts_related_to_terms( 'mjm-clinic-feedback', $taxonomy, $terms, $count, $ignore_ids );

		if ( count( $related_feedback ) > 0 ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_related_feedback">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $related_feedback as $related_feedback ) { ?>
					<div class="mjm_clinic_related_feedback_widget_output_entry-container">
						<i class="fa fa-plus-square"></i>
						<a class="mjm_clinic_related_feedback_widget_output_title-link"
						   href="<?php echo esc_url( get_post_permalink( $related_feedback->ID ) ); ?>">
							<?php echo esc_html( $related_feedback->post_title ); ?>
						</a>
					</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}


	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Related Feedback', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}
}

/**
 * Clinic Related Casestudy (by indication tags)
 *
 * @since    1.0.1
 */
class MJM_Clinic_Related_Casestudy extends WP_Widget {
	public function __construct() {
		$widget_options  = array( 'classname' => 'mjm_clinic_related_casestudy_widget', 'description' => __( 'Displays casestudy on single tax and post pages that share indications', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_related_casestudy_widget' );
		parent::__construct( 'mjm_clinic_related_casestudy_widget', 'MJM Clinic: Related Casestudy', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {

		if ( ( !is_singular( 'mjm-clinic-service' ) &&
				!is_singular( 'mjm-clinic-feedback' ) &&
				!is_singular( 'mjm-clinic-condition' ) &&
				!is_tax( 'mjm_clinic_indication' ) ) ||
			!taxonomy_exists( 'mjm_clinic_indication' )
		) {
			return;
		}

		global $wp_query;
		extract( $args );
		// count is the number of items to show

		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = __( 'Related Casestudy', 'mjm-clinic' );
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = - 1;
		}


		$taxonomy   = 'mjm_clinic_indication';
		$ignore_ids = array();

		if ( is_tax( 'mjm_clinic_indication' ) ) {
			$term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$terms = array( $term );

		} else {
			$this_post  = $wp_query->post;
			$terms      = wp_get_post_terms( $this_post->ID, $taxonomy );
			$ignore_ids = array( $this_post->ID );
		}


		if ( !is_array( $terms ) || count( $terms ) < 1 ) {
			return;
		}


		$related_casestudy = mjm_clinic_get_posts_related_to_terms( 'mjm-clinic-casestudy', $taxonomy, $terms, $count, $ignore_ids );

		if ( count( $related_casestudy ) > 0 ) {
			echo $args['before_widget'];?>
			<div class="mjm_clinic_widget_container mjm_clinic_widget_container_related_casestudy">
				<?php
				if ( !empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}
				foreach ( $related_casestudy as $related_casestudy ) {
					?>
					<div class="mjm_clinic_related_casestudy_widget_output_entry-container">
						<i class="fa fa-plus-square"></i>
						<a class="mjm_clinic_related_casestudy_widget_output_title-link"
						   href="<?php echo esc_url( get_post_permalink( $related_casestudy->ID ) ); ?>">
							<?php echo esc_html( $related_casestudy->post_title ); ?>
						</a>
					</div>
					<?php
				}
			echo '</div>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Related Casestudy', 'mjm-clinic' ), 'count' => - 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );


		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = $defaults['title'];
		}
		if ( isset( $instance['count'] ) ) {
			$count = $instance['count'];
		} else {
			$count = $defaults['count'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'mjm-clinic' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<span class="description"><?php _e( 'The title that displays above the widget.', 'mjm-clinic' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Count:', 'mjm-clinic' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" /><br />
			<span class="description"><?php _e( 'How many listings to display.', 'mjm-clinic' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
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

		$widget_options  = array( 'classname' => 'mjm_clinic_service_categories_widget', 'description' => __( 'A list or dropdown of clinic service categories.', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_service_categories_widget' );
		parent::__construct( 'mjm_clinic_service_categories_widget', 'MJM Clinic: Service Categories', $widget_options, $control_options );

	}

	public function widget( $args, $instance ) {
		if ( !taxonomy_exists( 'mjm_clinic_service_category' ) ) {
			return;
		}

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Service Categories' ) : $instance['title'], $instance, $this->id_base );

		$c     = !empty( $instance['count'] ) ? '1' : '0';
		$d     = !empty( $instance['dropdown'] ) ? '1' : '0';
		$h     = !empty( $instance['hierarchical'] ) ? '1' : '0';
		$depth = ( isset( $instance['depth'] ) && is_numeric( $instance['depth'] ) ) ? $instance['depth'] : '0';

		echo $args['before_widget'];?>
		<div class="mjm_clinic_widget_container mjm_clinic_widget_container_service_categories">
			<?php
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$selected = null;
			if ( is_tax( 'mjm_clinic_service_category' ) ) {
				$selected = get_query_var( 'mjm_clinic_service_category' );
			}

			if ( is_single() ) {
				$selected = wp_get_post_terms( get_the_ID(), 'mjm_clinic_service_category' );

				//if a service has multiple categories how do you choose? Only if one.
				if ( count( $selected ) == 1 ) {
					$selected = $selected[0]->slug;
				}

			}


			if ( $d ) {
				$dropdown_args = array(
					'taxonomy'         => 'mjm_clinic_service_category',
					'name'             => 'mjm_csc_dropdown_widget',
					'show_count'       => $c,
					'orderby'          => 'name',
					'hierarchical'     => $h,
					'depth'            => $depth,
					'echo'             => 1,
					'selected'         => $selected,
					'show_option_none' => __( 'Select Category' ),
					'walker'           => new MJM_Walker_SlugValueCategoryDropdown );

				wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $dropdown_args ) );
				?>

				<script type='text/javascript'>
					/* <![CDATA[ */
					var dropdown = document.getElementById("mjm_csc_dropdown_widget");
					function onCatChange() {
						if (dropdown.options[dropdown.selectedIndex].value != -1) {
							location.href = "<?php echo home_url(); ?>/?mjm_clinic_service_category=" + dropdown.options[dropdown.selectedIndex].value;
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
					$list_args = array(
						'show_option_all'    => '',
						'orderby'            => 'name',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 0,
						'hide_empty'         => 0,
						'use_desc_for_title' => 1,
						'child_of'           => null,
						'feed'               => '',
						'feed_type'          => '',
						'feed_image'         => '',
						'exclude'            => '',
						'exclude_tree'       => '',
						'include'            => '',
						'hierarchical'       => 1,
						'title_li'           => null,
						'show_option_none'   => __( 'No categories' ),
						'number'             => null,
						'echo'               => 1,
						'depth'              => $depth,
						'current_category'   => 0,
						'pad_counts'         => 0,
						'taxonomy'           => 'mjm_clinic_service_category',
						'walker'             => null
					);
					wp_list_categories( $list_args );
					?>
				</ul>
				<?php
			}
		echo '</div>';
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['count']        = !empty( $new_instance['count'] ) ? 1 : 0;
		$instance['hierarchical'] = !empty( $new_instance['hierarchical'] ) ? 1 : 0;
		$instance['dropdown']     = !empty( $new_instance['dropdown'] ) ? 1 : 0;
		$instance['depth']        = ( isset( $new_instance['depth'] ) && is_numeric( $new_instance['depth'] ) ) ? $new_instance['depth'] : 0;

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title        = esc_attr( $instance['title'] );
		$count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$depth        = ( isset( $instance['depth'] ) && is_numeric( $instance['depth'] ) ) ? $instance['depth'] : 0;
		$dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'dropdown' ); ?>" name="<?php echo $this->get_field_name( 'dropdown' ); ?>"<?php checked( $dropdown ); ?> />
			<label for="<?php echo $this->get_field_id( 'dropdown' ); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>"<?php checked( $count ); ?> />
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts' ); ?></label><br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>"<?php checked( $hierarchical ); ?> />
			<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( 'Show hierarchy' ); ?></label>
		</p>


		<p>
			<select id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>">
				<option value="0" <?php selected( $depth, 0 ); ?>>All</option>
				<option value="1" <?php selected( $depth, 1 ); ?>>Parents Only</option>
				<option value="2" <?php selected( $depth, 2 ); ?>>2 Levels</option>
				<option value="3" <?php selected( $depth, 3 ); ?>>3 Levels</option>
				<option value="4" <?php selected( $depth, 4 ); ?>>4 Levels</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'depth' ); ?>"><?php _e( 'Hierarchy Depth' ); ?></label></p>

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
		$widget_options  = array( 'classname' => 'mjm_clinic_booking_form_widget', 'description' => __( 'A Booking Form, detects relevant therapy and clinic where possible, otherwise displays with select options', 'mjm-clinic' ) );
		$control_options = array( 'id_base' => 'mjm_clinic_booking_form_widget' );
		parent::__construct( 'mjm_clinic_booking_form_widget', 'MJM Clinic: Booking Form', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		if ( !taxonomy_exists( 'mjm_clinic_location' ) ) {
			return;
		}
		global $wp_query;
		extract( $args );
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Booking Form', 'mjm-clinic' );

		/**  @TODO
		 *   Booking form has been set up as a shortcode.
		 *   Could wrap the shortcode form as a widget if requested.
		 */
		echo $args['before_widget'];?>
		<div class="mjm_clinic_widget_container mjm_clinic_widget_container_booking_form">
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = !empty( $new_instance['count'] ) ? 1 : 0;

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = esc_attr( $instance['title'] );
		$count    = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>"<?php checked( $count ); ?> />
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts' ); ?></label><br />
		</p>
		<?php
	}

}