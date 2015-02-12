<?php
/**
 * @package   MJM_Clinic
 * @author    Matt Manning <spam2014@mjman.net>
 * @license   GPLv3
 * @link      http://mjman.net
 * @copyright 2014 Matt Manning
 *
 * @wordpress-plugin
 * Plugin Name: Clinic Services
 * Plugin URI:  http://mjman.net.com/
 * Description: A plugin to promote health clinic services.
 * Version:     1.0.3
 * Author:      Matt Manning
 * Author URI:  http://mjman.net
 * License:     GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: mjm-clinic
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'CLINIC_SERVICES_FUNC', plugin_dir_path( __FILE__ ) . 'inc/func.php' );
define( 'CLINIC_SERVICES_WIDGETS', plugin_dir_path( __FILE__ ) . 'inc/widgets.php' );
define( 'CLINIC_SERVICES_AKISMET', plugin_dir_path( __FILE__ ) . 'vendor/akismet.class.php' );

$is_clinic_service_shortcode = false;

require_once( plugin_dir_path( __FILE__ ) . 'class-mjm-clinic.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-misc.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'MJM_Clinic', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'MJM_Clinic', 'deactivate' ) );


MJM_Clinic::get_instance();
