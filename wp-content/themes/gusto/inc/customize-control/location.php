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
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-location-' . $this->id;

		// Parse location
		parse_str( html_entity_decode( $this->value() ), $locations );

		foreach ( $locations as $k => $v ) {
			$locations[ $k ] = ( array ) $v;
		}

		// Print scripts
		if ( ! defined( 'TTT_Customize_Control_Location_Loaded' ) ) :
		?>
		<script type="text/html" id="ttt-location-control-template">
			<div class="panel">
				<h5 class="clearfix">
					<?php _e( 'Location box %d', 'gusto' ); ?>
					<a class="remove-location" href="javascript:void(0)" style="float: right;">x</a>
				</h5>
				<div>
					<label>
						<?php _e( 'Enable', 'gusto' ); ?>
						<input type="checkbox" autocomplete="off" checked="checked">
					</label>
					<input type="hidden" name="enable[]" value="yes">
				</div>
				<div>
					<label>
						<?php _e( 'Latitude', 'gusto' ); ?>
						<input type="text" name="latitude[]" value="">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Longitude', 'gusto' ); ?>
						<input type="text" name="longitude[]" value="">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Info box content', 'gusto' ); ?>
						<textarea name="content[]"></textarea>
					</label>
				</div>
			</div>
		</script>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					// Define function to update location data
					var update_location_data = function(container) {
						var location_data = container.find('input[name], textarea[name]').serialize();

						// Convert all special characters to HTML entities
						location_data = location_data.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
							return '&#'+i.charCodeAt(0)+';';
						});

						container.find('[data-customize-setting-link]').val(location_data).trigger('change');
					};

					// Setup action to add location box
					$('.ttt-location-control').on('click', '.add-location', function() {
						// Add location box
						var template = $('#ttt-location-control-template').text()
							.replace('%d', $(this).parent().children('.panel').length + 1);

						$(this).before(template);

						// Update location data
						update_location_data($(this).parent());
					});

					// Setup action to remove location box
					$('.ttt-location-control').on('click', '.remove-location', function() {
						if (confirm('<?php _e( 'Are you sure you want to do this?', 'gusto' ); ?>')) {
							var container = $(this).closest('.ttt-location-control');

							// Remove location box
							$(this).closest('.panel').remove();

							// Update location data
							update_location_data(container);
						}
					});

					// Setup action to toggle location box status
					$('.ttt-location-control').on('change', 'input[type="checkbox"]', function() {
						$(this).closest('.panel').find('input[name^="enable"]').val(
							this.checked ? 'yes' : 'no'
						).trigger('change');
					});

					// Track location data changes
					$('.ttt-location-control').on('change', 'input[name], textarea[name]', function() {
						update_location_data($(this).closest('.ttt-location-control'));
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Location_Loaded', true );

		endif;
		?>
		<div class="ttt-location-control" id="<?php echo esc_attr( $name ); ?>">
			<?php
			if ( isset( $locations ) && isset( $locations['enable'] ) && count( $locations['enable'] ) ) :

			foreach ( $locations['enable'] as $k => $v ) :
			?>
			<div class="panel">
				<h5 class="clearfix">
					<?php printf( __( 'Location box %d', 'gusto' ), $k + 1 ); ?>
					<a class="remove-location" href="javascript:void(0)" style="float: right;">x</a>
				</h5>
				<div>
					<label>
						<?php _e( 'Enable', 'gusto' ); ?>
						<input type="checkbox" autocomplete="off" <?php checked( $v, 'yes' ); ?>>
					</label>
					<input type="hidden" name="enable[]" value="<?php echo esc_attr( $v ); ?>">
				</div>
				<div>
					<label>
						<?php _e( 'Latitude', 'gusto' ); ?>
						<input type="text" name="latitude[]" value="<?php
							echo esc_attr( $locations['latitude'][ $k ] );
						?>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Longitude', 'gusto' ); ?>
						<input type="text" name="longitude[]" value="<?php
							echo esc_attr( $locations['longitude'][ $k ] );
						?>">
					</label>
				</div>
				<div>
					<label>
						<?php _e( 'Info box content', 'gusto' ); ?>
						<textarea name="content[]"><?php
							echo '' . $locations['content'][ $k ];
						?></textarea>
					</label>
				</div>
			</div>
			<?php
			endforeach;

			endif;
			?>
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
			<textarea <?php $this->link(); ?> style="display: none;"><?php
				echo '' . $this->value();
			?></textarea>
		</div>
		<?php
	}
}