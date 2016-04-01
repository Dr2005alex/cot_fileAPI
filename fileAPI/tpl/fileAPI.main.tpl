<!-- BEGIN: MAIN --> 
<!-- BEGIN: MAIN2 --> 
{PHP.usr.id|fileAPI_form('area:fileAPI, cat:user_pfs, indf:$this, preset:main')}
{PHP.usr.id|fileAPI_form('area:fileAPI, cat:user_avatar, indf:$this, preset:avatar')}
{PHP.usr.id|fileAPI_form('area:user_image, cat:avatar, indf:$this, preset:avatar')}	
{PHP.usr.id|fileAPI_form('area:user_image, cat:photo, indf:$this, preset:photo')}	
    <!-- END: MAIN2 -->
	
{PHP.usr.id|fileAPI_form('area:test, cat:photo, indf:$this, preset:main')}	
	
<!-- END: MAIN -->