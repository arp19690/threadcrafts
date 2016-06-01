<?php
/*
	Template Name: Front Page
	Design Theme's Front Page to Display the Home Page if Selected
	
*/
get_header(); ?>


<span id="section_one"></span>
<!--++++++++++++++ Slider Section Start +++++++++++++++++++++++++-->
 <?php  	
	  
	
		$list_featureboxes = array(
			'one' 		=> 'active',
			'two'			=> '',
			 
		);
?>

<div id="carouselSection" class="cntr"> 
		<div id="myCarousel" class="carousel slide">
		
			<div class="carousel-inner">
            
            <?php foreach($list_featureboxes as $key => $value){ ?>
            
            
            
            
            
      <div class="item <?php echo($value); ?>" style="background-image:url('<?php if(get_theme_mod('ariwoo_header_slider-'.$key.'-file-upload')): echo esc_url( get_theme_mod( 'ariwoo_header_slider-'.$key.'-file-upload' ) ); else: echo get_template_directory_uri(); echo '/images/slide1.jpg'; endif;?>');">
					<div class="carousel-caption-text">
<div class="container">


 
<div class="slide_h1_wrap"><h1 class="headline"><?php if(get_theme_mod('ariwoo_header_slider_'.$key.'_url')): echo esc_html( get_theme_mod( 'ariwoo_header_slider_'.$key.'_url' ) ); else: echo __('Stylish Page Theme', 'ariwoo');  endif;?></h1></div>
 

 
<div class="slide_h3_wrap"><h3 class="sub-headline"><?php if(get_theme_mod('ariwoo_header_slider_'.$key.'_subtitle')): echo esc_html( get_theme_mod( 'ariwoo_header_slider_'.$key.'_subtitle' ) ); else: echo __('Voluptate Velit Esse - Get Started Today!', 'ariwoo');  endif;?></h3></div>
 


 
<div class="descriptions"><p><?php if(get_theme_mod('ariwoo_featured_textbox_header_slider_'.$key)): echo esc_html( get_theme_mod( 'ariwoo_featured_textbox_header_slider_'.$key ) ); else: echo __('Erat dolor purus turpis hymenaeos vel luctus integer consectetuer porttitor ut.', 'ariwoo');  endif;?></p>
 
</div>
</div>
</div>
				</div>      
            
            
            
            
            
            
     
            
            
            
            
            
            <?php } ?>
            
				
				
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
				 
                
                
</div>
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
</div>




<span id="section_two"></span>

<div id="contentOuterSeparator"></div>

<div class="container" >

    <div class="divPanel page-content" >
    
    
    
    
    
    
    
   <!--++++++++++++++ Service Section Start +++++++++++++++++++++++++--> 
    
    
  <?php  	
	  
	
		$list_featureboxes2 = array(
			'one' 		=> __('Icon 1', 'ariwoo'),
			'two'		=> __( 'Icon 2', 'ariwoo' ),
		'three'		=> __( 'Icon 3', 'ariwoo' ),
			 
		);
?>   
    

        <div class="row">
 
 <div class="col-md-12" >           <div class="lead">
 
 
                       <h2> <?php if(get_theme_mod('ariwoo_maiN_heading')): echo esc_attr( get_theme_mod( 'ariwoo_maiN_heading' ) ); else: echo __('Our Services', 'ariwoo');  endif;?> </h2> 
                       <p class="saperator"><img src="<?php echo get_template_directory_uri(); ?>/images/divider-02.jpg"></p>
                    </div> </div> </div> 
 
 <div class="row">
 
  <?php foreach($list_featureboxes2 as $key => $value){ ?>
 
 
 
 
 
<div class="col-md-4 ">
<div class="menu12"  ><div><i class="fa <?php if(get_theme_mod('ariwoo_header_servicesicon_'.$key.'_url')): echo esc_html( get_theme_mod( 'ariwoo_header_servicesicon_'.$key.'_url' ) ); else: echo "fa-desktop";  endif;?> main-color"  ></i></div></div>
                    
                    <h3 style="text-align:center;"><?php if(get_theme_mod('ariwoo_header_services_'.$key.'_url')): echo esc_html( get_theme_mod( 'ariwoo_header_services_'.$key.'_url' ) ); else: echo __('Web Development', 'ariwoo');  endif;?></h3>
                    <p style="text-align:center;" ><?php if(get_theme_mod('ariwoo_featured_textbox_header_services_'.$key)): echo esc_html( get_theme_mod( 'ariwoo_featured_textbox_header_services_'.$key ) ); else: echo __('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum.', 'ariwoo');  endif;?>
                       
                    </p>

                </div>
                
                
     <?php } ?>            
                
                
                
                
                
 
                 
                
    <div class="col-md-12" >          <hr style="margin:45px 0 35px">  </div> </div> 
    
    
    <!--++++++++++++++ Service Section End +++++++++++++++++++++++++-->
    
    
    
    
    
 



 





</div></div>

 
 


 

</div>

<div class="container">
<p id="back-top" style="display: block;">
		<a href="#top"><span><i class="fa fa-arrow-up main-arrow"></i> </span></a>
</p>
</div>


 
   

 
<?php get_footer(); ?>
