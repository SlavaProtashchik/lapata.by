<?php
/**
 * The header for our theme.
 *
 * Displays header
 *
 */
?><!DOCTYPE html>
<html lang="ru-RU">
<head>
<title><?php wp_title(); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
	<![endif]-->

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri();?>/images/favicon.ico"  />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header>
		<div class="container">
			<div class="row-container">
				<div class="logo">
					<a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Логотип Lapata.by"/><span class="logo-text"><?php bloginfo('name'); ?><span></a>
				</div>
				<div class="cart">			
					<?php if ( is_active_sidebar( 'header-right-widget-area' ) ) : ?>
						<?php dynamic_sidebar( 'header-right-widget-area' ); ?>
					<?php endif; ?>
				</div>
				<div class="search"><?php get_product_search_form(); ?></div>
			</div>
		</div>
	</header>

<?php if (!is_home()) {
  ?>
	<div class="topmenu">
<div class="menucontainer">

			<nav role="navigation" class="navbar navbar-default">
			        <!-- Brand and toggle get grouped for better mobile display -->
			        <div class="navbar-header">
			            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			                <span class="sr-only">Переключить вид меню</span>
			                <span class="icon-bar"></span>
			                <span class="icon-bar"></span>
			                <span class="icon-bar"></span>
			            </button>
			          <!--  <a href="#" class="navbar-brand">Brand</a> -->
			        </div>
			        <!-- Collection of nav links and other content for toggling -->
			        <div id="navbarCollapse" class="collapse navbar-collapse">
			        	<?php wp_nav_menu( array( 'theme_location' => 'rest-page-category-menu','menu_class' => 'nav navbar-nav','walker'     => new wp_bootstrap_navwalker() ) ); ?>
			        </div>
			    </nav>

			</div>	
</div>
<?php }
?>