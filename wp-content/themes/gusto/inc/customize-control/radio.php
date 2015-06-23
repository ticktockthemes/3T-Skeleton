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
	protected $style = '';

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

		if ( isset( $args['span'] ) ) {
			$this->span = $args['span'];
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
				float: left;
				border: 0;
				padding: 0;
				text-align: center;
			}
			.ttt-radio-image .panel input, .ttt-radio-button label input {
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

					// Handle button switch
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

					// Handle radio group
					$('.ttt-radio-group .radio input:checked + label').addClass('active');
					$('.ttt-radio-group .radio input + label').click(function() {
						$(this).closest('.ttt-radio-group').find('label').removeClass('active');
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

			if ( 'radio-group' == $this->style ) :
			// Radio Group
			?>
			<div class="ttt-radio-group panel radius">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<div class="item clearfix">
					<div class="radio-label left">
						<?php echo esc_html( $label ); ?>
					</div>
					<div class="radio right">
						<input type="radio" autocomplete="off"
							id="<?php echo esc_attr( $name . ++$i ); ?>"
							name="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $value ); ?>"
							<?php $this->link(); ?>
							<?php checked( $this->value(), $value ); ?>
						>
						<label for="<?php echo esc_attr( $name . $i ); ?>"></label>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php elseif ( 'image' == $this->style ) :
			// Image Switch
			?>
			<div class="ttt-radio-image clear row">
				<?php
				// Calculate column span
				$span = isset( $this->span ) ? "small-{$this->span}" : 'small-12';

				// Option counter
				$i = 0;

				foreach ( $this->choices as $value => $data ) :
				?>
				<label for="<?php echo esc_attr( $name . ++$i ); ?>" class="panel radius <?php
					echo esc_attr( $span );

					if ( $this->value() == $value )
						echo ' callout';
				?>">
					<input type="radio" autocomplete="off"
						id="<?php echo esc_attr( $name . $i ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value(), $value ); ?>
					>
					<?php
					if ( isset( $data['label'] ) )
						echo esc_html( $data['label'] ) . '<br>';
					?>
					<img src="<?php echo esc_url( $data['image'] ); ?>">
				</label>
				<?php endforeach; ?>
			</div>
			<?php else :
			// Button Switch
			?>
			<ul class="radio-switch radius button-group">
				<?php $i = 0; foreach ( $this->choices as $value => $label ) : ?>
				<li class="<?php
					if ( $this->value() == $value )
						echo 'active';
				?>">
					<a href="javascript:void(0);" class="button">
					<input type="radio" autocomplete="off"
						id="<?php echo esc_attr( $name . ++$i ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value(), $value ); ?>
					style="display: none;">
					<label class="<?php
						if ( $this->value() == $value )
							echo 'lower-z';
					?>" data-content="<?php echo esc_html( $label ); ?>" for="<?php echo esc_attr( $name . $i ); ?>"></label>
					</a>
				</li>
				<?php endforeach; ?>
				<div class="switch-pad"></div>
			</ul>
			<?php endif; ?>
		</div>
		<?php
	}
}