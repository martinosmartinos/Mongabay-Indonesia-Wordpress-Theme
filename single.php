<?php get_header(); ?>

<main role="main">
    <?php
        $post_id = get_the_ID();
        $author = get_post_meta( $post_id, 'author', true);
        $byline = wp_get_post_terms($post_id, 'byline');
        $topics = get_the_tag_list( '', ', ');
        $post_cat = wp_get_post_terms($post_id, 'category');
        //$serial = wp_get_post_terms($post_id, 'serial');
    ?>

    <div id="headline">
        <div class="article-headline">
            <?php
                if ($post_cat) {
                    echo '<p>';
                    echo get_the_term_list( $post_id, 'category', '', ', ', '' );
                    echo '</p>';
                }
            ?>
            <h1><?php the_title(); ?></h1>
            <?php
            if(wp_is_mobile()) {
                echo '<div class="social">';
                get_template_part( 'partials/section', 'social' );
                echo '</div>';
            }
            ?>
        </div>
        <div class="single-article-meta">
            <?php
                if($byline) {
                    echo 'oleh '.get_the_term_list( $post_id, 'byline', '', ', ', '' );
                } else {
                    echo 'oleh '.$author;
                }
            ?>
            <?php echo ' di '; ?>
            <?php the_time('j F Y'); ?>

            <?php
                if(!wp_is_mobile()) {
                    echo '<div class="social">';
                    get_template_part( 'partials/section', 'social' );
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <?php if ( has_post_thumbnail() )  : ?>
        <div class="row article-cover-image no-gutters">
            <?php
                if(wp_is_mobile()) {
                    $coversize = 'medium';
                }
                else {
                    $coversize = 'large';
                }
            ?>
            <div class="col-lg-12" style="background: url('<?php echo get_the_post_thumbnail_url($post_id, $coversize)?>');background-size: cover; background-position: center"></div>
            
        </div>
    <?php endif; ?>

    <div class="row">
        <div id="main" class="col-lg-8 single">
            <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                <!-- article -->
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php mongabay_sanitized_content();?>

                    <div id="single-article-footer">
                        <div id="single-article-meta">
                            <span>Artikel yang diterbitkan oleh <?php the_author_posts_link(); ?></span>
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
    <?php
        if(!wp_is_mobile()) {
            get_sidebar();
        }
        ?>
    </div>
    <!-- /row -->
    <?php get_template_part( 'partials/section', 'series' ); ?>
</main>
</div>
<!-- /container -->
<?php get_footer(); ?>