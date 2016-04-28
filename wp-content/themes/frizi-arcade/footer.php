<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package games
 */
?>

<div class="footer group">
  <div class="center">
      <p class="footer-links"><?php theme_link(); ?><?php if (games_myarcade_plugin_activate()) { ?> | <a href="http://www.myarcadeplugin.com" class="myarcadelink">Powered by My Arcade Plugin</a><?php } ?></p>
    
    <div class="soc">
      <ul>
	      <?php 
	      if ( function_exists( 'ot_get_option' ) ) {
  				$facebook_fan_page = ot_get_option( 'facebook_fan_page_url' );
			}
		  if (isset($facebook_fan_page) && !empty($facebook_fan_page)):  ?> 
	      <li><a href="<?php echo $facebook_fan_page ?>" class="s1"></a></li>
	      <?php endif; ?>
	      <?php 
	      if ( function_exists( 'ot_get_option' ) ) {
  				$twitter_url = ot_get_option( 'twitter_url' );
			}
		  if (isset($twitter_url) && !empty($twitter_url)):  ?> 
	      <li><a href="<?php echo $twitter_url ?>" class="s2"></a></li>
	      <?php endif; ?>
	      <li><a href="<?php bloginfo('rss2_url') ?>" class="s3"></a></li>
          <?php if ( ot_get_option( 'contactus','on' ) == 'on' ){ ?>  
             <li><a href="#" class="s4 cont-h" id="contact-us"></a></li>
          <?php }?>
      
      </ul>
    </div>
      <?php wp_footer(); ?>
  </div>
</div>

	
	

</div><!-- .center -->
<?php
$google_analytics_code = ot_get_option( 'google_analytics_code' );
if($google_analytics_code ){
	echo $google_analytics_code;
}
?>
</body>
</html>
