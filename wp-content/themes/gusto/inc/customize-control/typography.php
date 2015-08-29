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
	protected $spacings = array(
		'0px',
		'0.5px',
		'1px',
		'1.5px',
		'2px',
		'2.5px',
		'3px',
		'-0.5px',
		'-1px',
		'-1.5px',
		'-2px',
		'-2.5px',
		'-3px',
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
	 * @access public
	 * @var array
	 */
	public static $options = array(
		'font_family',
		'font_size',
		'line_height',
		'spacing',
		'font_style',
		'text_transform',
		'subset',
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
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		// Generate control ID
		$name = '_customize-typography-' . $this->id;
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
			<div class="ttt-typography-settings">
				<?php
				foreach ( self::$options as $prop ) :

				// Get current value
				$value = get_theme_mod( $this->id . '_' . $prop );

				switch ( $prop ) :

				case 'font_family' :
				?>
				<select data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>">
					<option value=""><?php _e( 'Font Family', 'gusto' ); ?></option>
					<optgroup label="<?php _e( 'Standard Fonts', 'gusto' ); ?>">
						<?php foreach ( $this->standard_fonts as $option ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <?php
							selected( $value, $option );
						?>><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</optgroup>
					<optgroup label="<?php _e( 'Google Fonts', 'gusto' ); ?>">
						<?php foreach ( $this->google_fonts as $option ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <?php
							selected( $value, $option );
						?>><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</optgroup>
				</select>
				<?php
				break;

				case 'font_size' :
				?>
				<input autocomplete="off" type="number" min="0"
					value="<?php echo esc_attr( $value ); ?>"
					 placeholder="<?php _e( 'Font Size', 'gusto' ); ?>"
					data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>"
				>
				<?php
				break;

				case 'line_height';
				?>
				<input autocomplete="off" type="number" min="0"
					value="<?php echo esc_attr( $value ); ?>"
					 placeholder="<?php _e( 'Line Height', 'gusto' ); ?>"
					data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>"
				>
				<?php
				break;

				case 'spacing';
				?>
				<select data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>">
					<option value=""><?php _e( 'Spacing', 'gusto' ); ?></option>
					<?php foreach ( $this->spacings as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php
						selected( $value, $option );
					?>><?php echo esc_html( $option ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php
				break;

				case 'font_style';
				?>
				<select data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>">
					<option value=""><?php _e( 'Font Style', 'gusto' ); ?></option>
					<?php foreach ( $this->styles as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php
						selected( $value, $option );
					?>><?php echo esc_html( $option ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php
				break;

				case 'text_transform';
				?>
				<select data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>">
					<option value=""><?php _e( 'Text Transform', 'gusto' ); ?></option>
					<?php foreach ( $this->transforms as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php
						selected( $value, $option );
					?>><?php echo esc_html( $option ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php
				break;

				case 'subset';
				?>
				<select data-customize-setting-link="<?php echo esc_attr( $this->id . '_' . $prop ); ?>">
					<option value=""><?php _e( 'Subset', 'gusto' ); ?></option>
					<?php foreach ( $this->subsets as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php
						selected( $value, $option );
					?>><?php echo esc_html( $option ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php
				break;

				endswitch;

				endforeach;
				?>
			</div>
		</div>
		<?php
	}
}