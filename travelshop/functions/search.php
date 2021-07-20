<?php
//Exclude pages from WordPress Search
if (!is_admin()) {
    function ts_search_filter($query) {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
        return $query;
    }
    add_filter('pre_get_posts','ts_search_filter');
}

function ts_filter_search_form( $form ) {
    return '
	<form role="search" method="get" class="form-string-search input-group mw-100" action="'. esc_url( home_url( '/' ) ) . '">
			<input type="search" class="form-control search-field mw-100" placeholder="Suchbegriff..." value="" name="s">
            <div class="input-group-append">
                <button class="btn btn-link" aria-label="Suchen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <circle cx="10" cy="10" r="7"></circle>
                        <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                </button>
            </div>
	</form> ';
}
add_filter('get_search_form', 'ts_filter_search_form');