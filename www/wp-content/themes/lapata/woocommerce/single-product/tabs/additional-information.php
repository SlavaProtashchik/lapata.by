<?php
/**
 * Additional Information tab
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Характеристики', 'woocommerce' ) );

?>

<?php if ( $heading ): ?>
	<h2><?php printf( $heading.' '.get_the_title() ); ?></h2>
<?php endif; ?>

<?php $product->list_attributes(); ?>
