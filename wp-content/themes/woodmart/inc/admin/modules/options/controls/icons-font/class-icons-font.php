<?php
/**
 * Icon fonts control.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Admin\Modules\Options\Field;

/**
 * Icons Font.
 */
class Icons_Font extends Field {

	/**
	 * Icon config.
	 *
	 * @var array|string[]
	 */
	public array $icons_config = array(
		'f114' => 'chevron-left',
		'f113' => 'chevron-right',
		'f115' => 'chevron-up',
		'f129' => 'chevron-down',
		'f121' => 'long-arrow-left',
		'f120' => 'long-arrow-right',
		'f100' => 'warning-sign',
		'f101' => 'play-button',
		'f908' => 'pause-button',
		'f102' => '360-deg',
		'f108' => 'door-logout',
		'f107' => 'check',
		'f143' => 'plus',
		'f112' => 'cross-close',
		'f109' => 'more-dots',
		'f161' => 'vertical-menu',
		'f118' => 'filter',
		'f119' => 'sort-by',
		'f122' => 'grid',
		'f105' => 'header-cart',
		'f123' => 'cart',
		'f126' => 'bag',
		'f106' => 'heart',
		'f124' => 'user',
		'f125' => 'newlatter',
		'f127' => 'scale-arrows',
		'f128' => 'compare',
		'f130' => 'search',
		'f13f' => 'ruler',
		'f144' => 'home',
		'f146' => 'shop',
		'f147' => 'cart-empty',
		'f911' => 'cart-verified',
		'f148' => 'star',
		'f149' => 'star-empty',
		'f15a' => 'menu',
		'f15c' => 'menu-filters',
		'f182' => 'bundle',
		'f183' => 'map-pointer',
		'f906' => 'like',
		'f907' => 'dislike',
		'f11d' => 'fire',
		'f11a' => 'eye',
		'f11b' => 'eye-disable',
		'f116' => 'edit',
		'f117' => 'social',
		'f103' => 'comment',
		'f104' => 'paperclip',
		'f145' => 'blog',
		'f11c' => 'external-link',
		'f131' => 'quote',
		'f900' => 'list-view',
		'f901' => 'grid-view-2',
		'f902' => 'grid-view-3',
		'f903' => 'grid-view-4',
		'f904' => 'grid-view-5',
		'f905' => 'grid-view-6',
		'f134' => 'account-wishlist',
		'f135' => 'account-details',
		'f136' => 'account-download',
		'f137' => 'account-exit',
		'f138' => 'account-orders',
		'f139' => 'account-address',
		'f140' => 'account-other',
		'f142' => 'account-payment',
		'f157' => 'envelope-solid',
		'f133' => 'tik-tok-brands',
		'f154' => 'twitter-brands',
		'f155' => 'github-brands',
		'f156' => 'pinterest-brands',
		'f158' => 'linkedin-brands',
		'f162' => 'youtube-brands',
		'f163' => 'instagram-brands',
		'f164' => 'flickr-brands',
		'f165' => 'tumblr-brands',
		'f166' => 'dribbble-brands',
		'f167' => 'skype-brands',
		'f168' => 'vk-brands',
		'f169' => 'google-brands',
		'f170' => 'behance-brands',
		'f171' => 'spotify-brands',
		'f172' => 'soundcloud-brands',
		'f174' => 'facebook-square-brands',
		'f176' => 'odnoklassniki-brands',
		'f177' => 'vimeo-v-brands',
		'f178' => 'snapchat-ghost-brands',
		'f179' => 'telegram-brands',
		'f180' => 'facebook-f-brands',
		'f181' => 'viber-brands',
		'f175' => 'whatsapp-brands',
		'f184' => 'discord-brands',
	);

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value   = $this->get_field_value();
		$options = $this->get_field_options();

		?>
		<div class="xts-fields-group xts-group">
			<div class="xts-fields">
				<div class="xts-field xts-col-6">
					<?php if ( ! empty( $options['font'] ) ) : ?>
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Icon design', 'woodmart' ); ?>
								</span>
							</label>
						</div>

						<div class="xts-option-control">
							<select class="xts-select xts-icon-font-select" name="<?php echo esc_attr( $this->get_input_name( 'font' ) ); ?>" aria-label="<?php echo esc_attr( $this->get_input_name( 'font' ) ); ?>">
								<?php foreach ( $options['font'] as $option ) : ?>
									<?php
									$selected = false;

									if ( ! empty( $value['font'] ) && strval( $value['font'] ) === strval( $option['value'] ) ) {
										$selected = true;
									}

									?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( true, $selected ); ?>>
										<?php echo esc_html( $option['name'] ); ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
				<div class="xts-field xts-col-6">
					<?php if ( ! empty( $options['weight'] ) ) : ?>
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Icon weight', 'woodmart' ); ?>
								</span>
							</label>
						</div>

						<div class="xts-option-control">
							<select class="xts-select xts-icon-weight-select" name="<?php echo esc_attr( $this->get_input_name( 'weight' ) ); ?>" aria-label="<?php echo esc_attr( $this->get_input_name( 'weight' ) ); ?>">
								<?php foreach ( $options['weight'] as $option ) : ?>
									<?php
									$selected = false;

									if ( ! empty( $value['weight'] ) && strval( $value['weight'] ) === strval( $option['value'] ) ) {
										$selected = true;
									}

									?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( true, $selected ); ?>>
										<?php echo esc_html( $option['name'] ); ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
				<?php $this->preview_icons(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Preview icons.
	 *
	 * @return void
	 */
	public function preview_icons() {
		wp_enqueue_style( 'wd-icon-preview', WOODMART_ASSETS . '/css/icon-preview.css', array(), WOODMART_VERSION );

		?>
		<div class="xts-field xts-icons-preview">
			<?php foreach ( $this->icons_config as $key => $name ) : ?>
				<div class="wd-icon-<?php echo esc_attr( $name ); ?>" tabindex="0">
					<div class="xts-tooltip xts-top" tabindex="0">
						<div class="xts-tooltip-inner">
							content: <span class="xts-icon-cont">"\<?php echo esc_attr( $key ); ?>"</span>;<br>
							font-family: <span class="xts-icon-font">"woodmart-font"</span>;<br>
							font-weight: <span class="xts-icon-weight">400</span>;
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Enqueue.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		$icon_font_name = 'woodmart-font-';
		$value          = $this->get_field_value();

		if ( ! empty( $value['font'] ) ) {
			$icon_font_name .= $value['font'];
		}

		if ( ! empty( $value['weight'] ) ) {
			$icon_font_name .= '-' . $value['weight'];
		}

		?>
		<style id="wd-icon-font">
			@font-face {
				font-weight: normal;
				font-style: normal;
				font-family: "woodmart-font";
				src: url("<?php echo esc_url( woodmart_remove_https( WOODMART_THEME_DIR . '/fonts/' . $icon_font_name . '.woff2' ) . '?v=' . woodmart_get_theme_info( 'Version' ) ); ?>") format("woff2");
			}
		</style>
		<?php
	}
}