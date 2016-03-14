<!-- BEGIN: MAIN --> 


<!-- BEGIN: IMG --> 	
<div class='fileAPI_attach_box'>	
	<h3>Прикрепленные изображения</h3>
	<!-- BEGIN: ROW --> 
		<a href="{ORIG_URL}" data-lightbox = "roadtrip" target="_blank" title='{NAME}'  class='fileAPI_thumb'><img src="{SRC}" /></a>
	<!-- END: ROW -->
	<div class='fileAPIclear'></div>
</div>
<!-- END: IMG -->

<!-- BEGIN: FILE --> 
<div class='fileAPI_attach_box'>	
	<h3>Прикрепленные файлы</h3>
	<!-- BEGIN: ROW --> 
		<div class='fileAPI_file_wrap'>
			<i class="fileAPIicon icon_{EXT}"></i>
			<a href="{ORIG_URL}" target='_blank'  class="fapi_file_link">{NAME}</a>
			<div class="fapi_file_size">{SIZE}</div> 
			<div class='fileAPIclear'></div>
		</div>   
	<!-- END: ROW -->
</div>	
<!-- END: FILE -->


<!-- BEGIN: VIEW -->

{IMAGES}

{FILES}

<!-- END: VIEW -->

<!-- END: MAIN -->