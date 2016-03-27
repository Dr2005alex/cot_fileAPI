<!-- BEGIN: FORM --> 
    <div id="FileAPImultiupload{PRESET_NAME}" class="fileAPI">

                <div class="fapi_wrapper">
                    <div class="fapi_display">

                            {DISPLAY}
                            <div class="fapi_upload_files">

                                    <div class="fapi_tpl fapi_images_preview "  data-id="<%=uid%>" title="<%-name%>, <%-sizeText%>">
                                        <div class="fapi_ok">&nbsp;</div>

                                            <div data-fileapi="file.remove" class="fapi_del">✖</div>
                                            <div class="fapi_preview ">
                                                    <div class="fapi_preview_pic"></div>
                                            </div>
											<div class="fapi_preview_progress"><div class="fapi_bar"></div></div>
                                            <% if( /^image/.test(type) ){ %>
                                                    <div data-fileapi="file.rotate.cw" class="fapi_preview_rotate"></div>
                                            <% } %>
											
											<div class="sub_preview">
												<div class="fapi_thumb_name"><%-name%></div>
												<div class="fapi_file_size"><%-sizeText%></div>	
											</div> 
                                            <div class="fapi_error"></div>
                                    </div>

                            </div>
							
						<!-- IF {DND} -->	
						<div class="fapi_add_preview_btn fapi_btn_upload_ctrl">
								<span>{PHP.L.fileAPI_upload_file}</span>
						</div>			
						<div class="fapi_add_preview_btn fapi_btn_abort_ctrl">
								<span>{PHP.L.fileAPI_upload_file_abort}</span>
						</div>	
                        
                        <div class="fapi_dndbox fapi_dnd_add_btn">
							<span>{PHP.L.fileAPI_upload_dnd_files_hint}</span>
						</div>
                        <!-- ENDIF -->
                    </div>
                    <div class="fapi_clear"></div>                  
                </div>      
                <div class="fapi_btn_box" <!-- IF {DND} -->style="display:none"<!-- ENDIF -->>        
                    <div class="fapi_btn fapi_add_btn">
                            <span>{PHP.L.fileAPI_add_files}</span>
                            <input type="file" name="filedata" class="fapi_add_input" />
                    </div>
                    <div class="fapi_btn fapi_btn_upload fapi_btn_upload_ctrl">
                            <span>{PHP.L.fileAPI_upload_file}</span>
                    </div>
                    <div class="fapi_btn fapi_btn_abort fapi_btn_abort_ctrl">
                            <span>{PHP.L.fileAPI_upload_file_abort}</span>
                    </div>   
                </div>     
       
    </div>
					
<style>
	.fileAPI .fapi_images_preview .fapi_error,
	.fileAPI .fapi_images_preview {height: calc({PREVIEW_HEIGHT}px + 2.2em); width: {PREVIEW_WIDTH}px;}
	.fileAPI i.fileAPIicon,
	.fileAPI .fapi_images_preview .fapi_preview{height: {PREVIEW_HEIGHT}px; width: {PREVIEW_WIDTH}px;}
	.fileAPI .fapi_dnd_add_btn,
	.fileAPI .fapi_add_preview_btn{height: calc({PREVIEW_HEIGHT}px + 2.2em); width:{PREVIEW_WIDTH}px;}

</style>				
		
