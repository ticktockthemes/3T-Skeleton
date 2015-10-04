<?php
/**
 * Gusto Code Editor Customize Control
 *
 * @package Gusto
 */

/**
 * Code Editor Customize Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Code_Editor extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-code-editor';

	/**
	 * @access protected
	 * @var string
	 */
	protected $language = 'xml';

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

		if ( isset( $args['language'] ) ) {
			$this->language = $args['language'];
		}
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	function enqueue() {
		// Load CodeMirror library
		wp_enqueue_style( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.css', array(), '5.4' );
		wp_enqueue_script( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.js', array( 'jquery' ), '5.4', true );

		// Load language specific library
		wp_enqueue_script( "codemirror_{$this->language}", get_template_directory_uri() . "/assets/codemirror/mode/{$this->language}/{$this->language}.js", array( 'jquery' ), '5.4', true );

		// Load code editor customize control script.
		wp_enqueue_script( 'ttt-code-editor-control', get_template_directory_uri() . '/js/customize-control/code-editor.js' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return  void
	 */
	public function to_json() {
		parent::to_json();

		// Pass language and current value to the Javascript object as well.
		$this->json['language'] = $this->language;
		$this->json['value'   ] = $this->value();
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
			<textarea class="codemirror">{{{ data.value }}}</textarea>
		</div>
		<# new jQuery.TTT_Code_Editor_Control(data); #>
		<?php
	}
}