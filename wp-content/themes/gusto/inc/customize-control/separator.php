<?php
/**
 * Gusto Separator Customize Control
 *
 * @package Gusto
 */

/**
 * Separator Customize Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Separator extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-separator';

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-reset-' . $this->id;
		?>
		<hr class="ttt-separator-control" id="<?php echo esc_attr( $name ); ?>">
		<?php
	}
}