<div class="mjm_clinic_service_boxlink_category_container">
	<a class="mjm_clinic_service_boxlink_a" href="<?php echo esc_url(get_term_link($category))?>">
		<div class="mjm_clinic_service_boxlink_image_contain">
			<?php if($image){ ?>
				<img class="mjm_clinic_service_boxlink_image" src="<?php echo esc_url($image)?>" />
			<?php } else { ?>
				<i class="fa fa-plus-square fa-5x mjm_clinic_service_boxlink_icon"></i>
			<?php } ?>
		</div>
		<h3 class="mjm_clinic_service_boxlink_title"><?php echo esc_html($category->name) ?></h3>
		<p class="mjm_clinic_service_boxlink_excerpt"><?php echo esc_html($category_meta['excerpt'])?></p>
	</a>
</div>
