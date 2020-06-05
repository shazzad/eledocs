<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;

class Single_Doc_Childrens extends Widget_Base {

	public function get_name() {
		return 'wdei-single-doc-childrens';
	}

	public function get_title() {
		return __( 'Single Doc Childrens', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-product-pages';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'childrens' ];
	}

	protected function render() {
		global $post;

		$this->add_render_attribute(
			'wrapper',
			'class',
			'wdei-single-doc-childrens-container'
		);

		$children = wp_list_pages( 'title_li=&order=menu_order&parent=' . $post->ID . '&echo=0&post_type=' . $post->post_type );

		if ( $children ) {
			?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="article-child well">
					<ul>
						<?php echo $children; ?>
					</ul>
				</div>
			</div>
			<?php
		}
	}
}
