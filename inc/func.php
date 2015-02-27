<?php
/**
 * Some helper functions used by the plugin
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <2015@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014, 2015 Matt Manning
 */

/**
 * Some functions below can return taxonomy image fields if the taxonomy-images plugin is available.
 * To check we must include the plugins file :(
 *
 */
if( !function_exists( 'get_plugin_data' ) ) {
    include_once( ABSPATH.'wp-admin/includes/plugin.php');
}

/**
 * Enabled/Disabled toggle
 * used by the options page
 *
 * @since 	1.0.0
 *
 * @return 	$result 	the array of possible values
 */
function mjm_clinic_true_false() {
	$result = array(
		'true' => array(
			'value' => true,
			'label' => __( 'Enabled', 'mjm-clinic' )
		),
		'false' => array(
			'value' => false,
			'label' => __( 'Disabled', 'mjm-clinic' )
		)
	);
	return $result;
}


/**
 * Default option settings
 *
 * @since 	1.0.0
 *
 * @return 	$defaults 	all the default settings (everything disabled)
 */
function mjm_clinic_option_defaults() {
	$defaults = array(
        'mjm_clinic_option_condition' => true,
        'mjm_clinic_option_indication' => true,
        'mjm_clinic_option_location' => true,
        'mjm_clinic_option_feedback' => false,
        'mjm_clinic_option_casestudy' => false,
		'mjm_clinic_option_price' => false,
        'mjm_clinic_option_related_product' => false,
        'mjm_clinic_option_contraindication' => false,
        'mjm_clinic_disclaimer_text ' => '',
		'comments' => false
	);
	return $defaults;
}


function mjm_clinic_get_conditions(){
    $posts = get_posts(
        array(
            'post_type' => 'mjm-clinic-condition',
            'orderby' => 'title',
            'order' => 'ASC',
            'post_status'  => 'publish',
            'posts_per_page' => -1
        )
    );
    return $posts;
}

function mjm_clinic_get_condition_list(){
    $condition_list = array();
    $posts = mjm_clinic_get_conditions();

    foreach($posts as $post){
        $condition_list[$post->ID] = $post->post_title;
    }
    return $condition_list;

}



/**
 * Recursively sort an array of taxonomy terms hierarchically. Child categories will be
 * placed under a 'children' member of their parent term.
 * @param Array   $terms     taxonomy term objects to sort
 * @param Array   $into     result array to put them in
 * @param integer $parentId the current parent ID to put them in
 */
function mjm_clinic_sort_terms_hierarchically(Array &$terms, Array &$into, $parentId = 0){
    foreach ($terms as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($terms[$i]);
        }
    }

    foreach ($into as $topCat) {
        $topCat->children = array();
        mjm_clinic_sort_terms_hierarchically($terms, $topCat->children, $topCat->term_id);
    }
}

function mjm_clinic_get_sub_service_categories($parent_term_id){
    $args = array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => false,
        'fields'            => 'all',
        'parent'            => $parent_term_id,
        'hierarchical'      => true);

    $plugin_args = array(
        'term_args' => $args,
        'taxonomy' => 'mjm_clinic_service_category',
        'having_images' => false
    );


    $plugin = 'taxonomy-images/taxonomy-images.php';
    if(is_plugin_active($plugin)){
    return apply_filters( 'taxonomy-images-get-terms', '', $plugin_args );
    }
    return get_terms(array('mjm_clinic_service_category'), $args);
}

function mjm_clinic_get_all_service_categories(){

    $args =  array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => false,
        'fields'            => 'all',
        'hierarchical'      => true
    );

    $plugin_args = array(
        'term_args' => $args,
        'taxonomy' => 'mjm_clinic_service_category',
        'having_images' => false
    );

    $plugin = 'taxonomy-images/taxonomy-images.php';
    if(is_plugin_active($plugin)){
        $categories = apply_filters( 'taxonomy-images-get-terms', '', $plugin_args );
    } else {
        $categories = get_terms(array('mjm_clinic_service_category'), $args);
    }

    $categoryHierarchy = array();
    mjm_clinic_sort_terms_hierarchically($categories, $categoryHierarchy);
    return $categoryHierarchy;
}

