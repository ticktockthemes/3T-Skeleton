<?php
/**
 * TickTockThemes Customize Typography Control
 *
 * @package Gusto
 */

/**
 * Customize Typography Control class.
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
	protected $standard_fonts = array(
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
	protected $google_fonts = array(
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
	protected $styles = array(
		'Regular',
		'Italic',
		'Bold',
		'Underline',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected $transforms = array(
		'Lowercase',
		'Uppercase',
		'Capitailize',
	);

	/**
	 * @access public
	 * @var array
	 */
	protected $subsets = array(
		'Latin',
		'Vietnamese',
		'Thailand',
	);

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

		// Add action to load required assets
		add_action( 'customize_controls_enqueue_scripts', array( &$this, 'customize_scripts' ) );
	}

	/**
	 * Load required assets.
	 *
	 * @since 1.0
	 */
	function customize_scripts() {
		if ( ! defined( 'TTT_Customize_Control_Typography_Loaded' ) ) {
			wp_enqueue_script( 'ttt-typography-control', get_template_directory_uri() . '/js/customize-control/typography.js', array( 'backbone' ), '1.0', true );

			define( 'TTT_Customize_Control_Typography_Loaded', true );
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-typography-' . $this->id;

		// Print scripts
		if ( ! defined( 'TTT_Customize_Control_Typography_Template_Loaded' ) ) :
		?>
		<script type="text/html" id="ttt-typography-control-template">
			<label>
				<span class="customize-control-title clearfix">
					<%= type.replace('_', ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) %>
					<a class="expand-panel right" href="javascript:void">&gt;</a>
				</span>
				<select name="<%= type %>[font_family]">
					<option value=""><?php _e( '- Font Family -', 'gusto' ); ?></option>
					<optgroup label="<?php _e( 'Standard Fonts', 'gusto' ); ?>">
						<?php foreach ( $this->standard_fonts as $option ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <% if (font_family == '<?php echo esc_attr( $option ); ?>') { %>selected="selected"<% } %>>
							<?php echo esc_html( $option ); ?>
						</option>
						<?php endforeach; ?>
					</optgroup>
					<optgroup label="<?php _e( 'Google Fonts', 'gusto' ); ?>">
						<?php foreach ( $this->google_fonts as $option ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <% if (font_family == '<?php echo esc_attr( $option ); ?>') { %>selected="selected"<% } %>>
							<?php echo esc_html( $option ); ?>
						</option>
						<?php endforeach; ?>
					</optgroup>
				</select>
				<div class="panel ttt-advanced-panel">
					<h5><%= type.replace('_', ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) %></h5>
					<div>
						<label>
							<?php _e( 'Font Size', 'gusto' ); ?>
							<input type="number" min="0" name="<%= type %>[font_size]" value="<%= font_size %>" placeholder="<?php
								_e( 'e.g. 14', 'gusto' );
							?>">
						</label>
					</div>
					<div>
						<label>
							<?php _e( 'Line Height', 'gusto' ); ?>
							<input type="number" min="0" name="<%= type %>[line_height]" value="<%= line_height %>" placeholder="<?php
								_e( 'e.g. 24', 'gusto' );
							?>">
						</label>
					</div>
					<div>
						<label>
							<?php _e( 'Spacing', 'gusto' ); ?>
							<input type="number" min="0" name="<%= type %>[spacing]" value="<%= spacing %>" placeholder="<?php
								_e( 'e.g. 2', 'gusto' );
							?>">
						</label>
					</div>
					<div>
						<label>
							<?php _e( 'Font Style', 'gusto' ); ?>
							<select name="<%= type %>[font_style]">
								<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
								<?php foreach ( $this->styles as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <% if (font_style == '<?php echo esc_attr( $option ); ?>') { %>selected="selected"<% } %>>
									<?php echo esc_html( $option ); ?>
								</option>
								<?php endforeach; ?>
							</select>
						</label>
					</div>
					<div>
						<label>
							<?php _e( 'Text Transform', 'gusto' ); ?>
							<select name="<%= type %>[text_transform]">
								<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
								<?php foreach ( $this->transforms as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <% if (text_transform == '<?php echo esc_attr( $option ); ?>') { %>selected="selected"<% } %>>
									<?php echo esc_html( $option ); ?>
								</option>
								<?php endforeach; ?>
							</select>
						</label>
					</div>
					<div>
						<label>
							<?php _e( 'Subset', 'gusto' ); ?>
							<select name="<%= type %>[subset]">
								<option value=""><?php _e( '- click to select -', 'gusto' ); ?></option>
								<?php foreach ( $this->subsets as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <% if (subset == '<?php echo esc_attr( $option ); ?>') { %>selected="selected"<% } %>>
									<?php echo esc_html( $option ); ?>
								</option>
								<?php endforeach; ?>
							</select>
						</label>
					</div>
				</div>
			</label>
		</script>
		<?php
		define( 'TTT_Customize_Control_Typography_Template_Loaded', true );

		endif;
		?>
		<div class="ttt-typography-control" id="<?php echo esc_attr( $name ); ?>">
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
			<div class="typography-types"></div>
			<textarea <?php $this->link(); ?> class="data-storage hidden"><?php
				if ( ! is_string( $value = $this->value() ) )
					$value = htmlentities( json_encode( $value ) );

				echo '' . $value;
			?></textarea>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function() {
						new $.Gusto.Typography.ListView({
							el: $('#<?php echo esc_attr( $name ); ?>'),
						});
					});
				})(jQuery);
			</script>
		</div>
		<?php
	}
}