<?php

class LittleSousPost extends TimberPost {

	function byline() {
		$author = [];
		if (get_field('byline_override', $this->ID)) {
			$author['name'] = get_field('byline_override', $this->ID);
		} else {
			$author_id = get_post_field( 'post_author', $this->id );
			$user = get_user_by('ID', $author_id);
			// var_dump($author->display_name);

			$author['name'] = $user->display_name;
			$author['link'] = get_author_posts_url( $author_id );
			// $author['link'] = get_the_author_link();
			// $author = $this->author;
		}

		return $author;
	}


	function kicker() {
		return LittleSous::kicker($this);
	}


	function facets() {
		if (get_field('h_facets_string', $this->id)) {
			return json_decode(get_field('h_facets_string', $this->id));
		}
	}

/*
	function related() {
        // Post Link Manager
        $pl_manager = new RP4WP_Post_Link_Manager();

        $related_posts = $pl_manager->get_children($this->ID);

        $posts = [];
        foreach ( $related_posts as $related_post ) {
            $posts[] = new LittleSousPost( $related_post->ID );
        }

        return $posts;

        // Get the children
        $related_posts = $pl_manager->get_children( $this->ID, array( 
            'posts_per_page' => 4,
            'post_type' => array('post', 'page'),
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'sponsor-content',
                    'operator' => 'NOT IN'
                ),
            )
        ));

        $posts = [];
        foreach ( $related_posts as $related_post ) {
            $posts[] = new DMagPost( $related_post->ID );
        }

        return $posts;

    }

*/


}