<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Adds AccessPress Social Icons Widget
 */
class APSC_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'apsc_widget', // Base ID
                __('AccessPress Social Counter', 'accesspress-social-counter'), // Name
                array('description' => __('AccessPress Social Counter Widget', 'accesspress-social-counter')) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if(isset($instance['theme']) && $instance['theme']!='')
        {
            echo do_shortcode('[aps-counter theme="'.$instance['theme'].'"]');
        }
        else
        {
            echo do_shortcode('[aps-counter]');    
        }
        
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = isset($instance['title'])?$instance['title']:'';
        $theme = isset($instance['theme'])?$instance['theme']:'';
        ?>
        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'accesspress-social-counter'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Theme:', 'accesspress-social-counter'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>" >
                <option value="">Default</option>
                <?php for($i=1;$i<=5;$i++){
                    ?>
                    <option value="theme-<?php echo $i;?>" <?php selected($theme,'theme-'.$i);?>>Theme <?php echo $i;?></option>
                    <?php
                }?>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        //die(print_r($new_instance));
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['theme'] = (!empty($new_instance['theme']) ) ? strip_tags($new_instance['theme']) : '';
        return $instance;
    }

}

// class APS_PRO_Widget
?>