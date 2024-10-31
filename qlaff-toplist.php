<?php
/*
Plugin Name: QLAFF toplist
Plugin URI: 
Description: QLAFF affiliate matterials in WP.
Version: 1.3.1
Author: QLAFF
Author URI: http://www.qlaff.com
License: GPL2
*/

/*  Copyright 2010  QLAFF (email : margus.kiss@qlaff.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// ADMIN MENU ACTIONS

add_action('admin_menu', 'qlaff_toplist_admin');

function qlaff_toplist_admin() {
	
	add_menu_page( 'Qlaff', 'Qlaff Toplist', 'manage_options' , 'qlaff_identifier', 'qlaff_toplist_options' ); 
	add_submenu_page('qlaff_identifier', 'Qlaff Game Options', 'Qlaff Games', 'manage_options', 'qlaff_games_identifier', 'qlaff_games_options');
	add_action( 'admin_init', 'register_toplist_settings' );
	add_action( 'admin_init', 'register_game_settings');
}
function register_toplist_settings() {
	//register our settings
	register_setting( 'qlaff-toplist', 'qlaff_partner' );
	register_setting( 'qlaff-toplist', 'qlaff_ch' );
	register_setting( 'qlaff-toplist', 'qlaff_type' );
	register_setting( 'qlaff-toplist', 'qlaff_limit' );
	register_setting( 'qlaff-toplist', 'qlaff_geo' );
	register_setting( 'qlaff-toplist', 'qlaff_lang' );
	register_setting( 'qlaff-toplist', 'qlaff_width' );
}
function register_game_settings() {
	//register our settings
	register_setting( 'qlaff-game', 'qlaff_game_partner' );
	register_setting( 'qlaff-game', 'qlaff_game_ch' );
	register_setting( 'qlaff-game', 'qlaff_game_type' );
	register_setting( 'qlaff-game', 'qlaff_game_gametype' );
	register_setting( 'qlaff-game', 'qlaff_game_gamename' );
	register_setting( 'qlaff-game', 'qlaff_game_geo' );
	register_setting( 'qlaff-game', 'qlaff_game_pop' );
	register_setting( 'qlaff-game', 'qlaff_game_lang' );
	register_setting( 'qlaff-game', 'qlaff_game_width' );
}

// Game Settings

//require_once(ABSPATH . 'wp-content/plugins/qlaff/banners_casino_en.php');

require_once(ABSPATH . 'wp-content/plugins/qlaff/game_list.php');


require_once(ABSPATH . 'wp-content/plugins/qlaff/qlaff-games.php');





// Toplist Settings

function qlaff_toplist_options() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

?>
<div style="padding: 20px;">
	<h2>Qlaff Toplist Options Page</h2>
	<form method="post" action="options.php">
	<?php settings_fields( 'qlaff-toplist' ); ?>
		 <table width="1000">
			<tr valign="top">
				<th style="width:150px; text-align:left;">Partner ID</th>
				<td style="width:300px;">
					<select name="qlaff_partner" style="width:200px;">
						<?php $partnerArr = array();
							$partnerArr[]="RnD";
							$partnerArr[]="1";
							$partnerArr[]="dinv";
							$partnerArr[]="gimig";
							$partnerArr[]="gamaff";
							foreach($partnerArr as $v){
								if($v=='RnD') $partnername = "none";
								if($v=='1') $partnername = "Voorz";
								if($v=='dinv') $partnername = "Domain Invest";
								if($v=='gimig') $partnername = "GimiGames";
								if($v=='gamaff') $partnername = "Gamaff";
								if (get_option('qlaff_partner') == $v) {
									echo "<option name=\"qlaff_partner\" id=\"qlaff_partner\" value=\"$v\" selected=\"selected\">".$partnername."</option>\n";
								} 
								else {
									echo "<option name=\"qlaff_partner\" id=\"qlaff_partner\" value=\"$v\">".$partnername."</option>\n";
								}
							}
						?>
					</select>
					<!-- <input name="qlaff_partner" type="text" id="qlaff_partner" value="<?php echo get_option('qlaff_partner'); ?>" />    -->
				</td>
				<td>(enter your partner ID provided by Qlaff)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Channel</th>
				<td>
					<select name="qlaff_ch" style="width:200px;">
						<?php $chArr = array();
							$chArr[]="seo";
							$chArr[]="qlaff";
							foreach($chArr as $v){
								if (get_option('qlaff_ch') == $v) {
									echo "<option name=\"qlaff_ch\" id=\"qlaff_ch\" value=\"$v\" selected=\"selected\">$v</option>\n";
								} 
								else {
									echo "<option name=\"qlaff_ch\" id=\"qlaff_ch\" value=\"$v\">$v</option>\n";
								}
							}
						?>
					</select>
				</td>
				<td>(enter the channel name provided by Qlaff)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Type:</th>
				<td>
					<select name="qlaff_type" style="width:200px;">
						<?php $typeArr = array();
							$typeArr[]="casino";
							$typeArr[]="poker";
							$typeArr[]="whs";
							foreach($typeArr as $v){
								if (get_option('qlaff_type')== $v) {
									echo "<option name=\"qlaff_type\" id=\"qlaff_type\" value=\"$v\" selected=\"selected\">$v</option>\n";
								} 
								else {
									echo "<option name=\"qlaff_type\" id=\"qlaff_type\" value=\"$v\">$v</option>\n";
								}
							}
						?>
					</select>
				</td>
				<td>(ex. casino, poker, whs)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Limit:</th>
				<td><input name="qlaff_limit" type="text" id="qlaff_limit" value="<?php echo get_option('qlaff_limit'); ?>" style="width:200px;" /></td>
				<td>(# of rooms to display)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Geo:</th>
				<td>
					<select name="qlaff_geo" style="width:200px;">
						<?php $geoArr = array();
							$geoArr[]="all";
							$geoArr[]="us";
							$geoArr[]="eu";
							foreach($geoArr as $v){
								if (get_option('qlaff_geo')== $v) {
									echo "<option name=\"qlaff_geo\" id=\"qlaff_geo\" value=\"$v\" selected=\"selected\">$v</option>\n";
								} 
								else {
									echo "<option name=\"qlaff_geo\" id=\"qlaff_geo\" value=\"$v\">$v</option>\n";
								}
							}
						?>
					</select>
				</td>
				<td>(ex. All rooms = all; US rooms only = us, European rooms = eu)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Review language:</th>
				<td>
					<select name="qlaff_lang" style="width:200px;">
						<?php $langArr = array();
							$langArr[]="en";
							$langArr[]="fr";
							$langArr[]="de";
							$langArr[]="es";
							foreach($langArr as $v){
								if($v=='en') $language = "English";
								if($v=='fr') $language = "French";
								if($v=='de') $language = "German";
								if($v=='es') $language = "Spanish";
								if (get_option('qlaff_lang')== $v) {
									echo "<option name=\"qlaff_lang\" id=\"qlaff_lang\" value=\"$v\" selected=\"selected\">$language</option>\n";
								} 
								else {
									echo "<option name=\"qlaff_lang\" id=\"qlaff_lang\" value=\"$v\">$language</option>\n";
								}
							}
						?>
					</select>
				</td>
				<td>(NB! US rooms have only English language available)</td>
			</tr>
			<tr valign="top">
				<th style="width:150px; text-align:left;">Width:</th>
				<td><input name="qlaff_width" type="text" id="qlaff_width" value="<?php echo get_option('qlaff_width'); ?>" style="width:200px;" /></td>
				<td>(toplist widht in px)</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="qlaff_partner" />
		<input type="hidden" name="page_options" value="qlaff_ch" />
		<input type="hidden" name="page_options" value="qlaff_type" />
		<input type="hidden" name="page_options" value="qlaff_limit" />
		<input type="hidden" name="page_options" value="qlaff_geo" />
		<input type="hidden" name="page_options" value="qlaff_lang" />
		<input type="hidden" name="page_options" value="qlaff_width" />
		<p><input type="submit" value="<?php _e('Save Changes') ?>" /></p>
	</form>
	<div>
		<p>In order to add toplist on the page, insert <b>&lt;?php qlaff_toplist() ?&gt;</b> to the appropriate place.</p>
	</div>
</div>
<?php
}

// TOPLIST functions

function qlaff_toplist() {
	echo '
	<div id="qlafftoplist" style="float: left;padding: 0 0 10px 0;">
		<table cellspacing="0" cellpadding="0" class="home" style="width:'; echo get_option("qlaff_width"); echo 'px">
			<caption>Best Online ';echo ucfirst(get_option('qlaff_type')); echo ' Rooms</caption>
			<tbody>
				<tr>
					<th>Room</th>
					<th></th>
					<th>Bonus</th>
					<th>Review</th>
				</tr>';
	$toplistxml = "http://www.qlaff.com/request.php?type=".get_option('qlaff_type')."&ch=".get_option('qlaff_ch')."&partner=".get_option('qlaff_partner')."&limit=".get_option('qlaff_limit')."&geo=".get_option('qlaff_geo')."";
	$xml = simplexml_load_file($toplistxml);
	foreach ($xml->room as $room) {
		echo '
				<tr>
					<td class="room"><a target="_blank" href="';echo $room->tracker; echo '"><img src="'; echo $room->icon; echo '"></a></td>
					<td class="geo">'; if($room->geo =='us') { echo '<span class="flag flag-us">us</span>'; } echo '</td>
					<td class="bonus"><a target="_blank" href="'; echo $room->tracker; echo '">'; echo $room->bonus; echo '</a></td>
					<td class="review">
						<a class="button" href="'; echo $room->tracker; echo '" target="_blank"><span>Visit</span></a>
						<br>
						<a class="review" href="http://www.qlaff.com/reviewext.php?type='; echo get_option("qlaff_type"); echo '&partner='; echo get_option("qlaff_partner"); echo '&ch='; echo get_option("qlaff_ch"); echo '&lang='; echo get_option("qlaff_lang"); echo '&id='; echo $room->id; echo '">Read Review</a>
					</td>
				</tr>';
	}
	echo '		<tr>
					<td class="accept" colspan="5"><span class="flag flag-us"></span><span>Accepts also US Players</span></td>
				</tr> 
			</tbody>
		</table>
	</div>';
}

// CSS add

function my_init_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('init', 'my_init_method');


    add_action('wp_head', 'qlaff_header');

	function qlaff_header() {
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url("/qlaff-master.css", __FILE__).'" />' . "\n";
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url("/fancybox/jquery.fancybox-1.3.4.css", __FILE__).'" />' . "\n";
		echo '<script type="text/javascript" src="'.plugins_url("fancybox/jquery.fancybox-1.3.4.pack.js", __FILE__).'" /></script>' . "\n";
		echo '<script type="text/javascript" src="'.plugins_url("fancybox/jquery.onload.qlaff.js", __FILE__).'" /></script>' . "\n";
	}

	
?>