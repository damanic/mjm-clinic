<?php
		include_once(CLINIC_SERVICES_FUNC);
		include_once( 'public.php' );

		$options = get_option( 'mjm_clinic_settings', mjm_clinic_option_defaults() );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

        //Check for form submissions
        add_action('template_redirect', array( $this,'check_for_form_submissions'));

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Register post types
		add_action( 'init', array( $this, 'register_post_type_mjm_clinic_service' ),5 );
        add_action( 'init', array( $this, 'register_post_type_mjm_clinic_condition' ),5 );

        if ( isset($options['mjm_clinic_option_feedback']) && ($options['mjm_clinic_option_feedback']  == true) )
            add_action( 'init', array( $this, 'register_post_type_mjm_clinic_patient_feedback', ),5 );

        if ( isset($options['mjm_clinic_option_casestudy']) && ($options['mjm_clinic_option_casestudy']  == true) )
            add_action( 'init', array( $this, 'register_post_type_mjm_clinic_case_study' ),5 );

		// Register taxonomies
        add_action( 'init', array( $this, 'register_taxonomy_mjm_clinic_service_category' ) );
		add_action( 'mjm_clinic_service_category_add_form_fields', array( $this, 'add_taxonomy_form_fields_mjm_clinic_service_category' ) );
		add_action( 'mjm_clinic_service_category_edit_form_fields', array($this, 'add_taxonomy_edit_form_fields_mjm_clinic_service_category'));
		add_action( 'edited_mjm_clinic_service_category',array($this, 'save_taxonomy_custom_meta'));
		add_action( 'created_mjm_clinic_service_category', array($this, 'save_taxonomy_custom_meta'));
        add_action( 'manage_edit-mjm_clinic_service_category_columns', array($this,'edit_service_category_columns'));


            add_action( 'init', array( $this, 'register_taxonomy_mjm_clinic_location' ) );
            add_action( 'cjc_clinic_location_add_form_fields', array( $this, 'add_taxonomy_form_fields_mjm_clinic_location' ) );
            add_action( 'mjm_clinic_location_edit_form_fields', array($this, 'add_taxonomy_edit_form_fields_mjm_clinic_location'));
            add_action( 'edited_mjm_clinic_location',array($this, 'save_taxonomy_custom_meta'));
            add_action( 'created_mjm_clinic_location', array($this, 'save_taxonomy_custom_meta'));

        if ( isset($options['mjm_clinic_option_indication']) && ($options['mjm_clinic_option_indication']  == true) )
            add_action( 'init', array( $this, 'register_taxonomy_mjm_clinic_indication' ) );

        if ( isset($options['mjm_clinic_option_contraindication']) && ($options['mjm_clinic_option_contraindication']  == true) )
            add_action( 'init', array( $this, 'register_taxonomy_mjm_clinic_contraindication' ) );

		if ( isset($options['mjm_clinic_option_related_product']) && ($options['mjm_clinic_option_related_product']  == true) )
			add_action( 'init', array( $this, 'register_taxonomy_mjm_clinic_related_product' ) );
            add_action( 'mjm_clinic_related_product_add_form_fields', array( $this, 'add_taxonomy_form_fields_mjm_clinic_related_product' ) );
	        add_action( 'mjm_clinic_related_product_edit_form_fields', array($this, 'add_taxonomy_edit_form_fields_mjm_clinic_related_product'));
            add_action( 'edited_mjm_clinic_related_product',array($this, 'save_taxonomy_custom_meta'));
            add_action( 'created_mjm_clinic_related_product', array($this, 'save_taxonomy_custom_meta'));


        //block new taxonomies unless authorised
        add_action('pre_insert_term', array($this, 'block_unauthorised_taxonomy_additions'), 1, 2);

		// set new thumbnail size
		add_action( 'init', array( $this, 'create_thumb_sizes' ) );
        add_filter( 'image_size_names_choose', array( $this, 'mjman_thumb_sizes' ));

		// Move metaboxes around
		add_action( 'add_meta_boxes', array( $this, 'move_meta_boxes' ) );

		// add additional information meta boxes
		add_action( 'add_meta_boxes', array( $this, 'mjm_clinic_meta_boxes' ) );

		// Register the options
		add_action( 'admin_init' , array( $this, 'settings_init' ) );
        add_action('admin_init', array($this, 'check_update_scripts'));

		// Rename "featured image"
		add_action('admin_head-post-new.php', array($this, 'change_thumbnail_html'));
		add_action('admin_head-post.php', array($this, 'change_thumbnail_html'));

		// Update the Clinic Service columns
		add_filter( 'manage_edit-clinic-service_columns', array($this, 'edit_clinic_service_columns') );
		add_action( 'manage_clinic-service_posts_custom_column', array($this, 'manage_clinic_service_columns'), 10, 2 );

		// save the meta data
		add_action('save_post', array( $this, 'save_mjm_clinic_postmeta' ), 1, 2);

		// create a related items widget
		add_action( 'widgets_init', array( $this, 'register_clinic_service_widget' ) );

		// add a shortcode
		add_shortcode( 'mjm-clinic-booking-form', array( $this, 'shortcode_booking_form' ) );
        add_shortcode( 'mjm-clinic-location-map', array( $this, 'shortcode_location_map' ) );
        add_shortcode( 'mjm-clinic-service-box-links', array( $this, 'shortcode_service_box_links' ) );
        add_shortcode( 'mjm-clinic-condition-list', array( $this, 'shortcode_condition_list' ) );

		// do i18n stuff
		add_action( 'plugins_loaded', array( $this, 'setup_i18n' ) );



