<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="content-language" content="en" />
<!-- Begin deepsoft_headerContent -->
<?php $opts = get_option("deepsoft3_theme_options");
       echo stripslashes($opts['headerContent']); ?>
<!-- End deepsoft_headerContent -->
<meta name="generator" content="WordPress <?php bloginfo( 'version' ); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_uri(); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="SHORTCUT ICON" href="<?php echo esc_url( get_template_directory_uri() ); ?>/dws.ico" />
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a name="top"></a>
  <div id="page">
    <header>
    <div id="header">
      <div id="headerimgwrap">
        <div id="headerimg">
          <table width="100%" class="header" cellspacing="0" cellpadding="0" align="center">
            <tr class="header">
              <td align="left" height="20" valign="bottom" class="header">
                <h1 class="header"><?php
                 if ( is_front_page() || is_home() ) {
                   bloginfo('description'); 
                 } else if ( is_page() || is_single()) {
                   single_post_title('');
                 } elseif (is_category()) {
                   single_cat_title('');
                 } elseif (is_day()) {
                   if (have_posts()) {
                     $post = $posts[0]; // Hack. Set $post so that the_date() works.
                     echo "Archive for ";
                     the_time('F jS, Y');
                   }
                 } elseif (is_month()) {
                   if (have_posts()) {
                     $post = $posts[0]; // Hack. Set $post so that the_date() works.
                     echo "Archive for ";
                     the_time('F, Y');
                   }
                 } elseif (is_year()) {
                   if (have_posts()) {
                     $post = $posts[0]; // Hack. Set $post so that the_date() works.
                     echo "Archive for ";
                     the_time('Y');
                   }
                 } elseif (is_search()) {
                   if (have_posts()) {
                     echo "Search Results";
                   }
                 } else {
               } ?></h1>
           </td>
           <td class="header" align="right" rowspan="3" valign="center" height="42"><?php get_search_form(); ?></td>
         </tr>
         <tr class="header">
           <td class="header" valign="middle" height="1">
             <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/g340ClearHStrut.png" alt="Strut" width="235" height="1" border="0">
           </td>
         </tr>
         <tr class="header">
           <td align="left" height="20" valign="top" class="header">
             <h2 class="header"><?php 
              if ( is_page() || is_single() ) {
                $p = $post->ID;
                $description2 = '';
                $description2 = get_post_meta($p, '_description2', true);
                if ( empty($description2) ) $description2 = get_post_meta($p, 'description2', true);
                if ("$description2" == "%search") {
                  /* get_search_form(); */
                } else {
                  echo $description2;
                }
              } elseif (is_category()) {
                echo strip_tags(category_description( ));
              } else {
                /* get_search_form(); */
              }
            ?></h2>
          </td>
        </tr>
        <tr class="header" height="64"> 
          <td class="header" valign="bottom" align="left" height="64">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/largeHeader-2.png"
             width="156" height="44" alt="Deepwoods Software" class="headerDWS" /></td>
          <td class="headerWhat" valign="bottom" align="right" height="64"><p class="whatText">C, C++, Tcl/Tk<br />Programming/<br />Consulting</p></td></tr>
      </table>
    </div><!--end headerimg-->
  </div><!--end headerimgwrap-->
  <?php /*file_put_contents("php://stderr","*** header.php: calling navbar, title is |".get_the_title()."|\n"); */ ?>
  <?php get_template_part( 'navbar' , 'top' ); /* navbar(-top).php */ ?>  
