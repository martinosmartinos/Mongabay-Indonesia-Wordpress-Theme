<?php
    include (get_template_directory().'/custom-code/figure-caption.php');
    include (get_template_directory().'/custom-code/thumbnailed-recent-posts.php');
    include (get_template_directory().'/custom-code/taxonomy-byline.php');
    include (get_template_directory().'/custom-code/taxonomy-location.php');
    include (get_template_directory().'/custom-code/feed-vars.php');
    include (get_template_directory().'/custom-code/meta.php');
    include (get_template_directory().'/custom-code/menus.php');
    include (get_template_directory().'/custom-code/url-rewrites.php');
    include (get_template_directory().'/custom-code/analytics.php');
    if (function_exists('add_theme_support'))
    {
        add_theme_support('menus');
        add_theme_support( 'post-formats', array( 'aside' ) );
        add_theme_support('post-thumbnails');
        add_image_size('large', 1200, 800, true); // Large Thumbnail
        add_image_size('medium', 768, 512, true); // Medium Thumbnail
        add_image_size('cover-image', 1280, 450, true); // Cover Thumbnail
        add_image_size('thumbnail', 100, 100, true); // Small Thumbnail
        //load_theme_textdomain('mongabay', get_template_directory() . '/languages');
    }
/*------------------------------------*\
    Functions
\*------------------------------------*/
// Sanitize content
function mongabay_sanitized_content() {
        $content = get_the_content();
        $content = str_replace(array('<br>','<BR>','<br/>','<BR/>'),"\n",$content);
        $content = preg_replace('/ /','', $content);
        $content = str_replace('<p></p>', '', $content);
        $content = str_replace('&nbsp;', '', $content);
        $content = apply_filters('the_content', $content);
        echo $content;
}

// Series listing section function. Usage mongabay_series_section (array('slug1','slug2','slug3'), 3) where 3 is number of posts
    function mongabay_series_section ( $names, $number) {
        echo '<div id="special-series">';
        if(mongabay_layout() == 'container-fluid') echo '<div class="container">';
        $count = 0;
        foreach ($names as $name) {
            $count = $count + 1;
            $title = ucfirst(str_replace('-', ' ', $name));

            switch ($count) {
                case '1': ?>
                    <div class="row"><h2>Kategori</h2>
                    <?php break;
                case '4': ?>
                    <div class="spacer clearfix"></div>
                    <div class="row">
                    <?php break;
                case '7': ?>
                <div class="spacer clearfix"></div>
                <div class="row">
                <?php break;
            } ?>

                <div class="col-lg-4">
                    <h4><?php echo $title; ?></h4>
            <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => $name,
                            ),
                        ),
                    );
                

                $query = new WP_Query( $args );

                if ($query->have_posts()) { ?>

                <ul>
                <?php
                    $counter = 0;
                    while ( $query->have_posts() ) : $query->the_post();
                    $counter = $counter + 1; ?>
                    <li class="post-<?php the_ID(); ?>">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
                </ul>
                <div class="thumbnail-series">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/series/<?php echo $name; ?>.jpg" alt="<?php echo $title; ?>"/>
                </div>
                <?php
                }
                wp_reset_postdata(); ?>

                <div class="more-special">
                    <a href="<?php echo esc_url( home_url( '/' ) ).'category/'.$name; ?>"><?php _e('More articles', 'mongabay'); ?></a>
                </div>
                </div>
            <?php if ($count == 3 || $count == 6 || $count == 9) { ?>
                </div>
            <?php }
        } ?>
        <?php if(mongabay_layout() == 'container-fluid') echo '</div>';?>
        </div>

        <?php }

// Function to detect if we are dealing with featured aside article
    function mongabay_layout() {
        if ( is_single() ) {
            $post_id = get_the_ID();
            $aside = get_post_format($post_id);
            $featured = get_post_meta( $post_id, 'featured_as', false );
            if ( $aside == 'aside' && in_array('featured', $featured) ) {
                $container = 'container-fluid';
            }
            else {
                $container = 'container';
            }
        }
        else {
            $container = 'container';
        }
        return $container;
    }

