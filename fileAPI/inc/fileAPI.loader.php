<?php
defined('COT_CODE') or die('Wrong URL');

cot_autoload('FileAPI.class');

require_once cot_incfile('uploads');
require_once './datas/extensions.php';
$_downloaded = array();


if (!empty($_SERVER['HTTP_ORIGIN']))
{
	// Enable CORS
	header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type');
	header('Access-Control-Allow-Credentials: true');
}


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
	exit();
}


if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{

	$files = FileAPI::getFiles(); // Retrieve File List
	$ferror_massage = '';
	$file_info = array();

	$param['area'] = cot_import('area', 'P', 'ALP');
	$param['cat'] = cot_import('cat', 'P', 'ALP');
	$param['indf'] = cot_import('indf', 'P', 'ALP');
	$param['mode'] = cot_import('mode', 'P', 'ALP');
	$param['uid'] = cot_import('uid', 'P', 'TXT');

	// Fetch all image-info from files list
	fileAPI_fetch_files($files, $file_info, $param);

	// JSONP callback name
	$callback = cot_import('callback', 'P', 'TXT');
	$jsonp = isset($callback) ? trim($callback) : null;

	// JSON-data for server response
	$json = array(
		'file_info' => $file_info,
		'count' => sizeof($files),
		'area' => $param['area'],
		'cat' => $param['cat'],
		'indf' => $param['indf'],
		'error' => $ferror_massage,
		'jsonp' => $jsonp
	);


	// Server response: "HTTP/1.1 200 OK"
	FileAPI::makeResponse(array(
		'status' => FileAPI::OK,
		'statusText' => 'OK',
		'body' => $json
		), $jsonp);

	exit;
}

function fileAPI_fetch_files($files, &$file_info, $param, $name = 'file')
{
	global $ferror_massage, $_downloaded;

	if (isset($files['tmp_name']))
	{
		$filename = $files['tmp_name'];


		$finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
		$mime = finfo_file($finfo, $filename);
		finfo_close($finfo);

		list($mime) = explode('/', $mime);


		$last_id = fileAPI_create_file($files, $param, $name, $mime);
		$last_id = $last_id ? $last_id : false;

		$file_info = array(
			'type' => $mime,
			'lastId' => $last_id,
			'uid' => $param['uid']
		);
	}
	else
	{

		$orig_file = array(); // содержит оригинал, для его обработки последним

		foreach ($files as $name => $file)
		{
			if ($name == 'original')
			{
				$orig_file = $file;
			}
			else
			{
				fileAPI_fetch_files($file, $file_info, $param, $name);
			}
		}

		if (count($orig_file) > 0)
		{
			fileAPI_fetch_files($orig_file, $file_info, $param, 'original');
		}
	}
}

