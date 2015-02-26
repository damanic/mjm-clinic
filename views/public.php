<?php
/**
 * Deals with public-facing end.
 * @TODO tune default front end filters
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <2015@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014, 2015 Matt Manning
 */

add_action( 'init', 'clinic_service_category_template_check' );
add_action( 'init', 'clinic_service_single_check' );
add_action( 'init', 'clinic_service_taxonomy_check' );
add_filter('single_template', 'mjm_clinic_load_default_single_templates');
add_filter('taxonomy_template', 'load_default_taxonomy_templates');


/**
 * Post Type Default Template
 * if there's an single template for the clinic-service post type, don't do this
 *
 * @since 	1.0.0
 */
function mjm_clinic_load_default_single_templates($template)
{
	if ('mjm-clinic-service' == get_post_type(get_queried_object_id()) && !strstr($template,'single-mjm-clinic-service.php')) {
		// type and WP did NOT locate a template, use default.
//		$template = dirname(__FILE__) . '/templates/single-clinic-service.php';
//		return $template;
	}
	return $template;
}

/**
 * Post Type Default Template
 * if there's an single template for the clinic-service post type, don't do this
 *
 * @since 	1.0.0
 */
function load_default_taxonomy_templates($template)
{
    global $wp_query;
    $taxonomy = get_query_var('taxonomy');
    if ($taxonomy == 'mjm_clinic_service_category' && !strstr($template,'taxonomy-mjm_clinic_service_category.php')) {
        // type and WP did NOT locate a template, use default.
        $template = dirname(__FILE__) . '/templates/taxonomy-mjm_clinic_service_category.php';
        return $template;
    }

    if ($taxonomy == 'mjm_clinic_location' && !strstr($template,'taxonomy-mjm_clinic_location.php')) {
        // type and WP did NOT locate a template, use default.
        $template = dirname(__FILE__) . '/templates/taxonomy-mjm_clinic_service_location.php';
        return $template;
    }

    if ($taxonomy == 'mjm_clinic_indication' && !strstr($template,'taxonomy-mjm_clinic_indication.php')) {
        // type and WP did NOT locate a template, use default.
        $template = dirname(__FILE__) . '/templates/taxonomy-mjm_clinic_indication.php';
        return $template;
    }
	return $template;
}



/**
 * Post Type Archive check
 * if there's an archive template for the clinic-service post type, don't do this
 *
 * @since 	1.0.0
 */
function clinic_service_category_template_check() {;

	$archive = locate_template( 'taxonomy-mjm_clinic_service_category' );
	if ( empty($archive) ) {
		include_once(CLINIC_SERVICES_FUNC);
		$defaults = mjm_clinic_option_defaults();
		$options = get_option( 'mjm_clinic_settings', $defaults );
		// archive template for service listings not found, so do this...
		if ( isset($options['title-filter']) ) {
			switch ( $options['title-filter'] ) {
				case 'title' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title', 20 );
					break;

				case 'newline' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title_newline', 20 );
					break;

				case 'disabled' :
					break;
			}

		}

//			add_filter( 'the_content', 'filter_clinic_service_single', 20 );
//		add_filter( 'get_the_excerpt', 'filter_clinic_service_excerpt', 20 );
	}
}
/**
 * Post Type Single check
 * if there's an single.php template for the clinic-service post type, don't do this
 *
 * @since 	1.0.0
 */
function clinic_service_single_check() {;

	$single = locate_template( 'single-mjm-clinic-service.php' );
	if ( empty($single) ) {
		include_once(CLINIC_SERVICES_FUNC);
		$defaults = mjm_clinic_option_defaults();
		$options = get_option( 'mjm_clinic_settings', $defaults );
		// single template for service listings not found, so do this...
		if ( isset($options['title-filter']) ) {
			switch ( $options['title-filter'] ) {
				case 'title' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title', 20 );
					break;

				case 'newline' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title_newline', 20 );
					break;

				case 'disabled' :
					break;
			}

		}

			add_filter( 'the_content', 'filter_clinic_service_single', 20 );
	}
}

/**
 * Post Type Taxonomy check
 * if there's a taxonomy template at all, don't do this
 *
 * @since 	1.0.0
 */
function clinic_service_taxonomy_check() {;

	$taxonomy = locate_template( 'taxonomy.php' );
	if ( empty($taxonomy) ) {
		include_once(CLINIC_SERVICES_FUNC);
		$defaults = mjm_clinic_option_defaults();
		$options = get_option( 'mjm_clinic_settings', $defaults );
		// this actually makes it work better for tax archives if a taxonomy.php *doesn't* exist than if it does...maybe...
		if ( isset($options['title-filter']) ) {
			switch ( $options['title-filter'] ) {
				case 'title' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title', 20 );
					break;

				case 'newline' :
					add_filter( 'the_title', 'filter_mjm_clinic_service_category_title_newline', 20 );
					break;

				case 'disabled' :
					break;
			}

		}

//			add_filter( 'the_content', 'filter_clinic_service_single', 20 );
//		add_filter( 'get_the_excerpt', 'filter_clinic_service_excerpt', 20 );
	}
}

/**
 * Single service listing filter
 * filters the_content and adds the service listing meta data and taxonomies
 *
 * @since 	1.0.0
 */
