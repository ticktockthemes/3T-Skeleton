<?php
/**
 * TickTockThemes Customize Social Config Control
 *
 * @package Gusto
 */

/**
 * Customize Social Config Control class.
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
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-social-config-' . $this->id;
		?>
		<div class="ttt-social-config-control" id="<?php echo esc_attr( $name ); ?>">
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
		</div>
		<?php
	}
}