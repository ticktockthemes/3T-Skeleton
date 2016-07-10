<?php
/**
 * 3T Skeleton Theme Customize Controls.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to create Social Links custom control.
 */
class TickTock_Customize_Control_Social_Links extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'social-links';

	/**
	 * Define social networks list.
	 *
	 * @var array
	 */
	public $choices = array(
		'Facebook',
		'Twitter',
		'Youtube',
		'Google +',
		'RSS',
		'Behance',
		'Dribble',
		'Flickr',
		'Instagram',
		'LinkedIn',
		'Pinterest',
		'Tumblr',
		'Vimeo',
	);

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct( $manager, $id, $args ) {
		parent::__construct( $manager, $id, $args );

		// Register action to print the panel containing social networks list for selection.
		add_action( 'customize_controls_print_footer_scripts', array( &$this, 'print_sub_panel' ) );
	}

	/**
	 * Print the panel containing social networks list for selection.
	 *
	 * @return  void
	 */
	public function print_sub_panel() {
		if ( ! defined( 'TickTock_Customize_Control_Social_Links_Printed_Sub_Panel' ) ) {
			?>
			<<style type="text/css">
			<!--
			#customize-theme-controls .add-new-social-link {
				cursor: pointer;
				float: right;
				margin-left: 10px;
				-webkit-transition: all .2s;
				transition: all .2s;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				outline: 0;
			}
			.add-new-social-link:before {
				content: "\f132";
				display: inline-block;
				position: relative;
				left: -2px;
				top: -1px;
				font: 400 20px/1 dashicons;
				vertical-align: middle;
				-webkit-transition: all .2s;
				transition: all .2s;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
			body.adding-social-link .add-new-social-link, body.adding-social-link .add-new-social-link:hover {
				background: #eee;
				border-color: #929793;
				color: #32373c;
				-webkit-box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
				box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
			}
			body.adding-social-link .add-new-social-link:before {
				-webkit-transform: rotate(45deg);
				-ms-transform: rotate(45deg);
				transform: rotate(45deg);
			}
			#available-social-links {
				position: absolute;
				top: 0;
				bottom: 0;
				left: -301px;
				visibility: hidden;
				overflow-x: hidden;
				overflow-y: auto;
				width: 300px;
				margin: 0;
				z-index: 4;
				background: #eee;
				-webkit-transition: left .18s;
				transition: left .18s;
				border-right: 1px solid #ddd;
			}
			body.adding-social-link #available-social-links {
				left: 0;
				visibility: visible;
			}
			#available-social-links-title {
				padding: 13px 15px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				position: fixed;
				top: 0;
				z-index: 1;
				width: 300px;
				background: #eee;
				border-bottom: 1px solid #e5e5e5;
			}
			#available-social-links-list {
				top: 46px;
				position: absolute;
				overflow: auto;
				bottom: 0;
				width: 100%;
			}
			#available-social-links-list .ui.items .item {
				padding: 20px 15px;
				background: #fff;
				border-bottom: 1px solid #e5e5e5;
				cursor: pointer;
				margin: 0;
			}
			#available-social-links-list .ui.items .item:hover {
				background: #eee;
				border-bottom-color: #ccc;
			}
			-->
			</style>
			<div id="social-links-left">
				<div id="available-social-links">
					<div id="available-social-links-title">
						<?php _e( 'Add more social links', 'ticktock' ); ?>
					</div>
					<div id="available-social-links-list">
						<div class="ui items">
							<?php foreach ( $this->choices as $available_social_link ): ?>
							<div class="item" data-id="<?php esc_attr_e( $available_social_link ); ?>">
								<div class="content">
									<a class="header">
										<?php esc_html_e( $available_social_link ); ?>
									</a>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<?php
			define( 'TickTock_Customize_Control_Social_Links_Printed_Sub_Panel', 1 );
		}
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<div class="ui form {{{ data.type }}}" id="{{{ data.settings.default }}}">
			<button type="button" class="button-secondary add-new-social-link" aria-expanded="true" aria-controls="available-social-links">
				<?php _e( 'Add a Social Link', 'ticktock' ); ?>
			</button>
			<button type="button" class="button-link reorder-toggle" aria-label="Reorder social links" style="display: block;">
				<span class="reorder"><?php _e( 'Reorder', 'ticktock' ); ?></span>
				<span class="reorder-done"><?php _e( 'Done', 'ticktock' ); ?></span>
			</button>
		</div>
		<?php
	}
}
