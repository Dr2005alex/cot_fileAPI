<!-- BEGIN: MAIN --> 

<!-- BEGIN: MAIN2 --> 
{PHP.usr.id|fileAPI_files('area:test, cat:alex, indf:$this, type:all','thumb')} 
{PHP.usr.id|fileAPI_form('area:test, cat:photo, indf:$this, preset:main')}		

{PHP.usr.id|fileAPI_form('area:fileAPI, cat:user_pfs, indf:$this, preset:main')}
{PHP.usr.id|fileAPI_form('area:fileAPI, cat:user_avatar, indf:$this, preset:avatar')}
{PHP.usr.id|fileAPI_form('area:user_image, cat:avatar, indf:$this, preset:avatar')}	
{PHP.usr.id|fileAPI_form('area:user_image, cat:photo, indf:$this, preset:photo')}	
 <!-- END: MAIN2 -->
	

	
<div class="container">
	{PHP.usr.id|fileAPI_form('area:test, cat:alex, indf:$this, preset:new')}
	{PHP.usr.id|fileAPI_form('editor:1, area:test, cat:alex, indf:22, preset:new')}	
		
</div>
	
<!-- END: MAIN -->