<nav><div id="deepsoft-footer-menu"><?php
  wp_nav_menu( array('theme_location' => 'footer-menu',
			 'container_id'   => 'navwrap',
			 'fallback_cb'    => 'deepwoods_standard_page_menu',
			 'menu_id'	  => 'nav',
			 'menu_class'     => 'bottom_menu',
			 'walker'	  => new deepwoods_bottom_menu_walker()
			) );
  ?></div></nav><br clear="all" />
      

