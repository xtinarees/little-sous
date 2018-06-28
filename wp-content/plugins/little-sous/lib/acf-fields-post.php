<?php

function my_acf_admin_head() {
	?>
	<script type="text/javascript">
	(function($) {
		
		$(document).ready(function(){
			$('.acf-field-content-placeholder .acf-input').append( $('#postdivrich') );
			$('.acf-field-author-placeholder .acf-input').append( $('#authordiv') );
			$('.acf-field-featured-image-placeholder .acf-input').append( $('#postimagediv') );
		});
		
	})(jQuery);
	</script>
	<style type="text/css">
		.acf-field #wp-content-editor-tools {
			background: transparent;
			padding-top: 0;
		}
	</style>
	<?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head', 50);

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_featured',
	'title' => 'Featured',
	'fields' => array (
		array (
			'key' => 'field_is_featured',
			'label' => 'Featured',
			'name' => 'is_featured',
			'type' => 'true_false',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		// array (
		// 	'key' => 'field_is_featured_homepage',
		// 	'label' => 'Featured on Homepage',
		// 	'name' => 'is_featured_homepage',
		// 	'type' => 'true_false',
		// 	'value' => NULL,
		// 	'instructions' => '',
		// 	'required' => 0,
		// 	'conditional_logic' => '',
		// 	'wrapper' => array (
		// 		'width' => '',
		// 		'class' => '',
		// 		'id' => '',
		// 	),
		// 	'message' => '',
		// 	'default_value' => 0,
		// 	'ui' => 1,
		// 	'ui_on_text' => '',
		// 	'ui_off_text' => '',
		// ),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipe',
			),
		),
	),
	'menu_order' => 10,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_sponsored',
	'title' => 'Sponsored',
	'fields' => array (
		array (
			'key' => 'field_is_sponsored',
			'label' => '',
			'name' => 'is_sponsored',
			'type' => 'true_false',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 10,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_subhead',
	'title' => 'Subhead',
	'fields' => array (
		array (
			'key' => 'field_subhead',
			'label' => 'Subhead',
			'name' => 'subhead',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipe',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_content',
	'title' => 'Content',
	'fields' => array (
		array (
			'key' => 'field_tab_main',
			'label' => 'Main',
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
			'key' => 'field_content_placeholder',
			'label' => 'Content',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 100,
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'esc_html' => 0,
		),
		array (
			'key' => 'field_tab_steps',
			'label' => 'Steps',
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
					'key' => 'field_step',
					'label' => 'Step',
					'name' => 'step',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
				),
				array(
					'key' => 'field_button_tip',
					'label' => '',
					'name' => 'button_tip',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Tip Included',
					'ui_off_text' => 'Include Tip',
				),
				array (
					'key' => 'field_tip',
					'label' => 'Tip',
					'name' => 'tip',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_button_tip',
								'operator' => '==',
								'value' => 1,
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 0,
				),
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Step',
			'collapsed' => '',
			'key' => 'field_steps',
			'label' => 'Steps',
			'name' => 'steps',
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
		/// enddd
		array (
			'key' => 'field_tab_pull_quotes',
			'label' => 'Pull Quotes',
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
					'key' => 'field_pull_quote',
					'label' => 'Pull Quote',
					'name' => 'pull_quote',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 1,
				),
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add New Pull Quote',
			'collapsed' => '',
			'key' => 'field_pull_quotes',
			'label' => '',
			'name' => 'pull_quotes',
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
		/// enddd
		array (
			'key' => 'field_tab_images',
			'label' => 'Images',
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
			'key' => 'field_hero_image',
			'label' => 'Hero Image',
			'name' => 'hero_image',
			'type' => 'image',
			'instructions' => 'Image that appears at the top of the recipe / post',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_featured_image_placeholder',
			'label' => '',
			'name' => '',
			'type' => 'message',
			'instructions' => 'Image that appears in the feed. If no featured image is set, this field will inherit the hero image',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'esc_html' => 0,
		),
		array (
			'sub_fields' => array (
				array (
					'key' => 'field_slide_image',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 20,
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_slide_caption',
					'label' => 'Caption',
					'name' => 'caption',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 80,
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 0,
				),
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Add Slide',
			'collapsed' => '',
			'key' => 'field_slideshow',
			'label' => 'Slideshow',
			'name' => 'slideshow',
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
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipe',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

// acf_add_local_field_group(array (
// 	'key' => 'group_slideshow',
// 	'title' => 'Slideshow',
// 	'fields' => array (
// 		array (
// 			'key' => 'field_slides',
// 			'label' => 'Slides',
// 			'name' => 'slides',
// 			'type' => 'repeater',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array (
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'collapsed' => '',
// 			'min' => '',
// 			'max' => '',
// 			'layout' => 'table',
// 			'button_label' => 'Add Slide',
// 			'sub_fields' => array (
// 				array (
// 					'key' => 'field_slide_image',
// 					'label' => 'Image',
// 					'name' => 'image',
// 					'type' => 'image',
// 					'instructions' => '',
// 					'required' => 0,
// 					'conditional_logic' => 0,
// 					'wrapper' => array (
// 						'width' => 25,
// 						'class' => '',
// 						'id' => '',
// 					),
// 					'return_format' => 'id',
// 					'preview_size' => 'thumbnail',
// 					'library' => 'all',
// 					'min_width' => '',
// 					'min_height' => '',
// 					'min_size' => '',
// 					'max_width' => '',
// 					'max_height' => '',
// 					'max_size' => '',
// 					'mime_types' => '',
// 				),
// 				array (
// 					'key' => 'field_slide_caption',
// 					'label' => 'Caption',
// 					'name' => 'caption',
// 					'type' => 'wysiwyg',
// 					'instructions' => '',
// 					'required' => 0,
// 					'conditional_logic' => 0,
// 					'wrapper' => array (
// 						'width' => 75,
// 						'class' => '',
// 						'id' => '',
// 					),
// 					'default_value' => '',
// 					'tabs' => 'all',
// 					'toolbar' => 'basic',
// 					'media_upload' => 0,
// 				),
// 			),
// 		),
// 	),
// 	'location' => array (
// 		array (
// 			array (
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'post',
// 			),
// 		),
// 	),
// 	'menu_order' => 3,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'top',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => 1,
// 	'description' => '',
// ));


acf_add_local_field_group(array (
	'key' => 'group_author',
	'title' => 'Author',
	'fields' => array (
		array (
			'key' => 'field_author_placeholder',
			'label' => 'Byline',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 100,
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'esc_html' => 0,
		),
		array (
			'key' => 'field_byline_override',
			'label' => 'Byline Override',
			'name' => 'byline_override',
			'type' => 'text',
			'instructions' => 'This field overrides the post author. Use it when there is no user account for the author of a post.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipe',
			),
		),
	),
	'menu_order' => 6,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));


acf_add_local_field_group(array (
	'key' => 'group_linked_recipes',
	'title' => 'Linked Recipes',
	'fields' => array (
		array (
			'sub_fields' => array (
				array (
					'post_type' => array (
						0 => 'recipe',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
					'key' => 'field_recipe',
					'label' => 'Recipe',
					'name' => 'recipe',
					'type' => 'post_object',
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
			'layout' => 'table',
			'button_label' => 'Add Recipe',
			'collapsed' => '',
			'key' => 'field_recipes',
			'label' => 'Recipes',
			'name' => 'recipes',
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
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 10,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));


endif;