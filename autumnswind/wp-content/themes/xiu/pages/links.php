<?php 
/*
 * Template Name: Links Page
 * By daqianduan.com
*/
get_header();
?>
<div class="content-wrap">
    <div class="content page-links">
        <h1 class="title"><strong><?php echo get_the_title() ?></strong></h1>
		<?php while (have_posts()) : the_post(); ?>
			<article class="article-content">
				<?php the_content(); ?>
			</article>

			<ul class="plinks">
				<?php wp_list_bookmarks(); ?>
			</ul>

			<?php comments_template('', true); ?>

		<?php endwhile;  ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>