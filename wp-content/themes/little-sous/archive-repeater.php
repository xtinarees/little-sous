<?php

$context = Timber::get_context();

$paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
$query = (isset($_POST['query'])) ? json_decode(stripslashes($_POST['query']), true) : array();
$post_id = (isset($_POST['page_id'])) ? json_decode($_POST['page_id']) : null;


$args = array_merge(array(
    'paged' => (int) $paged,
    'post_status' => 'publish',
    'posts_per_page' => 10,
), $query);


$post = new TimberTerm($post_id);
$posts = Timber::get_posts($args);
$lsPosts = LittleSous::get_category_posts($posts);

$context['page'] = $post;
$context['posts'] = $lsPosts;

Timber::render('templates/archive-repeater.twig', $context, 600);

