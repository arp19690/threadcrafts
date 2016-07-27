{if $popup_category}
		{if $popup_category.show_popup == "Y"}
				{include file="common/popupbox.tpl" act="general" id="agressive_popup" content="<div style='width:{$popup_category.popup_width}px; height:{$popup_category.popup_height}px;'>{$popup_category.description}</div>" text="{$popup_category.title}" wysiwyg=true link_text="agressive_popup" link_meta="text-button hidden"}
	{literal}
	<script>
	var time_to_show = {/literal}{$popup_category.time_to_show}{literal}*1000;
	function open_agressive_popup(){
		var _e = $('#opener_agressive_popup');

		var params = $.ceDialog('get_params', _e);

		$('#' + _e.data('caTargetId')).ceDialog('open', params);

		return false;
		}
		setTimeout(open_agressive_popup, time_to_show);

	</script>
	{/literal}
		{/if}
{/if}

