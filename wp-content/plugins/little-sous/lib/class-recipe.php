<?php

class LittleSous_Recipe {
	function __construct() {
		$this->add_hooks();
	}

	function add_hooks() {
		add_action( 'save_post', array($this, 'ingredients') );
		add_action( 'save_post', array($this, 'total_time') );
		add_action( 'save_post', array($this, 'facets') );
		add_action( 'save_post', array($this, 'featured_image') );
	}

	function is_plural($qty, $qty2) {
		if (!$qty) { return false; }
		if ($qty > 1 || ($qty == 1 && $qty2)) { return true; }
		return false;
	}

	function pluralize($unit) {
		$units = [
			"cup"=> "cups",
			"tablespoon"=> "tablespoons",
			"teaspoon"=> "teaspoons",
			"pound"=> "pounds",
			"ounce"=> "ounces",
			"clove"=> "cloves",
			"sprig"=> "sprigs",
			"pinch"=> "pinches",
			"bunch"=> "bunches",
			"slice"=> "slices",
			"gram"=> "grams",
			"head"=> "heads",
			"quart"=> "quarts",
			"stalk"=> "stalks",
			"pint"=> "pints",
			"piece"=> "pieces",
			"stick"=> "sticks",
			"dash"=> "dashes",
			"fillet"=> "fillets",
			"can"=> "cans",
			"ear"=> "ears",
			"package"=> "packages",
			"strip"=> "strips",
			"bulb"=> "bulbs",
			"bottle"=> "bottles",
			"minute"=> "minutes",
			"hour"=> "hours"
		];

		foreach ($units as $key => $plural_unit) {
			if ($unit == $key) {
				return $plural_unit;
				break;
			} elseif ($unit == $plural_unit) {
				return $pluralunit;
				break;
			}
		}
	}

	function fractionalize($top, $bottom) {
		$fraction_glyphs = [
			'12',
			'14',
			'34',
			'18',
			'38',
			'58',
			'78',
			'13',
			'23',
			'15',
			'25',
			'35',
			'45',
			'16',
		];

		$top_bottom = $top . $bottom;

		if (in_array($top_bottom, $fraction_glyphs)) {
			return '<span class="fraction">' . '&frac' . $top . $bottom . ';' . '</span>';
		} else {
			return '<span class="fraction"><span class="fraction-top">' . $top . '</span>' . '/' . '<span class="fraction-bottom">' . $bottom . '</span></span>';
		}

	}

	// take ingredient data and convert into strings
	function ingredients() {
		global $post;

		if (!$post) { return; }

		$ingredient_groups = get_field('ingredient_group', $post->id);

		if ($ingredient_groups) {
			foreach ($ingredient_groups as $i => $ingredient_group) {
				$i = $i + 1;
				$ingredients = $ingredient_group['ingredients'];

				foreach ($ingredients as $n => $ingredient) {
					$n = $n + 1;
					$string = '';
					$string .= $ingredient['quantity_whole_number'] ?? '';

					if ($ingredient['quantity_fraction_top']) {
						$string .= ' ' . $this->fractionalize($ingredient['quantity_fraction_top'], $ingredient['quantity_fraction_bottom']);
					}

					if ($this->is_plural($ingredient['quantity_whole_number'], $ingredient['quantity_fraction_top']) && $ingredient['unit']) {
						$string .= ' ' . $this->pluralize($ingredient['unit']);
					} else if ($ingredient['unit']) {
						$string .= ' ' . $ingredient['unit'];
					}

					$string .= $ingredient['name'] ? ' ' . $ingredient['name'] : '';

					update_sub_field( array('ingredient_group', $i, 'ingredients', $n, 'h_string'), $string );

				}
			}
		}
	}



	function total_time_string($qty, $unit) {
		global $post;
		if (!$post) { return; }

		$id = $post->id;
		$time = '';

		$time_quantity = get_field($qty, $id);
		if (!$time_quantity) { return ''; }

		$time_unit = get_field($unit, $id);

		if ($time_quantity > 1) {
			$time_unit = $this->pluralize($time_unit);
		}

		$time .= $time_quantity;
		$time .= ' ';
		$time .= $time_unit; 

		return $time;
	}


	function total_time() {
		$time = $this->total_time_string('time_quantity', 'time_unit');
		$time2 = $this->total_time_string('time_quantity_2', 'time_unit_2');

		$time = !$time2 ? $time : $time . ' ' . $time2;

		update_field('h_time_string', $time);
	}


	function facets() {
		global $post;
		if (!$post) { return; }

		$post_id = $post->id;

		$facets = get_field('recipe_facets', 'option');
		$facet_fields = [];

		if ($facets) {
			foreach($facets as $facet) {
				$name_slug = $facet['name_slug'];
				$facet_fields = array_merge($facet_fields, get_field($name_slug, $post_id));
			}
			//enocde array so it can be saved in text field
			$facet_fields = json_encode($facet_fields);
			update_field('h_facets_string', $facet_fields);
		}
	}


	function featured_image() {
		global $post;
		if (!$post) { return; }

		if (get_field('hero_image', $post)) {
			set_post_thumbnail( $post, get_field('hero_image', $post) );
		}
	}



}

new LittleSous_Recipe();