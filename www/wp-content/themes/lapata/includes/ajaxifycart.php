<?php
function woocommerce_header_upd_cart_quant( $fragments ) {
    ob_start();
    ?>
    <?php
        global $woocommerce;

        $not_null="";
        if (WC()->cart->cart_contents_count > 0) {$not_null=" not-null";}
        echo '<span class="cart-item-wrap">';
        echo '<span class="items-in-cart'.$not_null.'">' . "\r\n";  
        echo  sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count );
        echo '</span>';
        echo '</span>';
    ?>
    <?php
    
    $fragments['span.cart-item-wrap'] = ob_get_clean();
    
    return $fragments;
}


function woocommerce_header_upd_cart( $fragments ) {
    ob_start();
    ?>
    <?php

global $woocommerce;
    
    
        echo '<div class="dropdowncartcontents">' . "\r\n";
        
                        echo '<ul class="cart_list">';

    if (sizeof($woocommerce->cart->cart_contents)>0) : 
        $i = 0;                 
        foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
            
            $i++;
            if ( $i == 1 ) :                
                $rowclass = ' class="cart_oddrow"';         
            else :
                //$rowclass = ' class="cart_evenrow"';
                $rowclass = ' class="cart_oddrow"';
                $i = 0;
            endif;
    
            $_product = $cart_item['data'];
            
            if ($_product->exists() && $cart_item['quantity']>0) :
                echo '<li'.$rowclass.'>';
                
                echo '<div class="dropdowncartimage">';
                echo '<a href="'.get_permalink($cart_item['product_id']).'">';              
                if (has_post_thumbnail($cart_item['product_id'])) :                 
                    echo get_the_post_thumbnail($cart_item['product_id'], 'widget-cart-xs'); 
                else :                   
                    echo '<img src="'.$woocommerce->plugin_url(). '/assets/images/placeholder.png" alt="Placeholder" width="75" height="50" />';                
                endif;              
                echo '</a>';
                echo '</div>';
                
                echo '<div class="dropdowncartproduct">';
                echo '<a href="'.get_permalink($cart_item['product_id']).'">';              
                echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a>';              
                if ($_product instanceof woocommerce_product_variation && is_array($cart_item['variation'])) :
                    echo woocommerce_get_formatted_variation( $cart_item['variation'] );
                endif;
                echo '</a>';
                echo '</div>';
                
                echo '<div class="dropdowncartquantity">';              
                echo '<span class="quantity">' .$cart_item['quantity'].' &times; '.woocommerce_price($_product->get_price()).'</span>';
                echo '</div>';
                echo '<div class="clear"></div>';
                
                echo '</li>';
                
            endif;
        endforeach; 
    else: 
        echo '<li class="empty">Ваша корзина пуста.</li>'; 
    endif;
        
    echo '</ul>';
        
    if (sizeof($woocommerce->cart->cart_contents)>0) :
        
        echo '<p class="total"><strong>';
            
    /*  if (get_option('js_prices_include_tax')=='yes') :
            _e('Total', 'woothemes');
        else :
            _e('Subtotal', 'woothemes');
        endif; */
        _e('Итого', 'woothemes');
         echo ':</strong> '.$woocommerce->cart->get_cart_total();
            
        echo '</p>';
            
        do_action( 'woocommerce_widget_shopping_cart_before_buttons' );
            
        echo '<p class="buttons">
              <a href="'.$woocommerce->cart->get_cart_url().'" class="dropdownbutton cart_but">'.__('Корзина &rarr;', 'woothemes').'</a> 
              <a href="'.$woocommerce->cart->get_checkout_url().'" class="dropdownbutton checkout">'.__('Заказать', 'woothemes').'</a>
              </p>';
    endif;
    
        echo '</div>' . "\r\n";

    ?>  
    <?php
    
    $fragments['div.dropdowncartcontents'] = ob_get_clean();
    
    return $fragments;
}

?>