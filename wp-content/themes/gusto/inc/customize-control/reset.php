<?php
/**
 * TickTockThemes Customize Reset Control
 *
 * @package Gusto
 */

/**
 * Customize Reset Control class.
 *
 * @since 1.0
 *
 * @see WP_Customize_Control
 */
class TTT_Customize_Control_Reset extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-reset';

	/**
	 * @access public
	 * @var array
	 */
	public $defaults;

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

		if ( isset( $args['defaults'] ) ) {
			$this->defaults = $args['defaults'];
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( ! isset( $this->defaults ) ) {
			return;
		}

		$name = '_customize-reset-' . $this->id;
		?>
		<a id="<?php echo esc_attr( $name ); ?>" class="button expand radius warning" href="javascript:void(0)">
			<?php
			if ( ! empty( $this->label ) )
				echo esc_html( $this->label );
			else
				_e( 'Reset to default', 'gusto' );
			?>
		</a>
		<script type="text/javascript">
			(function($) {
				var defaults = <?php echo json_encode( $this->defaults ); ?>;

				$('#<?php echo esc_attr( $name ); ?>').click(function(event) {
					event.preventDefault();

					if (confirm('<?php _e( 'Are you sure you want to reset these settings to default?', 'gusto' ); ?>')) {
						for (var i in defaults) {
							$('#customize-control-' + i).find(defaults[i].input).val(defaults[i].value).trigger('change');
						}
					}
				});
			})(jQuery);
		</script>
		<?php
	}
}