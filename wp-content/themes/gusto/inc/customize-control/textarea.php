<?php
/**
 * TickTockThemes Customize Textarea Control
 *
 * @package Gusto
 */

/**
 * Customize Textarea Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Textarea extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-textarea';

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

		if ( isset( $args['placeholder'] ) ) {
			$this->placeholder = $args['placeholder'];
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-radio-' . $this->id;
		?>
		<div class="ttt-textarea-control" id="<?php echo esc_attr( $name ); ?>">
			<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<?php
			endif;

			if ( ! empty( $this->description ) ) :
			?>
			<span class="description customize-control-description">
				<?php echo $this->description ; ?>
			</span>
			<?php endif; ?>
			<textarea rows="5" <?php $this->link(); ?>
				<?php
				if ( isset( $this->placeholder ) )
					echo 'placeholder="' . $this->placeholder . '"';
				?>
			><?php echo '' . $this->value(); ?></textarea>
		<?php
	}
}