function mjm_clinic_get_services_in_category($term_id){
	$posts = get_posts(array(
			'post_type' => 'mjm-clinic-service',
            'posts_per_page' => -1,
            'orderby'          => 'post_title',
            'order'            => 'ASC',
            'post_status'      => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'mjm_clinic_service_category',
					'field' => 'term_id',
					'terms' => array($term_id),
                    'operator' => 'IN',
                    'include_children' => false
                )
			))
	);
	return $posts;
}



function mjm_clinic_get_condition_assigned_services($condition_post, $limit = -1){
    $service_id_array = explode(',',$condition_post->mjm_clinic_recommended_service_selected_ids);
    $posts = get_posts(
        array(
            'post__in' => $service_id_array,
            'post_type' => 'mjm-clinic-service',
            'posts_per_page' => $limit
        )
    );
    return $posts;
}



function mjm_clinic_get_service_list(){
    $service_list = array();
    $posts = get_posts(
        array(
            'post_type' => 'mjm-clinic-service',
            'order_by' => 'title',
            'post_status'  => 'publish',
            'posts_per_page' => -1
        )
    );

    foreach($posts as $post){
        $service_list[$post->ID] = $post->post_title;
    }
    return $service_list;
}


function mjm_clinic_get_location_list(){
    $location_list = array();

    $args =  array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => false,
        'fields'            => 'all',
        'hierarchical'      => false
    );

    $locations = get_terms(array('mjm_clinic_location'), $args);
        if($locations){
            foreach($locations as $location){
                $location_list[$location->term_id] = $location->name;
            }

        }
    return $location_list;
}


/**
 * Get a location data given the locations ID
 * returns post
 *
 * @since 	1.0.7
 *
 * @param 	$id 	int 		Location taxonomy ID
 * @return 	        object	    taxonomy or false
 */
function mjm_clinic_get_location($id){
    if(!is_numeric($id)){
        return false;
    }

    $term =  get_term( $id, 'mjm_clinic_location');

    if($term){
        $location_meta = get_option( "taxonomy_$id" );
        $term->meta = $location_meta;
        return $term;
    }

    return false;
}


/**
 * Get feedback that was manually assigned to a given service or condition post
 * returns posts
 *
 * @since 	1.0.1
 *
 * @param 	$post 	object 		mjm-clinic-service or mjm-clinic-condition post types
 * @param 	$limit 	int		    number of results to limit
 * @return 	        array	    posts array
 */
function mjm_clinic_get_assigned_feedback($post, $limit=-1){
    $feedback_posts =  mjm_clinic_get_assigned_('mjm-clinic-feedback',$post,$limit);
    return $feedback_posts;
}

/**
 * Get case studies manually assigned to a given service or condition post
 * returns posts
 *
 * @since 	1.0.1
 *
 * @param 	$post 	object 		mjm-clinic-service or mjm-clinic-condition post types
 * @param 	$limit 	int		    number of results to limit
 * @return 	        array	    posts array
 */
function mjm_clinic_get_assigned_case_studies($post, $limit = -1){
    return mjm_clinic_get_assigned_('mjm-clinic-casestudy',$post,$limit);
}

/**
 * Get services manually assigned to a given condition, feedback or case study post
 * returns posts
 *
 * @since 	1.0.1
 *
 * @param 	$post 	object 		mjm-clinic-condition or mjm-clinic-feedback or mjm-clinic-casestudy post types
 * @param 	$limit 	int		    number of results to limit
 * @return 	        array	    posts array
 */
function mjm_clinic_get_assigned_services($post, $limit = -1){
    return mjm_clinic_get_assigned_('mjm-clinic-service',$post,$limit);
}

/**
 * Get conditions manually assigned to a feedback or case study post
 * returns posts
 *
 * @since 	1.0.1
 *
 * @param 	$post 	object 		mjm-clinic-condition or mjm-clinic-feedback or mjm-clinic-casestudy post types
 * @param 	$limit 	int		    number of results to limit
 * @return 	        array	    posts array
 */
