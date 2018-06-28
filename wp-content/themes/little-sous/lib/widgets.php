<?php

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

    register_sidebar( array(
        'name'          => 'Instagram Area',
        'id'            => 'instagram_area',
    ) );

    register_sidebar( array(
        'name'          => 'Twitter Area',
        'id'            => 'twitter_area',
    ) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

//add class to instagram widget images
add_filter( 'wpiw_item_class', 'my_instagram_class' );
// add_filter( 'wpiw_a_class', 'my_instagram_class' );
// add_filter( 'wpiw_img_class', 'my_instagram_class' );

function my_instagram_class( $classes ) {
    $classes = "instagram__item";
    return $classes;
}