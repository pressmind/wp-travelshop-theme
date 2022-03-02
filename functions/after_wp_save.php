<?php
if(defined('PM_REDIS_ACTIVATE') && PM_REDIS_ACTIVATE === true){
    add_action('save_post', function ($post_id) {
        $fstpage = [];
        $fstpage[] = get_option( 'page_on_front' );
        $fstpage[] = get_option( 'page_for_posts' );
        $level = in_array($post_id, array_filter($fstpage)) ? 3 : null;
        $pattern = Redis_Page_Cache::get_key_path_from_url(get_permalink($post_id)).'*';
        Redis_Page_Cache::del_by_pattern($pattern, $level);
    });
}