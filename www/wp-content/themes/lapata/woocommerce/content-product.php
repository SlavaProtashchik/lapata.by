<?php 
//require_once ('custom_functions.php');
?>
<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	//$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 1 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
/*$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last'; */
?>
<figure>
    <div class="product-block">
        <!--<?php //do_action( 'woocommerce_before_shop_loop_item' ); ?> -->
            <div class="imagecontainer">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'archive-page-m'); else echo '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" width="150px" height="100px" />'; ?>
                </a>
            </div>
            <div class="descrcontainer">
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                <?php $alt=1; ?>
                <div class="shortparams">
                    <?php
                    $attributes = $product->get_attributes();
                    $attributes = array_filter($attributes, function($attr){
                        return (mb_substr($attr['name'],-2)=="__");
                    });
                    array_slice($attributes, 5);
                    ?>
                    <?php if ($attributes ) : ?>
                        <?php foreach ( $attributes as $attribute ) : ?>
                            <div class="shortparams-row <?php if ( ( $alt = $alt * -1 ) <> 1 ) echo 'alt'; ?>">
                                <div class="shortparams-cell">
                                    <?php echo wc_attribute_label( $attribute['name'] ) . ': '; ?>
                                </div>
                                <div class="shortparams-cell">
                                    <?php if ( $attribute['is_taxonomy'] ) : ?>
                                        <?php $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) ); ?>
                                        <?php echo  apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ), $attribute, $values ); ?>
                                    <?php  else : ?>
                                        <?php $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) ); ?>
                                        <?php echo apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ) , $attribute, $values ); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pricecontainer">
                <p class="price"><?php echo $product->get_price_html(); ?></p>

                <div class="starscontainer">
                <?php
                    if ($product->get_rating_html() =="") {echo "<p>без рейтинга</p>";}
                    else {echo $product->get_rating_html();}
                ?>

                </div>

                <div class="button-container">
                <?php
                $disabled="";
                if (!$product->is_in_stock()) {$disabled="disabled";}
                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s %s">%s</a>',
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
            </div>
    </div>
</figure>
