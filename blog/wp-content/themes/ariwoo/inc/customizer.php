<?php
/**
 * Ariwoo Theme Customizer
 *
 * @package Ariwoo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
 function ariwoo_textarea_register($wp_customize){
	class ariwoo_Customize_ariwoo_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
        
      
        <h1><?php _e( 'Get Ariwoo PRO Theme!  Just $19', 'ariwoo' ); ?></h1>
		<div class="theme-info"> 
			<a title="<?php esc_attr_e( 'Upgrade to Ariwoo PRO Theme', 'ariwoo' ); ?>" href="<?php echo esc_url( 'http://arinio.com/ariwoo-responsive-multipurpose-wordpress-theme/' ); ?>" target="_blank">
			<?php _e( 'Upgrade to Ariwoo PRO Theme', 'ariwoo' ); ?>
			</a>
			<a title="<?php esc_attr_e( 'View More our themes', 'ariwoo' ); ?>" href="<?php echo esc_url( 'http://arinio.com/' ); ?>" target="_blank">
			<?php _e( 'View More our themes', 'ariwoo' ); ?>
			</a>
			 
			<a href="<?php echo esc_url( 'http://arinio.com/support/' ); ?>" title="<?php esc_attr_e( 'Free Support', 'ariwoo' ); ?>" target="_blank">
			<?php _e( 'Free Support', 'ariwoo' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://arinio.com/ariwoo-responsive-multipurpose-wordpress-theme/' ); ?>" title="<?php esc_attr_e( 'View Demo', 'ariwoo' ); ?>" target="_blank">
			<?php _e( 'View Demo', 'ariwoo' ); ?>
			</a>
           <a href="<?php echo esc_url( 'http://arinio.com/get-free-our-theme/' ); ?>" title="<?php esc_attr_e( 'Get Free Pro Version', 'ariwoo' ); ?>" target="_blank">
			<?php _e( 'Get Free Pro Version', 'ariwoo' ); ?>
			</a>
		</div>
		<?php
		}
	}
 
}



add_action('customize_register', 'ariwoo_textarea_register');
 
 
 
function ariwoo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	 
	 
	 
	 
	 $wp_customize->add_section('ariwoo_upgrade', array(
		'title'					=> __('Ariwoo Support', 'ariwoo'),
		'description'			=> __('You are using the Ariwoo, Free Version of Ariwoo Pro Theme. Upgrade to Pro for extra features like Home Page Unlimited Slider, Work ,Gallery, Team section, Client Section ,Social Link Section and  Life time theme support and much more. ','ariwoo'),
		'priority'				=> 1,
	));
	$wp_customize->add_setting( 'ariwoo_theme_settings[ariwoo_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new ariwoo_Customize_ariwoo_upgrade(
		$wp_customize,
		'ariwoo_upgrade',
			array(
				'label'					=> __('Ariwoo Upgrade','ariwoo'),
				'section'				=> 'ariwoo_upgrade',
				'settings'				=> 'ariwoo_theme_settings[ariwoo_upgrade]',
			)
		)
	);
	
}
add_action( 'customize_register', 'ariwoo_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since ariwoo 1.0
 */
function ariwoo_customize_preview_js() {
	wp_enqueue_script( 'ariwoo_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), rand(),  true );
}
add_action( 'customize_preview_init', 'ariwoo_customize_preview_js' );
 
 
 
/**
 * Implement the Custom Logo feature
 */
function ariwoo_theme_customizer( $wp_customize ) {
   
   $wp_customize->add_section( 'ariwoo_logo_section' , array(
    'title'       => __( 'Basic Setting', 'ariwoo' ),
    'description' => __( 'This Is a Basic Setting Section For Frontpage', 'ariwoo' ),
) );
   $wp_customize->add_setting( 'ariwoo_logo', array(
        'sanitize_callback' => 'ariwoo_sanitize_upload',
   ) );
   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ariwoo_logo', array(
    'label'    => __( 'Site Logo', 'ariwoo' ),
    'section'  => 'ariwoo_logo_section',
    'settings' => 'ariwoo_logo',
	)));
	
	
	
	 $wp_customize->add_setting( 'ariwoo_logo2', array(
        'sanitize_callback' => 'ariwoo_sanitize_upload',
   ) );
   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ariwoo_logo2', array(
    'label'    => __( 'Favicon', 'ariwoo' ),
    'section'  => 'ariwoo_logo_section',
    'settings' => 'ariwoo_logo2',
	)));
	
	
	 
	$wp_customize->add_setting(
	    'ariwoo_copyright_text', array(
		    'default' => __( 'Copyright', 'ariwoo' ),
			'transport' => 'postMessage',
		    'sanitize_callback' => 'ariwoo_sanitize_text',
	    )
	);
	
	$wp_customize->add_control(
		'ariwoo_copyright_text', array(
			'label'    => __( 'Copyright Text', 'ariwoo' ),
			'section' => 'ariwoo_logo_section',
			'type' => 'text',
		)
	);
	
		$wp_customize->add_setting(
	    'ariwoo_custom_css', array(
		    'default' => __( '', 'ariwoo' ),
			'capability' => 'edit_theme_options', 
		    'sanitize_callback' => 'wp_filter_nohtml_kses',
	    )
	);
	
	$wp_customize->add_control(
		'ariwoo_custom_css', array(
			'label'    => __( 'Custom CSS', 'ariwoo' ),
			'section' => 'ariwoo_logo_section',
			'type' => 'textarea',
		)
	);
	
	
}
add_action('customize_register', 'ariwoo_theme_customizer');
 
 
 
