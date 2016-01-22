<?php 
/*
 * Template Name: Tags Page
 * By daqianduan.com
*/
get_header();
?>
<div class="content-wrap">
    <div class="content page-tags no-sidebar">
        <h1 class="title"><strong><?php echo get_the_title() ?></strong></h1>
		<ul class="tagslist">
			<?php $tags_list = get_tags('orderby=count&order=DESC');
			if ($tags_list) { 
				foreach($tags_list as $tag) {
					echo '<li><a class="tagname" href="'.get_tag_link($tag).'">'. $tag->name .'</a><strong>x '. $tag->count .'</strong><br>'; 
					$posts = get_posts( "tag_id=". $tag->term_id ."&numberposts=1" );
					if( $posts ){
						foreach( $posts as $post ) {
							setup_postdata( $post );
							echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br><span class="muted">'.get_the_time('Y-m-d').'</span class="muted">';
						}
					}
					echo '</li>';
				} 
			} 
			?>
		</ul>
	</div>
</div>
<?php get_footer(); ?>