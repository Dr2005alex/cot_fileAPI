<?php
defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('fileAPI', 'a');
cot_block($usr['auth_read']);

$convert = cot_import('convert', 'G', 'ALP');
$t = new XTemplate(cot_tplfile(array('fileAPI', 'convert')));
$limit = 20;


if ($convert == 'avatar')
{

	$avatar_sql = $db->query("SELECT user_avatar, user_name, user_id FROM $db_users WHERE user_avatar != '' AND (user_fileAPI_avatar is  NULL OR user_fileAPI_avatar = '')  LIMIT $limit ");


	while ($row = $avatar_sql->fetch())
	{
		if (file_exists($row['user_avatar']))
		{

			$size_file = filesize($row['user_avatar']);
			$name_file = basename($row['user_avatar']);
			$ext_file = mb_substr($name_file, mb_strrpos($name_file, '.') + 1);
			$basename_file = basename($name_file, ".".$ext_file);

			$t->assign(array(
				"PATH" => $row['user_avatar'],
				"USER_NAME" => $row['user_name'],
				"SIZE" => $size_file,
				"EXT" => $ext_file
			));
			$t->parse('MAIN.RESULT.ROW');

			$new_file_path = $cfg['fileAPI']['dir'].'user_image/avatar/';
			$new_name = $row['user_id'].'_'.$basename_file;

			if (!is_dir($cfg['fileAPI']['dir']))
			{
				mkdir($cfg['fileAPI']['dir'], $cfg['dir_perms']);
			}

			if (!is_dir($cfg['fileAPI']['dir'].'user_image/'))
			{
				mkdir($cfg['fileAPI']['dir'].'user_image/', $cfg['dir_perms']);
			}

			if (!is_dir($cfg['fileAPI']['dir'].'user_image/avatar/'))
			{
				mkdir($cfg['fileAPI']['dir'].'user_image/avatar/', $cfg['dir_perms']);
			}

			if (copy($row['user_avatar'], $new_file_path.$new_name.'.'.$ext_file))
			{
				//unlink($row['user_avatar']);
			}



			$file_data = array(
				'fa_userid' => (int) $row['user_id'],
				'fa_date' => (int) $sys['now'],
				'fa_file' => cot::$db->prep($new_name),
				'fa_extension' => $ext_file,
				'fa_area' => 'user_image',
				'fa_cat' => 'avatar',
				'fa_indf' => $row['user_id'],
				'fa_prefix' => $prefix,
				'fa_mime' => 'image',
				'fa_folderid' => 0,
				'fa_desc' => '',
				'fa_size' => $size_file,
				'fa_count' => 0
			);

			$db->insert($db_x.'fileAPI', $file_data);
			$db->update(cot::$db_x.'users', array('user_avatar' => '', 'user_fileAPI_avatar' => $new_name.'.'.$ext_file), 'user_id = '.(int) $row['user_id']);
		}
	}

	$avatar_sql_count = $db->query("SELECT COUNT(*) FROM $db_users WHERE user_avatar != '' AND (user_fileAPI_avatar is  NULL OR user_fileAPI_avatar = '') ")->fetchColumn();
	$avatar_count_declension = cot_declension($avatar_sql_count, $L['fileAPI_user_avatar_find_files']);
	$avatar_count_comlete_title = sprintf($L['fileAPI_user_avatar_convert_comlete'], cot_declension($limit, $L['fileAPI_user_avatar_find_files']), $avatar_count_declension);

	$_SESSION['fileAPI_count_convert'] = $_SESSION['fileAPI_count_convert'] + $limit;
	$percent = floor(( $_SESSION['fileAPI_count_convert'] * 100) / $_SESSION['fileAPI_count_start']);


	$t->parse('MAIN.RESULT');

	if ($avatar_sql_count == 0)
	{
		unset($_SESSION['fileAPI_count_start'],$_SESSION['fileAPI_count_convert']);
		cot_redirect(cot_url('admin', 'm=fileAPI&a=convert_avatar&convert=done','',true));

	}else{
		$t->parse('MAIN');
		$adminmain = $t->text('MAIN');
		return;
	}
	//cot_redirect(cot_url('admin', 'm=fileAPI&a=convert_avatar'));
}


$avatar_sql = $db->query("SELECT user_avatar, user_name FROM $db_users WHERE user_avatar != '' AND (user_fileAPI_avatar is  NULL OR user_fileAPI_avatar = '') ");
$avatar_sql_count = $db->query("SELECT COUNT(*) FROM $db_users WHERE user_avatar != '' AND (user_fileAPI_avatar is  NULL OR user_fileAPI_avatar = '') ")->fetchColumn();
$avatar_count_declension = cot_declension($avatar_sql_count, $L['fileAPI_user_avatar_find_files']);


$_SESSION['fileAPI_count_convert'] = 0;
$_SESSION['fileAPI_count_start'] = $avatar_sql_count;


if ($convert == 'view'){

	while ($row = $avatar_sql->fetch())
	{
		$t->assign(array(
			"PATH" => $row['user_avatar'],
			"USER_NAME" => $row['user_name'],
		));
		$t->parse('MAIN.AVATAR.ROW');
	}
}
	$t->parse('MAIN.AVATAR');

if ($convert == 'done'){
	$t->parse('MAIN.COMLETE');
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
