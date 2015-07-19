<?php 

while ( $loop_var->have_posts() ) {
	$loop_var->the_post(); 
	global $product; ?>

<div class="line_item">   
  <?php 
  if ($product->sale_price) {
  $discount = floor(100-$product->sale_price/$product->regular_price*100);
  $red = $discount >= 10;
   } 
  ?>
<div class="discount  <?php if(!$product->sale_price) echo 'not-visible';?> <?php if($red) echo 'red';?>">
  <?php 
  if ($product->sale_price) {
  echo $discount.' %'; } 
  ?>
</div>
<div class="mix-container"> 
      <figure>
      <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<div class="imagecontainer">
          <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />'; ?>
    </div>
          <h3><?php echo textFunc(get_the_title(), 50,'...'); ?></h3>
      </a>
      <p class="price"><?php echo $product->get_price_html(); ?></p>

      </figure>
    </div>
</div>
<?php } ?>
