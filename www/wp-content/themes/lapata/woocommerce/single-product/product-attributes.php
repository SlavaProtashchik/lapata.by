<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

						$has_row    = false;
						$alt        = 1;
						$attributes = $product->get_attributes();

						ob_start();

						?>
						<table class="shop_attributes">

							<?php foreach ( $attributes as $attribute ) :
								if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
									continue;
								} else {
									$has_row = true;
								}

								?>
								
								<?php
									if ( $attribute['is_taxonomy'] ) { ?>
										<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
										<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
										<td><?php
											$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
											echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
										?></td>
									</tr>
									<?php
										} else {
										if (mb_substr($attribute['name'], 0,9) == "delimiter") {?>
											<tr class="category">
											<th  colspan="2"><?php
												// Convert pipes to commas and display values
												$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
												echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
											?></th>
											</tr>
											<?php
											} else { ?>
											<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
												<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
												<td><?php
													$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
													echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
												?></td>
											</tr>
									<?php
											}
										} ?>

							<?php endforeach; ?>

						</table>

						<?php 
						$product_id = get_the_ID();
						if (get_post_meta( $product_id, 'importer', true )<>"") { ?>	
						<div class="importer">
								<?php
								echo "Импортер: ".get_post_meta( $product_id, 'importer', true ); ?>					
						</div>
						<?php } ?>

						<?php
						if ( $has_row ) {
							echo ob_get_clean();
						} else {
							ob_end_clean();
						}
						
