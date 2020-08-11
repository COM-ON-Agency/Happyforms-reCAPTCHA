( function( $ ) {

    /**
     * HappyForms rewrite submit function to permit google recaptcha.
     * @param e
     */
    HappyForms.Form.prototype.submit = function( e ) {

        e.preventDefault();

        this.$form.addClass( 'happyforms-form--submitting' );
        this.$submits.attr( 'disabled', 'disabled' );

        let data = this.serialize( e.target );

        grecaptcha.ready(function () {

            grecaptcha.execute(grecaptcha_sitekey, {action: 'submit'}).then(function(recaptcha_token) {

                data += "&grecaptcha_token=" + recaptcha_token;

                $.ajax({
                    type: 'post',
                    data: data,
                }).done( this.onSubmitComplete.bind( this ) );

            }.bind( this ) );

        }.bind( this ) );
    }

} )( jQuery );