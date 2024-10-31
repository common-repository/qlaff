<?php 
include('../../../wp-config.php');
$getgametype=$_GET['gametype'];
$getgamename=$_GET['gamename'];
global $wpdb;
$table_name = $wpdb->prefix . "game_list";
$gamename = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE gametype='".$getgametype."' ORDER BY gamename_nice ASC"); 
?>
<select name="qlaff_game_gamename" style="width: 150px;">
	<?php foreach ($gamename as $game) { ?>
	<?php if($getgamename==$game->gamename) { ?>
	<option value="<?php echo $game->gamename ?>" selected="selected"><?php echo $game->gamename_nice ?></option>
	<?php } else { ?>
    <option value="<?php echo $game->gamename ?>"><?php echo $game->gamename_nice ?></option>
	<?php } ?>
	<?php } ?>
</select>