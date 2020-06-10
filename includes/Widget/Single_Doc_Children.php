<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;

class Single_Doc_Children extends Widget_Base {

	public function get_name() {
		return 'eledocs-single-doc-children';
	}

	public function get_title() {
		return __( 'Single Doc Children', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-product-pages';
	}

	public function get_categories() {
		return [ 'eledocs' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'eledocs', 'children' ];
	}

	protected function render() {
		global $post;

		$this->add_render_attribute(
			'wrapper',
			'class',
			'eledocs-single-doc-children-container'
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
