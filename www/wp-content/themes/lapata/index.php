<?php get_header(); ?>

<div class="maincontent-sidebar">
	<div class="container">
		<div class="row-container">
			<div class="maincontent">
				
				<div class="menu-slider">

						<div class="row-container">
							<div class="menu">
								<?php wp_nav_menu( array( 'theme_location' => 'main-page-category-menu' ) ); ?>
							</div>
							<div class="slider">
								<?php // echo do_shortcode("[rev_slider vertical_boxed]"); ?>
								<?php putRevSlider( "mainpageslider") ?>
							</div>
						</div>

				</div>

				
				<!-- зона виджетов под слайдером -->
				<?php if ( is_active_sidebar( 'mainpage-underslider-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'mainpage-underslider-widget-area' ); ?>
				<?php endif; ?>

			</div>
		
			<div class="sidebar">
			<?php if ( is_active_sidebar( 'sibedar-widget-area' ) ) : ?>
						<?php dynamic_sidebar( 'sibedar-widget-area' ); ?>
				<?php endif; ?>

			</div>
			<div class="index-descr">
				<p><a href="<?php echo home_url(); ?>">lapata.by</a> – это интернет-магазин в Минске, который позволяет заказать товар по низкой цене с бесплатной доставкой. Наш интернет магазин также осуществляет доставку по регионам Беларуси. </p>
				<p>В интернет-магазине можно купить ноутбук, мобильный телефон, телевизор, бытовую технику, планшет и многое другое. Мы реализуем товары известных мировых брендов: Samsung, LG, HP, Asus, Acer, Dell, Huawei, Canon, Ricoh, Nikon, Phillips, Lenovo, Bosch, Gefest, Braun, Moulinex, Tefal, Panashonic, Scarlett, Canyon, Prestigio, Apple, Xerox, Daewoo, Vigor, indesit, Logitech, Sven, Microlab, Nokia, Explay, keneksi, Texet, Sony, Supra, Vitek, Dialog, Polaris, Brother, Hansa, Maxwell, Pocketbook.</p>
			</div>
		</div>
	</div>
</div>




<?php get_footer();?>