// Load scripts
    function mongabay_header_scripts()
    {
        if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

            wp_register_script('fittext', get_template_directory_uri() . '/js/lib/jquery.fittext.min.js', array('jquery'), '1.2', true);
            wp_enqueue_script('fittext');

            wp_register_script('bootstraputils', get_template_directory_uri() . '/js/lib/util.min.js', array('jquery'), '4.0.0', true);
            wp_enqueue_script('bootstraputils');

            wp_register_script('bootstraptabs', get_template_directory_uri() . '/js/lib/tabs.min.js', array('jquery'), '4.0.0', true);
            wp_enqueue_script('bootstraptabs');

            wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script('scripts');
        }
    }

// Load conditional scripts
    function mongabay_conditional_scripts() {
        if ( mongabay_layout() == 'container-fluid') {
            wp_register_script('parallax', get_template_directory_uri() . '/js/lib/parallax.min.js', array(), '1.4.2', true);
            wp_enqueue_script('parallax');
            wp_register_script('iframeresize', 'https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.15/iframeResizer.min.js', array(), '3.5.15', true);
            wp_enqueue_script('iframeresize');
        }
        if (!is_singular() || is_home()) {
            wp_register_script('salvattore', get_template_directory_uri() . '/js/lib/salvattore.min.js', array(), '1.0.9', true);
            wp_enqueue_script('salvattore');
        }
    }

// Featured articles template
    function mongabay_featured() {
        if ( mongabay_layout() == "container-fluid" ) {
            include (TEMPLATEPATH . '/single-featured.php');
            exit;
        }
    }
    add_action('template_redirect', 'mongabay_featured');

