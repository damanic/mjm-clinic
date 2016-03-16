<div class="mjm_clinic_service_locations_widget_output_entry-container">

                        <span class="mjm_clinic_service_locations_widget_output_location-name">
                            <i class="fa fa-hospital-o"></i> <a href="<?php echo get_term_link( $location ) ?>"> <?php echo wp_strip_all_tags( $location->name ) ?> </a>
                        </span>

                        <span class="mjm_clinic_service_locations_widget_output_location-description">
                            <?php echo wpautop( $location->description ) ?>
                        </span>


	<?php if ( !empty( $location_meta['open_hours'] ) ) { ?>
		<span class="mjm_clinic_service_locations_widget_output_open-hours">
                            <?php echo wpautop( $location_meta['open_hours'] ) ?>
                        </span>
	<?php } ?>


	<?php if ( !empty( $location_meta['tel'] ) ) { ?>
		<a class="mjm_clinic_service_locations_widget_output_tel-link mjm_clinic_widget_btn-link"
		   href="tel:<?php echo wp_strip_all_tags( $location_meta['tel'] ) ?>">
			<i class="fa fa-phone"></i> <?php echo wp_strip_all_tags( $location_meta['tel'] ) ?>
		</a>
	<?php } ?>
	<?php if ( !empty( $location_meta['contact_link'] ) ) {
		$link = str_replace( '{service_id}', $this_post->ID, wp_strip_all_tags( $location_meta['contact_link'] ) );
		$link = str_replace( '{service_name}', urlencode( $this_post->post_title ), $link );
		?>
		<a href="<?php echo $link ?>"
		   class="mjm_clinic_service_locations_widget_output_booking-link mjm_clinic_widget_btn-link">
			<i class="fa fa-calendar"></i> Book Appointment
		</a>
	<?php } else {
		if ( !empty( $location_meta['email'] ) ) { ?>
			<a class="mjm_clinic_service_locations_widget_output_booking-link mjm_clinic_widget_btn-link">
				<i class="fa fa-envelope"></i> Book Appointment
			</a>

			<div class="mjm_clinic_service_locations_widget_output_booking-form" style="display: none">
				<?php echo do_shortcode( '[mjm-clinic-booking-form location="' . $location->term_id . '" no_location_select="true" service="' . $this_post->ID . '" no_service_select="true"]' ); ?>
			</div>
		<?php }
	} ?>

	<?php if ( !empty( $location_meta['map_link'] ) ) { ?>
		<a class="mjm_clinic_service_locations_widget_output_map-link mjm_clinic_widget_btn-link">
			<i class="fa fa-map-marker"></i> Map
		</a>
		<div class="mjm_clinic_service_locations_widget_output_map-contain" style="display: none;">
			<?php echo do_shortcode( '[mjm-clinic-location-map id="service_locations_widget" location="' . $location->term_id . '"]' ) ?>

		</div>
	<?php } ?>
</div>