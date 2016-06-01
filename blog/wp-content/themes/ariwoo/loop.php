<!-- *** Post1 Starts *** -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="article-page">
               <?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { ?>
             <?php
 	             the_post_thumbnail();
             ?>
 	                <?php } else { ?>
                     <?php
 	                     the_post_thumbnail();
 	                    ?> 
 	                    <?php
 	                }
 	                ?>
                <h1 class="article-page-head"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <ul class="meta">
                    <li><i class="fa fa-clock-o blogin-color"></i> <?php
                        $archive_year = get_the_time('Y');
                        $archive_month = get_the_time('m');
                        $archive_day = get_the_time('d');
                        ?>
                        <a href="<?php
                        echo get_day_link($archive_year,
                                $archive_month,
                                $archive_day);
                        ?>"><?php echo get_the_time('m, d, Y') ?></a></li>
                    <li><i class="fa fa-user blogin-color"></i>&nbsp;<?php the_author_posts_link(); ?></li>
                    <li><i class="fa fa-folder-open blogin-color"></i>&nbsp;<?php the_category(', '); ?></li>
                    <li class="comments"><i class="fa fa-comment blogin-color"></i> <?php comments_popup_link( __( 'No Comments.', 'ariwoo' ),
                                 __( 'Comment: 1', 'ariwoo' ),
                                __( 'Comments: %', 'ariwoo' )); ?></li>
                </ul>
        <?php the_excerpt(); ?>
                 
            </div>
        </div>
        <?php
    endwhile;
else:
    ?>
    <div>
        <p>
    <?php _e('Sorry no post matched your criteria',
            'ariwoo'); ?>
        </p>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
<!-- *** Post1 Starts Ends *** -->