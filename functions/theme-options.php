<?php

//Thanks to The Automattic Theme Team
//http://themeshaper.com/sample-theme-options/

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'deepsoft3_options', 'deepsoft3_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Deepwoods Software V2 Options', 'deepsoft' ), __( 'Deepwoods Software V3 Options', 'deepsoft' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
$ad_every_n_posts = array(
	'0' => array(
		'value' =>	'0',
		'label' => __( 'Zero', 'deepsoft' )
	),
	'1' => array(
		'value' =>	'1',
		'label' => __( 'One', 'deepsoft' )
	),
	'2' => array(
		'value' => '2',
		'label' => __( 'Two', 'deepsoft' )
	),
	'3' => array(
		'value' => '3',
		'label' => __( 'Three', 'deepsoft' )
	),
	'4' => array(
		'value' => '4',
		'label' => __( 'Four', 'deepsoft' )
	),
	'5' => array(
		'value' => '3',
		'label' => __( 'Five', 'deepsoft' )
	)
);

function deepwoods_yes_no_rbs($label,$optionname,$optionvalue,$default = 'yes') {
  $yes_no = array(
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Yes', 'deepsoft' )
	),
	'no' => array(
		'value' => 'no',
		'label' => __( 'No', 'deepsoft' )
	)
  );

  if ($optionvalue == '') $optionvalue = $default;

  ?><tr valign="top"><th scope="row"><?php echo $label; ?></th>
	<td>
	    <fieldset><legend class="screen-reader-text"><span><?php echo $label; ?></span></legend>
	    <?php
		if ( ! isset( $checked ) ) $checked = '';
		foreach ( $yes_no as $option ) {
		  if ( '' != $optionvalue ) {
		    if ( $optionvalue == $option['value'] ) {
		      $checked = "checked=\"checked\"";
		    } else {
		      $checked = '';
		    }
		  }
		  ?>
		  <label class="description"><input type="radio" name="deepsoft3_theme_options[<?php echo $optionname; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
		  <?php
		}
	    ?>
	    </fieldset>
	</td>
     </tr><?php
}

function deepwoods_rbs($label,$lv_array,$optionname,$optionvalue,$default)
{
  if ($optionvalue == '') $optionvalue = $default;
  
  ?><tr valign="top"><th scope="row"><?php echo $label; ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php echo $label; ?></span></legend>
      <?php
        if ( ! isset( $checked ) ) $checked = '';
        foreach ( $lv_array as $value_label => $value )
        {
          if ( '' != $optionvalue ) {
            if ( $optionvalue == $value ) 
            {
              $checked = "checked=\"checked\"";
            } else {
              $checked = '';
            }
          }
        ?>
        <label class="description"><input type="radio" name="deepsoft3_theme_options[<?php echo $optionname; ?>]" value="<?php echo esc_attr( $value); ?>" <?php echo $checked; ?> /> <?php echo $value_label; ?></label><br />
        <?php
        }
      ?></fieldset></td>
  </tr><?php
}


//$radio_options = array(
//	'yes' => array(
//		'value' => 'yes',
//		'label' => __( 'Yes', 'deepsoft' )
//	),
//	'no' => array(
//		'value' => 'no',
//		'label' => __( 'No', 'deepsoft' )
//	),
//	'maybe' => array(
//		'value' => 'maybe',
//		'label' => __( 'Maybe', 'deepsoft' )
//	)
//);


/**
 * Create the options page
 */
