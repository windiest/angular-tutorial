<?php
get_header();
global $wp_query;
$curauth = $wp_query->get_queried_object();
?>
<div class="content-wrap">
	<div class="content">
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>'.__('页', 'haoui').' '.$paged.'</small>';
		}
		echo '<h1 class="title"><strong>'.$curauth->display_name.__('的文章', 'haoui').'</strong>'.$pagedtext.'</h1>';
		
		hui_post_excerpt() 
		?>
	</div>
</div>

<?php get_sidebar(); get_footer(); ?>