<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>'.__('页', 'haoui').' '.$paged.'</small>';
		}
		echo '<h1 class="title"><strong><a href="'.get_category_link( get_cat_ID( single_cat_title('',false) ) ).'">', single_cat_title(), '</a></strong>'.$pagedtext.'</h1>';

		hui_post_excerpt() 
		?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>