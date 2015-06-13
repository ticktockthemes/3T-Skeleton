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
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		$name = '_customize-typography-' . $this->id;

		// Print styles
		if ( ! defined( 'TTT_Customize_Control_Typography_Loaded' ) ) :
		?>
		<style type="text/css">
			.ttt-typography-control.open {
				position: relative;
			}
			.ttt-typography-control.open table {
				position: absolute;
			}
			.ttt-typography-control th, .ttt-typography-control .advance {
				display: none;
			}
			.ttt-typography-control.open th, .ttt-typography-control.open .advance {
				display: block;
			}
		</style>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					$('.ttt-typography-control > a.button').click(function() {
						$(this).parent().css('height', $(this).parent().height() + 'px').toggleClass('open');
					});
				});
			})(jQuery);
		</script>
		<?php
		define( 'TTT_Customize_Control_Typography_Loaded', true );

		endif;
		?>
		<div id="<?php echo esc_attr( $name ); ?>" class="ttt-typography-control">
			<a class="button expand round success" href="javascript:void(0)"><?php
				if ( ! empty( $this->label ) )
					echo esc_html( $this->label );
				else
					_e( 'Advanced Settings', 'gusto' );
			?></a>
			<table border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th></th>
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
					<?php
					// Get current values
					$values = $this->value();

					if ( ! isset( $this->options ) ) :
					?>
					<tr>
						<td>
							<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
							<?php endif; ?>
						</td>
						<td>
							<select autocomplete="off" name="<?php echo esc_attr( $name ); ?>[font-family]" <?php
								$this->link();

								// Get current value
								$value = isset( $values['font-family'] ) ? $values['font-family'] : '';
							?>>
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
							<input autocomplete="off" type="number" min="0"
								name="<?php echo esc_attr( $name ); ?>[font-size]"
								value="<?php echo esc_attr( isset( $values['font-size'] ) ? $values['font-size'] : '' ); ?>"
								<?php $this->link(); ?>
							>
						</td>
						<td class="advance">
							<input autocomplete="off" type="number" min="0"
								name="<?php echo esc_attr( $name ); ?>[line-height]"
								value="<?php echo esc_attr( isset( $values['line-height'] ) ? $values['line-height'] : '' ); ?>"
								<?php $this->link(); ?>
							>
						</td>
						<td class="advance">
							<select autocomplete="off" name="<?php echo esc_attr( $name ); ?>[spacing]" <?php
								$this->link();

								// Get current value
								$value = isset( $values['spacing'] ) ? $values['spacing'] : '';
							?>>
								<?php foreach ( $this->spacings as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off" name="<?php echo esc_attr( $name ); ?>[font-style]" <?php
								$this->link();

								// Get current value
								$value = isset( $values['font-style'] ) ? $values['font-style'] : '';
							?>>
								<?php foreach ( $this->styles as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off" name="<?php echo esc_attr( $name ); ?>[text-transform]" <?php
								$this->link();

								// Get current value
								$value = isset( $values['text-transform'] ) ? $values['text-transform'] : '';
							?>>
								<?php foreach ( $this->transforms as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off" name="<?php echo esc_attr( $name ); ?>[subset]" <?php
								$this->link();

								// Get current value
								$value = isset( $values['subset'] ) ? $values['subset'] : '';
							?>>
								<?php foreach ( $this->subsets as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
					</tr>
					<?php
					else :

					foreach( $this->options as $setting => $default ) :
					?>
					<tr>
						<td>
							<?php if ( isset( $default['label'] ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $default['label'] ); ?></span>
							<?php endif; ?>
						</td>
						<td>
							<select autocomplete="off"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][font-family]"
								<?php
								$this->link();

								// Get current value
								$value = ( isset( $values[ $setting ] ) && isset( $values[ $setting ]['font-family'] )  )
									? $values[ $setting ]['font-family']
									: ( isset( $default['font-family'] ) ? $default['font-family'] : '' );
								?>
							>
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
							<input autocomplete="off" type="number" min="0"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][font-size]"
								value="<?php
									echo esc_attr(
										( isset( $values[ $setting ] ) && isset( $values[ $setting ]['font-size'] ) )
											? $values[ $setting ]['font-size']
											: ( isset( $default['font-size'] ) ? $default['font-size'] : '' )
									);
								?>"
								<?php $this->link(); ?>
							>
						</td>
						<td class="advance">
							<input autocomplete="off" type="number" min="0"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][line-height]"
								value="<?php
									echo esc_attr(
										( isset( $values[ $setting ] ) && isset( $values[ $setting ]['line-height'] ) )
											? $values[ $setting ]['line-height']
											: ( isset( $default['line-height'] ) ? $default['line-height'] : '' )
									);
								?>"
								<?php $this->link(); ?>
							>
						</td>
						<td class="advance">
							<select autocomplete="off"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][spacing]"
								<?php
								$this->link();

								// Get current value
								$value = ( isset( $values[ $setting ] ) && isset( $values[ $setting ]['spacing'] )  )
									? $values[ $setting ]['spacing']
									: ( isset( $default['spacing'] ) ? $default['spacing'] : '' );
								?>
							>
								<?php foreach ( $this->spacings as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][font-style]"
								<?php
								$this->link();

								// Get current value
								$value = ( isset( $values[ $setting ] ) && isset( $values[ $setting ]['font-style'] )  )
									? $values[ $setting ]['font-style']
									: ( isset( $default['font-style'] ) ? $default['font-style'] : '' );
								?>
							>
								<?php foreach ( $this->styles as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][text-transform]"
								<?php
								$this->link();

								// Get current value
								$value = ( isset( $values[ $setting ] ) && isset( $values[ $setting ]['text-transform'] )  )
									? $values[ $setting ]['text-transform']
									: ( isset( $default['text-transform'] ) ? $default['text-transform'] : '' );
								?>
							>
								<?php foreach ( $this->transforms as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
						<td class="advance">
							<select autocomplete="off"
								name="<?php echo esc_attr( $name ); ?>[<?php echo esc_attr( $setting ); ?>][subset]"
								<?php
								$this->link();

								// Get current value
								$value = ( isset( $values[ $setting ] ) && isset( $values[ $setting ]['subset'] )  )
									? $values[ $setting ]['subset']
									: ( isset( $default['subset'] ) ? $default['subset'] : '' );
								?>
							>
								<?php foreach ( $this->subsets as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php
									selected( $value, $option );
								?>><?php echo esc_html( $option ); ?></option>
								<?php endforeach; ?>
	                    	</select>
						</td>
					</tr>
					<?php
					endforeach;

					endif;
					?>
				</tbody>
			</table>
		</div>
		<?php
	}
}