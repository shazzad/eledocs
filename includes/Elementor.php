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
		add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_dynamic_tags' ] );

		// register template display conditions
		add_action( 'elementor/theme/register_conditions', [ $this, 'register_conditions' ] );
    }

	/**
	 * @param Conditions_Manager $conditions_manager
	 */
	public function register_conditions( $conditions_manager ) {
		$doc = new Condition\Doc();
		$section = new Condition\Section();

		$conditions_manager->get_condition( 'docs' )->register_sub_condition( $doc );
		$conditions_manager->get_condition( 'docs' )->register_sub_condition( $section );
	}

	public function register_dynamic_tags( $dynamic_tags ) {
		\Elementor\Plugin::$instance->dynamic_tags->register_group(
			'eledocs', [
				'title' => 'EleDocs'
			]
		);
		$dynamic_tags->register_tag( '\EleDocs\DynamicTag\Doc_Title' );
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
			ELEDOCS_ASSETS . '/css/widgets.css',
			[],
			filemtime( ELEDOCS_PATH . '/assets/css/widgets.css' )
		);

		wp_register_script(
			'eledocs-widgets',
			ELEDOCS_ASSETS . '/js/widgets.js',
			[ 'jquery' ],
			filemtime( ELEDOCS_PATH . '/assets/js/widgets.js' ),
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
				'title' => __( 'EleDocs', 'eledocs' ),
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
		$widgets_manager->register_widget_type( new Widget\Children() );
    }
}
