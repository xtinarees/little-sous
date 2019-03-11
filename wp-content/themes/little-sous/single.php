<?php

$context = Timber::get_context();

$post = new LittleSousPost();
$context['post'] = $post;

$recipes = get_field('recipes', $post) ?? false;
if ($recipes) {
	$ls_recipes = [];
	foreach ($recipes as $recipe) {
		$ls_recipes[] = new LittleSousPost($recipe['recipe']->ID);
	}
	$context['recipes'] = $ls_recipes;
}

if(is_singular('products')) {
    $context['product'] = new LittleSousProducts($post->ID);
}

$context['recipes_count'] = !$recipes ? 0 : count($recipes);

$context['related'] = LittleSous::get_related($post);

if ($post->post_type == 'recipe') {
	$context['recipe'] = $post;
	Timber::render('templates/single-recipe.twig', $context, 600);
} else if( $post->post_type == 'products' ) {
	Timber::render('templates/single-product.twig', $context, 600);
} else {
	Timber::render('templates/single-post.twig', $context, 600);
}