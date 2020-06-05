<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;

class Sections extends Widget_Base {

	public function get_name() {
		return 'wdei-sections';
	}

	public function get_title() {
		return __( 'Sections', 'wedocs-elementor-integration' );
	}

	public function get_icon() {
		return 'fa fa-file-alt';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'sections' ];
	}

	protected function _register_controls() {
		$this->_settings_controls();
		#$this->_section_controls();

		$this->_sections_style_controls();
		$this->_section_title_style_controls();
		$this->_articles_style_controls();
		$this->_article_style_controls();
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
			'show_articles',
			[
				'label' => __( 'Show Articles?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wedocs-elementor-integration' ),
				'label_off' => __( 'Hide', 'wedocs-elementor-integration' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'article_items_limit',
			[
				'label' => __( 'Articles per Section?', 'wedocs-elementor-integration' ),
				'description' => __( 'Number of Articles to display per Section?', 'wedocs-elementor-integration' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 20,
				'condition' => [
		            'show_articles' => 'yes'
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
		            'show_articles' => 'yes'
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
				            'name' => 'show_articles',
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
	protected function _section_controls() {
		$this->start_controls_section(
			'sections_content',
			[
				'label' 	=> __('Section', 'wedocs-elementor-integration'),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);
		$this->end_controls_section();
	}

	protected function _sections_style_controls() {
		$this->start_controls_section(
			'sections_style',
			[
				'label' => __( 'Sections', 'wedocs-elementor-integration' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sections_alignment', [
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
					'{{WRAPPER}} .wdei-sections-wrap' => 'justify-content: {{VALUE}};',
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
				'name' => 'section_border',
				'selector' => '{{WRAPPER}} .wdei-section',
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
			'section_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wdei-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'section_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdei-section' => 'background-color: {{VALUE}};',
				],
				'default' => '#FFF'
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'section_box_shadow',
				'selector' => '{{WRAPPER}} .wdei-section',
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wdei-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->end_controls_section();
	}
	protected function _section_title_style_controls()	{
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Section Title', 'wedocs-elementor-integration' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_title_text_alignment',
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
			'section_title_min_height', [
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
					'{{WRAPPER}} .section-title' => 'min-height: {{SIZE || 0}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_title_tag',
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
				'name' => 'section_title_text_typography',
				'label' => __('Typography'),
				'selector' => '{{WRAPPER}} .section-title',
				'fields_options' => [
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'section_title_border',
				'selector' => '{{WRAPPER}} .section-title',
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
			'section_title_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'section_title_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-title' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'section_title_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .section-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'section_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	protected function _articles_style_controls() {
		$this->start_controls_section(
			'articles_style',
			[
				'label' => __( 'Articles', 'tcmc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'articles_border',
				'selector' => '{{WRAPPER}} .section-articles',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'articles_background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-articles' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'articles_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .section-articles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'articles_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .section-articles' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	protected function _article_style_controls() {
		$this->start_controls_section(
			'article_style',
			[
				'label' => __( 'Article', 'tcmc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'article_text_alignment',
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
				'name' => 'article_text_typography',
				'label' => __('Text typography'),
				'selector' => '{{WRAPPER}} .section-article',
				'fields_options' => [
				]
			]
		);

		$this->add_control(
			'article_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section-article, {{WRAPPER}} .section-article a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'article_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .section-article' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		global $post;
        $sections = $this->get_sections( $post->ID );

		$this->add_render_attribute(
			'wrapper',
			'class',
			sprintf( 'elementor-container elementor-column-gap-%s wdei-sections-container', $settings[ 'column_gap' ] )
		);

		$this->add_render_attribute(
			'column',
			'class',
			sprintf( 'elementor-column elementor-col-%s', $settings[ 'column_size' ] )
		);

		$this->add_render_attribute(
			'section',
			'class',
			'wdei-section'
		);

		$this->add_render_attribute(
			'section-title',
			'class',
			sprintf( 'section-title elementor-align-%s', $settings[ 'section_title_text_alignment' ] )
		);

		$this->add_render_attribute(
			'section-articles',
			'class',
			'section-articles'
		);

		$this->add_render_attribute(
			'section-article',
			'class',
			sprintf( 'section-article elementor-align-%s', $settings[ 'article_text_alignment' ] )
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="elementor-row elementor-widget-wrap wdei-sections-wrap">
			<?php
			foreach ( $sections as $section ) {
				?>
				<div <?php echo $this->get_render_attribute_string( 'column' ); ?>>
					<div class="elementor-column-wrap elementor-element-populated">
						<div <?php echo $this->get_render_attribute_string( 'section' ); ?>>
							<<?php echo $settings['section_title_tag']; ?> <?php echo $this->get_render_attribute_string( 'section-title' ); ?>>
								<a href="<?php echo get_permalink( $section->ID ); ?>"><?php echo $section->post_title; ?></a>
							</<?php echo $settings['section_title_tag']; ?>>

			                <?php
							if ( $settings['show_articles'] ) {
								$articles = $this->get_articles( $section->ID, $settings['article_items_limit'] );
								if ( ! empty( $articles ) ) {
									?>
									<ul <?php echo $this->get_render_attribute_string( 'section-articles' ); ?>>
		                            <?php foreach ( $articles as $article ) { ?>
		                                <li <?php echo $this->get_render_attribute_string( 'section-article' ); ?>>
											<a href="<?php echo get_permalink( $article->ID ); ?>"><?php echo $article->post_title; ?></a>
										</li>
		                            <?php } ?>
			                        </ul>
									<?php
								}
							}

							if ( $settings['show_more_button'] ) {
								?>
				                <div class="wedocs-section-link">
				                    <a href="<?php echo get_permalink( $section->ID ); ?>"><?php echo $settings['more_button_text']; ?></a>
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

	private function get_sections( $doc_id = 0 ) {
        $sections_args = [
            'post_type'   => 'docs',
            'parent'      => $doc_id,
            'sort_column' => 'menu_order',
        ];

        return get_pages( $sections_args );
	}
	private function get_articles( $section_id, $limit = 20 ) {
		return get_children( [
			'post_parent'    => $section_id,
			'post_type'      => 'docs',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => (int) $limit,
		] );
	}
}
