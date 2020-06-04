<?php
/*
Plugin Name: weDocs Elementor Integration
Plugin URI: https://w4dev.com/
Description: Use elementor to manage wedocs frontend.
Version: 1.0.0
Author: Shazzad Hossain Khan
Author URI: https://shazzad.me/
License: GPL2
Text Domain: wdei-elementor
Domain Path: /languages
*/

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * WeDocs Elementor Integration class.
 *
 * @class WeDocs_Elementor_Integration The class that holds the entire WeDocs Elementor Integration plugin
 */
final class WeDocs_Elementor_Integration {

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
     * Holds various class instances
     *
     * @var array
     */
    private $container = [];

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();
        $this->init_actions();

        add_action( 'after_setup_theme', [ $this, 'init_classes' ] );
    }


    /**
     * Initializes the WeDocs_Elementor_Integration() class.
     *
     * Checks for an existing WeDocs_Elementor_Integration() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WeDocs_Elementor_Integration();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'WDEI_VERSION', self::VERSION );
        define( 'WDEI_FILE', __FILE__ );
        define( 'WDEI_PATH', __DIR__ );
        define( 'WDEI_URL', plugins_url( '', WDEI_FILE ) );
        define( 'WDEI_ASSETS', WDEI_URL . '/assets' );
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    public function init_actions() {
        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );
    }

    /**
     * Initialize the classes.
     *
     * @since 1.4
     *
     * @return void
     */
    public function init_classes() {
		$this->container['widgets'] = new WeDocs\Elementor_Integration\Elementor_Widgets();
        if ( ! is_admin() ) {
            $this->container['frontend'] = new WeDocs\Elementor_Integration\Frontend();
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

        return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
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

        return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return $this->plugin_path() . '/templates/';
    }

} // WeDocs_Elementor_Integration

/**
 * Initialize the plugin.
 *
 * @return \WeDocs_Elementor_Integration
 */
function wedocs_elementor_integration() {
    return WeDocs_Elementor_Integration::init();
}

// kick it off
wedocs_elementor_integration();