function filter_clinic_service_single( $content ) {

	return $content;
//
//	global $post, $is_clinic_service_shortcode;
//
//	$contraindications = null;
//	$meta = null;
//	$postmeta = null;
//	include_once(CLINIC_SERVICES_FUNC);
//	$options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );
//
//	// check for contraindications
//	if ( has_term('','contraindications') ) {
//		$contraindications = '<div class="contraindications post-data alignleft">';
//		if ( get_post_meta( $post->ID, 'contraindication_image', true ) ) {
//			$contraindications .= '<img src="' . get_post_meta( $post->ID, 'contraindication_image', true ) . '" alt="' . wp_strip_all_tags(get_the_title()) . '" class="aligncenter" /><br />';
//		}
//		$contraindications .= '<ul>';
//		$contraindications .= get_contraindications('<li>','</li>');
//		$contraindications .= '</ul>';
//		$contraindications .= '</div>';
//	}
//
//	$meta = '<div class="post-meta"><hr/>';
//
//
//	if ( has_term('', 'mjm_clinic_related_product' ) ) {
//		$meta .= '<span class="mjm_clinic_related_product">';
//		$meta .= sprintf( __('<strong>Related Products:</strong> %s', 'mjm-clinic'), get_related_product() );
//		$meta .= '<span><br />';
//	}
//	if ( !empty($options['price']) ) {
//        $price = get_post_meta( $post->ID, 'price', true );
//
//			$meta .= '<span class="price">';
//			$meta .=__( '<strong>Price:</strong> &pound;'.$price.'', 'mjm-clinic' );
//			$meta .= '</span>';
//
//	}
//	$meta .= '</div>';
//
//	$postmeta = '<hr />';
//	$postmeta .= '<div class="post-data">';
//
//	if ( has_term('','mjm_clinic_service_category') ) {
//		$postmeta .= '<span class="mjm_clinic_service_category">' . sprintf( __( '<strong>Category:</strong> %s', 'mjm-clinic' ), get_service_categories()) . '</span><br />';
//	}
//	if ( has_term('','mjm_clinic_location') ) {
//		$postmeta .= '<span class="clinic_location">' . sprintf(__( '<strong>Location:</strong> %s | ', 'mjm-clinic' ), get_clinic_location()) . '</span>';
//	}
//	if ( has_term('','mjm_clinic_indication') ) {
//		$postmeta .= '<span class="indications">' . sprintf( __('<strong>Indications:</strong> %s', 'mjm-clinic'), get_indications() ) . '</span><br />';
//	}
//	$postmeta .= '</div>';
//
//	if ( ( 'mjm-clinic-service' == get_post_type() ) && in_the_loop() && !$is_clinic_service_shortcode && !is_search() ) : // only do this if we're in the loop
//		return $contraindications . $content . $meta . $postmeta;
//	else : // otherwise, don't do anything
//		return $content;
//	endif;
}

/**
 * Excerpt service listing filter
 * filters the_excerpt and adds the service listing meta data and taxonomies
 *
 * @since 	1.0.0
 */
function filter_clinic_service_excerpt( $content ) {
//	global $post, $is_clinic_service_shortcode;
//
//	$meta = null;
//	$postmeta = null;
//	include_once(CLINIC_SERVICES_FUNC);
//	$options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );
//
//	$meta = '<div class="post-meta">';
//
//
//	if ( has_term('', 'mjm_clinic_related_product' ) ) {
//		$meta .= '<span class="mjm_clinic_related_product">';
//		$meta .= sprintf( __('Related Product: %s', 'mjm-clinic'), get_related_product() );
//		$meta .= '<span><br />';
//	}
//	if ( !empty($options['price']) ) {
//        $price = get_post_meta( $post->ID, 'price', true );
//			$meta .= '<span class="price">';
//			$meta .=__( 'Price: <strong>'.$price.'</strong>', 'mjm-clinic' );
//			$meta .= '</span>';
//
//	}
//	$meta .= '</div>';
//
//	$postmeta = '<hr />';
//	$postmeta .= '<div class="post-data">';
//
//	if ( has_term('','mjm_clinic_service_category') ) {
//		$postmeta .= '<span class="mjm_clinic_service_category">' . sprintf( __( '<strong>Category:</strong> %s', 'mjm-clinic' ), get_service_categories()) . '</span><br />';
//	}
//	if ( has_term('','mjm_clinic_location') ) {
//		$postmeta .= '<span class="clinic_location">' . sprintf(__( '<strong>Location:</strong> %s | ', 'mjm-clinic' ), get_clinic_location()) . '</span>';
//	}
//	if ( has_term('','mjm_clinic_indication') ) {
//		$postmeta .= '<span class="indications">' . sprintf( __('<strong>Indications:</strong> %s', 'mjm-clinic'), get_indications() ) . '</span><br />';
//	}
//
//	$postmeta .= '</div>';
//
//	if ( ( 'mjm-clinic-service' == get_post_type() ) && in_the_loop() && !$is_clinic_service_shortcode && !is_search() ) : // only do this if we're in the loop
//		return $content . $meta . $postmeta;
//	else : // otherwise, don't do anything
//		return $content;
//	endif;
	return $content;
}

/**
 * Service listing title filter
 *
 * @since 	1.0.0
 */
function filter_mjm_clinic_service_category_title( $title ) {
	global $post;

		return $title;

}

/**
 * Service listing newline title filter
 *
 * @since 	1.0.0
 */
function filter_mjm_clinic_service_category_title_newline( $title ) {
	global $post;

	return $title;
}