<?php get_header(); ?>

<div class="archive-sidebar">
	<div class="container">
		<div class="row-container">
			<div class="archive">
				<?php woocommerce_breadcrumb(array('delimiter'=>' &rarr; ')); ?>
				
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

				<?php endif; ?>
				<!-- зона виджетов -->
				<?php if ( is_active_sidebar( 'catalog-underheader-upperprodlist-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'catalog-underheader-upperprodlist-widget-area' ); ?>
				<?php endif; ?>						
				
				<?php $term = get_queried_object()->term_id;
				//$termid = get_term($term, 'product_cat' );
				$children = get_term_children($term, 'product_cat');
				//echo sizeof($children);
				if(sizeof($children) == 0) { ?>
				<!-- фильтр товаров-->
				<div class="filterzone">
					<?php
					if (! is_search() ) {
						if ( is_post_type_archive( 'product' ) || is_tax( array( 'product_cat', 'product_tag' ) ) ) {
							$args = array(); 
							$output = 'objects'; // or objects
							$taxonomies = get_taxonomies($args, $output); 

							foreach ( $taxonomies as $taxonomy ) {

								if (substr($taxonomy->name, -2) == "__") {
									$name_cut=str_replace( 'pa_', '', $taxonomy->name);

									 the_widget(
										'Custom_WC_Widget_Layered_Nav',
										array(
											'title' => $taxonomy->label,
											'attribute' => $name_cut,
											'query_type' => 'and',
											'display_type' => 'dropdown'
										),
										array(
											'before_widget' => '<div class="filter_widget">',
										    'after_widget' => '</div>',
										    'before_title' => '<span>',
										    'after_title' => '</span>',
										)
									);
								}
							}
						} 
					}?>
				</div>

				<!-- зона для виджета сортировки по цене и активных фильтров -->
				<div class="price_act_cont">
					<?php if ( is_active_sidebar( 'catalog-underheader-upperprodlist-widget-area-price-filter' ) ) : ?>
						<?php dynamic_sidebar( 'catalog-underheader-upperprodlist-widget-area-price-filter' ); ?>
					<?php endif; ?>		
					<?php	the_widget(
										'Custom_WC_Widget_Layered_Nav_Filters',
										array(
											'title' => 'Активные фильтры'
										),
										array(
											'before_widget' => '<div class="active_filters">',
										    'after_widget' => '</div>',
										    'before_title' => '<span class="title">',
										    'after_title' => '</span>',
										)
									);  ?>
				</div>
				<?php } ?>
				<!-- конец зоны виджетов сортировки <-->

				<?php if ( have_posts() ) : ?>
					
					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>
				
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<p class="woocommerce-info"><?php _e( 'По вашему запросу ничего не найдено :(', 'woocommerce' ); ?></p>
					
				<?php endif; ?>

			</div>
			<div class="sidebar hidden-xs hidden-sm hidden-md">
				<!-- зона виджетов сайдбара страницы каталога -->
				<?php if ( is_active_sidebar( 'catalog-sidebar-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'catalog-sidebar-widget-area' ); ?>
				<?php endif; ?>				
				<!-- конец зона виджетов сайдбара страницы каталога -->

			</div>
			<div class="navigation">
				<?php
					global $wp_query;

					if ( $wp_query->max_num_pages > 1 ) {	
					?>
					<nav class="woocommerce-pagination">
						<?php
							echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
								'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
								'format'       => '',
								'add_args'     => '',
								'current'      => max( 1, get_query_var( 'paged' ) ),
								'total'        => $wp_query->max_num_pages,
								'prev_text'    => '&larr;',
								'next_text'    => '&rarr;',
								'type'         => 'list',
								'end_size'     => 3,
								'mid_size'     => 3
							) ) );
						?>
					</nav> 
					<?php } ?>
			</div>
			<div class="description">
				<?php
				echo category_description( );
			//	echo tag_description();
			//	echo "1212";
				?>
			</div>
			<div class="sidebar hidden-lg">
				<!-- зона виджетов сайдбара страницы каталога -->
				<?php if ( is_active_sidebar( 'catalog-sidebar-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'catalog-sidebar-widget-area' ); ?>
				<?php endif; ?>				
				<!-- конец зона виджетов сайдбара страницы каталога -->

			</div>
		</div>
	</div>
</div>
<?php get_footer();?>