function theme_options_do_page() {
	global $ad_every_n_posts/*, $radio_options*/;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
          <?php
            $theme = wp_get_theme();
            if ($theme == null) {
              $theme_name = "Deepwoods Software V2";
            } else {
              $theme_name = $theme->Name;
            }
            echo "<h2>" . $theme_name . __( ' Theme Options', 'deepsoft' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'deepsoft' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'deepsoft3_options' ); ?>
			<?php $options = get_option( 'deepsoft3_theme_options' ); ?>
                        

			<table class="form-table">

				<?php
 				/**
				 * A deepsoft3 checkbox option
				 *  /
				?>
				<tr valign="top"><th scope="row"><?php _e( 'A checkbox', 'deepsoft' ); ?></th>
					<td>
						<input id="deepsoft3_theme_options[option1]" name="deepsoft3_theme_options[option1]" type="checkbox" value="1" <?php checked( '1', $options['option1'] ); ?> />
						<label class="description" for="deepsoft3_theme_options[option1]"><?php _e( 'deepsoft3 checkbox', 'deepsoft' ); ?></label>
					</td>
				</tr>
				*/ ?>
				<?php
				/**
				 * A deepsoft3 text input option
				 *  /
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Some text', 'deepsoft' ); ?></th>
					<td>
						<input id="deepsoft3_theme_options[sometext]" class="regular-text" type="text" name="deepsoft3_theme_options[sometext]" value="<?php echo esc_attr( $options['sometext'] ); ?>" />
						<label class="description" for="deepsoft3_theme_options[sometext]"><?php _e( 'deepsoft3 text input', 'deepsoft' ); ?></label>
					</td>
				</tr>
				*/ ?>
                                <?php
 				/**
				 * Enable Left Column?
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Enable Left Column?', 'deepsoft' ); ?></th>
					<td>
						<input id="deepsoft3_theme_options[enableleft]" name="deepsoft3_theme_options[enableleft]" type="checkbox" value="1" <?php checked( '1', $options['enableleft'] ); ?> />
						<label class="description" for="deepsoft3_theme_options[option1]"><?php _e( 'Enable left sidebar', 'deepsoft' ); ?></label>
					</td>
				</tr>
				<?php 
				/** 
				 * Google Adsense client ID
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Google Adsense Pub ID', 'deepsoft' ); ?></th>
					<td>
						<input id="deepsoft3_theme_options[google_ad_client]" class="regular-text" type="text" name="deepsoft3_theme_options[google_ad_client]" value="<?php echo esc_attr( $options['google_ad_client'] ); ?>" />
						<label class="description" for="deepsoft3_theme_options[google_ad_client]"><?php _e( 'Google Adsense Pub ID', 'deepsoft' ); ?></label>
					</td>
				</tr>
                                <?php
                                  deepwoods_rbs(__('Google Adsense code type:',
                                                   'deepsoft'),
                                                   array(__('Synchronous',
                                                            'deepsoft' ) 
                                                            => 's',
                                                            __('Asynchronous',
                                                               'deepsoft' ) 
                                                            => 'a'),
                                                'google_ad_type',
                                                $options['google_ad_type'],
                                                's');
				/**
				 * A deepsoft3 select input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Number of posts before an ad', 'deepsoft' ); ?></th>
					<td>
						<select name="deepsoft3_theme_options[postsperad]">
							<?php
								$selected = $options['postsperad'];
								$p = '';
								$r = '';

								foreach ( $ad_every_n_posts as $option ) {
									$label = $option['label'];
									if ( $selected == $option['value'] ) // Make default first in list
										$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
									else
										$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
								}
								echo $p . $r;
							?>
						</select>
						<label class="description" for="deepsoft3_theme_options[postsperad]"><?php _e( 'Number of posts before an ad', 'deepsoft' ); ?></label>
					</td>
				</tr>
				<?php
                                /**
				  * Navigation menu options
				  */
				deepwoods_yes_no_rbs(__('Header Menu','deepsoft'),'headermenu',$options['headermenu']);
				deepwoods_yes_no_rbs(__('Footer Menu','deepsoft'),'footermenu',$options['footermenu']);
				?>				
				<?php
				/**
				 * A deepsoft3 of radio buttons
				 *  /
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Radio buttons', 'deepsoft' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Radio buttons', 'deepsoft' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $radio_options as $option ) {
								$radio_setting = $options['radioinput'];

								if ( '' != $radio_setting ) {
									if ( $options['radioinput'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="deepsoft3_theme_options[radioinput]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				*/ ?>
				<?php
				/**
				 * headerContent option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Header Content', 'deepsoft' ); ?></th>
					<td>
						<textarea id="deepsoft3_theme_options[headerContent]" class="large-text" cols="50" rows="10" name="deepsoft3_theme_options[headerContent]"><?php echo esc_textarea( $options['headerContent'] ); ?></textarea>
						<label class="description" for="deepsoft3_theme_options[headerContent]"><?php _e( 'meta tags, javascriptlets, etc.', 'deepsoft' ); ?></label>
					</td>
				</tr>
				<?php
				/**
				 * footerContent option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Footer Content', 'deepsoft' ); ?></th>
					<td>
						<textarea id="deepsoft3_theme_options[footerContent]" class="large-text" cols="50" rows="10" name="deepsoft3_theme_options[footerContent]"><?php echo esc_textarea( $options['footerContent'] ); ?></textarea>
						<label class="description" for="deepsoft3_theme_options[footerContent]"><?php _e( 'meta tags, javascriptlets, etc.', 'deepsoft' ); ?></label>
					</td>
				</tr>
				<?php
				/**
				 * Custom CSS option
				 */
				?>   
				<tr valign="top"><th scope="row"><?php _e( 'Custom CSS', 'deepsoft' ); ?></th>
					<td>
						<textarea id="deepsoft3_theme_options[custom_styles]" class="large-text" cols="50" rows="10" name="deepsoft3_theme_options[custom_styles]"><?php echo esc_textarea( $options['custom_styles'] ); ?></textarea>
						<label class="description" for="deepsoft3_theme_options[custom_styles]"><?php _e( 'Custom CSS', 'deepsoft' ); ?></label>
					</td>
				</tr>
				<?php
				/**
				 * Bottom Wide Content
				 */
				?>   
				<tr valign="top"><th scope="row"><?php _e( 'Wide Bottom Content', 'deepsoft' ); ?></th>
					<td>
						<textarea id="deepsoft3_theme_options[bottomwidecontent]" class="large-text" cols="50" rows="10" name="deepsoft3_theme_options[bottomwidecontent]"><?php echo esc_textarea( $options['bottomwidecontent'] ); ?></textarea>
						<label class="description" for="deepsoft3_theme_options[bottomwidecontent]"><?php _e( 'Wide Bottom Content', 'deepsoft' ); ?></label>
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'deepsoft' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $ad_every_n_posts/*, $radio_options*/;

	if (!preg_match('/^(ca-)?pub-[0-9]+$/',$input['google_ad_client'])) {
	  unset($input['google_ad_client']);
	}
	//Our checkbox value is either 0 or 1
	if ( ! isset( $input['enableleft'] ) )
		$input['enableleft'] = null;
	$input['enableleft'] = ( $input['enableleft'] == 1 ? 1 : 0 );

	// Our checkbox value is either 0 or 1
	//if ( ! isset( $input['option1'] ) )
	//	$input['option1'] = null;
	//$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
	//
	// Say our text option must be safe text with no HTML tags
	//$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
	//
	//Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['postsperad'], $ad_every_n_posts ) )
		$input['postsperad'] = 0;
	
	// Our radio option must actually be in our array of radio options
	//if ( ! isset( $input['radioinput'] ) )
	//	$input['radioinput'] = null;
	//if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
	//	$input['radioinput'] = null;

	// Set default values for yes/no buttons.
	if ( ! isset( $input['headermenu'] ) ) $input['headermenu'] = 'yes';
	if ( ! isset( $input['footermenu'] ) ) $input['footermenu'] = 'yes';

	//
	// Say our textarea option must be safe text with the allowed tags for posts
	// $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
	$input['custom_styles'] = wp_filter_post_kses( $input['custom_styles'] );
        //$input['headerContent'] = wp_filter_post_kses( $input['headerContent'] );
        //$input['footerContent'] = wp_filter_post_kses( $input['footerContent'] );
        $input['bottomwidecontent'] = wp_filter_post_kses( $input['bottomwidecontent'] );
	return $input;
}

$options = get_option( 'deepsoft3_theme_options' );
if ( ! isset ($options['enableleft']) ) {$options['enableleft'] = 1;}
update_option( 'deepsoft3_theme_options', $options );

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
