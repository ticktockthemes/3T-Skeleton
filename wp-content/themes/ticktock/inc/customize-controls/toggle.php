<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Toggle custom control.
 */
class TickTock_Customize_Control_Toggle extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'toggle';

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
				<div class="ui toggle checkbox">
					<input type="checkbox" tabindex="0" class="hidden">
				</div>
			</div>
		</div>
		<?php
	}
}
