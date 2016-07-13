<?php
/*
Plugin Name: Advanced Text Widget
Plugin URI: http://simplerealtytheme.com/plugins/atw-pro/
Description: Text widget that has extensive conditional options to display content on pages, posts, specific categories etc. It supports regular HTML as well as PHP code.
Author: Max Chirkov
Version: 2.0.10
Author URI: http://simplerealtytheme.com
*/

if (class_exists('advanced_text'))
{
    function atw_plugin_exists_notice()
    {
        echo '<div class="error"><p>One instance of ATW Plugin is already active. Please de-activate it before activating current version.</p></div>';

        deactivate_plugins( plugin_basename( __FILE__ ) );
    }

    add_action('admin_notices', 'atw_plugin_exists_notice');
}
else
{
    define("ATW_BASENAME", plugin_basename(dirname(__FILE__)));
    define("ATW_DIR", WP_PLUGIN_DIR . '/' . ATW_BASENAME);
    define("ATW_URL", WP_PLUGIN_URL . '/' . ATW_BASENAME);
    define("ATW_LIB", ATW_DIR . '/lib');

    require_once('options/options.php');

    $atw = new atw_Admin();
//    $atw->auto_update();
    register_activation_hook( __FILE__, array($atw, 'plugin_activate'));

    if( defined('ATW_PRO') ){
        include_once ATW_PRO . '/init.php';
    }


    class advanced_text extends WP_Widget {

        function __construct() {
            global $atw;
            /* Widget settings. */
            $widget_ops = array( 'classname' => 'advanced_text', 'description' => __("Advanced text widget with PHP code support.", $atw->hook) );

            /* Widget control settings. */
            $control_ops = array( 'width' => 400, 'height' => 450, 'id_base' => 'advanced_text' );

            /* Create the widget. */
            parent::__construct('advanced_text', __("Advanced Text", $atw->hook), $widget_ops, $control_ops );
        }

        function form($instance) {
            global $atw;

            $title = ( isset($instance['title']) ) ? esc_attr( $instance['title'] ) : false;
            $title = apply_filters('widget_title', $title);
            $text = ( isset($instance['text']) ) ? $instance['text'] : false;

            ?>
            <label for="<?php echo $this->get_field_id('title'); ?>" title="<?php _e('Title above the widget', $atw->hook);?>"><?php _e('Title:', $atw->hook);?><input style="width:400px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
            <p><?php _e('PHP Code (MUST be enclosed in &lt;?php and ?&gt; tags!):', $atw->hook);?></p>
            <label for="<?php echo $this->get_field_id('text'); ?>" title="<?php _e('PHP Code (MUST be enclosed in &lt;?php and ?&gt; tags!):', $atw->hook);?>"><textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" cols="20" rows="16" style="width:400px;"><?php echo format_to_edit($text); ?></textarea></label>

            <?php
            do_action('atw_condition_fields', $this, $instance);
        }

        function update($new_instance, $old_instance) {
            $instance['title'] = strip_tags(stripslashes($new_instance['title']));
            $instance['text'] = $new_instance['text'];

            if( !defined('ATW_PRO') ){
                $instance['action'] = $new_instance['action'];
                $instance['show'] = $new_instance['show'];
                $instance['slug'] = $new_instance['slug'];
                $instance['suppress_title'] = $new_instance['suppress_title'];
            }

            return $instance;
        }

        function widget($args, $instance) {
            extract($args);

            if( !defined('ATW_PRO') ){
                $instance = atw_check_widget_visibility($instance, $this, $args);

                if(!$instance)
                    return;
            }

            $title = ( isset($instance['title']) ) ? esc_attr( $instance['title'] ) : false;
            $title = apply_filters( 'atw_widget_title', $title );
            $text = ( isset($instance['text']) ) ? $instance['text'] : false;

            $wpEmbed = new WP_Embed();
            $text = $wpEmbed->run_shortcode($text);
            $text = apply_filters( 'atw_widget_content', $text, $instance );

            echo $before_widget;
            echo "<div class='AdvancedText'>";
            $title ? print($before_title . $title . $after_title) : null;
            eval('?>'.$text);
            echo "</div>";
            echo $after_widget."\n";

        }

    }

    function advanced_text_do_shortcode(){
        if (!is_admin()){
            add_filter('widget_text', 'do_shortcode', 12);
            add_filter('atw_widget_content', 'shortcode_unautop');
            add_filter('atw_widget_content', 'do_shortcode', 12);
        }
    }

// Tell Dynamic Sidebar about our new widget and its control
    add_action('widgets_init', create_function('', 'return register_widget("advanced_text");'));
    add_action('widgets_init', 'advanced_text_do_shortcode');

    function atw_admin_scripts(){
        $page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
        if ( 'atw' == $page ){
            wp_enqueue_script('postbox');
            wp_enqueue_script('dashboard');
            wp_enqueue_style('dashboard');
            wp_enqueue_style('global');
            wp_enqueue_style('wp-admin');
            wp_register_script( 'atw', ATW_URL . '/js/scripts.js');
            wp_enqueue_script( 'atw' );
        }
    }
    add_action('admin_init', 'atw_admin_scripts');

    add_action('atw_condition_fields', 'atw_add_condition_fields', 10, 2);
    function atw_add_condition_fields($widget, $instance = false){
        global $atw;

        $output = false;

        //check if conditions should apply to ATW only
        if( defined('ATW_PRO') && atw_only() ){
            if( 'advanced_text' !== get_class($widget) )
                return;
        }

        if(!$instance && is_numeric($widget->number)){
            $widget_settings = get_option($widget->option_name);
            $instance = $widget_settings[$widget->number];
        }

        $instance['action'] = (isset($instance['action'])) ? $instance['action'] : 1;
        $instance['slug'] = (isset($instance['slug'])) ? $instance['slug'] : false;
        $instance['suppress_title'] = (isset($instance['suppress_title'])) ? $instance['suppress_title'] : false;

        $allSelected = $dontshowSelected = $showSelected = $homeSelected = $postSelected = $postInCategorySelected = $pageSelected = $categorySelected = $blogSelected = $searchSelected = false;
        switch ($instance['action']) {
            case "1":
                $showSelected = true;
                break;
            case "0":
                $dontshowSelected = true;
                break;
        }

        ?>
        <div class="atw-conditions">
            <?php _e('Widget Visibility:', $atw->hook); ?><br />
            <label for="<?php echo $widget->get_field_id('action'); ?>"  title="<?php _e('Show only on specified page(s)/post(s)/category. Default is All', $atw->hook);?>" style="line-height:35px;">
                <select name="<?php echo $widget->get_field_name('action'); ?>">
                    <option value="1" <?php if ($showSelected){echo "selected";} ?>><?php _e('Show', $atw->hook);?></option>
                    <option value="0" <?php if ($dontshowSelected){echo "selected";} ?>><?php _e('Do NOT show', $atw->hook);?></option>
                </select> <?php _e('on', $atw->hook);?>
                <select name="<?php echo $widget->get_field_name('show'); ?>" id="<?php echo $widget->get_field_id('show'); ?>">

                    <?php
                    if( is_array($atw->options['condition']) && !empty($atw->options['condition']) ){
                        foreach($atw->options['condition'] as $k => $item){
                            $output .= '<option label="' . $item['name'] . '" value="'. $k . '"' . selected(atw_back_compat(@$instance['show'], 'key'), $k) . '>' . $item['name'] .'</option>';
                        }
                    }

                    echo $output;
                    ?>

                </select>
            </label>
            <br/>
            <label for="<?php echo $widget->get_field_id('slug'); ?>"  title="<?php _e('Optional limitation to specific page, post or category. Use ID, slug or title.', $atw->hook);?>"><?php _e('Slug/Title/ID:', $atw->hook);?>
                <input type="text" style="width: 99%;" id="<?php echo $widget->get_field_id('slug'); ?>" name="<?php echo $widget->get_field_name('slug'); ?>" value="<?php echo htmlspecialchars($instance['slug']); ?>" />
            </label>
            <?php
            if ($postInCategorySelected) _e("<p>In <strong>Post In Category</strong> add one or more cat. IDs (not Slug or Title) comma separated!</p>", $atw->hook);
            ?>
            <br />
            <label for="<?php echo $widget->get_field_id('suppress_title'); ?>"  title="<?php _e('Do not output widget title in the front-end.', $atw->hook);?>">
                <input idx="<?php echo $widget->get_field_name('suppress_title'); ?>" name="<?php echo $widget->get_field_name('suppress_title'); ?>" type="checkbox" value="1" <?php checked($instance['suppress_title'],'1', true);?> /> <?php _e('Suppress Title Output', $atw->hook);?>
            </label>
        </div>
        <?php
        $return = null;
    }

    function atw_check_widget_visibility($instance, $widget_obj = null, $args = false){
        global $atw, $post;

        if( false !== $widget_obj && is_object($widget_obj) ){
            //check if conditions should apply to ATW only
            if( defined('ATW_PRO') && atw_only() ){
                if( 'advanced_text' !== get_class($widget_obj) )
                    return $instance;
            }
        }

        if( isset($instance['suppress_title']) && false != $instance['suppress_title']){
            unset($instance['title']);
        }

        if(isset($instance['action'])){
            $action  = $instance['action'];
        }else{
            return $instance;
        }

        if( isset($instance['show']) )
            $show 	 = $instance['show'];

        if( isset($instance['slug']) )
            $slug 	 = $instance['slug'];


        /* Do the conditional tag checks. */
        $arg = explode('|', $slug);

        //Checking if $show in not numeric - in that case we have older version conditions
        if(!is_numeric($show)){
            $code = atw_back_compat($show, 'code');
        }else{
            $code = $atw->options['condition'][$show]['code'];
        }

        $num = count($arg);
        $i = 1;

        foreach($arg as $k => $v){
            $ids = explode(",", $v);
            $str = '';
            $values = array();

            //wrap each value into quotation marks
            foreach($ids as $val){
                if($val !="")
                    $values[] = '"' . $val . '"';
            }


            $str = ( 1 == count($values) ) ? $values[0] : "array(" . implode(',', $values) . ")";


            //if multiple values, then put them into an array
            if( 1 < $num ){
                $code = str_replace('$arg' . $i, $str, $code);
            }else{
                $code = str_replace('$arg', $str, $code);
            }
            $i++;
        }

        if($code != false && $action == "1"){
            $code = "if($code){ return true; }else{ return false; }";

            if(eval($code)){
                return $instance;
            }
        }elseif($code != false){
            $code = "if($code){ return false; }else{ return true; }";
            if(eval($code)){
                return $instance;
            }
        }

        return false;
    }


    /**
     * Print styles in the admin header
     */
    function atw_print_styles(){
        echo '
<style type="text/css">
.widget-inside .atw-conditions {
	background-color: #FCFCFC;
	border: 1px solid #DFDFDF;
	padding: 5px;
	margin: 10px 0;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
</style>
';
    }
    add_action('admin_print_styles', 'atw_print_styles');

//backward compatibility - returns new value
// $item = key or code
    function atw_back_compat($key, $item){

        $old_values = array(
            'all'	=> array(
                'key'	=> '0',
                'code'	=> 'true'
            ),

            'home'	=> array(
                'key'	=> '1',
                'code'	=> 'is_home()'
            ),

            'post'	=> array(
                'key'	=> '4',
                'code'	=> 'is_single($arg)'
            ),

            'post_in_category'	=> array(
                'key'	=> '5',
                'code'	=> 'in_category($arg)'
            ),

            'page'	=> array(
                'key'	=> '3',
                'code'	=> 'is_page($arg)'
            ),

            'category'	=> array(
                'key'	=> '6',
                'code'	=> 'is_category($arg)'
            ),

            'blog'	=> array(
                'key'	=> '7',
                'code'	=> 'is_home($arg) || is_single() || is_archive()'
            ),

            'search'	=> array(
                'key'	=> '8',
                'code'	=> 'is_search()'
            ),
        );

        if( $key != '' && !is_numeric($key) )
            return $old_values[$key][$item];

        return $key;
    }

    add_action('admin_notices', 'atw_admin_notice', 1);
    function atw_admin_notice(){

        //show to non PRO users
        if( defined('ATW_PRO') )
            return;

        //check if it's been dismissed
        if ( get_option('atw-pro-notice') )
            return;

        $url = 'http://simplerealtytheme.com/plugins/atw-pro/?utm_source=wordpress&utm_medium=plugin&utm_content=admin_notice&utm_campaign=atw';

        $text = <<<HTML
  <h4><a href="%s" target="blank">Check out Advanced Text Widget PRO</a></h4>
  <p><strong>PRO Features:</strong><br />
  	- Visibility conditions on ALL widgets.<br />
		- Define custom CSS IDs/Classes for ANY widget.<br />
		- Import/Export your visibility conditions to re-use on other sites.
  </p>
HTML;

        $content = sprintf( $text, $url );

        printf( '<div class="updated" style="overflow: hidden;"><div class="alignleft">'. $content .'</div> <p class="alignright"><a href="%s">Dismiss</a></p></div>', add_query_arg( 'atw-dismiss-notice', 'true' ) );

    }

    add_action('admin_init', 'atw_dismiss_admin_notice');
    function atw_dismiss_admin_notice(){
        if ( !isset($_REQUEST['atw-dismiss-notice']) || $_REQUEST['atw-dismiss-notice'] !== 'true' )
            return;

        update_option( 'atw-pro-notice', 1 );
    }
}