<!-- BEGIN: MAIN -->
<span id="FapiRes{ID}">
	{INPUT_NAME}<button class="fapi_ajax" data-post = "1" data-ajaxblock = 'FapiRes{ID}' data-getval = 'FapiRes{ID}' data-url='{ACTION}'>OK</button>
	{INPUT_ID}
</span>
<!-- BEGIN: DONE -->

<script>
	$('#fapi_thumb_' + {ID}+ ' .fapi-js-left a').attr('title','{TITLE}');
	$('#fapi_thumb_' + {ID}+ ' .fapi-js-left a img').attr('alt','{TITLE}');
	$('#fapi_edit_name_' + {ID}).html('<a class="fapi-file-name fapi_ajax"  data-url="{NAME_EDIT_URL}" data-ajaxblock="fapi_edit_name_{ID}" >{TITLE}</a>');
</script>
<!-- END: DONE -->

<!-- END: MAIN -->