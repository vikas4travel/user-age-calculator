<?php
/**
 * Plugin Name:       User Age Calculator
 * Plugin URI:        https://caketech.in/
 * Description:       Allows website users to calculate their age by providing a birth date.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Vikas Sharma
 * Author URI:        https://caketech.in/vikas/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-age-calculator
 *
 * User Age Calculator
 * Copyright (C) 2021, Vikas Sharma <vikas@caketech.in>
 *
 * 'User Age Calculator' is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * 'User Age Calculator' is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with 'User Age Calculator'. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 *
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

class User_Age_Calculator {

	static $plugin_name     = 'User Age Calculator';
	static $plugin_slug     = 'user-age-calculator';
	public $error_message   = '';
	public $success_message = '';

	public function __construct() {

		if ( is_admin() ) {
			// Activation and Deactivation hooks
			register_activation_hook( __FILE__, [ $this, 'plugin_activation' ] );
			register_deactivation_hook( __FILE__, [ $this, 'plugin_deactivation' ] );
			add_action( 'admin_init', [ $this, 'do_activation_redirect' ] );
			add_action( 'admin_menu', [ $this, 'create_admin_menu' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts_and_styles' ] );
			add_action( 'admin_notices', [ $this, 'notice_welcome' ] );
		}

		// Add shortcode
		add_shortcode( 'user-age-calculator', [ $this, 'user_age_calculator_shortcode' ] );
	}

	/**
	 * Activate the plugin
	 */
	public function plugin_activation() : void {
		set_transient( 'uac_activation_redirect_transient', true, 30 );
	}

	/**
	 * Deactivate the plugin
	 */
	public function plugin_deactivation() : void {
		// To Do:
	}

	public function do_activation_redirect() {
		// Bail if no activation redirect
		if ( ! get_transient( 'uac_activation_redirect_transient' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( 'uac_activation_redirect_transient' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Redirect to plugin page
		wp_safe_redirect( add_query_arg( array( 'page' => self::$plugin_slug ), admin_url( 'options-general.php' ) ) );
	}

	/**
	 * Add menu item in the admin area.
	 */
	public function create_admin_menu() {
		add_submenu_page( 'options-general.php', self::$plugin_name, self::$plugin_name, 'manage_options', self::$plugin_slug, [ $this, 'admin_panel' ] );
	}

	/**
	 * Enqueue CSS for ou plugin in admin area.
	 */
	public function enqueue_admin_scripts_and_styles(){
		wp_enqueue_style('uac_admin_style', plugin_dir_url(__FILE__) . '/assets/css/admin-styles.css');
		wp_enqueue_script( 'uac_admin_script', plugin_dir_url(__FILE__) . '/assets/js/admin-scripts.js', array(), '1.0.0', true );
	}

	/**
	 * Display welcome messages
	 */
	public function notice_welcome() {
		global $pagenow;

		if ( 'options-general.php' === $pagenow && isset( $_GET['page'] ) && self::$plugin_slug === $_GET['page'] ) {
			if ( ! get_option( 'uac_welcome' ) ) {
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo __( 'Thank you for installing user age calculator.', 'user-age-calculator' ) ?></p>
				</div>
				<?php
				update_option( 'uac_welcome', 1 );
			}
		}
	}

	public function admin_panel(){
		if ( ! current_user_can( 'administrator' ) ) {
			echo '<p>' . __( 'Sorry, you are not allowed to access this page.', 'user-age-calculator' ) . '</p>';
			return;
		}

		$active_tab = 1;

		// if the form was submitted
		if ( isset( $_POST[ self::$plugin_slug . '-nonce' ] ) ) { // Input var okay.

			// Verify the nonce before proceeding.
			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::$plugin_slug . '-nonce' ] ) ), self::$plugin_slug ) ) { // Input var okay.

				// To Do: Update data here

				echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Success! data saved successfully.', 'user-age-calculator' ) . '</p></div>';

			} else {
				echo '<div class="notice notice-error is-dismissible"><p>' . __( 'Error: Invalid nonce, data not saved, please try again!', 'user-age-calculator' ) . '</p></div>';
			}
		}

		// Display the plugin page
		include_once( __DIR__ . '/templates/admin-panel.php' );
	}

	public function user_age_calculator_shortcode( $atts ) {
		if ( empty( $atts['template'] ) ) {
			return '';
		}

		wp_enqueue_style( 'uac-styles', plugin_dir_url( __FILE__ ) . "/assets/css/styles.css" );
		wp_enqueue_script( 'uac-scripts', plugin_dir_url( __FILE__ ) . "/assets/js/scripts.js", ['jquery'], '', true );

		ob_start();

		if ( 1 === intval( $atts['template'] ) ){
			require __DIR__ . '/templates/user-age-calculator-template1.php';
		} else {
			require __DIR__ . '/templates/user-age-calculator-template2.php';
		}

		return ob_get_clean();
	}
}

new User_Age_Calculator();