/* 
 * USE TO divide a section in to smaller sections
 */
function ariwoo_add_customizer_custom_controls( $wp_customize ) {
	//  Add Custom Subtitle
	//  =============================================================================
	class ariwoo_sub_title extends WP_Customize_Control {
		public $type = 'sub-title';
		public function render_content() {
		?>
			<h2 class="ariwoo-custom-sub-title"><?php echo esc_html( $this->label ); ?></h2>
		<?php
		}
	}
	//  Add Custom Description
	//  =============================================================================
	class ariwoo_description extends WP_Customize_Control {
		public $type = 'description';
		public function render_content() {
		?>
			<p class="ariwoo-custom-description"><?php echo esc_html( $this->label ); ?></p>
		<?php
		}
	}
	
	class ariwoo_footer extends WP_Customize_Control {
		public $type = 'footer';
		public function render_content() {
		?>
			<hr />
		<?php
		}
	}
}
add_action( 'customize_register', 'ariwoo_add_customizer_custom_controls' );




 








function ariwoo_slider_text_boxes_options( $wp_customize ){
	
	$list_feature_modules = array( // 1
		'one'		=> __( 'Slider 1', 'ariwoo' ),
		'two'		=> __( 'Slider 2', 'ariwoo' ),
		 
	);
	$wp_customize->add_section( 'ariwoo_customizer_slider_text_boxes', array(
		'title'    => __( 'Slider Setting', 'ariwoo' ),
		'description'    => __( 'You can upload here images for slider', 'ariwoo' ),
		
	));
	$i_priority = 1;
	
	foreach ($list_feature_modules as $key => $value) {
	
		/* Add sub title */
		$wp_customize->add_setting( 'ariwoo_slider_' . $key . '_sub_title', array(
            'sanitize_callback' => 'ariwoo_sanitize_text',
        ));
		$wp_customize->add_control( 
			new ariwoo_sub_title( $wp_customize, 'ariwoo_slider_' . $key . '_sub_title', array(
					'label'		=> $value,
					'section'   => 'ariwoo_customizer_slider_text_boxes',
					'settings'  => 'ariwoo_slider_' . $key . '_sub_title',
					'priority' 	=> $i_priority++ 
				) 
			) 
		);
		/* File Upload */
		$wp_customize->add_setting( 'ariwoo_header_slider-'.$key.'-file-upload', array(
            'sanitize_callback' => 'ariwoo_sanitize_upload',
        ) );
		$wp_customize->add_control(
		    new WP_Customize_Upload_Control($wp_customize, 'ariwoo_header_slider-'.$key.'-file-upload', array(
		            'label' => __( 'File Upload', 'ariwoo' ),
		            'section' => 'ariwoo_customizer_slider_text_boxes',
		            'settings' => 'ariwoo_header_slider-'.$key.'-file-upload',
		            'priority' => $i_priority++
		        )
		    )
		);
		
		/* URL */
		$wp_customize->add_setting( 'ariwoo_header_slider_'.$key.'_url', array(
		        'default' => __( 'Title', 'ariwoo' ),
				'sanitize_callback' => 'ariwoo_sanitize_text',
			) 
		);
		$wp_customize->add_control('ariwoo_header_slider_'.$key.'_url', array(
				'label'    => __( 'Slider Title', 'ariwoo' ),
				'section' => 'ariwoo_customizer_slider_text_boxes',
				'settings' => 'ariwoo_header_slider_'.$key.'_url',
				'type' => 'text',
				'priority' => $i_priority++
			)
		);
		
		
		/* URL */
		$wp_customize->add_setting( 'ariwoo_header_slider_'.$key.'_subtitle', array(
		        'default' => __( 'Sub Title', 'ariwoo' ),
				'sanitize_callback' => 'ariwoo_sanitize_text',
			) 
		);
		$wp_customize->add_control('ariwoo_header_slider_'.$key.'_subtitle', array(
				'label'    => __( 'Slider Sub Title', 'ariwoo' ),
				'section' => 'ariwoo_customizer_slider_text_boxes',
				'settings' => 'ariwoo_header_slider_'.$key.'_subtitle',
				'type' => 'text',
				'priority' => $i_priority++
			)
		);
		
		
		
		
		
		
		
		
		
		
	
		/* Featured Header Text */
		$wp_customize->add_setting('ariwoo_featured_textbox_header_slider_'.$key, array(
		        'default' => __( 'Description', 'ariwoo' ),
				'transport' => 'postMessage',
				'sanitize_callback' => 'ariwoo_sanitize_text',
		    )
		);
		$wp_customize->add_control('ariwoo_featured_textbox_header_slider_'.$key, array(
				'label' => __( 'Slider Description', 'ariwoo' ),
				'section' => 'ariwoo_customizer_slider_text_boxes',
				'settings' => 'ariwoo_featured_textbox_header_slider_'.$key,
				'type' => 'textarea',
				'priority' => $i_priority++
			)
		);
		
		 
		/* Add footer bar */
		$wp_customize->add_setting( 'ariwoo_slider_' . $key . '_footer', array(
            'sanitize_callback' => 'ariwoo_sanitize_text',
        ));
		$wp_customize->add_control( 
			new ariwoo_footer( $wp_customize, 'ariwoo_slider_' . $key . '_footer', array(
			'label'		=> $value,
			'section'   => 'ariwoo_customizer_slider_text_boxes',
			'settings'  => 'ariwoo_slider_' . $key . '_footer',
			'priority' 	=> $i_priority++
		) ) );
	}// end foreach	
}
add_action( 'customize_register', 'ariwoo_slider_text_boxes_options' );






