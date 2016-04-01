<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=usertags.main
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */
defined('COT_CODE') or die('Wrong URL');

if (is_array($user_data))
{
	global $R;
	require_once cot_incfile('fileAPI', 'module', 'resources');

	$temp_array['FILEAPI_AVATAR_PATH'] = $cfg['fileAPI']['dir'].'user_image/avatar/';
	$temp_array['FILEAPI_AVATAR_FILE'] = $user_data['user_fileAPI_avatar'];
	$temp_array['FILEAPI_AVATAR_SRC'] = !empty($temp_array['FILEAPI_AVATAR_FILE']) ? $temp_array['FILEAPI_AVATAR_PATH'].$temp_array['FILEAPI_AVATAR_FILE']
			: '';

	$temp_array['FILEAPI_AVATAR'] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_userimg_avatar", array(
			'src' => $temp_array['FILEAPI_AVATAR_SRC'],
			'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_avatar");

	$fapi_preset_avatar = load_fileAPI_preset('avatar');

	if ($fapi_preset_avatar)
	{
		foreach ($fapi_preset_avatar['imagetransform'] as $fkey => $fval)
		{
			if($fval['name'] != 'original'){
			$temp_array['FILEAPI_AVATAR_'.strtoupper($fval['name'])] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_userimg_avatar", array(
					'src' => $temp_array['FILEAPI_AVATAR_PATH'].$fval['name'].'/'.$temp_array['FILEAPI_AVATAR_FILE'],
					'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_avatar");
			}
		}
		unset($fapi_preset_avatar);
	}

	$temp_array['FILEAPI_PHOTO_PATH'] = $cfg['fileAPI']['dir'].'user_image/photo/';
	$temp_array['FILEAPI_PHOTO_FILE'] = $user_data['user_fileAPI_photo'];
	$temp_array['FILEAPI_PHOTO_SRC'] = !empty($temp_array['FILEAPI_PHOTO_FILE']) ? $temp_array['FILEAPI_PHOTO_PATH'].$temp_array['FILEAPI_PHOTO_FILE']
			: '';

	$temp_array['FILEAPI_PHOTO'] = !empty($temp_array['FILEAPI_PHOTO_SRC']) ? cot_rc("fapi_userimg_photo", array(
			'src' => $temp_array['FILEAPI_PHOTO_SRC'],
			'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_photo");

	$fapi_preset_photo = load_fileAPI_preset('photo');
	if ($fapi_preset_photo)
	{
		foreach ($fapi_preset_photo['imagetransform'] as $fkey => $fval)
		{
			if($fval['name'] != 'original'){
			$temp_array['FILEAPI_PHOTO_'.strtoupper($fval['name'])] = !empty($temp_array['FILEAPI_PHOTO_SRC']) ? cot_rc("fapi_userimg_photo", array(
					'src' => $temp_array['FILEAPI_PHOTO_PATH'].$fval['name'].'/'.$temp_array['FILEAPI_PHOTO_FILE'],
					'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_photo");
			}
		}
		unset($fapi_preset_photo);
	}

}