// Load styles
    function mongabay_styles() {
        wp_register_style('main', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
        wp_enqueue_style('main');
        wp_register_style('boostrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.0.0', 'all');
        wp_enqueue_style('boostrap');
        wp_register_style('framework', get_template_directory_uri() . '/css/framework.min.css', array(), '1.0', 'all');
        wp_enqueue_style('framework');
    }

// Register Navigation
    function register_mongabay_menu() {
        register_nav_menus(array( // Using array to specify more menus if needed
            'header-menu' => __('Header Menu', 'mongabay'), // Main Navigation
            'sidebar-menu' => __('Sidebar Menu', 'mongabay'), // Sidebar Navigation
            'extra-menu' => __('Extra Menu', 'mongabay') // Extra Navigation if needed (duplicate as many as you need!)
            ));
    }

// Remove the <div> surrounding the dynamic navigation to cleanup markup
    function my_wp_nav_menu_args($args = '') {
        $args['container'] = false;
        return $args;
    }

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
    function my_css_attributes_filter($var) {
        return is_array($var) ? array() : '';
    }

// Remove invalid rel attribute values in the categorylist
    function remove_category_rel_from_category_list($thelist) {
        return str_replace('rel="category tag"', 'rel="tag"', $thelist);
    }

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
    function add_slug_to_body_class($classes) {
        global $post;
        if (is_home()) {
            $key = array_search('blog', $classes);
            if ($key > -1) {
                unset($classes[$key]);
            }
        } elseif (is_page()) {
            $classes[] = sanitize_html_class($post->post_name);
        } elseif (is_singular()) {
            $classes[] = sanitize_html_class($post->post_name);
        }

        return $classes;
    }

// If Dynamic Sidebar Exists
    if (function_exists('register_sidebar')) {
        // Define Sidebar Widget
        register_sidebar(array(
            'name' => __('Sidebar Widget', 'mongabay'),
            'description' => __('All sidebar widgets should be placed here.', 'mongabay'),
            'id' => 'sidebar-widget',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
            ));

        // Define Footer Widget 1/4
        register_sidebar(array(
            'name' => __('Footer Widget 1/4', 'mongabay'),
            'description' => __('First column widget', 'mongabay'),
            'id' => 'footer-widget-1',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
            ));

        // Define Footer Widget 2/4
        register_sidebar(array(
            'name' => __('Footer Widget 2/4', 'mongabay'),
            'description' => __('Second column widget', 'mongabay'),
            'id' => 'footer-widget-2',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
            ));

        // Define Footer Widget 3/4
        register_sidebar(array(
            'name' => __('Footer Widget 3/4', 'mongabay'),
            'description' => __('Third column widget', 'mongabay'),
            'id' => 'footer-widget-3',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
            ));

        // Define Footer Widget 4/4
        register_sidebar(array(
            'name' => __('Footer Widget 4/4', 'mongabay'),
            'description' => __('Forth column widget', 'mongabay'),
            'id' => 'footer-widget-4',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
            ));
    }

// Tabbed articles by topic/location
    function mongabay_tabs() {
        register_widget( 'mongabay_topic_location' );
    }
    add_action( 'widgets_init', 'mongabay_tabs' );



    class mongabay_topic_location extends WP_Widget {

        function __construct() {
            parent::__construct(
                'mongabay_topic_location', 
                'Topic and location tabs', 
                array( 'description' => 'Listing topics and locations as tabbed content' ) 
                );
        }

        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $args['before_widget'];
            if ( ! empty( $title ) )
                echo '<p>' . $title . '</p>';
            
            ?>
            <?php
                function mongabay_tabbed_content ($home_url, $items) {
                    foreach ($items as $item) {
                        $title = ucwords($item);
                        $slug = sanitize_title($item);?>
                        <a class="widget-term" href="<?php echo $home_url.'tag/'.$slug ;?>"><?php echo $title; ?></a>
                    <?php }
            }
            ?>
            <ul class="nav nav-tabs">
              <li><a data-toggle="tab" href="#topic" class="active"><h2><?php echo 'Berdasarkan topik'; ?></h2></a></li>
              <li><a data-toggle="tab" href="#location"><h2><?php echo 'Berdasarkan lokasi'; ?></h2></a></li>
          </ul>
          <div class="tab-content">
            <div id="topic" class="tab-pane fade in active show">
                <?php
                    mongabay_tabbed_content('http://www.mongabay.co.id/', array('Batubara','Burung','Deforestasi','Dunia Satwa','Energi','Fitur','Hutan','Kabut Asap','Kelapa Sawit','Konservasi','Lautan','Masyarakat Adat','Orangutan','Penegakan Hukum','Perburuan Liar','Perkebunan','Perubahan Iklim','Polusi','Spesies Baru','Teknologi'));
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>topics" class="plus-link"><?php _e('Many more topics', 'mongabay'); ?></a>
            </div>
            <div id="location" class="tab-pane fade">
                <?php
                    mongabay_tabbed_content('http://www.mongabay.co.id/', array('Afrika','Amazon','Asia','Australia','Malaysia','Brazil','Jambi','Riau','China','Nusa Tenggara','Aceh','Maluku','Indonesia','Jakarta','Bali','Java','Papua','Kalimantan','Sumatera','Sulawesi'));
                    
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>locations" class="plus-link"><?php _e('Browse more locations', 'mongabay'); ?></a>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( 'New title', 'mongabay' );
            }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
                <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <?php 
        }


        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            return $instance;
        }

    }


// Remove wp_head() injected Recent Comment styles
    function my_remove_recent_comments_style()
    {
        global $wp_widget_factory;
        remove_action('wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
            ));
    }

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
    function mongabay_pagination()
    {
        global $wp_query;
        $big = 999999999;
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', get_pagenum_link($big)),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages
            ));
    }

// Custom Excerpts
    function mongabay_index($length) // Create 20 Word Callback for Index page Excerpts, call using mongabay_excerpt('mongabay_index');
    {
        return 20;
    }

