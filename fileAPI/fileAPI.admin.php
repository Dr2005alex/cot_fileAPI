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
$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);




if($a == 'convert_avatar'){
	$adminpath[] = $L['fileAPI_user_avatar_convert_title'];
	require_once cot_incfile('fileAPI', 'module','convert');
	return;
}

$t = new XTemplate(cot_tplfile('fileAPI.admin'));

$dt = cot_import('dt', 'P', 'ARR');
$name = cot_import('name', 'G', 'ALP');


$t->assign(array(
	"ADD_URL" => cot_url('admin', 'm=fileAPI&a=add'),
	"LIST_URL" => cot_url('admin', 'm=fileAPI'),
	"CONVERT_URL" => cot_url('admin', 'm=fileAPI&a=convert_avatar')
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
				"DELETE" => !in_array($pname, array('main', 'avatar', 'photo', 'page_avatar', 'page_editor')),
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
	$dt['tpl'] = 'fileAPI.form.'.$dt['tpl'].(!empty($dt['tpl_add']) ? '.'. $dt['tpl_add'] : '');
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
		$opt = array();
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
		if ($cache){
			$cache->db->clear();
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

	$tpl_arr = array();
	$tpl_arr[] = 'main';
	$tpl_arr[] = 'avatar';

	$mode_arr = array('avatar', 'photo','page_avatar');
	$mode_arr_title = $L['fileAPI_preset_mode_value'];

	if(strpos($dt['tpl'], 'fileAPI.form.main') === 0){
		$dt['tpl'] = 'main';
	}
	if(strpos($dt['tpl'], 'fileAPI.form.avatar') === 0){
		$dt['tpl'] = 'avatar';
	}


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
		"P_TPL_ADD" => cot_inputbox('text', 'dt[tpl_add]', $dt['tpl_add'],'id="tpl_add"'),
		"P_TPL" => cot_selectbox($dt['tpl'], 'dt[tpl]', $tpl_arr, null, false,'id="select_tpl"'),
		"P_CROPPER" => cot_radiobox($dt['cropper'], 'dt[cropper]', array(true, false), array($L['Yes'], $L['No']),'id="select_crop_mode"'),
		"P_MODE" => cot_selectbox($dt['mode'], 'dt[mode]', $mode_arr, $mode_arr_title),
	));

	if (count($dt['imagetransform']) > 0)
	{

		$dt['imagetransform'] = prepare_data($dt['imagetransform']);
	}
	else
	{
		$dt['imagetransform'][] = array(
			'name' => 'original',
			'width' => 800,
			'height' => 600,
			'type' => 'crop',
			'quality' => 0.86,
			'typeimage' => '',
			'form' => true,
			'watermark_on' => false,//watermark
			'src' => '', //watermark
			'pos' => 0, //watermark
			'x' => 15, //watermark
			'y' => 15, //watermark
		);
	}

	foreach ($dt['imagetransform'] as $key => $value)
	{

		$t->assign(array(
			"IT_NAME_TITLE" => $dt['imagetransform'][$key]['name'],
			"IT_NAME" => cot_inputbox('text', 'dt[imagetransform][name][]', $dt['imagetransform'][$key]['name'], ($dt['imagetransform'][$key]['name']
				== 'original' ? 'data-mark="prv_name" readonly' : 'data-mark="prv_name" ')),
			"IT_WIDTH" => cot_inputbox('text', 'dt[imagetransform][width][]', $dt['imagetransform'][$key]['width']),
			"IT_HEIGHT" => cot_inputbox('text', 'dt[imagetransform][height][]', $dt['imagetransform'][$key]['height']),
			"IT_TYPE" => cot_selectbox($dt['imagetransform'][$key]['type'], 'dt[imagetransform][type][]', array(
				'crop', 'side', 'stretch'), array('Обрезать', 'По максимальной стороне', 'Растянуть под размер'), false),
			"IT_TYPEIMAGE" => cot_selectbox($dt['imagetransform'][$key]['typeimage'], 'dt[imagetransform][typeimage][]', array(
				'image/png', 'image/jpeg'), array('png', 'jpeg'), true),
			"IT_GUALITY" => cot_inputbox('text', 'dt[imagetransform][quality][]', $dt['imagetransform'][$key]['quality']),
			"IT_FORM" => cot_selectbox($dt['imagetransform'][$key]['form'], 'dt[imagetransform][form][]', array(
				1, 0), array($L['Yes'], $L['No']), false),
			"IT_WATERMARK" => cot_selectbox($dt['imagetransform'][$key]['watermark_on'], 'dt[imagetransform][watermark_on][]', array(
				1, 0), array($L['Yes'], $L['No']), false),
			"IT_WATERMARK_SRC" => cot_inputbox('text', 'dt[imagetransform][src][]', $dt['imagetransform'][$key]['src']),
			"IT_WATERMARK_X" => cot_inputbox('text', 'dt[imagetransform][x][]', $dt['imagetransform'][$key]['x']),
			"IT_WATERMARK_Y" => cot_inputbox('text', 'dt[imagetransform][y][]', $dt['imagetransform'][$key]['y']),
			"IT_WATERMARK_POS" => cot_selectbox($dt['imagetransform'][$key]['pos'], 'dt[imagetransform][pos][]',array(0,1,2,3,4,5,6,7,8), array(
				'TOP_LEFT', 'TOP_CENTER', 'TOP_RIGHT', 'CENTER_LEFT', 'CENTER_CENTER', 'CENTER_RIGHT', 'BOTTOM_LEFT',
				'BOTTOM_CENTER', 'BOTTOM_RIGHT'), false),
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
