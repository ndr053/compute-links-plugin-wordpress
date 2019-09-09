<?php

/*
Plugin Name: Compute Links
Plugin URI: https://github.com/ndr053/compute-links-plugin-wordpress
Description: This plugin compute size of direct links in the content. It calculate you size links and display in your content.
Author: Hamed Naderfar
Version: 1.0.0
Author URI: http://naderfar.com
*/

if ( ! defined( 'WPINC' ) )
{
    die;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file )
{
    include_once $file;
}

add_action( 'plugins_loaded', 'compute_link_admin_settings' );

function compute_link_admin_settings()
{
    $page = new Compute_Submenu_Page();
    $plugin = new Compute_Submenu($page);
    $plugin->init();
    if (current_user_can('administrator')) {
        $page->save();
    }

}

add_shortcode('compute_links', 'computeLinks');

function computeLinks($atts, $links)
{
    wp_enqueue_style ('theme-style', plugin_dir_url( __FILE__ ) .'assets/css/style.css');

    preg_match_all('/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/is', $links, $matches);
    $urls = array_unique($matches[0]);

    $sum = 0;
    $resultLinks = array();
    foreach ($urls as $url) {
        $url = esc_url($url);
        $urlSize = getRemoteFileSize($url);
        $resultLinks[$url] = $urlSize;
        $sum += isset($urlSize) ? $urlSize : 0;
    }

    $isShortLink = get_option('compute_links_is_short_link');
    $titleBox = get_option('compute_links_box_title');
    $colorBox = get_option('compute_links_box_color');
    $result = '';
    if (count($resultLinks) > 0) {
        $result .= "<div id='compute-links-box' class='".$colorBox."'>";
        $result .= "<div id='compute-title' class='".$colorBox."'>".($titleBox?:'Download Links')." :: ".formatBytes($sum)."</div>";
        foreach ($resultLinks as $link => $size) {
            $result .= '<div class="compute-link">
                            <span class="file-link">
                                <a href="'.$link.'">'.($isShortLink == 0?$link:substr($link, 0, 60).'...').'</a>
                            </span>
                            <span class="size-link">'.formatBytes($size)."</span>
                        </div>";
        }
        $result .= "</div>";

    }
    return $result;
}

function getRemoteFileSize($url)
{
    $head = array_change_key_case(get_headers($url, 1));
    return $head['content-length'];
}

function formatBytes($clen)
{
    $size = $clen;
    switch ($clen) {
        case $clen < 1024                :
            $size = $clen . ' B';
            break;
        case $clen < 1048576            :
            $size = round($clen / 1024, 2) . ' KB';
            break;
        case $clen < 1073741824            :
            $size = round($clen / 1048576, 2) . ' MB';
            break;
        case $clen < 1099511627776        :
            $size = round($clen / 1073741824, 2) . ' GB';
            break;
    }
    return $size;
}