{if !$smarty.cookies.agressive_popup_home_page}
	{if $popup}
		{if $smarty.request.dispatch == 'index.index' && $popup.show_popup == "Y"}
				{include file="common/popupbox.tpl" act="general" id="agressive_popup" content="<div style='width:{$popup.popup_width}px; height:{$popup.popup_height}px;'>{$popup.description}</div>" text="{$popup.title}" wysiwyg=true link_text="agressive_popup" link_meta="text-button hidden"}
	{literal}
	<script>
	var time_to_show = {/literal}{$popup.time_to_show}{literal}*1000;
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
{/if}
