<?php
/**
 * Plugin Name.
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <spam2014@mjman.net>
 * @license   GPLv3
 * @link      http://mjman.net
 * @copyright 2014 Matt Manning
 */

/**
 * Plugin class.
 *
 * @package MJM_Clinic
 * @author  Matt Manning <spam2014@mjman.net>
 */
class MJM_Clinic {

	/**
	 * Plugin version, used for triggering updates, cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.1';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'mjm-clinic';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

    /**
     * Post Types Registered by this plugin
     *
     * @since   1.0.1
     *
     * @var     array
     */
    protected $available_post_types = array('mjm-clinic-service','mjm-clinic-condition','mjm-clinic-feedback','mjm-clinic-casestudy');

	/**
	 * Initialize the plugin.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		include_once( 'views/actions.php' );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Do i18n stuff
	 *
	 * @since 1.0
	 *
	 */
	public function setup_i18n() {
	        //@TODO languages
			//load_plugin_textdomain( 'mjm-clinic', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

    /**
     * Set up rewrite rules
     *
     * @since   1.0.
     *
     */
     public function add_rewrite_rules(){

     }

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		// add mjm-clinic caps to editors
		if ( get_role('editor') ) {
			$role = get_role( 'editor' );
			$role->add_cap('add_mjm-clinic');
			$role->add_cap('publish_mjm-clinic');
			$role->add_cap('edit_mjm-clinic');
			$role->add_cap('edit_others_mjm-clinic');
			$role->add_cap('read_mjm-clinic');
			$role->add_cap('edit_published_mjm-clinic');
			$role->add_cap('delete_published_mjm-clinic');
			$role->add_cap('delete_mjm-clinic');
		}

		// add mjm-clinic caps to admins
		if ( get_role('administrator') ) {
			$role = get_role( 'administrator' );
			$role->add_cap('add_mjm-clinic');
			$role->add_cap('publish_mjm-clinic');
			$role->add_cap('edit_mjm-clinic');
			$role->add_cap('edit_others_mjm-clinic');
			$role->add_cap('read_mjm-clinic');
			$role->add_cap('edit_published_mjm-clinic');
			$role->add_cap('delete_published_mjm-clinic');
			$role->add_cap('delete_mjm-clinic');

            $role->add_cap('add_mjm_clinic_location');
			$role->add_cap('manage_clinic_service_options');
		}


        add_option( 'MJM_Clinic_Activated_Plugin', 'mjm-clinic' );


	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( get_role( 'editor' ) ) {
			$role = get_role( 'editor' );
			$role->remove_cap('add_mjm-clinic');
			$role->remove_cap('publish_mjm-clinic');
			$role->remove_cap('edit_mjm-clinic');
			$role->remove_cap('edit_others_mjm-clinic');
			$role->remove_cap('read_mjm-clinic');
			$role->remove_cap('edit_published_mjm-clinic');
			$role->remove_cap('delete_published_mjm-clinic');
			$role->remove_cap('delete_mjm-clinic');
		}

		if ( get_role( 'administrator' ) ) {
			$role = get_role( 'administrator' );
			$role->remove_cap('add_mjm-clinic');
			$role->remove_cap('publish_mjm-clinic');
			$role->remove_cap('edit_mjm-clinic');
			$role->remove_cap('edit_others_mjm-clinic');
			$role->remove_cap('read_mjm-clinic');
			$role->remove_cap('edit_published_mjm-clinic');
			$role->remove_cap('delete_published_mjm-clinic');
			$role->remove_cap('delete_mjm-clinic');

            $role->remove_cap('add_mjm_clinic_location');
			$role->remove_cap('manage_clinic_service_options');
		}


        flush_rewrite_rules();
	}

