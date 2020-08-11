
<div class="wrap">
    <h1>ReCAPTCHA Settings</h1>

    <form method="post" action="options.php">

        <?php settings_fields( 'hpr-settings' ); ?>
        <?php do_settings_sections( 'hpr-settings' ); ?>

        <table class="form-table">

            <tr valing="top">
                <th scope="row"><?php echo __('ReCAPTCHA type', 'happyforms-recaptcha'); ?></th>
                <td>
                    <select name="hpr_recaptcha_type">
                        <option value="3">Recaptcha V3</option>
                        <option value="2" disabled>Recaptcha V2</option>
                    </select>
                    <p class="description" id="hpr_recaptcha_type-description">You must indicate the type of google recaptcha you want to use.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Site key', 'happyforms-recaptcha'); ?></th>
                <td>
                    <input type="text" name="hpr_recaptcha_sitekey" class="regular-text"
                           value="<?php echo esc_attr( get_option('hpr_recaptcha_sitekey') ); ?>" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Secret key', 'happyforms-recaptcha'); ?></th>
                <td>
                    <input type="text" name="hpr_recaptcha_secretkey"  class="regular-text"
                           value="<?php echo esc_attr( get_option('hpr_recaptcha_secretkey') ); ?>" />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>