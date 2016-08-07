<!-- BEGIN: MAIN --> 
<style>
	
.progress-bar {
	position: relative;
	background-color: #1a1a1a;
	height: 25px;
	padding: 1px;
	width: 100%;
	margin: 50px 0;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	-moz-box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
	-webkit-box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
	box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;

}

.progress-bar span {
	position: relative;
	display: block;
	height: 23px;
	width: 200px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	 -moz-box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
	-webkit-box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
	box-shadow: 0 1px 5px #000 inset, 0 1px 0 #444;
	background: green;
}
.progress-bar .lbl{
	position: absolute;
	top:3px;
	left:49%;
	color:#fff;
}
.done{
	padding: 1em;
	background: green;
	color:#fff;
	border:1px solid greenyellow;
}
</style>

<h2>{PHP.L.fileAPI_user_avatar_convert}</h2>
<!-- BEGIN: RESULT --> 

	<h3>{PHP.avatar_count_comlete_title}</h3>

<div class="progress-bar">
    <span style="width: {PHP.percent}%"></span>
	<b class='lbl'>{PHP.percent}%</b>
</div>
<hr style='clear: both;'/>
		<!-- BEGIN: ROW --> 
		
		<div style="display: inline-block; width: 10%; text-align: center; margin:5px; background: #ccc;padding:5px; border:1px solid #fff;">
			<img src="{PATH}" style="max-width: 30px; max-height: 30px;"/>
			<div style="font-size:0.9em;">{USER_NAME}</div>
			<div style="font-size:0.9em;">Seze:{SIZE} kb</div>
			<div style="font-size:0.9em;">Ext:{EXT}</div>
			<div style="font-size:0.9em; color:#fff; background: green; padding:3px;">Converted</div>
		</div>

		<!-- END: ROW -->

<script>
	function fresh() {
		location.reload();
	}
	setInterval("fresh()",1000);
</script>
<hr/>
<!-- END: RESULT -->

<!-- BEGIN: AVATAR --> 
<!-- IF {PHP.avatar_sql_count} > 0 AND {PHP.convert} != 'done' -->
<h3>{PHP.L.fileAPI_user_avatar_find}: {PHP.avatar_count_declension}</h3>
	<div>
		<a href="{PHP|cot_url('admin', 'm=fileAPI&a=convert_avatar&convert=avatar')}" class="btn btn-success special">{PHP.L.fileAPI_user_avatar_convert_title}</a>
	</div>
<!-- ELSE -->	
	<!-- IF {PHP.convert} != 'done' -->
	{PHP.L.fileAPI_user_avatar_nofind}
	<!-- ENDIF -->
<!-- ENDIF -->

	<!-- BEGIN: ROW --> 

	<div style="display: inline-block; width: 10%; text-align: center; margin:5px; background: #ccc;padding:5px; border:1px solid #fff;">
		<img src="{PATH}" style="max-width: 30px; max-height: 30px;"/>
		<div style="font-size:0.9em;">{USER_NAME}</div>
	</div>

	<!-- END: ROW -->

	
<!-- END: AVATAR -->

<!-- BEGIN: COMLETE --> 
<div class='done'>
	<h3>{PHP.L.fileAPI_comlete}</h3>
</div>

<!-- END: COMLETE -->

<!-- END: MAIN -->