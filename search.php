<?php get_header(); ?>
	<main role="main">
        <div class="row">
            <div id="main" class="col-lg-8">
                <div class="tag-line">
                    <h1><?php echo sprintf( '%s Hasil pencarian ', $wp_query->found_posts ); echo '"'.get_search_query().'"'; ?></h1>
                </div>
                <section>

                    <div id="post-wrapper-news" class="row" data-columns>
                        <?php get_template_part('loop'); ?>
                    </div>
                    <div class="counter">
                        <?php mongabay_pagination(); ?>
                    </div>
                    
                </section>
            </div>
            <?php
                if(!wp_is_mobile()) {
                    get_sidebar();
                }
            ?>
        </div>
        <?php get_template_part( 'partials/section', 'series' ); ?>
    </main>
</div>
<?php get_footer(); ?>