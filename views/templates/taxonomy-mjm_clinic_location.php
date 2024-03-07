<?php
/*
Template Name: MJM Clinic Service Location
*/

$location = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$location_meta = get_option("taxonomy_" . $location->term_id);

get_header();
?>

<!-- START CONTENT -->
<section id="primary" class="content-area">

	<div id="content" class="site-content" role="main">

		<div class="page-content">

			<h1><?php echo esc_html($location->name) ?></h1>

			<p>
				<?php echo wpautop(esc_html($location->description)) ?>
			</p>

			<?php if (!empty($location_meta['open_hours'])) { ?>

				<b> <?php echo esc_html__('Open Hours', 'mjm-clinic') ?>:</b>
				<div class="mjm_clinic_service_locations_widget_output_open-hours">
					<?php echo wpautop(esc_html($location_meta['open_hours'])) ?>
				</div>

			<?php } ?>

			<?php if (!empty($location_meta['tel'])) { ?>
				<p> <a href="tel:<?php echo esc_attr(wp_strip_all_tags($location_meta['tel'])) ?>">
						<i class="fa fa-phone"></i> <?php echo esc_html(wp_strip_all_tags($location_meta['tel'])) ?>
					</a></p>
			<?php } ?>
			<?php if (!empty($location_meta['contact_link'])) {
				$link = str_replace('{service_id}', '', wp_strip_all_tags($location_meta['contact_link']));
				$link = str_replace('{service_name}', '', $link);
				?>
				<p><a href="<?php echo esc_url($link) ?>">
						<i class="fa fa-calendar"></i> <?php echo esc_html__('Book Appointment', 'mjm-clinic') ?>
					</a></p>
			<?php } elseif (!empty($location_meta['email'])) { ?>
				<p> <a href="mailto:<?php echo antispambot(esc_attr(wp_strip_all_tags($location_meta['email']))) ?>">
						<i class="fa fa-envelope"></i>  <?php echo esc_html__('Email Us', 'mjm-clinic') ?>
					</a></p>
			<?php } ?>

			<hr/> <h4>Booking Form</h4>
			<?php echo do_shortcode('[mjm-clinic-booking-form location=' . esc_attr($location->term_id) . ' no_location_select=1]'); ?>

			<?php
			if (have_posts()) { ?>
				<hr/>
				<h2> <?php echo esc_html__('Available Services', 'mjm-clinic') ?></h2>

				<?php while (have_posts()) : the_post(); ?>
					<h5>
						<i class="fa fa-plus-square"></i>
						<a href="<?php echo get_permalink($post->ID) ?>">
							<?php echo esc_html(get_the_title($post->ID)) ?>
						</a>
					</h5>
					<p><?php echo esc_html(get_the_excerpt($post->ID)) ?></p>
				<?php endwhile; ?>

			<?php } ?>
		</div>

	</div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar('content');
get_sidebar();
get_footer();
?>
