<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$ids = array(1621, 1575);

if(in_array($post->ID, $ids)) {
    $context['boxes'] = get_boxes();
    $context['subscriptions'] = get_subscriptions();

    Timber::render('templates/page-shop-boxes.twig', $context, 600);
} else {
    Timber::render('templates/page.twig', $context, 600);
}

function get_boxes() {

    $boxes = Timber::get_posts([
        'post_type'         =>  'products',
        'posts_per_page'    =>  -1,
    ]);

    return $boxes;

}

function get_subscriptions() {
    
    $subscriptions = get_posts([
        'post_type'         =>  'products',
        'posts_per_page'    =>  '2',
        'meta_key'          =>  'featured_product',
        'meta_value'        =>  true
    ]);
        
    return $subscriptions;

}
