<?php

$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
	<div class="input-group">
		<input type="text" class="form-control" value="' . get_search_query() . '" name="s" id="s" placeholder="Поиск в каталоге" />
		<span class="input-group-btn">
		<input type="submit" class="btn btn-default" id="searchsubmit" value="" />
		</span>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>';

echo $form;