<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Radio Button custom control.
 */
class TickTock_Customize_Control_Radio_Button extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'radio-button';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Pass choices as well.
		$this->json['choices'] = $this->choices;
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
					<# var first = true; for (var key in data.choices) { #>
					<# if (first) first = false; else { #>
					<div class="or"></div>
					<# } #>
					<button type="button" class="ui button" data-value="{{{ key }}}">{{{ data.choices[key] }}}</button>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}
