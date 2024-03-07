<div class="mjm_clinic_service_boxlink_container">
	<a class="mjm_clinic_service_boxlink_a" href="<?php echo esc_url(get_the_permalink($post))?>">
		<div class="mjm_clinic_service_boxlink_image_contain">
			<?php if( $image ){ ?>
				<img class="mjm_clinic_service_boxlink_image" src="<?php echo esc_url($image_url)?>" />
			<?php } else { ?>
				<i class="fa fa-plus-square fa-5x mjm_clinic_service_boxlink_icon"></i>
			<?php } ?>
		</div>
		<h3 class="mjm_clinic_service_boxlink_title"><?php echo esc_html($post->post_title) ?></h3>
		<p class="mjm_clinic_service_boxlink_excerpt"><?php echo esc_html($post->post_excerpt) ?></p>
	</a>
</div>