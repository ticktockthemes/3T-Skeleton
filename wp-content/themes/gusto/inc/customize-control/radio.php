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

		$name = '_customize-radio-' . $this->id;

		// Print scripts
		if ( ! defined( 'TTT_Customize_Control_Radio_Loaded' ) ) :
		?>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					$('.ttt-radio-control .button-group li a label').click(function() {
						$(this).closest('.button-group').find('li').removeClass('active');
						$(this).closest('.button-group').find('label').removeClass('lower-z');
						if ( $(this).closest('.button-group').find('input:checked') ) {
							$(this).closest('li').addClass('active');
							$(this).addClass('lower-z');
						} else {
							$(this).removeClass('lower-z');
						}
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Radio_Loaded', true );

		endif;
		?>
		<div id="<?php echo esc_attr( $name ); ?>" class="ttt-radio-control">
			<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			endif;

			if ( ! empty( $this->description ) ) :
			?>
			<span class="description customize-control-description"><?php echo $this->description ; ?></span>
			<?php
			endif;

			if ( 'button' == $this->style ) :
			?>
			<ul class="radio-switch radius button-group">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<li class="<?php
					if ( $this->value() == $value )
						echo 'active';
				?>"><a href="javascript:void(0);" class="button">
					<input type="radio" autocomplete="off" style="display: none;"
						id="<?php echo esc_attr( $name . ++$i ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php $this->link(); checked( $this->value(), $value ); ?>
					>
					<label data-content="<?php echo esc_html( $label ); ?>" for="<?php echo esc_attr( $name . $i ); ?>"></label>
				</a></li>
				<?php endforeach; ?>
				<div class="switch-pad"></div>
			</ul>
			<?php else : ?>
			<div class="ttt-radio-switch">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<div class="row">
					<div class="small-4 columns">
						<div class="switch radius tiny">
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
			<?php endif; ?>
		</div>
		<?php
	}
}