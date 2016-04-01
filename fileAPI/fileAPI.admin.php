<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('fileAPI', 'module');
$t = new XTemplate(cot_tplfile('fileAPI.admin'));

$dt = cot_import('dt', 'P', 'ARR');
$name = cot_import('name', 'G', 'ALP');
$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);

$t->assign(array(
	"ADD_URL" => cot_url('admin', 'm=fileAPI&a=add'),
	"LIST_URL" => cot_url('admin', 'm=fileAPI')
));

function prepare_data($data)
{
	$res = array();
	foreach ($data as $key => $value)
	{
		foreach ($value as $k => $v)
		{
			$res[$k][$key] = $v;
		}
	}
	return $res;
}

if ($a == '')
{
	$data_presets = cot_config_load('fileAPI', true, 'preset');

	if (count($data_presets) > 0)
	{
		foreach ($data_presets as $key => $value)
		{
			$pname = substr($value['name'], 7);
			$t->assign(array(
				"DELETE" => !in_array($pname, array('main', 'avatar', 'photo', 'page_avatar')),
				"NAME" => $pname,
				"EDIT_URL" => cot_url('admin', 'm=fileAPI&a=edit&name='.$value['name']),
				"DELETE_URL" => cot_url('admin', 'm=fileAPI&a=delete&name='.$value['name']),
			));
			$t->parse('MAIN.LIST.ROW');
		}
		$t->parse('MAIN.LIST');
	}
}

if ($a == 'save' || $a == 'update')
{
	$dt['name'] = cot_import($dt['name'], 'D', 'ALP');
	cot_check(empty($dt['name']), 'fileAPI_preset_name_empty', 'dt[name]');
	cot_check($a == 'save' && isset($cfg['fileAPI']['cat_preset']['preset_'.$dt['name']]), 'fileAPI_preset_name_exist', 'dt[name]');
	if ($dt['imagetransform']['name'])
	{
		array_walk($dt['imagetransform']['name'], function(&$data) {
			$data = cot_import($data, 'D', 'ALP');
		});
		$tmp_arr = array();

		foreach ($dt['imagetransform']['name'] as $key => $value)
		{
			cot_check(empty($value), 'fileAPI_preset_preview_name_empty', 'dt[imagetransform][name]['.$key.']');
			cot_check($key > 0 && in_array($value, $tmp_arr), 'fileAPI_preset_preview_name_exist', 'dt[imagetransform][name]['.$key.']');
			$tmp_arr[] = $value;
			if ($key > 0 && $value == 'original')
			{
				unset($dt['imagetransform']['name'][$key]);
			}
		}
	}

	if (!cot_error_found())
	{
		$dt['imagetransform'] = prepare_data($dt['imagetransform']);
		$opt[0]['name'] = 'preset_'.$dt['name'];
		$opt[0]['type'] = 5;
		$opt[0]['default'] = $opt[0]['value'] = json_encode($dt);

		if ($a == 'update')
		{
			cot_config_modify('fileAPI', $opt, true, 'preset');
		}
		else
		{
			cot_config_add('fileAPI', $opt, true, 'preset');
		}
		cot_redirect(cot_url('admin', 'm=fileAPI'));
	}
	else
	{
		$name = $dt['name'];
		$a = $a == 'save' ? 'add' : 'edit';
	}
}

