<?php

class Clp_Compute_Submenu_Page {
    const BOX_COLORS = array('gray', 'red', 'blue', 'green', 'yellow');

    public function render()
    {
        include "view/index.php";
    }

    public function save()
    {
        $nonce = isset($_POST['compute_links_setting_token']) ?
            sanitize_text_field($_POST['compute_links_setting_token']) :
            null;

        if (isset($_POST['submit']) && wp_verify_nonce($nonce, 'compute_links_setting_form')) {

            $boxTitle = sanitize_text_field($_POST['box_title']);
            $boxColor = sanitize_text_field($_POST['box_color']);
            $isShortLink = sanitize_text_field($_POST['is_short_link']);

            if ($boxTitle) {
                update_option( 'compute_links_box_title', $boxTitle);
            }

            if ($boxColor && in_array($boxColor, self::BOX_COLORS)) {
                update_option( 'compute_links_box_color', $boxColor);
            }

            if ($isShortLink) {
                update_option( 'compute_links_is_short_link', $isShortLink);
            }
        }
    }
}