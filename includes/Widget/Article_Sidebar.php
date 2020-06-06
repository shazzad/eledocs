<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;
use \WeDevs\WeDocs\Walker;

class Article_Sidebar extends Widget_Base {

	public function get_name() {
		return 'eledocs-article-sidebar';
	}

	public function get_title() {
		return __( 'Article Sidebar', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_categories() {
		return [ 'eledocs' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'sidebar' ];
	}

	protected function _register_controls() {
		$this->_parents_style_controls();
	}

	protected function _parents_style_controls() {
		$this->start_controls_section(
			'parent_title_style',
			[
				'label' => __( 'Section Title' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'parent_title_border',
				'selector' => '{{WRAPPER}} .parent-title',
				'separator' => 'before',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '1',
							'left' => '0',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => '#ddd'
					]
				]
			]
		);

        $this->add_control(
			'parent_title_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .parent-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'parent_title_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .parent-title' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'parent_title_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .parent-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
		            'unit' => 'px',
		            'top' => 0,
		            'right' => 0,
		            'bottom' => 10,
		            'left' => 0,
		            'isLinked' => false
		        ]
			]
		);

		$this->add_responsive_control(
			'parent_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .parent-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
		            'unit' => 'px',
		            'top' => 0,
		            'right' => 0,
		            'bottom' => 10,
		            'left' => 0,
		            'isLinked' => false
		        ]
			]
		);

        $this->end_controls_section();
	}

	protected function render() {
		global $post;

		$this->add_render_attribute(
			'wrapper',
			'class',
			'eledocs-article-sidebar-container'
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="wedocs-sidebar" style="width: 100%;">
			<?php
			$ancestors = [];
			$root      = $parent = false;

			if ( $post->post_parent ) {
			    $ancestors = get_post_ancestors( $post->ID );
			    $root      = count( $ancestors ) - 1;
			    $parent    = $ancestors[$root];
			} else {
			    $parent = $post->ID;
			}

			$walker   = new Walker();
			$children = wp_list_pages( [
			    'title_li'  => '',
			    'order'     => 'menu_order',
			    'child_of'  => $parent,
			    'echo'      => false,
			    'post_type' => 'docs',
			    'walker'    => $walker,
			] );
			?>

			<?php if ( $children ) { ?>
			    <ul class="doc-nav-list">
			        <?php echo $children; ?>
			    </ul>
			<?php } ?>
			</div>
		</div>
		<?php
	}
}
