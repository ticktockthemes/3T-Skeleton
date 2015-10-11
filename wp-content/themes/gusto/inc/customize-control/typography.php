<?php
/**
 * Gusto Typography Customize Control
 *
 * @package Gusto
 */

/**
 * Typography Customize Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Typography extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-typography';

	/**
	 * @access public
	 * @var array
	 */
	protected static $standard_fonts = array(
		'Andale Mono',
		'Arial',
		'Arial Black',
		'Comic Sans MS',
		'Courier New',
		'Georgia',
		'Impact',
		'Times New Roman',
		'Trebuchet MS',
		'Verdana and Webdings',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected static $google_fonts = array(
		'Open Sans',
		'Inconsolata',
		'Montserrat',
		'Roboto',
		'Playfair Display',
		'Karla',
		'Source Sans Pro',
		'Lato',
		'Alegreya',
		'Anonymous Pro',
		'Libre Baskerville',
		'Merriweather',
		'Raleway',
		'Lora',
		'Muli',
		'Neuton',
		'Archivo Narrow',
		'Roboto Slab',
		'Domine',
		'Questrial',
		'Signika',
		'Titillium Web',
		'Fjalla One',
		'Bitter',
		'Arvo',
		'Dosis',
		'Chivo',
		'Arimo',
		'Varela Round',
		'Old Standard TT',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected static $styles = array(
		'Regular',
		'Italic',
		'Bold',
		'Underline',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected static $transforms = array(
		'Lowercase',
		'Uppercase',
		'Capitailize',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected static $subsets = array(
		'Latin',
		'Vietnamese',
		'Thailand',
	);

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function enqueue() {
		wp_enqueue_script( 'ttt-typography-control', get_template_directory_uri() . '/js/customize-control/typography.js', array( 'backbone' ), '1.0', true );

		// Pass supported typography settings to Javascript.
		wp_localize_script( 'ttt-typography-control', 'ttt_supported_standard_fonts', self::$standard_fonts );
		wp_localize_script( 'ttt-typography-control', 'ttt_supported_google_fonts', self::$google_fonts );
		wp_localize_script( 'ttt-typography-control', 'ttt_supported_font_styles', self::$styles );
		wp_localize_script( 'ttt-typography-control', 'ttt_supported_text_transforms', self::$transforms );
		wp_localize_script( 'ttt-typography-control', 'ttt_supported_font_subsets', self::$subsets );

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
		if ( ! defined( 'TTT_Customize_Control_Typography_Template_Loaded' ) ) :
		?>
		<script type="text/html" id="ttt-typography-control-template">
			<div class="panel ttt-advanced-panel">
				<div>
					<label>
						<?php _e( 'Font Size', 'gusto' ); ?>
						<input type="number" min="0" name="font_size" value="<%= font_size %>" placeholder="<?php
							_e( 'e.g. 14', 'gusto' );
						?>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Line Height', 'gusto' ); ?>
						<input type="number" min="0" name="line_height" value="<%= line_height %>" placeholder="<?php
							_e( 'e.g. 24', 'gusto' );
						?>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Spacing', 'gusto' ); ?>
						<input type="number" min="0" name="spacing" value="<%= spacing %>" placeholder="<?php
							_e( 'e.g. 2', 'gusto' );
						?>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Font Style', 'gusto' ); ?>
						<select name="font_style">
							<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
							<% var selected; for (var i in ttt_supported_font_styles) { %>
							<% selected = font_style == ttt_supported_font_styles[i] ? 'selected="selected"' : ''; %>
							<option value="<%= ttt_supported_font_styles[i] %>" <%= selected %>>
								<%= ttt_supported_font_styles[i] %>
							</option>
							<% } %>
						</select>
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Text Transform', 'gusto' ); ?>
						<select name="text_transform">
							<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
							<% for (var i in ttt_supported_text_transforms) { %>
							<% selected = text_transform == ttt_supported_text_transforms[i] ? 'selected="selected"' : ''; %>
							<option value="<%= ttt_supported_text_transforms[i] %>" <%= selected %>>
								<%= ttt_supported_text_transforms[i] %>
							</option>
							<% } %>
						</select>
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Subset', 'gusto' ); ?>
						<select name="subset">
							<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
							<% for (var i in ttt_supported_font_subsets) { %>
							<% selected = subset == ttt_supported_font_subsets[i] ? 'selected="selected"' : ''; %>
							<option value="<%= ttt_supported_font_subsets[i] %>" <%= selected %>>
								<%= ttt_supported_font_subsets[i] %>
							</option>
							<% } %>
						</select>
					</label>
				</div>
			</div>
		</script>
		<?php
		define( 'TTT_Customize_Control_Typography_Template_Loaded', true );

		endif;
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return  void
	 */
	public function to_json() {
		parent::to_json();

		// Pass current value to the Javascript object as well.
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
			<span class="customize-control-title clearfix">
				{{{ data.label }}}
				<a class="expand-panel right" href="javascript:void"></a>
			</span>
			<# } #>
			<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<label>
				<select name="font_family">
					<option value=""><?php _e( '- Font Family -', 'gusto' ); ?></option>
					<optgroup label="<?php _e( 'Standard Fonts', 'gusto' ); ?>">
						<# var selected; for (var i in ttt_supported_standard_fonts) { #>
						<# selected = data.value.font_family == ttt_supported_standard_fonts[i] ? 'selected="selected"' : ''; #>
						<option value="{{{ ttt_supported_standard_fonts[i] }}}" {{{ selected }}}>
							{{{ ttt_supported_standard_fonts[i] }}}
						</option>
						<# } #>
					</optgroup>
					<optgroup label="<?php _e( 'Google Fonts', 'gusto' ); ?>">
						<# for (var i in ttt_supported_google_fonts) { #>
						<# selected = data.value.font_family == ttt_supported_google_fonts[i] ? 'selected="selected"' : ''; #>
						<option value="{{{ ttt_supported_google_fonts[i] }}}" {{{ selected }}}>
							{{{ ttt_supported_google_fonts[i] }}}
						</option>
						<# } #>
					</optgroup>
				</select>
			</label>
		</div>
		<# new jQuery.TTT_Typography_Control(data); #>
		<?php
	}
}