<?php
//add_action('init', 'custom_author_base');
function custom_author_base() {
    global $wp_rewrite;
    $author_slug = 'by';
    $wp_rewrite->author_base = $author_slug;

}

add_action('init', 'add_rewrite_url');
function add_rewrite_url()
{
//pagination
//add_rewrite_rule( '^list/([^/]*)/page/([0-9]{1,})/?$', 'index.php?section=list&nc1=$matches[1]&paged=$matches[2]', "top" );
//add_rewrite_rule( '^list/([^/]*)/([^/]*)/page/([0-9]{1,})/?$', 'index.php?section=list&nc1=$matches[1]&nc2=$matches[2]&paged=$matches[3]', "top" );

//custom taxonomies
add_rewrite_rule( '^by/([^/]*)/?$', 'byline=$matches[1]', 'top' );
//add_rewrite_rule( '^series/([^/]*)/?$', 'index.php?section=series&nc1=$matches[1]', 'top' );
//add_rewrite_rule( '^topic/([^/]*)/?$', 'index.php?section=list&nc1=$matches[1]', 'top' );
//add_rewrite_rule( '^list/([^/]*)/([^/]*)/?$', 'index.php?section=list&nc1=$matches[1]&nc2=$matches[2]', 'top' );
//add_rewrite_rule( '^list/([^/]*)/?$', 'index.php?section=list&nc1=$matches[1]', 'top' );
//add_rewrite_rule( '^list/?$', 'index.php?section=list', 'top' );
}
?>