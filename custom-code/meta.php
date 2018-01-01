<?php
/* Meta tags */
add_action( 'wp_head', 'mongabay_meta', 10 );

function mongabay_meta() {
	
	global $post;
	// article
	if ( is_single() && !is_front_page() && !is_home() ) {
;
		echo '<meta name="description" content="';
		mongabay_excerpt($post->ID);
		echo '" />'."\n";
		echo '<meta name="Tags" content="Mongabay, Mongabay Environmental News, Environmental News, Conservation News" />'."\n";
		echo '<meta property="keywords" content="Mongabay, Mongabay Environmental News, Environmental News, Conservation News" />'."\n";
		echo '<meta name="robots" content="index, follow" />'."\n";
		echo '<link rel="publisher" href="https://plus.google.com/+Mongabay/" />'."\n";
		echo '<meta property="article:publisher" content="https://www.facebook.com/MongabayIndonesia/"/>'."\n";
		echo '<meta property="og:title" content="'.esc_attr(get_the_title()).'"/>'."\n";
		echo '<meta property="og:site_name" content="Mongabay Environmental News"/>'."\n";
		echo '<meta property="og:url" content="'.esc_url(get_permalink()).'"/>'."\n";
		echo '<meta property="og:type" content="article" />'."\n";
					
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		
		if(!empty($thumbnail_src[0])) {
			echo '<meta property="og:image" content="' . esc_url($thumbnail_src[0] ) . '"/>'."\n";
		}
		echo '<meta property="og:description" content="';
		mongabay_excerpt($post->ID);
		echo '" />'."\n";
		
		$format = 'c';
		echo '<meta property="article:published_time" content="'.get_the_date( $format ).'" />'."\n";
		echo '<meta property="article:modified_time" content="'.get_the_modified_date( $format ).'" />'."\n";
		echo '<meta property="article:section" content="Environmental news" />'."\n";
		echo '<meta property="article:tag" content="Mongabay, Mongabay Environmental News, Environmental News, Conservation News" />'."\n";
		echo '<meta property="fb:admins" content="139042016164873" />'."\n";
		echo '<meta property="og:locale" content="'.get_locale().'" />'."\n";
		echo '<meta property="fb:app_id" content="411516865602000"/>'."\n";
		echo '<meta name="twitter:card" content="summary"/>'."\n";
		echo '<meta name="twitter:description" content="';
		mongabay_excerpt($post->ID);
		echo '" />'."\n";
		echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '"/>'."\n";
		echo '<meta name="twitter:site" content="@mongabay"/>';
		if(!empty($thumbnail_src[0])) {
			echo '<meta name="twitter:image" content="' . esc_url($thumbnail_src[0] ) . '"/>'."\n";
		}
		echo '<meta name="twitter:creator" content="@mongabayID"/>'."\n";
	}
	
	else {
		echo "\n".'<meta name="description" content="Mongabay adalah penyedia ragam berita konservasi dan sains lingkungan berbasis non-profit." />'."\n";
		echo '<meta name="Tags" content="Mongabay, Mongabay Environmental News, Environmental News, Conservation News" />'."\n";
		echo '<meta property="keywords" content="Mongabay, Mongabay Environmental News, Environmental News, Conservation News" />'."\n";
		echo '<meta name="robots" content="index, follow" />'."\n";
		echo '<link rel="publisher" href="https://plus.google.com/+Mongabay/" />'."\n";
		echo '<meta property="article:publisher" content="https://www.facebook.com/MongabayIndonesia/"/>'."\n";
	}
		
}

