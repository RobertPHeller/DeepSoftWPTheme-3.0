<footer>
<div id="footer">
<div id="footerr">
<div id="footermid">
<?php /*file_put_contents("php://stderr","*** footer.php: calling navbar, title is |".get_the_title()."|\n"); */ ?>
<?php get_template_part( 'navbar' , 'bottom' ); /* navbar(-bottom).php */ ?>  
<ul id="contact">
  <li>Deepwoods Software</li>
  <li>51 Locke Hill Road</li>
  <li>Wendell, MA 01379</li><li>978-633-5364</li>
  <li><a href="mailto:sales@deepsoft.com">sales@deepsoft.com</a></li>
</ul><br />
<div id="copyright">
Content and Theme Copyright &#169; 2009-2026 <a href="<?php bloginfo('siteurl'); ?>"><?php bloginfo('name'); ?></a>.
Comments about this site or the WordPress Theme it uses should be sent to <a href="mailto:<?php bloginfo('admin_email'); ?>">Robert Heller</a>.
See our <a href="<?php bloginfo('siteurl'); ?>/privacypolicy">privacy policy</a>.
</div> <!-- id="copyright" -->
</div> <!-- id="footermid" -->
</div> <!-- id="footerr"   -->
</div> <!-- id="footer"    -->
</footer>
</div><!--page-->
<?php   wp_footer(); ?>
<!-- Begin deepsoft_footerContent -->
<?php $opts = get_option("deepsoft3_theme_options");
      echo stripslashes($opts['footerContent']); ?>
<!-- End deepsoft_footerContent -->
</body>
</html>

