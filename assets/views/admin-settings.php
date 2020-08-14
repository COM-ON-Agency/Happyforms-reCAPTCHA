
<div class="wrap">
    <h1>ReCAPTCHA Settings</h1>

    <form method="post" action="options.php">

        <?php settings_fields( 'hpr-settings' ); ?>
        <?php do_settings_sections( 'hpr-settings' ); ?>

        <table class="form-table">
        
            <tr valign="top">
                <th scope="row"><?php echo __('Site key', 'happyforms-recaptcha'); ?></th>
                <td>
                    <input type="text" name="hpr_recaptcha_sitekey" class="regular-text"
                           value="<?php echo esc_attr( get_option('hpr-recaptcha-sitekey') ); ?>" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Secret key', 'happyforms-recaptcha'); ?></th>
                <td>
                    <input type="text" name="hpr_recaptcha_secretkey"  class="regular-text"
                           value="<?php echo esc_attr( get_option('hpr-recaptcha-secretkey') ); ?>" />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>