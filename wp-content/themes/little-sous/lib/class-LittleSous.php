<?php

class LittleSous {

	static function icon_match($name) {
		$icons = [
			'Lifestyle' => 'book', 
			'Travel' => 'globe',
			'Kitchen Academy' => 'hat',
			'Recipes' => 'shrimp',
		];

		return $icons[$name] ?? false;
	}

	static function get_related() {
		return false;
		/*
		global $post;

		$pl_manager = new RP4WP_Post_Link_Manager();

        $related_posts = $pl_manager->get_children($post->ID);

        $posts = [];
        foreach ( $related_posts as $related_post ) {
            $posts[] = new LittleSousPost( $related_post->ID );
        }

        return $posts;
        */
	}

	static function get_category_posts($posts) {
		$postss = array();

		if (is_category() || is_author()) {
			foreach($posts as $post) {
				$postss[] = new LittleSousPost($post);
			}
		} else {
			foreach($posts as $post) {
				$postss[] = new LittleSousRecipe($post);
			}
		}

		return $postss;
	}

} 

new LittleSous();