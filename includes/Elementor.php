<?php

namespace EleDocs;

/**
 * Frontend Handler Class
 */
class Elementor {

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

		// register dynamic tags
		add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_tags' ] );
    }

	public function register_tags( $dynamic_tags ) {
		\Elementor\Plugin::$instance->dynamic_tags->register_group(
			'eledocs', [
				'title' => 'EleDocs'
			]
		);
		$dynamic_tags->register_tag( 'EleDocs\DynamicTag\Doc_Title' );
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
			'eledocs-widgets',
			WDEI_ASSETS . '/css/widgets.css',
			[],
			filemtime( WDEI_PATH . '/assets/css/widgets.css' )
		);

		wp_register_script(
			'eledocs-widgets',
			WDEI_ASSETS . '/js/widgets.js',
			[ 'jquery' ],
			filemtime( WDEI_PATH . '/assets/js/widgets.js' ),
			true
		);

		wp_localize_script( 'eledocs-widgets', 'eledocsSearchDoc', [
			'apiUrl' => rest_url( 'wp/v2/docs/search' ),
			'noKeywords' => __( 'Please enter something', 'eledocs' ),
			'noResults' => __( 'Nothing found! Try with another keyword!', 'eledocs' ),
			'loadingResults' => __( 'Loading results, please wait.', 'eledocs' )
		] );

		wp_enqueue_script( 'eledocs-widgets' );
    }

    /**
     * Enqueue admin scripts.
     *
     * Allows plugin assets to be loaded.
     */
    public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'eledocs',
			[
				'title' => __( 'WeDocs', 'eledocs' ),
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
		$widgets_manager->register_widget_type( new Widget\Sections() );
		$widgets_manager->register_widget_type( new Widget\Article_Sidebar() );
		$widgets_manager->register_widget_type( new Widget\Single_Doc_Children() );
    }
}
