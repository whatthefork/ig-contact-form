<?php
/**
 * @version    $Id$
 * @package    ig_contactform_Plugin
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Contactform about.
 *
 * @package  ig_contactform_Plugin
 * @since    1.0.0
 */
class IG_Contactform_About {

	/**
	 * Fields array.
	 *
	 * @var  array
	 */
	protected static $fields = array();

	/**
	 * Setup vertical tabs for theme options form.
	 *
	 * @return  void
	 */
	public static function ig_form_post_render() {
		IG_Init_Assets::inline(
			'js', '
			$(".oj-form-sections-tabs").addClass("ui-tabs-vertical ui-helper-clearfix");
			$(".jsn-form-sections-tabs > ul > li").removeClass("ui-corner-top").addClass("ui-corner-left");'
		);
	}

	/**
	 * Render about page.
	 *
	 * @return  void
	 */
	public static function render() {
		// Init HTML form
		$form = IG_Form::get_instance( 'ig_contactform_about', self::$fields );

		// Setup vertical tabs
		add_action( 'ig_form_post_render', array( __CLASS__, 'ig_form_post_render' ) );

		// Render HTML form
		$form->render( 'about' );
	}
}
