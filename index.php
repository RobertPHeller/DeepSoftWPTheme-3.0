<?php get_header(); /* header.php */
      $opts = get_option("deepsoft3_theme_options");
      get_template_part( 'breadcrumbs' ); /* breadcrumbs.php */
      get_template_part( 'googleadsense', 'leader' ); /* googleadsense(-leader).php */
      echo "</header>";
      if ($opts['enableleft']) {
        get_template_part( 'sidebar', 'left' ); /* sidebar(-left).php */
      }
  ?>
<div id="content" class="narrowcolumn <?php if (!$opts['enableleft']) {echo "narrowcolumn-noleft"; } ?>">
  <main>
  <?php
    if ( have_posts() ) {
      get_template_part( 'postnav', 'top' );
      global $deepwoods_postcount;
      $deepwoods_postcount = 0;
      while ( have_posts() ) {
        the_post(); 
        /* get_post_format() => 'aside', 'chat', 'gallery', 'link',	
          'image', 'quote', 'status', 'video',
          'audio', or false 
          (false implies 'standard') */
        $format = get_post_format();
        if ( false === $format ) $format = 'standard';
        get_template_part( 'content', $format ); /* content(-$format).php */
        $deepwoods_postcount++;
        get_template_part( 'googleadsense', 'interpost' ); /* googleadsense(-interpost).php */
      } //End While loop
      get_template_part( 'postnav', 'bottom' );
    } else {
    ?>
    <h2 class="center"><?php _e( 'Not Found', 'deepsoft' ) ?></h2>
    <p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here', 'deepsoft' ) ?>.</p>
    <?php get_search_form(); /* searchform.php */?>
    <?php } ?>
  </main>
  <?php get_template_part( 'bottomsidebar' ); /* bottomsidebar */?>
</div>
<?php  get_template_part( 'sidebar', 'right' ); /* sidebar(-right).php */
get_footer(); /* footer.php */ ?>
