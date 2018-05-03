<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * Array
(
    [action] => apsc_settings_action
    [social_profile] => Array
        (
            [facebook] => Array
                (
                    [page_id] => 
                )

            [twitter] => Array
                (
                    [username] => 
                    [cosumer_key] => 
                    [cosumer_secret] => 
                    [access_token] => 
                    [access_token_secret] => 
                )

            [googlePlus] => Array
                (
                    [page_id] => 
                    [api_key] => 
                )

            [instagram] => Array
                (
                    [username] => 
                    [access_token] => 
                )

            [youtube] => Array
                (
                    [username] => 
                    [channel_url] => 
                )

            [soundcloud] => Array
                (
                    [username] => 
                    [client_id] => 
                )

            [dribbble] => Array
                (
                    [username] => 
                )

        )

    [profile_order] => Array
        (
            [0] => facebook
            [1] => twitter
            [2] => googlePlus
            [3] => instagram
            [4] => soundcloud
            [5] => dribbble
            [6] => youtube
            [7] => posts
            [8] => comments
        )

    [cache_period] => 
    [apsc_settings_nonce] => ddf794f2f0
    [_wp_http_referer] => /accesspress-social-counter/wp-admin/admin.php?page=ap-social-counter
    [ap_settings_submit] => Save all changes
)
 */
//$this->print_array($_POST);die();
foreach($_POST as $key=>$val)
{
    $$key = $val;
}
$apsc_settings = array();//array for saving all the settings
$apsc_settings['social_profile'] = $social_profile;
$apsc_settings['profile_order'] = $profile_order;
$apsc_settings['cache_period'] = $cache_period;
$apsc_settings['social_profile_theme'] = $social_profile_theme;
$apsc_settings['counter_format'] = $counter_format;
$apsc_settings['disable_font_css'] = isset($disable_font_css)?1:0;
$apsc_settings['disable_frontend_css'] = isset($disable_frontend_css)?1:0;
update_option('apsc_settings', $apsc_settings);
wp_redirect(admin_url().'admin.php?page=ap-social-counter&message=1');



