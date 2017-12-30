<?php get_header(); ?>
	<?php
		$queried_object = get_queried_object();
		$section = get_query_var('section');
		$firstvar = get_query_var('nc1');
		$secondvar = get_query_var('nc2');

		$line_end = '';
		if ($section == 'list' && !empty($firstvar) && empty($secondvar)) {
			$item1 = get_terms(array('topic','location'), array('slug' => $firstvar));
			$title = $item1[0] -> name;
			$line_end = ' Berita';
		}

		if ($section == 'list' && !empty($firstvar) && !empty($secondvar)) {
			$item1 = get_terms(array('topic','location'), array('slug' => $firstvar));
			$item2 = get_terms(array('topic','location'), array('slug' => $secondvar));
			$title1 = $item1[0] -> name;
			$title2 = $item2[0] -> name;
			$title = $title1.' and '.$title2;
			$line_end = ' Berita';
		}

		if (empty($section)) {
			$title = 'Tajuk Lingkungan';
			$description = 'Mongabay adalah penyedia ragam berita konservasi dan sains lingkungan berbasis non-profit.';
		}

	?>
	<main role="main">
        <?php
        	if(empty($section)) {
        ?>
        <div class="row featured-slider no-gutters">
            <?php get_template_part( 'partials/section', 'slider' ); ?>
        </div>
        <?php
        	}
        ?>
        <div class="row">
            <div id="main" class="col-lg-8">
                <div class="tag-line">
                	<h1><?php echo _e($title, 'mongabay'); ?><?php _e( $line_end, 'mongabay');?></h1>
					<p><?php echo _e($description, 'mongabay'); ?></p>
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