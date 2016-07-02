<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Color Picker custom control.
 */
class TickTock_Customize_Control_Color_Picker extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'color-picker';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'spectrum', get_template_directory_uri() . '/3rd-party/spectrum/spectrum.css' );
		wp_enqueue_script( 'spectrum', get_template_directory_uri() . '/3rd-party/spectrum/spectrum.js', array( 'jquery' ), '1.8.0', true );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<div class="ui form {{{ data.type }}}" id="{{{ data.settings.default }}}">
			<div class="inline field">
				<# if (data.label) { #>
				<label>{{{ data.label }}}</label>
				<# } #>
				<div class="ui buttons">
					<input type="text" name="{{{ data.settings.default }}}">
				</div>
			</div>
		</div>
		<?php
	}
}
