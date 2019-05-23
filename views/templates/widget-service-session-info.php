<div class="mjm_clinic_service_session_info_widget_output_session-info-container">
	<?php
	if ( !empty( $title ) ) {
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
	} ?>
	<div class="mjm_clinic_service_session_info_widget_output_session-info">
		<?php echo wpautop( htmlspecialchars_decode( $this_post->session_info ) ) ?>
	</div>
</div>