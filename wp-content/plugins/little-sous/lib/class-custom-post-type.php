<?php

class LittleSous_Custom_Post_type {

	function __construct() {
		$this->add_hooks();
	}

	function add_hooks() {
		add_action( 'init', array($this, 'create_posttype' ));
	}

	// Our custom post type function
	function create_posttype() {
	 
		register_post_type( 'recipe',
		// CPT Options
			array(
				'labels' => array(
					'name' => __( 'Recipes' ),
					'singular_name' => __( 'Recipe' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'recipes'),
				'menu_icon' => 'dashicons-book',
				'supports' => array('title', 'editor', 'thumbnail', 'author', 'revisions', 'author')
			)
        );
        
        register_post_type( 'products', 
            array(
                'labels'    =>  array(
                    'name'          =>  __('Products'),
                    'singular_name' =>  __('Product')
                ),
                'public'    =>  true,
                'has_archive'   =>  false,
                'rewrite'   =>  array('slug' => 'shop'),
                'menu_icon' =>  'dashicons-cart',
                'supports'  =>  array('title', 'editor', 'thumbnail', 'author', 'revisions')
            )
        );

	}

}

new LittleSous_Custom_Post_Type();