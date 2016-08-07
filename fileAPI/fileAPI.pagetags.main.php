<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=pagetags.main
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */
defined('COT_CODE') or die('Wrong URL');

if (is_array($page_data))
{
	global $R;
	require_once cot_incfile('fileAPI', 'module', 'resources');

	$temp_array['FILEAPI_AVATAR_PATH'] = $cfg['fileAPI']['dir'].'page_avatar/'.$page_data['page_cat'].'/';
	$temp_array['FILEAPI_AVATAR_FILE'] = $page_data['page_fileAPI_avatar'];
	$temp_array['FILEAPI_AVATAR_SRC'] = !empty($temp_array['FILEAPI_AVATAR_FILE']) ? $temp_array['FILEAPI_AVATAR_PATH'].$temp_array['FILEAPI_AVATAR_FILE']
			: '';

	$temp_array['FILEAPI_AVATAR'] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_page_avatar", array(
			'src' => $temp_array['FILEAPI_AVATAR_SRC'],
			'alt' => $page_data['page_title'])) : '';

	$fapi_preset_avatar = load_fileAPI_preset('page_avatar');

	if ($fapi_preset_avatar)
	{
		foreach ($fapi_preset_avatar['imagetransform'] as $fkey => $fval)
		{
			if($fval['name'] != 'original'){
			$temp_array['FILEAPI_AVATAR_'.strtoupper($fval['name'])] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_page_avatar", array(
					'src' => $temp_array['FILEAPI_AVATAR_PATH'].$fval['name'].'/'.$temp_array['FILEAPI_AVATAR_FILE'],
					'alt' => $page_data['page_title'])) : '';
			}
		}
		unset($fapi_preset_avatar);
	}

}

