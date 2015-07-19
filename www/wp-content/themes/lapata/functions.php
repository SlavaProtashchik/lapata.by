<?php

//правильный вывод случайных товаров
session_start();

add_filter( 'posts_orderby', 'randomise_with_pagination' );
function randomise_with_pagination( $orderby ) {

    if( is_archive() ) {
        // Reset seed on load of initial archive page
        if( ! get_query_var( 'paged' ) || get_query_var( 'paged' ) == 0 || get_query_var( 'paged' ) == 1 ) {
            if( isset( $_SESSION['seed'] ) ) {
                unset( $_SESSION['seed'] );
            }
        }
        // Get seed from session variable if it exists
        $seed = false;
        if( isset( $_SESSION['seed'] ) ) {
            $seed = $_SESSION['seed'];
        }
            // Set new seed if none exists
            if ( ! $seed ) {
                $seed = rand();
                $_SESSION['seed'] = $seed;
            }   
            // Update ORDER BY clause to use seed
            $orderby = 'RAND(' . $seed . ')';
    }
    return $orderby;
}
//конец правильный вывод случайных товаров

add_theme_support('menus');

//отключаем стили вукомерса
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * 
 * Регистрируем стили
 */
function my_theme_load_resources() {
    $theme_uri = get_template_directory_uri();
 
    wp_register_style('my_theme_style', $theme_uri.'/style.css', false, '0.1');
    wp_enqueue_style('my_theme_style');

    wp_register_style('bootstrap', $theme_uri.'/libs/bootstrap/bootstrap.min.css', false, '0.1');
    wp_enqueue_style('bootstrap');
    
    wp_register_script('commonjs', $theme_uri.'/libs/bootstrap/bootstrap.min.js', array( 'jquery' ));
    wp_enqueue_script('bootstrapjs');

    wp_register_script('commonjs', $theme_uri.'/js/common.js', array( 'jquery' ));
    wp_enqueue_script('commonjs');

   }

 add_action('wp_enqueue_scripts', 'my_theme_load_resources');



/**
 * 
 * Регистрируем меню
 */

//подключаем библиотеку для работы меню бутстрапа
require_once('libs/bootstrap-navwalker/wp_bootstrap_navwalker.php');

function register_my_menu() {
	//главное меню (категории)
  register_nav_menu('main-page-category-menu',__( 'Меню категорий главной страницы' ));
  register_nav_menu('rest-page-category-menu',__( 'Меню категорий страниц кроме главной' ));
  register_nav_menu('footer-about-menu',__( 'Меню футера о нас' ));
  register_nav_menu('footer-popular-menu',__( 'Меню футера популярные категории' ));
}
add_action( 'init', 'register_my_menu' );

