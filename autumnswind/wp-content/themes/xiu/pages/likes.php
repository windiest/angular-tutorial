<?php 
/*
 * Template Name: Likes Page
 * By daqianduan.com
*/
get_header();
?>
<div class="content-wrap">
	<div class="content page-likes no-sidebar">
		<h1 class="title"><strong><?php echo get_the_title() ?></strong></h1>
		<ul class="likepage">
		<?php 
			$args = array(
			    'caller_get_posts' => 1,
			    'meta_key' => 'like',
			    'orderby' => 'meta_value_num',
			    'showposts' => 40
			);
			query_posts($args);

			while ( have_posts() ) : the_post(); 
		    $count = hui_post_images_number();
		    $like = get_post_meta( get_the_ID(), 'like', true );
		        echo '<li><a href="'.get_permalink().'">'.hui_get_thumbnail().'<h2>'.get_the_title().'</h2></a>',
		        	hui_get_post_like($class='post-like'),
		        	'<span class="img-count"><span class="glyphicon glyphicon-picture"></span>'.$count.'</span>',
		        '</li>';
		    endwhile; 
		    wp_reset_query();
		?>
		</ul>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_footer(); ?>