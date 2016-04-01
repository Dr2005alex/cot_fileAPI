<!-- BEGIN: MAIN --> 
<h2>{PHP.L.fileAPI_preset_title}</h2>

<div class="block button-toolbar">
	<!-- IF {PHP.a} == '' -->
	<a href="{ADD_URL}" class="button special">{PHP.L.fileAPI_preset_add}</a>
	<!-- ELSE -->
	<a href="{LIST_URL}" class="button">{PHP.L.fileAPI_preset_list}</a>
	<!-- ENDIF -->
</div>

<!-- BEGIN: LIST -->
<div class="block">
	<table class="cells">
	<tr>
		<td class="coltop centerall width80">{PHP.L.fileAPI_preset}</td>
		<td class="coltop centerall width20">{PHP.L.Action}</td>
	</tr>
	<!-- BEGIN: ROW --> 
	<tr>
		<td>{NAME}</td>
		<td class="centerall">
			<a href="{EDIT_URL}" class="button">{PHP.L.Edit}</a>
			<!-- IF {DELETE} -->
			<a href="{DELETE_URL}" class="button">{PHP.L.Delete}</a>
			<!-- ENDIF -->
		</td>
	</tr>
	<!-- END: ROW -->
	</table>
</div>		
<!-- END: LIST -->	

<!-- BEGIN: FORM -->
<form id="preset" action="{ACTION_FORM}" method="POST">	
	
	<div class="block">
		{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}

		<table class="cells">
			<tr>
				<td class="group_begin strong" colspan="2">{PHP.L.fileAPI_preset_main_setup_form}:</td>
			</tr>
			<tr>
				<td class="width25">{PHP.L.fileAPI_preset_name}:</td>
				<td class="width75">
					{P_NAME}
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_name_info}</div>
				</td>
			</tr>
			<tr>
				<td>{PHP.L.fileAPI_preset_autoload}:</td>
				<td>
					{P_AUTO}
				</td>
			</tr>
			<tr>
				<td>Drag&Drop:</td>
				<td>
					{P_DND}
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_dnd_info}</div>
				</td>
			</tr>
			<tr>
				<td>{PHP.L.fileAPI_preset_multiple}:</td>
				<td>
					{P_MULTIPLE}
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_multiple_info}</div>
				</td>
			</tr>				
			<tr>
				<td>{PHP.L.fileAPI_preset_maxfiles}:</td>
				<td>
					{P_MAXFILES}
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_maxfiles_info}</div>
				</td>
			</tr>	
			<tr>
				<td>{PHP.L.fileAPI_preset_accept}:</td>
				<td>
					{P_ACCEPT}
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_accept_info}</div>
				</td>
			</tr>	
			<tr>
				<td>{PHP.L.fileAPI_preset_max_file_size}:</td>
				<td>
					{P_MAX_F_SIZE} Mb.
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_max_file_size_info}</div>
				</td>
			</tr>
			<tr>
				<td>{PHP.L.fileAPI_preset_time_error}:</td>
				<td>
					{P_TIME} ms.
					<div class="adminconfigmore">{PHP.L.fileAPI_preset_time_error_info}</div>
				</td>
			</tr>	
			<tr>
				<td>{PHP.L.fileAPI_preset_tpl}:</td>
				<td>
					{P_TPL}
				</td>
			</tr>
			<tr>
				<td>{PHP.L.fileAPI_preset_mode}:</td>
				<td>
					{P_MODE}
				</td>
			</tr>
		</table>
	</div>
				
	<span id="prev_title" style="display:none;">{PHP.L.fileAPI_preset_preview_set}</span>	
	
	<!-- BEGIN: ELEMENT -->
	<div class="block preset_preview_block">
	<table class="info cells">	
		<tr>
			<td class="group_begin" colspan="3">	
				<h4 class="prev_title">
					<!-- IF {IT_NAME_TITLE} == 'original' -->
					{PHP.L.fileAPI_preset_orig_set}
					<!-- ELSE -->
					{PHP.L.fileAPI_preset_preview_set}
					<!-- ENDIF -->
				</h4>
			</td>
			<td class="group_begin textright">
				<a href="#" class="deloption button" <!-- IF {IT_NAME_TITLE} == 'original' -->style="display:none;"<!-- ENDIF -->>{PHP.L.Delete}</a>
			</td>
		</tr>
		<tr>
			<td class="width25">{PHP.L.fileAPI_preset_preview_name}</td>
			<td class="width25">{IT_NAME}</td>
			<td class="width25">{PHP.L.fileAPI_preset_preview_form}</td>
			<td class="width25">{IT_FORM}</td>
		</tr>
		<tr>
			<td colspan="2" class="centerall strong">{PHP.L.fileAPI_preset_param}:</td>
			<td colspan="2" class="centerall strong">{PHP.L.fileAPI_preset_watermark}:</td>
		</tr>
		<tr>
			<td>{PHP.L.fileAPI_preset_width}</td>
			<td>{IT_WIDTH} px</td>
			<td class="width25">{PHP.L.fileAPI_preset_watermark_on}</td>
			<td class="width25">{IT_WATERMARK}</td>
		</tr>
		<tr>
			<td>{PHP.L.fileAPI_preset_height}</td>
			<td>{IT_HEIGHT} px</td>
			<td>{PHP.L.fileAPI_preset_watermark_src}</td>
			<td>{IT_WATERMARK_SRC}</td>
		</tr>
		<tr>
			<td>{PHP.L.fileAPI_preset_framing}</td>
			<td>{IT_TYPE}</td>
			<td>{PHP.L.fileAPI_preset_watermark_pos}</td>
			<td>{IT_WATERMARK_POS}</td>
		</tr>
		<tr>
			<td>{PHP.L.fileAPI_preset_quality}</td>
			<td>{IT_GUALITY}</td>
			<td>{PHP.L.fileAPI_preset_watermark_x}</td>
			<td>{IT_WATERMARK_X}</td>
		</tr>
		<tr>
			<td>{PHP.L.fileAPI_preset_convert}</td>
			<td>{IT_TYPEIMAGE}</td>
			<td>{PHP.L.fileAPI_preset_watermark_y}</td>
			<td>{IT_WATERMARK_Y}</td>
		</tr>
	</table>	
	</div>
	
	<!-- END: ELEMENT -->	
	<div class="block">	
		<input type="submit" value="{PHP.L.Save}" class="confirm" />
		<a href="#" id="addoption" class="button special">{PHP.L.fileAPI_preset_preview_add}</a>			
	</div>
</form>		

<script type="text/javascript">
	$( document ).on( "click", ".deloption", function(e) {
		e.preventDefault();
		$(this).parents('.preset_preview_block').remove();
	});
	$( document ).on( "click", "#addoption", function(e) {
		e.preventDefault();
		var title = $('#prev_title').text();
		var newOption = $('.preset_preview_block').last().clone().insertAfter($('.preset_preview_block').last()).show();
		newOption.find('input[type="text"].prv_name').val('').prop('readonly', false);
		newOption.find('.prev_title').text(title);
		newOption.find('.deloption').show();
		return false;
	});
</script>	
<!-- END: FORM -->


<!-- END: MAIN -->