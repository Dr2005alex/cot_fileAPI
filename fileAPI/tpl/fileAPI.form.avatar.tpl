<!-- BEGIN: FORM --> 

<div id="userpic{PRESET_NAME}" class="fileAPI userpic userpic_{PRESET_NAME}">
	<div class="userpic__preview <!-- IF !{COUNT} --> bgd <!-- ENDIF --> ">
		{DISPLAY}
		<div class="js-preview"></div>
	</div>
   <div class="fapi_preview_progress"><div class="fapi_bar"></div></div>
   <div class="fapi_add_btn">
      <div class="js-browse">
         <span class="btn-txt">Выбрать</span>
         <input type="file" name="filedata">
      </div>
   </div>
</div>	

<style>
	.fileAPI.userpic_{PRESET_NAME} {height: {PREVIEW_HEIGHT}px; width: {PREVIEW_WIDTH}px;}
</style>


<script>
$().ready(function () {
	var widget_id = 'userpic{PRESET_NAME}';
	var FileAPIobj = $('#'+widget_id);
	var fileAPI_preset = {PRESET};	

	if(fileAPI_preset.currentfiles < 1){			
		$('#'+widget_id+' .fapi_add_btn').hide();
	}	
	
	$('body').on('click','#'+widget_id+' .fapi_del',function () {
		var id = $(this).attr('data-id');
		fapiGetFile(id, 'delete');
	});
	
	$('body').on('click','.js-close',function () {
		$.modal().close();
		FileAPIobj.fileapi('clear');
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
				empty: {  hide:'.fapi_preview_progress'},
				active: { show: '.js-upload, .fapi_preview_progress', hide: '.js-browse' },
				preview: {
				   el: '.js-preview',
				   width: {PREVIEW_WIDTH},
				   height: {PREVIEW_HEIGHT}
				},
				progress: '.fapi_preview_progress .fapi_bar'
			},
           imageTransform:  {IMAGE_TRANSFORM} ,
			onFilePrepare:function (evt, uiEvt){
					uiEvt.options.data.uid = uiEvt.xhr.uid; 
			},
            onFileComplete:function (evt, uiEvt){
				var error = uiEvt.error;
				var myerror = uiEvt.result.error;
				var widgetId = uiEvt.widget.__fileId; 
                if(error){
                    alert(error);
                }else{
                    var lastid = uiEvt.result.file_info.lastId;

                    if(lastid > 0){
						
                        fapiGetFile(lastid,'view',widgetId);   
                    }
				}
			
            },     
			onSelect: function (evt, ui){
			   var file = ui.files[0];
			   if( !FileAPI.support.transform ) {
				  alert('Your browser does not support Flash :(');
			   }
			   else if( file ){
				  $('#popup').modal({
					 closeOnEsc: true,
					 closeOnOverlayClick: false,
					 onOpen: function (overlay){
						$(overlay).on('click', '.js-upload', function (){
						   $.modal().close();
							 FileAPIobj.fileapi('upload');
						});

						$('.js-img', overlay).cropper({
						   file: file,
						   bgColor: '#fff',
						   maxSize: [$(window).width()-100, $(window).height()-100],
						   minSize: [{PREVIEW_WIDTH}, {PREVIEW_HEIGHT}],
						   selection: '90%',
						   onSelect: function (coords){
							  FileAPIobj.fileapi('crop', file, coords);
						   }
						});
					 }
				  }).open();

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

			$('#'+widget_id+' #fapi_add_input, #'+widget_id+' .fapi_dndbox').prop('disabled', true);
			$('#'+widget_id+' .fapi_btn_box, #'+widget_id+' .fapi_dnd_add_btn').addClass('fapi_opacity');

		} else {

			$('#'+widget_id+' #fapi_add_input, #'+widget_id+' .fapi_dndbox').prop('disabled', false);
			$('#'+widget_id+' .fapi_btn_box, #'+widget_id+ ' .fapi_dnd_add_btn').removeClass('fapi_opacity');
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
			FileAPIobj.children('.userpic__preview').html(msg);
			$('#'+widget_id+' .fapi_add_btn').hide();
			$('#'+widget_id+' .userpic__preview').removeClass('bgd');
		},
		delete:function(id){
			$('#'+widget_id+' #fapi_thumb_' + id).fadeOut('normal', function () {
				this.remove();
			});
			$('#'+widget_id+' .userpic__preview').addClass('bgd');
			$('#'+widget_id+' .fapi_add_btn').show();
		}
	  }
	}();

});	
	


</script>

<div id="popup" class="popup" style="display: none;">
	<div class="popup__body"><div class="js-img"></div></div>
	<div style="margin: 0 0 5px; text-align: center;">
		<div class="js-upload fapi_btn">{PHP.L.fileAPI_upload_file}</div>
		<div class="js-close fapi_btn fapi_btn-close">{PHP.L.Cancel}</div>
	</div>
</div>
<!-- END: FORM -->


<!-- BEGIN: MAIN --> 

	
	<!-- BEGIN: ROW --> 

		<!-- IF {TYPE} == 'IMG' -->
			<div id="fapi_thumb_{ID}" class="fapi_avatar" title="{TITLE}">
				<div class="fapi_del" data-id = "{ID}">✖</div>
				<img src="{SRC}" alt="{TITLE}"/>
			</div>   
		<!-- ENDIF -->

	<!-- END: ROW -->


<!-- END: MAIN -->