function servicesText_customizer( $wp_customize ) {
	
	$list_feature_modules = array( // 1
		'one'		=> __( 'Icon 1', 'ariwoo' ),
		'two'		=> __( 'Icon 2', 'ariwoo' ),
		'three'		=> __( 'Icon 3', 'ariwoo' ),
	);
	
	
    $wp_customize->add_section( 'ariwoo_servicesText_section_contact', array(
	     'title'       => __( 'Services Setting', 'ariwoo' ),
	     'description' => __( 'This is a Services settings section to change the servise section Details.', 'ariwoo' ),
        )
    );
	
	
	
	
	
	
	
	
	
	$i_priority = 1;
	
	foreach ($list_feature_modules as $key => $value) {
	
		/* Add sub title */
		$wp_customize->add_setting( 'ariwoo_services_' . $key . '_sub_title', array(
            'sanitize_callback' => 'ariwoo_sanitize_text',
        ));
		$wp_customize->add_control( 
			new ariwoo_sub_title( $wp_customize, 'ariwoo_services_' . $key . '_sub_title', array(
					'label'		=> $value,
					'section'   => 'ariwoo_servicesText_section_contact',
					'settings'  => 'ariwoo_services_' . $key . '_sub_title',
					'priority' 	=> $i_priority++ 
				) 
			) 
		);
	 
		
		/* Class */
		$wp_customize->add_setting( 'ariwoo_header_servicesicon_'.$key.'_url', array(
		        'default' => __( 'Font class Name', 'ariwoo' ),
				'sanitize_callback' => 'ariwoo_sanitize_text',
			) 
		);
		$wp_customize->add_control('ariwoo_header_servicesicon_'.$key.'_url', array(
				'label'    => __( 'Class Name', 'ariwoo' ),
				'section' => 'ariwoo_servicesText_section_contact',
				'settings' => 'ariwoo_header_servicesicon_'.$key.'_url',
				'type' => 'text',
				'priority' => $i_priority++
			)
		);
	
		/* Title */
		$wp_customize->add_setting( 'ariwoo_header_services_'.$key.'_url', array(
		        'default' => __( 'Title', 'ariwoo' ),
				'sanitize_callback' => 'ariwoo_sanitize_text',
			) 
		);
		$wp_customize->add_control('ariwoo_header_services_'.$key.'_url', array(
				'label'    => __( 'Title', 'ariwoo' ),
				'section' => 'ariwoo_servicesText_section_contact',
				'settings' => 'ariwoo_header_services_'.$key.'_url',
				'type' => 'text',
				'priority' => $i_priority++
			)
		);
	
	
	
		/* Featured Header Text */
		$wp_customize->add_setting('ariwoo_featured_textbox_header_services_'.$key, array(
		        'default' => __( 'Description', 'ariwoo' ),
				'transport' => 'postMessage',
				'sanitize_callback' => 'ariwoo_sanitize_text',
		    )
		);
		$wp_customize->add_control('ariwoo_featured_textbox_header_services_'.$key, array(
				'label' => __( 'Services Description', 'ariwoo' ),
				'section' => 'ariwoo_servicesText_section_contact',
				'settings' => 'ariwoo_featured_textbox_header_services_'.$key,
				'type' => 'textarea',
				'priority' => $i_priority++
			)
		);
		
		 
		/* Add footer bar */
		$wp_customize->add_setting( 'ariwoo_services_' . $key . '_footer', array(
            'sanitize_callback' => 'ariwoo_sanitize_text',
        ));
		$wp_customize->add_control( 
			new ariwoo_footer( $wp_customize, 'ariwoo_services_' . $key . '_footer', array(
			'label'		=> $value,
			'section'   => 'ariwoo_servicesText_section_contact',
			'settings'  => 'ariwoo_services_' . $key . '_footer',
			'priority' 	=> $i_priority++
		) ) );
	}// end foreach	
	
	
	
	
	
	
	
	
	
	
	
	$wp_customize->add_setting(
	    'ariwoo_maiN_heading', array(
		    'default' => __( 'Heading', 'ariwoo' ),
			'transport' => 'postMessage',
		    'sanitize_callback' => 'ariwoo_sanitize_text',
	    )
	);
	
	
	$wp_customize->add_control(
		'ariwoo_maiN_heading', array(
			'label'    => __( 'Main Heading', 'ariwoo' ),
			'section' => 'ariwoo_servicesText_section_contact',
			'type' => 'text',
			'priority' => '19',
		)
	);
	
	
	
	 
	
	
	
	
	
	
	
	
	
}
add_action( 'customize_register', 'servicesText_customizer' );




 

















 






 
 
