<?php get_header(); ?>
<?php
    $queried_object = get_queried_object();
    //var_dump($wp_query);
    $title = $queried_object -> name;
    $description = $queried_object -> description;
    $tax = $queried_object -> taxonomy;
?>
    <main role="main">
        <?php
            
            $line_start = '';
            $line_end = '';
            if ($tax == 'byline') {
                $line_start = 'Artikel oleh';
            }
            if ($tax == 'serial') {
                $line_start = 'Mongabay series: ';
            }
            if ($tax == 'topic' || $tax == 'location' || $tax == 'post_tag') {
                $line_end = ' News';
            }
            
        ?>
        <div class="row">
            <div id="main" class="col-lg-8">
                <div class="tag-line">
                    <h1><?php echo $line_start;?> <?php echo ucwords($title); ?><?php echo $line_end; ?></h1>
                    <p><?php echo $description; ?></p>
                </div>
                <!-- section -->
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
        <!-- /row -->
        <?php get_template_part( 'partials/section', 'series' ); ?>
    </main>
</div>
<!-- /container -->
<?php get_footer(); ?>