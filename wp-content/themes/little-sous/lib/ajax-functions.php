<?php
/**
 * AJAX functions
 *
*/


/*
LOAD MORE POSTS
*/
if ( !function_exists( 'dmag_load_more_posts_data' ) ) {
	/**
	 * Print an HTML script tag for a post navigation element and corresponding query
	 *
	 * If you plan on plugging this function, make sure the data structure it returns includes and "is_home" key.
	 *
	 * @param string  $nav_id The unique id of the navigation element used as the trigger to load more posts
	 * @param object $the_query The WP_Query object upon which calls to load more posts will be based
	 */
	function dmag_load_more_posts_data( $nav_id, $the_query, $page_id ) {
		global $post;

		$query = $the_query->query;

		$config = array(
			'nav_id' => $nav_id,
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'paged' => ( !empty( $the_query->query_vars['paged'] ) )? $the_query->query_vars['paged'] : 1,
			'query' => $query,
			'is_series_landing' => $post->post_type == 'cftl-tax-landing' ? true : false,
			'no_more_posts' => "You've reached the end!",
			'page_id' => $page_id,
			'max_num_pages' => $the_query->max_num_pages,
		);

		$config = apply_filters( 'dmag_load_more_posts_json', $config );

		?>
		<script type="text/javascript">
			LS.LoadMorePostsArray = LS.LoadMorePostsArray || [];
			LS.LoadMorePostsArray.push(<?php echo json_encode( $config ); ?>);
		</script>
	<?php
	}
}

if ( !function_exists( 'dmag_load_more_posts' ) ) {
	/**
	 * Renders markup for a page of posts and sends it back over the wire.
	 * @global $_POST
	 * @see dmag_load_more_posts_choose_partial
	 */
	function dmag_load_more_posts() {

		get_template_part('archive', 'repeater');

		wp_die();
	}
	add_action( 'wp_ajax_nopriv_load_more_posts', 'dmag_load_more_posts' );
	add_action( 'wp_ajax_load_more_posts', 'dmag_load_more_posts' );
}



if ( !function_exists( 'dmag_load_slideshow_data' ) ) {
	/**
	 * Print an HTML script tag for a post navigation element and corresponding query
	 *
	 * If you plan on plugging this function, make sure the data structure it returns includes and "is_home" key.
	 *
	 * @param string  $nav_id The unique id of the navigation element used as the trigger to load more posts
	 * @param object $the_query The WP_Query object upon which calls to load more posts will be based
	 */
	function dmag_load_slideshow_data() {
		global $post;
		$config = array(
			'post_id' => $post->ID,
			'slideshow_id' => 'js-slideshow-init',
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		);

		$config = apply_filters( 'dmag_load_slideshow_json', $config );

		// get_template_part('story', 'slideshow');

		?>
		<script type="text/javascript">
			LS.LoadSlideshowArray = LS.LoadSlideshowArray || [];
			LS.LoadSlideshowArray.push(<?php echo json_encode( $config ); ?>);
		</script>
	<?php
	}
}

if ( !function_exists( 'dmag_load_slideshow_ajax' ) ) {
	/**
	 * Renders markup for a page of posts and sends it back over the wire.
	 * @global $_POST
	 * @see dmag_load_more_posts_choose_partial
	 */
	function dmag_load_slideshow_ajax() {

		get_template_part('single', 'slideshow');

		wp_die();
	}
	add_action( 'wp_ajax_nopriv_load_slideshow', 'dmag_load_slideshow_ajax' );
	add_action( 'wp_ajax_load_slideshow', 'dmag_load_slideshow_ajax' );
}



