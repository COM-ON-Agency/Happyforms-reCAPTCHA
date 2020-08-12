<?php

    /**
     * Plugin Name: HappyForms Recaptcha
     * Plugin URI: https://www.com-on.agency/
     * Description: Add-on of HappyForms that add automatically recaptcha to forms.
     * Version: 0.0.1-dev
     * Author: Com'On Agency
     * Author URI: https://www.com-on.agency/
     * Text Domain: happyforms-recaptcha
     * Domain Path: /i18n/languages/
     * Requires at least: 5.2
     * Requires PHP: 7.0
     *
     * @package HappyForms_Recaptcha
     */

    defined('ABSPATH') || exit;

    define('HPR_PLUGIN_FILE', __FILE__);
    define('HPR_PLUGIN_DIR', dirname(HPR_PLUGIN_FILE));


    require_once HPR_PLUGIN_DIR . '/includes/class-happyforms-recaptcha.php';
    require_once HPR_PLUGIN_DIR . '/includes/class-happyforms-recaptcha-admin.php';


    if(in_array('happyforms/happyforms.php', apply_filters('active_plugins', get_option('active_plugins'))) ||
        (is_multisite() && in_array('happyforms/happyforms.php', apply_filters('active_plugins', array_flip(get_site_option('active_sitewide_plugins')))))) {

        add_action('plugins_loaded', 'hpr_initialize_plugin');
    }

    function hpr_initialize_plugin() {
        HappyForms_Recaptcha::instance();
    }
