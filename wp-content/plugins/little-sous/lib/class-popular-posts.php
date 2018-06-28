<?php

class LittleSous_Popular_Posts {

	function __construct() {
		add_filter( 'wpp_no_data', array( $this, 'my_custom_no_posts_found'), 10, 1 );
		add_filter( 'wpp_custom_html', array($this, 'my_custom_popular_posts_html_list'), 10, 2 );
	}

	/*
	 * Change WPP's 'Sorry. No data so far.' message to '' 
	 */
	function my_custom_no_posts_found( $no_data_html ){ 
		$output = ''; 
		return $output;
	}


	/*
	 * Builds custom HTML
	 *
	 * With this function, I can alter WPP's HTML output
	 * This way, the modification is permanent even if the plugin gets updated.
	 *
	 * @see https://github.com/cabrerahector/wordpress-popular-posts/wiki/3.-Filters
	 * @param   array   $mostpopular
	 * @param   array   $instance
	 * @return  string
	 */
	function my_custom_popular_posts_html_list($mostpopular, $instance) {
		$output = '<div class="mini-cards">';

		// loop the array of popular posts objects
		foreach( $mostpopular as $popular ) {
			$id = $popular->id;
			$link = get_the_permalink($id);
			$kicker = "";
			if (LittleSous::kicker($id)->link) { $kicker .= "<a href='" . LittleSous::kicker($id)->link . "'>"; }
			$kicker .= LittleSous::kicker($id)->name;
			if (LittleSous::kicker($id)->link) { $kicker .= "</a>"; }

			$output .= "<article class='mini-card hover-card js-card'>";
			$output .= "<a class='card__underlay' href='" . $link . "'></a>";
			$output .= "<a class='mini-card__image-wrapper' href='" . $link . "'>";
			$output .= "<img class='mini-card__image hover-card__image' src=" . get_the_post_thumbnail_url($id, 'square_medium') . ">";
			$output .= "</a>";
			$output .= "<div class='mini-card__content'>";
			$output .= "<span class='kicker-orange'>" . $kicker . "</span>";
			$output .= "<h1 class='mini-card__title hover-card__title'><a href=\"" . $link . "?ref=mpw\" title=\"" . esc_attr( $popular->title ) . "\">" . $popular->title . "</a></h2>";
			$output .= "<div class='mini-card__fade'></div>";
			$output .= "</div>";
			$output .= "</article>";
		}

		$output .= '</div>';

		return $output;
	}
}

new LittleSous_Popular_Posts();


