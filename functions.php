<?php
/* -*- php -*- ****************************************************************
 *
 *  System        : 
 *  Module        : 
 *  Object Name   : $RCSfile$
 *  Revision      : $Revision$
 *  Date          : $Date$
 *  Author        : $Author$
 *  Created By    : Robert Heller
 *  Created       : 2026-09-06 13:45:06
 *  Last Modified : <260906.1518>
 *
 *  Description	
 *
 *  Notes
 *
 *  History
 *	
 ****************************************************************************
 *
 *    Copyright (C) 2026  Robert Heller D/B/A Deepwoods Software
 *			51 Locke Hill Road
 *			Wendell, MA 01379-9728
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * 
 *
 ****************************************************************************/

require_once ( get_template_directory() . '/functions/theme-options.php' );
require_once ( get_template_directory() . '/functions/register_sidebars.php');
require_once ( get_template_directory() . '/functions/widgets.php' );
require_once ( get_template_directory() . '/functions/DeepwoodsMetaBox.php' );

require_once ( get_template_directory() . '/functions/navmenus.php' );

require_once ( get_template_directory() . '/functions/deepsoft_comments.php' );

if ( ! isset( $content_width ) ) $content_width = 900;
wp_link_pages( );
add_action( 'after_setup_theme', 'deepsoftv3_theme_setup' );
function deepsoftv3_theme_setup() {
  /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
  add_theme_support( 'title-tag' );
}
function deepsoft_breadcrumbs() {
  // Thanks to dimox for the code
  //http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
  
  /* === OPTIONS === */
  $text['home']     = 'Home'; // text for the 'Home' link
  $text['category'] = '%s'; // text for a category page
  $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
  $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
  $text['author']   = 'Articles Posted by %s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page
  
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter   = ' &raquo; '; // delimiter between crumbs
  $before      = '<span class="current">'; // tag before the current crumb
  $after       = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */
  
  global $post;
  $homeLink = home_url('/');
  $linkBefore = '<span typeof="v:Breadcrumb">';
  $linkAfter = '</span>';
  $linkAttr = ' rel="v:url" property="v:title"';
  $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
 
  echo '<div id="crumbs">';

  if (is_home() || is_front_page()) {
 
    if ($showOnHome == 1) echo '<a href="' . $homeLink . '">' . $text['home'] . '</a>';

  } else {
 
    echo sprintf($link, $homeLink, $text['home']) . $delimiter;

    $homepage = get_page_by_title("Home"); 
    $home_id = $homepage->ID; 

    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) {
        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
      }
      echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
 
    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;
 
    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); 
      //file_put_contents("php://stderr","*** deepsoft_breadcrumbs(): cat = ".print_r($cat,true)."\n");
      $cat = $cat[0];
      //file_put_contents("php://stderr","*** deepsoft_breadcrumbs(): cat ([0]) = ".print_r($cat,true)."\n");
      if (!empty($cat)) {
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        if ($page->ID != $home_id) $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      echo "\n<!-- breadcrumbs: ";print_r($breadcrumbs);echo " -->\n";
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo $delimiter;
      }
      if ($showCurrent == 1) {
	if (count($breadcrumbs) > 0) echo $delimiter;
	echo $before . get_the_title() . $after;
      }
 
    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;
 
    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page', 'deepsoft') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
  }
  echo '</div>';
}

function deepsoft_404_content() {
  $content = 'The page you are looking for does not exist; it may have been moved, or removed altogether. You might want to try the search function or return to the '.
                '<a href="' . user_trailingslashit(home_url()) . '">' .
                'front page' . '</a>';
  echo $content;
}

if ( !is_admin() ) {
    add_action( 'wp_head', 'deepsoft_head_css' );
}


function deepsoft_head_css () {
  $options = get_option( 'deepsoft2_theme_options' ); 
  $custom_styles = $options['custom_styles'];
  if (! empty($custom_styles) ) {
    echo "\r\n<style type=\"text/css\">".$custom_styles.'</style>';
  }
}

