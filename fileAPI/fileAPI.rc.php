<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=rc
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');

cot_rc_add_file($cfg['modules_dir'].'/fileAPI/css/fileAPI.css');

// подключить lightcase
if($cfg['fileAPI']['lightcase']){
	cot_rc_add_file($cfg['modules_dir'].'/fileAPI/js/lightcase/css/lightcase.css');
	cot_rc_link_footer($cfg['modules_dir'].'/fileAPI/js/lightcase/js/lightcase.js');
	cot_rc_embed($code);
	cot_rc_embed("

		$(document).on('ready ajaxSuccess',function (){
		$('a[data-rel^=lightcase]').lightcase({
				maxWidth:1600,
				maxHeight: 1200,
				slideshow: true,
				showCaption: false
			});
		});
	"
	);
}


