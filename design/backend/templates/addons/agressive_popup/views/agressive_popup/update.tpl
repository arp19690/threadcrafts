{capture name="mainbox"}
  <form action="{""|fn_url}" method="post" name="agressive_popup_form" class="form-horizontal form-edit" enctype="multipart/form-data">
    <div id="content_basic">
      <fieldset>
        <div class="control-group">
          <label class="control-label" for="popup_description">{__("description")}</label>
          <div class="controls">
            <textarea id="popup_description" name="popup_data[description]" cols="35" rows="8" class="cm-wysiwyg input-large">{$popup_data.description }</textarea>
          </div>
        </div>
        <div class="control-group">
					<label class="control-label" for="popup_title">{__("popup_title")}:</label>
					<div class="controls">
						<input type="text" name="popup_data[title]" id="popup_title" size="55" value="{$popup_data.title}" class="input-large" />
					</div>
				</div>
        <div class="control-group">
					<label class="control-label" for="popup_width">{__("popup_width")}:</label>
					<div class="controls">
						<input type="text" name="popup_data[popup_width]" id="popup_width" size="20" maxlength="32"  value="{$popup_data.popup_width}" class="input-small" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="popup_height">{__("popup_height")}:</label>
					<div class="controls">
						<input type="text" name="popup_data[popup_height]" id="popup_height" size="20" maxlength="32"  value="{$popup_data.popup_height}" class="input-small" />
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" for="popup_time_to_show">{__("show_delay")} ({__("in_seconds")}):</label>
					<div class="controls">
						<input type="text" name="popup_data[time_to_show]" id="popup_time_to_show" size="50" maxlength="32"  value="{$popup_data.time_to_show	}" class="input-small" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="popup_time_to_live">{__("time_to_live")} ({__("in_days")}):</label>
					<div class="controls">
						<input type="text" name="popup_data[time_to_live]" id="popup_time_to_live" size="50" maxlength="32"  value="{$popup_data.time_to_live	}" class="input-small" />
					</div>
				</div>
				<div class="control-group">
						<label class="control-label" for="show_popup">{__("show_popup")}:</label>
						<div class="controls">
								<label class="checkbox">
										<input type="hidden" name="popup_data[show_popup]" value="N" />
										<input type="checkbox" name="popup_data[show_popup]" id="show_popup" value="Y" {if $popup_data.show_popup == "Y"}checked="checked"{/if}/>
								</label>
						</div>
				</div>
      </fieldset>
    </div>
  </form>
  {capture name="buttonssave"}
      {include file="buttons/save_cancel.tpl" but_role="submit-link" but_name="dispatch[agressive_popup.update]" hide_second_button='true' but_target_form="agressive_popup_form" save="Y"}
    {/capture}
{/capture}
{include file="common/mainbox.tpl" title=__("home_page_popup") content=$smarty.capture.mainbox select_languages=true buttons=$smarty.capture.buttonssave}