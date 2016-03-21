<!-- BEGIN: MAIN --> 
    <div id="FileAPImultiupload" class="fileAPI">

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
                                            <% if( /^image/.test(type) ){ %>
                                                    <div data-fileapi="file.rotate.cw" class="fapi_preview_rotate"></div>
                                            <% } %>
                                            <div class="fapi_preview_progress"><div class="fapi_bar"></div></div>
                                            <div class="fapi_thumb_name"><%-name%></div>
                                            <div class="fapi_file_size"><%-sizeText%></div>
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
                            <input type="file" name="filedata" id="fapi_add_input" />
                    </div>
                    <div class="fapi_btn fapi_btn_upload fapi_btn_upload_ctrl">
                            <span>{PHP.L.fileAPI_upload_file}</span>
                    </div>
                    <div class="fapi_btn fapi_btn_abort fapi_btn_abort_ctrl">
                            <span>{PHP.L.fileAPI_upload_file_abort}</span>
                    </div>   
                </div>     
       
    </div>
					
<script type="text/javascript" src="modules/fileAPI/js/fileAPI.js"></script>						
<script type="text/javascript" src="modules/fileAPI/js/FileAPI/FileAPI.min.js"></script>
<script type="text/javascript" src="modules/fileAPI/js/jquery.fileapi.min.js"></script>
				


<script>
	var FileAPIobj = $('#FileAPImultiupload');
	var fileAPI_preset = {PRESET};	

	
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
                    list: '.fapi_upload_files ',
                    file: {
                            tpl: '.fapi_tpl',
                            preview: {
                                    el: '.fapi_preview',
                                    get: function($el, file){            
                                        $el.append('<i class="fileAPIicon icon_'+file.name.split('.').pop()+'"></i>');
                                    },
                                    width: 80,
                                    height: 80
                            },
                            upload: { show: '.fapi_preview_progress', hide: '.fapi_preview_rotate' },
                            complete: { hide: '.fapi_preview_progress'},
                            progress: '.fapi_preview_progress .fapi_bar'
                    },
                    dnd: {
                       el: '.fapi_dndbox',
                       hover: 'fapi_dndbox_hover',
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
					
                    $('[data-id="'+widgetId+'"] div.fapi_error').html(myerror).fadeIn();
                    $('[data-id="'+widgetId+'"]').delay(fileAPI_preset.timeviewerror).fadeOut('normal',function(){
						
						$('[data-id="'+widgetId+'"] .fapi_del').trigger('click');
                        
                    });
                    
                }else{

                    var lastid = uiEvt.result.file_info.lastId;

                    if(lastid > 0){
                        fapiGetFile(lastid,'view',widgetId);   
                    }
                }
            }     
   
    });
	
// действия над элементом для данного шаблона	
var fapiActionElement = function(){
  return{
    view:function(msg,id,widgetId){
	
		$('[data-id="'+widgetId+'"]').replaceWith(msg);
		FileAPIobj.fileapi('remove', widgetId);
    },
    delete:function(id){
		$('#fapi_thumb_' + id).fadeOut('normal', function () {
			this.remove();
		});
    }
  }
}();			
										
					
</script>
<!-- END: MAIN -->