<?php

class LittleSousRecipe extends TimberPost {

	function kicker() {
		return LittleSous::kicker($this);
	}


	function facets() {
		return json_decode(get_field('h_facets_string', $this->id));
	}

}