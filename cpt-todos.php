<?php
/**
 * Plugin Name: CPT TODOS
 * Plugin URI: https://talib.netlify.com
 * Description: simple todos project with brad traversy
 * Version: 1.0.0
 * Author: TALIB
 * Author URI: https://talib.netlify.com
 * Domain Path: /languages/
 * Text Domain: cpt-todos
 */

 if(!defined('ABSPATH')){
     exit;
 }

 define('PUBLIC_DIR', plugin_dir_url(__FILE__) . 'assets/public');
define('ADMIN_DIR', plugin_dir_url(__FILE__) . 'assets/admin');

require_once plugin_dir_path(__FILE__) . '/includes/cpt-todos-scripts.php';
require_once plugin_dir_path(__FILE__) . '/includes/cpt-todos-shortcode.php';

if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . '/includes/cpt-todos-metabox.php';
    require_once plugin_dir_path(__FILE__) . '/includes/cpt-todos-fields.php';
}