function mjm_clinic_get_assigned_conditions($post, $limit = -1){
    return mjm_clinic_get_assigned_('mjm-clinic-condition',$post,$limit);
}




/**
 * Get manually assigned post to a given post
 * returns posts
 *
 * @since 	1.0.1
 *
 * @param 	$post 	object 		mjm-clinic-service or mjm-clinic-condition post types
 * @param 	$limit 	int		    number of results to limit
 * @return 	        array	    posts array
 */
function mjm_clinic_get_assigned_($search_for_post_type,$post, $limit=-1){
    global $wpdb;
    $this_post_type = get_post_type($post);
    $key = false;


    if($search_for_post_type == 'mjm-clinic-service') {

        if($this_post_type == 'mjm-clinic-condition' ) {
            //multi select field so pass out
            return mjm_clinic_get_condition_assigned_services($post, $limit);
        }

        if($this_post_type == 'mjm-clinic-feedback' || ($this_post_type == 'mjm-clinic-casestudy' )) {
            //get feedback recommended services
            $service_id = $post->mjm_clinic_related_service_id;
            return array(get_post($service_id));
        }

    } else if ($search_for_post_type == 'mjm-clinic-casestudy' || $search_for_post_type == 'mjm-clinic-feedback') {

        if ($this_post_type == 'mjm-clinic-service') {
            $key = 'mjm_clinic_related_service_id';
        } else if ($this_post_type == 'mjm-clinic-condition') {
            $key = 'mjm_clinic_related_condition_id';
        }

    } else if ($search_for_post_type == 'mjm-clinic-condition') {

        if($this_post_type == 'mjm-clinic-feedback' || ($this_post_type == 'mjm-clinic-casestudy' )) {
            $condition_id = $post->mjm_clinic_related_condition_id;
            return array(get_post($condition_id));
        } else if ($this_post_type == 'mjm-clinic-service'){
            $query = "SELECT $wpdb->postmeta.post_id
                      FROM $wpdb->postmeta
                      WHERE $wpdb->postmeta.meta_key = 'mjm_clinic_recommended_service_selected_ids'
                      AND FIND_IN_SET('$post->ID', wp_postmeta.meta_value)";



            $posts = $wpdb->get_results($query, ARRAY_A);
                if($posts) {
                    $post_ids = array();
                    foreach($posts as $result){
                        $post_ids[] = $result['post_id'];
                    }

                    $args = array('post__in' => $post_ids,
                        'post_type' => $search_for_post_type,
                        'posts_per_page' => $limit,
                        'post_status' => 'publish');
                    return get_posts($args);
                }

            return false;
        }
    }

    if(!$key){
        return false;
    }

    $args = array(
        'meta_query' => array(
            array(
                'key' => $key,
                'value' => $post->ID
            )
        ),
        'post_type' => $search_for_post_type,
        'posts_per_page' => $limit,
        'post_status'  => 'publish',
    );
    return get_posts($args);
}

function mjm_clinic_get_posts_related_to_terms($get_post_type, $taxonomy, $terms=array(), $limit=-1, $ignore_ids=array()){

    if (empty($terms)) $terms = array();
    $term_list = wp_list_pluck($terms, 'term_id');

    $related_args = array(
        'post_type' => $get_post_type,
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'post__not_in' => $ignore_ids,
        'orderby' => 'modified',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'fields' => 'term_id',
                'terms' => $term_list
            )
        )
    );
    $query = new WP_Query($related_args);
    return $query->get_posts();
}
function mjm_clinic_get_post_related_posts($post, $get_post_type, $taxonomy, $limit = -1, $terms=false){

    if(!$terms){
        $terms = wp_get_post_terms( $post->ID, $taxonomy);
    }

   return mjm_clinic_get_posts_related_to_terms($get_post_type, $taxonomy, $terms, $limit, array($post->id));

}


