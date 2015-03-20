<?php
/**
 * Name: Media Assembly Kit Admin
 */

class MediaAssemblyKitAdmin extends MediaAssemblyKitInit {

	public function __construct() {
		parent::__construct();
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'admin_init', array( &$this, 'add_settings_fields' ) );
		add_filter( 'admin_init', array( &$this, 'add_register_setting' ) );
	}

	public function admin_menu() {
		add_options_page(
			__( 'Media Assembly Kit Settings', $this->domain ),
			__( 'Media Assembly Kit', $this->domain ),
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

	public function add_register_setting() {
		register_setting( $this->basename, 'wp_rest_api_kit', array( &$this, 'register_setting_check' ) );
	}

	public function register_setting_check( $value ) {
		$value['destination_url'] = untrailingslashit( esc_url( $value['destination_url'] ) );
		return $value;
	}

}
