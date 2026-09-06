<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<div class="entrytext">
  <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
  <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 
                            'after' => '</p>', 
                            'next_or_number' => 'number')); ?>
</div>
<?php get_template_part( 'bottompost' ); /* bottompost.php */  ?>
</div>
