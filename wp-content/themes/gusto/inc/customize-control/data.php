<?php
/**
 * TickTockThemes Customize Data Control
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
class TTT_Customize_Control_Data extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'ttt-data';

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
		$name = '_customize-data-' . $this->id;

		// Print scripts
		if ( ! defined( 'TTT_Customize_Control_Data_Loaded' ) ) :
		?>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					// Handle backup settings action
					$('a.backup-settings').click(function(event) {
						setTimeout(function() {
							$(event.target).next('.alert-box').show();
						}, 1000);
					});

					// Setup restore settings action
					var form = $('<form>')
						.attr('action', '<?php
							echo '' . admin_url( 'admin-ajax.php?action=gusto_manipulate_data&task=restore_settings' );
						?>')
						.attr('method', 'post')
						.attr('enctype', 'multipart/form-data')
						.attr('target', 'upload_backup_file')
						.append($('#select_backup_file'))
						.appendTo(document.body);

					$('a.restore-settings').click(function() {
						$('#select_backup_file').trigger('click').off('change').on('change', function() {
							$('#upload_backup_file').off('load').on('load', function() {
								alert($(this).contents().find('body').text());
							});

							form.submit();
						});
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Data_Loaded', true );

		endif;
		?>
		<div class="ttt-data-control" id="<?php echo esc_attr( $name ); ?>">
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
			<a class="backup-settings button expand radius success" href="<?php
				echo esc_url( admin_url( 'admin-ajax.php?action=gusto_manipulate_data&task=backup_settings' ) );
			?>">
				<?php _e( 'Backup Theme Settings', 'gusto' ); ?>
			</a>
			<div class="alert-box success radius" style="display: none;">
				<?php _e( 'Well done! Your backup file has been downloaded. Keep it safe!', 'gusto' ); ?>
			</div>
			<a class="restore-settings button expand radius info" href="javascript:void(0)">
				<?php _e( 'Restore Theme Settings', 'gusto' ); ?>
			</a>
			<div class="alert-box warning radius">
				<?php _e( 'Be noticed! Restoration will overwrite all of your current theme settings, you&#39;ve been warned.', 'gusto' ); ?>
				<input id="select_backup_file" type="file" name="backup_file" style="display: none;">
				<iframe
					id="upload_backup_file" name="upload_backup_file"
					src="about:blank" style="display: none;"
				></iframe>
			</div>
			<hr>
			<a class="install-sample-data button expand radius warning" href="javascript:void(0)">
				<?php _e( 'Install Sample Data', 'gusto' ); ?>
			</a>
			<div class="alert-box alert radius">
				<?php _e( 'Be noticed! Installing sample data will destroy all of your current data (both web content and back-end settings).', 'gusto' ); ?>
			</div>
		</div>
		<?php
	}
}