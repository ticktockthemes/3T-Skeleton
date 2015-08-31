<?php
/**
 * TickTockThemes Customize Location Control
 *
 * @package Gusto
 */

/**
 * Customize Location Control class.
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
	}

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function enqueue() {
		wp_enqueue_script( 'ttt-location-control', get_template_directory_uri() . '/js/customize-control/location.js', array( 'backbone' ), '1.0', true );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-location-' . $this->id;

		// Print scripts
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
						<input class="toggle-location" type="checkbox" autocomplete="off" <% if (enable == 'yes') { %>checked="checked" <% } %>>
					</label>
					<input type="hidden" name="enable" value="<%= enable %>">
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
		?>
		<div class="ttt-location-control" id="<?php echo esc_attr( $name ); ?>">
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
			<textarea <?php $this->link(); ?> class="data-storage hidden"><?php
				if ( ! is_string( $value = $this->value() ) )
					$value = htmlentities( json_encode( $value ) );

				echo '' . $value;
			?></textarea>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function() {
						new $.Gusto.LocationBox.ListView({
							el: $('#<?php echo esc_attr( $name ); ?>'),
						});
					});
				})(jQuery);
			</script>
		</div>
		<?php
	}
}