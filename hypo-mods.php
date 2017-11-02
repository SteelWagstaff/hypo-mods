<?php
/*
 * Plugin Name: Hypothesis Mods
 * Plugin URI: none
 * Description: A plugin that allows some modification of the Hypothesis client
 * Author: Steel Wagstaff
 * Version: 0.1.0
 * Author URI: https://steelwagstaff.info
 * Text Domain:     hypothesis mods
 * Domain Path:     /languages
 */

// Exit if called directly.
defined( 'ABSPATH' ) or die( 'Cannot access pages directly.' );

/**
 * Create settings page (see https://codex.wordpress.org/Creating_Options_Pages)
 */
class HypothesisModsSettingsPage {
	/**
	 * Holds the values to be used in the fields callbacks
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		add_options_page(
			'Hypothesis Mods Settings Admin',
			'Hypothesis Mods Settings',
			'manage_options',
			'hypothesis-mods-setting-admin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property.
		$this->options = get_option( 'hypothesis_mods_options' ); ?>
		<div class="wrap">
		<form method="post" action="options.php">
		<?php
				settings_fields( 'hypothesis_mods_option_group' );
				do_settings_sections( 'hypothesis-mods-setting-admin' );
				submit_button();
			?>
		</form>
		</div>
	<?php }

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'hypothesis_mods_option_group', // Option group.
			'hypothesis_mods_options', // Option name.
			array( $this, 'sanitize' ) // Sanitize callback.
		);

		/**
		 * Hypothesis Mod Settings
		 */
		add_settings_section(
			'hypothesis_mods_settings_section', // ID.
			'Hypothesis Mod Settings', // Title.
			array( $this, 'print_section_info' ), // Callback.
			'hypothesis-mods-setting-admin' // Page.
		);

		add_settings_field(
			'adjust-page-width',
			'Adjust the width of the page when annotation pane is expanded',
			array( $this, 'adjust_page_width_callback' ),
			'hypothesis-mods-setting-admin',
			'hypothesis_mods_settings_section'
		);

		add_settings_field(
			'darken-highlights',
			'Darken highlights (to make more visible)',
			array( $this, 'darken_highlights_callback' ),
			'hypothesis-mods-setting-admin',
			'hypothesis_mods_settings_section'
		);

    add_settings_field(
      'hide-annotation-header',
      __( 'Hide annotation author & date information', 'hypothesis' ),
      array( $this, 'hide_annotation_header_callback' ),
      'hypothesis-mods-setting-admin',
			'hypothesis_mods_settings_section'
    );
}

/**
	* Sanitize each setting field as needed
	*
	* @param array $input Contains all settings fields as array keys.
	*/
 public function sanitize( $input ) {
	 $new_input = array();

	 if ( isset( $input['adjust-page-width'] ) ) {
		 $new_input['adjust-page-width'] = absint( $input['adjust-page-width'] );
	 }

	 if ( isset( $input['darken-highlights'] ) ) {
		 $new_input['darken-highlights'] = absint( $input['darken-highlights'] );
	 }

	 if ( isset( $input['hide-annotation-header'] ) ) {
		 $new_input['hide-annotation-header'] = absint( $input['hide-annotation-header'] );
	 }

	 return $new_input;
 }

  /**
   * Print the Display Settings section text
   */
  public function print_section_info() {
  	printf( 'Control additional Hypothesis display settings.');
	}

	/**
	 * Callback for 'adjust-page-width'.
	 */
	public function adjust_page_width_callback ( $args ) {
		$val = isset( $this->options['adjust-page-width'] ) ? esc_attr( $this->options['adjust-page-width'] ) : 0;

		printf(
			'<input type="checkbox" id="adjust-page-width" name="hypothesis_mods_options[adjust-page-width]" value="1" %s/>',
			checked( $val, 1, false )
		);
	}

  /**
   * Callback for 'darken-highlights'.
   */
  public function darken_highlights_callback ( $args ) {
    $val = isset( $this->options['darken-highlights'] ) ? esc_attr( $this->options['darken-highlights'] ) : 0;

    printf(
      '<input type="checkbox" id="darken-highlights" name="hypothesis_mods_options[darken-highlights]" value="1" %s/>',
      checked( $val, 1, false )
    );
  }

  /**
   * Callback for 'hide-annotation-header'.
   */
  public function hide_annotation_header_callback ( $args ) {
    $val = isset( $this->options['hide-annotation-header'] ) ? esc_attr( $this->options['hide-annotation-header'] ) : 0;
    printf(
      '<input type="checkbox" id="hide-annotation-header" name="hypothesis_mods_options[hide-annotation-header]" value="1" %s/>',
      checked( $val, 1, false )
    );
  }
}
	if ( is_admin() ) {
		$hypothesis_mods_settings_page = new HypothesisModsSettingsPage();
	}

add_action( 'wp', 'hypothesis_mods' );

function hypothesis_mods() {
	$options = get_option( 'hypothesis_mods_options' );
	console.log('Is this being called?');
	console.log($options);
	console.log('testing' . $this);
	console.log('Page width value:' . $this->options['adjust-page-width']);

	/**
 	* Calls script to resize page upon expansion of Hypothesis annotation pane
 	*/
 	if ( isset ( $options['adjust-page-width'] ) ) {
		 wp_enqueue_script( 'resize', plugins_url('/js/resize.js', __FILE__), array('jquery'), false, true );
  }

	/**
   * Loads CSS which hides annotation header
   */
  // display settings
  if ( isset( $options['hide-annotation-header'] ) ) {
    wp_enqueue_style( 'hypo', plugins_url( '/css/hypo.css', __FILE__) );
  }

	/**
 	* Loads CSS which darkens annotations to make more visible
 	*/
  if (isset ($options['darken_highlights'] ) ) {
    wp_enqueue_style( 'darken', plugins_url( 'css/darken.css', __FILE__) );
  }
}
