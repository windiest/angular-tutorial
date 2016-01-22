<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php if ( !have_posts() ) : ?>
			<?php hui_404() ?>
		<?php else: ?>
			<h1 class="title"><strong><?php echo $s; ?> <?php echo __('的搜索结果', 'haoui') ?></strong></h1>
			<?php hui_post_excerpt() ?>
		<?php endif; ?>
	</div>
</div>
<?php 
if ( have_posts() ) {
	get_sidebar(); 
} 

get_footer();
?>