// Create 40 Word Callback for Custom Post Excerpts, call using mongabay_excerpt('mongabay_custom_post');
    function mongabay_custom_post($length)
    {
        return 40;
    }

// Create the Custom Excerpts
    function mongabay_excerpt() {
        global $post;
        if ( empty( $post->post_excerpt ) ) {
            $output_1 = strip_shortcodes ($post->post_content);
            $output_2 = wp_strip_all_tags($output_1);
            $output = wp_trim_words( $output_2, 30 );
        } else {
            $output = $post->post_excerpt; 
        }
        $output = apply_filters('wptexturize', $output);
        $output = apply_filters('convert_chars', $output);
        echo $output;
    }



// Custom View Article link to Post
    function mongabay_blank_view_article($more) {
        global $post;
        return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'mongabay') . '</a>';
    }

// Remove 'text/css' from our enqueued stylesheet
    function mongabay_style_remove($tag) {
        return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
    }

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
    function remove_thumbnail_dimensions( $html ) {
        $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
        return $html;
    }

/* Parallax Shortcode */
    add_shortcode('parallax-img','parallax_img');

    function parallax_img($atts) {
        extract(shortcode_atts(array('imagepath' => 'Image Needed','id' => '1', 'px_title' => 'Slide Title', 'title_color' => '#FFFFFF' , 'img_caption' => 'Your image caption'),$atts));
        return "<div class='clearfix'></div><div class='parallax-section full-height' data-parallax='scroll' id='".$id."' data-image-src='".$imagepath."'); background-size: cover;'><div class='featured-article-meta'><span class='subtitle' style='color:".$title_color."'>".$img_caption."</span></div></div><div class='clearfix'></div>";
    }

    add_shortcode('open-parallax-content','parallax_open');

    function parallax_open() {
        return "<div class='container'><div class='row justify-content-center'><div id='main' class='col-lg-8 single'><article>";
    }

    add_shortcode('close-parallax-content','parallax_close');

    function parallax_close() {
        return "</article></div></div></div>";
    }


/* Parallax Slide Shortcode Button in a text editor*/
    function px_shortcode_button() {

        if(wp_script_is("quicktags"))
        {
            ?>
                <script type="text/javascript">
                    function getSel() {
                        var txtarea = document.getElementById("content");
                        var start = txtarea.selectionStart;
                        var finish = txtarea.selectionEnd;
                        return txtarea.value.substring(start, finish);
                    }

                    QTags.addButton(
                        "parallax_shortcode",
                        "ParallaxSlide",
                        callback
                    );

                    function callback() {
                        var selected_text = getSel();
                        QTags.insertContent("[parallax-img imagepath='image_url' id='1' px_title='First Title' title_color='#333333' img_caption='Your image caption']");
                    }
                </script>
            <?php
        }
    }
    add_action("admin_print_footer_scripts", "px_shortcode_button");


/* Parallax Content Shortcode Button in a text editor*/
    function open_close_px_content() {
        if(wp_script_is("quicktags"))
        {
            ?>
                <script type="text/javascript">
                    function getSel() {
                        var txtarea = document.getElementById("content");
                        var start = txtarea.selectionStart;
                        var finish = txtarea.selectionEnd;
                        return txtarea.value.substring(start, finish);
                    }

                    QTags.addButton(
                        "pxcontent_shortcode",
                        "ParallaxContent",
                        callback
                    );

                    function callback() {
                        var selected_text = getSel();
                        QTags.insertContent("[open-parallax-content]" +  selected_text + "[close-parallax-content]")
                    }
                </script>
            <?php
        }
    }
    add_action('admin_print_footer_scripts', 'open_close_px_content');



// Remove meta boxes from post editing screen
    function mongabay_remove_custom_fields() {

        $post_types = get_post_types( '', 'names' );
        foreach ( $post_types as $post_type ) {
            remove_meta_box( 'postcustom' , $post_type , 'normal' );     
        }

    }

    add_action( 'admin_menu' , 'mongabay_remove_custom_fields' );

