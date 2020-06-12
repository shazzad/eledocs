<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;

class Children extends Widget_Base {

	public function get_name() {
		return 'eledocs-children';
	}

	public function get_title() {
		return __( 'Children', 'plugin-name' );
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
			'eledocs-children-container'
		);

		$children = wp_list_pages( array(
			'title_li'  => '',
			'order'     => 'menu_order',
			'parent'    => $post->ID,
			'echo'      => 0,
			'post_type' => 'docs'
		) );

		if ( $children ) {
			?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<ul>
					<?php echo $children; ?>
				</ul>
			</div>
			<?php
		}
	}
}
