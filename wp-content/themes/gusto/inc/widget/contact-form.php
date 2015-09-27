<?php
/**
 * Gusto Contact Form widget
 *
 * Provides support for embedding contact form created with Contact Form 7 inside a widget.
 *
 * @package Gusto
 */

/**
 * Adds Contact Form widget.
 */
class TTT_Widget_Contact_Form extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ttt_contact_form_widget',
			__( 'Contact Form', 'gusto' ),
			array(
				'description' => __( 'Embed contact form created with Contact Form 7.', 'gusto' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		// Get contact form to embed
		if ( isset( $instance['form'] ) ) {
			$form = get_post( $instance['form'] );

			if ( $form ) {
				echo '' . do_shortcode( '[contact-form-7 id="' . $form->ID . '"]' );
			}
		}

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'gusto' );
		$form  = ! empty( $instance['form' ] ) ? $instance['form' ] : '';

		// Get all available contact forms
		$forms = get_posts( array(
			'post_type'   => 'wpcf7_contact_form',
			'post_status' => 'publish',
		) );

		if ( ! $forms || ! count( $forms ) ) :
		?>
		<p><?php _e( 'You don&#39;t have any contact form created with Contact Form 7.', 'gusto' ); ?></p>
		<?php
		else :
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input type="text" class="widefat" id="<?php
				echo $this->get_field_id( 'title' );
			?>" name="<?php
				echo $this->get_field_name( 'title' );
			?>" value="<?php
				echo esc_attr( $title );
			?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'form' ); ?>"><?php _e( 'Form:' ); ?></label>
			<select class="widefat" id="<?php
				echo $this->get_field_id( 'form' );
			?>" name="<?php
				echo $this->get_field_name( 'form' );
			?>">
				<option value=""><?php _e( '- Click to select -', 'gusto' ); ?></option>
				<?php foreach ( $forms as $_form ) : ?>
				<option value="<?php echo esc_attr( $_form->ID ); ?>" <?php selected( $form, $_form->ID ); ?>>
					<?php echo esc_html( $_form->post_title ); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
		endif;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'title' => ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '',
			'form'  => ! empty( $new_instance['form' ] ) ? intval( $new_instance['form' ] ) : '',
		);

		return $instance;
	}
}

// Register widget with WordPress
register_widget( 'TTT_Widget_Contact_Form' );