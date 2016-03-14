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

cot_rc_add_file($cfg['modules_dir'].'/fileAPI/js/fileAPI.js');
cot_rc_add_file($cfg['modules_dir'].'/fileAPI/css/fileAPI.css');
cot_rc_add_file($cfg['modules_dir'].'/fileAPI/js/FileAPI/FileAPI.min.js');

// подключить lightbox
if($cfg['fileAPI']['lightbox']){
	cot_rc_add_file($cfg['modules_dir'].'/fileAPI/js/lightbox/css/lightbox.css');
	cot_rc_link_footer($cfg['modules_dir'].'/fileAPI/js/lightbox/js/lightbox.min.js');
}

//cot_rc_add_file($cfg['modules_dir'] . '/fileAPI/js/FileAPI/FileAPI.exif.js');


cot_rc_add_file($cfg['modules_dir'] . '/fileAPI/js/jquery.fileapi.min.js');


//cot_rc_add_file($cfg['modules_dir'] . '/fileAPI/js/jcrop/jquery.Jcrop.min.js');
//cot_rc_add_file($cfg['modules_dir'] . '/fileAPI/js/jcrop/jquery.Jcrop.min.css');
