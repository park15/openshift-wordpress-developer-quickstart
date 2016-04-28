<?php
/**
 * The Sidebar containing adds.
 *
 * @package games
 */
?>

<h3><a href="javascript:history.back()" class="back"><span></span>Back</a></h3>


<?php $ad_code = ot_get_option('rectangular_ad_code_');
if (isset($ad_code)) {?>
<div class="game-banners">
	<div id="ban4"><?php echo $ad_code ?></div>
	<div id="ban5"><?php echo $ad_code ?></div>
	<br class="clear">
</div>


<?php } ?>