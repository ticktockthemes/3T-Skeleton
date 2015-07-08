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
	public $standard_fonts = array(
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
	public $google_fonts = array(
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
	public $spacings = array(
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
	public $styles = array(
		'Regular',
		'Italic',
		'Bold',
		'Underline',
	);

	/**
	 * @access public
	 * @var array
	 */
	public $transforms = array(
		'Lowercase',
		'Uppercase',
		'Capitailize',
	);

	/**
	 * @access public
	 * @var array
	 */
	public $subsets = array(
		'Latin',
		'Vietnamese',
		'Thailand',
	);

	/**
	 * @access public
	 * @var array
	 */
	public $options;

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

		if ( isset( $args['options'] ) ) {
			$this->options = $args['options'];
		} else {
			$this->options = array(
				$id => array(
					'label' => isset( $options['label'] ) ? $options['label'] : __( 'Typography', 'gusto' ),
				)
			);
		}

		// Register child settings
		$props = array(
			'font_family',
			'font_size',
			'line_height',
			'spacing',
			'font_style',
			'text_transform',
			'subset',
		);

		foreach ( $this->options as $setting => $default ) {
			foreach ( $props as $prop ) {
				$manager->add_setting(
					$setting . '_' . $prop, array(
						'default'           => isset( $default[ $prop ] ) ? $default[ $prop ] : null,
						'sanitize_callback' => 'sanitize_key',
					)
				);
			}
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

		// Print styles
		if ( ! defined( 'TTT_Customize_Control_Typography_Loaded' ) ) :
		?>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					if ( $('#_customize-switch-custom_font-input').prop('checked') ) {
						$('#customize-control-custom_fonts').show();
					} else {
						$('#customize-control-custom_fonts').hide();
					}

					$('#_customize-switch-custom_font-input').bind('change', function () {
						if ( $(this).prop('checked') ) {
							$('#customize-control-custom_fonts').show();
						} else {
							$('#customize-control-custom_fonts').hide();
						}
					});

					$('.ttt-typography-control > a.button').click(function() {
						$(this).parent().toggleClass('open');
						$('body').toggleClass('advance-expand');
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Typography_Loaded', true );

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
			<a class="button expand radius success" href="javascript:void(0)">
				<?php _e( 'Advanced Settings', 'gusto' ); ?>
			</a>
			<div id="advanced-typography" class="reveal-modal"
				data-reveal
				aria-labelledby="modalTitle"
				aria-hidden="true" role="dialog"
			>
				<h2 id="modalTitle">Awesome. I have it.</h2>
				<p class="lead">Your couch.  It is mine.</p>
				<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
				<a class="close-reveal-modal" aria-label="Close">&#215;</a>
			</div>
			<table>
				<thead>
					<tr>
						<th>
							<a class="close-reveal-modal" aria-label="<?php _e( 'Close', 'gusto' ); ?>">
								&#215;
							</a>
						</th>
						<th><?php _e( 'Font family', 'gusto' ); ?></th>
						<th><?php _e( 'Font size', 'gusto' ); ?></th>
						<th><?php _e( 'Line height', 'gusto' ); ?></th>
						<th><?php _e( 'Spacing', 'gusto' ); ?></th>
						<th><?php _e( 'Font style', 'gusto' ); ?></th>
						<th><?php _e( 'Transform', 'gusto' ); ?></th>
						<th><?php _e( 'Subset', 'gusto' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach( $this->options as $setting => $default ) : ?>
					<tr>
						<td>
							<?php if ( isset( $default['label'] ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $default['label'] ); ?></span>
							<?php endif; ?>
						</td>
						<td>
							<?php
							// Generate setting name
							$prop = $setting . '_font_family';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['font_family'] ) ? $default['font_family'] : null
							);
							?>
							<select data-customize-setting-link="<?php echo esc_attr( $prop ); ?>">
								<option value=""><?php _e( '- Font Family -', 'gusto' ); ?></option>
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
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_font_size';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['font_size'] ) ? $default['font_size'] : null
							);
							?>
							<input autocomplete="off" type="number" min="0" value="<?php echo esc_attr( $value ); ?>"
								data-customize-setting-link="<?php echo esc_attr( $prop ); ?>"
							>
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_line_height';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['line_height'] ) ? $default['line_height'] : null
							);
							?>
							<input autocomplete="off" type="number" min="0" value="<?php echo esc_attr( $value ); ?>"
								data-customize-setting-link="<?php echo esc_attr( $prop ); ?>"
							>
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_spacing';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['spacing'] ) ? $default['spacing'] : null
							);
							?>
							<select data-customize-setting-link="<?php echo esc_attr( $prop ); ?>">
								<?php foreach ( $this->spacings as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_font_style';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['font_style'] ) ? $default['font_style'] : null
							);
							?>
							<select data-customize-setting-link="<?php echo esc_attr( $prop ); ?>">
								<?php foreach ( $this->styles as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_text_transform';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['text_transform'] ) ? $default['text_transform'] : null
							);
							?>
							<select data-customize-setting-link="<?php echo esc_attr( $prop ); ?>">
								<?php foreach ( $this->transforms as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<?php
							// Generate setting name
							$prop = $setting . '_subset';

							// Get current value
							$value = get_theme_mod(
								$prop,
								isset( $default['subset'] ) ? $default['subset'] : null
							);
							?>
							<select data-customize-setting-link="<?php echo esc_attr( $prop ); ?>">
								<?php foreach ( $this->subsets as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}
}