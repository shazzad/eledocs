<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;

abstract class Parent_Child_Grid extends Widget_Base {

	protected function _register_controls() {
		$this->_settings_controls();
		#$this->_parent_controls();

		$this->_parents_style_controls();
		$this->_parent_style_controls();
		$this->_parent_title_style_controls();

		$this->_children_style_controls();
		$this->_child_style_controls();
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
			'show_children',
			[
				'label' => $this->get_control_label( 'show_children' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eledocs' ),
				'label_off' => __( 'Hide', 'eledocs' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'children_limit',
			[
				'label' => $this->get_control_label( 'children_limit' ),
				'description' => $this->get_control_description( 'children_limit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 20,
				'condition' => [
		            'show_children' => 'yes'
		        ],
			]
		);

		$this->add_control(
			'show_more_button',
			[
				'label' => __( 'Show More Button?', 'eledocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eledocs' ),
				'label_off' => __( 'Hide', 'eledocs' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
		            'show_children' => 'yes'
		        ]
			]
		);

		$this->add_control(
			'more_button_text',
			[
				'label' => __( 'More Button Text', 'eledocs' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Show Details', 'eledocs' ),
				'label_block' => true,
				'condition' => [
		            'show_more_button' => 'yes'
		        ],
				'conditions' => [
				    'relation' => 'and',
				    'terms' => [
						[
				            'name' => 'show_children',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				        [
				            'name' => 'show_more_button',
				            'operator' => '==',
				            'value' => 'yes'
				        ],
				    ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function _parent_controls() {
		$this->start_controls_section(
			'parents_content',
			[
				'label' => $this->get_control_label( 'parent_singular' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);
		$this->end_controls_section();
	}

	protected function _parents_style_controls() {
		$this->start_controls_section(
			'parents_style',
			[
				'label' => $this->get_control_label( 'parent_plural' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'parents_alignment', [
				'label' 			=> __( 'Column Size', 'eledocs' ),
				'type' 				=> Controls_Manager::SELECT,
				'label_block' 		=> true,
				'default'			=> 'center',
				'options' => [
					'flex-start' => __( 'Start', 'elementor' ),
					'center' => __( 'Center', 'elementor' ),
					'flex-end' => __( 'End', 'elementor' ),
					'space-between' => __( 'Space Between', 'elementor' ),
					'space-around' => __( 'Space Around', 'elementor' ),
					'space-evenly' => __( 'Space Evenly', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .eledocs-parent-children-wrap' => 'justify-content: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'parents_column_gap', [
				'label' 			=> __( 'Column Gap', 'eledocs' ),
				'type' 				=> Controls_Manager::SELECT,
				'label_block' 		=> true,
				'default' 			=> 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'no' => __( 'No Gap', 'elementor' ),
					'narrow' => __( 'Narrow', 'elementor' ),
					'extended' => __( 'Extended', 'elementor' ),
					'wide' => __( 'Wide', 'elementor' ),
					'wider' => __( 'Wider', 'elementor' ),
				]
			]
		);

		$this->add_control(
			'parents_column_size', [
				'label' 			=> __( 'Column Size', 'eledocs' ),
				'type' 				=> Controls_Manager::SELECT,
				'label_block' 		=> true,
				'default'			=> '33',
				'options'			=> [
					'20' => __( 'Five', 'eledocs' ),
					'25' => __( 'Four', 'eledocs' ),
					'33' => __( 'Three', 'eledocs' ),
					'50' => __( 'Two', 'eledocs'),
					'100' => __( 'One', 'eledocs' )
				]
			]
		);

        $this->end_controls_section();
	}
	protected function _parent_style_controls() {
		$this->start_controls_section(
			'parent_style',
			[
				'label' => $this->get_control_label( 'parent_singular' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'parent_border',
				'selector' => '{{WRAPPER}} .eledocs-parent',
				'separator' => 'before',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#ddd'
					]
				]
			]
		);

		$this->add_control(
			'parent_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eledocs-parent' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
		            'unit' => 'px',
		            'top' => 5,
		            'right' => 5,
		            'bottom' => 5,
		            'left' => 5,
		            'isLinked' => 1
		        ]
			]
		);

		$this->add_control(
			'parent_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eledocs-parent' => 'background-color: {{VALUE}};',
				],
				'default' => '#FFF'
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'parent_box_shadow',
				'selector' => '{{WRAPPER}} .eledocs-parent',
			]
		);

		$this->add_responsive_control(
			'parent_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eledocs-parent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'default' => [
		            'unit' => 'px',
		            'top' => 20,
		            'right' => 25,
		            'bottom' => 20,
		            'left' => 25,
		            'isLinked' => false
		        ]
			]
		);

		$this->add_responsive_control(
			'parent_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eledocs-parent' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

        $this->end_controls_section();
	}
	protected function _parent_title_style_controls()	{
		$this->start_controls_section(
			'parent_title_style',
			[
				'label' => $this->get_control_label( 'parent_title' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'parent_title_text_alignment',
			[
				'label' => __( 'Text Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'default' => 'left',
			]
		);

		$this->add_responsive_control(
			'parent_title_min_height', [
				'label' => __( 'Minimum Height', 'eledocs' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .parent-title' => 'min-height: {{SIZE || 0}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'parent_title_tag',
			[
				'label' => __( 'HTML Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h4',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'parent_title_text_typography',
				'label' => __('Typography'),
				'selector' => '{{WRAPPER}} .parent-title',
				'fields_options' => [
				]
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
	protected function _children_style_controls() {
		$this->start_controls_section(
			'childs_style',
			[
				'label' => $this->get_control_label( 'child_plural' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'childs_border',
				'selector' => '{{WRAPPER}} .children',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'childs_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .children' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'childs_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .children' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'childs_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .children' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
					'isLinked' => false
				]
			]
		);

		$this->end_controls_section();
	}
	protected function _child_style_controls() {
		$this->start_controls_section(
			'child_style',
			[
				'label' => $this->get_control_label( 'child_singular' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'child_text_alignment',
			[
				'label' => __( 'Text Alignment', 'elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'default' => 'left',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'child_text_typography',
				'label' => __('Text typography'),
				'selector' => '{{WRAPPER}} .child',
				'fields_options' => [
				]
			]
		);

		$this->add_control(
			'child_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .child, {{WRAPPER}} .child a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'child_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top' => 0,
					'right' => 0,
					'bottom' => 5,
					'left' => 0,
					'isLinked' => false
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        $parents = $this->get_parent_items();

		$this->add_render_attribute(
			'wrapper',
			'class',
			sprintf( 'elementor-container elementor-column-gap-%s eledocs-parent-children-container', $settings[ 'parents_column_gap' ] )
		);

		$this->add_render_attribute(
			'column',
			'class',
			sprintf( 'elementor-column elementor-col-%s', $settings[ 'parents_column_size' ] )
		);

		$this->add_render_attribute(
			'parent',
			'class',
			'eledocs-parent'
		);

		$this->add_render_attribute(
			'parent-title',
			'class',
			sprintf( 'parent-title elementor-align-%s', $settings[ 'parent_title_text_alignment' ] )
		);

		$this->add_render_attribute(
			'children',
			'class',
			'children'
		);

		$this->add_render_attribute(
			'child',
			'class',
			sprintf( 'child elementor-align-%s', $settings[ 'child_text_alignment' ] )
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="elementor-row elementor-widget-wrap eledocs-parent-children-wrap">
			<?php
			foreach ( $parents as $parent ) {
				?>
				<div <?php echo $this->get_render_attribute_string( 'column' ); ?>>
					<div class="elementor-column-wrap elementor-element-populated">
						<div <?php echo $this->get_render_attribute_string( 'parent' ); ?>>
							<<?php echo $settings['parent_title_tag']; ?> <?php echo $this->get_render_attribute_string( 'parent-title' ); ?>>
								<a href="<?php echo get_permalink( $parent->ID ); ?>"><?php echo $parent->post_title; ?></a>
							</<?php echo $settings['parent_title_tag']; ?>>

			                <?php
							if ( $settings['show_children'] ) {
								$childs = $this->get_children_items( $parent->ID, $settings['children_limit'] );
								if ( ! empty( $childs ) ) {
									?>
									<ul <?php echo $this->get_render_attribute_string( 'children' ); ?>>
		                            <?php foreach ( $childs as $child ) { ?>
		                                <li <?php echo $this->get_render_attribute_string( 'child' ); ?>>
											<a href="<?php echo get_permalink( $child->ID ); ?>"><?php echo $child->post_title; ?></a>
										</li>
		                            <?php } ?>
			                        </ul>
									<?php
								}
							}

							if ( $settings['show_more_button'] ) {
								?>
				                <div class="more-button-wrap">
				                    <a href="<?php echo get_permalink( $parent->ID ); ?>"><?php echo $settings['more_button_text']; ?></a>
				                </div>
								<?php
							}
							?>
						</div>
					</div>
	            </div>
	        <?php
			}
			?>
			</div>
		</div>
		<?php
	}

	abstract function get_parent_items();
	abstract function get_children_items( $parent_id, $limit = 20 );
}
