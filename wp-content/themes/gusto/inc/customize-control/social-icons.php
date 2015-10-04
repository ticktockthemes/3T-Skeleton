<?php
/**
 * Gusto Social Icons Customize Control
 *
 * @package Gusto
 */

/**
 * Social Icons Customize Control class.
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
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		// Load social icons customize control script.
		wp_enqueue_script( 'ttt-social-icons-control', get_template_directory_uri() . '/js/customize-control/social-icons.js' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return  void
	 */
	public function to_json() {
		parent::to_json();

		// Pass linked option and current value to the Javascript object as well.
		$this->json['linked'] = $this->linked;
		$this->json['value' ] = $this->value();
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
			<div class="ttt-switch-control" data-network="{{{ i }}}">
				<span class="customize-control-title">{{{ ttt_supported_social_networks[i] }}}</span>
				<div class="switch round tiny">
					<# var checked = (data.value && data.value[i]) ? ' checked="checked"' : ''; #>
					<input type="checkbox" name="{{{ i }}}" id="{{{ data.settings.default + '-' + i }}}"{{{ checked }}}>
					<label for="{{{ data.settings.default + '-' + i }}}"></label>
				</div>
			</div>
			<# } #>
			<a class="button expand radius success" href="javascript:void(0)" data-linked="{{{ data.linked }}}">
				<?php _e( 'Configure Social Links', 'gusto' ); ?>
			</a>
		</div>
		<# new jQuery.TTT_Social_Icons_Control(data); #>
		<?php
	}
}