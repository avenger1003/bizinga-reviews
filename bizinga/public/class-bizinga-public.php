<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Bizinga
 * @subpackage Bizinga/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bizinga
 * @subpackage Bizinga/public
 * @author     Your Name <email@example.com>
 */
class Bizinga_Public {

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
	 * @param      string    $Bizinga       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Bizinga, $version ) {

		$this->Bizinga = $Bizinga;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->Bizinga, plugin_dir_url( __FILE__ ) . 'css/bizinga-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->Bizinga.'_bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->Bizinga.'_carousel', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		
		// wp_register_script ( 'scriptjs', plugins_url ( 'js/script.js', __FILE__ ) );
		// wp_register_script ( 'mysample2', plugins_url ( 'js/owl.carousel.min.js', __FILE__ ) );
		
		// wp_register_script ( 'mysample1', plugins_url ( 'js/birdeye.ajax.js', __FILE__ ) );
		wp_enqueue_script( $this->Bizinga.'-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->Bizinga.'-ajax', plugin_dir_url( __FILE__ ) . 'js/birdeye.ajax.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->Bizinga, plugin_dir_url( __FILE__ ) . 'js/bizinga-public.js', array( 'jquery' ), $this->version, false );
		
	}

	public function register_shortcodes() {
		add_shortcode( 'bizinga-reviews', array( $this, 'bizinga_ui') );
	}
	// ob_start();
	public function bizinga_ui() {
	
		$businessNumber = get_option('businessNumber');
		$apiKey = get_option('apiKey');
		$apiHost = get_option('apiHost');
		$cssStyle = get_option('cssStyle');
		$check = get_option('demo-checkbox');
		$appointTab = get_option('Appointment-tab');
		$reviewTab = get_option('review-tab');
		$numOfReviews = get_option('default-reviews');
		$postData = [
			"statuses" => ["published"]
		];
		
		$opts1 = array(
			'http' => array(
				'method' => 'POST',
				'header'=> "Content-Type: application/json\r\n" . 
				"Accept: application/json\r\n",
				"content" => json_encode($postData)
				)
			);
			
			$context1 = stream_context_create($opts1);
			?>
		<section>
			
		<script type="text/javascript">
			const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
		<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
		<style type="text/css"><?=$cssStyle;?></style>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->

		
			<?php
			$reviewerHtml ='<div class="owl-carousel owl-theme">';
			// Reviews GET API consume
			$response = file_get_contents('https://' . $apiHost . '/resources/v1/review/businessId/' . $businessNumber . '?api_key=' . $apiKey . '&sindex=0&count='.$numOfReviews , false, $context1);
			$objReviews = json_decode($response);
		
			foreach($objReviews as $objReview) {
				$objReview->sourceType = $objReview->sourceType == 'Our Website' ? "BirdEye" : $objReview->sourceType;
				$objReview->recommended = $objReview->recommended == 1 ? "Recommended" : "Null";
				$reviewerImg = $objReview->reviewer->thumbnailUrl;
				$reviewerName = !empty($objReview->reviewer->firstName) ? $objReview->reviewer->firstName : $objReview->reviewer->nickName;		
				$reviewerHtml .='<div class="item">
								<div class="card" style="text-align: left;">
									<img class="card-img-top" src="'.$reviewerImg.'" alt="Card image cap">
									<div class="card-body">
									<h5 class="card-title">'.$reviewerName.'</h5>
									<p class="card-text">';
										if ($objReview->recommended =='Recommended'){
											$reviewerHtml.='<span><img src='.plugin_dir_url(( __FILE__ ) ) . 'images/fb_r.svg'.'></span><span class="beFBColor">Recommended</span>';
										}else {
											$reviewerHtml.='<span class="star-num">'.$objReview->rating.'<span><img src='.plugin_dir_url(( __FILE__ ) ) . 'images/fill-2-copy-45.svg'.'></span></span>';
										}	
										if($objReview->sourceType == 'BirdEye'){
											$reviewerHtml.='<span class="on-brand"><a target=_blank style="color: #1976d2"; href='.$objReview->uniqueReviewUrl.'>on <span class="brand">'.$objReview->sourceType.'</a>,</span></span><div class="date">'.$objReview->reviewDate .'</div>';
										}else{
											$reviewerHtml.='<span class="on-brand"><a target=_blank style="color: #1976d2"; href='.$objReview->reviewUrl.'>on <span class="brand">'.$objReview->sourceType.'</a>,</span></span><div class="date">'.$objReview->reviewDate .'</div>';

										} 
										$reviewerHtml.= $objReview->comments .
									'</p>
									</div>
								</div>
							</div>';
				// echo $reviewerHtml;
			}
			// return ob_get_clean();
			return $reviewerHtml;
			?>
		</div>  
	
	</section> <?php


	}
}