// SANITIZATION
// ==============================
// Sanitize Text
function ariwoo_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
// Sanitize Textarea
function ariwoo_sanitize_textarea($input) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags);
	return $output;
}
// Sanitize Checkbox
function ariwoo_sanitize_checkbox( $input ) {
	if( $input ):
		$output = '1';
	else:
		$output = false;
	endif;
	return $output;
}
// Sanitize Numbers
function ariwoo_sanitize_integer( $input ) {
	$value = (int) $input; // Force the value into integer type.
    return ( 0 < $input ) ? $input : null;
}
function ariwoo_sanitize_float( $input ) {
	return floatval( $input );
}
// Sanitize Uploads
function ariwoo_sanitize_upload($input){
	return esc_url_raw($input);	
}
// Sanitize Colors
function ariwoo_sanitize_hex($input){
	return maybe_hash_hex_color($input);
}



function customize_styles_ariwoo_upgrade( $input ) { ?>
	   <style type="text/css">
		#customize-theme-controls #accordion-section-ariwoo_upgrade .accordion-section-title:after {
			color: #fff;
		}
		#customize-theme-controls #accordion-section-ariwoo_upgrade .accordion-section-title {
			background-color: rgba(113, 176, 47, 0.9);
			color: #fff;
		}
		#customize-theme-controls #accordion-section-ariwoo_upgrade .accordion-section-title:hover {
			background-color: rgba(113, 176, 47, 1);
		}
		#customize-theme-controls #accordion-section-ariwoo_upgrade .theme-info a {
			padding: 10px 8px;
			display: block;
			border-bottom: 1px solid #eee;
			color: #555;
		}
		#customize-theme-controls #accordion-section-ariwoo_upgrade .theme-info a:hover {
			color: #222;
			background-color: #f5f5f5;
		}
		h1 {
		line-height: 25px;
		}
	</style>
<?php }
 
add_action( 'customize_controls_print_styles', 'customize_styles_ariwoo_upgrade');
 







/* Wait until all sections are created then re-order them */
function ariwoo_reorder_sections_theme_customizer($wp_customize){
	
	$wp_customize->get_section('title_tagline')->priority = 2;
	$wp_customize->get_section('ariwoo_logo_section')->priority = 3;
	$wp_customize->get_section('nav')->priority = 4;
	$wp_customize->get_section('header_image')->priority = 6;
	$wp_customize->get_section('colors')->priority = 7;
	 
	
	$wp_customize->get_section('static_front_page')->priority = 11;
	$wp_customize->get_section('ariwoo_customizer_slider_text_boxes')->priority = 14;
	$wp_customize->get_section('ariwoo_logo_section')->priority = 15;
$wp_customize->get_section('ariwoo_servicesText_section_contact')->priority = 16;
 
}
add_action('customize_register', 'ariwoo_reorder_sections_theme_customizer');















