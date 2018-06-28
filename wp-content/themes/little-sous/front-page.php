<?php
/**
 * Template Name: Home
 */

$context = Timber::get_context();

$post = new TimberPost();
$context['page'] = $post;
$context['featured_post'] = get_featured_post();
$context['recipes'] = get_recipes();
$context['kitchen_academy'] = get_kitchen_academys();
$context['posts_1'] = get_ls_posts('travel');
$context['posts_2'] = get_ls_posts('lifestyle');
$context['instagrams'] = get_instagram_posts();
$context['video'] = get_recipe();

function get_featured_post() {
	$featured_post = get_field('featured_on_homepage', 'option') ?: false;

	$featured_post = new LittleSousPost($featured_post);
	return $featured_post;
}


function get_recipe() {
	$args = array(
		'posts_per_page'   => 1,
		'post_type'        => array('post'),
		'tax_query'        => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => 'video',
			),
		),
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'post__not_in' => array(get_featured_post()->ID),
	);

	$posts = Timber::get_posts($args);
	$ls_posts = array();
	foreach($posts as $post) {
		$ls_posts[] = new LittleSousPost($post);
	}

	$header = get_category_by_slug('video');
	$header = new LittleSousTerm($header);

	$output = [
		'featured' => $posts ? $posts[0] : false,
		'title' => $header->name,
		'description' => $header->description,
		'icon' => $header->icon(),
		'link' => $header->link,
	];

	return $output;
}


function get_recipes() {
	$args = array(
		'posts_per_page'   => 3,
		'post_type'        => array('recipe'),
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'post__not_in' => array(get_featured_post()->ID),
	);

	$posts = Timber::get_posts($args);
	$recipes = array();
	foreach($posts as $post) {
		$recipes[] = new LittleSousPost($post);
	}

	$output = [
		'posts' => $recipes,
		'title' => 'Recipes',
		'description' => get_field('recipes_description', 'options'),
		'icon' => LittleSous::icon_match('Recipes'),
		'link' => '/recipes',
		'style' => 'cards'
	];

	return $output;
}


function get_kitchen_academys() {
	$args = array(
		'posts_per_page'   => 2,
		'post_type'        => array('post'),
		'tax_query'        => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => 'kitchen-academy',
			),
		),
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'post__not_in' => array(get_featured_post()->ID),
	);

	$posts = Timber::get_posts($args);
	$ls_posts = array();
	foreach($posts as $post) {
		$ls_posts[] = new LittleSousPost($post);
	}

	$header = new LittleSousTerm(get_category_by_slug('kitchen-academy'));

	$output = [
		'posts' => $ls_posts,
		'title' => $header->name,
		'description' => get_field('recipes_description', 'options'),
		'icon' => $header->icon(),
		'link' => $header->link,
		'style' => 'accent-cards',
	];

	return $output;
}


function get_ls_posts($tax) {
	$args = array(
		'posts_per_page'   => 3,
		'post_type'        => array('post'),
		'tax_query'        => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $tax,
			),
		),
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'post__not_in' => array(get_featured_post()->ID),
	);

	$posts = Timber::get_posts($args);
	$ls_posts = array();
	foreach($posts as $post) {
		$ls_posts[] = new LittleSousPost($post);
	}

	$header = get_category_by_slug($tax);
	$header = new LittleSousTerm($header);

	$output = [
		'posts' => $ls_posts,
		'title' => $header->name,
		'description' => $header->description,
		'icon' => $header->icon(),
		'link' => $header->link,
		'style' => 'cards',
	];

	return $output;
}

// based on https://gist.github.com/cosmocatalano/4544576. via the 'WP Instagram Widget' plugin
function get_instagram( $username ) {

	$username = trim( strtolower( $username ) );

	switch ( substr( $username, 0, 1 ) ) {
		case '#':
			$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
			$transient_prefix = 'h';
			break;

		default:
			$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
			$transient_prefix = 'u';
			break;
	}

	if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

		$remote = wp_remote_get( $url );

		if ( is_wp_error( $remote ) ) {
			return;
			// return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
		}

		if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
			return;
			// return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
		}

		$shards      = explode( 'window._sharedData = ', $remote['body'] );
		$insta_json  = explode( ';</script>', $shards[1] );
		$insta_array = json_decode( $insta_json[0], true );

		if ( ! $insta_array ) {
			return;
			// return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
		}

		if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			return;
			// return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
		}

		if ( ! is_array( $images ) ) {
			return;
			// return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
		}

		$instagram = array();

		foreach ( $images as $image ) {
			if ( true === $image['node']['is_video'] ) {
				$type = 'video';
			} else {
				$type = 'image';
			}

			$caption = __( 'Instagram Image', 'wp-instagram-widget' );
			if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
				$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
			}

			$instagram[] = array(
				'description' => $caption,
				'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
				'time'        => $image['node']['taken_at_timestamp'],
				'comments'    => $image['node']['edge_media_to_comment']['count'],
				'likes'       => $image['node']['edge_liked_by']['count'],
				'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
				'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
				'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
				'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
				'type'        => $type,
			);
		} // End foreach().

		// do not set an empty transient - should help catch private or empty accounts.
		if ( ! empty( $instagram ) ) {
			$instagram = base64_encode( serialize( $instagram ) );
			set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
		}
	}

	if ( ! empty( $instagram ) ) {

		return unserialize( base64_decode( $instagram ) );

	} else {

		return;
		// return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wp-instagram-widget' ) );

	}
}


function get_instagram_posts() {
	$posts = get_instagram('little.sous');
	if (!$posts) { return; }

	$posts = array_slice($posts, 0, 4);

	$output = [
		'posts' => $posts,
		'title' => '#MyLittleSous',
		'icon' => 'instagram',
		'link' => 'https://www.instagram.com/little.sous/',
		'style' => 'instagrams',
		'text' => 'Share your kitchen moments',
	];

	return $output;
}



Timber::render('templates/template-home.twig', $context);