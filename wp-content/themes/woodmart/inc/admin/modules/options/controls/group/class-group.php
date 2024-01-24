<?php
/**
 * Group control.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Admin\Modules\Options;
use XTS\Admin\Modules\Options\Field;
use XTS\Admin\Modules\Options\Page;
use XTS\Admin\Modules\Options\Presets;
use XTS\Registry;

/**
 * Notice control.
 */
class Group extends Field {
	public function __construct( $args, $options, $type = 'options', $object = 'post' ) {
		parent::__construct( $args, $options, $type, $object );

		$inner_fields = $this->args['inner_fields'];

		usort(
			$inner_fields,
			function ( $item1, $item2 ) {

				if ( ! isset( $item1['priority'] ) ) {
					return 1;
				}

				if ( ! isset( $item2['priority'] ) ) {
					return -1;
				}

				return $item1['priority'] - $item2['priority'];
			}
		);

		foreach ( $inner_fields as $field_args ) {
			if ( ! isset( $this->options[ $field_args['id'] ] ) ) {
				$this->options[ $field_args['id'] ] = Options::get_default( $field_args );
			}

			if ( 'metabox' === $this->_type ) {
				$this->inner_fields[ $field_args['id'] ] = new Options::$_controls_classes[ $field_args['type'] ]( $field_args, $this->options, $type, $object );
			} else {
				$this->inner_fields[ $field_args['id'] ] = new Options::$_controls_classes[ $field_args['type'] ]( $field_args, $this->options );
			}
		}
	}

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$design = isset( $this->args['style'] ) ? $this->args['style'] : 'default';

