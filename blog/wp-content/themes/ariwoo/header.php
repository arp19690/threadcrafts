<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <?php
 if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
endif;
 
 ?>
 
 
<link rel="profile" href="<?php echo esc_url( 'http://gmpg.org/xfn/11' ); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

 

 
 
   <?php wp_head(); ?> 
   
</head>
<body <?php body_class(); ?> id="pageBody">


<!--++++++++++++++ Main Menu Start +++++++++++++++++++++++++-->
<div id="mainheader1">
    <div class="container">

        <div class="divPanel topArea notop nobottom" >
            <div class="row">
                <div class="col-md-12">

                   <div id="divLogo" class="pull-left">
                       <?php if(get_theme_mod('ariwoo_logo')): ?> 
			   <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> <?php echo '<img src="'.esc_url( get_theme_mod( 'ariwoo_logo' ) ).'">'; ?> </a>
			   <?php  else:  ?>  
			      <a  id="divSiteTitle" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <?php echo bloginfo('name');?> </a> <br> <a href="" class="desnav" id="divTagLine"> <?php echo bloginfo('description'); ?></a> 
               
                <?php endif; ?> 
                    </div>

                    <div id="divMenuRight" class="pull-right">
                    <div class="navbar">
                        <button type="button" class="btn btn-navbar-highlight btn-large btn-primary" data-toggle="collapse" data-target=".nav-collapse">
                            <?php _e( 'NAVIGATION', 'ariwoo' ); ?> <span class="icon-chevron-down icon-white"></span>
                        </button>
                        <div id="abby" class="nav-collapse navbar-collapse single-page-nav collapse">
                        
                         
                        
                        <?php 
			$defaults = array(
					'theme_location'  => 'primary',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul id="nav" class="nav nav-pills ddmenu">%3$s</ul>',
					'depth'           => 0,
					'walker'          => ''
					);
			wp_nav_menu($defaults); ?>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                           
                               
                             
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!--++++++++++++++ Main Menu End +++++++++++++++++++++++++-->