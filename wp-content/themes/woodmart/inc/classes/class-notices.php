<?php
/**
 * Notices helper class.
 *
 * @package xts
 */


	namespace XTS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Notices helper class
 */
class Notices {
	/**
	 * All notices.
	 *
	 * @var array
	 */
	public $notices;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->notices = array();

		add_action( 'admin_init', array( $this, 'nag_ignore' ) );
		add_action( 'admin_notices', array( $this, 'add_notice' ), 50 );
	}

	/**
	 * Add notice message.
	 *
	 * @param string  $msg Message.
	 * @param string  $type Notice type.
	 * @param boolean $global Is global message.
	 *
	 * @return void
	 */
	public function add_msg( $msg, $type, $global = false ) {
		$this->notices[] = array(
			'msg'    => $msg,
			'type'   => $type,
			'global' => $global,
		);

		$this->nag_ignore();
	}

	/**
	 * Get all message.
	 *
	 * @param boolean $globals Is global message.
	 *
	 * @return array
	 */
	public function get_msgs( $globals = false ) {
		if ( $globals ) {
			return array_filter(
				$this->notices,
				function( $v ) {
					return $v['global'];
				}
			);
		}

		return $this->notices;
	}

	/**
	 * Clear message.
	 *
	 * @param boolean $globals Is global message.
	 *
	 * @return void
	 */
	public function clear_msgs( $globals = true ) {
		if ( $globals ) {
			$this->notices = array_filter(
				$this->notices,
				function( $v ) {
					return ! $v['global'];
				}
			);
		} else {
			$this->notices = array();
		}
	}

	/**
	 * Show message.
	 *
	 * @param boolean $globals Is global message.
	 *
	 * @return void
	 */
	public function show_msgs( $globals = false ) {
		$msgs = $this->get_msgs( $globals );
		if ( ! empty( $msgs ) ) {
			foreach ( $msgs as $key => $msg ) {
				if ( ! $globals && $msg['global'] ) {
					continue;
				}
				echo '<div class="woodmart-msg xts-notice xts-' . $msg['type'] . '">';
					echo '<div>' . $msg['msg'] . '</div>';
				echo '</div>';
			}
		}

		$this->clear_msgs( $globals );
	}

	/**
	 * Add notice.
	 *
	 * @return void
	 */
	public function add_notice() {
		$msgs = $this->get_msgs( true );
		global $current_user;

		$user_id = $current_user->ID;

		if ( ! empty( $msgs ) ) {
			foreach ( $msgs as $key => $msg ) {
				$hash = md5( serialize( $msg['msg'] ) );
				if ( get_user_meta( $user_id, $hash ) ) {
					continue;
				}
				echo '<div class="xts-notice notice xts-' . esc_attr( $msg['type'] ) . '">';
				echo '<p>' . wp_kses( $msg['msg'], true ) . '</p>';

				if ( 'error' !== $msg['type'] ) {
					echo '<a class="wd-dismiss-link" href="' . esc_url( wp_nonce_url( add_query_arg( 'woodmart-hide-notice', $hash ) ) ) . '">' . esc_html_e( 'Dismiss Notice', 'woodmart' ) . '</a>';
					echo '<a class="notice-dismiss" href="' . esc_url( wp_nonce_url( add_query_arg( 'woodmart-hide-notice', $hash ) ) ) . '"></a>';
				}

				echo '</div>';
			}
		}
	}

	/**
	 * Add error message.
	 *
	 * @param string  $msg Message.
	 * @param boolean $global Is global message.
	 *
	 * @return void
	 */
	public function add_error( $msg, $global = false ) {
		$this->add_msg( $msg, 'error', $global );
	}

	/**
	 * Add warning message.
	 *
	 * @param string  $msg Message.
	 * @param boolean $global Is global message.
	 *
	 * @return void
	 */
	public function add_warning( $msg, $global = false ) {
		$this->add_msg( $msg, 'warning', $global );
	}

	/**
	 * Add success message.
	 *
	 * @param string  $msg Message.
	 * @param boolean $global Is global message.
	 *
	 * @return void
	 */
	public function add_success( $msg, $global = false ) {
		$this->add_msg( $msg, 'success', $global );
	}

	/**
	 * Hide notice for current user.
	 *
	 * @return void
	 */
	public function nag_ignore() {
		if ( ! isset( $_GET['woodmart-hide-notice'] ) ) {
			return;
		}
		global $current_user;
		$user_id = $current_user->ID;

		$hide_notice = sanitize_text_field( wp_unslash( $_GET['woodmart-hide-notice'] ) );

		/* If user clicks to ignore the notice, add that to their user meta */
		if ( $hide_notice ) {
			add_user_meta( $user_id, $hide_notice, true );
		}
	}
}
