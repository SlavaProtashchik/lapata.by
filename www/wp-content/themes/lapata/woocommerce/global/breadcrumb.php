<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( $breadcrumb ) {

	echo $wrap_before;

	if (is_product_category() || is_product_tag()) {
		if (sizeof( $breadcrumb ) == 2) {
				//для главной и категории
				$main = $breadcrumb[0];
				$cat = $breadcrumb[1];
				echo '<a href="' . esc_url( $main[1] ) . '">' . esc_html( $main[0] ) . '</a>';
				echo $delimiter;
				echo esc_html( $cat[0] );
			} elseif (sizeof( $breadcrumb ) == 3) {
				//для главной и подкатегории
				$main = $breadcrumb[0];
				$cat = $breadcrumb[1];
				$subcat = $breadcrumb[2];
				echo '<a href="' . esc_url( $main[1] ) . '">' . esc_html( $main[0] ) . '</a>';
				echo $delimiter;
				echo esc_html( $cat[0] )." - ".esc_html( $subcat[0] );
			}else {}
	} elseif (is_product()) {
		if (sizeof( $breadcrumb ) == 3) {
				//для главной и категории
				$main = $breadcrumb[0];
				$cat = $breadcrumb[1];
				$product = $breadcrumb[2];
				echo '<a href="' . esc_url( $main[1] ) . '">' . esc_html( $main[0] ) . '</a>';
				echo $delimiter;
				echo '<a href="' . esc_url( $cat[1] ) . '">' . esc_html( $cat[0] ) . '</a>';
				echo $delimiter;
				echo esc_html( $product[0] );
			} elseif (sizeof( $breadcrumb ) == 4) {
				//для главной и подкатегории
				$main = $breadcrumb[0];
				$cat = $breadcrumb[1];
				$subcat = $breadcrumb[2];
				$product = $breadcrumb[3];
				echo '<a href="' . esc_url( $main[1] ) . '">' . esc_html( $main[0] ) . '</a>';
				echo $delimiter;
				echo '<a href="' . esc_url( $subcat[1] ) . '">'. esc_html( $cat[0] )." - ".esc_html( $subcat[0] ). '</a>';
				echo $delimiter;
				echo esc_html( $product[0] );
			}else {}		
	} else {
	

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}

	}
}
	echo $wrap_after;

}