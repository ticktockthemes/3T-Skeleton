<?php
/**
 * TickTockThemes Customize Radio Control
 *
 * @package Gusto
 */

/**
 * Customize Radio Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Radio extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-radio';

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

		if ( isset( $args['choices'] ) ) {
			$this->choices = $args['choices'];
		} else {
			$this->choices = array(
				'on'  => __( 'On', 'gusto' ),
				'off' => __( 'Off', 'gusto' ),
			 );
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		if ( ! empty( $this->label ) ) {
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
		}

		if ( ! empty( $this->description ) ) {
			?>
			<span class="description customize-control-description"><?php echo $this->description ; ?></span>
			<?php
		}
		?>
		<div class="btn-group" data-toggle="buttons">
		<?php
		foreach ( $this->choices as $value => $label ) {
			?>
			<label class="btn btn-primary <?php if ( $this->value() == $value ) echo 'active'; ?>">
				<input autocomplete="off" type="radio" value="<?php
					echo esc_attr( $value );
				?>" name="<?php
					echo esc_attr( $name );
				?>" <?php
					$this->link();
					checked( $this->value(), $value );
				?>>
				<?php echo esc_html( $label ); ?>
			</label>
			<?php
		}
		?>
		</div>
		<?php
	}
}