<?php

namespace EleDocs;

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * EleDocs class.
 *
 * @class EleDocs The class that holds the entire EleDocs plugin
 */
final class Plugin {

    /**
     * Plugin version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The plugin url.
     *
     * @var string
     */
    public $plugin_url;

    /**
     * The plugin path.
     *
     * @var string
     */
    public $plugin_path;

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

		add_action( 'init', [ $this, 'localization_setup' ] );
        add_action( 'after_setup_theme', [ $this, 'initialize' ] );
    }

    /**
     * Initializes the EleDocs() class.
     *
     * Checks for an existing EleDocs() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'ELEDOCS_VERSION', self::VERSION );
        define( 'ELEDOCS_PATH', plugin_dir_path( ELEDOCS_PLUGIN_FILE ) );
        define( 'ELEDOCS_URL', plugin_dir_url( ELEDOCS_PLUGIN_FILE ) );
        define( 'ELEDOCS_ASSETS', ELEDOCS_URL . '/assets' );
    }

    /**
     * Initialize.
     */
    public function initialize() {
		new Elementor();
        if ( ! is_admin() ) {
           new Frontend();
        }
    }

    /**
     * Initialize plugin for localization.
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wdei', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url() {
        if ( $this->plugin_url ) {
            return $this->plugin_url;
        }

        return $this->plugin_url = untrailingslashit( ELEDOCS_URL );
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        if ( $this->plugin_path ) {
            return $this->plugin_path;
        }

        return $this->plugin_path = untrailingslashit( ELEDOCS_PATH );
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return $this->plugin_path() . '/templates/';
    }

} // EleDocs
