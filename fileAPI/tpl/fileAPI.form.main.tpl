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
                <div class="fapi_btn_box">        
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

<script>
    <!-- IF {DND} -->	
	var btn_box = false;
	<!-- ELSE -->
	var btn_box = true;
	<!-- ENDIF -->
     
     var btn_add = true;
     var btn_abort = true;
     var autoUpload = {AUTOLOAD};
     
     var delay_error =3000;
     var maxFiles = {MAX_FILES};
     var FilesCount = {FILES_COUNT};
     var maxFilesCurrent = {MAX_FILES} - {FILES_COUNT}; 
     
     maxFilesCurrent = maxFilesCurrent > 0 ? maxFilesCurrent : -1;
     
     var fapiobj = $('#FileAPImultiupload');
     
    $(document).on('ready ajaxSuccess',function (){
        
        $('.fapi_del').off('click');
        $('.fapi_del').on('click',function (){
            var id = $(this).attr('data-id');
            fapiGetFile(id,'delete');
        });
        
        if(maxFilesCurrent < 1){
            
            $('#fapi_add_input').prop('disabled', true);

        }else{
            
            $('#fapi_add_input').prop('disabled', false);
        } 
        
    });
    
    $().ready(function () {

       $('.fapi_dndbox').on('click', function(){
           $('#fapi_add_input').trigger('click');
           });
           
           !btn_box && $('.fapi_btn_box').hide();
           !btn_add && $('.fapi_add_btn').hide();
           !btn_abort && $('.fapi_btn_abort').remove();
           autoUpload && $('.fapi_btn_upload').remove();
           !btn_add && $('.fapi_add_btn').hide();
           
           
           fapiHideBtn();
    });
    
    
    
    function fapiHideBtn(){

        if( maxFilesCurrent < 1)
        {   
                $('.fapi_btn_box, .fapi_dnd_add_btn').addClass('fapi_opacity');
        }
        if( maxFilesCurrent >= 1 && btn_box)
        {
            $('.fapi_btn_box, .fapi_dnd_add_btn').removeClass('fapi_opacity');
        } 
    }
    
    function fapiGetFile(id,action){
        
        data = '{DATA_URL}' + '&id='+id+'&x={PHP.sys.xk}&act=' + action ;
       
        $.ajax({
            type: "POST",
            url: '{GET_FILE_URL}',
            data: data,
            success: function (msg) {

                if(action === 'view'){
                    $('#fapi_display').append(msg);
                    $('#fapi_thumb_'+id).hide().fadeIn();
                    $('#fapi_thumb_'+id+' .fapi_ok').show().delay(2000).fadeOut();
                    
                    maxFilesCurrent--;
                    
                        if(maxFilesCurrent === 0){

                            maxFilesCurrent--;

                        }
                    
                    fapiHideBtn();
                    
                    fapiobj.fileapi("maxFiles",maxFilesCurrent);
   
                }
                if(action === 'delete' && msg === 'delete'){
 
                    maxFilesCurrent++;
                    
                        if(maxFilesCurrent === 0){

                            maxFilesCurrent++;

                        }
                    
                    fapiobj.fileapi("maxFiles",maxFilesCurrent);

                    $('#fapi_thumb_'+id).fadeOut('normal',function(){ this.remove(); });

                    fapiHideBtn();

                }
            }

        });
    
    }
    
     fapiobj.fileapi({
			url: '{ACTION}',
            multiple: true,
            autoUpload: autoUpload,
            accept: '{ACCEPT}',
            data: {DATA},
            maxSize: 20 * FileAPI.MB,
            maxFiles: maxFilesCurrent,
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
            imageTransform: {
                'thumb': { width: 80, weight: 80, preview: true },
            },
            onFilePrepare:function (evt, uiEvt){
               
                uiEvt.options.data.fileUID = evt.timeStamp;
                
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
                    $('[data-id="'+widgetId+'"]').delay(delay_error).fadeOut('normal',function(){
                        
                        $('[data-id="'+widgetId+'"] .fapi_del').trigger('click');
                        
                        });
                    
                }else{
                    //console.log(uiEvt.result);

                    var lastid = uiEvt.result.file_info.lastId;

                    if(lastid > 0){
                        
                        $('[data-id="'+widgetId+'"]').fadeOut('fast',function(){
                            $('[data-id="'+widgetId+'"] .fapi_del').trigger('click');
                            fapiGetFile(lastid,'view');
                        });
                        
                    }
                }


            }     
   
    });

</script>
<!-- END: MAIN -->