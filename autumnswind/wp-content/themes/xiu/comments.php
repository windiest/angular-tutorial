<?php
defined('ABSPATH') or die('This file can not be loaded directly.');

global $comment_ids; $comment_ids = array();
// global $loguser;
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} 

if ( !comments_open() ) return;

date_default_timezone_set(PRC);
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>
<h3 class="title" id="comments">
	<div class="text-muted pull-right">
	<?php if( is_user_logged_in() ){ ?>
		<a href="<?php echo wp_logout_url() ?>"><span class="glyphicon glyphicon-user"></span> <?php echo __('退出', 'haoui') ?></a>
	<?php }else{
		if ( !empty($comment_author) ) echo '<a href="javascript:;" data-event="comment-user-change"><span class="glyphicon glyphicon-user"></span> '.__('更换用户', 'haoui').'</a>';
	} 
	?>
	</div>
	<strong><?php echo _hui('comment_title') ?> <?php echo hui_get_comment_number(' ',' ') ? '<b>'.hui_get_comment_number(' ',' ').'</b>':'<small>'.__('抢沙发', 'haoui').'</small>'; ?></strong>
</h3>
<div id="respond" class="no_webshot">
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>
	<div class="comment-signarea">
		<h3 class="text-muted"><?php echo __('评论前必须登录！', 'haoui') ?></h3>
	</div>
	<?php }elseif( get_option('close_comments_for_old_posts') && $closeTimer > get_option('close_comments_days_old') ) { ?>
	<h3 class="title">
		<strong><?php echo __('文章评论已关闭！', 'haoui') ?></strong>
	</h3>
	<?php }else{ ?>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		
		<div class="comt-title">
			<div class="comt-avatar">
				<?php 
					global $current_user;
					get_currentuserinfo();
					if ( is_user_logged_in() ) 
						echo hui_get_avatar($user_id=get_current_user_id(), $user_email=$current_user->user_email);
					elseif( !is_user_logged_in() && get_option('require_name_email') && $comment_author_email=='' ) 
						echo hui_get_avatar($user_id='', $user_email=$current_user->user_email);
					elseif( !is_user_logged_in() && get_option('require_name_email') && $comment_author_email!=='' )  
						echo hui_get_avatar($user_id='', $user_email=$comment->comment_author_email);
					else
						echo hui_get_avatar($user_id='', $user_email=$comment->comment_author_email);
				?>
			</div>
			<div class="comt-author">
			<?php 
				if ( is_user_logged_in() ) {
					printf($user_identity);
				}else{
					if( get_option('require_name_email') && !empty($comment_author_email) ){
						printf($comment_author.' <span>'.__('发表我的评论', 'haoui').'</span> &nbsp; <a class="switch-author" href="javascript:;" data-type="switch-author" style="font-size:12px;">'.__('换个身份', 'haoui').'</a>');
					}else{
						printf('');
					}
				}
			?>
			</div>
			<a id="cancel-comment-reply-link" href="javascript:;"><?php echo __('取消', 'haoui') ?></a>
		</div>
		
		<div class="comt">
			<div class="comt-box">
				<textarea placeholder="<?php echo _hui('comment_text') ?>" class="input-block-level comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
				<div class="comt-ctrl">
					<div class="comt-tips"><?php comment_id_fields(); do_action('comment_form', $post->ID); ?></div>
					<button type="submit" name="submit" id="submit" tabindex="5"><i class="icon-ok-circle icon-white icon12"></i> <?php echo _hui('comment_submit_text') ?></button>
					<!-- <span data-type="comment-insert-smilie" class="muted comt-smilie"><i class="icon-thumbs-up icon12"></i> 表情</span> -->
				</div>
			</div>

			<?php if ( !is_user_logged_in() ) { ?>
				<?php if( get_option('require_name_email') ){ ?>
					<div class="comt-comterinfo" id="comment-author-info" <?php if ( !empty($comment_author) ) echo 'style="display:none"'; ?>>
						<ul>
							<li class="form-inline"><label class="hide" for="author"><?php echo __('昵称', 'haoui') ?></label><input class="ipt" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" placeholder="<?php echo __('昵称', 'haoui') ?>"><span class="text-muted"><?php echo __('昵称', 'haoui') ?> (<?php echo __('必填', 'haoui') ?>)</span></li>
							<li class="form-inline"><label class="hide" for="email"><?php echo __('邮箱', 'haoui') ?></label><input class="ipt" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" placeholder="<?php echo __('邮箱', 'haoui') ?>"><span class="text-muted"><?php echo __('邮箱', 'haoui') ?> (<?php echo __('必填', 'haoui') ?>)</span></li>
							<li class="form-inline"><label class="hide" for="url"><?php echo __('网址', 'haoui') ?></label><input class="ipt" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="4" placeholder="<?php echo __('网址', 'haoui') ?>"><span class="text-muted"><?php echo __('网址', 'haoui') ?></span></li>
						</ul>
					</div>
				<?php } ?>
			<?php } ?>
		</div>

	</form>
	<?php } ?>
</div>
<?php  

if ( have_comments() ) { 
?>
<div id="postcomments">
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=hui_comment_list') ?>
	</ol>
	<div class="pagenav">
		<?php paginate_comments_links('prev_next=0');?>
	</div>
</div>
<?php 
} 
?>