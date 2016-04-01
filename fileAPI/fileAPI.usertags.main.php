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
	global $R, $fileAPI_preset;
	require_once cot_incfile('fileAPI', 'module', 'resources');
	require_once cot_incfile('fileAPI', 'module', 'preset');


	$temp_array['FILEAPI_AVATAR_PATH'] = $cfg['fileAPI']['dir'].'user_image/avatar/';
	$temp_array['FILEAPI_AVATAR_FILE'] = $user_data['user_fileAPI_avatar'];
	$temp_array['FILEAPI_AVATAR_SRC'] = !empty($temp_array['FILEAPI_AVATAR_FILE']) ? $temp_array['FILEAPI_AVATAR_PATH'].$temp_array['FILEAPI_AVATAR_FILE']
			: '';

	$temp_array['FILEAPI_AVATAR'] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_userimg_avatar", array(
			'src' => $temp_array['FILEAPI_AVATAR_SRC'],
			'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_avatar");


	if ($fileAPI_preset['avatar'])
	{
		$fileAPI_preset['avatar'] = array_change_key_case($fileAPI_preset['avatar'], CASE_LOWER);

		foreach ($fileAPI_preset['avatar']['imagetransform'] as $fkey => $fval)
		{
			if($fkey != 'original'){
			$temp_array['FILEAPI_AVATAR_'.strtoupper($fkey)] = !empty($temp_array['FILEAPI_AVATAR_SRC']) ? cot_rc("fapi_userimg_avatar", array(
					'src' => $temp_array['FILEAPI_AVATAR_PATH'].$fkey.'/'.$temp_array['FILEAPI_AVATAR_FILE'],
					'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_avatar");
			}
		}
	}

	$temp_array['FILEAPI_PHOTO_PATH'] = $cfg['fileAPI']['dir'].'user_image/photo/';
	$temp_array['FILEAPI_PHOTO_FILE'] = $user_data['user_fileAPI_photo'];
	$temp_array['FILEAPI_PHOTO_SRC'] = !empty($temp_array['FILEAPI_PHOTO_FILE']) ? $temp_array['FILEAPI_PHOTO_PATH'].$temp_array['FILEAPI_PHOTO_FILE']
			: '';

	$temp_array['FILEAPI_PHOTO'] = !empty($temp_array['FILEAPI_PHOTO_SRC']) ? cot_rc("fapi_userimg_photo", array(
			'src' => $temp_array['FILEAPI_PHOTO_SRC'],
			'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_photo");


	if ($fileAPI_preset['photo'])
	{
		$fileAPI_preset['photo'] = array_change_key_case($fileAPI_preset['photo'], CASE_LOWER);

		foreach ($fileAPI_preset['photo']['imagetransform'] as $fkey => $fval)
		{
			if($fkey != 'original'){
			$temp_array['FILEAPI_PHOTO_'.strtoupper($fkey)] = !empty($temp_array['FILEAPI_PHOTO_SRC']) ? cot_rc("fapi_userimg_photo", array(
					'src' => $temp_array['FILEAPI_PHOTO_PATH'].$fkey.'/'.$temp_array['FILEAPI_PHOTO_FILE'],
					'alt' => $user_data['user_name'])) : cot_rc("fapi_userimg_default_photo");
			}
		}
	}

}

