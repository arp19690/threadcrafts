<div class="ty-company-fields">
    <h1 class="ty-mainbox-title">Track Your Shipment Status</h1>

    <div id="track_shipment" > 

        <form action="{"track.track"|fn_url}" method="post" name="track_shipment_form">

            <div class="ty-control-group">
                <label for="order_id" class="ty-control-group__title cm-required">Order ID</label>
                <input type="text" name="order_id" id="track_order_id" size="8" value="" class="ty-input-text" />
            </div>

            <div class="buttons-container">
                {include file="buttons/button.tpl" but_text=__("submit") but_name="dispatch[companies.apply_for_vendor]" but_id="but_apply_for_vendor" but_meta="ty-btn__primary"}
            </div>
        </form>		
    </div>
	{if isset($track_data)}
		<div id="track_data">
			{$track_data nofilter}
				
		</div>
	{/if}
</div>
{literal}
<style>
 #track_shipment{width :40%;margin:0 auto;}
 #track_data{width: 80%;margin: 0 auto;}
 .error{ max-width:50% ;background-color: #D82F2F;padding: 10px 20px;color: #ffffff;font-size: 14px;width: 80%;margin: 0 auto;border: 1px solid #AD2C2C;border-radius: 3px;text-align:center;}
 .track_table{margin: 20px auto;width: 50%;border: 1px solid #1A7AA0;text-align:center;}
 .track_table tr.head{   background-color: #428BCA;  color: #fff;}
 .track_table tr th{ border-right:1px solid #fff;padding:5px; }
 .track_table tr td{border-right:1px solid #2eade0;padding:5px;}
 .row-fluid .span0{width:23.404255319149%!important;}
 </style>
 {/literal}
