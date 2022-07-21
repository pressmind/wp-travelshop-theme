<?php
/**
 * Example to extend WPQuery to search wildcard like in title field
 * @example
 * <code>
 * $my_query = new WP_Query( array(
 *                              'post_type' => 'post',
 *                              'post_status' => 'publish',
 *                              'posts_per_page' => 20,
 *                              'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
 *                              'update_post_meta_cache' => false,
 *                              'update_post_term_cache' => false,
 *                              'extend_where' => "(post_title like '%".$search_key."%')"
 *                          )
 *                      );
 * </code>
 */
add_filter( 'posts_where', function ( $where, $wp_query ) {
    if ( $extend_where = $wp_query->get( 'extend_where' ) ) {
        $where .= " AND " . $extend_where;
    }
    return $where;
}, 10, 2 );
