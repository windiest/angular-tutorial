<?php
if (!function_exists('duoshuo_comment')){ 
	function duoshuo_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'duoshuo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'duoshuo' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
		//	end_el函数会自己输出一个</li>
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<cite class="comment-author vcard">
						<?php
							/* translators: 1: comment author, 2: date and time */
							printf( __( '%1$s on %2$s <span class="says">said:</span>', 'duoshuo' ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf( '<a rel="nofollow" href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( __( '%1$s at %2$s', 'duoshuo' ), get_comment_date(), get_comment_time() )
								)
							);
						?>
					</cite><!-- .comment-author .vcard -->
				</footer>
	
				<div class="comment-content"><?php comment_text(); ?></div>
				
			</article><!-- #comment-## -->
		<?php
		//	end_el函数会自己输出一个</li>
				break;
		endswitch;
	}
}
?>
	<div id="ds-ssr">

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'duoshuo' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'duoshuo' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'duoshuo' ) ); ?></div>
		</nav>
		<?php endif;?>

            <ol id="commentlist">
                <?php
                    /* Loop through and list the comments. Tell wp_list_comments()
                     * to use Duoshuo::comment() to format the comments.
                     */
                    wp_list_comments(array('callback' => 'duoshuo_comment'));
                ?>
            </ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'duoshuo' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'duoshuo' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'duoshuo' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
            
    </div>