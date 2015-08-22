<?php
/**
 * TickTockThemes Customize Social Icons Control
 *
 * @package Gusto
 */

/**
 * Customize Social Icons Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Social_Icons extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-social-icons';

	/**
	 * @access public
	 * @var string
	 */
	protected $linked = 'social_config';

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

		if ( isset( $args['linked'] ) ) {
			$this->linked = $args['linked'];
		}

		// Register child settings
		foreach ( TTT_Customize_Control_Social_Config::$networks as $network => $label ) {
			$default = ( isset( $args['default'] ) && in_array( $network, $args['default'] ) )
				? 'yes'
				: 'no';

			$manager->add_setting(
				$this->id . '_' . $network, array(
					'default'           => $default,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			if ( false === get_theme_mod( $this->id . '_' . $network, false ) ) {
				set_theme_mod(
					$this->id . '_' . $network,
					( isset( $args['default'] ) && in_array( $network, $args['default'] ) )
						? 'yes'
						: 'no'
				);
			}
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-social-icons-' . $this->id;

		// Print styles
		if ( ! defined( 'TTT_Customize_Control_Social_Icons_Loaded' ) ) :
		?>
		<style type="text/css">
			.ttt-social-icons-control div[data-network] {
				display: none;
			}
			.ttt-social-icons-control div[data-network].configured {
				display: block;
			}
		</style>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					$('.ttt-social-icons-control input[type="checkbox"]').change(function() {
						$(this).prev('input').val(this.checked ? 'yes' : 'no').trigger('change');
					});

					$('.ttt-social-icons-control > a.button').click(function() {
						var linked = $('#_customize-social-config-' + $(this).attr('data-linked'));

						linked.closest('.accordion-section').find('.accordion-section-title').trigger('click');
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Social_Icons_Loaded', true );

		endif;
		?>
		<div class="ttt-social-icons-control" id="<?php echo esc_attr( $name ); ?>">
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

			foreach ( TTT_Customize_Control_Social_Config::$networks as $network => $label ) :

			// Get social network config
			$config = get_theme_mod( $this->linked . '_' . $network );
			?>
			<div class="ttt-switch-control <?php if ( $config ) echo 'configured'; ?>" data-network="<?php
				echo esc_attr( $network );
			?>">
				<span class="customize-control-title">
					<?php echo esc_html( $label ); ?>
				</span>
				<div class="switch round tiny">
					<input type="hidden" data-customize-setting-link="<?php
						echo esc_attr( $this->id . '_' . $network );
					?>" value="<?php
						echo esc_attr( get_theme_mod( $this->id . '_' . $network ) );
					?>">
					<input type="checkbox" autocomplete="off" id="<?php
						echo esc_attr( $name . '_' . $network );
					?>" <?php
						if ( 'yes' == get_theme_mod( $this->id . '_' . $network ) )
							echo 'checked="checked"';
					?>>
					<label for="<?php echo esc_attr( $name . '_' . $network ); ?>"></label>
				</div>
			</div>
			<?php endforeach; ?>
			<a class="button expand radius success" href="javascript:void(0)"
				data-linked="<?php echo esc_attr( $this->linked ); ?>"
			>
				<?php _e( 'Configure Social Links', 'gusto' ); ?>
			</a>
		</div>
		<?php
	}
}