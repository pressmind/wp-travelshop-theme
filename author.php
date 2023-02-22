<?php
get_header();
?>
    <!-- BREADCRUMB: START -->
<?php the_breadcrumb(null);?>
    <!-- BREADCRUMB: END -->

    <main>

        <div class="content-main content-main--posts" id="content-main">

            <div class="container">

                <div class="content-block content-block-blog--header">
                    <div class="row">
                        <div class="col-12">
                            <h1 ><?php echo get_the_archive_title() ?></h1>
                            <?php if ( (bool) get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) : ?>

                                <div class="blog-list-entry blog-list-entry--author">
                                    <div class="blog-list-entry--body">


                                        <div class="author-bio <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">
                                            <?php echo get_avatar( get_the_author_meta( 'ID' ), '85' ); ?>
                                            <div class="author-bio-content">

                                                <?php
                                                $author_website = get_the_author_meta('url');
                                                $author_social = [];

                                                if ( get_the_author_meta('facebook') ) {
                                                    $author_social['facebook'] = get_the_author_meta('facebook');
                                                }

                                                if ( get_the_author_meta('twitter') ) {
                                                    $author_social['twitter'] = get_the_author_meta('twitter');
                                                }

                                                if ( get_the_author_meta('instagram') ) {
                                                    $author_social['instagram'] = get_the_author_meta('instagram');
                                                }

                                                if ( get_the_author_meta('youtube') ) {
                                                    $author_social['youtube'] = get_the_author_meta('youtube');
                                                }

                                                if ( get_the_author_meta('linkedin') ) {
                                                    $author_social['linkedin'] = get_the_author_meta('linkedin');
                                                }

                                                if ( get_the_author_meta('pinterest') ) {
                                                    $author_social['pinterest'] = get_the_author_meta('pinterest');
                                                }
                                                ?>
                                                <?php if ( $author_website || !empty($author_social) ) { ?>
                                                    <div class="author-links">

                                                        <?php
                                                        if ( !empty($author_social) ) {
                                                            foreach ( $author_social as $key => $social ) {
                                                                ?>
                                                                <a href="<?php echo $social; ?>" target="_blank" class="author-link author-link--<?php echo $key; ?>">
                                                                    <?php
                                                                    switch ( $key ) {
                                                                        case 'facebook':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>';
                                                                            break;

                                                                        case 'instagram':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 24 24"><title>Instagram</title><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>';
                                                                            break;

                                                                        case 'twitter':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 24 24"><title>Twitter</title><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                                                                            break;

                                                                        case 'youtube':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 24 24"><title>YouTube</title><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
                                                                            break;

                                                                        case 'pinterest':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><path d="m12.326 0c-6.579.001-10.076 4.216-10.076 8.812 0 2.131 1.191 4.79 3.098 5.633.544.245.472-.054.94-1.844.037-.149.018-.278-.102-.417-2.726-3.153-.532-9.635 5.751-9.635 9.093 0 7.394 12.582 1.582 12.582-1.498 0-2.614-1.176-2.261-2.631.428-1.733 1.266-3.596 1.266-4.845 0-3.148-4.69-2.681-4.69 1.49 0 1.289.456 2.159.456 2.159s-1.509 6.096-1.789 7.235c-.474 1.928.064 5.049.111 5.318.029.148.195.195.288.073.149-.195 1.973-2.797 2.484-4.678.186-.685.949-3.465.949-3.465.503.908 1.953 1.668 3.498 1.668 4.596 0 7.918-4.04 7.918-9.053-.016-4.806-4.129-8.402-9.423-8.402z"/></svg>';
                                                                            break;

                                                                        case 'linkedin':
                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><path d="m23.994 24v-.001h.006v-8.802c0-4.306-.927-7.623-5.961-7.623-2.42 0-4.044 1.328-4.707 2.587h-.07v-2.185h-4.773v16.023h4.97v-7.934c0-2.089.396-4.109 2.983-4.109 2.549 0 2.587 2.384 2.587 4.243v7.801z"/><path d="m.396 7.977h4.976v16.023h-4.976z"/><path d="m2.882 0c-1.591 0-2.882 1.291-2.882 2.882s1.291 2.909 2.882 2.909 2.882-1.318 2.882-2.909c-.001-1.591-1.292-2.882-2.882-2.882z"/></svg>';
                                                                            break;
                                                                    }
                                                                    ?>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <?php if ( $author_website ) { ?>
                                                            <a href="<?php echo $author_website; ?>" target="_blank" class="author-link author-link--website">
                                                                <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m488.73 0h-186.18c-12.853 0-23.273 10.42-23.273 23.273s10.42 23.273 23.273 23.273h130l-239.54 239.54c-9.087 9.087-9.087 23.823 0 32.912 4.543 4.543 10.499 6.816 16.455 6.816s11.913-2.273 16.455-6.817l239.55-239.54v130c0 12.853 10.42 23.273 23.273 23.273s23.273-10.42 23.273-23.273v-186.18c-1e-3 -12.853-10.421-23.273-23.274-23.273z"/><path d="M395.636,232.727c-12.853,0-23.273,10.42-23.273,23.273v209.455H46.545V139.636H256c12.853,0,23.273-10.42,23.273-23.273 S268.853,93.091,256,93.091H23.273C10.42,93.091,0,103.511,0,116.364v372.364C0,501.58,10.42,512,23.273,512h372.364 c12.853,0,23.273-10.42,23.273-23.273V256C418.909,243.147,408.489,232.727,395.636,232.727z"/></svg>
                                                            </a>
                                                        <?php } ?>

                                                    </div>
                                                <?php } ?>

                                                <p class="author-description"> <?php the_author_meta( 'description' ); ?></p><!-- .author-description -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list">
                                <?php if ( have_posts() ): ?>
                                    <?php
                                    // -- wp query, all posts
                                    global $wp;

                                    $count = get_option('posts_per_page', 10);
                                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                    $offset = ($paged - 1) * $count;

                                    $current_cat_ID = get_query_var('cat');

                                    $get_permalink =  home_url( $wp->request );
                                    $get_permalink_split = explode('/page/', $get_permalink);

                                    $get_permalink = $get_permalink_split[0];

                                    // get searchquery
                                    $search_query = get_search_query();

                                    $count_posts = $wp_query->found_posts;
                                    ?>
                                    <?php while ( have_posts() ) : the_post(); ?>

                                        <?php get_template_part( 'template-parts/wp-views/blog-list-entry' );  ?>

                                    <?php endwhile; else: ?>

                                    Keine Beiträge gefunden.

                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                            <?php if ( $count_posts > $count ) { ?>
                                <div class="posts-pagination">
                                    <nav>
                                        <ul class="pagination">

                                            <?php
                                            $prev_page = $paged - 1;
                                            $prev_page_str = '';

                                            if ( $prev_page < 1 ) {
                                                $prev_page = 1;
                                            }

                                            if ( $prev_page >= 1 ) {
                                                $prev_page_str = '/page/' . $prev_page;
                                            }
                                            ?>

                                            <li  class="page-item <?php if ( $paged == 1 ) { echo 'disabled'; } ?>">
                                                <a href="<?php echo $get_permalink . $prev_page_str; ?>" class="page-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="16" height="16" viewBox="0 2 24 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <polyline points="15 6 9 12 15 18"></polyline>
                                                    </svg>
                                                </a>
                                            </li>

                                            <?php

                                            $pager_active_class = '';

                                            for ( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) {
                                                if ( $i == $paged ) {
                                                    $pager_active_class = 'active';
                                                } else {
                                                    $pager_active_class = '';
                                                }
                                                ?>
                                                <li class="page-item <?php echo $pager_active_class; ?>">
                                                    <a href="<?php echo $get_permalink; ?>/page/<?php echo $i; ?>" class="page-link "><?php echo $i; ?></a>

                                                </li>
                                                <?php
                                            }

                                            ?>

                                            <?php if ( $wp_query->max_num_pages > 1 ) { ?>
                                                <?php
                                                $next_page = $paged + 1;

                                                if ( $next_page > $wp_query->max_num_pages ) {
                                                    $next_page = $wp_query->max_num_pages;
                                                }
                                                ?>
                                                <li  class="page-item <?php if ( $paged == $wp_query->max_num_pages ) { echo 'disabled'; } ?>">
                                                    <a href="<?php echo $get_permalink; ?>/page/<?php echo $next_page; ?>" class="page-link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 2 24 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <polyline points="9 6 15 12 9 18"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-3">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>

            </div><!-- .container -->
        </div>

    </main>
<?php
get_footer();
