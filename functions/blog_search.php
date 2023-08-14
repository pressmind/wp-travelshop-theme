<?php
//Exclude pages from WordPress Search
if (!is_admin()) {
    add_filter('pre_get_posts', function($query) {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
        return $query;
    });
}


add_filter('get_search_form', function($form) {
    return '
	<form role="search" method="get" class="form-string-search input-group mw-100" action="'. esc_url( home_url( '/' ) ) . '">
			<input type="search" class="form-control search-field mw-100" placeholder="Suchbegriff..." value="" name="s">
            <div class="input-group-append">
                <button class="btn btn-link" aria-label="Suchen">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'. get_stylesheet_directory_uri() .'/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
                </button>
            </div>
	</form> ';
});