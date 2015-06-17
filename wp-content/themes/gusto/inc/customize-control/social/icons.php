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
	public $linked = 'social_config';

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
			$default = 'no';

			if ( isset( $args['default'] ) && in_array( $network, $args['default'] ) ) {
				$default = 'yes';
			}

			$manager->add_setting(
				$this->id . '_' . $network, array(
					'default'           => $default,
					'sanitize_callback' => 'sanitize_key',
				)
			);
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

		// Get configured social networks
		$social_networks = get_theme_mod( $this->linked, array() );

		// Print styles
		if ( ! defined( 'TTT_Customize_Control_Social_Icons_Loaded' ) ) :
		?>
		<style type="text/css">
			.ttt-social-icons-control .row {
				display: none;
			}
			.ttt-social-icons-control .row.configured {
				display: block;
			}
		</style>
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
			?>
			<div class="row <?php
				if ( isset( $social_networks[ $network ] ) && ! empty( $social_networks[ $network ] ) )
					echo 'configured';
			?>">
				<div class="small-8 columns">
					<?php echo esc_html( $label ); ?>
				</div>
				<div class="small-4 columns">
					<div class="switch round small">
						<input type="checkbox" autocomplete="off" value="1" id="<?php
							echo esc_attr( $name . '_' . $network );
						?>" data-customize-setting-link="<?php
							echo esc_attr( $this->id . '_' . $network );
						?>" <?php
							if ( get_theme_mod( $this->id . '_' . $network ) || in_array( $network, $this->value() ) )
								echo 'checked="checked"';
						?>>
						<label for="<?php echo esc_attr( $name . '_' . $network ); ?>"></label>
					</div>
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