<script>
$().ready(function () {

	var widget_id = 'FileAPImultiupload{PRESET_NAME}';
	var FileAPIobj = $('#'+widget_id);
	var fileAPI_preset = {PRESET};	

	if(fileAPI_preset.currentfiles < 1){			
		$('#'+widget_id + ' .fapi_add_btn').hide();
	}
	
	$('body').on('click','#'+widget_id + ' .fapi_del',function () {
		var id = $(this).attr('data-id');
		fapiGetFile(id, 'delete');
	});
	
	$('body').on('click','#'+widget_id + ' .fapi_dndbox', function () {

		$('#'+widget_id + ' .fapi_add_input').trigger('click');

	});
	
    FileAPIobj.fileapi({
			url: fileAPI_preset.actionurl,
            multiple: fileAPI_preset.multiple,
            autoUpload: fileAPI_preset.autoupload,
            accept: fileAPI_preset.accept,
            data: fileAPI_preset.data ,
            maxSize: fileAPI_preset.maxfilesize * FileAPI.MB,
            maxFiles: fileAPI_preset.currentfiles,
			imageOriginal:false,
            elements: {
                    ctrl: { upload: '.fapi_btn_upload_ctrl' , abort:'.fapi_btn_abort_ctrl'},
                    empty: {  hide:'.fapi_btn_reset'},
                    emptyQueue: { hide: '.fapi_btn_upload .fapi_add_preview_btn .fapi_btn_abort' , show: '.fapi_btn_reset'},
                    active: { show:'.fapi_btn_abort', hide: '.fapi_btn_upload, .fapi_btn_upload.fapi_add_preview_btn'},
                    list: '.fapi_upload_files',
                    file: {
                            tpl: '.fapi_tpl',
                            preview: {
                                    el: '.fapi_preview' ,
                                    get: function($el, file){  
                                        $el.append('<i class="fileAPIicon icon_'+file.name.split('.').pop()+'"></i>');
                                    },
                                    width: {PREVIEW_WIDTH},
                                    height: {PREVIEW_HEIGHT}
                            },
                            upload: { show: '.fapi_preview_progress', hide: '.fapi_preview_rotate' },
                            complete: { hide: '.fapi_preview_progress'},
                            progress: '.fapi_preview_progress .fapi_bar'
                    },
                    dnd: {
                       el: '.fapi_dndbox',
                       hover: '.fapi_dndbox_hover',
                       fallback: '.fapi_dndbox-not-supported'
                    }
            },        
            imageTransform:  {IMAGE_TRANSFORM} ,
			onSelect: function (evt, ui){
	
			},
            onFilePrepare:function (evt, uiEvt){
				uiEvt.options.data.uid = uiEvt.xhr.uid;  
            },  
            onFileComplete:function (evt, uiEvt){
                
                var error = uiEvt.error;
                var myerror = uiEvt.result.error;
                var widgetId = uiEvt.widget.__fileId;
				
                if(error){
                    alert(error);
                }
				
                if(myerror){
					
                    $('#'+widget_id + ' [data-id="'+widgetId+'"] div.fapi_error').html(myerror).fadeIn();
                    $('#'+widget_id + ' [data-id="'+widgetId+'"]').delay(fileAPI_preset.timeviewerror).fadeOut('normal',function(){
						
						$('#'+widget_id + ' [data-id="'+widgetId+'"] .fapi_del').trigger('click');
                        
                    });
                    
                }else{

                    var lastid = uiEvt.result.file_info.lastId;

                    if(lastid > 0){
                        fapiGetFile(lastid,'view',widgetId);   
                    }
                }
            }     
   
    });

	function fapiGetFile(id, action,widgetId) {

		var data = fileAPI_preset.data;
		data.id = id;
		data.act = action;
		$.ajax({
			type: "POST",
			url: fileAPI_preset.elementurl,
			data: data,
			success: function (msg) {

				if (action === 'view') {

					fapiCurrentCount(false);
					fapiActionElement.view(msg,id,widgetId);

				}

				if (action === 'delete' && msg === 'delete') {

					fapiCurrentCount(true);
					fapiActionElement.delete(id);

					return true;
				}

			}
		});

	}

	function fapiCurrentCount(act) {

		if(act){
			fileAPI_preset.currentfiles++;
			if (fileAPI_preset.currentfiles === 0){ fileAPI_preset.currentfiles++; }
		}else{
			fileAPI_preset.currentfiles--;
			if (fileAPI_preset.currentfiles === 0){ fileAPI_preset.currentfiles--; }	
		}
		FileAPIobj.fileapi("maxFiles", fileAPI_preset.currentfiles);

		if (fileAPI_preset.currentfiles < 1) {

			$('#'+widget_id + ' .fapi_add_input, .fapi_dndbox').prop('disabled', true);
			$('#'+widget_id + ' .fapi_btn_box, #'+widget_id +' .fapi_dnd_add_btn').addClass('fapi_opacity');

		} else {

			$('#'+widget_id+ ' .fapi_add_input, .fapi_dndbox').prop('disabled', false);
			$('#'+widget_id + ' .fapi_btn_box, #'+widget_id +' .fapi_dnd_add_btn').removeClass('fapi_opacity');
		}

		if (fileAPI_preset.currentfiles == 1 && fileAPI_preset.multiple) {

			FileAPIobj.fileapi("multiple", false);

		} else {

			FileAPIobj.fileapi("multiple", fileAPI_preset.multiple);

		}

	}

	// действия над элементом для данного шаблона	
	var fapiActionElement = function(){
	  return{
		view:function(msg,id,widgetId){

			$('#'+widget_id + ' [data-id="'+widgetId+'"]').replaceWith(msg);
			FileAPIobj.fileapi('remove', widgetId);
			$('#'+widget_id + ' #fapi_thumb_' + id + ' .fapi_ok').show().delay(2000).fadeOut();
		},
		delete:function(id){
			$('#'+widget_id + ' #fapi_thumb_' + id).fadeOut('normal', function () {
				this.remove();
			});
		}
	  }
	}();			
										
});					
</script>
<!-- END: FORM -->

<!-- BEGIN: MAIN --> 
<div class="fapi_display" id="fapi_display">
	
	<!-- BEGIN: ROW --> 

		<!-- IF {TYPE} == 'IMG' -->
			<div class="fapi_images_preview" id="fapi_thumb_{ID}" title="{TITLE}">
				<div class="fapi_ok">&nbsp;</div>
				<div class="fapi_edit_title jqmLink" data-id = "{ID}" data-url="{NAME_EDIT_URL}"></div>
				<div class="fapi_del" data-id = "{ID}">✖</div>
				<a href="{ORIG_URL}" data-lightbox = "roadtrip" data-rel="lightcase:myCollection" target="_blank" title="{TITLE}"><img src="{SRC}" alt="{TITLE}"/></a>
				<div class="sub_preview">
					<div class="fapi_thumb_name" id="fapi_file_name_{ID}">{TITLE}</div>
					<div class="fapi_file_size">{SIZE}</div>
				</div>
			</div>   
		<!-- ELSE -->
			<div class="fapi_images_preview" id="fapi_thumb_{ID}" title="{TITLE}">
				<div class="fapi_ok">&nbsp;</div>
				<div class="fapi_edit_title jqmLink" data-id = "{ID}" data-url="{NAME_EDIT_URL}"></div>
				<div class="fapi_del" data-id = "{ID}">✖</div>
				<a href="{ORIG_URL}"  target="_blank">
					<div class="fapi_preview ">
						<div class="fapi_preview_pic"></div>
						<i class="fileAPIicon icon_{EXT}"></i>
					</div>
				</a>	
				<div class="sub_preview">
					<div class="fapi_thumb_name"  id="fapi_file_name_{ID}">{TITLE}</div>
					<div class="fapi_file_size">{SIZE}</div> 
				</div>
			</div> 
		<!-- ENDIF -->

	<!-- END: ROW -->

</div>
<!-- END: MAIN -->