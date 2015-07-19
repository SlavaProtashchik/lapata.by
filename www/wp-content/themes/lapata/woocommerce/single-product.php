<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="singlecontainer">
	<div class="container">
		<div class="row-container">
		<!-- сайдбар и главный блок -->

			<!-- главный блок -->
			<div class="mainblock">
				<?php woocommerce_breadcrumb(array('delimiter'=>' &rarr; ')); ?>
				<!-- Картинка и большое описание -->
				<div class="image-descr" itemscope itemtype="http://schema.org/Product">
					<div class="imageblock">
						<div class="image-wrap">
						<?php
							if ( has_post_thumbnail() ) {

								$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
								$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
								$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
								$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'single-page-m' ), array(
									'title'	=> $image_title,
									'alt'	=> $image_title
									) );

								$attachment_count = count( $product->get_gallery_attachment_ids() );

								if ( $attachment_count > 0 ) {
									$gallery = '[product-gallery]';
								} else {
									$gallery = '';
								}

								echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );

								} else {

									echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

								}
							?>
						<!-- сюда вставить тумбнэйлы -->
						<div class="thumbcontainer">
							<?php
							$attachment_ids = $product->get_gallery_attachment_ids();

							if ( $attachment_ids ) {
								$loop 		= 0;

								foreach ( $attachment_ids as $attachment_id ) { 
								if ($loop>=8) {break 1;}
								?>
								<div class="imagecontainer">
								<?php
									$classes = array( 'zoom' );

									$image_link = wp_get_attachment_url( $attachment_id );

									if ( ! $image_link )
										continue;

									$image       = wp_get_attachment_image( $attachment_id, 'single-page-xs' );
									$image_class = esc_attr( implode( ' ', $classes ) );
									$image_title = esc_attr( get_the_title( $attachment_id ) );

									echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

									$loop++;

									 ?>
								</div>
								<?php }
							} ?>	
					</div>
						<!--конец тумбнэйлов -->
						</div>
					</div>
					<div class="descrblock">
						<div class="descr-wrap">
							<h1 itemprop="name" class="product_title entry-title"><?php 
							echo '<span class="cat_single">';
							echo get_post_meta( $product->id, 'cat_single', true );
							echo "</span> ";
							the_title(); ?></h1>
							<meta itemprop="model" content="<?php the_title(); ?>" />
							<!-- Рейтинг и количество отзывов -->
							<div class="rate_sku_cont">
								<div class="woocommerce-product-rating" >
								<?php 

								$rating_count = $product->get_rating_count();
								$review_count = $product->get_review_count();
								$average      = $product->get_average_rating();

								if ( $rating_count > 0 ) : ?>
										<div class="star-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
											<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
												<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
												<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
											</span>
										</div>
										<?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' ); ?>)</a><?php endif ?>
								<?php endif; ?>
								</div>
								<!-- Конец рейтинга и количества отзывов -->
								<div class="sku">
									<?php echo "Код товара:&nbsp;<strong>";
									echo $product->get_sku();
									echo "</strong>";
									?>
								</div>
							</div>
							<?php 
							$product_id = get_the_ID();
							if (get_post_meta( $product_id, 'warranty', true )<>"") { ?>	
							<div class="warranty">
									<?php
									echo "Гарантия: <span class='bold'>".get_post_meta( $product_id, 'warranty', true ); 
									echo "</span>"?>	

							</div>
							<?php } ?>
							<!-- Описание большое-->
							<p class="description"><?php echo get_the_content(); ?></p>
							<!-- Конец описание большое -->

							<div class="wrapper">
								<div class="leftblock">
									<!-- Цена -->
									<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

										<p class="price"><?php echo $product->get_price_html(); ?></p>

										<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
										<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
										<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

									</div>
									
									<!-- Конец цена -->
									<!-- наличие товара на складе -->
									<?php if ( $product->is_in_stock() ) {
										$class="in-stock";
										$mes="<span>в наличии</span>";
									} else {
										$class="out-of-stock";
										$mes="<span>отсутствует</span>";								
									}

									echo '<div class="'.$class.'" >';
									include(dirname(__FILE__)."/../images/".$class.".svg"); //вставляем svg картинку
									echo $mes.'</div>';
									?>
									<!-- конец наличия товара на складе-->
								</div>
								<div class="rightblock">
									<?php
										$disabled="";
										if (!$product->is_in_stock()) {$disabled="disabled";}
									?>
									<?php
									//кнопка быстрого чекаута
									$productid = $product->id;
									$form = '<form data-productid="'.$productid.'" id="wc_quick_buy_'.$productid.'" class="wc_quick_buy_form wc_quick_buy_form_'.$productid.'" method="post" enctype="multipart/form-data">
									<input  type="hidden" value="1" name="quantity" id="quantity">
									<input  type="hidden" value="true" name="quick_buy" />
									<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
									<button data-productid="'.$productid.'" type="submit" class="wc_quick_buy_product_'.$productid.' quick_buy_'.$productid.'  wc_quick_buy_btn '.$disabled.'">Заказать</button>
									</form>';
									echo $form;
									?>

									<!-- Кнопка добавить в корзину -->
									<div class="buttoncont">
									<?php
									echo apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button_sp %s product_type_%s %s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( $product->id ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
											esc_attr( $product->product_type ),
											esc_attr( $disabled ),
											esc_html( 'В корзину' )
										),
									$product );
									?>
								</div>
				
								</div>
								<!-- Конец кнопки добавить в корзину -->
							</div>
							<?php 
							$product_id = get_the_ID();
							if (get_post_meta( $product_id, 'manufacturer_addr', true )<>"") { ?>	
							<div class="manufacturer">
									<?php
									echo "Производитель: ".get_post_meta( $product_id, 'manufacturer_addr', true ); ?>					
							</div>
							<?php } ?>
						<?php //social buttons
							echo do_shortcode("[getsocial app='sharing_bar']");
						?>
						</div>
					</div>
				</div>
				<!-- Конец картинки и большого описания -->

				
				<div class="reldescrrow">
					<div class="descr-reviews">
						<div class="descr-reviews-wrap">

						<?php
						$tabs = apply_filters( 'woocommerce_product_tabs', array() );

						if ( ! empty( $tabs ) ) : ?>

							<div class="woocommerce-tabs">
								<ul class="tabs nav nav-pills">
									<?php foreach ( $tabs as $key => $tab ) : ?>

										<li role="presentation" class="<?php echo $key ?>_tab">
											<a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
										</li>

									<?php endforeach; ?>
								</ul>
								<?php foreach ( $tabs as $key => $tab ) : ?>

									<div class="panel entry-content" id="tab-<?php echo $key ?>">
										<?php call_user_func( $tab['callback'], $key, $tab ) ?>
									</div>

								<?php endforeach; ?>
							</div>

						<?php endif; ?>




						</div>
					</div>
					<div class="related-prod">
						
						<?php
						$posts_per_page=3; //количество товаров на странице
						$related = $product->get_related( $posts_per_page );

						if ( sizeof( $related ) <> 0 ) {;

						$args = apply_filters( 'woocommerce_related_products_args', array(
							'post_type'            => 'product',
							'ignore_sticky_posts'  => 1,
							'no_found_rows'        => 1,
							'posts_per_page'       => $posts_per_page,
							'orderby'              => $orderby,
							'post__in'             => $related,
							'post__not_in'         => array( $product->id )
						) );

						$products = new WP_Query( $args );

						$woocommerce_loop['columns'] = $columns;

						if ( $products->have_posts() ) : ?>

							

								<h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>

								<?php woocommerce_product_loop_start(); ?>

									<?php while ( $products->have_posts() ) : $products->the_post(); ?>

										<div class="prod-wrap">
											<div class="border-wrap">
										<figure>
										
										<div class="imagecontainer">
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										    <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'single-page-s'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="120px" height="80px" />'; ?>
											</a>
										</div>
										<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
										<p class="price"><?php echo $product->get_price_html(); ?></p>
										
										</figure>
										</div>
										</div>



									<?php endwhile; // end of the loop. ?>

								<?php woocommerce_product_loop_end(); ?>

							

						<?php endif;

						wp_reset_postdata();
					}
						?>
						
					</div>
				</div>




			</div>
			<!-- конец главного блока -->
			<!-- сайдбар -->
			<div class="sidebar">
				<?php if ( is_active_sidebar( 'page-sidebar-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'page-sidebar-widget-area' ); ?>
				<?php endif; ?>				

			</div>
			<!-- конец сайдбара -->
		<!-- конец сайдбар и главный блок -->
		</div>
	</div>
</div>

		


		<?php endwhile; // end of the loop. ?>


<?php get_footer( 'shop' ); ?>
