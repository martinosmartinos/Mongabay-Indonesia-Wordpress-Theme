<?php
// Google Analytics integration

add_action('wp_head','mongabay_google_analytics');
function mongabay_google_analytics() {
	
	$lines = array();
	
	if(is_single()) {
		global $post;
		$args = array('orderby' => 'count', 'order' => 'DESC');
		$tags = wp_get_object_terms(get_the_ID(), 'post_tag');
		$categories = wp_get_object_terms(get_the_ID(), 'category', $args);
		$bylines =  wp_get_object_terms(get_the_ID(), 'byline' , $args);
		$byline_slug = $byline -> slug;
		$byline_legacy =  get_post_meta(get_the_ID(), 'author', true);

		$author_id = $post->post_author;
		$author = get_the_author_meta('user_nicename', $author_id);

		foreach ($tags as $tag) $tags_f[]= $tag -> slug;
		foreach ($bylines as $byline) $bylines_f[]= $byline -> slug;
		foreach ($categories as $category) $category_f[]= $category -> slug;

		
		if (isset($tags_f)) $lines[] = "ga('set', 'dimension1', '".implode(' ',$tags_f)." '); ";
		if (isset($category_f)) $lines[] = "ga('set', 'dimension2', '".implode(' ',$category_f)." '); ";
		if (isset($bylines_f)) $lines[] = "ga('set', 'dimension3', '".implode(' ',$bylines_f)." '); ";
		if ($byline_legacy) $lines[] = "ga('set', 'dimension4', '".$byline_legacy." '); ";
		if ($author) $lines[] = "ga('set', 'dimension5', '".$author." '); ";
	}

	?>
    <!-- Google Analytics -->
	<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-28789750-1', 'auto');
		<?php echo implode("\n",$lines); ?>
  		ga('send', 'pageview');
	</script>
    <!-- End Google Analytics -->
	<?php 
}
