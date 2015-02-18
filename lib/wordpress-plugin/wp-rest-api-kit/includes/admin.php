<?php
/**
 * Name: Menus Endpoint
 */

class WPRestAPIKitAdmin extends WPRestAPIKitEndpointInit {

	public function __construct() {
		parent::__construct();
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		//add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_init', array( &$this, 'add_settings_fields' ) );
		add_filter( 'admin_init', array( &$this, 'add_register_setting' ) );
		//add_action( 'wp_ajax_reset_css', array( $this, 'reset_css') );
	}

	public function admin_menu() {
		add_options_page(
			__( 'WP Rest API Kit Settings', $this->domain ),
			__( 'WP Rest API Kit', $this->domain ),
			'create_users',
			$this->basename,
			array( &$this, 'add_admin_edit_page' )
		);
	}

	public function add_admin_edit_page() {
		echo '<div class="wrap" id="wp-rest-api-kit-options">' . "\n";
		echo '<h2>' . esc_html( get_admin_page_title() ) . '</h2>' . "\n";
		echo '<form method="post" action="options.php">' . "\n";
		settings_fields( $this->basename  );
		do_settings_sections( $this->basename  );
		submit_button();
		echo '</form>' . "\n";
		echo '</div>' . "\n";
	}

	public function add_settings_fields() {
		global $wp_version;

		add_settings_section(
			'general',
			__( 'General', $this->domain ),
			'',
			$this->basename
		);
		add_settings_field(
			'wp-rest-api-kit-destination_url',
			__( 'Destination URL', $this->domain ),
			array( &$this, 'text_field' ),
			$this->basename,
			'general',
			array(
				'name'  => 'wp_rest_api_kit[destination_url]',
				'value' => $this->destination_url,
			)
		);

	}

	public function text_field( $args ) {
		extract( $args );

		$id      = ! empty( $id ) ? $id : $name;
		$desc    = ! empty( $desc ) ? $desc : '';
		$output  = '<input type="text" name="' . $name .'" id="' . $id .'" class="regular-text" value="' . $value .'" />' . "\n";
		if ( $desc )
			$output .= '<p class="description">' . $desc . '</p>' . "\n";

		echo $output;
	}

	public function textarea_field( $args ) {
		extract( $args );

		$id      = ! empty( $id ) ? $id : $name;
		$desc    = ! empty( $desc ) ? $desc : '';
		$output  = '<textarea name="' . $name .'" rows="10" cols="50" id="' . $id .'" class="large-text code">' . $value . '</textarea>' . "\n";
		if ( $desc )
			$output .= '<p class="description">' . $desc . '</p>' . "\n";
		echo $output;
	}

	public function check_field( $args ) {
		extract( $args );

		$id      = ! empty( $id ) ? $id : $name;
		$desc    = ! empty( $desc ) ? $desc : '';
		$output  = '<label for="' . $name . '">' . "\n";
		$output  .= '<input name="' . $name . '" type="checkbox" id="' . $id . '" value="1"' . checked( $value, 1, false ) . '>' . "\n";
		if ( $desc )
			$output .= $desc . "\n";
		$output  .= '</label>' . "\n";

		echo $output;
	}

	public function select_field( $args ) {
		extract( $args );

		$id             = ! empty( $id ) ? $id : $name;
		$desc           = ! empty( $desc ) ? $desc : '';
		$multi          = ! empty( $multi ) ? ' multiple' : '';
		$multi_selected = ! empty( $multi ) ? true : false;
		$output = '<select name="' . $name . '" id="' . $id . '"' . $multi . '>' . "\n";
			foreach ( $option as $key => $val ) {
				$output .= '<option value="' . $key . '"' . selected( $value, $key, $multi_selected ) . '>' . $val . '</option>' . "\n";
			}
		$output .= '</select>' . "\n";
			if ( $desc )
			$output .= $desc . "\n";

		echo $output;
	}

	public function selected( $value = '', $val = '', $multi = false ) {
		$select = '';
		if ( $multi ) {

			$select = selected( true, in_array( $val, $value ), false );
		} else {
			$select = selected( $value, $val, false );
		}
		return $select;
	}

	public function add_register_setting() {
		register_setting( $this->basename, 'wp_rest_api_kit', array( &$this, 'register_setting_check' ) );
	}

	public function register_setting_check( $value ) {
		$value['destination_url'] = untrailingslashit( esc_url( $value['destination_url'] ) );
		return $value;
	}

}
