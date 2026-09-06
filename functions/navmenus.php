<?php

function deepsoft_register_menus () {
  register_nav_menus (
	array (
	   'header-menu' => __('Header Menu', 'deepsoft'),
	   'footer-menu' => __('Footer Menu', 'deepsoft') ) );
}

add_action('init','deepsoft_register_menus');

class deepwoods_top_menu_walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = $childclass = '';

        if ( $args->has_children ) {
            $childclass = 'has_children';
        }
        $classes = empty( $item->classes ) ? array( ) : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . ' ' . $childclass . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .=!empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .=!empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .=!empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

class deepwoods_bottom_menu_walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = $childclass = '';

        if ( $args->has_children ) {
            $childclass = 'has_children';
        }
        $classes = empty( $item->classes ) ? array( ) : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . ' ' . $childclass . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .=!empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .=!empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .=!empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

function deepwoods_standard_page_menu ($args) {
  $defaults = array('container' => 'div',
		    'container_id' => 'navwrap',
		    'menu_class'     => 'flat_menu',
		    'menu_id'        => 'nav');
  $args = wp_parse_args( $args, $defaults );
  $args = apply_filters( 'wp_page_menu_args', $args );
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
  $menu = '';
  $menu .= '<li><a href="'.$homeLink.'" title="'.$homeTitle.'">'.$homeTitle.'</a></li>';
  $menu .= wp_list_categories( array ('title_li' => '',
				      'depth' => 1,
				      'include' => get_cat_ID('News'),
				      'echo' => 0 ));
  $children = wp_list_pages( array ('title_li' => '',
				    'depth' => 1,
				    'sort_column' => 'menu_order',
				    'child_of' => $pageid,
				    'echo' => 0 ));
  if ( empty($children) ) {
    if ($parent != 0 && $parent != $home_id) {
      $parentbutton = $parent;
      $pageid = $parent;
    } else {
      $parentbutton = 0;
      $pageid = $home_id;
    }
  } elseif ($pageid != $home_id) {
    $parentbutton = $pageid;
  } else {
    $parentbutton = 0;
  }
  if ( $parentbutton != 0) {
    $menu .= wp_list_pages( array ('title_li' => '',
				   'depth' => 1,
				   'sort_column' => 'menu_order',
				   'include' => $pageid,
				   'echo' => 0 ));
  }
  $menu .= wp_list_pages( array ('title_li' => '',
				 'depth' => 1,
				 'sort_column' => 'menu_order',
				 'exclude' => $home_id,
				 'child_of' => $pageid,
				 'echo' => 0 ));
  $bugreporturl = '';
  $bugreporturl = get_post_meta($pageid, 'bugreporturl', true);
  if (! empty($bugreporturl) ) {
    $menu .= '<li><a href="'.$bugreporturl.'">File a Bug</a></li>';
  }
  $consultPage = get_page_by_path('freeconsultation');
  $consult = $consultPage->ID;
  $menu .= wp_list_pages( array ('title_li' => '',
				 'depth' => 1,
				 'include' => $consult,
				 'echo' => 0 ));
  $sitemapPage = get_page_by_path('sitemap');
  $sitemap = $sitemapPage->ID;
  $menu .= wp_list_pages( array ('title_li' => '',
				 'depth' => 1,
				 'include' => $sitemap,
				 'echo' => 0 ));
  $menu .= wp_list_categories( array ('title_li' => '',
				      'depth' => 1,
				      'include' => get_cat_ID('Linux Articles'),
				      'echo' => 0 ));
  $m1 = '<ul';
  if (! empty($args['menu_id']) ) {
    $m1 .= ' id="'.$args['menu_id'].'"';
  }
  if (! empty($args['menu_class']) ) {
    $m1 .= ' class="'.$args['menu_class'].'"';
  }
  $menu = $m1.'>'.$menu.'</ul>';
  if ($container) {
    $c1 = '<'.$container;
    if (! empty($args['container_id']) ) {
      $c1 .= ' id="'.$args['container_id'].'"';
    }
    if (! empty($args['container_class']) ) {
      $c1 .= ' class="'.$args['container_class'].'"';
    }
    $menu = $c1.'>'.$menu.'</'.$container.'>';
  }
  if ( $args['echo'] ) {
    echo $menu;
  } else {
    return $menu;
  }
}
