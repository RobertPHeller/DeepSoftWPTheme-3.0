<?php
   $options = get_option( 'deepsoft3_theme_options' );
   $postsperad = $options['postsperad'];
   if (!(empty($postsperad) || $postsperad == 0)) {
     global $deepwoods_postcount;
     if ( ($deepwoods_postcount % $postsperad) == 0 &&
	  function_exists('dynamic_sidebar') ) {
	?><!-- dynamic_sidebar('AdSenseInterpost') --><?php
	?><div id="googleadsense-interpost" class="sidebar">
	    <ul><?php dynamic_sidebar('AdSenseInterpost'); ?></ul></div><?php
     }
   }