if ($a == 'add' || ($a == 'edit' && !empty($name)))
{

	if ($a == 'edit')
	{

		$dt = json_decode($cfg['fileAPI']['cat_preset'][$name], true);
		$dt['imagetransform'] = prepare_data($dt['imagetransform']);
	}

	$dt['maxfiles'] = (int) $dt['maxfiles'] > 0 ? (int) $dt['maxfiles'] : 20;
	$dt['maxfilesize'] = (int) $dt['maxfilesize'] > 0 ? (int) $dt['maxfilesize'] : 20;
	$dt['timeviewerror'] = (int) $dt['timeviewerror'] > 0 ? (int) $dt['timeviewerror'] : 3000;


	$t->assign(array(
		"ACTION_FORM" => $a == 'edit' ? cot_url('admin', 'm=fileAPI&a=update') : cot_url('admin', 'm=fileAPI&a=save'),
		"P_NAME" => cot_inputbox('text', 'dt[name]', $dt['name'], $a == 'edit' ? 'readonly' : ''),
		"P_AUTO" => cot_radiobox($dt['autoupload'], 'dt[autoupload]', array(true, false), array($L['Yes'],
			$L['No'])),
		"P_DND" => cot_radiobox($dt['dnd'], 'dt[dnd]', array(true, false), array($L['Yes'], $L['No'])),
		"P_MULTIPLE" => cot_radiobox($dt['multiple'], 'dt[multiple]', array(true, false), array($L['Yes'],
			$L['No'])),
		"P_MAXFILES" => cot_inputbox('text', 'dt[maxfiles]', $dt['maxfiles']),
		"P_ACCEPT" => cot_inputbox('text', 'dt[accept]', $dt['accept']),
		"P_MAX_F_SIZE" => cot_inputbox('text', 'dt[maxfilesize]', $dt['maxfilesize']),
		"P_TIME" => cot_inputbox('text', 'dt[timeviewerror]', $dt['timeviewerror']),
		"P_TPL" => cot_inputbox('text', 'dt[tpl]', $dt['tpl']),
		"P_TPL" => cot_selectbox($dt['tpl'], 'dt[tpl]', array('fileAPI.form.main', 'fileAPI.form.avatar'), null, false),
		"P_MODE" => cot_selectbox($dt['mode'], 'dt[mode]', array('avatar', 'photo','page_avatar'), array('Загрузка аватара пользователя',
			'Загрузка фото пользователя','Загрузка аватара страницы')),
	));

	if (count($dt['imagetransform']) > 0)
	{

		$dt['imagetransform'] = prepare_data($dt['imagetransform']);
	}
	else
	{
		$dt['imagetransform'][] = array(
			'name' => 'original',
			'width' => 100,
			'height' => 100,
			'type' => 'crop',
			'quality' => 0.86,
			'typeimage' => 'image/png',
			'form' => true,
			'src' => 'cfg', //watermark
			'pos' => 'BOTTOM_RIGHT', //watermark
			'x' => 15, //watermark
			'y' => 15, //watermark
		);
	}

	foreach ($dt['imagetransform'] as $key => $value)
	{

		$t->assign(array(
			"IT_NAME_TITLE" => $dt['imagetransform'][$key]['name'],
			"IT_NAME" => cot_inputbox('text', 'dt[imagetransform][name][]', $dt['imagetransform'][$key]['name'], ($dt['imagetransform'][$key]['name']
				== 'original' ? 'class="prv_name" readonly' : 'class="prv_name"')),
			"IT_WIDTH" => cot_inputbox('text', 'dt[imagetransform][width][]', $dt['imagetransform'][$key]['width']),
			"IT_HEIGHT" => cot_inputbox('text', 'dt[imagetransform][height][]', $dt['imagetransform'][$key]['height']),
			"IT_TYPE" => cot_selectbox($dt['imagetransform'][$key]['type'], 'dt[imagetransform][type][]', array(
				'crop', 'side', 'stretch'), array('Обрезать', 'По максимальной стороне', 'Растянуть под размер'), false),
			"IT_TYPEIMAGE" => cot_selectbox($dt['imagetransform'][$key]['typeimage'], 'dt[imagetransform][typeimage][]', array(
				'image/png', 'image/jpg'), array('PNG', 'JPG'), true),
			"IT_GUALITY" => cot_inputbox('text', 'dt[imagetransform][quality][]', $dt['imagetransform'][$key]['quality']),
			"IT_FORM" => cot_selectbox($dt['imagetransform'][$key]['form'], 'dt[imagetransform][form][]', array(
				1, 0), array($L['Yes'], $L['No']), false),
			"IT_WATERMARK" => cot_selectbox($dt['imagetransform'][$key]['watermark_on'], 'dt[imagetransform][watermark_on][]', array(
				1, 0), array($L['Yes'], $L['No']), false),
			"IT_WATERMARK_SRC" => cot_inputbox('text', 'dt[imagetransform][src][]', $dt['imagetransform'][$key]['src']),
			"IT_WATERMARK_X" => cot_inputbox('text', 'dt[imagetransform][x][]', $dt['imagetransform'][$key]['x']),
			"IT_WATERMARK_Y" => cot_inputbox('text', 'dt[imagetransform][y][]', $dt['imagetransform'][$key]['y']),
			"IT_WATERMARK_POS" => cot_selectbox($dt['imagetransform'][$key]['pos'], 'dt[imagetransform][pos][]', array(
				'TOP_LEFT', 'TOP_CENTER', 'TOP_RIGHT', 'CENTER_LEFT', 'CENTER_CENTER', 'CENTER_RIGHT', 'BOTTOM_LEFT',
				'BOTTOM_CENTER', 'BOTTOM_RIGHT'), null, false),
		));
		$t->parse('MAIN.FORM.ELEMENT');
	}

	cot_display_messages($t, 'MAIN.FORM');
	$t->parse('MAIN.FORM');
}

if ($a == 'delete' && !empty($name))
{
	cot_config_remove('fileAPI', true, $name, 'preset');
	cot_redirect(cot_url('admin', 'm=fileAPI'));
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
