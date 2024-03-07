<div class="mjm_clinic_staff_list_container">
	<div class="mjm_clinic_staff_list_image_contain">
		<?php if( $image ){ ?>
			<img class="mjm_clinic_staff_list_image" src="<?php echo esc_url($image_url) ?>" />
		<?php } else { ?>
			<i class="fa fa-plus-square fa-5x mjm_clinic_staff_list_icon"></i>
		<?php } ?>
	</div>
	<div class="mjm_clinic_staff_list_content_contain">
		<a class="mjm_clinic_staff_list_a" href="<?php echo esc_url(get_the_permalink($post)) ?>">
			<h3 class="mjm_clinic_staff_list_title"><?php echo esc_html($post->post_title) ?></h3>
		</a>
		<p class="mjm_clinic_staff_list_excerpt"><?php echo esc_html($post->post_excerpt) ?></p>
	</div>

	<div style="clear:both"></div>
</div>
