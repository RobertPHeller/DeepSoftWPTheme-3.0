<?php 
  /* Deepwoods Software V3.0 Theme Widgets */

  class Deepwoods_PageSpecificSidebarButtons extends WP_Widget {
      /* Initialize ourselves */
      function __construct() {
	/* Widget settings. */
        $widget_ops = array( 'classname' => 'PageSpecificSidebarButtons',
			     'description' => __('Display Page Specific Sidebar Buttons', 'deepsoft') );
	/* Create the widget. */
	parent::__construct( 'PageSpecificSidebarButtons', 
			  __('Page Specific Sidebar Buttons', 'deepsoft'), 
			  $widget_ops);
      }

      /**
	* How to display the widget on the screen. 
 	*/
      function widget( $args, $instance ) {
	extract( $args );
	echo $before_widget;
	echo $before_title . $after_title;
	if ( is_page() || is_single() ) {
	  global $post;
	  $p = $post->ID;
	  $rightbuttons = '';
	  $rightbuttons =  deepwoods_get_post_meta($p, '_rightbutton', true);
	  if ( empty($rightbuttons) ) $rightbuttons =  deepwoods_get_post_meta($p, 'rightbutton', true);
	  while ( empty($rightbuttons) && $p > 0) {
	    $page = get_page($p);
	    $p = $page->post_parent;
	    $rightbuttons =  deepwoods_get_post_meta($p, '_rightbutton', true);
	    if ( empty($rightbuttons) ) $rightbuttons =  deepwoods_get_post_meta($p, 'rightbutton', true);
	  }
	  if ( empty($rightbuttons) ) {
	    $page = get_page_by_title('Home');
	    $p = $page->ID;
	    $rightbuttons =  deepwoods_get_post_meta($p, '_rightbutton', true);
	    if ( empty($rightbuttons) ) $rightbuttons =  deepwoods_get_post_meta($p, 'rightbutton', true);
	  }
	} else {
	  $page = get_page_by_title('Home');
	  $p = $page->ID;
	  $rightbuttons =  deepwoods_get_post_meta($p, '_rightbutton', true);
	  if ( empty($rightbuttons) ) $rightbuttons =  deepwoods_get_post_meta($p, 'rightbutton', true);
	}
	if ( ! empty($rightbuttons) ) {
	  /*file_put_contents("php://stderr","*** Deepwoods_PageSpecificSidebarButtons::widget: rightbuttons is ".print_r($rightbuttons,true)."\n");*/
	  ?><div id="pagebuttons"><?php 
	  foreach ($rightbuttons as $rightbutton ) {
	    echo $rightbutton;
	    ?><br><?php 
	  }
	  ?></div><?php 
	}
	echo $after_widget;
      }
  }


  class Deepwoods_RelatedLinks extends WP_Widget {
      /* Initialize ourselves */
      function __construct() {
	/* Widget settings. */
	$widget_ops = array( 'classname' => 'RelatedLinks',
			     'description' => __('Related Links', 'deepsoft') );
	/* Create the widget. */
	parent::__construct( 'RelatedLinks', __('Related Links', 'deepsoft'),
			  $widget_ops);
      }

      /**
	* How to display the widget on the screen. 
 	*/
      function widget( $args, $instance ) {
	extract( $args );
	echo $before_widget;
	if ( is_page() || is_single() ) {
	  global $post;
	  $p = $post->ID;
	  $linkcat = '';
	  $linkcat =  deepwoods_get_post_meta($p, '_linkcat', false);
	  if ( empty($linkcat) ) $linkcat =  deepwoods_get_post_meta($p, 'linkcat', false);
	  while ( empty($linkcat) && $p > 0) {
	    $page = get_page($p);
	    $p = $page->post_parent;
	    $linkcat =  deepwoods_get_post_meta($p, '_linkcat', false);
	    if ( empty($linkcat) ) $linkcat =  deepwoods_get_post_meta($p, 'linkcat', false);
	  }
	  if ( empty($linkcat) ) {
	    $page = get_page_by_title('Home');
	    $p = $page->ID;
	    $linkcat =  deepwoods_get_post_meta($p, '_linkcat', false);
	    if ( empty($linkcat) ) $linkcat =  deepwoods_get_post_meta($p, 'linkcat', false);
	  }
	} else {
	  $page = get_page_by_title('Home');
	  $p = $page->ID;
	  $linkcat =  deepwoods_get_post_meta($p, '_linkcat', false);
	  if ( empty($linkcat) ) $linkcat =  deepwoods_get_post_meta($p, 'linkcat', false);
	}
        if ( ! empty($linkcat) ) {
          /*file_put_contents("php://stderr","*** related links: linkcat is ".$linkcat."\n");*/
	  ?><div id="relatedlinks"><?php 
          wp_list_bookmarks(array(
	  'category_name' => $linkcat,
	  'categorize' => 0,
	  'category_before' => ' ',
	  'category_after' => ' ',
	  'before' => '<li class="therelatedlink">',
          'title_li' => 'Related Links',
          'title_before' => $before_title,
          'title_after' => $after_title
        ));
	  ?></div><?php 
	}
	echo $after_widget;
      }
  }


  class Deepwoods_GoogleAdSense extends WP_Widget {
    function __construct() {
      /* Widget settings. */
      $widget_ops = array( 'classname' => 'dwsgoogleadsense',
			   'description' => 
				__('Display Google Ad Sense Blocks', 
					'deepsoft') );
      $control_ops = array( 'width' => 300, 'height' => 350,
			    'id_base' => 'dwsgoogleadsense');
      /* Create the widget. */
      parent::__construct( 'dwsgoogleadsense',
			   __('Display Google Ad Sense Blocks', 'deepsoft'),
			   $widget_ops, $control_ops );
    }
    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
      extract( $args );
      /* Before widget (defined by themes). */
      echo $before_widget;
      $opts = get_option("deepsoft3_theme_options");
      switch ($opts['google_ad_type']) {
      case 's':
        ?><script type="text/javascript"><!--
                  google_ad_client = "<?php echo $opts['google_ad_client']; ?>";
                  google_ad_slot = "<?php echo $instance['google_ad_slot']; ?>";
                  google_ad_width = <?php echo $instance['google_ad_width']; ?>;
                  google_ad_height = <?php echo $instance['google_ad_height']; ?>;
                  //--> 
          </script>
          <script type="text/javascript"
           src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
          </script><?php
         break;
      case 'a':
        ?><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <ins class="adsbygoogle"
             style="display:inline-block;width:<?php echo $instance['google_ad_width']; ?>px;height:<?php echo $instance['google_ad_height']; ?>px"
             data-ad-client="<?php echo $opts['google_ad_client']; ?>"
             data-ad-slot="<?php echo $instance['google_ad_slot']; ?>"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script><?php
        break;
      }
      /* After widget (defined by themes). */
      echo $after_widget;
    }
    static function shortcode ($atts, $content=null, $code="") {
      extract( shortcode_atts ( array(
	'google_ad_slot' => '',
	'google_ad_width' => 0,
	'google_ad_height' => 0), $atts ) );
      $opts = get_option("deepsoft3_theme_options");
      switch ($opts['google_ad_type']) {
      case 's':
        $result  = '<script type="text/javascript"><!--
                      google_ad_client = "'.$opts['google_ad_client'].'";
                      google_ad_slot = "'.$google_ad_slot.'";
                      google_ad_width = '.$google_ad_width.';
                      google_ad_height = '.$google_ad_height.';
                      //-->
                    </script>
                    <script type="text/javascript"
                       src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                    </script>';
         break;
       case 'a':
         $result  = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <ins class="adsbygoogle"
             style="display:inline-block;width:'.$google_ad_width.'px;height:'.$google_ad_height.'px"
             data-ad-client="'.$opts['google_ad_client'].'"
             data-ad-slot="'.$google_ad_slot.'"></ins>
          <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
          </script>';
         break;
      }
      return $result;
    }
    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['google_ad_slot'] = $new_instance['google_ad_slot'];
      $instance['google_ad_width'] = $new_instance['google_ad_width'];
      $instance['google_ad_height'] = $new_instance['google_ad_height'];
      return $instance;
    }
    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {
      /* Set up some default widget settings. */
      $defaults = array( 'google_ad_slot' => "", 
			 'google_ad_width' => 0,
			 'google_ad_height' => 0 );
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>
      <p>
	<label for="<?php echo $this->get_field_id( 'google_ad_slot' ); 
	?>"><?php _e('Google Ad Slot','deepsoft'); ?></label>
	<input id="<?php echo $this->get_field_id( 'google_ad_slot' ); ?>"
	       value="<?php echo $instance['google_ad_slot']; ?>"
	       name="<?php echo $this->get_field_name( 'google_ad_slot' ); ?>"
	       style="width:100%;" />
      </p>
      <p>
	<label for="<?php echo $this->get_field_id( 'google_ad_width' ); 
	?>"><?php _e('Google Ad Width','deepsoft'); ?></label>
	<input id="<?php echo $this->get_field_id( 'google_ad_width' ); ?>"
	       value="<?php echo $instance['google_ad_width']; ?>"
	       name="<?php echo $this->get_field_name( 'google_ad_width' ); ?>"
	       style="width:100%;" />
      </p>
      <p>
	<label for="<?php echo $this->get_field_id( 'google_ad_height' ); 
	?>"><?php _e('Google Ad Height','deepsoft'); ?></label>
	<input id="<?php echo $this->get_field_id( 'google_ad_height' ); ?>"
	       value="<?php echo $instance['google_ad_height']; ?>"
	       name="<?php echo $this->get_field_name( 'google_ad_height' ); ?>"
	       style="width:100%;" />
      </p>
      <?php
    }
  }
  
  class Deepwoods_SingleBestsellerWidget extends WP_Widget {
    /* Initialize ourselves */
    function __construct() {
      /* Widget settings. */
      $widget_ops = array( 'classname' => 'SingleBestsellerWidget',
                          'description' => __('Single Bestseller Widget') );
      /* Create the widget. */
      parent::__construct( 'SingleBestsellerWidget',
                          __('Single Bestseller Widget', 'deepsoft'),
                          $widget_ops);
    }
    /**
      * How to display the widget on the screen. 
      */
    function widget( $args, $instance ) {
      extract( $args );
      echo $before_widget;
      echo $before_title . $after_title;
      <?php include( "https://www.drivethrurpg.com/single_bestseller_widget.php?affiliate_id=83696" ); ?>
      echo $after_widget;
    }
  }
  

  add_action( 'widgets_init', 'init_deepwoods_widgets' );

  function init_deepwoods_widgets() {
  
    register_widget('Deepwoods_PageSpecificSidebarButtons');
    register_widget('Deepwoods_RelatedLinks');
    register_widget('Deepwoods_GoogleAdSense');
    register_widget('Deepwoods_SingleBestsellerWidget');
  }

  add_shortcode('DWS_AdSense',array('Deepwoods_GoogleAdSense','shortcode'));
