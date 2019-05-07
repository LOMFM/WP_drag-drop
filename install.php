<?php

// Create by HJ on 04/29/2019

// Admin Menu configuration
add_action('admin_menu', 'dd_plugin_setup_menu');


function dd_plugin_setup_menu(){
        add_menu_page( 'Drag and Drop Management', 'Drog & Drop', '', 'dd-plugin' );
        add_submenu_page ( 'dd-plugin', 'Element Management Page', 'Element Manage', 'manage_options', 'dd-element-mg', 'dd_element_init');
        add_submenu_page ( 'dd-plugin', 'Background Management Page', 'Background Manage', 'manage_options', 'dd-bg-mg', 'dd_bg_init');
}

// Admin page StyleSheet
function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(DD_PLUGIN)) . '/css/style.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

add_action('admin_head', 'admin_register_head');

function admin_register_script() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(DD_PLUGIN)) . '/js/script.js';
    echo "<script src='$url' /></script>\n";
}

add_action('admin_print_footer_scripts', 'admin_register_script');

function dd_plugin_register_settings() {
   add_option( 'dd_bg_baseurl',   dirname(DD_PLUGIN).'/assets/img/bg/');
   add_option( 'dd_asset_baseurl',  $siteurl . '/wp-content/plugins/' . basename(dirname(DD_PLUGIN)).'/assets/img/asset/');
}

add_action( 'admin_init', 'dd_plugin_register_settings' );


// Ajax API Register
// Remove Backgroud Ajax
add_action('wp_ajax_dd_bg_remove', array(new Background(), 'remove'));
add_action('wp_ajax_nopriv_dd_bg_remove', array(new Background(), 'remove'));

// Remove Asset Ajax
add_action('wp_ajax_dd_element_remove', array(new Element(),'remove'));
add_action('wp_ajax_nopriv_dd_element_remove', array(new Element(), 'remove'));



// Add shortcode for the front-end
add_shortcode( 'drag_drop', 'drag_drop_front' );

// Style for the shortcode
function dd_front_enqueue_style() {
    wp_register_style( 'drag_drop_styles', plugins_url( '/css/front-style.css', __FILE__ ), array(), '1.0.0', 'all' );
    wp_register_script( 'drag_drop_scripts', plugins_url( '/js/front-script.js', __FILE__ ), array(), '1.0.0', 'all' );
    wp_register_script( 'drag_drop_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '1.0.0', 'all' );
}

add_action( 'wp_enqueue_scripts', 'dd_front_enqueue_style' );