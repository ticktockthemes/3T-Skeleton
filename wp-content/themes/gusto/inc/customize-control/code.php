<?php
/**
 * Gusto Code Customize Control
 *
 * @package Gusto
 */

/**
 * Code Customize Control class.
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
	}

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function enqueue() {
		// Load CodeMirror library
		wp_enqueue_style( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.css', array(), '5.4' );
		wp_enqueue_script( 'codemirror', get_template_directory_uri() . '/assets/codemirror/lib/codemirror.js', array( 'jquery' ), '5.4', true );

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
						$('#<?php echo esc_attr( $name ); ?> .codemirror').click(function() {
							var ThisCodeMirror;
							ThisCodeMirror = CodeMirror(
								function(elt) {
									$('#<?php echo esc_attr( $name ); ?> .codemirror').replaceWith($(elt).on('change', function() {
										var textarea = $('#<?php echo esc_attr( $name ); ?> textarea'), content = ThisCodeMirror.getValue();

										if (textarea.val() != content) {
											textarea.val(content).trigger('change');
										}
									}));

									$(elt).find('.CodeMirror-scroll').trigger('click');
								},
								{
									mode: '<?php echo esc_js( $this->language ); ?>',
									autofocus: true,
									value: $('#<?php echo esc_attr( $name ); ?> .codemirror').val(),
								}
							);
						});
					});
				})(jQuery);
			</script>
		</div>
		<?php
	}
}