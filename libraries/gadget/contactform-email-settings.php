<?php
/**
 * @version    $Id$
 * @package    IG_Plugin_Framework
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

class IG_Gadget_Contactform_Email_Settings extends IG_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-email-settings';

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {

	}

	/**
	 *  set default action
	 */
	public function default_action() {
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		auth_redirect();
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return  void
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		$assets = array(
			'ig-jquery-placeholder-js',
			'ig-jquery-tipsy-js',
			'ig-jquery-json-js',
			'ig-jquery-select2-js',
			'ig-jquery-wysiwyg-js',
			'ig-jquery-wysiwyg-colorpicker-js',
			'ig-jquery-wysiwyg-table-js',
			'ig-jquery-wysiwyg-cssWrap-js',
			'ig-jquery-wysiwyg-image-js',
			'ig-jquery-wysiwyg-link-js',
			'ig-jquery-wysiwyg-css',
			'ig-bootstrap2-css',
			'ig-jquery-select2-css',
			'ig-bootstrap2-responsive-css',
			'ig-bootstrap2-jsn-gui-css',
			'ig-bootstrap2-icomoon-css',
			'ig-jquery-ui-css',
			'ig-jquery-tipsy-css',
			'ig-contactform-css',
			'ig-contactform-modal-css',
			'ig-contactform-emailsettings-js',
		);
		IG_Init_Assets::load( $assets );
	}

	/**
	 * Schedule rendering the output.
	 *
	 * @param   string  $action  Gadget action to execute.
	 *
	 * @return  void
	 */
	protected function render( $action = 'default' ) {
		// Store scheduled action
		$this->scheduled = $action;

		add_action( 'admin_head', array( &$this, 'admin_head' ) );
	}

	/**
	 * Render the output.
	 *
	 * @return  void
	 */
	public function admin_head() {
		include IG_Loader::get_path( 'gadget/tmpl/email-settings/default.php' );
		exit;
	}
}
