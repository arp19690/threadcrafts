{if $products}
	{foreach from=$products item="po"}
		<li class="p-item clearfix" >
			<a class="ui-corner-all" href="{"products.view?product_id=`$po.product_id``$suffix`"|fn_url:'C':'http'}"> 
			{assign var="product_image" value=$po.product_id|fn_get_image_pairs:'product':'M':true:true}
			{if $product_image.pair_id}
				{include file="common/image.tpl" image_width="50" image_height="50" images=$product_image no_ids=true class="product-notification-image ty-float-left"}
			{/if}
			{$po.product|truncate:40|nl2br nofilter} 
			<br />
			<span class="ty-list-price ty-nowrap">
				{include file="common/price.tpl" value=$po.price|default:$po.list_price span_id="old_price_`$po.product_id`" class="ty-list-price ty-nowrap"}
			</span>
			
			</a>
		</li>
	{/foreach}
{/if}