// Stats pages dynamic sidebar
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => __('Stats Widget', 'mongabay'),
            'description' => __('Stats page sidebar widgets should be placed here.', 'mongabay'),
            'id' => 'stats-widget',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
            ));
    }

// Remove first image from single post
    function remove_first_image ($content) {
        if (is_single()){
            $post_id = get_the_ID();
            if($post_id < 59282) {
                $content = preg_replace("/<figure[^>]*>.*?<\/figure>/", "", $content, 1);
            }
        } return $content;
    }
    add_filter('the_content', 'remove_first_image', 20, 1);

// Remove query strings from scripts and css
    function remove_query_string( $src ) {   
        $parts = explode( '?ver', $src );
        return $parts[0];
    }

    if ( !is_admin() ) {
        add_filter( 'script_loader_src', 'remove_query_string', 15, 1 );
        add_filter( 'style_loader_src', 'remove_query_string', 15, 1 );
    }

// Customize RSS feed
remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'mongabay_feed_rss2', 10, 1 );

function mongabay_feed_rss2() {

    $rss_template = get_template_directory() . '/custom-code/feed-rss2.php';
    load_template( $rss_template );

}

// Add the filter parameter for API
function rest_api_filter_add_filters() {
    foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
        add_filter( 'rest_' . $post_type->name . '_query', 'rest_api_filter_add_filter_param', 10, 2 );
    }
}

function rest_api_filter_add_filter_param( $args, $request ) {
    if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
        return $args;
    }
    $filter = $request['filter'];
    if ( isset( $filter['posts_per_page'] ) && ( (int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100 ) ) {
        $args['posts_per_page'] = $filter['posts_per_page'];
    }
    global $wp;
    $vars = apply_filters( 'query_vars', $wp->public_query_vars );
    foreach ( $vars as $var ) {
        if ( isset( $filter[ $var ] ) ) {
            $args[ $var ] = $filter[ $var ];
        }
    }
    return $args;
}

// Onesignal notification filter
function onesignal_send_notification_filter($fields, $new_status, $old_status, $post) {
    $fields_dup = $fields;
    $fields_dup['isAndroid'] = true;
    $fields_dup['isIos'] = true;
    $fields_dup['isAnyWeb'] = false;
    $fields_dup['isWP'] = false;
    $fields_dup['isAdm'] = false;
    $fields_dup['isChrome'] = false;
    $fields_dup['data'] = array(
        "notifyurl" => $fields['url']
    );
    $fields_dup['tags'] = array(
      array("key" => "notify_domain", "relation" => "=", "value" => home_url())
    );
    unset($fields_dup['url']);
    $ch = curl_init();
    $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
    $onesignal_wp_settings = OneSignal::get_onesignal_settings();
    $onesignal_auth_key = $onesignal_wp_settings['app_rest_api_key'];
    curl_setopt($ch, CURLOPT_URL, $onesignal_post_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . $onesignal_auth_key
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields_dup));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $fields;
}