		if ( 'dropdown' === $design ) {
			$btn_settings = array(
				'label'   => esc_html__( 'Edit', 'woodmart' ),
				'classes' => '',
			);

			if ( ! empty( $this->args['btn_settings'] ) ) {
				$btn_settings = wp_parse_args( $this->args['btn_settings'], $btn_settings );
			}

			?>
			<a class="xts-btn xts-color-primary xts-dropdown-open <?php echo esc_attr( $btn_settings['classes'] ); ?>">
				<?php echo esc_html( $btn_settings['label'] ); ?>
			</a>
			<div class="xts-dropdown-options xts-hidden">
				<?php $this->render_inner_fields(); ?>
			</div>
			<?php
		} else {
			?>
			<div class="xts-fields-group">
				<?php $this->render_inner_fields(); ?>
			</div>
			<?php
		}
	}

	/**
	 * Render inner button
	 *
	 * @return void
	 */
	private function render_inner_fields() {
		foreach ( $this->inner_fields as $field ) {
			if ( 'metabox' === $this->_type ) {
				$field->render( $this->_term );
			} else {
				if ( Page::get_instance()->is_inherit_field( $field->get_id() ) ) {
					$field->inherit_value( true );
				}

				$field->render( null, Presets::get_current_preset(), true );
			}
		}
	}

	/**
	 * Get field label with reset button.
	 *
	 * @return void
	 */
	public function get_field_label() {
		parent::get_field_label();

		if ( Presets::get_current_preset() && $this->inner_fields ) {
			$inner_input_ids = array();

			foreach ( $this->inner_fields as $field ) {
				$inner_input_ids[] = $field->args['id'];
			}

			?>
			<input type="hidden" class="xts-group-settings" data-inputs-id='<?php echo wp_json_encode( $inner_input_ids ); ?>'>
			<?php
		}

		if ( empty( $this->args['style'] ) || 'dropdown' !== $this->args['style'] ) {
			return;
		}

		$inner_input_name = array();
		$show_reset_btn   = false;

		if ( $this->inner_fields ) {
			foreach ( $this->inner_fields as $field ) {
				$inner_input_name[] = $field->get_input_name();

				if ( 'color' === $field->args['type'] ) {
					$inner_input_name[] = $field->get_input_name( 'idle' );
					$inner_input_name[] = $field->get_input_name( 'hover' );
				}

				if ( $show_reset_btn ) {
					continue;
				}

				if ( 'metabox' === $this->_type ) {
					$field->_term = $this->_term;
				}

				$field_value         = $field->get_field_value();
				$field_default_value = $field->get_default_value();

				if ( $field_value && $field_value != $field_default_value ) { //phpcs:ignore
					$show_reset_btn = true;
				}
			}
		}

		?>
		<a href="#" class="xts-reset-group xts-i-round-left<?php echo $show_reset_btn ? ' xts-show' : ' xts-hidden'; ?>" data-settings='<?php echo wp_json_encode( $inner_input_name ); ?>' title="<?php esc_html_e( 'Reset', 'woodmart' ); ?>"></a>
		<?php
	}

	/**
	 * Output field's css code based on the settings..
	 *
	 * @since 1.0.0
	 *
	 * @return array $output Generated CSS code.
	 */
	public function css_output() {
		if ( empty( $this->inner_fields ) || $this->check_is_requires_css() ) {
			return array();
		}

		$device           = ! empty( $this->args['css_device'] ) ? $this->args['css_device'] : 'desktop';
		$is_active_preset = 'metabox' !== $this->_type && Registry::getInstance()->themesettingscss->is_preset_active();
		$output_css       = array(
			$device => array(),
		);

		foreach ( $this->inner_fields as $inner_field ) {
			if ( 'metabox' === $this->_type ) {
				if ( $this->_term ) {
					$inner_field->set_post( $this->_term );
				} else {
					$inner_field->set_post( $this->_post );
				}
			} else {
				$inner_field->set_presets( $this->_presets );
			}

			if ( 'metabox' === $this->_type || ! $is_active_preset || woodmart_is_opt_changed( $inner_field->args['id'] ) ) {
				if ( 'metabox' === $this->_type && $this->options ) {
					$object_id = $this->_post ? $this->_post->ID : $this->_term->term_id;

					foreach ( $this->options as $key => $value ) {
						if ( ! $value ) {
							$this->options[ $key ] = get_metadata( $this->_object, $object_id, $key, true );
						}
					}

					$inner_field->options = $this->options;
				}

				$inner_field_css = $inner_field->css_output();

				if ( $inner_field_css && is_array( $inner_field_css ) ) {
					$output_css = array_merge_recursive( $output_css, $inner_field_css );
				}
			}
		}

		if ( empty( $this->args['selectors'] ) || ! function_exists( 'woodmart_decompress' ) ) {
			return $output_css;
		}

		$generate_css = false;

		foreach ( $this->args['selectors'] as $selector => $css_data ) {
			foreach ( $css_data as $css ) {
				$generate_preset_css = false;

				foreach ( $this->inner_fields as $field ) {
					if ( ! $generate_preset_css && $is_active_preset && str_contains( $css, '{{' . strtoupper( $field->get_id() ) . '}}' ) && woodmart_is_opt_changed( $field->args['id'] ) ) {
						$generate_preset_css = true;
					}

					$field_value = $field->get_field_value();

					if ( is_array( $field_value ) ) {
						$field_value = reset( $field_value );

						if ( $field_value ) {
							$generate_css = true;
						}
					} elseif ( woodmart_is_compressed_data( $field_value ) ) {
						$decompressed_value = json_decode( woodmart_decompress( $field_value ), true );

						if ( isset( $decompressed_value['devices'][ $device ]['value'] ) ) {
							$field_value = (string) $decompressed_value['devices'][ $device ]['value'];

							if ( ! $field_value ) {
								$field_value = '0';
							} else {
								$generate_css = true;
							}

							if ( ! empty( $decompressed_value['devices'][ $device ]['unit'] ) ) {
								$field_value .= $decompressed_value['devices'][ $device ]['unit'];
							}
						} else {
							$field_value = 0;
						}
					} elseif ( $field_value && ! $generate_css ) {
						$generate_css = true;
					}

					if ( isset( $this->args['css_rules'] ) && ! empty( $this->args['css_rules']['with_all_value'] ) && ! $field_value && str_contains( $css, '{{' . strtoupper( $field->get_id() ) . '}}' ) ) {
						$generate_css = false;

						break;
					}

					$css = str_replace( '{{' . strtoupper( $field->get_id() ) . '}}', $field_value, $css );
				}

				if ( ! $generate_css || ! $generate_preset_css && $is_active_preset ) {
					continue;
				}

				$output_css[ $device ][ $selector ][] = $css . "\n";
			}
		}

		return $output_css;
	}
}


