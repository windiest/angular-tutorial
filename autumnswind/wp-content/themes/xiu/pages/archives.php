<?php
/**
 * Template Name: Archives Page
 * By daqianduan.com
 */
get_header(); ?>
<div class="content-wrap">
    <div class="content page-archives">
        <h1 class="title"><strong><?php echo get_the_title() ?></strong></h1>
        <article class="archives">
            <?php
            $previous_year = $year = 0;
            $previous_month = $month = 0;
            $ul_open = false;
             
            $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
            
            foreach($myposts as $post) :
                setup_postdata($post);
             
                $year = mysql2date('Y', $post->post_date);
                $month = mysql2date('n', $post->post_date);
                $day = mysql2date('j', $post->post_date);
                
                if($year != $previous_year || $month != $previous_month) :
                    if($ul_open == true) : 
                        echo '</ul></div>';
                    endif;
             
                    echo '<div class="item"><h3>'; echo the_time('Y-m'); echo '</h3>';
                    echo '<ul class="archives-list">';
                    $ul_open = true;
             
                endif;
                $previous_year = $year; $previous_month = $month;
            ?>
                <li>
                    <time><?php the_time('d'); ?>日</time>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
                    <span class="text-muted"><?php echo hui_get_comment_number() ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        </article>
    </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>