// Sanitize json output for content. Consumed by APP.
function mongabay_sanitize_json( $data, $post, $context ) {
    $allowtags = array(
        'a' => array(
            'href' => array(),
            'data-wpel-link' => array(),
            'rel' => array()
        ),
        'p' => array(),
        'b' => array(),
        'strong' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'br' => array(),
        'em' => array(),
        'ul' => array(
            'class' => array()
        ),
        'ol' => array(
            'class' => array()
        ),
        'li' => array(),
        'img' => array(
            'alt' => array(),
            'width' => array(),
            'height' => array(),
            'class' => array(),
            'src' => array(),
            'srcset' => array(),
            'data-soliloquy-src' => array()
        ),
        'noscript' => array(),
        'style' => array(),
        'span' => array(
            'class' => array()
        ),
        'figure' => array(),
        'figcaption' => array(),
        'iframe' => array(
            'width' => array(),
            'height'=> array(),
            'src' => array()
        ),
        'div' => array(
            'data-image-src' => array()
        )
    );
    $data->data['content'] = preg_replace('/<noscript\b[>]*>(.*?)<\/noscript>/s', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<p><\/p>/', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<p>&nbsp;<\/p>/', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<div class=\'container\'>\\n<div class=\'row justify-content-center\'>\\n<div id=\'main\' class=\'col-lg-8 single\'>\\n/s', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<div class=\'clearfix\'><\/div>\\n/s', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<\/div>\\n<\/div>\\n<\/div>\\n/s', '', $data->data['content']);
    $data->data['content'] = wp_kses($data->data['content'], $allowtags);
    $data->data['content'] = preg_replace('/\\n<div>\\n<div>\\n<ul class/s', '<ul class', $data->data['content']);
    $data->data['content'] = preg_replace('/\/>\\n<div>\\n<div>.*\w*<\/div>\\n<\/div>\\n<\/li>/', '/></li>', $data->data['content']);
    $data->data['content'] = preg_replace('/<!--.*\w*-->/', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<p>\\n<p>/s', '<p>', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/news[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/cn[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_cn://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/de[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_de://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/es[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_es://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/fr[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_fr://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/it[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_it://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/jp[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_jp://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/pt[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_pt://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/<a href=\\"https:\/\/india[.]mongabay[.]com\/\d\d\d\d\/\d\d\//s', '<a href="mongabay_in://article/', $data->data['content']);
    $data->data['content'] = preg_replace('/\\n/s', '', $data->data['content']);
    $data->data['content'] = preg_replace('/<\/li><\/ul><\/div><p><\/div>/', '</li></ul>', $data->data['content']);
    return $data;
}
function mongabay_sanitize_page_json( $data, $post, $context ) {
    $data->data['content'] = preg_replace('/\\n/s', '', $data->data['content']);
    return $data;
}

/*------------------------------------*\
    Actions + Filters
\*------------------------------------*/

    // Add Actions
    add_action('init', 'mongabay_header_scripts'); // Add Custom Scripts to wp_head
    add_action('wp_enqueue_scripts', 'mongabay_conditional_scripts'); // Add Conditional Page Scripts
    add_action('wp_enqueue_scripts', 'mongabay_styles'); // Add Theme Stylesheet
    add_action('init', 'register_mongabay_menu'); // Add Blank Menu
    add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
    add_action('init', 'mongabay_pagination'); // Add our Pagination
    add_action( 'rest_api_init', 'rest_api_filter_add_filters' ); // Add the filter parameter for API

    // Remove Actions
    remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
    remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
    remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
    remove_action('wp_head', 'index_rel_link'); // Index link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
    remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
    remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'print_emoji_detection_script', 7); //remove emoji script
    remove_action('admin_print_scripts', 'print_emoji_detection_script'); //remove emoji script
    remove_action('wp_print_styles', 'print_emoji_styles'); //remove emoji style
    remove_action('admin_print_styles', 'print_emoji_styles'); //remove emoji style

    // Add Filters
    add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
    add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
    add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
    add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
    add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
    add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
    add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
    add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
    add_filter('style_loader_tag', 'mongabay_style_remove'); // Remove 'text/css' from enqueued stylesheet
    add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
    add_filter( 'rest_prepare_post', 'mongabay_sanitize_json', 100, 3 ); // Get content ready for App
    add_filter( 'rest_prepare_page', 'mongabay_sanitize_page_json', 100, 3 ); //Get content ready for App
    add_filter('onesignal_send_notification', 'onesignal_send_notification_filter', 10, 4); // Add Onesignal notifications filter

    // Remove Filters
    remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
    remove_filter( 'the_content', 'wpautop' );
    add_filter( 'the_content', 'wpautop' , 12); //Remove <p> and <br> from shortcodes
?>
