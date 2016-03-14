<!-- BEGIN: MAIN --> 

<div class="fapi_display" id="fapi_display">
	<!-- BEGIN: ROW --> 

		<!-- IF {TYPE} == 'IMG' -->
			<div class="fapi_images_preview" id="fapi_thumb_{ID}" title="{NAME}">
				<div class="fapi_ok">&nbsp;</div>
				<div class="fapi_del" data-id = "{ID}">✖</div>
				<a href="{ORIG_URL}" data-lightbox = "roadtrip" target="_blank"><img src="{SRC}" /></a>
				<div class="fapi_thumb_name">{NAME}</div>
				<div class="fapi_file_size">{SIZE}</div> 
			</div>   
		<!-- ELSE -->
			<div class="fapi_images_preview" id="fapi_thumb_{ID}" title="{NAME}">
				<div class="fapi_ok">&nbsp;</div>

				<div class="fapi_del" data-id = "{ID}">✖</div>
				<a href="{ORIG_URL}"  target="_blank">
					<div class="fapi_preview ">
						<div class="fapi_preview_pic"></div>
						<i class="fileAPIicon icon_{EXT}"></i>
					</div>
				</a>	
				<div class="fapi_thumb_name">{NAME}</div>
				<div class="fapi_file_size">{SIZE}</div> 
			</div> 
		<!-- ENDIF -->

	<!-- END: ROW -->
</div>

    

<!-- END: MAIN -->