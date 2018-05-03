<div class="apsc-boards-tabs" id="apsc-board-social-profile-settings">

    <div class="apsc-tab-wrapper">
        <!---Facebook-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Facebook', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[facebook][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['facebook']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Facebook Page ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[facebook][page_id]" value="<?php echo esc_attr($apsc_settings['social_profile']['facebook']['page_id']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the page ID or page name.For example:If your page url is https://www.facebook.com/AccessPressThemes then your page ID is AccessPressThemes.', 'accesspress-social-counter'); ?></div>
                        
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Facebook App ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[facebook][app_id]" value="<?php echo isset($apsc_settings['social_profile']['facebook']['app_id'])?esc_attr($apsc_settings['social_profile']['facebook']['app_id']):'';?>"/>
                        <div class="apsc-option-note"><?php _e('Please go to <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a> and create an app and get the App ID', 'accesspress-social-counter'); ?></div>
                        
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Facebook App Secret', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[facebook][app_secret]" value="<?php echo isset($apsc_settings['social_profile']['facebook']['app_secret'])?esc_attr($apsc_settings['social_profile']['facebook']['app_secret']):'';?>"/>
                        <div class="apsc-option-note"><?php _e('Please go to <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a> and create an app and get the App Secret', 'accesspress-social-counter'); ?></div>
                        
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Facebook Default Count', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[facebook][default_count]" value="<?php echo isset($apsc_settings['social_profile']['facebook']['default_count'])?esc_attr($apsc_settings['social_profile']['facebook']['default_count']):'';?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the default count for facebook to show whenever the API is unavailable.', 'accesspress-social-counter'); ?></div>
                        
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="facebook"] to get the Facebook Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!---Facebook-->
        
        <!--Twitter-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Twitter', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[twitter][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['twitter']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Twitter Username', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[twitter][username]" value="<?php echo esc_attr($apsc_settings['social_profile']['twitter']['username']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the twitter username.For example:apthemes', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Twitter Consumer Key', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[twitter][consumer_key]" value="<?php echo esc_attr($apsc_settings['social_profile']['twitter']['consumer_key']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please create an app on Twitter through this link:', 'accesspress-social-counter'); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Twitter Consumer Secret', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[twitter][consumer_secret]" value="<?php echo esc_attr($apsc_settings['social_profile']['twitter']['consumer_secret']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please create an app on Twitter through this link:', 'accesspress-social-counter'); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Twitter Access Token', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[twitter][access_token]" value="<?php echo esc_attr($apsc_settings['social_profile']['twitter']['access_token']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please create an app on Twitter through this link:', 'accesspress-social-counter'); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Twitter Access Token Secret', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[twitter][access_token_secret]" value="<?php echo esc_attr($apsc_settings['social_profile']['twitter']['access_token_secret']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please create an app on Twitter through this link:', 'accesspress-social-counter'); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps </a><?php _e(' and get this information.'); ?></div>
                    </div>
                </div>

            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="twitter"] to get the Twitter Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Twitter-->
        
        <!--Google Plus-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Google Plus', 'accesspress-social-counter'); ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[googlePlus][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['googlePlus']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Google Plus Page Name or Profile ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[googlePlus][page_id]" value="<?php echo esc_attr($apsc_settings['social_profile']['googlePlus']['page_id']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the page name or profile ID.For example:If your page url is https://plus.google.com/+BBCNews then your page name is +BBCNews', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Google API Key', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[googlePlus][api_key]" value="<?php echo esc_attr($apsc_settings['social_profile']['googlePlus']['api_key']);?>"/>
                        <div class="apsc-option-note">
                        <p><?php _e('To get your API Key, please go to <a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a> and follow below steps.','accesspress-social-counter');?></p>
                        <ol>
                            <li> <?php _e('Click on create project.','accesspress-social-counter');?></li>
                            <li> <?php _e('Enter project name and click create, A new page will load with newly created app dashboard.','accesspress-social-counter');?></li>
                            <li> <?php _e('In the blue API box click on "Enable and manage APIs".','accesspress-social-counter');?></li>
                            <li> <?php _e('Enable google+ api by clicking on it.','accesspress-social-counter');?></li>
                            <li> <?php _e('Now click on credentials tab.','accesspress-social-counter');?></li>
                            <li> <?php _e('When you click on "Create Credentials" button, options will appear.','accesspress-social-counter');?></li> 
                            <li> <?php _e('Now click on API key, a popup will appear.','accesspress-social-counter');?></li>
                            <li> <?php _e('Now click on Browser key.','accesspress-social-counter');?></li>
                            <li> <?php _e('Copy the browser key and paste in the above field.','accesspress-social-counter');?></li>
                        </ol>
                        <p class="description">
                        <?php _e('If still, the count is not displaying then there may be a privacy issue within the google+ account.You may need to public some of your settings in it.Please chek in the below screenshot:','accesspress-social-counter');?>
                        </p>
                        <a href="https://i.imgur.com/4zbtqKH.png" target="_blank">https://i.imgur.com/4zbtqKH.png</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="googlePlus"] to get the Google Plus Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Google Plus-->
        
        <!--Instagram-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Instagram', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[instagram][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['instagram']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Instagram Username', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[instagram][username]" value="<?php echo esc_attr($apsc_settings['social_profile']['instagram']['username']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the instagram username', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Instagram User ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[instagram][user_id]" value="<?php  echo esc_attr($apsc_settings['social_profile']['instagram']['user_id']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the instagram user ID.You can get this information from <a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">http://www.pinceladasdaweb.com.br/instagram/access-token/</a>', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Instagram Access Token', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[instagram][access_token]" value="<?php echo esc_attr($apsc_settings['social_profile']['instagram']['access_token']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the instagram Access Token.You can get this information from <a href="http://instagram.pixelunion.net/" target="_blank">http://instagram.pixelunion.net/</a>', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="instagram"] to get the Instagram Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Instagram-->
        
        <!--Youtube-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Youtube', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[youtube][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['youtube']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Youtube Channel ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[youtube][channel_id]" value="<?php echo isset($apsc_settings['social_profile']['youtube']['channel_id'])?esc_attr($apsc_settings['social_profile']['youtube']['channel_id']):'';?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the youtube channel ID.Your channel ID looks like: UC4WMyzBds5sSZcQxyAhxJ8g. And please note that your channel ID is different from username.Please go <a href="https://support.google.com/youtube/answer/3250431?hl=en" target="_blank">here</a> to know how to get your channel ID.', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Youtube Channel URL', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[youtube][channel_url]" value="<?php echo esc_attr($apsc_settings['social_profile']['youtube']['channel_url']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the youtube channel URL.For example:https://www.youtube.com/user/accesspressthemes', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Youtube API Key', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[youtube][api_key]" value="<?php echo isset($apsc_settings['social_profile']['youtube']['api_key'])?esc_attr($apsc_settings['social_profile']['youtube']['api_key']):'';?>"/>
                        <div class="apsc-option-note"><?php _e('To get your API Key, first create a project/app in <a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a> and then turn on both Youtube Data and Analytics API from "APIs & auth >APIs inside your project.Then again go to "APIs & auth > APIs > Credentials > Public API access" and then click "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, and then copy your API key and paste in above field.', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Default Subscribers Count', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[youtube][subscribers_count]" value="<?php echo isset($apsc_settings['social_profile']['youtube']['subscribers_count'])?esc_attr($apsc_settings['social_profile']['youtube']['subscribers_count']):0;?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter total number of subscribers that your youtube channel has in case the API fetching is failed for automatic update.', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="youtube"] to get the Youtube Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Youtube-->
        
        <!--Sound Cloud-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Sound Cloud', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[soundcloud][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['soundcloud']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('SoundCloud Username', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[soundcloud][username]" value="<?php echo $apsc_settings['social_profile']['soundcloud']['username'];?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the SoundCloud username.For example:bchettri', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('SoundCloud Client ID', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[soundcloud][client_id]" value="<?php echo esc_attr($apsc_settings['social_profile']['soundcloud']['client_id']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the SoundCloud APP Client ID.You can get this information from <a href="http://soundcloud.com/you/apps/new">http://soundcloud.com/you/apps/new</a> after creating a new app', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="soundcloud"] to get the SoundCloud Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Sound Cloud-->
        
        <!--Dribbble-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Dribbble', 'accesspress-social-counter') ?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter', 'accesspress-social-counter') ?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[dribbble][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['dribbble']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label><?php _e('Dribbble Username', 'accesspress-social-counter'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="social_profile[dribbble][username]" value="<?php echo esc_attr($apsc_settings['social_profile']['dribbble']['username']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter your dribbble username.For example:Creativedash', 'accesspress-social-counter'); ?></div>
                    </div>
                </div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="dribbble"] to get the Dribbble Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Dribbble-->
        
        <!--Posts-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e("Posts",'accesspress-social-counter')?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter','accesspress-social-counter');?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[posts][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['posts']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="posts"] to get the Posts Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Posts-->
        
        <!--Comments-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e("Comments",'accesspress-social-counter');?></h4>
            <div class="apsc-option-inner-wrapper">
                <label><?php _e('Display Counter','accesspress-social-counter');?></label>
                <div class="apsc-option-field"><label><input type="checkbox" name="social_profile[comments][active]" value="1" class="apsc-counter-activation-trigger" <?php if(isset($apsc_settings['social_profile']['comments']['active'])){?>checked="checked"<?php } ?>/><?php _e('Show/Hide', 'accesspress-social-counter'); ?></label></div>
            </div>
            <div class="apsc-extra-note"><?php _e('Please use: [aps-get-count social_media="comments"] to get the Comments Count only.You can also pass count_format parameter too in this shortcode to format your count.Formats are "short" for abbreviated format and "comma" for comma separated formats.');?></div>
        </div>
        <!--Comments-->
        
      </div>

</div>
