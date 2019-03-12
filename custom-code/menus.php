<?php
    function mongabay_menu_items() {

        //set up the list of names for menu items
        $items = array('Tentang','Readersblog','Hutan Hujan','Foto','Para Penjaga Hutan');

        //set up arrays for menu item's links
        $url_base = esc_url( home_url( '/', 'https' ) );
        $urls = array($url_base.'tentang','https://readersblog.mongabay.co.id/','https://www.mongabay.co.id/hutan-hujan','https://www.mongabay.co.id/foto/','https://www.mongabay.co.id/para-penjaga-hutan/');

        //return unordered list with menu items
        foreach ($items as $item) {
            $count = $count + 1;
            $item_url = $urls[($count -1)];
            echo '<li class="nav-item '.$count.'">';
            echo '<a href="'.$item_url.'" class="nav-link">';
            echo $item;
            echo '</a>';
            echo '</li>';
        }
    }
?>
