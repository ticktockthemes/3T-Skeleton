<?php
/**
 * Gusto Location Customize Control
 *
 * @package Gusto
 */

/**
 * Location Customize Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Location extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-location';

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function enqueue() {
		wp_enqueue_script( 'ttt-location-control', get_template_directory_uri() . '/js/customize-control/location.js', array( 'backbone' ), '1.0', true );

		// Register action to print necessary templates for rendering location box list view.
		add_action( 'customize_controls_print_footer_scripts', array( &$this, 'additional_content_template' ) );
	}

	/**
	 * Print necessary templates for rendering location box list view.
	 *
	 * @return  void
	 */
	public function additional_content_template() {
		// Print HTML template.
		if ( ! defined( 'TTT_Customize_Control_Location_Template_Loaded' ) ) :
		?>
		<script type="text/html" id="ttt-location-control-template">
			<div class="panel">
				<h5 class="clearfix">
					<?php _e( 'Location box <%= index %>', 'gusto' ); ?>
					<a class="remove-location right" href="javascript:void(0)">x</a>
				</h5>
				<div>
					<label>
						<?php _e( 'Enable', 'gusto' ); ?>
						<input class="toggle-location" type="checkbox" <% if (enable) { %>checked="checked" <% } %>>
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Latitude', 'gusto' ); ?>
						<input class="input-text" type="text" name="latitude" value="<%= latitude %>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Longitude', 'gusto' ); ?>
						<input class="input-text" type="text" name="longitude" value="<%= longitude %>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Info box content', 'gusto' ); ?>
						<textarea class="input-text" name="content"><%= content %></textarea>
					</label>
				</div>
			</div>
		</script>
		<?php
		define( 'TTT_Customize_Control_Location_Template_Loaded', true );

		endif;
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return  void
	 */
	public function to_json() {
		parent::to_json();

		// Pass language and current value to the Javascript object as well.
		$this->json['value'] = is_array( $this->value() ) ? $this->value() : array();
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
			<div class="location-boxes"></div>
			<a class="add-location button expand radius success" href="javascript:void(0)">
				<?php
				if ( ! empty( $this->label ) ) :
					echo esc_html( $this->label );
				else :
					if ( isset( $locations ) && isset( $locations['enable'] ) && count( $locations['enable'] ) )
						_e( 'Add more location box', 'gusto' );
					else
						_e( 'Add location box', 'gusto' );
				endif;
				?>
			</a>
		</div>
		<# new jQuery.TTT_Location_Control(data); #>
		<?php
	}
}