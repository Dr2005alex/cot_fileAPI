<!-- BEGIN: FORM --> 

<div id="FileAPImultiupload{PRESET_NAME}_{INDF}" class="fileapi_form fileapi_form_avatar">
	<div  class="fileapi_body">	
		<div  class="fapi-js-dropzone" style="display: none">
			<div class="fapi-dropzone-bg"></div>
			<div class="fapi-dropzone-txt">{PHP.L.fileAPI_drop_file_here}</div>
		</div>
		<div class="fapi-oooops">	
			{PHP.L.fileAPI_not_support}
			<div>{PHP.L.fileAPI_downloading_file_is_not_posible}</div>
		</div>
		<script class="fapi-file-tmpl" type="text/ejs">
			<div id="file-<%=FileAPI.uid(file)%>" class="fapi-js-file fapi-b-file fapi-b-file_<%=file.type.split('/')[0]%>">
				<div class="fapi-js-left">
					<span class="fapi-icon-file fapi-icon-type-<%=file.type.split('/')[0]%> fapi-icon-ext-<%=file.name.split(".").pop()%>"></span>
				</div>
				<div class="fapi-b-file-right">
					<div class="fapi-js-info fapi-b-file__info">size: <%=(file.size/FileAPI.KB).toFixed(2)%> KB <span class="fapi-process"></span></div>
					<div class="fapi-js-progress fapi-b-file-bar" style="display: none">
						<div class="fapi-b-progress"><div class="fapi-js-bar fapi-b-progress-bar"></div></div>
					</div>
				</div>
				<b class="fapi-js-reset fapi-del">&times;</b>
				<b class="fapi-js-abort fapi-b-file-abort" title="abort">&times;</b>
			</div>
		</script>
		<script class="fapi-popup-tmpl" type="text/ejs">
			<div id="<%=box%>" class="jqmWindow">
				<div class="fapi_popup_body">
					<div class="lside">
						<div id="imagebox" ></div>
					</div>
					<div class="rside">
						<div class="imgprev"></div>
						<div class="btnpanel">
							<button class="fapi-js-crop"><img src="{PHP.cfg.modules_dir}/fileAPI/icon/disk.png" /> {PHP.L.Download}</button>
							<button class="w50" data-method="move" data-option="0" data-second-option="10" title="Move Down">
								<img src="images/icons/default/arrow-down.png"/>
							</button>
							<button class="w50" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
								<img src="images/icons/default/arrow-up.png"/>
							</button>
							<button class="w50" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
								<img src="images/icons/default/arrow-left.png"/>
							</button>
							<button class="w50" data-method="move" data-option="10" data-second-option="0" title="Move Right">
								<img src="images/icons/default/arrow-right.png"/>
							</button>
							<button class="w50" data-method="rotate" data-option="-90" title="Rotate Left">
								<img src="images/icons/default/undo.png"/>
							</button>
							<button class="w50" data-method="rotate" data-option="90" title="Rotate Right">
								<img src="images/icons/default/arrow-jump.png" class="rotate-90"/>
							</button>				
							<button class="jqmClose">
								<img src="images/icons/default/stop.png" /> {PHP.L.Cancel}
							</button>						
						</div>
					</div>
				</div>
			</div>
		</script>
		<div class="fapi-file-preview" style="height: {PREVIEW_HEIGHT}px; width: {PREVIEW_WIDTH}px">
			<div class="fapi-buttons-panel">
				<div class="fapi-button btn btn-success btn-sm">
					<div class="fapi-buttont-text">{PHP.L.fileAPI_download_file}</div>
					<input name="files" class="fipi-button-input" type="file"  />
				</div>
				<button class="fapi-js-start fapi-button ">{PHP.L.fileAPI_download_file}</button>
				<div class="fapi-drag-n-drop">
					{PHP.L.fileAPI_drag_file_here}
				</div>
				<div class="fapi-main-info"></div>
			</div>
			{DISPLAY}
		</div>
	</div>
	<div  class="popup" style="display: none;">
		<div class="popup__body"><div class="js-img"></div></div>
		<div style="margin: 0 0 5px; text-align: center;">
			<div class="js-upload fapi_btn">{PHP.L.fileAPI_upload_file}</div>
			<div class="js-close fapi_btn fapi_btn-close">{PHP.L.Cancel}</div>
		</div>
	</div>
</div>	

<script type="text/javascript">
		jQuery(function ($){
			var widget_id = 'FileAPImultiupload{PRESET_NAME}_{INDF}';
			var FileAPIobj = $('#'+widget_id);
			FileAPIobj.cot_fileAPI({
					preset:{PRESET}
				});
		});	
</script>
<!-- END: FORM -->


<!-- BEGIN: MAIN --> 
	
	<!-- BEGIN: ROW --> 

		<div id="fapi_thumb_{ID}" class="fapi-b-file">
			<!-- IF {TYPE} == 'IMG' -->
			<div class="fapi-js-left">

				<img src="{SRC}" alt="{TITLE}"/>

			</div>		
			<!-- ENDIF -->
			<div class="fapi-b-file-right">
				<!-- IF !{LINKS_EDITOR_LINK} -->	
				<div class="fapi-js-info fapi-b-file__info"><span class="fapi_ok">&check;ok</span></div>
				<!-- ENDIF -->
			</div>
			<span class="fapi-js-del fapi-del" data-id = "{ID}" title="{PHP.L.Delete}">&times;</span>
			<div class="fapiclear"></div>
		</div>

	<!-- END: ROW -->


<!-- END: MAIN -->