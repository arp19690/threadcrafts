{if $capture}
{capture name="carrier_field"}
{/if}

<select {if $id}id="{$id}"{/if} name="{$name}" {if $meta}class="{$meta}"{/if}>
    <option value="">--</option>
    {hook name="carriers:list"}
    {foreach from=$carriers item="code"}
    	<option value="{$code}" {if $carrier == "{$code}"}{$carrier_name = __("carrier_`$code`")}selected="selected"{/if}>{__("carrier_`$code`")}</option>
    {/foreach}
	<option value="bluedart" {if $carrier == "bluedart"}{$carrier_name = "Bluedart"} selected="selected"{/if} >Bluedart</option>
	<option value="delhivery" {if $carrier == "delhivery"}{$carrier_name = "Delhivery"} selected="selected"{/if} >Delhivery</option>
	<option value="gati" {if $carrier == "gati"}{$carrier_name = "Gati"} selected="selected"{/if}>Gati</option>
	<option value="gojavas" {if $carrier == "gojavas"}{$carrier_name = "Gojavas"} selected="selected"{/if}>Gojavas</option>
	<option value="ecomexpress" {if $carrier == "ecomexpress"}{$carrier_name = "Ecom Express"} selected="selected"{/if} >Ecom Express</option>
	<option value="dtdc" {if $carrier == "dtdc"}{$carrier_name = "DTDC"} selected="selected"{/if} >DTDC</option>
	<option value="dotzot" {if $carrier == "dotzot"}{$carrier_name = "Dotzot"} selected="selected"{/if} > DotZot</option>
	<option value="redexpress" {if $carrier == "redexpress"}{$carrier_name = "Red Express"} selected="selected"{/if}>Red Express</option>
	<option value="firstflight" {if $carrier == "firstflight"}{$carrier_name = "First Flight"} selected="selected"{/if}>First Flight</option>
	<option value="aramex" {if $carrier == "aramex"}{$carrier_name = "Aramex"} selected="selected"{/if} >Aramex</option>
	<option value="professional" {if $carrier == "professional"}{$carrier_name = "Professional Courier"} selected="selected"{/if} >Professional Courier</option>
    {/hook}
</select>
{if $capture}
{/capture}

{capture name="carrier_name"}
{$carrier_name}
{/capture}
{/if}