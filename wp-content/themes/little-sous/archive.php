<?php

global $paged;
global $wp_query;

if (!isset($paged) || !$paged){
    $paged = 1;
}

$context = Timber::get_context();
$post = is_category() || is_tag() || is_tax() ? new LittleSousTerm() : new LittleSousPost();

$featured_post = get_category_featured_post();
$the_query = ls_query($featured_post, $post);

$context['page'] = $post;
$context['header'] = get_ls_header();
$context['featured_post'] = $featured_post;
$context['posts'] = ls_get_posts($the_query, $featured_post);
$context['the_query'] = $the_query;
$context['pagination'] = Timber::get_pagination();


function get_ls_header() {
	global $post;

	if (is_search()) {
		return;
	} else if (is_category() || is_tag()) {
		$header = new LittleSousTerm(get_term_top_most_parent($post->id, $post->taxonomy));
	} else if (is_author()) {
		$user_id = $post->post_author;
		$header = new LittleSousUser($user_id);
	} else {
		$header = get_field( 'recipes' . '_header', 'options');
	}

	return $header;
}

function get_term_top_most_parent($term_id, $taxonomy){
    // start from the current term
    $parent  = get_term_by( 'id', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
    }
    return $parent;
}

function get_category_featured_post() {
	global $post;
	$args = array(
		'posts_per_page'   => 1,
		'post_type'        => array('recipe', 'post'),
		'post_status'      => 'publish',
		'tax_query'        => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $post->slug
			),
		),
		'meta_query'       => array(
			'relation'     => 'AND',
			array(
				'key'      => '_thumbnail_id',
				'compare'  => 'EXISTS',
			),
			array(
				'key'      => 'is_featured',
				'value'    => true,
				'compare'  => '=',
			),
		),
	);

	$featured_posts = Timber::get_posts($args);
	$featured_post = $featured_posts ? $featured_posts[0] : false;
	$featured_post = $featured_post ? new LittleSousPost($featured_post) : false;

	return $featured_post;
}

function ls_query($featured_post, $post) {
	global $wp_query;

	$featured_post_id = $featured_post ? $featured_post->id : false;

	if (!$featured_post_id) {
		return $wp_query;
	}

	$args = array(
		'post__not_in' => array($featured_post_id),
		'posts_per_page' => 10,
	);

	if (is_category() || is_tag() || is_tax()) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $post->taxonomy,
				'field'    => 'slug',
				'terms'    => $post->slug
			),
		);
	} else if (is_author()) {
		$args['author'] = get_ls_header();
		$args['meta_query'] = array(
			'relation'      => 'AND',
			array(
				'key'       => 'byline_override',
				'value'     => '',
				'compare'   => '=',
			),
		);
	} else if (is_post_type_archive('recipe')) {
		$args['post_type'] = array('recipe');
	}

	$query = new WP_Query($args);

	return $query;
}

function ls_get_posts($the_query, $featured_post) {
	if ($featured_post) {
		$posts = $the_query->posts;
	} else {
		$posts = Timber::get_posts();
	}

	return LittleSous::get_category_posts($posts);

}

Timber::render('templates/archive.twig', $context, 600);
