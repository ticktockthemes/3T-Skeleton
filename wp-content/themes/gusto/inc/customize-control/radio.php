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
	 * @access protected
	 * @var string
	 */
	protected $style = 'button';

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

		if ( isset( $args['style'] ) ) {
			$this->style = $args['style'];
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

		// Generate control ID
		$name = '_customize-radio-' . $this->id;

		// Print scripts
		if ( ! defined( 'TTT_Customize_Control_Radio_Loaded' ) ) :
		?>
		<style type="text/css">
			.ttt-radio-image .panel {
				text-align: center;
			}
			.ttt-radio-image .panel input, .ttt-radio-control .button-group input {
				display: none;
			}
		</style>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					// Handle radio image control
					$('.ttt-radio-image label').click(function() {
						$(this).parent().children().removeClass('callout');
						$(this).addClass('callout');
					});

					// Handle radio button control
					$('.ttt-radio-button label').click(function() {
						$(this).parent().children().removeClass('active');
						$(this).addClass('active');
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Radio_Loaded', true );

		endif;
		?>
		<div class="ttt-radio-control" id="<?php echo esc_attr( $name ); ?>">
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
			<?php
			endif;

			if ( 'switch' == $this->style ) :
			?>
			<div class="ttt-radio-switch">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<div class="row">
					<div class="small-4 columns">
						<div class="switch round small">
							<input type="radio" autocomplete="off"
								id="<?php echo esc_attr( $name . ++$i ); ?>"
								name="<?php echo esc_attr( $name ); ?>"
								value="<?php echo esc_attr( $value ); ?>"
								<?php $this->link(); checked( $this->value(), $value ); ?>
							>
							<label for="<?php echo esc_attr( $name . $i ); ?>"></label>
						</div>
					</div>
					<div class="small-8 columns">
						<?php echo esc_html( $label ); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php elseif ( 'image' == $this->style ) : ?>
			<div class="ttt-radio-image">
				<?php $i = 0; foreach ( $this->choices as $value => $data ) : ?>
				<label for="<?php echo esc_attr( $name . ++$i ); ?>" class="panel radius <?php
					if ( $this->value() == $value )
						echo 'callout';
				?>">
					<input type="radio" autocomplete="off"
						id="<?php echo esc_attr( $name . $i ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php $this->link(); checked( $this->value(), $value ); ?>
					>
					<?php echo esc_html( $data['label'] ); ?>
					<br>
					<img src="<?php echo esc_url( $data['image'] ); ?>">
				</label>
				<?php endforeach; ?>
			</div>
			<?php else : ?>
			<div class="ttt-radio-button stack-for-small round secondary button-group">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<label class="button <?php
					if ( $this->value() == $value )
						echo 'active';
				?>">
					<input type="radio" autocomplete="off"
						id="<?php echo esc_attr( $name . ++$i ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php $this->link(); checked( $this->value(), $value ); ?>
					>
					<?php echo esc_html( $label ); ?>
				</label>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}
}