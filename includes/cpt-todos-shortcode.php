<?php
class Todo_Shortcode
{
    public function __construct()
    {
        add_shortcode('todos', [$this, 'todo_shortcode']);
    }
// List todos
    public function todo_shortcode($atts, $content = null)
    {
        global $post;

        $atts = shortcode_atts(array(
            'title' => 'Todos',
            'count' => 10,
            'category' => 'all',
        ), $atts);

        // Check Category
        if ($atts['category'] == 'all') {
            $terms = '';
        } else {
            $terms = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $atts['category'],
                ));
        }

        // Query Args
        $args = array(
            'post_type' => 'todo',
            'post_status' => 'publish',
            'orderby' => 'created',
            'order' => 'DESC',
            'posts_per_page' => $atts['count'],
            'tax_query' => $terms,
        );

        // Fetch todos
        $todos = new WP_Query($args);

        // Check for todos
        if ($todos->have_posts()) {
            $category = str_replace('-', ' ', $atts['category']);
            $category = strtolower($category);
// Get Field values
            $output = '';
            $output .= '<div class="todo-list">';

            while ($todos->have_posts()) {
                $todos->the_post();

                $due_date = get_post_meta($post->ID, 'due_date', true);
                $priority = get_post_meta($post->ID, 'priority', true);
                $details = get_post_meta($post->ID, 'details', true);

                $output .= '<div class="todo">';
                $output .= '<h3 class="title priority-' . strtolower($priority) . ' ">' . get_the_title() . '</h3>';
                $output .= '<div class="details">' . $details . '</div>';
                $output .= '<div>' . $priority . '</div>';
                $output .= ' <div class="date">' . $due_date . '</div>';
                $output .= '</div>';
            }
            $output .= '</div>';
            // Reset Post Data
            wp_reset_postdata();
            return $output;

        } else {
            return '<p>No Todos Found</p>';
        }
    }
}
new Todo_Shortcode();
