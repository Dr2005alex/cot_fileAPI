<!-- BEGIN: FORM --> 
<div id="FileAPImultiupload{PRESET_NAME}_{INDF}" class="fileapi_form">
	<div  class="fileapi_body">			
		<div  class="fapi-js-dropzone" style="display: none">
			<div class="fapi-dropzone-bg"></div>
			<div class="fapi-dropzone-txt">{PHP.L.fileAPI_drop_file_here}</div>
		</div>
		<div class="fapi-oooops">	
			{PHP.L.fileAPI_not_support}
			<div>{PHP.L.fileAPI_downloading_file_is_not_posible}</div>
		</div>
		<div class="fapi-buttons-panel">
			<div class="fapi-js-select fapi-button btn btn-success btn-sm">
				<div class=" fapi-buttont-text">{PHP.L.fileAPI_select_file}</div>
				<input name="files" class="fipi-button-input" type="file"  />
			</div>
			<button class="fapi-js-start fapi-button">{PHP.L.fileAPI_download_file}</button>
			<div class="fapi-drag-n-drop">
				{PHP.L.fileAPI_drag_file_here}
			</div>
		</div>
		<div class="fapi-main-info"></div>
		<script class="fapi-file-tmpl" type="text/ejs">
			<div id="file-<%=FileAPI.uid(file)%>" class="fapi-js-file fapi-b-file fapi-b-file_<%=file.type.split('/')[0]%>">
				<div class="fapi-js-left fapi-b-file-left">
					<span class="fapi-icon-file fapi-icon-type-<%=file.type.split('/')[0]%> fapi-icon-ext-<%=file.name.split(".").pop()%>"></span>
				</div>
				<div class="fapi-b-file-right">
					<div class="fapi-overflow"><a class="fapi-file-name"><%=file.name%></a></div>
					<div class="fapi-js-info fapi-b-file__info">size: <%=(file.size/FileAPI.KB).toFixed(2)%> KB <span class="fapi-process"></span></div>
					<div class="fapi-js-progress fapi-b-file-bar" style="display: none">
						<div class="fapi-b-progress"><div class="fapi-js-bar fapi-b-progress-bar"></div></div>
					</div>
				</div>
				<b class="fapi-js-reset fapi-del">&times;</b>
				<b class="fapi-js-abort fapi-b-file-abort" title="abort">&times;</b>
				<div class="fapiclear"></div>
			</div>
		</script>
		<script class="fapi-file-tmpl-editor" type="text/ejs">
			<%if( data.file){%>
				<a href="<%=data.orig_url%>" title="<%=data.alt%>"><%=data.alt%></a>
			<%}else{ %>	
				<% if( link){%>
					<a href="<%=data.orig_url%>" ><img src="<%=data.url%>" alt="<%=data.alt%>"  /></a>
				<%}else{%>	
					<img src="<%=data.url%>" alt="<%=data.alt%>"/>
				<%} %>	
			<% } %>	
		</script>
		<div class="fapi-file-preview" style="margin-top: 10px">
			{DISPLAY}
		</div>
	</div>
</div>	
		<style>
			#FileAPImultiupload{PRESET_NAME}_{INDF} .fapi-b-file-right{
				width: calc(98% - 10px - {PREVIEW_WIDTH}px );
			}
		</style>
<script type="text/javascript">
		jQuery(function ($){
			var widget_id = 'FileAPImultiupload{PRESET_NAME}_{INDF}';
			var FileAPIobj = $('#'+widget_id);
			FileAPIobj.cot_fileAPI({
					preset:{PRESET}
				});
		}); 
		$(document).on('ready ajaxSuccess',function(){
				$('.fapi-dropdown > li a').click(function(evt){
					evt.preventDefault();
				});
				$('.fapi-dropdown > li').unbind('hover');
				$('.fapi-dropdown > li').hover(
				function(){
					$(this).find('ul').fadeIn('fast');
				},
				function(){
				  $(this).find('ul').hide();
				});	
		});
</script>
<!-- END: FORM -->

<!-- BEGIN: MAIN --> 

	<!-- BEGIN: ROW --> 

		<div id="fapi_thumb_{ID}" class="fapi-b-file">
			<!-- IF {TYPE} == 'IMG' -->
			<div class="fapi-js-left fapi-b-file-left fapi-left-border">
				<a href="{ORIG_URL}" data-lightbox = "roadtrip" data-rel="lightcase:FapiImages" target="_blank" title="{TITLE}">
					<img src="{SRC}" alt="{TITLE}"/>
				</a>
			</div>	
			<!-- ELSE -->
			<div class="fapi-js-left fapi-b-file-left">
			
				<a href="{ORIG_URL}" <!-- IF {MIME_TYPE} != 'application' -->data-lightbox = "roadtrip" data-rel="lightcase"<!-- ELSE -->target="_blank"<!-- ENDIF -->  title="{TITLE}">
					<span class="fapi-icon-file fapi-icon-type-{MIME_TYPE} fapi-icon-ext-{EXT}"></span>
				</a>
			</div>		
			<!-- ENDIF -->
			
			<div class="fapi-b-file-right">
				<div class="fapi-overflow">
					<span id="fapi_edit_name_{ID}" title="size: {SIZE}">
						<a class="fapi-file-name fapi_ajax"  data-url="{NAME_EDIT_URL}" data-ajaxblock="fapi_edit_name_{ID}" >{TITLE}</a>
					</span>
				</div>
				<!-- IF !{LINKS_EDITOR_LINK} -->	
				<div class="fapi-js-info fapi-b-file__info">size: {SIZE} <span class="fapi_ok">&check;ok</span></div>
				<!-- ENDIF -->
		
				<!-- IF {TYPE} == 'IMG' -->
				
					<!-- IF {LINKS_EDITOR_LINK} -->
					<div class="fapi-b-file__info">
						<ul class="fapi-dropdown">
							<li>
								<a href="#"><i class="fapi-icon-insert-img"></i></a>
								<ul>
									<li class="head">{PHP.L.fileAPI_insert_img}</li>
									{LINKS_EDITOR_IMG}
								</ul>
							</li>
							<li>
								<a href="#"><i class="fapi-icon-insert-img link-img"></i></a>
								<ul>
									<li class="head">{PHP.L.fileAPI_insert_link_img}</li>
									{LINKS_EDITOR_LINK}
								</ul>
							</li>
						</ul>
					</div>
					<!-- ENDIF -->
					
				<!-- ELSE -->
				
					<!-- IF {LINKS_EDITOR_LINK} -->	
					<div class="fapi-b-file__info">
						<ul class="fapi-dropdown">
							<li>
								<a href="#"><i class="fapi-icon-insert-img link-img"></i></a>
								<ul>
									<li class="head">{PHP.L.fileAPI_insert_link}</li>
									{LINKS_EDITOR_LINK}
								</ul>
							</li>
						</ul>
					</div>
					<!-- ENDIF -->
					
				<!-- ENDIF -->
			</div>
			<span class="fapi-js-del fapi-del" data-id = "{ID}" title="{PHP.L.Delete}">&times;</span>
			<div class="fapiclear"></div>
		</div>

	<!-- END: ROW -->
	
<!-- END: MAIN -->