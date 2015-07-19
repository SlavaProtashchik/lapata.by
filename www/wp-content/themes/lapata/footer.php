<footer>
	<div class="container">
		<div class="row-container">
			<div class="about">
				<p class="copyright">&copy; <a href="<?php echo home_url();?>">www.lapata.by 2015</a></p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-about-menu' ) ); ?>
			</div>
			<div class="popular">
				<p class="popular-cats">Популярные категории</p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-popular-menu' ) ); ?>
			</div>
			<div class="contacts hidden-xs hidden-sm hidden-md">
				<p class="contacts-header">Контакты</p>
				<ul>
					<li>+375(33) 900 22 60</li>
					<li>+375(44) 511 22 60</li>
					<li>+375(25) 700 22 60</li>
				</ul>
				<ul class="rest-contacts">
					<li>Skype: lapata.by</li>
					<li>e-mail: info@lapata.by</li>
				</ul>
			</div>
			<div class="reginfo">
				<p>ООО "Либертайм"</p>
				<ul class="info">
					<li>г. Минск, ул. Чапаева, д.3, каб. 204</li>
					<li>Регистрация №192294163 от 24.06.2014</li>
					<li>Выдана минским горисполкомом</li>
					<li>В торговом реестре с 25.06.2015</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
