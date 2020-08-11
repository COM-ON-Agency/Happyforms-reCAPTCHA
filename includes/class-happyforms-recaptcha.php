<?php

    /**
     * HappyForms Recaptcha plugin main class.
     *
     * Entry point of the plugin, declaration of main events, hooks,
     * actions, assets.
     *
     * @package HappyForms-Recaptcha
     * @author Com'On <thomas@com-on.agency>
     * @version 0.0.1-dev
     */
    class HappyForms_Recaptcha {

        private static $_instance = null;

        const GRECAPTCHA_SITE_VERIFY = "https://www.google.com/recaptcha/api/siteverify";

        /**
         * Constructor function.
         */
        public function __construct() {

            HappyForms_Recaptcha_Admin::initialize();

            add_filter( 'happyforms_meta_fields', array( $this, 'meta_fields' ) );
            add_filter( 'happyforms_setup_controls', array( $this, 'setup_controls' ) );

            add_action( 'happyforms_footer', array( $this, 'enqueue_scripts' ) );
            add_filter( 'happyforms_validate_submission', array( $this, 'check_recaptcha' ), 10, 3 );

            add_action( 'happyforms_form_before', array( $this, 'handle_recaptcha_error' ) );

        }

        /**
         * Enqueue scripts after HappyForms to rewrite methods and add
         * google reCAPTCHA script.
         *
         * @param array $current_forms
         */
        public function enqueue_scripts( $current_forms ) {

           $need_recaptcha_in_page = array_search(1, array_column($current_forms, 'hpr_use_recaptcha'));

           if($need_recaptcha_in_page === FALSE)
               return;

           $recaptcha_sitekey = get_option('hpr_recaptcha_sitekey');

           wp_enqueue_script('grecaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_sitekey,
                array(), false, true);

           wp_enqueue_script('hpr', plugin_dir_url(HPR_PLUGIN_FILE) . 'assets/js/front.js', array(), false, true);
           wp_localize_script('hpr', 'grecaptcha_sitekey', $recaptcha_sitekey);
        }

        /**
         * Calls the reCAPTCHA siteverify API to verify whether the user passes
         * CAPTCHA test.
         *
         * @param bool $is_valid
         * @param array $request
         * @param Object $form
         * @return bool Result
         */
        public function check_recaptcha( $is_valid, $request, $form ) {

            if(!$form['hpr_use_recaptcha'])
                return $is_valid;

            if ($is_valid && isset($request['grecaptcha_token'])) {

                $session = happyforms_get_session();

                $recaptcha_secret = get_option('hpr_recaptcha_secretkey');
                $recaptcha_response = $request['grecaptcha_token'];

                $recaptcha = file_get_contents(self::GRECAPTCHA_SITE_VERIFY . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);

                $success = $recaptcha->success && $recaptcha->score > 0.5;

                if(!$success) {
                    $session->add_error($form['ID'] . '-recaptcha', $form['hpr_error_recaptcha'] );
                }

                return $success;
            }

            return $is_valid;
        }


        /**
         * Replace main error with an more specific one to handle reCAPTCHA issue
         * in case of score issue.
         *
         * @param $form
         */
        public function handle_recaptcha_error($form) {

            $session = happyforms_get_session();

            $error_recaptcha = $session->get_messages($form['ID'] . '-recaptcha');

            if(!empty($error_recaptcha))
                $session->add_error( $form['ID'], $error_recaptcha[0]['message'] );
        }

        /**
         * Add meta fields `hpr_use_recaptcha` to disable scripts in forms that doesn't
         * need it, in case of.
         *
         * @param array fields
         * @return array fields
         */
        public function meta_fields( $fields ) {

            $fields['hpr_use_recaptcha'] = array(
                'default' => 1,
                'sanitize' => 'happyforms_sanitize_checkbox',
            );

            $fields['hpr_error_recaptcha'] = array(
                'default' => __( 'There is a problem with the reCAPTCHA! Please review your submission.', 'happyforms-recaptcha' ),
                'sanitize' => 'esc_html'
            );

            return $fields;
        }

        /**
         * Add controls to the Setup tab in the customize page of forms, to be able
         * to disable/enable the usage of reCAPTCHA scripts.
         *
         * @param array controls
         * @return array controls
         */
        public function setup_controls( $controls ) {

            $controls[1401] = array(
                'type' => 'checkbox',
                'label' => __( '[ADD-ON] Use reCAPTCHA', 'happyforms-recaptcha' ),
                'tooltip' => __( 'Protect your forms from bots.', 'happyforms-recaptcha' ),
                'field' => 'hpr_use_recaptcha',
            );

            $controls[111] = array(
                'type' => 'editor',
                'label' => __( 'Error message reCAPTCHA', 'happyforms-recaptcha' ),
                'tooltip' => __( 'This is the message your users will see when there are form errors with reCAPTCHA module.', 'happyforms-recaptcha' ),
                'field' => 'hpr_error_recaptcha',
            );

            return $controls;
        }

        /**
         * Main HappyForms recaptcha instance.
         *
         * Ensures only one instance of HappyForms Recaptcha is loaded
         * or can be loaded.
         *
         * @return HappyForms_Recaptcha instance
         * @static
         */
        public static function instance() {

            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }