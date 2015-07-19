<?php 
require_once ('layout_grid.php');




$i=0;
$params=$layout_items; //задает располодение
while ( $loop_var->have_posts() ) {
	$loop_var->the_post(); 
	global $product; 

  if (substr($params, $i, 1)=="5") {
    echo template_5($product, $show_rating); }
  if (substr($params, $i, 1)=="4") {
    echo template_4($product, $show_rating); } 
  if (substr($params, $i, 1)=="3") {
    echo template_3($product, $show_rating); } 
  if (substr($params, $i, 1)=="0") {
    echo template_0($product, $show_rating); } 

  $i++;
} ?>

<!--
<div class="line_item">    
      <figure>
        <?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
      <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    
          <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />'; ?>

          <h3><?php the_title(); ?></h3>
      </a>
      <p class="price"><?php echo $product->get_price_html(); ?></p>

      </figure>
</div> -->

