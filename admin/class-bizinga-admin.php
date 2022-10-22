<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Bizinga
 * @subpackage Bizinga/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bizinga
 * @subpackage Bizinga/admin
 * @author     sandeep.bly@gmail.com
 */
class Bizinga_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Bizinga    The ID of this plugin.
	 */
	private $Bizinga;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Bizinga       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Bizinga, $version ) {

		$this->Bizinga = $Bizinga;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bizinga_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bizinga_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Bizinga, plugin_dir_url( __FILE__ ) . 'css/bizinga-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bizinga_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bizinga_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Bizinga, plugin_dir_url( __FILE__ ) . 'js/bizinga-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function bizinga_plugin_create_menu() {
		//create new top-level menu
		add_menu_page('Bizinga Reviews Page', 'Reviews Setting', 'administrator', __FILE__, array($this, 'bizinga_plugin_settings_page'), plugins_url('/img/birdeye.png', __FILE__) );
	
		//call register settings function
		
		//add_action( 'admin_init', 'new_plugin' );
		
	}

	public function register_bizinga_plugin_settings() {
		//register our settings
		register_setting( 'bizinga-plugin-settings-group', 'businessNumber' );
		register_setting( 'bizinga-plugin-settings-group', 'apiKey' );
		register_setting( 'bizinga-plugin-settings-group', 'apiHost' );
		register_setting( 'bizinga-plugin-settings-group', 'cssStyle' );
		register_setting( 'bizinga-plugin-settings-group', 'bizinga-border-size' );
		register_setting( 'bizinga-plugin-settings-group', 'bizinga-border-color' );
		register_setting( 'bizinga-plugin-settings-group', 'bizinga-border-radius' );
		register_setting( 'bizinga-plugin-settings-group', 'demo-checkbox');
		register_setting( 'bizinga-plugin-settings-group', 'Appointment-tab');
		register_setting( 'bizinga-plugin-settings-group', 'review-tab');
		register_setting( 'bizinga-plugin-settings-group', 'default-reviews');
	}
  
	public function bizinga_plugin_settings_page() {
		?>
		<div class="be-seeting">
			<div class="bg">
				<div class="be-container">
					<div class="be-logo">
						BIZINGA
					<!-- <img src="<?php //echo plugin_dir_url(( __FILE__ ) ) . 'img/logo-color.png'; ?>"> -->
					</div>
					<div class="be-social">
						<div class="twit">
							<a href="https://twitter.com/birdeye_" target="_blank"><img src="<?php echo plugin_dir_url(( __FILE__ ) ) . 'img/twitter.png'; ?>"><span class="Follow-on-Twitter">Follow On Twitter</span></a>
						</div>
						<div class="fb">
							<a href="https://www.facebook.com/BirdEyeReviews" target="_blank"><img src="<?php echo plugin_dir_url(( __FILE__ ) ) . 'img/facebook.png'; ?>"><span class="Like-on-Facebook">Like on Facebook</span></a>
						</div>
						<div class="yout">
							<a href="https://www.youtube.com/channel/UC5GVt-szboTnj2DKO6PKW5w" target="_blank"><span style="background:#ad2b2b;"><img src="<?php echo plugin_dir_url(( __FILE__ ) ) . 'img/youtube.png'; ?>"></span><span class="Subscribe-On-YouTube">Subscribe YouTube</span></a>
						</div>
					</div>
					<div class="be-head">Bizinga Reviews Plugin</div>
					<div class="form">
						<form method="post" action="options.php">
							<?php settings_fields( 'bizinga-plugin-settings-group' ); ?>
							<?php do_settings_sections( 'bizinga-plugin-settings-group' ); ?>
							<div>
								<label for="fullname">Business ID</label>
								<input type="number" name="businessNumber" value="<?php echo esc_attr( get_option('businessNumber') ); ?>" class="txt"/>
							</div>
							<div>
								<label for="email">API Key</label>
								<input type="text" name="apiKey" value="<?php echo esc_attr( get_option('apiKey') ); ?>" class="txt"/>
							</div>
							<div style="display: none;">
								<label for="password1">API Host</label>
								<input type="text" name="apiHost" value="api.birdeye.com" class="txt"/>
							</div>
							<div class="slider-container">
								<label for="border-customiztion">Customize slider border</label>
								<select id="border_container" name="border-value" class="form-select form-select-sm" aria-label=".form-select-sm">
									<option selected>Select</option>
									<option <?php if ($border_vaules == 1 ) echo 'selected' ; ?> value=1>Size</option>
									<option <?php if ($border_vaules == 2 ) echo 'selected' ; ?> value=2>Color</option>
									<option <?php if ($border_vaules == 3 ) echo 'selected' ; ?> value=3>Radius</option>
								</select>	

								<div class="bizinga-border-size">
									<input type="number" name="bizinga-border-size" class="small-txt" value="<?php echo esc_attr( get_option('bizinga-border-size') ); ?>"/>
								</div>
								<div class="bizinga-border-color">
									<input type="color" name="bizinga-border-color"  class="small-txt" value="<?php echo esc_attr( get_option('bizinga-border-color') ); ?>"/>
								</div>
						
								<div class="bizinga-border-radius">
									<input type="number" name="bizinga-border-radius" class="small-txt" value="<?php echo esc_attr( get_option('bizinga-border-radius') ); ?>"/>
								</div>
							</div>
							<div>
								<label for="password2">Reviews Summary TAB</label>
								<label class="switch">
									<input class="switch-input" type="checkbox" style="display: none;" name="demo-checkbox" value="1" <?php checked(1, get_option('demo-checkbox'), true); ?> />
									<span class="switch-label" data-on="On" data-off="Off"></span> 
									<span class="switch-handle"></span> 
								</label>
							</div>
							<div>
								<label for="password2">Display Appointment TAB</label>
								<label class="switch">
									<input class="switch-input" type="checkbox" style="display: none;" name="Appointment-tab" value="1" <?php checked(1, get_option('Appointment-tab'), true); ?> />
									<span class="switch-label" data-on="On" data-off="Off"></span> 
									<span class="switch-handle"></span> 
								</label>
							</div>
							<div>
								<label for="password2">Write Review TAB</label>
								<label class="switch">
									<input class="switch-input" type="checkbox" style="display: none;" name="review-tab" value="1" <?php checked(1, get_option('review-tab'), true); ?> />
									<span class="switch-label" data-on="On" data-off="Off"></span> 
									<span class="switch-handle"></span> 
								</label>
							</div>
							<div>
								<?php $default_state = get_option('default-reviews');
								?>
								<label for="level">No. Of Reviews Show</label>
								<select name="default-reviews">
									<option>Select Option</option>
									<option  <?php if ($default_state == 15 ) echo 'selected' ; ?> value="15">15</option>
									<option <?php if ($default_state == 20 ) echo 'selected' ; ?> value="20">20</option>
									<option <?php if ($default_state == 25 ) echo 'selected' ; ?> value="25">25</option>
									<option <?php if ($default_state == 30 ) echo 'selected' ; ?> value="30">30</option>
								</select>
							</div>
							<div>
							<?php submit_button(); ?>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>

 	<?php	} 
}
