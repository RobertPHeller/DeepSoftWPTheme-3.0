<?php
/**
 * @package WordPress
 * @subpackage Deepsoft_Theme
 */
?><asside>
<?php $opts = get_option("deepsoft3_theme_options"); ?>
<div id="<?php 
     if ($opts['enableleft']) { 
       echo 'r_sidebar'; 
     } else {
       echo 'r_sidebar1';
     } ?>" class="sidebar">
  <?php if (function_exists('chicklet_creator')) {
	chicklet_creator();
      } else { ?><a href="<?php bloginfo('rss_url'); ?>"><img 
	src="<?php bloginfo('siteurl'); ?>/wp-includes/images/rss.png" 
	height="14" width="14" alt="RSS Feed"> RSS Feed</a><?php } ?><br />
  <div id="page_right">
    <ul id="googleadsenseright">
      <!-- dynamic_sidebar('AdSenseRight') -->
        <?php 	/* Widgetized sidebar, if you have the plugin installed. */
	    if ( !function_exists('dynamic_sidebar') || 
		 !dynamic_sidebar('AdSenseRight') ) {} ?>
    </ul>
  </div>
  <div id="lower_right">
    <ul>
       <!-- dynamic_sidebar('Right Sidebar') -->
         <?php 	/* Widgetized sidebar, if you have the plugin installed. */
	    if ( !function_exists('dynamic_sidebar') || 
	         !dynamic_sidebar('Right Sidebar') ) {} ?>
    </ul>
  </div>
  <div id="pagebuttons">
     <h4><a href="<?php bloginfo('siteurl'); ?>/toolbarinfo">Get Your Deepwoods Software Firefox Toolbar TODAY!</a></h4>
   </div> <!-- id="pagebuttons" -->
  <!-- opts['enableleft'] = <?php echo $opts['enableleft']; ?> -->
  <?php 
    if (!$opts['enableleft']) {
      get_template_part( 'sidebar', 'always' ); /* sidebar(-always).php */
    } ?>    
</div> <!-- id="r_sidebar" -->
</asside>
