<?php

class SlimWriterOptions
{
    private $_actions = array(
        'admin_init', 'admin_menu'
    );

    private $_filters = array(
    );

    private $slug = 'slimwriter-theme-options';
    private $options = null;

    public function __construct()
    {
        $this->options = get_option('slimwriter_theme_options');

        foreach($this->_actions as $action){
            if(is_array($action)){
                add_action($action[0], array($this, $action[0]), $action[1], $action[2]);
            }else{
                add_action($action, array($this, $action));
            }
        }
        /*
        foreach($this->_filters as $filter){
            if(is_array($filter)){
                add_filter($filter[0], array($this, $filter[0]), $filter[1], $filter[2]);
            }else{
                add_filter($filter, array($this, $filter));
            }
        }
         */
    }

    public function get_slug(){ return $this->slug; }
    public function get_opt(){ return $this->options; }

    public function admin_init(){
        register_setting( 'slimwriter_options_group', 'slimwriter_theme_options', array($this, 'sanitize') );
        add_settings_section('slimwriter-main-section', 'Main Settings', array($this, 'section_main'), $this->slug);
        add_settings_field('logo', 'Heading', array($this, 'input_logo'), $this->slug, 'slimwriter-main-section');

        add_settings_section('slimwriter-tracking-section', 'Tracking Settings', array($this, 'section_tracking'), $this->slug);
        add_settings_field('tracking_code', 'Tracking Code', array($this, 'input_tracking_code'), $this->slug, 'slimwriter-tracking-section');
    }

    public function sanitize($new_options){
        if(!empty($_FILES['slimwriter_logo_upload']['tmp_name'])){
            $override = array('test_form' => false);
            $file = wp_handle_upload($_FILES['slimwriter_logo_upload'], $override);

            $new_options['logo'] = $file['url'];
        }else{
            $new_options['logo'] = $this->options['logo'];
        }

        if($_POST['slimwriter_remove_logo'] == '1'){
            $new_options['logo'] = '';
        }
        return $new_options;
    }

    // Section: subscription
    public function section_main(){
    }
    public function input_logo(){
        if(!empty($this->options['logo'])){
            echo sprintf('<img src="%s" /><br/>', $this->options['logo']);
            echo '<label><input name="slimwriter_remove_logo" type="checkbox" value="1" /> Remove logo</label><br/>';
        }
        echo sprintf('<input name="slimwriter_logo_upload" type="file" />');
    }
    // Section: tracking
    public function section_tracking(){
    }
    public function input_tracking_code(){
        echo sprintf('<textarea name="slimwriter_theme_options[tracking_code]" rows="5" cols="60">%s</textarea>',
            esc_textarea($this->options['tracking_code']));
    }

    public function admin_menu(){
        add_theme_page('Theme Options', 'Theme Options', 'administrator', $this->slug, array($this, 'options_page'));
    }

    public function options_page(){?>
<div class="wrap">
    <h2>Slim Theme Options</h2>
    <form action="options.php" method="post" enctype="multipart/form-data">
        <?php settings_fields('slimwriter_options_group'); ?>
        <?php do_settings_sections($this->slug); ?>

        <p class="submit"><input type="submit" class="button-primary" value="Update Settings" /></p>
    </form>
</div>
    <?php
    }
};