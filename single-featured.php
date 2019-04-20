<?php get_header( 'featured' ); ?>
    <?php
        $post_id = get_the_ID();
        $byline = get_the_term_list( $post_id, 'byline', '', ', ', '' );
        $topics = get_the_tag_list( 'Tags: ', ', ');
        //$serial = wp_get_post_terms($post_id, 'serial');
    ?>
    <!-- post thumbnail -->
    <?php if ( has_post_thumbnail()) : ?>
    <div class="row no-gutters">
        <div class="col-lg-12 parallax-section full-height article-cover" data-parallax="scroll" data-image-src="<?php echo get_the_post_thumbnail_url($post_id, 'large')?>">
            <div class="featured-article-meta">
                <h1 class="title"><?php the_title(); ?></h1>
                <span class="subtitle">
                    <?php echo $tagline; ?>
                </span>
                <span class="featured-article-publish">
                    <?php _e('by ', 'mongabay'); ?>
                    <?php echo $byline; ?>
                    <?php _e(' on ', 'mongabay'); ?>
                    <?php the_time('j F Y'); ?>
                </span>
                <?php
                    // if ($serial) {
                    //     echo '<p>';
                    //     _e('Mongabay Series: ', 'mongabay');
                    //     echo get_the_term_list( $post_id, 'serial', '', ', ', '' );
                    //     echo '</p>';
                    // }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php endif; ?>
    <!-- /post thumbnail -->
    <main role="main">
        <div class="container">
            <div class="row justify-content-center">
                <div id="main" class="col-lg-8 single">
                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php the_content();?>
                        <div id="single-article-footer">
                            <div id="single-article-meta">
                                <span><?php _e( 'Article published by ', 'mongabay' ); the_author(); ?></span>
                                <span class="article-comments"><a href=""></a></span>
                            </div>
                            <div id="single-article-tags">
                                <?php echo $topics; ?>
                            </div>
                        </div>
                        <?php //mongabay_comments(); ?>
                    </article>
                    <!-- /article -->
                    <?php endwhile; ?>
                    <?php else: ?>
                    <!-- article -->
                    <article>
                        <h1>Maaf, tidak ada yang bisa ditampilkan.</h1>
                    </article>
                    <!-- /article -->
                    <?php endif; ?>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
        <?php get_template_part( 'partials/section', 'series' ); ?>
    </main>
<?php get_footer(); ?>
