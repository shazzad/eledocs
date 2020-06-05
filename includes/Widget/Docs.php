<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;

class Docs extends Widget_Base {

	public function get_name() {
		return 'wdei-docs';
	}

	public function get_title() {
		return __( 'Docs', 'wedocs-elementor-integration' );
	}

	public function get_icon() {
		return 'fa fa-file-alt';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'docs' ];
	}

	protected function _register_controls() {
		$this->_settings_controls();
		#$this->_doc_controls();

		$this->_docs_style_controls();
		$this->_doc_title_style_controls();
		$this->_sections_style_controls();
		$this->_section_style_controls();
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
			'show_sections',
			[
				'label' => __( 'Show Sections?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wedocs-elementor-integration' ),
				'label_off' => __( 'Hide', 'wedocs-elementor-integration' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'section_items_limit',
			[
				'label' => __( 'Sections per Doc?', 'wedocs-elementor-integration' ),
				'description' => __( 'Number of Sections to display per Doc?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 20,
				'condition' => [
		            'show_sections' => 'yes'
		        ],
			]
		);

		$this->add_control(
			'show_more_button',
			[
				'label' => __( 'Show More Button?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wedocs-elementor-integration' ),
				'label_off' => __( 'Hide', 'wedocs-elementor-integration' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
		            'show_sections' => 'yes'
		        ]
			]
		);

		$this->add_control(
			'more_button_text',
			[
				'label' => __( 'More Button Text', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Show Details', 'wedocs-elementor-integration' ),
				'label_block' => true,
				'condition' => [
		            'show_more_button' => 'yes'
		        ],
				'conditions' => [
				    'relation' => 'and',
				    'terms' => [
						[
				            'name' => 'show_sections',
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
	protected function _doc_controls() {
		$this->start_controls_section(
			'docs_content',
			[
				'label' 	=> __('Doc', 'wedocs-elementor-integration'),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);
		$this->end_controls_section();
	}

	protected function _docs_style_controls() {
		$this->start_controls_section(
			'docs_style',
			[
				'label' => __( 'Docs', 'wedocs-elementor-integration' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'docs_alignment', [
				'label' 			=> __( 'Column Size', 'wedocs-elementor-integration' ),
				'type' 				=> Controls_Manager::SELECT,
				'label_block' 		=> true,
				'default'			=> 'center',
				'options' => [
					'flex-start' => __( 'Default', 'elementor' ),
					'center' => __( 'Center', 'elementor' ),
					'flex-end' => __( 'End', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .wdei-docs-wrap' => 'justify-content: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'column_gap', [
				'label' 			=> __( 'Column Gap', 'wedocs-elementor-integration' ),
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
			'column_size', [
				'label' 			=> __( 'Column Size', 'wedocs-elementor-integration' ),
				'type' 				=> Controls_Manager::SELECT,
				'label_block' 		=> true,
				'default'			=> '33',
				'options'			=> [
					'20' => __( 'Five', 'wedocs-elementor-integration' ),
					'25' => __( 'Four', 'wedocs-elementor-integration' ),
					'33' => __( 'Three', 'wedocs-elementor-integration' ),
					'50' => __( 'Two', 'wedocs-elementor-integration'),
					'100' => __( 'One', 'wedocs-elementor-integration' )
				]
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'service_border',
				'selector' => '{{WRAPPER}} .wdei-doc',
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
						'default' => '#333'
					]
				]
			]
		);

		$this->add_control(
			'service_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wdei-doc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
		            'unit' => 'px',
		            'top' => 0,
		            'right' => 0,
		            'bottom' => 0,
		            'left' => 0,
		            'isLinked' => 1
		        ]
			]
		);

		$this->add_control(
			'service_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdei-doc' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'service_box_shadow',
				'selector' => '{{WRAPPER}} .wdei-doc',
			]
		);

		$this->add_responsive_control(
			'service_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wdei-doc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'default' => [
		            'unit' => 'px',
		            'top' => 20,
		            'right' => 20,
		            'bottom' => 20,
		            'left' => 20,
		            'isLinked' => 1
		        ]
			]
		);

        $this->end_controls_section();
	}
	protected function _doc_title_style_controls()	{
		$this->start_controls_section(
			'doc_title_style',
			[
				'label' => __( 'Doc Title', 'wedocs-elementor-integration' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'doc_title_text_alignment',
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
			'doc_title_min_height', [
				'label' => __( 'Minimum Height', 'wedocs-elementor-integration' ),
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
					'{{WRAPPER}} .doc-title' => 'min-height: {{SIZE || 0}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'doc_title_tag',
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
				'name' => 'doc_title_text_typography',
				'label' => __('Typography'),
				'selector' => '{{WRAPPER}} .doc-title',
				'fields_options' => [
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'doc_title_border',
				'selector' => '{{WRAPPER}} .doc-title',
				'separator' => 'before'
			]
		);

        $this->add_control(
			'doc_title_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .doc-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'doc_title_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .doc-title' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'doc_title_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .doc-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'doc_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .doc-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
	}
	protected function _sections_style_controls() {
		$this->start_controls_section(
			'sections_style',
			[
				'label' => __( 'Sections', 'tcmc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'doc_sections_border',
				'selector' => '{{WRAPPER}} .doc-sections',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'doc_sections_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .doc-sections' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'doc_sections_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .doc-sections' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'doc_sections_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .doc-sections' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	protected function _section_style_controls() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Section', 'tcmc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'doc_section_text_alignment',
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
				'name' => 'doc_section_text_typography',
				'label' => __('Text typography'),
				'selector' => '{{WRAPPER}} .doc-section',
				'fields_options' => [
				]
			]
		);

		$this->add_control(
			'doc_section_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .doc-section, {{WRAPPER}} .doc-section a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'doc_section_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .doc-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

	protected function render() {
		$settings = $this->get_settings_for_display();

        $docs = $this->get_docs();

		$this->add_render_attribute(
			'wrapper',
			'class',
			sprintf( 'elementor-container elementor-column-gap-%s wdei-docs-container', $settings[ 'column_gap' ] )
		);

		$this->add_render_attribute(
			'column',
			'class',
			sprintf( 'elementor-column elementor-col-%s', $settings[ 'column_size' ] )
		);

		$this->add_render_attribute(
			'doc',
			'class',
			'wdei-doc'
		);

		$this->add_render_attribute(
			'doc-title',
			'class',
			sprintf( 'doc-title elementor-align-%s', $settings[ 'doc_title_text_alignment' ] )
		);

		$this->add_render_attribute(
			'doc-sections',
			'class',
			'doc-sections'
		);

		$this->add_render_attribute(
			'doc-section',
			'class',
			sprintf( 'doc-section elementor-align-%s', $settings[ 'doc_section_text_alignment' ] )
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="elementor-row elementor-widget-wrap wdei-docs-wrap">
			<?php
			foreach ( $docs as $doc ) {
				?>
				<div <?php echo $this->get_render_attribute_string( 'column' ); ?>>
					<div class="elementor-column-wrap elementor-element-populated">
						<div <?php echo $this->get_render_attribute_string( 'doc' ); ?>>
							<<?php echo $settings['doc_title_tag']; ?> <?php echo $this->get_render_attribute_string( 'doc-title' ); ?>>
								<a href="<?php echo get_permalink( $doc->ID ); ?>"><?php echo $doc->post_title; ?></a>
							</<?php echo $settings['doc_title_tag']; ?>>

			                <?php
							if ( $settings['show_sections'] ) {
								$sections = $this->get_sections( $doc->ID, $settings['section_items_limit'] );
								if ( ! empty( $sections ) ) {
									?>
									<ul <?php echo $this->get_render_attribute_string( 'doc-sections' ); ?>>
		                            <?php foreach ( $sections as $section ) { ?>
		                                <li <?php echo $this->get_render_attribute_string( 'doc-section' ); ?>>
											<a href="<?php echo get_permalink( $section->ID ); ?>"><?php echo $section->post_title; ?></a>
										</li>
		                            <?php } ?>
			                        </ul>
									<?php
								}
							}

							if ( $settings['show_more_button'] ) {
								?>
				                <div class="wedocs-doc-link">
				                    <a href="<?php echo get_permalink( $doc->ID ); ?>"><?php echo $settings['more_button_text']; ?></a>
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

	private function get_docs() {
        $docs_args = [
            'post_type'   => 'docs',
            'parent'      => 0,
            'sort_column' => 'menu_order',
        ];

        return get_pages( $docs_args );
	}
	private function get_sections( $doc_id, $limit = 20 ) {
		return get_children( [
			'post_parent'    => $doc_id,
			'post_type'      => 'docs',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => (int) $limit,
		] );
	}
}
