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
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		// Load social config customize control script.
		wp_enqueue_script( 'ttt-social-config-control', get_template_directory_uri() . '/js/customize-control/social-config.js' );

		// Pass supported social networks to Javascript.
		wp_localize_script( 'ttt-social-config-control', 'ttt_supported_social_networks', self::$networks );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return  void
	 */
	public function to_json() {
		parent::to_json();

		// Pass current value to the Javascript object as well.
		$this->json['value'] = $this->value();
	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 *
	 * @return  void
	 */
	public function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @return  void
	 */
	protected function content_template() {
		?>
		<div class="{{{ data.type }}}" id="{{{ data.type + '-' + data.settings.default }}}">
			<# if (data.label) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<# for (var i in ttt_supported_social_networks) { #>
			<div>
				<label for="{{{ data.settings.default + '-' + i }}}">
					{{{ ttt_supported_social_networks[i] }}}
				</label>
				<# var value = (data.value && data.value[i]) ? data.value[i] : ''; #>
				<input type="text" id="{{{ data.settings.default + '-' + i }}}" name="{{{ i }}}" value="{{{ value }}}">
			</div>
			<# } #>
		</div>
		<# new jQuery.TTT_Social_Config_Control(data); #>
		<?php
	}
}