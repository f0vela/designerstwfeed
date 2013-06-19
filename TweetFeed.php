<?php 
	/*
	Plugin Name: Designers Twitter Feed
	Plugin URI: http://www.frisley.com/wpplugins/dtwitterfeed
	Description: Designers Twitter Feed
	Author: Frisley Velasquez
	Version: 0.0.1
	Author URI: http://www.frisley.com
	*/
	function twitfeed_admin_init() {
		//$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
	}
	
	function twitfeed_admin() {
		include('admin/TweetFeedAdmin.php');
	}
		
	
	function twitfeed_admin_actions() {
		add_options_page("Designers TwFeed", "Designers TwFeed", 1, "DesignersTwFeed", "twitfeed_admin");	
	}
	
	function twitfeed_recentTweets(){
		
		//session_start();
		include('twitteroauth/twitteroauth.php');
		
		$twitterusername	= get_option('twitterusername');
		$numberoftweets		= get_option('numberoftweets');
		
		$consumerkey		= get_option('consumerkey');
		$consumersecret		= get_option('consumersecret');
		$accesstoken		= get_option('accesstoken');
		$accesstokensecret	= get_option('accesstokensecret');
		
		$plugin_directory 	= WP_PLUGIN_URL.'/DesignersTwFeed';
		
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		  return $connection;
		}
		  
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		 
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitterusername."&count=".$numberoftweets);
		 
		$tweets = json_encode($tweets);
		
		
		?>
	<link href="<?php echo $plugin_directory.'/css/twcss.css'; ?>" media="all" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script>
		function twtjs_loadTweets(user,numTweets,appendTo)
		{
		        
		        user = typeof user !== 'undefined' ? user : 'f0vela';
				numTweets = typeof numTweets !== 'undefined' ? numTweets : '3';
				appendTo = typeof appendTo !== 'undefined' ? appendTo : '#twtbox_body';
				data = <?php echo $tweets; ?>;
				
 				jQuery('#twtbox_footer').html('<div>Sigueme <a href="http://twitter.com/'+user+'">@'+user+'</a></div>');
 				//twtbox_head_name
 				//twtbox_head_subname
                 var html = '<div class="tweet"><div class="tweettext">TWEET_TEXT</div><div class="time">AGO</div><div class="twjs_icons">TWEET_ICONS</div><div style="clear:both;"></div>';
         
                 // append tweets into page
                 for (var i = 0; i < data.length; i++) {
                 	
                 twtjsicons = '<a href="https://twitter.com/intent/tweet?in_reply_to='+data[i].id_str+'" target="_blank"><img src="<?php echo $plugin_directory.'/images'; ?>/reply2.png" alt="Reply"/></a>';
                 twtjsicons += '<a href="https://twitter.com/intent/retweet?tweet_id='+data[i].id_str+'" target="_blank"><img src="<?php echo $plugin_directory.'/images'; ?>/retweet2.png" alt="Retweet"/></a>';
                 twtjsicons += '<a href="https://twitter.com/intent/favorite?tweet_id='+data[i].id_str+'" target="_blank"><img src="<?php echo $plugin_directory.'/images'; ?>/favorite2.png" alt="Favorite"/></a>';
                 
                    jQuery(appendTo).append(
                        html.replace('TWEET_TEXT', ify.clean(data[i].text) )
                        	.replace('TWEET_ICONS', twtjsicons)
                            .replace(/USER/g, data[i].user.screen_name)
                            .replace('AGO', timeAgo(data[i].created_at) )
                            .replace(/ID/g, data[i].id_str)
                    );
                 }
		         
		}
		     
		         
		    /**
		      * relative time calculator FROM TWITTER
		      * @param {string} twitter date string returned from Twitter API
		      * @return {string} relative time like "2 minutes ago"
		      */
		function timeAgo(dateString) {
		        var rightNow = new Date();
		        var then = new Date(dateString);
		         
		        if (jQuery.browser.msie) {
		            // IE can't parse these crazy Ruby dates
		            then = Date.parse(dateString.replace(/( \+)/, ' UTC$1'));
		        }
		 
		        var diff = rightNow - then;
		 
		        var second = 1000,
		        minute = second * 60,
		        hour = minute * 60,
		        day = hour * 24,
		        week = day * 7;
		 
		        if (isNaN(diff) || diff < 0) {
		            return ""; // return blank string if unknown
		        }
		 
		        if (diff < second * 2) {
		            // within 2 seconds
		            return "right now";
		        }
		 
		        if (diff < minute) {
		            return Math.floor(diff / second) + " seconds ago";
		        }
		 
		        if (diff < minute * 2) {
		            return "about 1 minute ago";
		        }
		 
		        if (diff < hour) {
		            return Math.floor(diff / minute) + " minutes ago";
		        }
		 
		        if (diff < hour * 2) {
		            return "about 1 hour ago";
		        }
		 
		        if (diff < day) {
		            return  Math.floor(diff / hour) + " hours ago";
		        }
		 
		        if (diff > day && diff < day * 2) {
		            return "yesterday";
		        }
		 
		        if (diff < day * 365) {
		            return Math.floor(diff / day) + " days ago";
		        }
		 
		        else {
		            return "over a year ago";
		        }
		}
	    
	    ify = {
	      link: function(tweet) {
	        return tweet.replace(/\b(((https*\:\/\/)|www\.)[^\"\']+?)(([!?,.\)]+)?(\s|$))/g, function(link, m1, m2, m3, m4) {
	          var http = m2.match(/w/) ? 'http://' : '';
	          return '<a class="twtr-hyperlink" target="_blank" href="' + http + m1 + '">' + ((m1.length > 25) ? m1.substr(0, 24) + '...' : m1) + '</a>' + m4;
	        });
	      },
	 
	      at: function(tweet) {
	        return tweet.replace(/\B[@?]([a-zA-Z0-9_]{1,20})/g, function(m, username) {
	          return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/intent/user?screen_name=' + username + '">@' + username + '</a>';
	        });
	      },
	 
	      list: function(tweet) {
	        return tweet.replace(/\B[@?]([a-zA-Z0-9_]{1,20}\/\w+)/g, function(m, userlist) {
	          return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/' + userlist + '">@' + userlist + '</a>';
	        });
	      },
	 
	      hash: function(tweet) {
	        return tweet.replace(/(^|\s+)#(\w+)/gi, function(m, before, hash) {
	          return before + '<a target="_blank" class="twtr-hashtag" href="http://twitter.com/search?q=%23' + hash + '">#' + hash + '</a>';
	        });
	      },
	 
	      clean: function(tweet) {
	        return this.hash(this.at(this.list(this.link(tweet))));
	      }
	    };

	
		function reloadTweets()
		{
			jQuery('#twtbox_body').html('');
			twtjs_loadTweets('<?php echo $twitterusername; ?>','<?php echo $numberoftweets; ?>');
		}
		
		jQuery(function(){
			reloadTweets();
		});
	</script>
		<style>
		#twitfeed_wrapper{ margin: 0 auto;  width: 90%; padding: 10px 5px; font-family: Helvetica, Arial; }
		#twitfeed_bigvid { float: left; width: 65%; max-width: 518px; max-height:293px; background-color: black; border:2px solid #fff; }
		#twitfeed_youtube { float:left; max-width:410px; width: 35%; overflow: hidden;}
		
		.twitfeed_youtube_video { height: 150px; padding: 0 5px 5px; width:40%; float: left; }
		.twitfeed_youtube_video img { float: left; margin-right: 10px; border: 3px solid #fff; width:200px; }
		
		#twitfeed_youtube_link a{ color: #878080; font-size: 12px; line-height: 14px; }
		</style><?php

        $lyt = '';
        $lyt = '<div id="twtbox">
					<div id="twtbox_head">
					<img src="'.$plugin_directory.'/images/twitter-bird-white-on-blue.png" width="60"/>
					<div id="twtbox_head_name">'.$twitterusername.'</div>
					<div id="twtbox_head_subname">Mis Tweets</div>
					</div>
					<div id="twtbox_body"></div>
					<div id="twtbox_footer"></div>
				</div>';
        $lyt .= '<div style="clear:both;"></div>';
        
        return $lyt;
	}
	
	add_action('admin_init', 'twitfeed_admin_init');
	add_action('admin_menu', 'twitfeed_admin_actions');
	add_shortcode('twitterfeed', 'twitfeed_recentTweets');
?>