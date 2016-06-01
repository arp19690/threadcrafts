<?php
/**
 * The template for displaying Search Results pages.
 *
 */
get_header(); ?>
<div class="mainblogwrapper">
    <div class="container">
        <div class="row">
        
            <div class="mainblogcontent">
            <div class="col-md-12  col-sm-12 ">
        <ol class="breadcrumb ">
          <?php ariwoo_breadcrumbs(); ?>
        </ol>
      </div>
             <div class="col-md-9">
            
            
          <h1><?php printf( __( 'Search Results for: %s', 'ariwoo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        
        <?php if (have_posts() ) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <div class="article-page">
                                
                                 <?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { ?>
             <?php
 	             the_post_thumbnail();
             ?>
 	                <?php }  ?>
                                
                                
                                
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
          <!--end / post-content--> 
          
       <div class="clearfix"></div>
                    <!-- *** Post1 Starts Ends *** -->
                    <!-- *** Post loop ends*** -->
                    <div class="clearfix"></div>
        <?php endwhile; 
	  else:
			echo'<h2>'._e( 'No Results Found', 'ariwoo' ).'</h2>';
	  ?>
        <?php endif; ?>
        
        <!--end / article--> 
         <nav id="nav-single"> <span class="nav-previous">
                            <?php next_posts_link(); ?>
                        </span> <span class="nav-next">
<?php previous_posts_link(); ?>
                        </span> </nav>
      </div>
      
      <!--end / main-->
      
     <div class="col-md-3">
        <?php get_sidebar(); ?>
     </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
