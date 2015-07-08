<?php
/**
 * TickTockThemes Customize Code Control
 *
 * @package Gusto
 */

/**
 * Customize Code Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Code extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-code';

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

		// Add action to load required assets
		add_action( 'customize_controls_enqueue_scripts', array( &$this, 'customize_scripts' ) );
	}

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function customize_scripts() {
		// Load CodeMirror library
		if ( ! defined( 'TTT_Customize_Control_Code_Loaded' ) ) {
			wp_enqueue_style( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.css', array(), '5.4' );
			wp_enqueue_script( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.js', array( 'jquery' ), '5.4', true );

			define( 'TTT_Customize_Control_Code_Loaded', true );
		}

		// Load language specific library
		wp_enqueue_script( "codemirror_{$this->language}", get_template_directory_uri() . "/assets/codemirror/mode/{$this->language}/{$this->language}.js", array( 'jquery' ), '5.4', true );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-code-' . $this->id;
		?>
		<div class="ttt-code-control" id="<?php echo esc_attr( $name ); ?>">
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
			<textarea class="codemirror"><?php
				echo '' . $this->value();
			?></textarea>
			<textarea <?php $this->link(); ?> style="display: none;"><?php
				echo '' . $this->value();
			?></textarea>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function() {
						var ThisCodeMirror = CodeMirror(
							function(elt) {
								$('#<?php echo esc_attr( $name ); ?> .codemirror').replaceWith(elt);
							},
							{
								mode: 'css',
							}
						);
					});
				})(jQuery);
			</script>
		</div>
		<?php
	}
}