<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Dropdown Select custom control.
 */
class TickTock_Customize_Control_Dropdown_Select extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'dropdown-select';

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
			<div class="field">
				<# if (data.label) { #>
				<label>{{{ data.label }}}</label>
				<# } #>
				<select class="ui dropdown" name="{{{ data.settings.default }}}">
					<# for (var key in data.choices) { #>
					<option value="{{{ key }}}">{{{ data.choices[key] }}}</option>
					<# } #>
				</div>
			</select>
		</div>
		<?php
	}
}
