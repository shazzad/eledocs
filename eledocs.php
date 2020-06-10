<?php
/*
Plugin Name: EleDocs
Plugin URI: https://w4dev.com/
Description: Use Elementor Pro to modify WeDocs frontend.
Version: 1.0.0
Author: Shazzad Hossain Khan
Author URI: https://shazzad.me/
License: GPL2
Text Domain: eledocs
Domain Path: /languages
*/

// Don't call the file directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Defined this file as plugin base file.
if ( ! defined( 'ELEDOCS_PLUGIN_FILE' ) ) {
	define( 'ELEDOCS_PLUGIN_FILE', __FILE__ );
}

// Load dependencies.
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Get Plugin Instance.
 *
 * @return \EleDocs
 */
function eledocs() {
    return \EleDocs\Plugin::init();
}

/**
* Show in WP Dashboard notice about wedocs requirement.
 *
 * @return void
 */
function eledocs_notice_missing_wedocs() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	echo '<div class="error"><p>' . __( 'EleDocs is not working because you need to activate the WeDocs plugin.', 'eledocs' ) . '</p></div>';
}

/**
 * Show in WP Dashboard notice about elementor pro requirement.
 *
 * @return void
 */
function eledocs_notice_missing_elementor_pro() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	echo '<div class="error"><p>' . __( 'EleDocs is not working because you need to activate the Elementor Pro plugin.', 'eledocs' ) . '</p></div>';
}

/**
 * Kickoff the plugin or display admin notice if dependencies unavailable.
 *
 * @return void
 */
function eledocs_load_plugin() {
	if ( ! defined( 'WEDOCS_VERSION' ) ) {
		add_action( 'admin_notices', 'eledocs_notice_missing_wedocs' );
		return;
	}

	if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
		add_action( 'admin_notices', 'eledocs_notice_missing_elementor_pro' );
		return;
	}

	// Kick.
	eledocs();
}

add_action( 'plugins_loaded', 'eledocs_load_plugin' );
