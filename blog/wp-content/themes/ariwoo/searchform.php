<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <input type="text" placeholder="<?php echo __( 'Search', 'ariwoo' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="search" />
        <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ariwoo' ); ?>" />
    </div>
</form>
<div class="clear"></div>
<br/>
