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

	function fileAPI_form($param)
	{
		global $L;
		if (!function_exists('get_fileAPI_form'))
		{
			require_once cot_incfile('fileAPI', 'module');
		}

		return get_fileAPI_form($param);
	}
}

if (!function_exists('fileAPI_prepare'))
{

	function fileAPI_prepare($area)
	{

		cot::$cfg['fileAPI']['prepare'][$area] = 'area: '.$area.', cat:fileapi_prepare, indf: '.cot::$usr['id'];
		$_SESSION['fileAPI']['prepare'][$area] = cot::$usr['id'];
	}
}

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