function deepwoods_get_post_meta($postid,$key,$arrayP = false) {
  if ($arrayP) { // backwards compatibility checking
    $metaold = get_post_meta($postid, $key, false); // Old version
    $metanew = get_post_meta($postid, $key, true); // New version
    if (is_array($metanew)) {
      return $metanew;
    } else {
      return $metaold;
    }
  } else { // just a scalar
    return get_post_meta($postid, $key, true);
  }
}

function deepwoods_update_post_meta($postid, $key, $new, $arrayP = false) {
  if ($arrayP) {
    $metaold = get_post_meta($postid, $key, false); // Old version
    $metanew = get_post_meta($postid, $key, true); // New version
    if (is_array($metanew)) {
      update_post_meta($postid, $key, $new);
    } else {
      delete_post_meta($postid, $key);
      add_post_meta($postid, $key, $new, true);
    }
  } else {
    update_post_meta($postid, $key, $new);
  }
}

function deepwoods_delete_post_meta($postid, $key, $old, $arrayP = false) {
  if ($arrayP) {
    $metaold = get_post_meta($postid, $key, false); // Old version
    $metanew = get_post_meta($postid, $key, true); // New version
    if (is_array($metanew)) {
      delete_post_meta($postid, $key, $old);
    } else {
      delete_post_meta($postid, $key);
    }
  } else {
    delete_post_meta($postid, $key, $old);
  }
}

function deepwoods_add_LinkBox ($atts, $content="") {
  extract(shortcode_atts(array('page' => 'Home',
			       'linktext' => 'Custom contract programming, Linux Administration, and Web Hosting services',
			       'description' => 'Home page (generic link to Deepwoods Software).',
			       'outer' => 'tr',
			       'innerheader' => 'th',
			       'inner' => 'td'
      ), $atts));
  $thepage = get_page_by_title($page);
  $thepage_id = $thepage->ID;
  $pageURL = get_permalink($thepage_id);
  $content_expanded = do_shortcode($content);
  $linkbox = '<p><a href="'.$pageURL.'">'.$linktext.'</a>'.$content_expanded.'</p>';

  $result  = '<'.$outer.'>';
  $result .= '<'.$innerheader.' colspan="2" style="width:100%;text-align:center;">'.$description.'</'.$innerheader.'>';
  $result .= '</'.$outer.'>';
  $result .= '<'.$outer.'>';
  $result .= '<'.$innerheader.' style="width:50%;">Link Sample</'.$innerheader.'>';
  $result .= '<'.$innerheader.' style="width:50%;">HTML Code</'.$innerheader.'>';
  $result .= '</'.$outer.'>';
  $result .= '<'.$outer.'>';
  $result .= '<'.$inner.' style="width:50%;">';
  $result .= $linkbox;
  $result .= '</'.$inner.'>';
  $result .= '<'.$inner.' style="width:50%;">';
  $result .= '<textarea readonly="readonly" rows="6" cols="35" onClick="this.select()">';
  $result .= $linkbox;
  $result .= '</textarea>';
  $result .= '</'.$inner.'>';
  $result .= '</'.$outer.'>';
  return $result;
}

function deepwoods_gcpaybutton ($atts, $content="") {
  extract(shortcode_atts(array('item' => 'web hosting',
                               'amount' => 10),$atts));
  $result  = '<a href="https://new.commongood.earth/pay-with-cg/company=NEWBHX&item=';
  $result .= urlencode($item);
  $result .= '&amount=';
  $result .= urlencode($amount);
  $result .= '" target="_blank"><img src="https://cg4.us/images/buttons/cgpay.png" height="50" /></a>';
  return $result;
}

add_shortcode('DWS_add_LinkBox','deepwoods_add_LinkBox');
add_shortcode('DWS_GCPayButton','deepwoods_gcpaybutton');
?>
