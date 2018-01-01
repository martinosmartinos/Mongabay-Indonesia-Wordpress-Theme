<?php
	if (have_posts()): while (have_posts()) : the_post();
    $post_id = get_the_ID();
    $post_cat = wp_get_post_terms($post_id, 'category');
    $author = get_post_meta( $post_id, 'author', true);
    $byline = wp_get_post_terms($post_id, 'byline');
?>

<article id="post-<?php the_ID(); ?>" class="post-news">
    <?php if ($post_cat) echo '<p class="post-categories">'.get_the_term_list( $post_id, 'category', '', ', ', '' ).'</p>';?>
	<?php if ( has_post_thumbnail()) : ?>
		<div class="d-md-none">
		<?php echo get_the_post_thumbnail($post_id, 'medium')?>
		</div>
	<?php endif; ?>
		<h2 class="post-title-news"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry-meta-news">
			<?php
				if($byline) {
                    echo 'oleh '.get_the_term_list( $post_id, 'byline', '', ', ', '' );
                } else {
                    echo 'oleh '.$author;
                }
				echo ' ';
				the_time('j F Y');
			?>
		</div>
		<div class="excerpt-news">
			<?php
				mongabay_excerpt();
			?>
		</div>
		<?php if ( has_post_thumbnail()) : ?>
		<div class="thumbnail-news d-none d-md-block">
		<?php echo get_the_post_thumbnail($post_id, 'thumbnail')?>
		</div>
	<?php endif; ?>

</article>


<?php endwhile; ?>
<?php else: ?>

<article>

	<h2><?php echo 'Maaf, tidak ada yang bisa ditampilkan.'; ?></h2>

</article>


<?php endif;?>