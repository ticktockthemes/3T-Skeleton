<?php
/**
 * TickTockThemes Customize Switch Control
 *
 * @package Gusto
 */

/**
 * Customize Switch Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Switch extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-switch';

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

		if ( isset( $args['checked_value'] ) ) {
			$this->checked_value = $args['checked_value'];
		} else {
			$this->checked_value = 'on';
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		$name = '_customize-switch-' . $this->id;
		?>
		<div id="<?php echo esc_attr( $name ); ?>" class="ttt-switch-control">
			<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			endif;

			if ( ! empty( $this->description ) ) :
			?>
			<span class="description customize-control-description"><?php echo $this->description ; ?></span>
			<?php endif; ?>
			<div class="switch round small">
				<input type="checkbox" autocomplete="off"
					id="<?php echo esc_attr( $name ); ?>-input"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $this->checked_value ); ?>"
					<?php $this->link(); checked( $this->value(), $this->checked_value ); ?>
				>
				<label for="<?php echo esc_attr( $name ); ?>-input"></label>
			</div>
		</div>
		<?php
	}
}