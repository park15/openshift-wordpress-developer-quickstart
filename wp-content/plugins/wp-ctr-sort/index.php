<?php

/**
  Plugin Name: Wordpress CTR Sort
  Description: Plugin which sorts posts by CTR
  Author:  Arcade Pulse
  Version: 1.1.9
  Date: 2015-10-19
  Author URI: http://www.arcadepulse.com/
 */
global $wpdb;/** wordpress global database object */
$ctr_table_prefix = $wpdb->prefix . 'ctr_';

$getsiteurl = get_option('siteurl');

define('CTR_PREFIX', $ctr_table_prefix);
define('PLUGIN_FOLDER', dirname(plugin_basename(__FILE__))); //PATH TO PLUGIN
define('PLUGIN_URL', $getsiteurl . '/wp-content/plugins/' . PLUGIN_FOLDER); //URL TO PLUGIN
// Table names
define('TABLE_CLICKS_INDEX', CTR_PREFIX . "clicks_index");
define('TABLE_CLICKS_CATEGORY', CTR_PREFIX . "clicks_category");
define('TABLE_CLICKS_TAG', CTR_PREFIX . "clicks_tags");
define('TABLE_CLICKS_TMP', CTR_PREFIX . "clicks_tmp");
define('TABLE_CLICKS_SETTINGS', CTR_PREFIX . "settings");

/**
 * CALL FUNCTION TO ACTIVATE PLUGIN
 */
register_activation_hook(__FILE__, 'ctr_plugin_install');

/**
 * CALL FUNCTION TO DEACTIVATE PLUGIN
 */
register_deactivation_hook(__FILE__, 'ctr_plugin_uninstall');

/**
 * FUNCTION FOR PLUGIN ACTIVATION
 */
function ctr_plugin_install() {
    global $wpdb;

    $table_tmp_clicks = CTR_PREFIX . "clicks_tmp";
    $table_clicks_index = CTR_PREFIX . "clicks_index";
    $table_clicks_category = CTR_PREFIX . "clicks_category";
    $table_clicks_tags = CTR_PREFIX . "clicks_tags";
    $table_settings = CTR_PREFIX . "settings";
    //$table_statistic = CTR_PREFIX . "clicks_statistic";

    $schema_tmp_clicks = "CREATE TABLE IF NOT EXISTS `$table_tmp_clicks` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `post_id` int(20) NOT NULL,
  `type` int(1) NOT NULL,
  `type_id` int(20) NOT NULL,
  `clicks` int(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    $schema_clicks_index = "CREATE TABLE IF NOT EXISTS `$table_clicks_index` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `post_id` int(20) NOT NULL,
  `type` int(1) NOT NULL,
  `type_id` int(20) NOT NULL,
  `clicks` int(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    $schema_clicks_category = "CREATE TABLE IF NOT EXISTS `$table_clicks_category` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `post_id` int(20) NOT NULL,
  `type` int(1) NOT NULL,
  `type_id` int(20) NOT NULL,
  `clicks` int(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    $schema_clicks_tags = "CREATE TABLE IF NOT EXISTS `$table_clicks_tags` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `post_id` int(20) NOT NULL,
  `type` int(1) NOT NULL,
  `type_id` int(20) NOT NULL,
  `clicks` int(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    $schema_settings = "CREATE TABLE IF NOT EXISTS `$table_settings` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    $wpdb->query($schema_tmp_clicks);
    $wpdb->query($schema_clicks_index);
    $wpdb->query($schema_clicks_category);
    $wpdb->query($schema_clicks_tags);
    $wpdb->query($schema_settings);

    $sql = "SELECT * FROM " . $table_settings;
    $result = $wpdb->get_results($sql);
    
    if(!count($result)){
        $sql = "INSERT INTO `" . TABLE_CLICKS_SETTINGS . "` (`name`, `value`) VALUES
                ('licence_posts', ''),
                ('clicks_total_0', '0'),
                ('clicks_total_1', '0'),
                ('clicks_total_2', '0'),
                ('clicks0', '0'),
                ('clicks1', '0'),
                ('clicks2', '0'),
                ('categoryclicks', '100'),
                ('tagclicks', '100'),
                ('indexclicks', '100'),
                ('indexmain', '0'),
                ('categorymain', '0'),
                ('tagsmain', '0'),
                ('afterposts', '12'),
                ('countposts', '20'),
                ('indexposts', '116'),
                ('categoryposts', '116'),
                ('tagposts', '116'),
                ('ctr_admin_table_posts_per_page', '50'),
                ('post_template_class', 'post'),
                ('lang', 'en');
        ";
        $wpdb->query($sql);
    }
}

/**
 * FUNCTION FOR PLUGIN DEACTIVATION
 */
function ctr_plugin_uninstall() {
    /*global $wpdb;

    $table_tmp_clicks = CTR_PREFIX . "clicks_tmp";
    $table_clicks_index = CTR_PREFIX . "clicks_index";
    $table_clicks_category = CTR_PREFIX . "clicks_category";
    $table_clicks_tags = CTR_PREFIX . "clicks_tags";
    $table_settings = CTR_PREFIX . "settings";

    $deletetmpclicks = "drop table if exists $table_tmp_clicks";
    $deleteclicksindex = "drop table if exists $table_clicks_index";
    $deleteclickscategory = "drop table if exists $table_clicks_category";
    $deleteclickstags = "drop table if exists $table_clicks_tags";
    $deletesettings = "drop table if exists $table_settings";

    $table = $wpdb->prefix . 'postmeta';
    $sql = "DELETE FROM `$table` WHERE meta_key LIKE 'post_displays_ctr_%';";
    $wpdb->query($sql);

    $table = $wpdb->prefix . 'term_taxonomy';
    $sql = "DELETE FROM `$table` WHERE taxonomy='ctr_category_click' OR taxonomy='ctr_tag_click';";
    $wpdb->query($sql);
    $wpdb->query($deletetmpclicks);
    $wpdb->query($deleteclicksindex);
    $wpdb->query($deleteclickscategory);
    $wpdb->query($deleteclickstags);
    $wpdb->query($deletesettings);
    */
}

if (version_compare(PHP_VERSION, '5.5.0') < 0) {
    include_once('plugger.php');
} else {
    include_once('plugger_5.php');
}
?>
