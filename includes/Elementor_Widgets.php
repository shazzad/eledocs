<?php

namespace WeDocs\Elementor_Integration;

/**
 * Frontend Handler Class
 */
class Elementor_Widgets {

    /**
     * Class Constructor
     */
    function __construct() {

		// register elementor widget category - wedocs
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_categories' ] );

        // register elementor widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// register scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }

	/**
     * Enqueue admin scripts.
     *
     * Allows plugin assets to be loaded.
     *
     * @uses wp_enqueue_script()
     * @uses wp_localize_script()
     * @uses wp_enqueue_style
     */
    public function widget_scripts() {
        // All styles goes here
        wp_enqueue_style(
			'wdei-widgets',
			WDEI_ASSETS . '/css/widgets.css',
			[],
			filemtime( WDEI_PATH . '/assets/css/widgets.css' )
		);

		wp_register_script(
			'wdei-widgets',
			WDEI_ASSETS . '/js/widgets.js',
			[ 'jquery' ],
			filemtime( WDEI_PATH . '/assets/js/widgets.js' ),
			true
		);

		wp_localize_script( 'wdei-widgets', 'wdeiSearchDoc', [
			'apiUrl' => rest_url( 'wp/v2/docs/search' ),
			'noKeywords' => __( 'Please enter something' ),
			'noResults' => __( 'Nothing found! Try with another keyword!' ),
			'loadingResults' => __( 'Loading results, please wait.' )
		] );

		wp_enqueue_script( 'wdei-widgets' );
    }

    /**
     * Enqueue admin scripts.
     *
     * Allows plugin assets to be loaded.
     */
    public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'wedocs-elementor-integration',
			[
				'title' => __( 'WeDocs', 'wedocs-elementor-integration' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

    /**
     * Enqueue admin scripts.
     *
     * Allows plugin assets to be loaded.
     */
    public function register_widgets( $widgets_manager ) {
		$widgets_manager->register_widget_type( new Widget\Breadcrumbs() );
		$widgets_manager->register_widget_type( new Widget\Search_Doc() );
		$widgets_manager->register_widget_type( new Widget\Docs() );
		$widgets_manager->register_widget_type( new Widget\Single_Doc_Sidebar() );
		$widgets_manager->register_widget_type( new Widget\Single_Doc_Children() );
    }
}
