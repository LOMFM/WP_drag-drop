<?php
/**
 * Plugin Name: Drag and Drop
 * Plugin URI: http://www.dragdrop.dev
 * Author: Hong Jin
 * Version: 1.0
 * Description: Drag and Drop plugin for the assets.
 */


define('DD_PLUGIN', __FILE__);
define('DD_PLUGIN_DIR', untrailingslashit(dirname(DD_PLUGIN)));
require_once DD_PLUGIN_DIR . '/model/background.php';
require_once DD_PLUGIN_DIR . '/model/element.php';
require_once DD_PLUGIN_DIR . '/model/instance.php';
require_once DD_PLUGIN_DIR . '/admin.php';
require_once DD_PLUGIN_DIR . '/front.php';
require_once DD_PLUGIN_DIR . '/install.php';


// DB creation for installing
function dd_plugin_activate() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $bg_table_name = $wpdb->prefix . 'dd_bg';
    $element_table_name = $wpdb->prefix . 'dd_elements';
    

    $sql_bg_table = "CREATE TABLE IF NOT EXISTS `$bg_table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` int(11) NOT NULL,
      `url` varchar(255) NOT NULL,
      `target` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) $charset_collate;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql_bg_table);

    $sql_elements_table = "CREATE TABLE IF NOT EXISTS `$element_table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` int(11) NOT NULL,
      `url` varchar(255) NOT NULL,
      `target` varchar(255) NOT NULL,
      `fields` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) $charset_collate;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql_elements_table);

}
register_activation_hook( __FILE__, 'dd_plugin_activate' );

