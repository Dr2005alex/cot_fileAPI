<!-- BEGIN: MAIN --> 
<div class="fapi_display" id="fapi_display">
	
	<!-- BEGIN: ROW --> 

		<!-- IF {TYPE} == 'IMG' -->
			<div class="fapi_images_preview" id="fapi_thumb_{ID}" title="{TITLE}">
				<div class="fapi_ok">&nbsp;</div>
				<div class="fapi_edit_title jqmLink" data-id = "{ID}" data-url="{NAME_EDIT_URL}"></div>
				<div class="fapi_del" data-id = "{ID}">✖</div>
				<a href="{ORIG_URL}" data-lightbox = "roadtrip" data-rel="lightcase:myCollection" target="_blank" title="{TITLE}"><img src="{SRC}" alt="{TITLE}"/></a>
				<div class="fapi_thumb_name" id="fapi_file_name_{ID}">{TITLE}</div>
				<div class="fapi_file_size">{SIZE}</div> 
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
		<div class="fade"></div>		</a>	
				<div class="fapi_thumb_name"  id="fapi_file_name_{ID}">{TITLE}</div>
				<div class="fapi_file_size">{SIZE}</div> 
			</div> 
		<!-- ENDIF -->

	<!-- END: ROW -->

</div>

    

<!-- END: MAIN -->