<?php
namespace EleDocs\Widget;

use \Elementor\Widget_Base;

class Breadcrumbs extends Widget_Base {

	public function get_name() {
		return 'wdei-breadcrumbs';
	}

	public function get_title() {
		return __( 'Docs Breadcrumbs', 'wedocs-elementor-integration' );
	}

	public function get_icon() {
		return 'fa fa-chevron-right';
	}

	public function get_categories() {
		return [ 'wedocs-elementor-integration' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'breadcrumbs' ];
	}

	protected function render() {
		$this->add_render_attribute(
			'wrapper',
			'class',
			'wdei-breadcrumbs-container'
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php wedocs_breadcrumbs(); ?>
		</div>
		<?php
	}
}
