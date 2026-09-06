<?php 
@header("HTTP/1.1 404 Not Found"); 
@header("Status: 404 Not Found"); ?>
<?php get_header(); /* header.php */
      $opts = get_option("deepsoft2_theme_options");
      get_template_part( 'breadcrumbs' ); /* breadcrumbs.php */
      get_template_part( 'googleadsense', 'leader' ); /* googleadsense(-leader).php */
      echo "</header>";
      if ($opts['enableleft']) {
        get_template_part( 'sidebar', 'left' ); /* sidebar(-left).php */ 
      }
    ?>
    <div id="content" class="narrowcolumn <?php if (!$opts['enableleft']) {echo "narrowcolumn-noleft"; } ?>">
      <main><h2 class="center">Error 404 - Not Found</h2>
      <div class="content">
        <?php deepsoft_404_content(); ?>
      </div></main>
      <?php get_template_part( 'bottomsidebar' ); /* bottomsidebar */?>
    </div>
    <?php  get_template_part( 'sidebar', 'right' ); /* sidebar(-right).php */
      get_footer(); /* footer.php */ ?>

