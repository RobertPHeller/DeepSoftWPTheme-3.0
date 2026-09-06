<asside>
<div id="l_sidebar" class="sidebar"> 
<ul>
  <!-- dynamic_sidebar('Left Sidebar') -->
  <?php 	/* Widgetized sidebar, if you have the plugin installed. */
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Sidebar') ) : ?>
  <?php endif; ?>
</ul>
<?php 
get_template_part( 'sidebar', 'always' );  /* sidebar(-always).php */
?>
</div> <!-- id="l_sidebar" -->
</asside>


