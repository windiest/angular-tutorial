<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<ul class="article-meta">
				<?php $author = get_the_author();
    if( _hui('author_link') ){
        $author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.$author.'</a>';
    } ?>
				<li><?php echo $author ?> <?php echo __('发布于', 'haoui') ?> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></li>
				<li><?php echo __('分类：', 'haoui');the_category(' / '); ?></li>
				<?php echo hui_get_post_from() ? '<li>'.hui_get_post_from().'</li>' : '' ?>
				<li><?php echo hui_get_views() ?></li>
				<li><?php echo hui_get_comment_number() ?></li>
				<li><?php edit_post_link('['.__('编辑', 'haoui').']'); ?></li>
			</ul>
		</header>
		<?php if( _hui('ads_post_01_s') ) echo '<div class="ads ads-content ads-post">'._hui('ads_post_01').'</div>'; ?>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
		<?php endwhile;  ?>
		<div class="article-social">
			<?php echo hui_get_post_like($class='action action-like'); ?>
		</div>
		<div class="action-share bdsharebuttonbox">
			<?php echo __('分享到：', 'haoui') ?><a class="bds_qzone" data-cmd="qzone"></a><a class="bds_tsina" data-cmd="tsina"></a><a class="bds_weixin" data-cmd="weixin"></a><a class="bds_tqq" data-cmd="tqq"></a><a class="bds_sqq" data-cmd="sqq"></a><a class="bds_tpf" data-cmd="tpf"></a><a class="bds_renren" data-cmd="renren"></a><a class="bds_qq" data-cmd="qq"></a><a class="bds_diandian" data-cmd="diandian"></a><a class="bds_youdao" data-cmd="youdao"></a><a class="bds_ty" data-cmd="ty"></a><a class="bds_fbook" data-cmd="fbook"></a><a class="bds_twi" data-cmd="twi"></a>
			<a class="bds_more" data-cmd="more"><?php echo __('更多', 'haoui') ?></a>
			<a class="bds_count" data-cmd="count"></a>
		</div>
		<div class="article-tags">
			<?php the_tags(__('标签：', 'haoui'),'',''); ?>
		</div>
		<nav class="article-nav">
			<span class="article-nav-prev"><?php previous_post_link(__('上一篇', 'haoui').'<br>%link'); ?></span>
			<span class="article-nav-next"><?php next_post_link(__('下一篇', 'haoui').'<br>%link'); ?></span>
		</nav>
		<?php if( _hui('ads_post_02_s') ) echo '<div class="ads ads-content ads-related">'._hui('ads_post_02').'</div>'; ?>
		<?php hui_posts_related( _hui('related_title'), _hui('post_related_n') ) ?>
		<?php if( _hui('sticky_post_s') ) hui_posts_sticky( $title=_hui('sticky_title'), $showposts=_hui('sticky_limit') ) ?>
		<?php if( _hui('ads_post_03_s') ) echo '<div class="ads ads-content ads-comment">'._hui('ads_post_03').'</div>'; ?>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>