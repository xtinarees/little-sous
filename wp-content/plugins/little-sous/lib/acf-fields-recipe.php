<?php

add_filter('init', 'acf_load_recipe_facets');


function acf_recipe_facet_fields($name, $name_slug, $choices) {
	return
	array (
		'key' => 'field_' . $name_slug,
		'label' => $name,
		'name' => $name_slug,
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '33.33',
			'class' => '',
			'id' => '',
		),
		'choices' => $choices,
		'default_value' => array (
		),
		'return_format' => 'array',
		'allow_null' => 0,
		'multiple' => 1,
		'ui' => 1,
		'ajax' => 1,
		'placeholder' => '',
		'disabled' => 0,
		'readonly' => 0,
	);
}

function acf_load_recipe_facets() {
	$i = 0;

	$facets = get_field('recipe_facets', 'option');
	$facet_fields = [];

	foreach($facets as $facet) {

		$name = $facet['name'];
		$name_slug = $facet['name_slug'];
		$items = $facet['items'];
		$choices = [];

		foreach($items as $item) {
			$choices[$item['slug']] = $item['label'];
		}

		$facet_fields[] =  acf_recipe_facet_fields($name, $name_slug, $choices);

	}

	if( function_exists('acf_add_local_field_group') ):
		acf_add_local_field_group(array (
			'key' => 'group_facets',
			'title' => 'Facets',
			'fields' => $facet_fields,
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'recipe',
					),
				),
			),
			'menu_order' => 3,
			'position' => 'normal',
			'style' => 'normal',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
	endif;
}



if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_recipe',
	'title' => 'Recipe',
	'fields' => array (
		array (
			'key' => 'field_tab_info',
			'label' => 'Info',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'default_value' => '',
			'min' => '',
			'max' => '',
			'step' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_time_quantity',
			'label' => 'Time',
			'name' => 'time_quantity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '25',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'multiple' => 0,
			'allow_null' => 1,
			'choices' => array (
				'minute' => 'minute',
				'hour' => 'hour',
			),
			'default_value' => array (
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_time_unit',
			'label' => 'Time Unit',
			'name' => 'time_unit',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '25',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'min' => '',
			'max' => '',
			'step' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_time_quantity_2',
			'label' => 'Time 2',
			'name' => 'time_quantity_2',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '25',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'multiple' => 0,
			'allow_null' => 1,
			'choices' => array (
				'minute' => 'minute',
				'hour' => 'hour',
			),
			'default_value' => array (
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_time_unit_2',
			'label' => 'Time Unit 2',
			'name' => 'time_unit_2',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '25',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_time_string',
			'label' => 'Time String',
			'name' => 'h_time_string',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_yield',
			'label' => 'Yield',
			'name' => 'yield',
			'type' => 'text',
			'instructions' => 'ex: "4-8 servings"',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		// array (
		// 	'default_value' => '',
		// 	'maxlength' => '',
		// 	'placeholder' => '',
		// 	'prepend' => '',
		// 	'append' => '',
		// 	'key' => 'field_tip',
		// 	'label' => 'Tip',
		// 	'name' => 'tip',
		// 	'type' => 'text',
		// 	'instructions' => '',
		// 	'required' => 0,
		// 	'conditional_logic' => 0,
		// 	'wrapper' => array (
		// 		'width' => '',
		// 		'class' => '',
		// 		'id' => '',
		// 	),
		// ),

		array (
			'key' => 'field_tab_ingredients',
			'label' => 'Ingredients',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),

		array (
			'sub_fields' => array (
				array (
					'default_value' => '',
					'maxlength' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'key' => 'field_ingredient_group_title',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => 'This text is displayed above a group of ingriendients.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
				),
				array (
					'sub_fields' => array (
						array (
							'default_value' => '',
							'min' => '',
							'max' => '',
							'step' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'key' => 'field_59e571e9574c6',
							'label' => 'Quantity',
							'name' => 'quantity_whole_number',
							'type' => 'number',
							'instructions' => 'Whole Number',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '10',
								'class' => '',
								'id' => '',
							),
						),
						array (
							'default_value' => '',
							'min' => '',
							'max' => '',
							'step' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'key' => 'field_59e57222574c7',
							'label' => 'Quantity',
							'name' => 'quantity_fraction_top',
							'type' => 'number',
							'instructions' => 'Fraction Top',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '10',
								'class' => '',
								'id' => '',
							),
						),
						array (
							'default_value' => '',
							'min' => '',
							'max' => '',
							'step' => '',
							'placeholder' => '',
							'prepend' => '/',
							'append' => '',
							'key' => 'field_59e57247574c8',
							'label' => 'Quantity',
							'name' => 'quantity_fraction_bottom',
							'type' => 'number',
							'instructions' => 'Fraction Bottom',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '10',
								'class' => '',
								'id' => '',
							),
						),
						array (
							'multiple' => 0,
							'allow_null' => 1,
							'choices' => array (
								'cup' => 'cup',
								'tablespoon' => 'tablespoon',
								'teaspoon' => 'teaspoon',
								'bottle' => 'bottle',
								'bulb' => 'bulb',
								'bunch' => 'bunch',
								'can' => 'can',
								'clove' => 'clove',
								'dash' => 'dash',
								'ear' => 'ear',
								'fillet' => 'fillet',
								'gram' => 'gram',
								'head' => 'head',
								'ounce' => 'ounce',
								'package' => 'package',
								'piece' => 'piece',
								'pinch' => 'pinch',
								'pint' => 'pint',
								'pound' => 'pound',
								'quart' => 'quart',
								'slice' => 'slice',
								'sprig' => 'sprig',
								'stalk' => 'stalk',
								'stick' => 'stick',
								'strip' => 'strip',
							),
							'default_value' => array (
							),
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'return_format' => 'value',
							'key' => 'field_59e5718e574c5',
							'label' => 'Unit',
							'name' => 'unit',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '20',
								'class' => '',
								'id' => '',
							),
						),
						array (
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'key' => 'field_59e572b2574c9',
							'label' => 'Name',
							'name' => 'name',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array (
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'key' => 'field_ingredient_string',
							'label' => 'String',
							'name' => 'h_string',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '0',
								'class' => '',
								'id' => '',
							),
						),
					),
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => 'Add Ingredient',
					'collapsed' => '',
					'key' => 'field_ingredients',
					'label' => 'Ingredients',
					'name' => 'ingredients',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
				),
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Ingredient Group',
			'collapsed' => '',
			'key' => 'field_ingredient_group',
			'label' => 'Ingredient Group',
			'name' => 'ingredient_group',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),


		array (
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_facets_string',
			'label' => 'Facets String',
			'name' => 'h_facets_string',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipe',
			),
		),
	),
	'menu_order' => 2,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));



endif;



