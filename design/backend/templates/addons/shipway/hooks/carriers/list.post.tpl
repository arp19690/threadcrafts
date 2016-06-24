{if ""|fn_get_shipway_login_id}
{assign 'shipway_carriers' ""|fn_get_shipway_carriers}
{if $shipway_carriers}
	{foreach from=$shipway_carriers item=ship_carrier}
	<option value="{$ship_carrier.code}" {if $carrier == "{$ship_carrier.code}"}{$carrier_name = "`$ship_carrier.name`"}selected="selected"{/if}>{$ship_carrier.name}</option>
	{/foreach}
{/if}
{/if}