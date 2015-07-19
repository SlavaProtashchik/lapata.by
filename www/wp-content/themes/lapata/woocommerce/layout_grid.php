<?php
require_once ('custom_functions.php');

function template_5($product , $show_rating) { ?>

<div class='_5line'>
  <div class="mix-container">
  <figure>
    <div class="imagecontainer">

<?php 
if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page-m'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />';
?>

    </div>
  <div class="descrcontainer">
    <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3>
<?php 
the_title(); ?>
  </h3></a>
  <div class="starscontainer">
	       <?php 
        if ( ! empty( $show_rating ) ) {
          if ($product->get_rating_html() =="") {echo "<p>без рейтинга</p>";} 
            else {echo $product->get_rating_html();}
        } 
        ?>
  </div>
  <p class="price">
<?php 
echo $product->get_price_html(); ?>
  
  </p>
</div>
</figure>
</div>
</div>
<?php 
}

function template_4($product , $show_rating) {
?>

<div class='_4line'>
  <div class="mix-container">
  <figure>
  	<a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3>
  <?php echo textFunc(get_the_title(),70,'...'); ?>
  </h3>
    <div class="imagecontainer">

<?php 
if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page-m'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />';
?>

    </div>
  <div class="descrcontainer">
    <div class="starscontainer">
         <?php 
        if ( ! empty( $show_rating ) ) {
          if ($product->get_rating_html() =="") {echo "<p>без рейтинга</p>";} 
            else {echo $product->get_rating_html();}
        } 
        ?>
  </div>

  <?php if ( $product->is_in_stock() ) {
    //наличие товара на складе -->
    $class="in-stock";
    $mes="<span>в наличии</span>";
  } else {
    $class="out-of-stock";
    $mes="<span>отсутствует</span>";                
  }

  echo '<div class="'.$class.'" >';
  include(dirname(__FILE__)."/../images/".$class.".svg"); //вставляем svg картинку
  echo $mes.'</div>';
  //конец наличия товара на складе-->
  ?>
      
  <p class="price">
<?php 
echo $product->get_price_html(); ?>

  </p>
</div>
</a>
</figure>
</div>
</div>
<?php 
}

function template_3($product , $show_rating) {
?>

<div class='_3line'>
  <div class="mix-container">
  <figure>
  	<a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3>
  <?php echo textFunc(get_the_title(),30,'...'); ?>
  </h3>
    <div class="imagecontainer">

<?php 
if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page-xs'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />';
?>

    </div>

    <p class="price">
<?php 
echo $product->get_price_html(); ?>

  </p>
 </a>
</figure>
</div>
</div>
<?php 
}

function template_0($product , $show_rating) {
?>

<div class='_0line'>
  <div class="mix-container">
  <figure>
    <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3>
<?php 
the_title(); ?>
  </h3>
    <div class="imagecontainer">

<?php 
if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'main-page-xs'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="204px" height="136px" />';
?>

    </div>

    <p class="price">
<?php 
echo $product->get_price_html(); ?>

  </p>
 </a>
</figure>
</div>
</div>
<?php 
}
?>