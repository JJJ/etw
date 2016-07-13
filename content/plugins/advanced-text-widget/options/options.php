<?php
if(!class_exists('Plugin_Admin_Class_0_2')){
    require_once ATW_LIB . '/wp_plugin_admin.php';
}

class atw_Admin extends Plugin_Admin_Class_0_2 {    
    var $hook       = 'atw';
    //var $longname = 'Advanced Text Widget Options';
    //var $shortname    = 'ATW Plugin';
    var $filename   = 'advanced-text-widget/advancedtext.php';
    var $optionname = 'atw';
    var $menu       = true;
    var $prefix     = 'atw_';    

    var $credits = array(
                    'download_url'  => 'http://wordpress.org/extend/plugins/advanced-text-widget/', //plugin page on wp.org
                    'official_url'  => 'http://wordpress.org/extend/plugins/advanced-text-widget/', //plugin page on author's website
                    'author_url'    => 'http://wordpress.org/extend/plugins/profile/maxchirkov',
                    'sponsored_by'  => '<a href="http://simplerealtytheme.com">SimpleRealtyTheme.com</a>',
                    'forums_url'    => 'http://wordpress.org/tags/advanced-text-widget?forum_id=10',
                );
    var $default_options = array(
        'condition' => array(
            array(
                'name'  => 'All',
                'code'  => 'true',
                ),
            array(
                'name'  => 'Home Page',
                'code'  => 'is_home()',
                ),
            array(
                'name'  => 'Front Page',
                'code'  => 'is_front_page()',
                ),
            array(
                'name'  => 'Page',
                'code'  => 'is_page($arg)',
                ),
            array(
                'name'  => 'Single Post',
                'code'  => 'is_single($arg)',
                ),
            array(
                'name'  => 'Post in Category',
                'code'  => 'in_category($arg)',
                ),
            array(
                'name'  => 'Category',
                'code'  => 'is_category($arg)',
                ),
            array(
                'name'  => 'Blog',
                'code'  => 'is_home() || is_single() || is_archive()',
                ),
            array(
                'name'  => 'Search Results Page',
                'code'  => 'is_search()',
                ),
            array(
                'name'  => 'Child of Page ID',
                'code'  => '(int)$arg == $post->post_parent',
                ),
            )
        );


    function __construct()
    {
        if (isset($_POST['reset-atw-settings']) && $_POST['reset-atw-settings'] == 1)
        {
            update_option($this->optionname, $this->default_options);
        }

        parent::__construct();
    }

    function localize(){
        $this->set_longname(__('Advanced Text Widget Options', $this->hook));
        $this->set_shortname(__('ATW Plugin', $this->hook));
        //$this->set_var( 'longname', __('Advanced Text Widget Options', $this->hook) );       
    }
    
    //update from old widgets to new
    function auto_update(){
        if($widgets = get_option('widget_advanced_text')){

            $convert = array(
                'all'               => 0,
                'home'              => 1,
                'post'              => 4,
                'post_in_category'  => 5,
                'page'              => 3,
                'category'          => 6,
                'blog'              => 7,
                'search'            => 8,
                );
                $new_widgets = $widgets;
            //check is any 'show' keys have numeric values 
            $update = false;           
            foreach($new_widgets as $key => $widget){
                if(isset($widget['show']) && !is_numeric($widget['show'])){
                    $new_widgets[$key]['show'] = $convert[$widget['show']];
                    $update = true;
                }
            }                        

            if($update){
                update_option('widget_advanced_text', $new_widgets);
                add_option('widget_advanced_text_old');
                update_option('widget_advanced_text_old', $widgets);
            }
        }
    }

