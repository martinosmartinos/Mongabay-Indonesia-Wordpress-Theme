<?php
    function mongabay_menu_items() {

        //set up the list of names for menu items
        $items = array('Home','Tentang','Readersblog','Hutan Hujan','Foto','Para Penjaga Hutan');

        //set up arrays for menu item's links
        $url_base = esc_url( home_url( '/', 'http' ) );
        $urls = array('http://www.mongabay.co.id/',$url_base.'tentang','http://readersblog.mongabay.co.id/','http://www.mongabay.co.id/hutan-hujan','http://www.mongabay.co.id/foto/','http://www.mongabay.co.id/para-penjaga-hutan/');

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