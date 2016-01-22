<?php 
/*
 * Template Name: Reader Wall Page
 * By daqianduan.com
*/
get_header();
function readers_wall( $outer='1', $timer='100', $limit='200' ){
	global $wpdb;
	$items = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($items as $item) {
		$c_url = $item->comment_author_url;
		if (!$c_url) $c_url = 'javascript:;';
		$type .= '<a target="_blank" href="'. $c_url . '" title="'.$item->comment_author.' 评论'. $item->cnt . '次">'.hui_get_avatar($user_id=$item->user_id, $user_email=$item->comment_author_email).'</a>';
	}
	echo $type;
};
?>
<div class="content-wrap">
    <div class="content page-readerwall">
        <h1 class="title"><strong><?php echo get_the_title() ?></strong></h1>
		<?php while (have_posts()) : the_post(); ?>
			<article class="article-content">
				<?php the_content(); ?>
			</article>
			<div class="readers">
				<?php readers_wall( $outer='1', $timer=_hui('readwall_limit_time'), $limit=_hui('readwall_limit_number') ); ?>
			</div>
		<?php comments_template('', true); endwhile;  ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>