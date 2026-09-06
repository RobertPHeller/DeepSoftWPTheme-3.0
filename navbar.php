<?php /* Navigation Menu Bar */

global $post;
$homeLink = home_url() . '/';
$homeTitle = "Home";
$homepage = get_page_by_title("Home");
$home_id = $homepage->ID;
if ( is_page() || is_single() ) {
  $pageid = $post->ID;
  $name = get_the_title($post->ID);
  $parent = $post->post_parent;
} else {
  $pageid = $home_id;
  $name = $homeTitle;
  $parent = 0;
} 
  

// file_put_contents("php://stderr","*** navbar.php (entry): referer is ".$_SERVER['HTTP_REFERER'].", from ".$_SERVER['REMOTE_ADDR']." (".$_SERVER['REMOTE_HOST'].")\n");


?><div id="navwrap">
<ul id="nav" class="flat_menu">
<li><a href="<?php echo $homeLink; ?>" title="<?php echo $homeTitle; ?>"><?php echo $homeTitle; ?></a></li>
<?php 
   global $wpdb;
   wp_list_categories('title_li=&depth=1&include='.get_cat_ID('News')); 
   // file_put_contents("php://stderr","*** navbar.php: home_id is ".$home_id.", pageid = ".$pageid.", name = |".$name."|\n");
   $children = wp_list_pages('title_li=&depth=1&sort_column=menu_order&child_of='.$pageid.'&echo=0');
   // file_put_contents("php://stderr","*** navbar.php: children are ".$children."\n");
   // file_put_contents("php://stderr","*** navbar.php: parent is ".$parent."\n");
   if ( empty($children) ) {
     // file_put_contents("php://stderr","*** navbar.php: === begin no children ===\n");
     // file_put_contents("php://stderr","*** navbar.php (no children, start): parent = $parent, home_id = $home_id, pageid = $home_id\n");
     if ($parent != 0 && $parent != $home_id) {
        $parentbutton = $parent;
	$pageid = $parent;
     } else {
	$parentbutton = 0;
	$pageid = $home_id;
     }
     // file_put_contents("php://stderr","*** navbar.php (no children, end): parent = $parent, home_id = $home_id, pageid = $home_id\n");
     // file_put_contents("php://stderr","*** navbar.php: === end no children ===\n");
   } elseif ($pageid != $home_id) {
     $parentbutton = $pageid;
   } else {
     $parentbutton = 0;
   }
   // file_put_contents("php://stderr","*** navbar.php: parentbutton = ".$parentbutton."\n");
   if ( $parentbutton != 0) {
     wp_list_pages('title_li=&depth=1&sort_column=menu_order&include='.$pageid);
   }
   // file_put_contents("php://stderr","*** navbar.php(2): home_id is ".$home_id.", pageid = ".$pageid.", name = |".$name."|\n");
   wp_list_pages('title_li=&depth=1&sort_column=menu_order&exclude='.$home_id.'&child_of='.$pageid);
   $bugreporturl = '';
   $bugreporturl = get_post_meta($pageid, 'bugreporturl', true);
   if (! empty($bugreporturl) ) {
     ?><li><a href="<?php echo $bugreporturl; ?>">File a Bug</a></li><?php
   }
   $consultPage = get_page_by_path('freeconsultation');
   $consult = $consultPage->ID;
   wp_list_pages('title_li=&depth=1&include='.$consult);
   $sitemapPage = get_page_by_path('sitemap');
   $sitemap = $sitemapPage->ID;
   wp_list_pages('title_li=&depth=1&include='.$sitemap);
   wp_list_categories('title_li=&depth=1&include='.get_cat_ID('Linux Articles'));
   ?>
</ul>
</div> <!-- id="navmenu" -->

