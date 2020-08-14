<?php

    namespace HPR;

    /**
     * Class that represents the dashboard.
     *
     * @package HPR
     * @author COM'ON <thomas@com-on.agency>
     * @version 0.0.1-dev
     */
    class HappyForms_Recaptcha_Admin {

        /**
         * Initialize function.
         *
         * @static
         */
        public static function initialize() {

            add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 11 );
            add_action( 'admin_init', array( __CLASS__, 'register_settings_options' ) );
        }

        /**
         * Register the reCAPTCHA settings page into the HappyForms section,
         * at the 5 position, before "Upgrade".
         *
         * @static
         */
        public static function admin_menu() {

            add_submenu_page(
                'happyforms',
                __( 'ReCAPTCHA Settings', 'happyforms-recaptcha' ),
                __( 'ReCAPTCHA', 'happyforms-recaptcha' ),
                apply_filters( 'happyforms_forms_page_capabilities', 'manage_options' ),
                'hpr-settings',
                array( __CLASS__, 'view_settings' ),
                5
            );
        }

        /**
         * Display the view settings from the folder at
         * the path `assets/views/admin-settings.php`.
         *
         * @static
         */
        public static function view_settings() {
            include_once HPR_PLUGIN_DIR . '/assets/views/admin-settings.php';
        }

        /**
         * Register option group and options that are available
         * in the plugin.
         *
         * @static
         */
        public static function register_settings_options() {

            register_setting( 'hpr-settings', 'hpr-recaptcha-sitekey' );
            register_setting( 'hpr-settings', 'hpr-recaptcha-secretkey' );
        }
    }