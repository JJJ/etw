<?php 
$count = 0;
            $apsc_settings = $this->apsc_settings;
            $cache_period = ($apsc_settings['cache_period'] != '') ? $apsc_settings['cache_period']*60*60 : 24 * 60 * 60;
            switch($social_media){
                case 'facebook':
                        $facebook_page_id = $apsc_settings['social_profile']['facebook']['page_id'];
                        $facebook_count = get_transient('apsc_facebook');
                            if (false === $facebook_count) {
                                if(isset($apsc_settings['social_profile']['facebook']['app_id'],$apsc_settings['social_profile']['facebook']['app_secret']) && $apsc_settings['social_profile']['facebook']['app_id']!='' && $apsc_settings['social_profile']['facebook']['app_secret']!=''){
                                    $count = $this->new_fb_count();
                                   
                                                                                
                                }else{
                                    $api_url = 'https://www.facebook.com/' . $facebook_page_id;
                                
                                    $count = $this->facebook_count($api_url);
                                    
                                }

                                    set_transient('apsc_facebook', $count, $cache_period);
                                
                            } else {
                                $count = $facebook_count;
                            }
                            
                            $default_count = isset($apsc_settings['social_profile']['facebook']['default_count'])?$apsc_settings['social_profile']['facebook']['default_count']:0;
                            $count = ($count==0)?$default_count:$count;
                            if($count!=0){
                                set_transient('apsc_facebook',$count,$cache_period);
                            }
                            break;
                        case 'twitter':
                            
                        $twitter_count = get_transient('apsc_twitter');
                        if (false === $twitter_count) {
                            $count = ($this->get_twitter_count());
                            set_transient('apsc_twitter', $count, $cache_period);
                        } else {
                            $count = $twitter_count;
                        }
                        
                        
                        break;
                    case 'googlePlus':
                        $social_profile_url = 'https://plus.google.com/' . $apsc_settings['social_profile']['googlePlus']['page_id'];
                        
                            $googlePlus_count = get_transient('apsc_googlePlus');
                            if (false === $googlePlus_count) {
                                $api_url = 'https://www.googleapis.com/plus/v1/people/' . $apsc_settings['social_profile']['googlePlus']['page_id'] . '?key=' . $apsc_settings['social_profile']['googlePlus']['api_key'];
                                $params = array(
                                    'sslverify' => false,
                                    'timeout' => 60
                                );
                                $connection = wp_remote_get($api_url, $params);
                                
                                if (is_wp_error($connection)) {
                                    $count = 0;
                                } else {
                                    $_data = json_decode($connection['body'], true);

                                    if (isset($_data['circledByCount'])) {
                                        $count = (intval($_data['circledByCount']));
                                        set_transient('apsc_googlePlus', $count,$cache_period);
                                    } else {
                                        $count = 0;
                                    }
                                }
                            } else {
                                $count = $googlePlus_count;
                            }
                            
                            break;
                        case 'instagram':
                            $username = $apsc_settings['social_profile']['instagram']['username'];
                            $user_id = $apsc_settings['social_profile']['instagram']['user_id'];
                            $social_profile_url = 'https://instagram.com/' . $username;
                            
                            $instagram_count = get_transient('apsc_instagram');
                            if (false === $instagram_count) {
                                $access_token = $apsc_settings['social_profile']['instagram']['access_token'];

                                $api_url = 'https://api.instagram.com/v1/users/self/?access_token=' . $access_token;
                                $params = array(
                                    'sslverify' => false,
                                    'timeout' => 60
                                );
                                $connection = wp_remote_get($api_url, $params);
                                if (is_wp_error($connection)) {
                                    $count = 0;
                                } else {
                                    $response = json_decode($connection['body'], true);
                                    if (
                                            isset($response['meta']['code']) && 200 == $response['meta']['code'] && isset($response['data']['counts']['followed_by'])
                                    ) {
                                        $count = (intval($response['data']['counts']['followed_by']));
                                        set_transient('apsc_instagram',$count,$cache_period);
                                    } else {
                                        $count = 0;
                                    }
                                }
                            } else {
                                $count = $instagram_count;
                            }
                            
                            break;
                        case 'youtube':
                            $social_profile_url = esc_url($apsc_settings['social_profile']['youtube']['channel_url']);
                            $count = get_transient('apsc_youtube');
                           
                            if(false === $count){
                            $count = $apsc_settings['social_profile']['youtube']['subscribers_count'];
                            if(
                                isset($apsc_settings['social_profile']['youtube']['channel_id'],$apsc_settings['social_profile']['youtube']['api_key']) && 
                                $apsc_settings['social_profile']['youtube']['channel_id']!='' && $apsc_settings['social_profile']['youtube']['api_key']
                               )
                             {
                                
                                  $api_key = $apsc_settings['social_profile']['youtube']['api_key'];
                                  $channel_id = $apsc_settings['social_profile']['youtube']['channel_id'];
                                  $api_url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_id.'&key='.$api_key;
                                  $connection = wp_remote_get($api_url, array('timeout'=>60));
                                  
                                  if (!is_wp_error($connection)) {
                                        $response = json_decode($connection['body'], true);
                                        if (isset($response['items'][0]['statistics']['subscriberCount'])) {
                                            $count = $response['items'][0]['statistics']['subscriberCount'];
                                            set_transient('apsc_youtube',$count,$cache_period);
                                            } 
                                        }
                                } 
                            }
                            break;
                        case 'soundcloud':
                            $username = $apsc_settings['social_profile']['soundcloud']['username'];
                            $social_profile_url = 'https://soundcloud.com/' . $username;
                            
                            $soundcloud_count = get_transient('apsc_soundcloud');
                            if (false === $soundcloud_count) {
                                $api_url = 'https://api.soundcloud.com/users/' . $username . '.json?client_id=' . $apsc_settings['social_profile']['soundcloud']['client_id'];
                                $params = array(
                                    'sslverify' => false,
                                    'timeout' => 60
                                );

                                $connection = wp_remote_get($api_url, $params);
                                if (is_wp_error($connection)) {
                                    $count = 0;
                                } else {
                                    $response = json_decode($connection['body'], true);

                                    if (isset($response['followers_count'])) {
                                        $count = (intval($response['followers_count']));
                                        set_transient( 'apsc_soundcloud',$count,$cache_period );
                                    } else {
                                        $count = 0;
                                    }
                                }
                            } else {
                                $count = $soundcloud_count;
                            }
                            
                            break;
                        case 'dribbble':
                            $social_profile_url = 'http://dribbble.com/'.$apsc_settings['social_profile']['dribbble']['username'];
                            
                            $dribbble_count = get_transient('apsc_dribbble');
                            if (false === $dribbble_count) {
                                $username = $apsc_settings['social_profile']['dribbble']['username'];
                                 $api_url = 'http://api.dribbble.com/' . $username;
                                $params = array(
                                    'sslverify' => false,
                                    'timeout' => 60
                                );
                                $connection = wp_remote_get($api_url, $params);
                                if (is_wp_error($connection)) {
                                    $count = 0;
                                } else {
                                    $response = json_decode($connection['body'], true);
                                    if (isset($response['followers_count'])) {
                                        $count = (intval($response['followers_count']));
                                        set_transient('apsc_dribbble',$count,$cache_period );
                                    } else {
                                        $count = 0;
                                    }
                                }
                            } else {
                                $count = $dribbble_count;
                            }
                            
                            break;
                        case 'posts':
                            
                            $posts_count = get_transient('apsc_posts');
                            if (false === $posts_count) {
                                $posts_count = wp_count_posts();
                                $count = $posts_count->publish;
                                set_transient('apsc_posts', $count, $cache_period);
                            } else {
                                $count = $posts_count;
                            }
                            
                            break;
                        case 'comments':
                            
                            $comments_count = get_transient('apsc_comments');
                            if (false === $comments_count) {
                                $data = wp_count_comments();
                                $count = ($data->approved);
                                set_transient('apsc_comments', $count, $cache_period);
                            } else {
                                $count = $comments_count;
                            }
                            
                            break;
                        default:
                            break;
            }
            