    function settings($key = null){
        
        $add_button = array(
                    //'label'       => __('Add New Condition'),                    
                    'id'        => 'condition-add-new',
                    'type'      => 'input',
                    'attr'      => array('type' => 'button', 'value' => __('Add New Condition', $this->hook), 'class' => 'button'),
                );
    
       $conditions = array(                
                array(
                    'label'     => sprintf(__('Name %d', $this->hook), 1),                    
                    'id'        => array('condition', 0, 'name'),
                    'type'      => 'text',
                    'attr'      => array('size' => 30),                    
                ),
                array(
                    'label'     => sprintf(__('Code %d', $this->hook), 1),                    
                    'id'        => array('condition', 0, 'code'),
                    'type'      => 'text',
                    'attr'      => array('size' => 60),                
                ),                 
                $add_button
            );

       $options = $this->options;

       if(!empty($options))
       {
           if(isset($options['condition'][0]))
           {
               $conditions = array();

               foreach($options['condition'] as $k => $item)
               {
                    $n = $k + 1;
                   $conditions[] = array(
                        'label'     => sprintf(__('Name %d', $this->hook), $n),                    
                        'id'        => array('condition', $k, 'name'),
                        'type'      => 'text',
                        'attr'      => array('size' => 30),
                        'default'   => $item['name'],                        
                    );
                    $conditions[] = array(
                        'label'     => sprintf(__('Code %d', $this->hook), $n),                    
                        'id'        => array('condition', $k, 'code'),
                        'type'      => 'text',
                        'attr'      => array('size' => 60),
                        'default'   => $item['code'],                        
                    );
               }

               $conditions[] = $add_button;
           }
           
       }

        $settings = array(
            'Widget Visibility Conditions'       => $conditions,            
        );

        $settings = apply_filters('atw_settings_array', $settings);

        if($key){
            return $settings[$key];
        }
        //settings have to return a regular array of fields - no section
        foreach($settings as $section => $fields){
            foreach($fields as $field){
                $settings_array[] = $field;
            }
        }
        return $settings_array;
    }


    function validate_input($input){        
        foreach($input['condition'] as $k => $v){
            
                if(empty($v['name']) && empty($v['code']))
                    unset($input['condition'][$k]);
            
        }
        return $input;
    }


    function config_page(){   
        $this->add_column(1, '69%');
        $this->add_box(__('Widget Visibility Conditions', $this->hook), $this->settings('Widget Visibility Conditions'), 1);
        do_action('atw_add_boxes');
        //$this->add_box('Misc. Settings', $this->settings('Misc. Settings'), 1);
        //Generate Config Page
        $this->_config_page_template();

        $this->resetForm();
    }


    function resetForm()
    {
        ?>
        <script>
            jQuery(document).ready(
                function()
                {
                    var submitBtn = jQuery('#atw-conf input[name="submit"]').last();
                    var resetBtn = jQuery('<input class="button" type="button" name="reset_settings" value="Reset Settings">').css({'display' : 'inline-block', 'margin' : '0 10px 0 0'});

                    submitBtn.before(resetBtn).css({'display' : 'inline-block'});

                    resetBtn.click(
                        function()
                        {
                            var message = 'All current settings will be deleted. Are you sure you want to reset to default settings?';
                            if (confirm(message))
                            {
                                jQuery('#atw_reset_settings').submit();
                            }
                        }
                    );
                }
            );
        </script>
        <form name="atw_reset_settings" id="atw_reset_settings" method="post">
            <input type="hidden" name="reset-atw-settings" value="1">
        </form>
    <?php
    }


    function plugin_donate(){        
        $content = '<div style="text-align: center">';
        $content .= sprintf(__('Check out <a href="%s" target="_blank"><strong>Advanced Text Widget PRO!</strong></a> - it\'s inexpensive and comes with great features.', $this->hook), 'http://simplerealtytheme.com/plugins/atw-pro/');
        $content .= '</div>';
        $buy_pro = $this->postbox(__('Get Advanced Text Widget PRO!', $this->hook), $content, $this->hook.'donate');
        $buy_pro = apply_filters('atw_get_pro_version', $buy_pro);
        return $buy_pro;
    }

    function credits_column(){
                    $output = $this->plugin_like();
                    $output .= $this->plugin_donate();
                    $output .= $this->plugin_support();
                    $output .= $this->plugin_credits();                    
                    return $output;
                }
    
    function contextual_help() {                

        $contextual_help = '<H3>Advanced Text Widget Help</H3>
        <p>All code is executed inside this condition: <code>IF( YOUR CODE ){ return TRUE; }else{ return FALSE; }</code>. So make sure your code doesn\'t break the <code>IF</code> section.</p>
        <p>If your condition supports arguments (page id, slug, title), then use variable <code>$arg</code> for a single function, and $argN for multiple functions, where N is a number.<br/>Example 1: <code>is_single($arg)</code>. Example 2: <code>is_single($arg1) && !in_category($arg2)</code>. When using multiple arguments that are assigned to different functions, you can divide their values with pipe symbol "|" when entering into the Slug/Title/ID filed on the widgets page. Multiple arguments that belong to the same function should be delimited by comma.</p>
        <p>Please note that each <code>$arg</code> is exploded and executed as an array. <br>For example: <code>is_single($arg)</code> is executed as <code>is_single(explode(",", $arg))</code>.</p>
        <p>For mor details on functions that you can use read <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">WP Codex on Conditional Tags</a></p>';
        
        return $contextual_help;
    }     
}