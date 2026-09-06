<?php
/**
 * Theme Comment Functions
 *
 * Holds functions and filters for displaying comments
 *
 * @package      Deepsoft V2
 * @author       Robert Heller <heller@deepsoft.com> (code lifted from Techozoic Fluid by Jeremy Clark <jeremy@clark-technet.com>)
 */

/**
 * Deepsoft V2 comment callback
 * 
 * Callback for displaying comments
 * 
 * @param   object  $comment  comment object from callback
 * @param   array   $args   args from callback
 * @param   string  $depth  comment nesting depth from callback.
 * 
 * @access    private
 */
function deepsoft_comment( $comment, $args, $depth ) {
    //file_put_contents("php://stderr","*** deepsoft_comment(".print_r($comment,true).",".print_r($args,true)."','". $depth."')\n");
    $GLOBALS['comment'] = $comment;
    global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <?php if ( $comment->comment_type == '' ) { ?>
                <div class="avatar_cont"><?php echo get_avatar( $comment, '50' ); ?></div>
            <?php }
            if ( $comment->comment_type == '' ) {
                printf( __( 'Comment by %s', 'deepsoft' ), '<em>' . get_comment_author_link() . '</em>' );
            } else {
                printf( __( 'Ping from %s', 'deepsoft' ), '<em>' . get_comment_author_link() . '</em>' );
            }
            ?>:
            <?php if ( $comment->comment_approved == '0' ) { ?>				
                <em><?php _e( 'Your comment is awaiting moderation.', 'deepsoft' ) ?></em>
            <?php } ?>
            <br />
            <small class="commentmetadata">
                <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date( 'l, F jS Y' ) ?> at <?php comment_time() ?></a>&nbsp;|&nbsp;<?php
        edit_comment_link( __( 'Edit', 'deepsoft' ), '', '' );
            ?>
            </small>
            <?php comment_text(); ?>
            <div class="reply">
                <?php echo comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
            </div>
        </div>
        <?php
    }


  
