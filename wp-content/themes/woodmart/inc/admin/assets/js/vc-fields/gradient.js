(function($) {
	var $panel = $('#vc_ui-panel-edit-element');

	$panel.on('vcPanel.shown', function() {
		$('.wpb_el_type_woodmart_gradient').each( function () {
			var $this = $(this);
			var gradient_line = '#' + $this.find('.woodmart-grad-line').attr('id');
			var gradient_preview = '#' + $this.find('.woodmart-grad-preview').attr('id');
			var $grad_input = $this.find('.wpb_vc_param_value');
			var grad_val = $grad_input.val();
			var result_type_value = '';
			var result_direction_value = '';
			var result_point_value = [];

			if ( grad_val.length ) {
				var data = grad_val.split('|');

				if ( 'undefined' !== typeof data[0] ) {
					var $gradient_settings = data[0].split('/');

					$.each( $gradient_settings, function ( index, value ) {
						var points_values = value.split('-');

						result_point_value.push( {color: points_values[0] ,position: points_values[1]} );
					});
				}
				if ( 'undefined' !== typeof data[2] ) {
					result_type_value = data[2];
				}
				if ( 'undefined' !== typeof data[3] ) {
					result_direction_value = data[3];
				}
			}

			if ( ! result_point_value.length ) {
				result_point_value.push(
					{color:'rgb(60, 27, 59)',position:0},
					{color:'rgb(90, 55, 105)',position: 33},
					{color:'rgb(46, 76, 130)',position:66},
					{color:'rgb(29, 28, 44)',position:100}
				);
			}
			if ( ! result_type_value ) {
				result_type_value = 'linear';
			}
			if ( ! result_direction_value ) {
				result_direction_value = 'left';
			}

			$this.find('.woodmart-grad-line').gradX(gradient_line, {
				targets: [gradient_preview],
				change: function( points, styles, type, direction ) {
					for( var i = 0; i < styles.length; ++i ) {
						$( gradient_preview ).css( 'background-image', styles[i] );

						var points_value = '';

						$( points ).each( function( index , value ){
							points_value +=  value[0] + '-' + value[1] + '/';
						});

						$grad_input.attr( 'value', points_value + '|' + styles[i] + '|' + type + '|' + direction );
					}
				},
				type: result_type_value,
				direction: result_direction_value,
				sliders: result_point_value,
			});
		});
	});
})(jQuery);