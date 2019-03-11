<?php 

add_action('init', 'shortcode_functions');
function shortcode_functions() {
    add_shortcode( 'subscription', 'subscription_shorcode' );
    add_shortcode( 'boxes', 'sous_boxes' );
}

function subscription_shorcode( $atts ) {
    $title = $atts['title'];
    $subscriptions = get_subscriptions();

    // This time we use Timber::compile since shortcodes should return the code
    return Timber::compile('templates/subscription-box.twig', array( 'title' => $title, 'subscriptions' => $subscriptions ) );
}

function sous_boxes($atts) {
    $title = $atts['title'];
    $posts = get_boxes();
    return Timber::compile('templates/boxes-shortcode.twig', array( 'title' => $title, 'posts' => $posts ) );
}

// function get_subscriptions() {
    
//     $subscriptions = get_posts([
//         'post_type'         =>  'products',
//         'posts_per_page'    =>  '2',
//         'meta_key'          =>  'featured_product',
//         'meta_value'        =>  true
//     ]);
        
//     return $subscriptions;

// }

// function get_boxes() {

//     $boxes = Timber::get_posts([
//         'post_type'         =>  'products',
//         'posts_per_page'    =>  -1,
//     ]);

//     return $boxes;

// }