function fileAPI_create_file($files, $param, $name, $mime = 'mime')
{
	global $cfg, $usr, $sys, $db, $db_fileAPI, $cot_extensions, $ferror_massage, $L, $_downloaded;

	$save_db = true;
	$last_id = false;

	if ($name != 'original' && $mime == 'image')
	{
		$save_db = false;
		$param['thumb_fld'] = $name;
	}

	if ($param['cat'] == 'fileapi_prepare')
	{
		$param['user_folder'] = $usr['id'];
	}

	$file_path = $cfg['fileAPI']['dir'].
		(!empty($param['area']) ? $param['area'].'/' : '').
		(!empty($param['cat']) ? $param['cat'].'/' : '').
		(!empty($param['user_folder']) ? $param['user_folder'].'/' : '').
		(!empty($param['thumb_fld']) ? $param['thumb_fld'].'/' : '');

	$files['name'] = trim(mb_strtolower($files['name']));

	// расширение
	$ext = mb_substr($files['name'], mb_strrpos($files['name'], '.') + 1);

	// имя
	$file_name = mb_substr($files['name'], 0, mb_strrpos($files['name'], '.'));
	$file_name = str_replace(array('php','—','.jpg','.jpeg','.png','.gif','.'), array('p_h_p','-','','','','','_'), $file_name);
	$files['name'] = $file_name.'.'.$ext;

	// безопасное имя
	$pefix_name = ($param['cat'] == 'fileapi_prepare') ? '' : (!empty($param['indf']) ? '_'.$param['indf']
				: '').'_'.$usr['id'];

	if($param['mode'] == 'avatar' || $param['mode'] == 'page_avatar' || $param['mode'] == 'photo'){
		$pefix_name = cot_unique(4).$pefix_name;// решает проблему отображения закешированных браузером нарезанных изображений
	}

	$new_filename = cot_safename($files['name'], true, $pefix_name);

	$sql_filename = mb_substr($new_filename, 0, mb_strrpos($new_filename, '.'));



	if (!empty($param['uid']) && array_key_exists($param['uid'], $_downloaded))
	{
		$sql_filename = $_downloaded[$param['uid']]['name'];
		$new_filename = $_downloaded[$param['uid']]['name'].'.'.$ext;
	}
	else
	{
		$_downloaded[$param['uid']]['name'] = $sql_filename;
	}

	if ($name != 'original' && $mime == 'image')
	{
		$_downloaded[$param['uid']]['prefix'][] = array($name, $ext);
	}

	$ext_ok = 0;

	if ($ext != 'php' && $ext != 'php3' && $ext != 'php4' && $ext != 'php5')
	{
		foreach ($cot_extensions as $k => $line)
		{
			if (mb_strtolower($ext) == $line[0])
			{
				$ext_ok = 1;
			}
		}
	}

	if ($ext_ok && is_uploaded_file($files['tmp_name']))
	{

		$fcheck = check_fileAPI_file($files['tmp_name'], $log_name, $ext, 'area: "'.$param['area'].'", cat: "'.$param['cat'].'", indf: "'.$param['indf'].'"');

		if ($fcheck == 1)
		{

			if (!is_dir($file_path))
			{
				if (!fileAPI_create_path($param))
				{
					$ferror_massage = 'create a path error '.$file_path;
					return;
				}
			}

			$filesize = (int) filesize($files['tmp_name']);

			$is_create = $db->query("SELECT COUNT(*) FROM $db_fileAPI WHERE fa_area = '{$param['area']}' AND fa_cat = '{$param['cat']}'  AND fa_indf = '{$param['indf']}' AND fa_file = '{$sql_filename}'")->fetchColumn();

			if ($is_create > 0)
			{
				$ferror_massage = $L['fileAPI_file_exists'];
				return;
			}

			if (move_uploaded_file($files['tmp_name'], $file_path.$new_filename))
			{

				if ($save_db)
				{

					$prefix = (count($_downloaded[$param['uid']]['prefix']) > 0) ? serialize($_downloaded[$param['uid']]['prefix'])
							: '';

					$file_data = array(
						'fa_userid' => (int) $usr['id'],
						'fa_date' => (int) $sys['now'],
						'fa_file' => cot::$db->prep($sql_filename),
						'fa_extension' => $ext,
						'fa_area' => $param['area'],
						'fa_cat' => $param['cat'],
						'fa_indf' => $param['indf'],
						'fa_prefix' => $prefix,
						'fa_mime' => cot::$db->prep($mime),
						'fa_folderid' => (int) $folderid,
						'fa_desc' => cot::$db->prep($desc),
						'fa_size' => $filesize,
						'fa_count' => 0
					);

					$db->insert($db_fileAPI, $file_data);
					$last_id = $db->lastInsertId();
				}
			}
		}
		elseif ($fcheck == 2)
		{
			$ferror_massage = sprintf($L['fileAPI_filemimemissing'], $ext);
		}
		else
		{
			$ferror_massage = sprintf($L['fileAPI_filenotvalid'], $ext);
		}

		// удаление созданных превью для не корректного оригинала
		if ($fcheck != 1 && $name == 'original' && $mime == 'image')
		{
			foreach ($_downloaded[$param['uid']]['prefix'] as $value)
			{
				if ($value[0] && $value[1])
				{
					@unlink($file_path.$value[0].'/'.$sql_filename.'.'.$value[1]);
				}
			}
		}
	}
	else
	{
		$ferror_massage = sprintf($L['fileAPI_upload_file_error_ext'], $ext);
	}

	/* === Hook === */
	foreach (cot_getextplugins('fileAPI.loader.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	return $last_id;
}

//создание пути для сохранения файла
function fileAPI_create_path($param)
{
	global $cfg;

	$file_path = $cfg['fileAPI']['dir'];

	if (!is_dir($file_path))
	{
		if (!@mkdir($file_path, $cfg['dir_perms']))
		{

			return false;
		}
	}

	if ($param['area'])
	{

		$file_path = $cfg['fileAPI']['dir'].$param['area'].'/';

		if (!is_dir($file_path))
		{
			if (!@mkdir($file_path, $cfg['dir_perms']))
			{

				return false;
			}
		}
	}

	if ($param['cat'])
	{

		$file_path = $cfg['fileAPI']['dir'].$param['area'].'/'.$param['cat'].'/';

		if (!is_dir($file_path))
		{
			if (!@mkdir($file_path, $cfg['dir_perms']))
			{

				return false;
			}
		}
	}

	if ($param['user_folder'])
	{

		$file_path = $cfg['fileAPI']['dir'].$param['area'].'/'.$param['cat'].'/'.$param['user_folder'].'/';

		if (!is_dir($file_path))
		{
			if (!@mkdir($file_path, $cfg['dir_perms']))
			{

				return false;
			}
		}
	}

	if ($param['thumb_fld'])
	{

		$file_path = $cfg['fileAPI']['dir'].$param['area'].'/'.$param['cat'].'/'.(!empty($param['user_folder'])
					? $param['user_folder'].'/' : '' ).$param['thumb_fld'].'/';

		if (!is_dir($file_path))
		{
			if (!@mkdir($file_path, $cfg['dir_perms']))
			{

				return false;
			}
		}
	}
	return true;
}
