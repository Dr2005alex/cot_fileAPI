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
				'width' => '',
				'height' => '',
				'watermark_on' => 1,
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
				'width' => 80,
				'height' => 80,
				'watermark_on' => 0,
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
	'autoupload' => 1,
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'avatar',
	'cropper' => 1,
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'width' => 80,
			'height' => 80,
			'type' => 'crop',
			'quality' => 0.86,
			'typeimage' => '',
			'watermark_on' => '',
			'src' => '',
			'pos' => 'BOTTOM_RIGHT',
			'x' => 25,
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
	'autoupload' => 1,
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'photo',
	'cropper' => 1,
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'width' => 300,
			'height' => 200,
			'typeimage' => '',
			'type' => 'crop',
			'quality' => 0.86,
			'watermark_on' => '',
			'src' => '',
			'pos' => 'BOTTOM_RIGHT',
			'x' => 25,
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
	'autoupload' => 1,
	'dnd' => '',
	'multiple' => '',
	'maxfiles' => 1,
	'accept' => 'image',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.avatar',
	'mode' => 'page_avatar',
	'cropper' => 1,
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'width' => 600,
			'height' => 400,
			'type' => 'crop',
			'quality' => 0.86,
			'typeimage' => '',
			'watermark_on' => 1,
			'src' => '',
			'pos' => 'BOTTOM_RIGHT',
			'x' => 25,
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_page_avatar';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');

$arr_preset = array(
	'name' => 'page_editor',
	'autoupload' => 1,
	'dnd' => 1,
	'multiple' => 1,
	'maxfiles' => 20,
	'accept' => '',
	'maxfilesize' => 20,
	'timeviewerror' => 3000,
	'tpl' => 'fileAPI.form.main',
	'mode' => '',
	'cropper' => 0,
	'imagetransform' => Array
		(
		'0' => Array
			(
			'name' => 'original',
			'form' => 1,
			'width' => 600,
			'height' => 400,
			'type' => 'crop',
			'quality' => 0.86,
			'typeimage' => '',
			'watermark_on' => 1,
			'src' => '',
			'pos' => 'BOTTOM_RIGHT',
			'x' => 25,
			'y' => 25
		)
	)
);

$opt[0]['name'] = 'preset_page_editor';
$opt[0]['type'] = 5;
$opt[0]['default'] = json_encode($arr_preset);
cot_config_add('fileAPI', $opt, true, 'preset');
