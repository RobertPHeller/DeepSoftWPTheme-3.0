<nav>
<div id="deepsoft-header-menu"><?php 
  wp_nav_menu( array('theme_location' => 'header-menu',
                         'container_id'   => 'navwrap',
                         'fallback_cb'    => 'deepwoods_standard_page_menu',
                         'menu_id'        => 'nav',
                         'menu_class'     => 'top_menu',                        
                         'walker'         => new deepwoods_top_menu_walker()
                        ) );
  ?></div></nav><br clear="all" />
