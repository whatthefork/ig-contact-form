<?php
/**
 * Plugin Name: IG Contact Form
 * Plugin URI: http://innogears.com
 * Description: Super easy form builder bringing to your Wordpress websitecontact form, survey and much more.
 * Version: 1.0.0
 * Author: InnoGears Team <support@innogears.com>
 * Author URI: http://innogears.com
 * License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
session_start();
define( 'IG_UNIFORM_PLUGIN_FILE', __FILE__ );
require_once dirname( __FILE__ ) . '/defines.php';
require_once ( IG_UNIFORM_PATH . 'libraries/loader.php' );
require_once( IG_UNIFORM_PATH . '/helpers/uniform.php' );
require_once( IG_UNIFORM_PATH . '/helpers/action-hook.php' );
require_once( IG_UNIFORM_PATH . '/helpers/ajax.php' );
require_once( IG_UNIFORM_PATH . '/libraries/uniform.php' );
require_once( IG_UNIFORM_PATH . '/libraries/installer.php' );
//Get Post Type
register_activation_hook( __FILE__, array( 'IG_Uniform_Installer', 'on_activate_function' ) );
register_uninstall_hook( __FILE__, array( 'IG_Uniform_Installer', 'on_uninstaller_function' ) );

// Register IG Sample Plugin initialization
add_action( 'ig_init', 'ig_init_uniform_plugin' );

// Initialize IG Library
IG_Init_Plugin::hook();

function ig_init_uniform_plugin() {
	$IGUniform = new IG_Uniform();
	// Init admin pages
	$IGUniformLoadAjax = new IGUniformLoadAjax();
}
