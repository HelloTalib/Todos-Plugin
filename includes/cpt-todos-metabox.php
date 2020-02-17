<?php
//create custom post type

class TodosCPT
{
    public function __construct()
    {
        add_action('init', [$this, 'register_todo_list']);
    }
    public function register_todo_list()
    {
        $singular_name = apply_filters('cpt-todos-single', 'Todo');
        $plural_name = apply_filters('cpt-todos-plural', 'Todos');
        $labels = array(
            'name' => $plural_name,
            'singular_name' => $singular_name,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New' . $singular_name,
            'edit' => 'Edit',
            'edit_item' => 'Edit' . $singular_name,
            'new_item' => 'New' . $singular_name,
            'view' => 'View',
            'view_item' => 'View' . $plural_name,
            'search_item' => 'Search' . $plural_name,
            'not_found' => "No" . $plural_name . 'Found',
            'not_found_in_trash' => "No" . $plural_name, 'Found',
        );

        $args = apply_filters('todo_list_args', array(
            'labels' => $labels,
            'description' => 'todos by category',
            'taxonomies' => ['category'],
            'public' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-facebook',
            'capability_type' => 'post',
            'supports' => ['title'],
        ));
        register_post_type('todo', $args);
    }

}
new TodosCPT();
