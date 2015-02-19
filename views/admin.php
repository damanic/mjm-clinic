<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <2015@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014, 2015 Matt Manning
 */
?>
<?php
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	require_once( 'setup-options.php' );
?>
<div class="wrap">
	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Clinic settings saved', 'mjm-clinic' ); ?></strong></p></div>
	<?php endif; ?>
	<?php get_screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<div id="poststuff" class="metabox-holder">
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content">
				<form method="post" action="options.php">
					<?php settings_fields( 'mjm_clinic_settings' ); ?>
					<?php mjm_clinic_do_options(); ?>
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'mjm-clinic' ); ?>" />
						<input type="hidden" name="mjm-clinic-service-settings-submit" value="Y" />
					</p>
				</form>
			</div><!-- closes post-body-content -->
		</div><!-- closes post-body -->
	</div><!-- closes poststuff -->
</div>