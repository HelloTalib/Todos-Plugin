<?php
class TodosMetabox
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'add_todo_metabox']);
        add_action('save_post', [$this, 'save_todo_metabox']);
    }
    public function add_todo_metabox()
    {
        add_meta_box(
            'todo_metabox_fields',
            __('Todo Metabox Fields', 'cpt-todos'),
            [$this, 'todo_metabox_fields_callback'],
            ['todo'],
        );
    }

    // SEQURITY CHECK
    private function is_secured($action, $nonce_field, $post_id)
    {
        $nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';

        if ($nonce == '') {
            return false;
        }
        if (!wp_verify_nonce($nonce, $action)) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        if (wp_is_post_autosave($post_id)) {
            return false;
        }

        if (wp_is_post_revision($post_id)) {
            return false;
        }

        return true;

    }

// SAVE DATA
    public function save_todo_metabox($post_id)
    {
        //varify nonce
        if (!$this->is_secured('todo_metabox_action', 'todo_metabox_field', $post_id)) {
            return $post_id;
        }

        //input content due_date
        $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
        $due_date = sanitize_text_field($due_date);
        update_post_meta($post_id, 'due_date', $due_date);

        //input content checkbox
        $checkbox = isset($_POST['checkbox']) ? $_POST['checkbox'] : '';
        $checkbox = sanitize_text_field($checkbox);
        update_post_meta($post_id, 'checkbox', $checkbox);

        //input content priority
        $priority = isset($_POST['priority']) ? $_POST['priority'] : '';
        $priority = sanitize_text_field($priority);
        update_post_meta($post_id, 'priority', $priority);

        //input content details
        $details = isset($_POST['details']) ? $_POST['details'] : '';
        $details = sanitize_text_field($details);
        update_post_meta($post_id, 'details', $details);

    }

    // ADMIN CONTENT
    public function todo_metabox_fields_callback($post)
    {
        // nonce
        wp_nonce_field('todo_metabox_action', 'todo_metabox_field');

        //input content due_date
        $label_due_date = __(ucfirst('date'), 'cpt-todos');
        $due_date = get_post_meta($post->ID, 'due_date', true);

        // input content checkbox
        $label_checkbox = __('Checkbox', 'cpt-todos');
        $checkbox = get_post_meta($post->ID, 'checkbox', true);
        $checked = $checkbox == 1 ? 'checked' : '';

        // input content dropbox
        $label_priority = __(ucfirst('priority'), 'cpt-todos');
        $priority = get_post_meta($post->ID, 'priority', true);
        $priority_values = ['Low', 'Normal', 'High'];
        $priority_html = "<select id='priority' name='priority'>";
        foreach ($priority_values as $key => $value) {
            if ($value == $priority) {
                $priority_html .= "<option selected>$value</option>";
            } else {
                $priority_html .= "<option>$value</option>";
            }
        }
        $priority_html .= "</select>";

        //details
        $label_details = __(ucfirst('details'), 'cpt-todos');
        $details = get_post_meta($post->ID, 'details', true);
        $editor = 'details';
        $settings = [
            'textarea_rows' => 5,
            'media_buttons' => false,
        ];
?>
        <div class="wrap todo-form>
            <div class="form-group">
                <label for="due_date"><?php echo $label_due_date;?></label>
                <input type="date" name="due_date" id="due_date" value="<?php echo $due_date;?>"/>
            </div>
            <div class="form-group">
                <label for="checkbox"><?php echo $label_checkbox;?></label>
                <input type="checkbox" name="checkbox" id="checkbox" value="1" <?php echo $checked;?>>
                </div>
            <div class="form-group">
                <label for="priority"><?php echo $label_priority;?></label>
                <?php echo $priority_html;?>
            </div>
            <div class="form-group">
               <label for="details"><?php echo $label_details; ?></label>
               <?php echo wp_editor($details, $editor, $settings); ?>
            </div>
       </div>
        <?php

    }

}
new TodosMetabox();
