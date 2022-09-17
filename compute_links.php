<?php

/*
Plugin Name: Compute Links
Plugin URI: https://github.com/ndr053/compute-links-plugin-wordpress
Description: This plugin compute size of direct links in the content. It calculate you size links and display in your content.
Author: Hamed Naderfar
Version: 1.2.1
Author URI: https://naderfar.com
*/

if ( ! defined( 'WPINC' ) )
{
    die;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file )
{
    include_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'models/*.php' ) as $file )
{
	include_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'controllers/*.php' ) as $file )
{
    include_once $file;
}


$postModel = new Clp_Post();
$postModel->removeAllUrlsByPostId();
add_action( 'plugins_loaded', 'clp_admin_settings' );
add_shortcode('compute_links', 'clp_computeLinks');

function clp_admin_settings()
{
	include('installer.php');
    $page = new Clp_Compute_Submenu_Page();
    $plugin = new Clp_Compute_Submenu($page);
    $plugin->init();
    if (current_user_can('administrator')) {
        $page->save();
    }
}

function clp_computeLinks($atts, $links)
{
	$computeLinkModel = new Clp_Link();
	$convertorModel = new Clp_Convertor();
	$postModel = new Clp_Post();
    wp_enqueue_style ('theme-style', plugin_dir_url( __FILE__ ) .'assets/css/style.css');

    preg_match_all('/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/is', $links, $matches);
    $urls = array_unique($matches[0]);

    $sum = 0;
    foreach ($urls as $key=>$url) {
	    $urls[$key] = $computeLinkModel->getUrlByPostIdAndUrl($url);

	    if (is_null($urls[$key]) && $postModel->isPublish()) {
	    	$urlId = $computeLinkModel->saveUrl($url);
		    $urls[$key] = $computeLinkModel->getUrlById($urlId);
	    }
        $sum += $urls[$key]->size;
    }

    $isShortLink = get_option('compute_links_is_short_link');
    $titleBox = get_option('compute_links_box_title');
    $colorBox = get_option('compute_links_box_color');
    $result = '';
    if (count($urls) > 0) {
        $result .= "<div id='compute-links-box' class='".($colorBox?:'blue')."'>";
        $result .= "<div id='compute-title' class='".($colorBox?:'blue')."'>".($titleBox?:'Download Links')." :: ".$convertorModel->formatBytes($sum)."</div>";
        foreach ($urls as $url) {
        	if (isset($url)) {
		        $result .= '<div class="compute-link">
                            <span class="file-link">
                                <a href="'.$url->url.'">'.($isShortLink == 0?$url->url:substr($url->url, 0, 60).'...').'</a>
                            </span>
                            <span class="size-link">'.$convertorModel->formatBytes($url->size?:0)."</span>
                        </div>";
	        }
        }
        $result .= "</div>";

    }
    return $result;
}

