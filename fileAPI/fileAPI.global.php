<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=global
  [END_COT_EXT]
  ==================== */
/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */
defined('COT_CODE') or die('Wrong URL');


if (!function_exists('fileAPI_form'))
{

	function fileAPI_form($param,$mytpl = false)
	{
		global $L, $ext_array;
		if (!function_exists('get_fileAPI_form'))
		{
			require_once cot_incfile('fileAPI', 'module');
		}

		return get_fileAPI_form($param, $mytpl);
	}
}

//if (!function_exists('fileAPI_prepare'))
//{
//
//	function fileAPI_prepare($area, $add_indf = false)
//	{
//		$add = $add_indf ? '_'.$add_indf : '';
//		cot::$cfg['fileAPI']['prepare'][$area] = 'area: '.$area.', cat:fileapi_prepare, indf: '.cot::$usr['id'].$add;
//		$_SESSION['fileAPI']['prepare'][$area] = cot::$usr['id'].$add;
//	}
//}

if (!function_exists('fileAPI_files'))
{

	function fileAPI_files($param, $thumb_dir = '', $tpl = 'fileAPI.display.view')
	{

		global $L;

		if (!function_exists('get_fileAPI_files'))
		{
			require_once cot_incfile('fileAPI', 'module');
		}

		return get_fileAPI_files($param, $thumb_dir, false, $tpl);
	}
}

function load_fileAPI_preset($name)
{
	if (!isset(cot::$cfg['fileAPI']['cat_preset']['preset_'.$name]))
	{
		throw new Exception('Error: Preset not found.');
	}
	return json_decode(cot::$cfg['fileAPI']['cat_preset']['preset_'.$name], true);
}

function exist_fileAPI_file($path)
{

	return file_exists($path);
}
