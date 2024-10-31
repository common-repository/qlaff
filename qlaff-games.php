<?php function qlaff_games_options($nr) {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>
<div style="padding: 20px;">
	<h2>Qlaff Games Options Page</h2>

		<?php 
			if($_GET['result']=='result' && $_GET['updated']!='true') {
				$toppartner = $_POST['qlaff_game_partner'];
				$topch = $_POST['qlaff_game_ch'];
				$toptype = $_POST['qlaff_game_type'];
				$topgametype = $_POST['qlaff_game_gametype']; 
				$topgamename = $_POST['qlaff_game_gamename'];
				$topgeo = $_POST['qlaff_game_geo'];
				$toplang = $_POST['qlaff_game_lang'];
				$toppop = $_POST['qlaff_game_pop'];
				$topwidth = $_POST['qlaff_game_width'];
			}
			else {
				$toppartner = get_option('qlaff_game_partner');
				if(empty($toppartner))
						$toppartner='RnD';

				$topch = get_option('qlaff_game_ch');
				if(empty($topch))
						$topch='qlaff';

				$toptype = get_option('qlaff_game_type');
				if(empty($toptype))
						$toptype='casino';

				$topgametype = get_option('qlaff_game_gametype');
				if(empty($topgametype))
						$topgametype='Roulette';

				$topgamename = get_option('qlaff_game_gamename');
				if(empty($topgamename))
						$topgamename='roulette2adv';

				$topgeo = get_option('qlaff_game_geo');
				if(empty($topgeo))
						$topggeo='all';

				$toplang = get_option('qlaff_game_lang');
				if(empty($toplang))
						$toplang='en';

				$toppop = get_option('qlaff_game_pop');
				if(empty($toppop))
						$toppop='5';

				$topwidth = get_option('qlaff_game_width');
				if(empty($topwidth))
						$topwidth='700';
			}
			
		
		if($topgeo!='all') {$topgeocheck = "&amp;geo=".$topgeo;}
		$topheight = $topwidth*0.75; 
		?>
		<script language="javascript" type="text/javascript">
		function getXMLHTTP() { //fuction to return the xml http object
			var xmlhttp=false;	
			try{
				xmlhttp=new XMLHttpRequest();
			}
			catch(e)	{		
				try{			
					xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e){
					try{
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
					}
					catch(e1){
						xmlhttp=false;
					}
				}
			}
				
			return xmlhttp;
		}
		function getState(GameType, GameName)
		{
		   var strURL="../wp-content/plugins/qlaff/findState.php?gametype="+GameType+"&gamename="+GameName;
		   var req = getXMLHTTP();
		   if (req)
		   {
			 req.onreadystatechange = function()
			 {
			  if (req.readyState == 4)
			  {
			 // only if "OK"
			 if (req.status == 200)
				 {
				document.getElementById('statediv').innerHTML=req.responseText;
			 } else {
			   alert("There was a problem while using XMLHTTP:\n" + req.statusText);
			 }
			   }
			  }
		   req.open("GET", strURL, true);
		   req.send(null);
		   }
		}
		</script>
		<h3>Search the game you want to place on the page.</h3>
		<div id="container" class="banners">
			<div id="selection">
				<form action="admin.php?page=qlaff_games_identifier&result=result" method="post" enctype="multipart/form-data" name="gameselector">
					<table>
						<thead>
							<tr>
								<td>Game Type</td>
								<td>Game Name</td>
								<td>Language</td>
								<td>Width</td>
								<td>Partner</td>
								<td>Channel</td>
								<td>Popover Type</td>
								<td>Geo</td>
								<td># of popovers</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<select name="qlaff_game_gametype" onchange="getState(this.value)" style="width: 120px;">
										<?php global $wpdb;
										$gametypecheck = mysql_query("SELECT * FROM ".$wpdb->prefix ."game_list GROUP BY gametype");
										while($gametype = mysql_fetch_array($gametypecheck)) { 	
											if ($topgametype == $gametype['gametype']) { ?>
												<option value="<?php echo $gametype['gametype'] ?>" selected="selected"><?php echo $gametype['gametype'] ?></option>
											<?php } 
											else { ?>
												<option value="<?php echo $gametype['gametype'] ?>"><?php echo $gametype['gametype'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</td>
								<td>
									<p id="statediv">
									<select name="qlaff_game_gamename" style="width: 150px;">
									<script language="javascript" type="text/javascript">getState('<?php echo $topgametype; ?>','<?php echo $topgamename; ?>');</script>
									</select>
								</td>
								<td>
									<select name="qlaff_game_lang" style="width: 80px;">
										<?php $langArr = array();
											$langArr[]="en";
											$langArr[]="de";
											$langArr[]="fr";
											$langArr[]="es";
											foreach($langArr as $v){
												if ($toplang == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$v</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$v</option>\n";
												}
											}
										?>
									</select>
								</td>
								<td style="width: 100px;">
									<input type="text" size="5" value="<?php echo $topwidth ?>" name="qlaff_game_width">px
								</td>
								<td>
									<select name="qlaff_game_partner" style="width: 150px;">
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
												if ($toppartner == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$partnername</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$partnername</option>\n";
												}
											}
										?>
									</select>
								</td>
								<td>
									<select name="qlaff_game_ch" style="width: 80px;">
										<?php $chArr = array();
											$chArr[]="seo";
											$chArr[]="qlaff";
											foreach($chArr as $v){
												if ($topch == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$v</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$v</option>\n";
												}
											}
										?>
									</select>
								</td>
								<td>
									<select name="qlaff_game_type" style="width: 100px;">
										<?php $typeArr = array();
											$typeArr[]="casino";
											$typeArr[]="poker";
											$typeArr[]="whs";
											foreach($typeArr as $v){
												if ($toptype == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$v</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$v</option>\n";
												}
											}
										?>
									</select>
								</td>
								<td>
									<select name="qlaff_game_geo" style="width: 80px;">
										<?php $geoArr = array();
											$geoArr[]="all";
											$geoArr[]="us";
											$geoArr[]="eu";
											foreach($geoArr as $v){
												if ($topgeo == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$v</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$v</option>\n";
												}
											}
										?>
									</select>
								</td>
								<td>
									<select name="qlaff_game_pop" style="width: 80px;">
										<?php $popArr = array();
											$popArr[]="1";
											$popArr[]="2";
											$popArr[]="3";
											$popArr[]="4";
											$popArr[]="5";
											foreach($popArr as $v){
												if ($toppop == $v) {
													echo "<option value=\"$v\" selected=\"selected\">$v</option>\n";
												} 
												else {
													echo "<option value=\"$v\">$v</option>\n";
												}
											}
										?>
									</select>
								</td>
								
								<td>
									<input type="submit" name = "Search" value="Search" />
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div id="list">
				<table border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th class="banner" style="float: left; padding-left: 30px;">Game - <?php $gamenamenicecheck = mysql_query("SELECT * FROM ".$wpdb->prefix ."game_list WHERE gamename='".$topgamename."'"); ?>
							<?php while($gamenamenice = mysql_fetch_array($gamenamenicecheck)) { ?>
								"<?php echo $gamenamenice['gamename_nice']; ?>"
							<?php } ?></td>
							<th class="code">Implementation guide</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="banner">
								<iframe width="<?php echo $topwidth+2; ?>" height="<?php echo $topheight; ?>" frameborder="0" scrolling="no" src="http://www.qlaff.com/game.php?gameid=<?php echo $topgamename; ?>&type=<?php echo $toptype; ?>&ch=<?php echo $topch; ?>&partner=<?php echo $toppartner; ?>&lang=<?php echo $toplang; echo $topgeocheck; ?>&width=<?php echo $topwidth; ?>&pop=<?php echo $toppop; ?>" hspace="0" vspace="0"></iframe>
							</td>
							<td class="code" style="text-align: center; padding: 20px; width: 300px;">
								<h3>How to place the game:</h3>
								1. Save the setting for size, partner, channel, geo and # of popvers by clicking:
								<form action="options.php?result=no" method="post">
									<?php settings_fields( 'qlaff-game' ); ?>
									<input type="hidden" name="qlaff_game_gamename" value="<?php echo $topgamename; ?>" />
									<input type="hidden" name="qlaff_game_gametype" value="<?php echo $topgametype; ?>" />
									<input type="hidden" name="qlaff_game_partner" value="<?php echo $toppartner; ?>" />
									<input type="hidden" name="qlaff_game_ch" value="<?php echo $topch; ?>" />
									<input type="hidden" name="qlaff_game_type" value="<?php echo $toptype; ?>" />
									<input type="hidden" name="qlaff_game_pop" value="<?php echo $toppop; ?>" />
									<input type="hidden" name="qlaff_game_geo" value="<?php echo $topgeo; ?>" />
									<input type="hidden" name="qlaff_game_lang" value="<?php echo $toplang; ?>" />
									<input type="hidden" name="qlaff_game_width" value="<?php echo $topwidth; ?>" />
									<input type="hidden" name="action" value="update" />
									<input type="hidden" name="page_options" value="qlaff_game_gamename" />
									<input type="hidden" name="page_options" value="qlaff_game_gametype" />
									<input type="hidden" name="page_options" value="qlaff_game_partner" />
									<input type="hidden" name="page_options" value="qlaff_game_ch" />
									<input type="hidden" name="page_options" value="qlaff_game_type" />
									<input type="hidden" name="page_options" value="qlaff_game_pop" />
									<input type="hidden" name="page_options" value="qlaff_game_geo" />
									<input type="hidden" name="page_options" value="qlaff_game_lang" />
									<input type="hidden" name="page_options" value="qlaff_game_width" />
									<input type="submit" value="<?php _e('Save Changes') ?>" />
								</form>
								<br/>
								2. Place this code to the page: <br/><br/>
								<b>&lt;?php qlaff_game(<?php echo $topgamename; ?>,<?php echo $toplang; ?>,<?php echo $toptype; ?>); ?&gt;</b><br/><br/>
								(sets the game name, language and promotion type)
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- container -->
	</div>
<?php } ?>
<?php function qlaff_game($gamename,$gamelang,$gametype) { 
	$checkgeo = get_option('qlaff_game_geo');
	if($checkgeo!='all') {$topgeocheck2 = "&amp;geo=".$checkgeo;}
	$checkwidth = get_option('qlaff_game_width');
	$topheight2 = $checkwidth*0.75; 
	if(get_option('qlaff_game_width')>275) $ullimit = 2;
	if(get_option('qlaff_game_width')>415) $ullimit = 3;
	if(get_option('qlaff_game_width')>545) $ullimit = 4;
	if(get_option('qlaff_game_width')>685) $ullimit = 5;
	if(get_option('qlaff_game_width')>815) $ullimit = 6;
	?>
	<div id="game" style="width:<?php echo get_option('qlaff_game_width'); ?>px;">
		<iframe width="<?php echo get_option('qlaff_game_width')+2; ?>" height="<?php echo $topheight2; ?>" frameborder="0" scrolling="no" src="http://www.qlaff.com/game.php?gameid=<?php echo $gamename; ?>&type=<?php echo $gametype; ?>&ch=<?php echo get_option('qlaff_game_ch'); ?>&partner=<?php echo get_option('qlaff_game_partner'); ?>&lang=<?php echo $gamelang; echo $topgeocheck2; ?>&width=<?php echo get_option('qlaff_game_width'); ?>&pop=<?php echo get_option('qlaff_game_pop'); ?>" hspace="0" vspace="0"></iframe>
		<ul style="width:<?php echo get_option('qlaff_game_width')-2; ?>px;">
			<?php $toplistxml = "http://www.qlaff.com/request.php?type=".$gametype."&ch=".get_option('qlaff_game_ch')."&partner=".get_option('qlaff_game_partner')."&limit=".$ullimit."&geo=".get_option('qlaff_game_geo')."";
			$xml = simplexml_load_file($toplistxml);
			foreach ($xml->room as $room) { ?>
			<li>
				<a rel="external nofollow" href="<?php echo $room->tracker; ?>" target="_blank"><img alt="<?php echo $room->nicename; ?>" src="<?php echo $room->icon; ?>"></a>
				<a rel="external nofollow" class="button" href="<?php echo $room->tracker; ?>" target="_blank">
					<?php if($gamelang=='de') 
						echo'Spiele jetzt!';
					if($gamelang=='es') 
						echo'Juego!';
					if($gamelang=='fr') 
						echo'Jouez!';
					else 
						echo'Play now!';
					?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>