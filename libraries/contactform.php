<?php
/**
 * @version    $Id$
 * @package    IG_Sample_Plugin
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Core initialization class of IT Sample Plugin.
 *
 * @package  IG_CONTACTFORM_Plugin
 * @since    1.0.0
 */
class IG_Contactform {

	/**
	 * IT Contactform Plugin's custom post type slug.
	 *
	 * @var  string
	 */
	protected $type_slug = 'ig_cf_post_type';

	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 'ig-sample-update', 'ig-sample-upgrade' );

	/**
	 * Define Ajax actions.
	 *
	 * @var  array
	 */
	protected static $actions = array( 'ig-download-update', 'ig-install-update', 'ig-check-edition' );

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {
		// Initialize necessary IG Library classes
		//Hook Meta Box
		IG_Init_Meta_Box::hook();
		//Hook Post Type
		IG_Init_Post_Type::hook();
		//Hook Assets
		IG_Init_Assets::hook();
		//register post type wordpress
		IGContactformActionHook::register_post_type();

		// Prepare admin pages
		if ( defined( 'WP_ADMIN' ) ) {

			add_action( 'admin_init', array( 'IG_Gadget_Base', 'hook' ), 100 );

			// add languages
			add_action( 'admin_init', array( &$this, 'ig_contactform_languages' ) );

			// Register admin menu for IT Contactform Plugin
			IG_Init_Admin_Menu::hook();

			add_action( 'admin_menu', array( 'IGContactformActionHook', 'ig_contactform_register_menus' ) );

			// add Filter apply assets
			add_filter( 'ig_register_assets', array( 'IGContactformHelper', 'apply_assets' ) );
			
			// add filter customize the messages
			add_filter( 'post_updated_messages', array( 'IGContactformHelper', 'set_messages' ) );

			//Adding "embed form" button
			add_action( 'media_buttons', array( 'IGContactformActionHook', 'add_form_button' ), 20 );

			add_action( 'restrict_manage_posts', array( 'IGContactformActionHook', 'ig_contactform_submissions_filters' ) );
			// Load necessary assets
			IGContactformActionHook::load_assets();

		}
		else {
			global $pagenow;
			//Hook IG Gadget Base
			IG_Gadget_Base::hook();

			//get short code
			add_filter( 'the_content', 'do_shortcode' );

			// add Filter apply assets
			add_filter( 'ig_register_assets', array( 'IGContactformHelper', 'apply_assets' ) );

			//render contactform in frontend
			add_shortcode( 'ig_contactform', array( &$this, 'contactform_to_frontend' ) );

			//get language contactform in frontend
			$this->ig_contactform_frontend_languages();
			if ( $pagenow == 'index.php' && ! empty( $_GET[ 'post_type' ] ) && $_GET[ 'post_type' ] == 'ig_cf_post_type' && ! empty( $_GET[ 'p' ] ) ) {
				add_filter( 'the_content', array( &$this, 'ig_contactform_front_end_preview' ) );
			}
		}
	}

	public function ig_contactform_front_end_preview( $postId ) {
		$data[ 'id' ] = (int)$_GET[ 'p' ];
		return self::contactform_to_frontend( $data );
	}

	/**
	 * Show Contactform content for Frontend post
	 *
	 * @param type $content
	 *
	 * @return type
	 */
	public function contactform_to_frontend( $atts, $return = true ) {
		global $wpdb;
		if ( ! empty( $atts[ 'id' ] ) ) {
			$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE  meta_key='form_id' AND meta_value=%d", (int)$atts[ 'id' ] ) );
			if ( empty( $postId ) ) {
				$postId = (int)$atts[ 'id' ];
			}
			$status = get_post_status( $postId );

			if ( $status && $status != 'pending' ) {
				return self::load_html_contactform( $postId, (int)$atts[ 'id' ], rand( 99999999999, 999999999999999 ) );
			}
		}

	}

	/**
	 * Load Form
	 *
	 * @param   Int  $postId  Post id
	 * @param   Int  $formID  Form id
	 *
	 * @param   Imt  $index   Form Index
	 *
	 * @return void
	 */
	public function load_html_contactform( $postId, $formID, $index ) {
		//form Name
		$formName = md5( date( 'Y-m-d H:i:s' ) . $index . rand( 999999999, 999999999999 ) );
		//return html form
		return IGContactformHelper::generate_html_pages( $postId, $formID, $formName );
	}

	/**
	 * load languages files
	 */
	public function ig_contactform_languages() {
		load_plugin_textdomain( IG_CONTACTFORM_TEXTDOMAIN, false, IG_CONTACTFORM_TEXTDOMAIN . '/libraries/languages/' );
	}

	/**
	 * Front-End Load langauge file
	 *
	 */
	public function ig_contactform_frontend_languages() {
		load_plugin_textdomain( IG_CONTACTFORM_TEXTDOMAIN, false, IG_CONTACTFORM_TEXTDOMAIN . '/frontend/languages/' );
	}

}

