<!-- BEGIN: MAIN -->
<form action="{ACTION}" id="fapi_editname" method="post" class="ajax post-FapiRes" >
	<h4>Описание файла</h4>
	{INPUT_NAME}<button class="p_send" >OK</button>
	{INPUT_ID}
</form>
<div id="FapiRes"></div>

<!-- BEGIN: DONE -->
<script>
	$('#confirmBox').jqmHide();
	$('#fapi_file_name_' + {ID}).text('{TITLE}');
</script>
<!-- END: DONE -->

<!-- END: MAIN -->