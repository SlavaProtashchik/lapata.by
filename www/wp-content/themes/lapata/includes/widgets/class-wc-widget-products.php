<?php

require_once ('register_layout_types.php');

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * List products. One widget to rule them all.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class Custom_WC_Widget_Products extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_products';
		$this->widget_description = __( 'Display a list of your products on your site.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_products';
		$this->widget_name        = __( '!WooCommerce Products', 'woocommerce' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Products', 'woocommerce' ),
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
			'show' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => __( 'Show', 'woocommerce' ),
				'options' => array(
					''         => __( 'All Products', 'woocommerce' ),
					'featured' => __( 'Featured Products', 'woocommerce' ),
					'onsale'   => __( 'On-sale Products', 'woocommerce' ),
				)
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'date'   => __( 'Date', 'woocommerce' ),
					'price'  => __( 'Price', 'woocommerce' ),
					'rand'   => __( 'Random', 'woocommerce' ),
					'sales'  => __( 'Sales', 'woocommerce' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'desc',
				'label' => _x( 'Order', 'Sorting order', 'woocommerce' ),
				'options' => array(
					'asc'  => __( 'ASC', 'woocommerce' ),
					'desc' => __( 'DESC', 'woocommerce' ),
				)
			),
			'hide_free' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide free products', 'woocommerce' )
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show hidden products', 'woocommerce' )
			),
			'show_out_of_stock' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Показывать отсутствующие товары', 'woocommerce' )
			),
			'layout' => array(
				'type'  => 'select',
				'label' => __( 'Внешний вид', 'woocommerce' ),
				'options' => array(
                    'linear' => __( 'Линейная', 'woocommerce' ),
                    'mix1'  => __( 'Плитки 1', 'woocommerce' ),
                /*    'mix2'  => __( 'Плитки 2', 'woocommerce' ), */
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
	 * Query the products and return them
	 * @param  array $args
	 * @param  array $instance
	 * @return WP_Query
	 */
	public function get_products( $args, $instance ) {
		$number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$show    = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$orderby = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order   = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
		$show_out_of_stock = '';
		if ( empty( $instance['show_out_of_stock'] ) ) {
			$show_out_of_stock = 	array(
					    'key'       => '_stock_status',
					    'value'     => 'outofstock',
					    'compare'   => 'NOT IN'
					);
		}

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array( $show_out_of_stock)
		);

		if ( empty( $instance['show_hidden'] ) ) {
			$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			$query_args['post_parent']  = 0;
		}


		if ( ! empty( $instance['hide_free'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
		$query_args['meta_query']   = array_filter( $query_args['meta_query'] );

		switch ( $show ) {
			case 'featured' :
				$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
		}

		switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
		}

		return new WP_Query( $query_args );
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {
			$this->widget_start( $args, $instance );

			//выбираем шаблон
			$templ=choose_template($instance['layout'],$instance['number']);

			wc_get_template( $templ, array( 'show_rating' => true,'loop_var'=>$products,'layout_items'=>$instance['layout_items'] ) );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo $this->cache_widget( $args, ob_get_clean() );
	}
}
