<?php
defined('ABSPATH') or die("No script kiddies please!");

$apsc_settings = $this->apsc_settings;
$cache_period = ($apsc_settings['cache_period'] != '') ? $apsc_settings['cache_period']*60*60 : 24 * 60 * 60;

$apsc_settings['social_profile_theme'] = isset($atts['theme'])?$atts['theme']:$apsc_settings['social_profile_theme']; 
$format = isset($apsc_settings['counter_format'])?$apsc_settings['counter_format']:'comma';
?>
<div class="apsc-icons-wrapper clearfix apsc-<?php echo $apsc_settings['social_profile_theme']; ?>" >
    <?php
    foreach ($apsc_settings['profile_order'] as $social_profile) {
        if (isset($apsc_settings['social_profile'][$social_profile]['active']) && $apsc_settings['social_profile'][$social_profile]['active'] == 1) {
            ?>
            <div class="apsc-each-profile">
                <?php
                $count = $this->get_count($social_profile);
                $count = ($count!=0)?$this->get_formatted_count($count,$format):$count;
                switch ($social_profile) {
                    case 'facebook':
                        $facebook_page_id = $apsc_settings['social_profile']['facebook']['page_id'];
                        ?>
                        <a  class="apsc-facebook-icon clearfix" href="<?php echo "https://facebook.com/" . $facebook_page_id; ?>" target="_blank" <?php do_action('apsc_facebook_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="fa fa-facebook apsc-facebook"></i><span class="media-name">Facebook</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Fans</span>
                            </div>
                        </a>
                            <?php
                            break;
                        case 'twitter':
                              ?>
                        <a  class="apsc-twitter-icon clearfix"  href="<?php echo 'https://twitter.com/'.$apsc_settings['social_profile']['twitter']['username'];?>" target="_blank"  <?php do_action('apsc_twitter_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="fa fa-twitter apsc-twitter"></i><span class="media-name">Twitter</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Followers</span>
                            </div>
                        </a>
                    <?php
                        break;
                    case 'googlePlus':
                        $social_profile_url = 'https://plus.google.com/' . $apsc_settings['social_profile']['googlePlus']['page_id'];
                        ?>
                        <a  class="apsc-google-plus-icon clearfix" href="<?php echo $social_profile_url; ?>" target="_blank"  <?php do_action('apsc_googlePlus_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-googlePlus fa fa-google-plus"></i><span class="media-name">google+</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Followers</span>
                            </div>
                        </a>
                        <?php
                            break;
                        case 'instagram':
                            $username = $apsc_settings['social_profile']['instagram']['username'];
                            $user_id = $apsc_settings['social_profile']['instagram']['user_id'];
                            $social_profile_url = 'https://instagram.com/' . $username;
                            ?>
                            <a  class="apsc-instagram-icon clearfix" href="<?php echo $social_profile_url; ?>" target="_blank"   <?php do_action('apsc_instagram_link');?>>
                                <div class="apsc-inner-block">
                                    <span class="social-icon"><i class="apsc-instagram fa fa-instagram"></i><span class="media-name">Instagram</span></span>
                                    <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Followers</span>
                                </div>
                            </a>
                            <?php
                            break;
                        case 'youtube':
                            $social_profile_url = esc_url($apsc_settings['social_profile']['youtube']['channel_url']);
                            ?>
                        <a class="apsc-youtube-icon clearfix" href="<?php echo $social_profile_url; ?>" target="_blank"  <?php do_action('apsc_youtube_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-youtube fa fa-youtube"></i><span class="media-name">Youtube</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Subscriber</span>
                            </div>
                        </a>
                        <?php
                            break;
                        case 'soundcloud':
                            $username = $apsc_settings['social_profile']['soundcloud']['username'];
                            $social_profile_url = 'https://soundcloud.com/' . $username;
                            ?>
                        <a class="apsc-soundcloud-icon clearfix" href="<?php echo $social_profile_url; ?>" target="_blank" <?php do_action('apsc_soundcloud_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-soundcloud fa fa-soundcloud"></i><span class="media-name">Soundcloud</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Followers</span>
                            </div>
                        </a>
                        <?php
                            break;
                        case 'dribbble':
                            $social_profile_url = 'https://dribbble.com/'.$apsc_settings['social_profile']['dribbble']['username'];
                            ?>
                        <a class="apsc-dribble-icon clearfix" href="<?php echo $social_profile_url; ?>" target="_blank" <?php do_action('apsc_dribbble_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-dribbble fa fa-dribbble"></i><span class="media-name">dribble</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Followers</span>
                            </div>
                        </a>
                        <?php
                            break;
                        case 'posts':
                            ?>
                        <a class="apsc-edit-icon clearfix" href="javascript:void(0);" <?php do_action('apsc_posts_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-posts fa fa-edit"></i><span class="media-name">Post</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Post</span>
                            </div>
                        </a>
                        <?php
                            break;
                        case 'comments':
                            ?>
                        <a class="apsc-comment-icon clearfix" href="javascript:void(0);" <?php do_action('apsc_comments_link');?>>
                            <div class="apsc-inner-block">
                                <span class="social-icon"><i class="apsc-comments fa fa-comments"></i><span class="media-name">Comment</span></span>
                                <span class="apsc-count"><?php echo $count; ?></span><span class="apsc-media-type">Comments</span>
                            </div>
                        </a>
                        <?php
                            break;
                        default:
                            break;
                    }
                    ?>
            </div><?php
                }
            }
            ?>
</div>

