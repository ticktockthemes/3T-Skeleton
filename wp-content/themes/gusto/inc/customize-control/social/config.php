<?php
/**
 * Gusto Social Config Customize Control
 *
 * @package Gusto
 */

/**
 * Social Config Customize Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Social_Config extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-social-config';

	/**
	 * @access public
	 * @var array
	 */
	public static $networks = array(
		'facebook'  => 'Facebook',
		'twitter'   => 'Twitter',
		'google+'   => 'Google +',
		'vimeo'     => 'Vimeo',
		'dribbble'  => 'Dribbble',
		'youtube'   => 'Youtube',
		'pinterest' => 'Pinterest',
		'tumblr'    => 'Tumblr',
		'linkedin'  => 'LinkedIn',
		'behance'   => 'Behance',
		'flickr'    => 'Flickr',
		'instagram' => 'Instagram',
		'skype'     => 'Skype',
		'email'     => 'Email',
		'rss'       => 'RSS',
	);

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

		// Register child settings
		foreach ( self::$networks as $network => $label ) {
			$default = ( isset( $args['default'] ) && isset( $args['default'][ $network ] ) )
				? $args['default'][ $network ]
				: '';

			$manager->add_setting(
				$this->id . '_' . $network, array(
					'default'           => $default,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			if ( false === get_theme_mod( $this->id . '_' . $network, false ) ) {
				set_theme_mod(
					$this->id . '_' . $network,
					( isset( $args['default'] ) && isset( $args['default'][ $network ] ) )
						? $args['default'][ $network ]
						: ''
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
		$name = '_customize-social-config-' . $this->id;

		// Print styles
		if ( ! defined( 'TTT_Customize_Control_Social_Config_Loaded' ) ) :
		?>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					$('.ttt-social-config-control input[type="text"]').change(function() {
						var id = $(this).closest('.ttt-social-config-control').attr('data-link');

						$('[data-linked="' + id + '"]').each($.proxy(function(i, e) {
							var func = $(this).val() != '' ? 'addClass' : 'removeClass',

							elm = $(e)
								.closest('.ttt-social-icons-control')
									.find('[data-network="' + $(this).parent().attr('data-network') + '"]');

							elm[func]('configured');
						}, this));
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Social_Config_Loaded', true );

		endif;
		?>
		<div class="ttt-social-config-control" id="<?php
			echo esc_attr( $name );
		?>" data-link="<?php
			echo esc_attr( $this->id );
		?>">
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

			foreach ( self::$networks as $network => $label ) :
			?>
			<div data-network="<?php echo esc_attr( $network ); ?>">
				<label for="<?php echo esc_attr( $name . '_' . $network ); ?>">
					<?php echo esc_html( $label ); ?>
				</label>
				<input type="text" autocomplete="off" id="<?php
					echo esc_attr( $name . '_' . $network );
				?>" data-customize-setting-link="<?php
					echo esc_attr( $this->id . '_' . $network );
				?>" value="<?php
					echo esc_url( get_theme_mod( $this->id . '_' . $network ) );
				?>">
			</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}