// Область виджетов в шапке
    register_sidebar(array(
        'name' => __('Хеадер справа (корзина)'),
        'id' => 'header-right-widget-area',
        'description' => __('Виджеты в шапке, например для корзины'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

// Область виджетов в сайдбаре
    register_sidebar(array(
        'name' => __('Главная сайдбар'),
        'id' => 'sibedar-widget-area',
        'description' => __('Виджеты в сайдбаре'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));


// Область виджетов на главной под слайдером
register_sidebar(array(
    'name' => __('Главная под слайдером'),
    'id' => 'mainpage-underslider-widget-area',
    'description' => __('Виджеты на главной под стайдером для категорий товаров'),
    'before_widget' => '<div class="mainpage-widget-area"><div class="row-container set-row-equal-height">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="title"><h3>',
    'after_title' => '</h3><div class="hr"></div></div>',
));

// Область виджетов на странице каталога между хеадером и списком товаров
register_sidebar(array(
    'name' => __('Каталог между хеадером и списком товаров'),
    'id' => 'catalog-underheader-upperprodlist-widget-area',
    'description' => __('Виджеты на странице каталога между хеадером и списком товаров'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
));

// Область виджетов ля виджета сортировки по цене
register_sidebar(array(
    'name' => __('Фильтр по цене каталог между хеадером и списком товаров'),
    'id' => 'catalog-underheader-upperprodlist-widget-area-price-filter',
    'description' => __('Зона фильтра по цене странице каталога между хеадером и списком товаров'),
    'before_widget' => '<div class="price_filter">',
    'after_widget' => '</div>',
    'before_title' => '<span class="title">',
    'after_title' => '</span>',
));

// Область виджетов на странице каталога сайдбар
register_sidebar(array(
    'name' => __('Каталог сайдбар'),
    'id' => 'catalog-sidebar-widget-area',
    'description' => __('Виджеты на странице каталога в сайдбаре'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
));

// Область виджетов на статических страницах
register_sidebar(array(
    'name' => __('Страницы сайдбар'),
    'id' => 'page-sidebar-widget-area',
    'description' => __('Виджеты на статических страницах в сайдбаре'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
));
/*
// регистрация виджетов в теме
function instanceof_widgets_init() {
    require get_template_directory() . '/includes/widgets/random-post-widget.php';
    register_widget('MainPageCatWidget');
}
add_action( 'widgets_init', 'instanceof_widgets_init' );

*/



/*
* заменяем плейсхолдер на свой
*
**/
add_action( 'init', 'custom_fix_thumbnail' );
 
function custom_fix_thumbnail() {
  add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
   
	function custom_woocommerce_placeholder_img_src( $src ) {
	$upload_dir = wp_upload_dir();
	$uploads = untrailingslashit( $upload_dir['baseurl'] );
	$src = $uploads . '/2015/05/placeholder.png';
	 
	return $src;
	}
}





//перерегистрируем стандартный виджет woocommerce для вывода скидок и популярных
add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );
 
function override_woocommerce_widgets() {
  // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
 //виджет для Товаров с высоким рейтингом
  if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
    unregister_widget( 'WC_Widget_Top_Rated_Products' );
 
    require get_template_directory() . '/includes/widgets/class-wc-widget-top-rated-products.php';
 
    register_widget( 'Custom_WC_Widget_Top_Rated_Products' );
  }

 //виджет для Популярных товаров и Скидок
  if ( class_exists( 'WC_Widget_Products' ) ) {
    unregister_widget( 'WC_Widget_Products' );
 
    require get_template_directory() . '/includes/widgets/class-wc-widget-products.php';
 
    register_widget( 'Custom_WC_Widget_Products' );
  }

 //виджет фильтра товаров
 // if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
   // unregister_widget( 'WC_Widget_Layered_Nav' );
 
    require get_template_directory() . '/includes/widgets/class-wc-widget-layered-nav.php';
 
    register_widget( 'Custom_WC_Widget_Layered_Nav' );
  //} 

 //виджет активных фильтров
  if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
    unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
 
    require get_template_directory() . '/includes/widgets/class-wc-widget-layered-nav-filters.php';
 
    register_widget( 'Custom_WC_Widget_Layered_Nav_Filters' );
  } 


 //виджет flyout корзины
    require get_template_directory() . '/includes/widgets/woocommerce-drop-down-cart-widget/widget-flyout-cart.php';
    register_widget( 'WooCommerce_Widget_DropdownCart' );


 //виджет контактов и доставки
    require get_template_directory() . '/includes/widgets/contact_delivery.php';
    register_widget( 'Contact_Delivery_Widget' );
}


// Определяем размеры миниатюр
if ( function_exists( 'add_image_size' ) ){
 add_image_size( 'main-page', 204, 136, false ); //$width, $height, $crop
 add_image_size( 'main-page-m', 147, 98, false ); //$width, $height, $crop
 add_image_size( 'main-page-xs', 120, 80, false ); //$width, $height, $crop
 add_image_size( 'widget-cart-xs', 75, 50, false ); //$width, $height, $crop
 add_image_size( 'archive-page-m', 210, 140, false ); //$width, $height, $crop
 add_image_size( 'single-page-m', 360, 240, false ); //$width, $height, $crop
 add_image_size( 'single-page-s', 135, 90, false ); //$width, $height, $crop
 add_image_size( 'single-page-xs', 81, 54, false ); //$width, $height, $crop

}

//Отключаем стандартные миниатюры woocommerce
function paulund_remove_default_image_sizes( $sizes) {
    unset( $sizes['shop_thumbnail']);
    unset( $sizes['shop_catalog']);
    unset( $sizes['shop_single']);
     
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'paulund_remove_default_image_sizes');



//отключаем лишнюю закладку на странице продукта
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );          // Remove the description tab
    return $tabs;
}

//переименовываем закладки на странице продукта
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
    if (isset($tabs['additional_information'])) {
    $tabs['additional_information']['title'] = 'Характеристики';       // Rename the description tab
}
    return $tabs;
}


//убираем лишние поля с формы заказа
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
  
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    return $fields;
}


//ajaxify корзины
require('includes/ajaxifycart.php');
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_upd_cart_quant' );
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_upd_cart' );


//изменяем вывод холебных крошек
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '&nbsp;&#47;&nbsp;',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemscope itemtype="http://schema.org/WebPage" itemprop="breadcrumb"' : '' ) . '>',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' )
        );
}
//конец изменения вывода хлебных крошек

//добавляем бел руб
add_filter( 'woocommerce_currencies', 'add_my_currency' );
 
function add_my_currency( $currencies ) {
     $currencies['BYR'] = __( 'Белорусский рубль', 'woocommerce' );
     return $currencies;
}
 
add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
 
function add_my_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'BYR': $currency_symbol = 'BYR'; break;
     }
     return $currency_symbol;
}
//конец добавл бел руб
?>