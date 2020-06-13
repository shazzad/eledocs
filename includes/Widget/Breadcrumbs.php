<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Breadcrumbs extends Widget_Base {

	public function get_name() {
		return 'eledocs-breadcrumbs';
	}

	public function get_title() {
		return __( 'Docs Breadcrumbs', 'eledocs' );
	}

	public function get_icon() {
		return 'fa fa-chevron-right';
	}

	public function get_categories() {
		return [ 'eledocs' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'eledocs', 'breadcrumbs' ];
	}

	protected function _register_controls() {
		$this->_settings_controls();
	}

	protected function _settings_controls() {
		$this->start_controls_section(
			'settings_content',
			[
				'label' => __( 'Settings', 'ecll' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_home_link',
			[
				'label' => __( 'Show home link?', 'eledocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eledocs' ),
				'label_off' => __( 'Hide', 'eledocs' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_docs_link',
			[
				'label' => __( 'Show docs link?', 'eledocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eledocs' ),
				'label_off' => __( 'Hide', 'eledocs' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$this->add_render_attribute(
			'wrapper',
			'class',
			'eledocs-breadcrumbs-container'
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php $this->display_breadcrumbs(); ?>
		</div>
		<?php
	}

	private function display_breadcrumbs() {
        global $post;
		$settings = $this->get_settings_for_display();

        $html = '';
        $args = apply_filters( 'wedocs_breadcrumbs', [
            'delimiter' => '<li class="delimiter"><i class="wedocs-icon wedocs-icon-angle-right"></i></li>',
            'home'      => __( 'Home', 'wedocs' ),
            'before'    => '<li><span class="current">',
            'after'     => '</span></li>',
        ] );

        $breadcrumb_position = 0;

        $html .= '<ol class="wedocs-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

		if ( 'yes' === $settings['show_home_link'] ) {
			++ $breadcrumb_position;

			$html .= '<li><i class="wedocs-icon wedocs-icon-home"></i></li>';
	        $html .= wedocs_get_breadcrumb_item( $args['home'], home_url( '/' ), $breadcrumb_position );
	        $html .= $args['delimiter'];
		}

        $docs_home = wedocs_get_option( 'docs_home', 'wedocs_settings' );
        if ( $docs_home && 'yes' === $settings['show_docs_link'] ) {
            ++ $breadcrumb_position;

            $html .= wedocs_get_breadcrumb_item( __( 'Docs', 'wedocs' ), get_permalink( $docs_home ), $breadcrumb_position );
            $html .= $args['delimiter'];
        }

		if ( 'docs' == $post->post_type && $post->post_parent ) {
		    $parent_id   = $post->post_parent;
		    $pages = [];

		    while ( $parent_id ) {
		        $page          = get_post( $parent_id );
		        $parent_id     = $page->post_parent;
		        $pages[]       = $page;
		    }

		    $pages = array_reverse( $pages );

		    foreach ( $pages as $page ) {
		        ++ $breadcrumb_position;

		        $html .= wedocs_get_breadcrumb_item( get_the_title( $page->ID ), get_permalink( $page->ID ), $breadcrumb_position );
		        $html .= ' ' . $args['delimiter'] . ' ';
		    }
		}

        $html .= ' ' . $args['before'] . get_the_title() . $args['after'];

        $html .= '</ol>';

        echo apply_filters( 'wedocs_breadcrumbs_html', $html, $args );
    }
}
