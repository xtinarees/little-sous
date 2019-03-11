<?php

class LittleSous {

	static function icon_match($name) {
		$icons = [
			'Lifestyle' => 'sunday', 
			'Travel' => 'pizza-globe',
			'Kitchen Academy' => 'hat',
			'Recipes' => 'utensils',
            'Video' => 'fire',
            'Shop our Boxes' => 'shop-icon'
		];

		return $icons[$name] ?? false;
	}

	static function get_related() {
		global $post;

		if ( !class_exists('RP4WP_Post_Link_Manager') ) { return; }

		$pl_manager = new RP4WP_Post_Link_Manager();

		$related_posts = $pl_manager->get_children($post->ID);

		$posts = [];
		foreach ( $related_posts as $related_post ) {
			$posts[] = new LittleSousPost( $related_post->ID );
		}

		return $posts;
	}

	static function get_category_posts($posts) {
		$postss = array();

		foreach($posts as $post) {
			$postss[] = new LittleSousPost($post);
		}

		return $postss;
	}

	static function kicker($post) {
		if (get_post_type($post) == 'recipe') {
			return array(
				'name' => 'Recipe',
				'link' => get_post_type_archive_link('recipe')
			);
		}

		if (get_field('is_sponsored', $post) == true) {
			return array(
				'link' => false,
				'name' => 'Partner Content'
			);
		}

		$categories = get_the_category($post);
		$kicker = false;

		// check and see if any of the categories are children and return the first one
		foreach ($categories as $cat) {
			if ($cat->parent != 0) {
				$kicker = $cat;
			}
		}

		// if no children, get top-level category
		if (!$kicker) {
			$kicker = $categories ? $categories[0] : false;
		}

		$kicker = $kicker ? new TimberTerm($kicker) : false;
		return $kicker;
	}

} 

new LittleSous();