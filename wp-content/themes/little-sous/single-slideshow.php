<?php

global $post;
$context = Timber::get_context();

if (isset($_POST['post_id']))
	$post_id = $_POST['post_id'];
else
	$post_id = '';

$post = new TimberPost($post_id);
$context['post'] = $post;

Timber::render('templates/slideshow.twig', $context);
