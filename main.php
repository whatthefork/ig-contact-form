<?php
/**
 * Plugin Name: IG Contact Form
 * Plugin URI: http://innogears.com
 * Description: Super easy form builder bringing to your Wordpress websitecontact form, survey and much more.
 * Version: 1.0.1
 * Author: InnoGears Team <support@innogears.com>
 * Author URI: http://innogears.com
 * License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
session_start();
define( 'IG_CONTACTFORM_PLUGIN_FILE', __FILE__ );
require_once dirname( __FILE__ ) . '/defines.php';
require_once( IG_CONTACTFORM_PATH . 'libraries/loader.php' );
require_once( IG_CONTACTFORM_PATH . '/helpers/contactform.php' );
require_once( IG_CONTACTFORM_PATH . '/helpers/action-hook.php' );
require_once( IG_CONTACTFORM_PATH . '/helpers/ajax.php' );
require_once( IG_CONTACTFORM_PATH . '/libraries/contactform.php' );
require_once( IG_CONTACTFORM_PATH . '/libraries/installer.php' );
//Get Post Type
register_activation_hook( __FILE__, array( 'IG_Contactform_Installer', 'on_activate_function' ) );
register_uninstall_hook( __FILE__, array( 'IG_Contactform_Installer', 'on_uninstaller_function' ) );

// Register IG Sample Plugin initialization
add_action( 'ig_init', 'ig_init_contactform_plugin' );

// Initialize IG Library
IG_Init_Plugin::hook();

function ig_init_contactform_plugin() {
	$IGContactform = new IG_Contactform();
	// Init admin pages
	$IGContactformLoadAjax = new IGContactformLoadAjax();
}
