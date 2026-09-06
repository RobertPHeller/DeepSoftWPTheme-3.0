<?php
   /* Deepwoods Metaboxes */

/*
_description2 -- text
_linkcatpage  -- select(categories)
_linkcat      -- select(categories)
_rightbutton  -- list of textareas
_screenshotdir -- text
_screenshot -- list of arrays[thumb,media,caption,description]
		thumb,media,caption could be vectors!
_sitemapp  -- checkbox
_downloadp -- checkbox
_downloads -- list of arrays[description,size,thelink,thelinkname]
_buybuttons -- list of arrays[text,thelink,thebutton]
_auxlinks -- list of arrays[text,thelink,thelinkname]
*/

//Code lifted from Tammy Hart's Reusable Custom Meta Boxes tutorial
//http://wp.tutsplus.com/tutorials/reusable-custom-meta-boxes-part-1-intro-and-basic-fields/
   
class Deepwoods_Metaboxes {
  private $fields;
  private $prefix;

  function __construct() {
    add_action('add_meta_boxes', array ($this, 'add_meta_box'));
    add_action('save_post', array ($this, 'save_meta'));
    $this->prefix = 'deepwoods_meta_';
    $this->fields = array(
	array ('label'=> 'Subtitle',
	       'desc'  => 'Subtitle for the page or post',
	       'option' => '_description2',
	       'id' => $this->prefix.'description2',
	       'type' => 'text',
	       'repeatable' => false),
	array ('label'=> 'Link page category',
	       'desc'  => 'Page of link category',
	       'option' => '_linkcatpage',
	       'id' => $this->prefix.'linkcatpage',
	       'type' => 'link_categories',
	       'repeatable' => false),
	array ('label'=> 'Related links category',
	       'desc'  => 'Related links category',
	       'option' => '_linkcat',
	       'id' => $this->prefix.'linkcat',
	       'type' => 'link_categories',
	       'repeatable' => false),
	array ('label'=> 'Display Sitemap?',
	       'desc'  => '',
	       'option' => '_sitemapp',
	       'id' => $this->prefix.'sitemapp',
	       'type' => 'checkbox',
	       'repeatable' => false),
	array ('label'=> 'Side Buttons',
	       'desc'  => 'Sidebar ad blocks/buttons',
	       'option' => '_rightbutton',
	       'id' => $this->prefix.'rightbutton',
	       'type' => 'textarea',
	       'repeatable' => true),
	array ('label'=> 'Screen Shot subdirectory',
	       'desc'  => '',
	       'option' => '_screenshotdir',
	       'id' => $this->prefix.'screenshotdir',
	       'type' => 'text',
	       'repeatable' => false),
	array ('label' => 'Screen Shots',
	       'desc'  => '',
	       'option' => '_screenshot',
	       'id' => $this->prefix.'screenshot',
	       'type' => 'array',
	       'repeatable' => true,
	       'fields' => array(
			'thumb' => array('label' => 'Thumb',
					 'type'  => 'vector',
					 'class' => 'scrollable'),
			'media' => array('label' => 'Media',
					 'type'  => 'vector',
					 'class' => 'scrollable'),
			'caption' => array('label' => 'Caption',
					   'type'  => 'vector',
					 'class' => 'scrollable'),
			'description' => array('label' => 'Description',
					       'type'  => 'textarea') ) ),
	array ('label' => 'Page has downloads?',
	       'desc'  => '',
	       'option' => '_downloadp',
	       'id' => $this->prefix.'downloadp',
	       'type' => 'checkbox',
	       'repeatable' => false),
	array ('label' => 'Downloads',
	       'desc'  => '',
	       'option' => '_downloads',
	       'id' => $this->prefix.'downloads',
	       'type' => 'array',
	       'repeatable' => true,
	       'fields' => array(
			'thelink'  => array('label' => 'Link', 
					    'type'  => 'text'),
			'size'  => array('label' => 'Size', 
					    'type'  => 'text'),
			'thelinkname'  => array('label' => 'Link Name', 
					    'type'  => 'text'),
			'description' => array('label' => 'Description',
					       'type'  => 'textarea') ) ),
	array ('label' => 'Buy Buttons',
	       'desc'  => '',
	       'option' => '_buybuttons',
	       'id' => $this->prefix.'buybuttons',
	       'type' => 'array',
	       'repeatable' => true,
	       'fields' => array(
			'thelink'  => array('label' => 'Link', 
					    'type'  => 'text',
					 'class' => 'scrollable'),
			'thebutton'  => array('label' => 'Button', 
					    'type'  => 'text',
					 'class' => 'scrollable'),
			'text' => array('label' => 'Text',
					       'type'  => 'textarea') ) ),
	array ('label' => 'Aux Links',
	       'desc'  => '',
	       'option' => '_auxlinks',
	       'id' => $this->prefix.'auxlinks',
	       'type' => 'array',
	       'repeatable' => true,
	       'fields' => array(
			'thelink'  => array('label' => 'Link', 
					    'type'  => 'text',
					    'class' => 'scrollable'),
			'thelinkname'  => array('label' => 'Link Name', 
					    'type'  => 'text'),
			'text' => array('label' => 'Text',
					       'type'  => 'textarea') ) ) 
		
    );
    // enqueue scripts and styles, but only if is_admin
    if(is_admin() && $this->is_post_editor_page()) {
	wp_enqueue_style('deepwoods-metabox-style', get_template_directory_uri().'/css/deepwoods-metabox-style.css');
	wp_enqueue_script('deepwoods-js', get_template_directory_uri().'/js/deepwoods-js.js');
	//wp_enqueue_style('jquery-ui-deepwoods', get_template_directory_uri().'/css/jquery-ui-deepwoods.css');
	
    }
  }
  function is_post_editor_page() {
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::is_post_editor_page: _SERVER is ".print_r($_SERVER,true)."\n");
    $page = basename($_SERVER['SCRIPT_NAME'],'.php');
    if ($page == 'post-new' || $page == 'edit' || $page == 'post') return true;
    else return false;
  }
  function add_meta_box() {
    add_meta_box( 'deepwoods-meta-boxes',
		  'Deepwoods Page Meta Boxes',
		   array ($this, 'meta_boxes'),
		   'post');
    add_meta_box( 'deepwoods-meta-boxes',
		  'Deepwoods Page Meta Boxes',
		   array ($this, 'meta_boxes'),
		   'page');
  }
  function meta_boxes($post, $args) {
    // Use nonce for verification  
    echo '<input type="hidden" name="'.$this->prefix.'meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
      
    // Begin the field table and loop  
    echo '<table class="form-table deepwoods-metabox">';
    foreach ($this->fields as $field) {
      // get value of this field if it exists for this post
      $meta = deepwoods_get_post_meta($post->ID, $field['option'], $field['repeatable']);
      // begin a table row with
      echo '<tr> 
            <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
            <td>';  
      if (!$field['repeatable']) {
	$this->show_meta_field($meta,$field);
      } else {
	$this->show_meta_repeatable($meta,$field);
      }
      echo '</td></tr>';  
    } // end foreach
    echo '</table>'; // end table
  }
  function show_meta_field($meta,$field,$repeatable=-1,$arrayindx='') {
    switch($field['type']) {  
      // case items will go here  
      // text
      case 'text':
        echo '<input type="text" name="'.$field['id'].$this->make_indexes($repeatable,$arrayindx).'" id="'.$field['id'].'" value="'.htmlspecialchars($meta).'" size="60" ';
	if ($field['class']) echo 'class="'.$field['class'].'" ';
	echo '/>';
	if ($field['desc'] != '') 
	  echo '<br /><span class="description">'.$field['desc'].'</span>';
      break;
      // textarea
      case 'textarea':
	echo '<textarea name="'.$field['id'].$this->make_indexes($repeatable,$arrayindx).'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>';
	if ($field['desc'] != '')
	  echo '<br /><span class="description">'.$field['desc'].'</span>';
      break;
      // checkbox
      case 'checkbox':
	echo '<input type="checkbox" name="'.$field['id'].$this->make_indexes($repeatable,$arrayindx).'" id="'.$field['id'].'" value="1" ',$meta ? ' checked="checked"' : '','/>
		<label for="'.$field['id'].'">'.$field['desc'].'</label>';
      break;
      // String vector
      case 'vector':
	echo '<input type="text" name="'.$field['id'].$this->make_indexes($repeatable,$arrayindx).'" id="'.$field['id'].'" value="'.htmlspecialchars($this->stringlist($meta)).'" size="60" ';
	if ($field['class']) echo 'class="'.$field['class'].'" ';
	echo '/>';
	if ($field['desc'] != '') 
	  echo '<br /><span class="description">'.$field['desc'].'</span>';
      break;
      // link_categories
      case 'link_categories':
	echo '<select name="'.$field['id'].$this->make_indexes($repeatable,$arrayindx).'" id="'.$field['id'].'">';
	echo '<option value="" '.(($meta == "")?'selected="selected" ':'').'>--None--</option>';
	foreach (get_terms('link_category', 'fields=names&hide_empty=0') as $linkcategory) {
	  ?>
	  <option value="<?php echo $linkcategory; ?>" <?php
	  if ($linkcategory == $meta) echo 'selected="selected" ';
	  ?>><?php echo $linkcategory; ?></option>
	  <?php
	}
	echo '</select>';
	if ($field['desc'] != '')
	  echo '<br /><span class="description">'.$field['desc'].'</span>';
      break;
      case 'array':
	$this->show_meta_field_array($meta,$field,$repeatable);
      break;
    } //end switch
  }
  function show_meta_field_array($metapacked,$field,$repeatable) {
    echo '<div class="form-table deepwoods-metabox div-as-table">';
    $metadefaults = array();
    foreach (array_keys($field['fields']) as $key) $metadefaults[$key] = '';
    $meta = wp_parse_args($metapacked,$metadefaults);
    $alt = '';
    foreach ($field['fields'] as $fieldname => $fieldspec) {
      $subfield = $fieldspec;
      $subfield['id'] = $field['id'];
      $subfield['desc']  = '';
      $submeta = $meta[$fieldname];
      echo '<div class="div-as-table-row';
      /* if ($alt != '') {
	echo ' '.$alt;
	$alt = '';
      } else {
	$alt = 'alternate';
      } */
      echo '">';
      echo '<span class="span-as-th"><label for="'.$field['id'].'">'.$subfield['label'].'</label></span><span class="span-as-td">';
      $this->show_meta_field($submeta,$subfield,$repeatable,$fieldname);
      echo '</span>';
      echo '</div>';
    }
    echo '</div>';
  }
  function make_indexes($i,$field) {
    $result = '';
    if ($i >= 0) $result .= '['.$i.']';
    if ($field != '') $result .= "[".$field."]";
    return $result;
  }
  function show_meta_repeatable($meta,$field) {
    $image_uri = get_template_directory_uri().'/images/';
    echo '<a class="repeatable-add button" href="#"><img src="'.$image_uri.'add.png" width="16" height="16" alt="+" /></a>
	  <ul id="'.$field['id'].'-repeatable" class="deepwoods_metabox_repeatable">';
    $i = 0;
    $tempfield = $field;
    $tempfield['desc'] = '';
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::show_meta_repeatable: field is ".print_r($field,true)."\n");
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::show_meta_repeatable: meta is ".print_r($meta,true)."\n");
    if ($meta && is_array($meta) && count($meta) > 0) {
      foreach($meta as $row) {
	echo '<li><span class="sort hndle"><img src="'.$image_uri.'up-down.png" width="16" height="32" alt="-" /></span>';
	$this->show_meta_field($row,$tempfield,$i);
	echo '<a class="repeatable-remove button" href="#"><img src="'.$image_uri.'remove.png" width="16" height="16" alt="-" /></a></li>';
	$i++;
      }
    } else {
	echo '<li><span class="sort hndle"><img src="'.$image_uri.'up-down.png" width="16" height="32" alt="-" /></span>';
	$this->show_meta_field('',$tempfield,$i);
	echo '<a class="repeatable-remove button" href="#"><img src="'.$image_uri.'remove.png" width="16" height="16" alt="-" /></a></li>';
    }
    echo '</ul>
          <span class="description">'.$field['desc'].'</span>';

  }
  function save_meta($post_id) {
    // verify nonce
    if (!wp_verify_nonce($_POST[$this->prefix.'meta_box_nonce'], basename(__FILE__))) 
	return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) return $post_id;
    } else if (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::save_meta: _POST is ".print_r($_POST,true)."\n");

    // loop through fields and save the data
    foreach ($this->fields as $field) {
      if ($field['type'] == 'array') {
	$new = $this->packarray($_POST[$field['id']],$field['repeatable'],$field['fields']);
      } else if ($field['type'] == 'vector') {
        $new = $this->stringtovector($_POST[$field['id']]);
      } else {
	$new = $_POST[$field['id']];
      }
      if ($field['repeatable']) {
	$new = $this->removeemptys($new);
      }
      $old = deepwoods_get_post_meta($post_id, $field['option'],$field['repeatable'] );
      //if ($field['repeatable']) {
	//file_put_contents("php://stderr","*** Deepwoods_Metaboxes::save_meta: field is ".print_r($field,true)."\n");
	//file_put_contents("php://stderr","*** Deepwoods_Metaboxes::save_meta: new is ".print_r($new,true)."\n");
	//file_put_contents("php://stderr","*** Deepwoods_Metaboxes::save_meta: old is ".print_r($old,true)."\n");
      //}
      if (!empty($new) && $new != $old) {
	deepwoods_update_post_meta($post_id, $field['option'], $new,$field['repeatable']);
      } else if (empty($new) && $old) {
	deepwoods_delete_post_meta($post_id, $field['option'], $old,$field['repeatable']);
      }
    }
  }
  function removeemptys($arr) {
    $new = array();
    foreach ($arr as $v) {
      if (!empty($v)) $new[] = $v;
    }
    return $new;
  }
  function packarray($postvalue,$isrepeatable,$fields) {
    if ($isrepeatable) {
      $result = array();
      foreach ($postvalue as $onepostvalue) {
	$packedvalue = $this->packarray($onepostvalue,false,$fields);
	if ($packedvalue != '') $result[] = $packedvalue;
      }
      return $result;
    }
    $newarray = array();
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::packarray: postvalue is ".print_r($postvalue,true)."\n");
    foreach ($postvalue as $key => $thevalue) {
      if ($fields[$key]['type'] == 'vector') $thevalue=$this->stringtovector($thevalue);
      if (is_array ($thevalue) ) {
	$newvalue = array();
	foreach ($thevalue as $v) {
	  $newvalue[] = htmlspecialchars(stripslashes($v),ENT_QUOTES);
	}
      } else {
	$newvalue = htmlspecialchars(stripslashes($thevalue),ENT_QUOTES);
      }
      $newarray[$key] = $newvalue;
    }
    if ($this->allempty($newarray)) return '';
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::packarray: newarray is ".print_r($newarray,true)."\n");
    $q = http_build_query($newarray);
    //file_put_contents("php://stderr","*** Deepwoods_Metaboxes::packarray: q = |$q|\n");
    return $q;
  }
  function allempty($arr) {
    foreach ($arr as $key => $value) {
      if ($value != '') return false;
    }
    return true;
  }
  function packvector($vector) {
    return http_build_query($vector);
  }
  function stringlist($vector) {
    if (empty($vector)) return '';
    else return implode(';;',$vector);
  }
  function stringtovector($stringlist) {
    return explode(';;',$stringlist);
  }
}

new Deepwoods_Metaboxes();



