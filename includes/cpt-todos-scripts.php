<?php
class CPT_TODOS_Scripts
{
    public function __construct()
    {
        $this->version = time();
        add_action('plugins_loaded', [$this, 'load_textdomain']);
        add_action('wp_enqueue_scripts', [$this, 'load_cpt_todos_assets_public']);
        add_action('admin_enqueue_scripts', [$this, 'load_cpt_todos_assets_admin']);

    }
    public function load_textdomain()
    {
        load_plugin_textdomain('cpt-todos', false, plugin_dir_path(__FILE__) . '/languages');
    }
    public function load_cpt_todos_assets_public()
    {
        wp_enqueue_style('cpt-todos-style', PUBLIC_DIR . '/css/style.css', null, $this->version);
        wp_enqueue_script('cpt-todos-script', PUBLIC_DIR . '/js/main.js', ['jquery'], $this->version, true);
    }
    public function load_cpt_todos_assets_admin()
    {
        wp_enqueue_style('cpt-todos-style', ADMIN_DIR . '/css/style.css', null, $this->version);
        wp_enqueue_script('cpt-todos-script', ADMIN_DIR . '/js/main.js', ['jquery'], $this->version, true);
    }
}
new CPT_TODOS_Scripts();
