<?php
/**
 * D Magazine Defining Taxonomies and Rewrite rules
 *
 * @package   D Magazine
 *
 * @since 1.0
 */

class LittleSous_Taxonomies {

	function __construct() {
		$this->add_hooks();
	}

	function add_hooks() {
		// Load custom taxonomies. It's a static method.
		// Load even when invalid to allow for export
		add_action( 'init', array( $this, 'init_taxonomies' ) );
		// add_filter( 'post_link', array( $this, 'section_permalink' ), 10, 3 );
		// add_filter( 'post_type_link', array( $this, 'section_permalink' ), 10, 3 );
		add_filter( 'page_rewrite_rules', array( $this, 'rewrite_verbose_page_rules' ), PHP_INT_MAX );
		add_filter( 'do_parse_request',  array( $this, 'rewrite_verbose_page_rules' ), PHP_INT_MAX );

		// Disable the WPSEO v3.1+ Primary Category feature.
		add_filter( 'wpseo_primary_term_taxonomies', '__return_empty_array' );

		//hook in to the save_post action to run when a post is saved
		add_action( 'save_post', array( $this, 'remove_default_category' ), 100, 2 );
		add_action('after_setup_theme', array( $this, 'wpse65653_remove_formats'), 100);

	}

	/**
	 * set WP_Rewrite::use_verbose_page_rules to TRUE if %section%
	 * is used as the first rewrite tag in post permalinks
	 * 
	 * @wp-hook do_parse_request
	 * @wp-hook page_rewrite_rules
	 * @global $wp_rewrite
	 * @param mixed $pass_through (Unused)
	 * @return mixed
	 */
	function rewrite_verbose_page_rules( $pass_through = NULL ) {

		$permastruct = $GLOBALS[ 'wp_rewrite' ]->permalink_structure;
		$permastruct = trim( $permastruct, '/%' );
		if ( 0 !== strpos( $permastruct, 'section%' ) )
			return $pass_through;

		$GLOBALS[ 'wp_rewrite' ]->use_verbose_page_rules = TRUE;
		return $pass_through;
	}

	/**
	 * Register custom taxonomies
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function init_taxonomies() {

		$labels = array(
			'name'                       => _x( 'Supplies', 'Taxonomy General Name' ),
			'singular_name'              => _x( 'supply', 'Taxonomy Singular Name'),
			'menu_name'                  => __( 'Supplies' ),
			'all_items'                  => __( 'All Supplies' ),
			'parent_item'                => __( 'Parent Supply' ),
			'parent_item_colon'          => __( 'Parent Supply:' ),
			'new_item_name'              => __( 'New Supply Name' ),
			'add_new_item'               => __( 'Add New Supply' ),
			'edit_item'                  => __( 'Edit Supply' ),
			'update_item'                => __( 'Update Supply' ),
			'view_item'                  => __( 'View Supply' ),
			'separate_items_with_commas' => __( 'Separate supplies with commas' ),
			'add_or_remove_items'        => __( 'Add or remove supplies' ),
			'choose_from_most_used'      => __( 'Choose from the most used' ),
			'popular_items'              => __( 'Popular Supplies' ),
			'search_items'               => __( 'Search Supplies' ),
			'not_found'                  => __( 'Not Found' ),
			'no_terms'                   => __( 'No supplies' ),
			'items_list'                 => __( 'Supply list' ),
			'items_list_navigation'      => __( 'Supply list navigation' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'					 => array(
				'slug' => 'supplies',
				'with_front' => true,
				'hierarchical' => true,
				//'ep_mask' => EP_ALL,
			),
		);

		register_taxonomy( 'supply', array( 'post', 'recipe' ), $args );

	} //end public static function init_taxonomies

	/**
	 * Register rewrite rules to capture the single entry view
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	// public static function init_rewrite() {

	// 	add_filter('rewrite_rules_array', array( 'LittleSous_Taxonomies', 'rewrite_rules' ) );
	// }

	// public static function rewrite_rules( $rules ) {

	// 	$new_rules  = array();

	// 	return array_merge( $new_rules, $rules );

	// } //end function rewrite_rules

	function section_permalink( $permalink, $post, $leavename ) {

		$permalink = str_replace( 'uncategorized/', '', $permalink );

		if ( strpos( $permalink, '%section%' ) === FALSE ) return $permalink;
		 
			// Get post
			if ( !$post ) return $permalink;

			// Get taxonomy terms for Section
			$sections = wp_get_object_terms( $post->ID, 'section' );

			if ( count( $sections ) > 0 ) {

				if ( $section_permalink = get_post_meta( $post->ID, '_section_permalink', true ) ) {

					$section_slug = current( array_filter( $sections, function( $section ) use($section_permalink) {
						return $section->term_id == $section_permalink;
					} ) )->slug;

				} else {
					$section_slug = current( $sections )->slug;
				}

				$permalink = str_replace( '%section%', $section_slug, $permalink );
				return $permalink;
			}

			$section_slug = '';
	 
		$permalink = str_replace( '%section%/', $section_slug, $permalink );
		return $permalink;

	} //end function section_permalink

	// my own function to do what get_category_parents does for other taxonomies
	// function get_taxonomy_parents( $id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array() ) {    
	// 	$chain = '';   
	// 	$parent = get_term( $id, $taxonomy );

	// 	if ( is_wp_error( $parent ) ) {
	// 		return $parent;
	// 	}

	// 	if ($nicename) {
	// 		$name = $parent->slug;
	// 	} else {
	// 		$name = $parent->name;
	// 	}

	// 	if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
	// 		$visited[] = $parent->parent;
	// 		$chain .= $this->get_taxonomy_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
	// 	}

	// 	if ( $link ) {
	// 		// nothing, can't get this working :(
	// 	} else {
	// 		$chain .= $name . $separator;    
	// 	}
	// 	return $chain;

	// } //end function get_taxonomy_parents

	//remove default category (uncategorized) when another category has been set
	function remove_default_category( $id, $post ) {

		//get all categories for the post
		$categories = wp_get_object_terms( $id, 'category' );
		
		//if there is more than one category set, check to see if one of them is the default
		if ( count( $categories ) > 1 ) { 
			foreach ( $categories as $key => $category ) {
				//if category is the default, then remove it
				if ( $category->name == 'Uncategorized' ) {
					wp_remove_object_terms( $id, 'uncategorized', 'category' );
				}
			}
		}

		// set is_story meta for posts and print stories (pages under Publications)
		/*
		* Criteria for stories: 
		* Is a Post
		* Is a Page, Has an Issue Template as a Parent, and is not a package page
		* Is a Page, Has a Package Page as a Parent, and is not a package page
		*/
		$parent_issue_template = get_post_meta( $post->post_parent, '_wp_page_template', true ) == 'template-issue.php';
		$parent_package = get_post_meta( $post->post_parent, '_wp_page_template', true ) == 'template-package.php';
		$package_page = get_post_meta( $post->ID, '_wp_page_template', true ) == 'template-package.php';
		$is_story = $post->post_type == 'post' || ($post->post_type == 'page' && $post->post_parent > 0 && $parent_issue_template && !$package_page) || ($post->post_type == 'page' && $parent_package && !$package_page);

		if ( $is_story ) {
			update_post_meta( $id, 'is_story', 1 );
		} else {
			update_post_meta( $id, 'is_story', 0 );
		}

	} //end function remove_default_category


	function wpse65653_remove_formats() {
	   remove_theme_support('post-formats');
	}



} //end class LittleSous_Taxonomies

new LittleSous_Taxonomies();