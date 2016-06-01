<?php

 

// admin area styling
function ariwoo_custom_admin_colors() { 
   echo '<style type="text/css">

body {
	margin: 0px;
}

.grid {
	width: 100%;
	max-width: 1240px; 
	min-width: 755px;
	margin: 0 auto;
	overflow: hidden;
}

.grid:after {
	content: "";
	display: table;
	clear: both;
}

.grid-pad {
	padding-top: 20px;
	padding-left: 0px; /* grid-space to left */
	padding-right: 0px; /* grid-space to right: (grid-space-left - column-space) e.g. 20px-20px=0 */
}


.adcenter {
    text-align: center;
}



.col-1-4 {
	float: left;
	padding-right: 2%; 
	width: 23%;  
	text-align: center;
}

.col-1-3 {
	float: left;
	padding-right: 2%;
	width: 31.333%;
	text-align: center;
	}
	
.fa { 
	font-size: 30px;
	color: #1cbda2;
}

.senswp .fa { font-size: 30px !important; }

.col-1-4 h4 {
	font-size: 16px;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"] {
	border: 2px solid;
	border-color: #1cbda2;
	border-radius: 4px;
	background: #1cbda2;
	box-shadow: none;
	font-size: 13px;
	line-height: 1;
	font-weight: 400;
	padding: 0.7em 1.5em 0.7em;
	text-shadow: none;
	color: #fff;
	cursor: pointer;
}

button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover {
	border-color: #1cbda2;
}

button:focus,
input[type="button"]:focus,
input[type="reset"]:focus,
input[type="submit"]:focus,
button:active,
input[type="button"]:active,
input[type="reset"]:active,
input[type="submit"]:active {
	border-color: #1cbda2;
}

button.pro {
	font-size: 24px;
	padding: 1.25em 2em;
	text-align: center;
	margin: 20px auto 0;
	display: block;
}

a { 
	text-decoration: none;
}

.custom-box {
    border: 1px solid #dadada;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 30px;
    overflow: hidden;
    position: relative;
    width: 100%;
}
.custom-box:before {
    content: "";
    display: block;
    padding-top: 90%;
}
.home-collection {
    background: none repeat scroll 0 0 #fff;
}
.custom-content {
    bottom: 0;
    color: white;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.custom-content div {
    display: table;
    height: 100%;
    width: 100%;
}
.custom-content span {
    color: #999;
    display: table-cell;
    padding: 20px;
    text-align: center;
    vertical-align: middle;
}
.custom-content span > .fa {
    color: #404040;
    display: block;
    font-size: 50px;
    margin: 0 auto;
    padding: 0 0 20px;
    transition: all 0.2s ease-in-out 0s;
}
.custom-content:hover .fa {
    color: #1cbda2;
    font-size: 58px;
    transition: all 0.2s ease-in-out 0s;
}
.custom-content span > h5 {
    color: #404040;
	font-size: 18px;
	line-height: 20px;
	margin: 0;
}
.custom-content span > p {
    font-size: 15px;
    margin-bottom: 0;
}

@media handheld, only screen and (max-width: 800px) {
	.grid {
		width: 100%;
		min-width: 0;
		margin-left: 0px;
		margin-right: 0px;
		padding-left: 0px; /* grid-space to left */
		padding-right: 10px; /* grid-space to right: (grid-space-left - column-space) e.g. 20px-10px=10px */ 
	}
	
	.col-1-4 {
		float: none;
		padding-right: 0px;
		width: 100%;
		text-align: center;
	}
	
	.col-1-3 {
		float: none;
		padding-right: 0px;
		width: 100%;
		text-align: center; 
	}
}

}
		
         </style>';
}

add_action('admin_head', 'ariwoo_custom_admin_colors');

     
    add_action('admin_menu', 'ariwoo_setup_menu');
     
    function ariwoo_setup_menu(){
    	add_theme_page( __('AR Theme Details', 'ariwoo' ), __('AR Theme Details', 'ariwoo' ), 'edit_theme_options', 'ariwoo-setup', 'ariwoo_init' ); 
    }  
     
 	function ariwoo_init(){ 
	 	echo '<div class="grid grid-pad"><div class="col-1-1"><h1 style="text-align: center;">';
		printf( __('Thank you for using Ariwoo Theme :)', 'ariwoo' ));  
        echo "</h1></div></div>";
			
		echo '<div class="grid grid-pad" style="border-bottom: 1px solid #ccc; padding-bottom: 40px; margin-bottom: 30px;" ><div class="col-1-3"><h2>'; 
		printf( __('View Theme Demo', 'ariwoo' ));
        echo '</h2>';
		
		echo '<p>';
		printf( __('You can see more feature & functionality in our PRO Virsion. Watch the Demo by clicking the link below.', 'ariwoo' )); 
		echo '</p>'; 
		
		echo '<a href="http://arinio.com/ariwoo-responsive-multipurpose-wordpress-theme/" target="_blank"><button>';  
		printf( __('View Demo', 'ariwoo' )); 
		echo "</button></a></div>";
		
		echo '<div class="col-1-3"><h2>'; 
		printf( __('Get Pro Free This Theme', 'ariwoo' ));
        echo '</h2>';  
		
		echo '<p>';
		printf( __('If you want to get Pro version of this theme Totally Free. Click the link below.', 'ariwoo' )); 
		echo '</p>'; 
		
		echo '<a href="http://arinio.com/get-free-our-theme/" target="_blank"><button>'; 
		printf( __('Read More', 'ariwoo' ));
		echo "</button></a></div>";
		
		echo '<div class="col-1-3"><h2>'; 
		printf( __('View More Our Themes', 'ariwoo' )); 
        echo '</h2>';  
		
		echo '<p>';
		printf( __('Want to see more our themes you simply visit our site. Click the link below.', 'ariwoo' ));
		echo '</p>';
		
		echo '<a href="http://arinio.com/" target="_blank"><button>';
		printf( __('Visit Site', 'ariwoo' ));
		echo '</button></a></div></div>';
		
		echo '<div class="grid grid-pad senswp"><div class="col-1-1"><h1 style="padding-bottom: 30px; text-align: center;">';
		printf( __('Get Ariwoo PRO Theme! Just $19', 'ariwoo' )); 
		echo '</h1></div>';
		
        echo '<div class="col-1-12 adcenter"><i class="fa fa-cogs"></i><h4>';
		printf( __('You are using the Ariwoo, Free Version of Ariwoo Pro Theme. Upgrade to Pro for extra features like Home Page Unlimited Slider, Work Gallery, Team section, Client Section, Contact Page and many more Page Templates, Social Link Section, Life time theme support and much more.', 'ariwoo' ));
		echo '</h4>';
		
        
		echo ' </div></div>';
		
       
            
        
		
		echo '<div class="grid grid-pad" style="border-bottom: 1px solid #ccc; padding-bottom: 50px; margin-bottom: 30px;"><div class="col-1-1"><a href="http://arinio.com/ariwoo-responsive-multipurpose-wordpress-theme/" target="_blank"><button class="pro">'; 
		printf( __( 'Upgrade to Ariwoo PRO', 'ariwoo' ));
		echo '</button></a></div></div>';
		
    }
?>