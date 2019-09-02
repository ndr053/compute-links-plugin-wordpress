<?php

class Compute_Submenu_Page {
    const BOX_COLORS = array('gray', 'red', 'blue', 'green', 'yellow');

    public function render()
    {
        include "view/index.php";
    }

    public function save()
    {
        $params = $_POST;
        if ($params['submit']) {

            if (isset($params['box_title']) && strlen($params['box_title']) < 20) {
                update_option( 'compute_links_box_title', $params['box_title']);
            }

            if (isset($params['box_color']) && in_array($params['box_color'], self::BOX_COLORS)) {
                update_option( 'compute_links_box_color', $params['box_color']);
            }

            if (isset($params['is_short_link'])) {
                update_option( 'compute_links_is_short_link', $params['is_short_link']);
            }
        }
    }
}