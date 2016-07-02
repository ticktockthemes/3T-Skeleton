<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Button custom control.
 */
class TickTock_Customize_Control_Button extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'button';

	/**
	 * onClick event handler.
	 *
	 * @var string
	 */
	public $onclick = '';

	/**
	 * Button style variation.
	 *
	 * @var string
	 */
	public $variation = '';

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct( $manager, $id, $args ) {
		parent::__construct( $manager, $id, $args );

		if ( isset( $args['onclick'] ) ) {
			$this->onclick = $args['onclick'];
		}

		if ( isset( $args['variation'] ) ) {
			$this->variation = $args['variation'];
		}
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Pass onCLick event handler and button variation as well.
		$this->json['onclick'  ] = $this->onclick;
		$this->json['variation'] = $this->variation;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<div class="fluid ui {{{ data.variation }}} button {{{ data.type }}}" id="{{{ data.settings.default }}}" onclick="{{{ data.onclick }}}">
			{{{ data.label }}}
		</div>
		<?php
	}
}
