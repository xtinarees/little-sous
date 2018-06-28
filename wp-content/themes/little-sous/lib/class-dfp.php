<?php

/**
 * Global instances for DoubleClick object.
 */


class DoubleClick {

	/**
	 * Network code from DFP.
	 *
	 * @var int
	 */
	public $networkCode;

	/**
	 * If true, plugin prints debug units instead of
	 * making a call to dfp.
	 *
	 * @var boolean
	 */
	public $debug = false;

	/**
	 * Array of defined breakpoints
	 *
	 * @var Array
	 */
	public $breakpoints = array();

	/**
	 * Array of placed ads.
	 *
	 * @var Array
	 */
	public $adSlots = array();

	/**
	 * Whether we have hooked enqueue of the script
	 * to wp head.
	 *
	 * @var boolean
	 */
	private static $enqueued = false;

	/**
	 * Size mappings for ad units.
	 *
	 * @var Array
	 */
	private static $mapping = array();

	/**
	 * The number of ads on a page. Also appended to
	 * ad identifiers to create unique strings.
	 *
	 * @var int
	 */
	public static $count = 0;

	/**
	 * Create a new DoubleClick object
	 *
	 * @param string $networkCode The code for your dfp instance.
	 */
	public function __construct() {

		// $this->networkCode = $networkCode;

		// Script enqueue is static because we only ever want to print it once.
		if(!self::$enqueued) {
			add_action('wp_footer', array($this, 'enqueue_scripts'));
			self::$enqueued = true;
		}

		add_action('wp_print_footer_scripts', array($this, 'footer_script'));

	}



	public function enqueue_scripts() {

		$data = array(
			'networkCode' => '21680537470',
			'targeting' => $this->targeting()
		);

	}

	/**
	 * If the network code is set by the theme, return that.
	 * Else, try to return the front end option.
	 *
	 * @return String network code.
	 */
	private function networkCode() {
		return isset($this->networkCode) ? $this->networkCode : get_option('dfw_network_code','xxxxxx');
	}

	public function footer_script() { ?>
		<script type="text/javascript">
			(function($) {
				window.dfp_targeting = <?php echo json_encode($this->targeting()); ?>;
			})(jQuery);
		</script>

	<?php
	}

	private function targeting() {
		/** @see http://codex.wordpress.org/Conditional_Tags */
		global $post;
		global $wp_query;

		$is_home =  is_home() || is_front_page();
		$targeting = array();
		$targeting['Page'] = array();

		// Homepage
		if( $is_home )
			$targeting['Page'][] = 'home';

		// Admin
		if( is_admin() )
			$targeting['Page'][] = 'admin';

		if( is_admin_bar_showing()  )
			$targeting['Page'][] = 'admin-bar-showing';

		// Templates
		if( is_single() )
			$targeting['Page'][] = 'story';

		if( is_tax() || is_category() || is_tag() || is_post_type_archive() )
			$targeting['Page'][] = 'archive';

		if( get_post_type($post) && !$is_home )
			$targeting['Page'][] = get_post_type($post);

		if( is_author() )
			$targeting['Page'][] = 'author';

		if( is_date() )
			$targeting['Page'][] = 'date';

		if( is_search() )
			$targeting['Page'][] = 'search';

		if( is_single() ) {
			$cats = get_the_category();
			$targeting['Category'] = array();

			if ($cats) {
				foreach($cats as $c) {
					$targeting['Category'][] = $c->slug;
				}
			}
		}

		if ( is_category() ) {
			$targeting['Category'][] = $wp_query->query['category_name'];
		}

		if ( is_tag() ) {
			$targeting['Tag'][] = $wp_query->query['tag'];
		}

		if( is_single() ) {
			$tags = get_the_tags();
			if ($tags) {
				$targeting['Tag'] = array();
				foreach($tags as $t) {
					$targeting['Tag'][] = $t->slug;
				}
			}
		}

		// return the array of targeting criteria.
		return $targeting;
	}
	
}


new DoubleClick();
