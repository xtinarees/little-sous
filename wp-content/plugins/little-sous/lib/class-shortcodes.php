<?php


class LittleSous_Shortcodes {

	function __construct() {
		$this->add_hooks();
	}

	function add_hooks() {
		add_action( 'init', array( $this, 'init_shortcodes' ) );
	}



	/**
	 * Register custom shortcodes
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public function init_shortcodes() {

		add_action( 'register_shortcode_ui', array( $this, 'shortcode_ui_pullquotes_shortcode' ) );
		add_shortcode( 'pull_quote' , array( $this, 'pull_quote_shortcode' ) );

	} //end public static function init_shortcodes




	function shortcode_ui_pullquotes_shortcode() {
		shortcode_ui_register_for_shortcode( 'pull_quote',
			array(
				'label' => esc_html__( 'Pull Quotes', 'dmagazine' ),
				'listItemImage' => 'dashicons-editor-quote',
				'post_type' => array( 'post', 'page' ),
				'attrs' => array(
					array(
						'label'  => esc_html__( 'Pull Quote Id', 'dmagazine' ),
						'attr'   => 'id',
						'type'   => 'number',
						'encode' => false,
						'meta'   => array(
							'placeholder' => esc_html__( 'ID Number', 'dmagazine' ),
							'data-test'   => 1,
						),
					),
				),
			)
		);
	}

	public function pull_quote_shortcode( $atts, $text = null ) {

		global $post;

		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );

		$pull_quotes = get_field('pull_quotes');

		$pull_quote_id = 0;

		if ( isset( $id ) ) {
			$pull_quote_id = $id-1;
		}

		$pull_quote = $pull_quotes[$pull_quote_id];

		// return '<blockquote class="pull-quote alignleft"><span>'.$pull_quote['quote'].'</span><span class="pull-quote__attribution">'.$pull_quote['attribution'].'</span></blockquote>';
		
		return '<blockquote class="pull-quote"><span>'.$pull_quote['pull_quote'].'</span></blockquote>';


	}






} //end class LittleSous_Shortcodes

new LittleSous_Shortcodes;