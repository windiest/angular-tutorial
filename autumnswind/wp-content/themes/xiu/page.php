<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<h1 class="title"><strong><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></strong></h1>
		<p>&nbsp;</p>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>
		<p>&nbsp;</p>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>