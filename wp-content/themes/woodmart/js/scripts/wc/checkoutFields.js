/* global woodmart_checkout_fields */
/* global wc_address_i18n_params */
(function($) {
	// wc_address_i18n_params is required to continue, ensure the object exists
	if ( 'undefined' === typeof wc_address_i18n_params ) {
		return false;
	}

	function isRequiredField( field, isRequired ) {
		if ( isRequired ) {
			field.find( 'label .optional' ).remove();
			field.addClass( 'validate-required' );

			if ( 0 === field.find( 'label .required' ).length ) {
				field.find( 'label' ).append(
					'&nbsp;<abbr class="required" title="' +
					wc_address_i18n_params.i18n_required_text +
					'">*</abbr>'
				);
			}
		} else {
			field.find( 'label .required' ).remove();
			field.removeClass( 'validate-required woocommerce-invalid woocommerce-invalid-required-field' );

			if ( field.find( 'label .optional' ).length === 0 ) {
				field.find( 'label' ).append( '&nbsp;<span class="optional">(' + wc_address_i18n_params.i18n_optional_text + ')</span>' );
			}
		}
	}

	$( document )
		.on( 'country_to_state_changing', function( event, country, wrapper ) {
			if ( 0 === woodmart_checkout_fields.length ) {
				return;
			}

			let thisform      = wrapper;
			let locale_fields = JSON.parse( wc_address_i18n_params.locale_fields );

			$.each( locale_fields, function( key, value ) {
				let field     = thisform.find( value );
				let fieldName = field.find('[name]').attr('name');

				if ( ! woodmart_checkout_fields.hasOwnProperty(fieldName) || ! woodmart_checkout_fields[fieldName].hasOwnProperty('required') ) {
					return;
				}

				let isRequired = woodmart_checkout_fields[fieldName]['required'];

				isRequiredField( field, isRequired );
			});
		});
})(jQuery);
