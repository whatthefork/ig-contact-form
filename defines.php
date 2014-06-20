<?php
/**
 * @version    $Id$
 * @package    IG_ContactForm
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 InnoGears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 */

// Define the absolute path, with trailing slash, of the IT Sample Plugin directory
define( 'IG_CONTACTFORM_PATH', plugin_dir_path( __FILE__ ) );

// Define the URL, including a trailing slash, of the IG Sample Plugin directory
define( 'IG_CONTACTFORM_URI', plugin_dir_url( __FILE__ ) );

define( 'IG_CONTACTFORM_CAPTCHA_PUBLICKEY', get_option( 'ig_contactform_recaptcha_public_key' ) );

define( 'IG_CONTACTFORM_CAPTCHA_PRIVATEKEY', get_option( 'ig_contactform_recaptcha_private_key' ) );

// Text domain for IG ContactForm plugin
define( 'IG_CONTACTFORM_TEXTDOMAIN', 'ig-contact-form' );

// Define product edition
define( 'IG_CONTACTFORM_EDITION', 'FREE' );

// Define product identified name
define( 'IG_CONTACTFORM_IDENTIFIED_NAME', 'ig_contact_form' );

// Define product identified name
define( 'IG_CONTACTFORM_DEPENDENCY', '' );

// Define product identified name
define( 'IG_CONTACTFORM_ADDONS', 'ig_contactform_addons_profields' );
