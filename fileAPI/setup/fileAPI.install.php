<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('extrafields');
if (cot_module_active('users'))
{
	cot_extrafield_add(cot::$db_x.'users', 'fileAPI_avatar', 'input');
	cot_extrafield_add(cot::$db_x.'users', 'fileAPI_photo', 'input');
}

if (cot_module_active('page'))
{
	cot_extrafield_add(cot::$db_x.'pages', 'fileAPI_avatar', 'input');
}

$arr_preset = array(
	'name' => 'main',
	'autoupload' => '',
	'dnd' => 1,
	'multiple' => 1,
	'maxfiles' => 20,
	'accept' => '',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.main',
	'mode' => '',
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 0,
			'height' => '',
			'watermark_on' => 1,
			'width' => '',
			'src' => '',
			'type' => 'side',
			'pos' => 'BOTTOM_RIGHT',
			'quality' => 0.86,
			'x' => 25,
			'typeimage' => '',
			'y' => 25
		),
		'1' => Array
			(
			'name' => 'thumb',
			'form' => 1,
			'height' => 80,
			'watermark_on' => 0,
			'width' => 80,
			'src' => '',
			'type' => 'crop',
			'pos' => 'BOTTOM_RIGHT',
			'quality' => 0.86,
			'x' => 25,
			'typeimage' => 'image/png',
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_main';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');

$arr_preset = array(
	'name' => 'avatar',
	'autoupload' => '',
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'avatar',
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'height' => 80,
			'watermark_on' => '',
			'width' => 80,
			'src' => '',
			'type' => 'side',
			'pos' => 'BOTTOM_RIGHT',
			'quality' => 0.86,
			'x' => 25,
			'typeimage' => 'image/png',
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_avatar';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');

$arr_preset = array(
	'name' => 'photo',
	'autoupload' => '',
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'photo',
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'height' => 200,
			'watermark_on' => '',
			'width' => 300,
			'src' => '',
			'type' => 'side',
			'pos' => 'BOTTOM_RIGHT',
			'quality' => 0.86,
			'x' => 25,
			'typeimage' => 'image/png',
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_photo';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');

$arr_preset = array(
	'name' => 'page_avatar',
	'autoupload' => '',
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'page_avatar',
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'height' => 200,
			'watermark_on' => '',
			'width' => 620,
			'src' => '',
			'type' => 'side',
			'pos' => 'BOTTOM_RIGHT',
			'quality' => 0.86,
			'x' => 25,
			'typeimage' => 'image/png',
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_page_avatar';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');
