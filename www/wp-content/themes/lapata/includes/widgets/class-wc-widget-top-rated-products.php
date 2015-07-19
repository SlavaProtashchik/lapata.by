<?php

require_once ('register_layout_types.php');

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Top Rated Products Widget
 *
 * Gets and displays top rated products in an unordered list
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class Custom_WC_Widget_Top_Rated_Products extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_top_rated_products';
		$this->widget_description = __( 'Display a list of your top rated products on your site.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_top_rated_products';
		$this->widget_name        = __( '!WooCommerce Top Rated Products', 'woocommerce' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Top Rated Products', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of products to show', 'woocommerce' )
			),
			'layout' => array(
				'type'  => 'select',
				'label' => __( 'Внешний вид', 'woocommerce' ),
				'options' => array(
                    'linear' => __( 'Линейная', 'woocommerce' ),
                    'mix1'  => __( 'Плитки 1', 'woocommerce' ),
                   /* 'mix2'  => __( 'Плитки 2', 'woocommerce' ), */
                    'default'  => __( 'Стандартная', 'woocommerce' )
                )
			),
			'layout_items' => array(
				'type'  => 'text',
				'label' => __( 'Расположение плиток (только для mix)', 'woocommerce' ),
				'std'   => '453345'
			),
			'note' => array(
				'label' => __( 'layout от 3 до 5. 3 - для мобил 6, 0 - тот же 3 но для мобил 12', 'woocommerce' ),
				'type'  => 'text',
				'std'   => 'Ничего не вводить'
			)
		);

		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

		add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );

	/*	if ( empty( $instance['show_out_of_stock'] ) ) {
			$show_out_of_stock = 	array(
					    'key'       => '_stock_status',
					    'value'     => 'outofstock',
					    'compare'   => 'NOT IN'
					);
		} */
		$query_args = array( 'posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
		//$query_args = array( 'posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'meta_query' => array( $show_out_of_stock));

		$query_args['meta_query'] = WC()->query->get_meta_query();

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			$this->widget_start( $args, $instance );

			//выбираем шаблон
			$templ=choose_template($instance['layout'],$instance['number']);

			wc_get_template( $templ, array( 'show_rating' => true,'loop_var'=>$r,'layout_items'=>$instance['layout_items'] ) );

			$this->widget_end( $args );
		}

		remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
