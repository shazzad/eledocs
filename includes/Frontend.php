<?php

namespace WeDocs\Elementor_Integration;

/**
 * Frontend Handler Class
 */
class Frontend {

    /**
     * Class Constructor
     */
    function __construct() {

        // Loads frontend scripts and styles
        # add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        // override the theme template
        add_filter( 'template_include', [ $this, 'template_loader' ], 21 );
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
    public function enqueue_scripts() {
        // All styles goes here
        wp_enqueue_style(
			'wdei-styles',
			WDEI_ASSETS . '/css/frontend.css',
			[],
			filemtime( WDEI_PATH . '/assets/css/frontend.css' )
		);
    }

    /**
     * If the theme doesn't have any single doc handler, load that from
     * the plugin.
     *
     * @param string $template
     *
     * @return string
     */
    public function template_loader( $template ) {
        if ( is_single() && get_post_type() == 'docs' ) {
			$template = wedocs_elementor_integration()->template_path() . 'single-docs.php';
        }

        return $template;
    }
}
