<?php
/*
* Plugin Name: Ezcape Video Chat - Discontinued
* Plugin URI: https://wordpress.org/plugins/ezcape-chat/
* Author: Ruddernation Designs
* Author URI: https://profiles.wordpress.org/ruddernationdesigns
* Description: This allows you to have Ezcape chat on your blog, Make sure the chat room exists though! (Formally Kageshi) and you will need flash player enabled.
* Requires at least: WordPress 2.0, BuddyPress 1.0.0
* Tested up to: 5.6
* Version: 1.3.2
* License: MIT 
* License URI: https://opensource.org/licenses/MIT
* Date:19th December 2020
*/
define('COMPARE_VERSION', '1.3.1');
defined( 'ABSPATH' ) or die( 'Anime is not just for Christmas, but for Life!' );
register_activation_hook(__FILE__, 'ezcapechat_install');

function ezcapechat_install() {
	
	global $wpdb, $wp_version;
	$post_date = date("Y-m-d H:i:s");
	$post_date_gmt = gmdate("Y-m-d H:i:s");
	$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_content LIKE '%[ezcapechat_page]%' AND `post_type` NOT IN('revision') LIMIT 1";
	$page = $wpdb->get_row($sql, ARRAY_A);
	
	if($page == NULL) {
		$sql ="INSERT INTO ".$wpdb->posts."(
			post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt,  post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)
VALUES ('1', '$post_date', '$post_date_gmt', '[ezcapechat_page]', '', 'Ezcape Chat', '', 'publish', 'closed', 'closed', '', 'ezcape-chat', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page')";
		
		$wpdb->query($sql);
		$post_id = $wpdb->insert_id;
		$wpdb->query("UPDATE $wpdb->posts SET guid = '" . get_permalink($post_id) . "' WHERE ID = '$post_id'");
		
	} 
	else 
	{
		
		$post_id = $page['ID'];
		
	}
	
	update_option('ezcapechat_url', get_permalink($post_id));
}

add_filter('the_content', 'wp_show_ezcapechat_page', 222);

function wp_show_ezcapechat_page($content = '') {
	
	if(preg_match("/\[ezcapechat_page\]/",$content)) {
		wp_show_ezcapechat();
		return "";
		
	}
	
	return $content;
}

function wp_show_ezcapechat() {
	if(!get_option('ezcapechat_enabled', 0)) {
	}
?>

<h2>Ezcape Video Chat</h2>
<br>
<form method="post" class="form">

<input type="text" name="room" title="Enter the ezcape chat room, but make sure it exists! or it wont work." tabindex="1" placeholder="Just enter the name of the Ezcape Chat room" autofocus required/>

<input type="submit" class="button2" tabindex="2" value="Chat"/></form>

<br>
    <div class="info">                              
        <h3 class="main" title="Click Me!">Click me!</h3>             
        <p  class="chatinfo" tabindex="3">
			<strong>This allows you to join ezcape chat rooms with Camera/Mic of up to 12 people,<br>

	It also has YouTube so you can play your videos, 
				There are also hundreds of registered chat rooms that you can visit and they normally contain and average of 19 chatters,<br>
				Simply enter your room name in to the form above.<br>
				Below are a list of some of the most used chat room on Ezcape Chat.<br>
				<h3>btvparty | lurkchat | the_others | chat | 40supfriendsflirts | uncle_tripp | smokefilledthoughts | cannabuzz </h3>
</strong>
		</p>   
    </div>

<?php
	$room = filter_input(INPUT_POST, 'room');
	if(preg_match('/^[a-z0-9]/', $room=strtolower($room))) 
		
	{
		
		$room=preg_replace('/[^a-zA-Z0-9]/','',$room);
		
		{
			
		if (strlen($room) < 3)
			
		{
			
			echo '<p>The Ezcape room needs to be more than 3 characters.</p>'; 
			
		}
			
		else
			
			if (strlen($room) > 38) 
				
			{
				
				echo '<p>The Ezcape room needs to be less than 38 characters.</p>';
				
			} 
			
		else
			
		{
			
			echo '<style>iframe {width: 100%;height: 100%;position:fixed;top:0px;left:0px;right:0px;bottom:0px;z-index:9999999;}</style>
	
<iframe class="iframe" src="https://www.ezcapechat.com/rooms/'.$room.'/" name="room" frameborder="0" scrolling="yes" height="100%" width="100%" allow="geolocation; microphone; camera;"></iframe>';
		}
					}
								}

											}?>