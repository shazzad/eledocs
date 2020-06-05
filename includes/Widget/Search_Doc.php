<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Search_Doc extends Widget_Base {

	public function get_name() {
		return 'wdei-search-doc';
	}

	public function get_title() {
		return __( 'Search Doc', 'wedocs-elementor-integration' );
	}

	public function get_icon() {
		return 'fa fa-search';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'search' ];
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
			'show_docs_dropdown',
			[
				'label' => __( 'Show Docs Dropdown?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wedocs-elementor-integration' ),
				'label_off' => __( 'Hide', 'wedocs-elementor-integration' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'docs_dropdown_label',
			[
				'label' => __( 'Docs Dropdown Label', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'All Docs', 'wedocs-elementor-integration' ),
				'condition' => [
		            'show_docs_dropdown' => 'yes'
		        ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'search_placeholder_text',
			[
				'label' => __( 'Search Placeholder Text', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Documentation Search &hellip;', 'wedocs-elementor-integration' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'search_button_text',
			[
				'label' => __( 'Search Button Text', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Search', 'wedocs-elementor-integration' ),
				'label_block' => true,
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$dropdown_html = '';
		if ( $settings['show_docs_dropdown'] === 'yes' ) {
			$dropdown_args = [
	            'post_type'         => 'docs',
	            'echo'              => 0,
	            'depth'             => 1,
	            'show_option_none'  => $settings['docs_dropdown_label'],
	            'option_none_value' => '0',
	            'name'              => 'doc-id',
				'class'				=> 'doc-id'
	        ];

			if ( isset( $_GET['search_in_doc'] ) && 'all' != $_GET['search_in_doc'] ) {
	            $dropdown_args['selected'] = (int) $_GET['search_in_doc'];
	        }

			$dropdown_html = '<div class="wdei-field docs-dropdown-field-wrap">
            ' . wp_dropdown_pages( $dropdown_args ) . '
            </div>';
		} else {
			global $post;

			if ( $post->post_type === 'docs' ) {
				if ( $post->post_parent ) {
			        $ancestors = get_post_ancestors( $post->ID );
			        $root      = count( $ancestors ) - 1;
			        $parent    = $ancestors[$root];
			    } else {
			        $parent = $post->ID;
			    }

				$dropdown_html = '<input type="hidden" name="search_in_doc" value="'. $parent .'" />';
			}
		}

		$this->add_render_attribute( 'wrapper', 'class', 'wdei-search-doc' );

		$this->add_render_attribute( 'form', 'class', 'wdei-form wdei-search-form' );
		$this->add_render_attribute( 'form', 'role', 'search' );
		$this->add_render_attribute( 'form', 'method', 'get' );
		$this->add_render_attribute( 'form', 'action', esc_url( home_url( '/' ) ) );

		$this->add_render_attribute( 'search-input', 'type', 'search' );
		$this->add_render_attribute( 'search-input', 'class', 'search-input' );
		$this->add_render_attribute( 'search-input', 'placeholder', esc_attr( $settings['search_placeholder_text'] ) );
		$this->add_render_attribute( 'search-input', 'value', get_search_query() );
		$this->add_render_attribute( 'search-input', 'name', 's' );
		$this->add_render_attribute( 'search-input', 'title', esc_attr( 'Search for:' ) );

		$this->add_render_attribute( 'search-submit', 'type', 'submit' );
		$this->add_render_attribute( 'search-submit', 'class', 'search-submit' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<form <?php echo $this->get_render_attribute_string( 'form' ); ?>>
	            <div class="field-wrap search-field-wrap">
	                <input <?php echo $this->get_render_attribute_string( 'search-input' ); ?> />
				</div>
				<?php echo $dropdown_html ?>
				<input type="hidden" name="post_type" value="docs" />
				<div class="submit-wrap">
	            	<button <?php echo $this->get_render_attribute_string( 'search-submit' ); ?>>
						<?php echo esc_attr( $settings['search_button_text'] ); ?>
					</button>
				</div>
			</form>
			<div class="results-wrap">
				<div class="notice"></div>
				<ul class="results"></ul>
			</div>
		</div>
		<?php
	}
}
