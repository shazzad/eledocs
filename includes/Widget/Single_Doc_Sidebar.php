<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;
use \WeDevs\WeDocs\Walker;

class Single_Doc_Sidebar extends Widget_Base {

	public function get_name() {
		return 'wdei-single-doc-sidebar';
	}

	public function get_title() {
		return __( 'Single Doc Sidebar', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'sidebar' ];
	}

	protected function render() {
		global $post;

		$this->add_render_attribute(
			'wrapper',
			'class',
			'wdei-single-doc-sidebar-container'
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