	/**
	 * Register and enqueue admin-specific style sheets
	 *
	 * @since     1.0.0
	 *
	 * @return    null
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( is_admin() && current_user_can( 'publish_mjm-clinic' ) ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}

	}

	/**
	 * Register and enqueue fontend style sheet.
	 *
	 * @since    1.0.0
     * @TODO default front end CSS should be user switchable
	 */
	public function enqueue_styles() {
		global $post;

		if (!is_admin() && (in_array(get_post_type(),$this->available_post_types) || (is_page() && has_shortcode($post->post_content, 'mjm-clinic')))) {
			wp_enqueue_style( $this->plugin_slug . '-public', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since   1.0.0
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_submenu_page(
			'edit.php?post_type=mjm-clinic-service',
			__( 'Clinic Settings', 'mjm-clinic' ),
			__( 'Settings', 'mjm-clinic' ),
			'manage_clinic_service_options',
			$this->plugin_slug . '-options',
			array( $this, 'display_plugin_admin_page' )
		);

        global $submenu;
        unset($submenu['edit.php?post_type=mjm-clinic-service'][10]);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since   1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}


	/**
	 * Register the service listing post type
	 *
	 * @since 	1.0.0
	 */
	public function register_post_type_mjm_clinic_service() {
		include_once(CLINIC_SERVICES_FUNC);
		$defaults = mjm_clinic_option_defaults();
		$options = get_option( 'mjm_clinic_settings', $defaults );
		if ( isset($options['comments']) && $options['comments'] ) {
			$supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments' );
		} else {
			$supports = array( 'title', 'editor', 'excerpt',  'thumbnail', 'revisions' );
		}

		$capabilities = array(
			'publish_posts' => 'publish_mjm-clinic',
			'edit_posts' => 'edit_mjm-clinic',
			'edit_others_posts' => 'edit_others_mjm-clinic',
			'delete_posts' => 'delete_mjm-clinic',
			'edit_post' => 'edit_mjm-clinic',
			'delete_post' => 'delete_mjm-clinic',
			'read_post' => 'read_mjm-clinic'
		);
		$labels = array(
   			'name' => __( 'Services', 'mjm-clinic' ),
            'all_items' => 'Services',
   			'singular_name' => __( 'Clinic Service', 'mjm-clinic' ),
   			'add_new' => __( 'Add New Service', 'mjm-clinic' ),
   			'add_new_item' => __( 'Add New Clinic Service', 'mjm-clinic' ),
   			'edit_item' => __( 'Edit Listing', 'mjm-clinic' ),
   			'new_item' => __( 'New Clinic Service', 'mjm-clinic' ),
   			'view_item' => __( 'View Clinic Service', 'mjm-clinic' ),
   			'search_items' => __( 'Search Clinic Services', 'mjm-clinic' ),
   			'not_found' => __( 'No service listings found', 'mjm-clinic' ),
   			'not_found_in_trash' => __( 'No service listings found in Trash', 'mjm-clinic' ),
   			'menu_name' => __( 'Clinic', 'mjm-clinic' ),);

        $args = array('labels' => $labels,
            'menu_icon' => 'dashicons-clipboard',
			'hierarchical' => false,
			'description' => 'Clinic Service',
			'supports' => $supports,
			'taxonomies' => array( 'mjm_clinic_service_category','mjm_clinic_related_product', 'mjm_clinic_indication', 'mjm_clinic_location' ),
			'public' => true,
			'show_ui' => true,
            'show_in_menu' => true,
			'menu_position' => 20,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'mjm-clinic',
			'capabilities' => $capabilities,
			'map_meta_cap' => false,
            'rewrite' => array(
                'slug' => 'therapy',
                'with_front' => false
            )
		);
		register_post_type( 'mjm-clinic-service', $args );

	}


    /**
     * Register the conditions listing post type
     *
     * @since 	1.0.0
     */
    public function register_post_type_mjm_clinic_condition() {
        include_once(CLINIC_SERVICES_FUNC);
        $defaults = mjm_clinic_option_defaults();
        $options = get_option( 'mjm_clinic_settings', $defaults );
        if ( isset($options['comments']) && $options['comments'] ) {
            $supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments' );
        } else {
            $supports = array( 'title', 'editor', 'excerpt',  'thumbnail', 'revisions' );
        }

        $capabilities = array(
            'publish_posts' => 'publish_mjm-clinic',
            'edit_posts' => 'edit_mjm-clinic',
            'edit_others_posts' => 'edit_others_mjm-clinic',
            'delete_posts' => 'delete_mjm-clinic',
            'edit_post' => 'edit_mjm-clinic',
            'delete_post' => 'delete_mjm-clinic',
            'read_post' => 'read_mjm-clinic'
        );
        $labels = array(
            'name' => __( 'Health Conditions', 'mjm-clinic' ),
            'singular_name' => __( 'Health Condition', 'mjm-clinic' ),
            'add_new' => __( 'Add New', 'mjm-clinic' ),
            'add_new_item' => __( 'Add New Health Condition', 'mjm-clinic' ),
            'edit_item' => __( 'Edit Listing', 'mjm-clinic' ),
            'new_item' => __( 'New Health Condition', 'mjm-clinic' ),
            'view_item' => __( 'View Health Condition', 'mjm-clinic' ),
            'search_items' => __( 'Search Health Conditions', 'mjm-clinic' ),
            'not_found' => __( 'No listings found', 'mjm-clinic' ),
            'not_found_in_trash' => __( 'No listings found in Trash', 'mjm-clinic' ),
            'menu_name' => __( 'Health Conditions', 'mjm-clinic' ),);

        $args = array('labels' => $labels,
            'hierarchical' => false,
            'description' => 'Health Condition',
            'supports' => $supports,
            'taxonomies' => array('mjm_clinic_indication', 'mjm_clinic_contraindication' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type=mjm-clinic-service',
            'menu_position' => 1,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'mjm-clinic',
            'capabilities' => $capabilities,
            'map_meta_cap' => false,
            'rewrite' => array(
                'slug' => 'can-we-help/condition',
                'with_front' => false
            )
        );
        register_post_type( 'mjm-clinic-condition', $args );

    }


    /**
     * Register the patient feedback listing post type
     *
     * @since 	1.0.1
     */
    public function register_post_type_mjm_clinic_patient_feedback() {
        include_once(CLINIC_SERVICES_FUNC);
        $defaults = mjm_clinic_option_defaults();
        $options = get_option( 'mjm_clinic_settings', $defaults );
        if ( isset($options['comments']) && $options['comments'] ) {
            $supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments' );
        } else {
            $supports = array( 'title', 'editor', 'excerpt',  'thumbnail', 'revisions' );
        }

        $capabilities = array(
            'publish_posts' => 'publish_mjm-clinic',
            'edit_posts' => 'edit_mjm-clinic',
            'edit_others_posts' => 'edit_others_mjm-clinic',
            'delete_posts' => 'delete_mjm-clinic',
            'edit_post' => 'edit_mjm-clinic',
            'delete_post' => 'delete_mjm-clinic',
            'read_post' => 'read_mjm-clinic'
        );
        $labels = array(
            'name' => __( 'Patient Feedback', 'mjm-clinic' ),
            'singular_name' => __( 'Patient Feedback', 'mjm-clinic' ),
            'add_new' => __( 'Add New', 'mjm-clinic' ),
            'add_new_item' => __( 'Add New Patient Feedback', 'mjm-clinic' ),
            'edit_item' => __( 'Edit Listing', 'mjm-clinic' ),
            'new_item' => __( 'New Patient Feedback', 'mjm-clinic' ),
            'view_item' => __( 'View Patient Feedback', 'mjm-clinic' ),
            'search_items' => __( 'Search Patient Feedback', 'mjm-clinic' ),
            'not_found' => __( 'No listings found', 'mjm-clinic' ),
            'not_found_in_trash' => __( 'No listings found in Trash', 'mjm-clinic' ),
            'menu_name' => __( 'Patient Feedback', 'mjm-clinic' ),);

        $args = array('labels' => $labels,
            'hierarchical' => false,
            'description' => 'Patient Feedback',
            'supports' => $supports,
            'taxonomies' => array('mjm_clinic_indication' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type=mjm-clinic-service',
            'menu_position' => 2,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'mjm-clinic',
            'capabilities' => $capabilities,
            'map_meta_cap' => false,
            'rewrite' => array(
                'slug' => 'patient-feedback',
                'with_front' => false
            )
        );
        register_post_type( 'mjm-clinic-feedback', $args );

    }

    /**
     * Register the case study listing post type
     *
     * @since 	1.0.1
     */
    public function register_post_type_mjm_clinic_case_study() {
        include_once(CLINIC_SERVICES_FUNC);
        $defaults = mjm_clinic_option_defaults();
        $options = get_option( 'mjm_clinic_settings', $defaults );
        if ( isset($options['comments']) && $options['comments'] ) {
            $supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments' );
        } else {
            $supports = array( 'title', 'editor', 'excerpt',  'thumbnail', 'revisions' );
        }

        $capabilities = array(
            'publish_posts' => 'publish_mjm-clinic',
            'edit_posts' => 'edit_mjm-clinic',
            'edit_others_posts' => 'edit_others_mjm-clinic',
            'delete_posts' => 'delete_mjm-clinic',
            'edit_post' => 'edit_mjm-clinic',
            'delete_post' => 'delete_mjm-clinic',
            'read_post' => 'read_mjm-clinic'
        );
        $labels = array(
            'name' => __( 'Case Studies', 'mjm-clinic' ),
            'singular_name' => __( 'Case Study', 'mjm-clinic' ),
            'add_new' => __( 'Add New', 'mjm-clinic' ),
            'add_new_item' => __( 'Add New Case Study', 'mjm-clinic' ),
            'edit_item' => __( 'Edit Listing', 'mjm-clinic' ),
            'new_item' => __( 'New Case Study', 'mjm-clinic' ),
            'view_item' => __( 'View Case Study', 'mjm-clinic' ),
            'search_items' => __( 'Search Case Studies', 'mjm-clinic' ),
            'not_found' => __( 'No listings found', 'mjm-clinic' ),
            'not_found_in_trash' => __( 'No listings found in Trash', 'mjm-clinic' ),
            'menu_name' => __( 'Case Studies', 'mjm-clinic' ),);

        $args = array('labels' => $labels,
            'hierarchical' => false,
            'description' => 'Case Study',
            'supports' => $supports,
            'taxonomies' => array('mjm_clinic_indication' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type=mjm-clinic-service',
            'menu_position' => 3,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'mjm-clinic',
            'capabilities' => $capabilities,
            'map_meta_cap' => false,
            'rewrite' => array(
                'slug' => 'case-study',
                'with_front' => false
            )
        );
        register_post_type( 'mjm-clinic-casestudy', $args );

    }

	/**
	 * Register the mjm_clinic_service_category taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function register_taxonomy_mjm_clinic_service_category() {
		register_taxonomy('mjm_clinic_service_category', array('mjm-clinic-service'), array(
			'label' => __('Service Categories', 'mjm-clinic'),
			'labels' => array(
				'name' => __( 'Service Categories', 'mjm-clinic' ),
				'singular_name' => __( 'Category', 'mjm-clinic' ),
				'search_items' =>  __( 'Search Categories', 'mjm-clinic' ),
				'popular_items' => __( 'Popular Categories', 'mjm-clinic' ),
				'all_items' => __( 'All Categories', 'mjm-clinic' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Category', 'mjm-clinic' ),
				'update_item' => __( 'Update Category', 'mjm-clinic' ),
				'add_new_item' => __( 'Add New Category', 'mjm-clinic' ),
				'new_item_name' => __( 'New Category Name', 'mjm-clinic' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'mjm-clinic' ),
				'add_or_remove_items' => __( 'Add or remove categories', 'mjm-clinic' ),
				'choose_from_most_used' => __( 'Choose from the most used categories', 'mjm-clinic' ),
				'not_found' => __( 'No categories found', 'mjm-clinic' ),
				'menu_name' => __( 'Service Categories', 'mjm-clinic' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'update_count_callback' => '',
			'query_var' => 'mjm_clinic_service_category',
			'rewrite' => array(
				'slug' => 'our-services',
				'with_front' => false,
				'hierarchical' => false,
			),
			'capabilities' => array(
				'manage_terms' => 'edit_mjm-clinic',
				'edit_terms' => 'edit_mjm-clinic',
				'delete_terms' => 'edit_others_mjm-clinic',
				'manage_categories' => 'edit_mjm-clinic',
				'assign_terms' => 'edit_mjm-clinic'
			),
		));
	}

	/**
	 * Add custom fields to the service category taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function add_taxonomy_form_fields_mjm_clinic_service_category(){
		?>
		<div class="form-field">
			<label for="term_meta[excerpt]"><?php _e( 'Excerpt','mjm-clinic')?></label>
			<input type="text" name="term_meta[excerpt]" id="term_meta[excerpt]" value="">
			<p class="description"><?php _e( 'This short description is used in category list views')?> </p>
		</div>

		<script type="text/javascript">
			jQuery('document').ready(function() {
				jQuery("label[for='tag-description']").text("Long Description");
			});
		</script>
	<?
	}


	/**
	 * Add custom fields to the service category taxonomy edit view
	 *
	 * @since 	1.0.0
	 */
	public function add_taxonomy_edit_form_fields_mjm_clinic_service_category($term){
		// put the term ID into a variable
		$t_id = $term->term_id;

		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" ); ?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_meta[excerpt]"><?php _e( 'Excerpt','mjm-clinic' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[excerpt]" id="term_meta[excerpt]" value="<?php echo esc_attr( $term_meta['excerpt'] ) ? esc_attr( $term_meta['excerpt'] ) : ''; ?>">
				<p class="description"><?php _e( 'This short description is used in category list views','mjm-clinic' ); ?></p>
			</td>
		</tr>
	<?
	}

    public function edit_service_category_columns($columns){
        unset($columns['description']);
        return $columns;
    }





	/**
	 * Register the related product taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function register_taxonomy_mjm_clinic_related_product() {
		register_taxonomy('mjm_clinic_related_product', array('mjm-clinic-service','mjm-clinic-condition'), array(
			'label' => __('Related Products', 'mjm-clinic'),
			'labels' => array(
				'name' => __( 'Related Products', 'mjm-clinic' ),
				'singular_name' => __( 'Related Product', 'mjm-clinic' ),
				'search_items' =>  __( 'Search Related Products', 'mjm-clinic' ),
				'popular_items' => __( 'Popular Related Products', 'mjm-clinic' ),
				'all_items' => __( 'All Related Products', 'mjm-clinic' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Related Product', 'mjm-clinic' ),
				'update_item' => __( 'Update Related Product', 'mjm-clinic' ),
				'add_new_item' => __( 'Add New Related Product', 'mjm-clinic' ),
				'new_item_name' => __( 'New Related Product Name', 'mjm-clinic' ),
				'separate_items_with_commas' => __( 'Separate Related Products with commas', 'mjm-clinic' ),
				'add_or_remove_items' => __( 'Add or remove Related Products', 'mjm-clinic' ),
				'choose_from_most_used' => __( 'Choose from the most used Related Products', 'mjm-clinic' ),
				'menu_name' => __( 'Related Products', 'mjm-clinic' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'update_count_callback' => '',
			'query_var' => 'mjm_clinic_related_product',
			'rewrite' => array(
				'slug' => 'mjm_clinic_related_product',
				'with_front' => true,
				'hierarchical' => false,
			),
			'capabilities' => array(
				'manage_terms' => 'edit_mjm-clinic',
				'edit_terms' => 'edit_mjm-clinic',
				'delete_terms' => 'edit_others_mjm-clinic',
				'manage_categories' => 'edit_mjm-clinic',
				'assign_terms' => 'edit_mjm-clinic'
			),
		));
	}

    /**
     * Add custom fields to the related product taxonomy
     *
     * @since 	1.0.0
     */
    public function add_taxonomy_form_fields_mjm_clinic_related_product(){
        ?>
        <div class="form-field">
            <label for="term_meta[stockcode]"><?php _e( 'Stockcode','mjm-clinic')?></label>
            <input type="text" name="term_meta[stockcode]" id="term_meta[stockcode]" value="">
            <p class="description"><?php _e( 'Enter this products Stockcode','mjm-clinic')?> (SKU)</p>
        </div>

        <script type="text/javascript">
            jQuery('document').ready(function() {
                jQuery("label[for='tag-description']").text("Promotional Text");
            });
        </script>
    <?
    }


    /**
     * Add custom fields to the related product taxonomy edit view
     *
     * @since 	1.0.0
     */
    public function add_taxonomy_edit_form_fields_mjm_clinic_related_product($term){
        // put the term ID into a variable
        $t_id = $term->term_id;

        // retrieve the existing value(s) for this meta field. This returns an array
        $term_meta = get_option( "taxonomy_$t_id" ); ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[stockcode]"><?php _e( 'Stockcode','mjm-clinic' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[stockcode]" id="term_meta[stockcode]" value="<?php echo esc_attr( $term_meta['stockcode'] ) ? esc_attr( $term_meta['stockcode'] ) : ''; ?>">
                <p class="description"><?php _e( 'Enter the products stockcode (SKU)','mjm-clinic' ); ?></p>
            </td>
        </tr>
    <?
    }

	/**
	 * Register the indication taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function register_taxonomy_mjm_clinic_indication() {
		register_taxonomy('mjm_clinic_indication', array('mjm-clinic-service','mjm-clinic-condition','mjm-clinic-casestudy','mjm-clinic-feedback'), array(
			'label' => __('Indication Tags', 'mjm-clinic'),
			'labels' => array(
				'name' => __( 'Indication Tags', 'mjm-clinic' ),
				'singular_name' => __( 'Indication', 'mjm-clinic' ),
				'search_items' =>  __( 'Search Indications', 'mjm-clinic' ),
				'popular_items' => __( 'Popular Indications', 'mjm-clinic' ),
				'all_items' => __( 'All Indications', 'mjm-clinic' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Indication', 'mjm-clinic' ),
				'update_item' => __( 'Update Indication', 'mjm-clinic' ),
				'add_new_item' => __( 'Add New Indication', 'mjm-clinic' ),
				'new_item_name' => __( 'New Indication Name', 'mjm-clinic' ),
				'separate_items_with_commas' => __( 'Separate Indications with commas', 'mjm-clinic' ),
				'add_or_remove_items' => __( 'Add or remove Indications', 'mjm-clinic' ),
				'choose_from_most_used' => __( 'Choose from the most used Indications', 'mjm-clinic' ),
				'menu_name' => __( 'Indication Tags', 'mjm-clinic' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'update_count_callback' => '',
			'query_var' => 'mjm_clinic_indication',
			'rewrite' => array(
				'slug' => 'symptom-indication',
				'with_front' => true,
				'hierarchical' => false,
			),
			'capabilities' => array(
				'manage_terms' => 'edit_mjm-clinic',
				'edit_terms' => 'edit_mjm-clinic',
				'delete_terms' => 'edit_others_mjm-clinic',
				'manage_categories' => 'edit_mjm-clinic',
				'assign_terms' => 'edit_mjm-clinic'
			),
		));
	}



    /**
     * Register the clinic-location taxonomy
     *
     * @since 	1.0.0
     */
    public function register_taxonomy_mjm_clinic_location() {
        register_taxonomy('mjm_clinic_location', array('mjm-clinic-service'), array(
            'label' => __('Service Locations', 'mjm-clinic'),
            'labels' => array(
                'name' => __( 'Service Locations', 'mjm-clinic' ),
                'singular_name' => __( 'Location', 'mjm-clinic' ),
                'search_items' =>  __( 'Search Location', 'mjm-clinic' ),
                'popular_items' => __( 'Popular Location', 'mjm-clinic' ),
                'all_items' => __( 'All Location', 'mjm-clinic' ),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __( 'Edit Location', 'mjm-clinic' ),
                'update_item' => __( 'Update Location', 'mjm-clinic' ),
                'add_new_item' => __( 'Add New Location', 'mjm-clinic' ),
                'new_item_name' => __( 'New Location Name', 'mjm-clinic' ),
                'separate_items_with_commas' => __( 'Separate Location with commas', 'mjm-clinic' ),
                'add_or_remove_items' => __( 'Add or remove Location', 'mjm-clinic' ),
                'choose_from_most_used' => __( 'Choose from the most used Location', 'mjm-clinic' ),
                'menu_name' => __( 'Service Locations', 'mjm-clinic' ),
            ),
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => false,
            'update_count_callback' => '',
            'query_var' => 'mjm_clinic_location',
            'rewrite' => array(
                'slug' => 'mjm_clinic_location',
                'with_front' => false,
                'hierarchical' => false,
            ),
            'capabilities' => array(
                'manage_terms' => 'edit_mjm-clinic',
                'edit_terms' => 'edit_mjm-clinic',
                'delete_terms' => 'edit_mjm-clinic',
                'assign_terms' => 'edit_mjm-clinic'
            )
        ));
    }

	/**
	 * Add custom fields to the clinic location taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function add_taxonomy_form_fields_mjm_clinic_location(){
		?>
		<div class="form-field">
			<label for="term_meta[tel]"><?php _e( 'Phone','mjm-clinic')?></label>
			<input type="text" name="term_meta[tel]" id=" term_meta[tel]" value="">
			<p class="description"><?php _e( 'Booking Phone','mjm-clinic')?></p>
		</div>

		<div class="form-field">
			<label for="term_meta[email]"><?php _e( 'Email','mjm-clinic')?></label>
			<input type="text" name="term_meta[email]" id="term_meta[email]" value="">
			<p class="description"><?php _e( 'Booking Email','mjm-clinic')?></p>
		</div>

        <div class="form-field">
            <label for="term_meta[contact_link]"><?php _e( 'Contact Link','mjm-clinic')?></label>
            <input type="text" name="term_meta[contact_link]" id="term_meta[contact_link]" value="">
            <p class="description"><?php _e( 'URL Link to a booking/contact form.
                                              You can use {service_id} and or {service_name} placeholders in your URL
                                              if you want to pass this information to your contact form.
                                              An entry in this field will over-ride email display in widgets.','mjm-clinic')?></p>
        </div>

		<div class="form-field">
			<label for="term_meta[open_hours]"><?php _e( 'Open Hours','mjm-clinic')?></label>
			<textarea cols="40" rows="6" name="term_meta[open_hours]" id="term_meta[open_hours]"></textarea>
			<p class="description"><?php _e( 'Operational hours, for this location.','mjm-clinic')?></p>
		</div>

        <div class="form-field">
            <label for="term_meta[map_link]"><?php _e( 'Map Link','mjm-clinic')?></label>
            <input type="text" name="term_meta[map_link]" id="term_meta[map_link]" value="">
            <p class="description"><?php _e( 'A URL link to a location map','mjm-clinic')?></p>
        </div>

		<script type="text/javascript">
			jQuery('document').ready(function() {
				jQuery("label[for='description']").text('<?php _e( 'Address','mjm-clinic')?>');
			});
		</script>
	<?
	}


	/**
     * Add custom fields to the clinic_location taxonomy edit view
     *
     * @since 	1.0.0
     */
    public function add_taxonomy_edit_form_fields_mjm_clinic_location($term){
        // put the term ID into a variable
        $t_id = $term->term_id;

        // retrieve the existing value(s) for this meta field. This returns an array
        $term_meta = get_option( "taxonomy_$t_id" ); ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[tel]"><?php _e( 'Phone','mjm-clinic' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[tel]" id="term_meta[tel]" value="<?php echo esc_attr( $term_meta['tel'] ) ? esc_attr( $term_meta['tel'] ) : ''; ?>">
                <p class="description"><?php _e( 'Booking Phone','mjm-clinic' ); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[email]"><?php _e( 'Email','mjm-clinic' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[email]" id="term_meta[email]" value="<?php echo esc_attr( $term_meta['email'] ) ? esc_attr( $term_meta['email'] ) : ''; ?>">
                <p class="description"><?php _e( 'Booking Email','mjm-clinic' ); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[contact_link]"><?php _e( 'Contact Link','mjm-clinic' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[contact_link]" id="term_meta[contact_link]" value="<?php echo esc_attr( $term_meta['contact_link'] ) ? esc_attr( $term_meta['contact_link'] ) : ''; ?>">
                <p class="description"><?php _e( 'URL Link to a booking/contact form.
                                              You can use {service_id} and or {service_name} placeholders in your URL
                                              if you want to pass this information to your contact form.
                                              An entry in this field will over-ride email display in widgets.','mjm-clinic' ); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[open_hours]"><?php _e( 'Open Hours','mjm-clinic' ); ?></label></th>
            <td>
                <textarea cols="40" rows="6" name="term_meta[open_hours]" id="term_meta[open_hours]"><?php echo esc_attr( $term_meta['open_hours'] ) ? esc_attr( $term_meta['open_hours'] ) : ''; ?></textarea>
                <p class="description"><?php _e( 'Operational hours for this location','mjm-clinic' ); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[map_link]"><?php _e( 'Map Link','mjm-clinic' ); ?></label></th>
            <td>
                <input type="text" name="term_meta[map_link]" id="term_meta[map_link]" value="<?php echo esc_attr( $term_meta['map_link'] ) ? esc_attr( $term_meta['map_link'] ) : ''; ?>">
                <p class="description"><?php _e( 'Enter a link to location map','mjm-clinic' ); ?></p>
            </td>
        </tr>
        <script type="text/javascript">
            jQuery('document').ready(function() {
                jQuery("label[for='description']").text('<?php _e( 'Address','mjm-clinic')?>');
            });
        </script>
    <?
    }

	/**
	 * Register the contraindications taxonomy
	 *
	 * @since 	1.0.0
	 */
	public function register_taxonomy_mjm_clinic_contraindication() {
		register_taxonomy('mjm_clinic_contraindication', array('mjm-clinic-service','mjm-clinic-condition'), array(
			'label' => __('Contraindication Tags', 'mjm-clinic'),
			'labels' => array(
				'name' => __( 'Contraindication Tags', 'mjm-clinic' ),
				'singular_name' => __( 'Contraindication', 'mjm-clinic' ),
				'search_items' =>  __( 'Search Contraindications', 'mjm-clinic' ),
				'popular_items' => __( 'Popular Contraindications', 'mjm-clinic' ),
				'all_items' => __( 'All Contraindications', 'mjm-clinic' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Contraindication', 'mjm-clinic' ),
				'update_item' => __( 'Update Contraindication', 'mjm-clinic' ),
				'add_new_item' => __( 'Add New Contraindication', 'mjm-clinic' ),
				'new_item_name' => __( 'New Contraindication Name', 'mjm-clinic' ),
				'separate_items_with_commas' => __( 'Separate Contraindications with commas', 'mjm-clinic' ),
				'add_or_remove_items' => __( 'Add or remove Contraindications', 'mjm-clinic' ),
				'choose_from_most_used' => __( 'Choose from the most used Contraindications', 'mjm-clinic' ),
				'menu_name' => __( 'Contraindication Tags', 'mjm-clinic' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'update_count_callback' => '',
			'query_var' => 'mjm_clinic_contraindication',
			'rewrite' => array(
				'slug' => 'mjm_clinic_contraindication',
				'with_front' => true,
				'hierarchical' => false,
			),
			'capabilities' => array(
				'manage_terms' => 'edit_mjm-clinic',
				'edit_terms' => 'edit_mjm-clinic',
				'delete_terms' => 'edit_others_mjm-clinic',
				'manage_categories' => 'edit_mjm-clinic',
				'assign_terms' => 'edit_mjm-clinic'
			),
		));
	}





    /**
     * Save custom taxonomy fields
     *
     * @since 	1.0.0
     */
    public function save_taxonomy_custom_meta( $term_id ) {
        if ( isset( $_POST['term_meta'] ) ) {
            $t_id = $term_id;
            $term_meta = get_option( "taxonomy_$t_id" );
            $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ) {
                if ( isset ( $_POST['term_meta'][$key] ) ) {
                    $term_meta[$key] = sanitize_text_field($_POST['term_meta'][$key]);
                }
            }
            // Save the option array.
            update_option( "taxonomy_$t_id", $term_meta );
        }
    }

    /**
     * Block Unauthorised additions to taxonomies
     *
     * @since 	1.0.1
     */
    function block_unauthorised_taxonomy_additions ($term, $taxonomy) {

        if ('mjm_clinic_location' === $taxonomy && !current_user_can('add_mjm_clinic_location')) {
            return new WP_Error('term_addition_blocked', __('You do not have the required permissions to add a clinic location'));
        }
        return $term;
    }




	/**
	 * Moves the taxonomy meta boxes around and modifies the featured image text
	 *
	 * @since 	1.0.0
	 */
	public function move_meta_boxes() {
		global $wp_meta_boxes;

		$screen = get_current_screen();
		if ( 'mjm-clinic-service' != $screen->post_type ) {
			return;
		} else {

			include_once(CLINIC_SERVICES_FUNC);


			remove_meta_box( 'postimagediv', 'mjm-clinic-service', 'side' );
			add_meta_box('postimagediv', __('Service Cover', 'mjm-clinic'), 'post_thumbnail_meta_box', 'mjm-clinic-service', 'side', 'high');

			$options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );




			if ( isset($options['mjm_clinic_location']) && ($options['mjm_clinic_location']  == true) ) {
				//unset( $wp_meta_boxes['mjm-clinic-service']['side']['core']['clinic-locationdiv'] );
				//remove_meta_box('tagsdiv-clinic-location', 'mjm-clinic-service', 'side' );
				//add_meta_box( 'clinic-locationdiv', __( 'Location', 'mjm-clinic' ), 'post_categories_meta_box', 'mjm-clinic-service', 'normal', 'core', array( 'taxonomy' => 'mjm_clinic_location' ) );
			}

			if ( isset($options['mjm_clinic_related_product']) && ($options['mjm_clinic_related_product']  == true) ) {
//				unset( $wp_meta_boxes['mjm-clinic-service']['side']['core']['tagsdiv-mjm_clinic_related_product'] );
//				add_meta_box( 'tagsdiv-mjm_clinic_related_product', __( 'Related Products', 'mjm-clinic' ), 'post_tags_meta_box', 'mjm-clinic-service', 'normal', 'core', array( 'taxonomy' => 'mjm_clinic_related_product' ) );
			}


		}
	}

	/**
	 * Adds the Additional Information meta boxes in admin
	 *
	 * @since 	1.0.1
	 */
	public function mjm_clinic_meta_boxes() {
		add_meta_box( 'mjm-clinic-service-meta', __('Additional Information', 'mjm-clinic'), array($this,'mjm_clinic_service_box'), 'mjm-clinic-service', 'normal', 'default' );
        add_meta_box( 'mjm-clinic-condition-meta', __('Additional Information', 'mjm-clinic'), array($this,'mjm_clinic_condition_box'), 'mjm-clinic-condition', 'normal', 'default' );
        add_meta_box( 'mjm-clinic-feedback-meta', __('Additional Information', 'mjm-clinic'), array($this,'mjm_clinic_patient_feedback_box'), 'mjm-clinic-feedback', 'normal', 'default' );
        add_meta_box( 'mjm-clinic-casestudy-meta', __('Additional Information', 'mjm-clinic'), array($this,'mjm_clinic_case_study_box'), 'mjm-clinic-casestudy', 'normal', 'default' );

    }


    /**
     * Renters the actual content of the Additional Information meta box
     *
     * @since 	1.0.0
     *   //related services
    include(plugin_dir_path( __FILE__ ) . 'views/templates/field-recommended_services.php');

     */
    public function mjm_clinic_service_box() {
        global $post;

        include_once(CLINIC_SERVICES_FUNC);

        $options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );

        echo '<input type="hidden" name="noncename" id="noncename" value="' .
            wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

        echo '<div class="session_info-meta">';
        echo '<label for="session_info"><strong>' . __( 'Session Info:', 'mjm-clinic' ) . '</strong></label><br />';
        echo '<textarea cols="40" rows="6" style="width:90%" id="session_info" name="session_info">'.wp_strip_all_tags( get_post_meta( $post->ID, 'session_info', true ), false ) . '</textarea>';
        echo '</div>';


        if ( isset($options['price']) && ($options['price'] == true) ) {
            echo '<div class="price-box">';
            echo '<label for="price"><strong>' . __( 'Session Price:', 'mjm-clinic' ) . '</strong></label><br />';
            echo '<input class="widefat" id="price" name="price" value="' . wp_strip_all_tags( get_post_meta( $post->ID, 'price', true ), true ) . '" type="number" step="any" />';
            echo '</div>';
        }
        echo '<div style="clear:both"></div>';

//		if ( isset($options['contraindications']) && ($options['contraindications'] == true) ) {
//			echo '<div class="contraindication-image-upload">';
//			echo '<label for-"contraindication-image-upload"><strong>' . __( 'Upload Contraindication Image', 'mjm-clinic' ) . '</strong></label><br />';
//			echo '<input style="width: 55%;" id="contraindication_image" class="contraindication_image" name="contraindication_image" value="' . get_post_meta($post->ID, 'contraindication_image', true) . '" type="text" /> <input id="upload_file_image_button" type="button" class="upload_button button button-primary" value="Upload Image" />';
//			echo '</div>';
//		}
    }


    /**
     * Render content for conditions meta box
     *
     * @since 	1.0.1
     *
     */
    public function mjm_clinic_condition_box() {
        global $post;

        include_once(CLINIC_SERVICES_FUNC);
        $service_posts = mjm_clinic_get_condition_assigned_services($post);
        $options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );

        echo '<input type="hidden" name="noncename" id="noncename" value="' .
            wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

        //render recommended services multiselect list
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-recommended_services.php');

    }

    /**
     * Render content for patient feedback meta box
     *
     * @since 	1.0.1
     *
     */
    public function mjm_clinic_patient_feedback_box() {
        global $post;
        include_once(CLINIC_SERVICES_FUNC);
        $options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );

        echo '<input type="hidden" name="noncename" id="noncename" value="' .
            wp_create_nonce( plugin_basename(__FILE__) ) . '" />';


        //patient name field
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-patient-name.php');

        //render related post fields
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-select-service.php');
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-select-condition.php');

    }

    /**
     * Render content for case study meta box
     *
     * @since 	1.0.1
     *
     */
    public function mjm_clinic_case_study_box() {
        global $post;
        include_once(CLINIC_SERVICES_FUNC);
        $options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );

        echo '<input type="hidden" name="noncename" id="noncename" value="' .
            wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

        //case name field
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-case-name.php');

        //render related post fields
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-select-service.php');
        include(plugin_dir_path( __FILE__ ) . 'views/templates/field-select-condition.php');

    }






    /**
	 * Registers the options
	 *
	 * @since 	1.0.0
	 */
	public function settings_init()
    {
        register_setting('mjm_clinic_settings', 'mjm_clinic_settings');

        if (is_admin()) {

            if (get_option('MJM_Clinic_Activated_Plugin') == 'mjm-clinic') {
                delete_option('MJM_Clinic_Activated_Plugin');
                flush_rewrite_rules(true);
            }


        }
	}

    /**
     * Check for update scripts. Run on init, one time
     *
     * @since   1.0.1
     */
    function check_update_scripts(){
        //ONE OFF IMPORT
        $update_id = 'MJM_Clinic_UPDATED_'.$this->version;
        if (get_option($update_id) == 'true'){
            $version_string = str_replace('.','_',$this->version);
            $update_method = 'mjm_clinic_update_v'.$version_string;
            if(method_exists($this,$update_method)){
                $this->$update_method();
                add_option( $update_id, 'true' );
            }
        }
    }





	/**
	 * Filter for the featured image post box
	 *
	 * @since 	1.0.0
	 */
	public function change_thumbnail_html( $content ) {
	    if ('mjm-clinic-service' == $GLOBALS['post_type'])
	      add_filter('admin_post_thumbnail_html', array($this,'do_thumb'));
	}

	/**
	 * Replaces "Set featured image" with "Select Service Cover"
	 *
	 * @since 	1.0.0
	 *
	 * @return 	string 	returns the modified text
	 */
	public function do_thumb($content){
		 return str_replace(__('Set featured image'), __('Select Service Cover', 'mjm-clinic'),$content);
	}

	/**
	 * Creates new columns for the Clinic Services dashboard page
	 *
	 * @since 	1.0.0
	 *
	 * @return 	array $columns
	 */
	public function edit_clinic_service_columns( $columns ) {
		$default_columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'mjm-clinic' ),
			'mjm_clinic_service_category' => __( 'Category', 'mjm-clinic' ),
		);
		$clinic_location_column = array();
		if ( taxonomy_exists( 'mjm_clinic_location' ) ) {
			$clinic_location_column = array( 'mjm_clinic_location' => __( 'Location', 'mjm-clinic' ) );
		}

		$indication_column = array();
		if ( taxonomy_exists( 'mjm_clinic_indication' ) ) {
			$indication_column = array( 'mjm_clinic_indication' => __( 'Indications', 'mjm-clinic' ) );
		}
		$related_product_column = array();
		if ( taxonomy_exists( 'mjm_clinic_related_product' ) ) {
			$related_product_column = array( 'mjm_clinic_related_product' => __( 'Related Product', 'mjm-clinic' ) );
		}
		$contraindications_column = array();
		if ( taxonomy_exists( 'mjm_clinic_contraindication' ) ) {
			$contraindications_column = array( 'mjm_clinic_contraindication' => __( 'Contraindications', 'mjm-clinic' ) );
		}

		$columns = array_merge($default_columns, $clinic_location_column, $indication_column, $related_product_column, $contraindications_column);

		return $columns;
	}

	/**
	 * Renders new data for the new columns
	 *
	 * @since 	1.0.0
	 */
	public function manage_clinic_service_columns( $column, $post_id ){
		global $post;

		switch( $column ) {



			// if displaying the mjm_clinic_service_category column
			case 'mjm_clinic_service_category' :
				// get the mjm_clinic_service_category(s) for the service
				$terms = get_the_terms( $post_id, 'mjm_clinic_service_category' );

				// if terms were found
				if ( !empty( $terms ) ) {

					$out = array();

					// loop through each term, linking to the 'edit posts' page for the specific term
					foreach( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mjm_clinic_service_category' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mjm_clinic_service_category', 'display' ) )
						);
					}

					// join the terms, separating them with a comma
					echo join( ', ', $out );
				}
				// if no terms are found, say something
				else {
					_e( 'No categories found', 'mjm-clinic' );
				}
				break;

			// if displaying the location column
			case 'mjm_clinic_location' :
				// get the location(s) for the service
				$terms = get_the_terms( $post_id, 'mjm_clinic_location' );

				// if terms were found
				if ( !empty( $terms ) ) {

					$out = array();

					// loop through each term, linking to the 'edit posts' page for the specific term
					foreach( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mjm_clinic_location' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mjm_clinic_location', 'display' ) )
						);
					}

					// join the terms, separating them with a comma
					echo join( ', ', $out );
				}
				// if no terms are found, say something
				else {
					_e( 'No location found', 'mjm-clinic' );
				}
				break;



			// if displaying the indications column
			case 'mjm_clinic_indication' :
				// get the indications for the service
				$terms = get_the_terms( $post_id, 'mjm_clinic_indication' );

				// if terms were found
				if ( !empty( $terms ) ) {

					$out = array();

					// loop through each term, linking to the 'edit posts' page for the specific term
					foreach( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mjm_clinic_indication' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mjm_clinic_indication', 'display' ) )
						);
					}

					// join the terms, separating them with a comma
					echo join( ', ', $out );
				}
				// if no terms are found, say something
				else {
					_e( 'No indications found', 'mjm-clinic' );
				}
				break;

			// if displaying the related product column
			case 'mjm_clinic_related_product' :
				// get the related product for the service
				$terms = get_the_terms( $post_id, 'mjm_clinic_related_product' );

				// if terms were found
				if ( !empty( $terms ) ) {

					$out = array();

					// loop through each term, linking to the 'edit posts' page for the specific term
					foreach( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mjm_clinic_related_product' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mjm_clinic_related_product', 'display' ) )
						);
					}

					// join the terms, separating them with a comma
					echo join( ', ', $out );
				}
				// if no terms are found, say something
				else {
					_e( 'No related product found', 'mjm-clinic' );
				}
				break;

			// if displaying the contraindications column
			case 'mjm_clinic_contraindication' :
				// get the contraindications for the service
				$terms = get_the_terms( $post_id, 'mjm_clinic_contraindication' );

				// if terms were found
				if ( !empty( $terms ) ) {

					$out = array();

					// loop through each term, linking to the 'edit posts' page for the specific term
					foreach( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mjm_clinic_contraindication' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mjm_clinic_contraindication', 'display' ) )
						);
					}

					// join the terms, separating them with a comma
					echo join( ', ', $out );
				}
				// if no terms are found, say something
				else {
					_e( 'No contraindications found', 'mjm-clinic' );
				}
				break;



			// just break out of the switch statement for everything else
			default :
				break;
		}
	}



	/**
	 * Saves the clinic-service post meta data
	 *
	 * @since 	1.0.0
	 */
	public function save_mjm_clinic_postmeta($post_id, $post) {
		$nonce = isset( $_POST['noncename'] ) ? $_POST['noncename'] : 'all the hosts, dream and blue';
		if ( !wp_verify_nonce( $nonce, plugin_basename(__FILE__) )) {
		return $post->ID;
		}
		/* confirm user is allowed to save page/post */
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post->ID ))
			return $post->ID;
		} else {
			if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;
		}

		/* ready our data for storage */
		$meta_keys = array(
            'contraindication_image' => 'text',
            'price' => 'price',
            'session_info' => 'text',
            'mjm_clinic_recommended_service_selected_ids' => 'commadel-numeric-ids',
            'mjm_clinic_related_service_id' => 'numeric',
            'mjm_clinic_related_condition_id' => 'numeric',
            'mjm_clinic_patient_name' => 'text',
            'mjm_clinic_case_name' => 'text'
        );

		/* Add values of $mydata as custom fields */
		foreach ($meta_keys as $meta_key => $type) {
			if( $post->post_type == 'revision' )
				return;
			if ( isset( $_POST[ $meta_key ] ) ) {
				if ( $type == 'text' ) {
					$value = wp_kses_post( $_POST[ $meta_key ] );
				}

                if ( $type == 'price') {
                    $value = number_format_i18n( $_POST[ $meta_key ],2 );
                }

                if( $type == 'commadel-numeric-ids'){
                    $numbers = explode(',',$_POST[ $meta_key ]);
                    foreach ($numbers as $key => $number){
                        if(!is_numeric($number) || $number < 1){
                            unset($numbers[$key]);
                        }
                    }
                    if(is_array($numbers) && count($numbers) > 0) {
                        $value = implode(',', $numbers);
                    } else {
                        $value = '';
                    }
                }

                if( $type == 'numeric'){
                    $value = is_numeric($_POST[ $meta_key ]) ? $_POST[ $meta_key ] : null;
                }

				update_post_meta( $post->ID, $meta_key, $value );
			} else {
				delete_post_meta( $post->ID, $meta_key );
			}
		}
	}

	/**
	 * Registers the widget
	 *
	 * @since 	1.0.0
	 */
	public function register_clinic_service_widget() {
		include_once(CLINIC_SERVICES_WIDGETS);
		register_widget( 'MJM_Clinic_Indication_Tags' );
        register_widget( 'MJM_Clinic_Service_Locations' );
        register_widget( 'MJM_Clinic_Service_Session_Info' );
        register_widget( 'MJM_Clinic_Assigned_Services' );
        register_widget( 'MJM_Clinic_Assigned_Case_Studies' );
        register_widget( 'MJM_Clinic_Assigned_Patient_Feedback' );
        register_widget( 'MJM_Clinic_Assigned_Conditions' );
        register_widget( 'MJM_Clinic_Shared_Symptoms' );
        register_widget( 'MJM_Clinic_Related_Services' );
        register_widget( 'MJM_Clinic_Related_Conditions' );
        register_widget( 'MJM_Clinic_Related_Feedback' );
        register_widget( 'MJM_Clinic_Related_Casestudy' );

	}

	/**
	 * Adds a new image size (for the widget)
	 *
	 * @since 	1.0.0
	 */
	public function create_thumb_sizes() {
		if ( function_exists('add_image_size' ) ) {
			add_image_size( 'mjm-clinic-service-thumb', 172, 138, true );
			add_image_size( 'mjm-clinic-service-feature', 280, 241, false );
		}
	}

	/**
	 * Creates the shortcode
	 *
	 * @since 	1.0.0
	 */
	public function create_shortcode( $atts )
    {
//        global $is_clinic_service_shortcode;
//
//        $is_clinic_service_shortcode = true;
//
//        include_once(CLINIC_SERVICES_FUNC);
//        $defaults = mjm_clinic_option_defaults();
//        $options = get_option('mjm_clinic_settings', $defaults);
//
//        extract(shortcode_atts(array(
//            'count' => '',
//            'covers' => true,
//            'order_by' => 'date_added', // title, date added (default)
//            'format' => 'none', // 0 = none, 1 = excerpt, 2 = full
//            'mjm_clinic_service_category' => '' // any mjm_clinic_service_category
//        ), $atts));
//
//        $covers = null;
//        $mjm_clinic_service_category = null;
//
//        if (isset($atts['count'])) {
//            $count = $atts['count'];
//        } else {
//            $count = -1;
//        }
//        if (isset($atts['covers']) && 'true' == $atts['covers']) {
//            $covers = true;
//        } else {
//            $covers = false;
//        }
//        if (isset($atts['order_by'])) {
//            $order_by = $atts['order_by'];
//            switch ($order_by) {
//                case 'date_added' :
//                    $orderby = 'date';
//                    $order = 'DESC';
//                    break;
//                case 'title' :
//                    $orderby = 'title';
//                    $order = 'ASC';
//                    break;
//                default :
//                    $orderby = 'date';
//                    $order = 'DESC';
//                    break;
//            }
//        } else {
//            $orderby = 'date';
//            $order = 'DESC';
//        }
//        if (isset($atts['format'])) {
//            $format = 0;
//            if ('excerpt' == $atts['format']) {
//                $format = 1;
//            }
//            if ('full' == $atts['format']) {
//                $format = 2;
//            }
//        }
//
//        if (isset($atts['mjm_clinic_service_category'])) {
//            $mjm_clinic_service_category = sanitize_title($atts['mjm_clinic_service_category']); // sanitize the mjm_clinic_service_category in case someone didn't remember to do that
//        }
//
//        if (!$mjm_clinic_service_category) { // we are not listing services
//            $args = array(
//                'post_type' => 'mjm-clinic-service',
//                'posts_per_page' => $count,
//                'orderby' => $orderby,
//                'order' => $order
//            );
//        } else {
//            $args = array(
//                'post_type' => 'mjm-clinic-service',
//                'posts_per_page' => $count,
//                'orderby' => $orderby,
//                'order' => $order,
//                'mjm_clinic_service_category' => $mjm_clinic_service_category
//            );
//        }
//
//        $query = new WP_Query($args);
//        ob_start();
//        if ($query->have_posts()) {
//            while ($query->have_posts()) {
//                $query->the_post(); ?>
<!--                <div class="mjm-clinic-service-wrapper orderedby---><?php //echo esc_attr($orderby); ?><!--"-->
<!--                     id="mjm-clinic-service---><?php //echo get_the_ID(); ?><!--">-->
<!--                    --><?php
//                        echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
//                    ?>
<!---->
<!--                    <div --><?php //post_class('mjm-clinic-service-sc'); ?><!-->-->
<!--                        --><?php //if (($covers == true) && has_post_thumbnail()) { ?>
<!--                            <a href="--><?php //the_permalink(); ?><!--" title="--><?php //the_title_attribute(); ?><!--"-->
<!--                               class="alignleft pull-left thumbnail">-->
<!--                                --><?php //if (isset($options['thumbnail']) && 'service-cover' == $options['thumbnail']) {
//                                    the_post_thumbnail('service-cover');
//                                } else {
//                                    the_post_thumbnail('thumbnail');
//                                } ?>
<!--                            </a>-->
<!--                        --><?php //} ?>
<!---->
<!--                        --><?php //if ($format) {
//                            if ($format == 1) {
//                                ?>
<!--                                --><?php //the_excerpt(); ?>
<!--                            --><?php //} elseif ($format == 2) { ?>
<!--                                --><?php //the_content(); ?>
<!--                            --><?php
//                            }
//                        } ?>
<!--                    </div>-->
<!---->
<!--                    <div class="post-meta">-->
<!--                        --><?php
//                        if (has_term('', 'mjm_clinic_related_product')) {
//                            echo '<span class="mjm_clinic_related_product">';
//                            echo sprintf(__('Related Product: %s', 'mjm-clinic'), get_related_product());
//                            echo '<span><br />';
//                        }
//                        if (isset($options['price']) && $options['price']) {
//                            $price = get_post_meta(get_the_ID(), 'price', true);
//
//                            echo '<span class="price">';
//                            _e('This service is <strong>' . $price . '</strong>', 'mjm-clinic');
//                            echo '</span>';
//
//                        } ?>
<!--                    </div>-->
<!--                    <div class="post-data">-->
<!--                        --><?php //if (has_term('', 'mjm_clinic_service_category')) { ?>
<!--                            <span-->
<!--                                class="mjm_clinic_service_category">--><?php //echo sprintf(__('<strong>Category:</strong> %s', 'mjm-clinic'), get_service_categories()); ?><!--</span>-->
<!--                            <br/>-->
<!--                        --><?php //} ?>
<!--                        --><?php //if (has_term('', 'mjm_clinic_location')) { ?>
<!--                            <span-->
<!--                                class="clinic-location">--><?php //echo sprintf(__('<strong>Location:</strong> %s | ', 'mjm-clinic'), get_clinic_location()); ?><!--</span>-->
<!--                        --><?php //} ?>
<!--                        --><?php //if (has_term('', 'mjm_clinic_indication')) { ?>
<!--                            <span-->
<!--                                class="indications">--><?php //echo sprintf(__('<strong>Indications:</strong> %s', 'mjm-clinic'), get_indications()); ?><!--</span>-->
<!--                            <br/>-->
<!--                        --><?php //} ?>
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php
//            }
//        }
//        wp_reset_query();
//        return ob_get_clean();
    }
}