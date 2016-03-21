<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('fileAPI', 'module');
require_once cot_incfile('fileAPI', 'module', 'preset');

cot::$cfg['fileAPI']['const_param'] = array('area', 'cat', 'indf', 'maxfiles', 'tpl', 'dnd', 'auto',
	'accept', 'loop', 'preset', 'type');

// Registering tables
cot::$db->registerTable('fileAPI');

$fileAPI_loop_ids = array();
$fileAPI_loop_data = array();

cot::$cfg['fileAPI']['preset'] = $fileAPI_preset;

function load_fileAPI_preset($name)
{
	if (!isset(cot::$cfg['fileAPI']['preset'][$name]))
	{
		throw new Exception('Error: Preset not found.');
	}

	// переводим ключи в нижний регистр
	$fileAPI_preset[$name] = array_change_key_case(cot::$cfg['fileAPI']['preset'][$name], CASE_LOWER);

	return $fileAPI_preset[$name];
}

function img_transform_fileAPI_preset_parse($param, &$t)
{
	global $cfg;

	$out = '';
	$array_pos = array('TOP_LEFT', 'TOP_CENTER', 'TOP_RIGHT', 'CENTER_LEFT', 'CENTER_CENTER', 'CENTER_RIGHT',
		'BOTTOM_LEFT', 'BOTTOM_CENTER', 'BOTTOM_RIGHT');

	$form_thumb = array();

	foreach ($param as $key => $value)
	{

		if (!empty($out))
		{
			$out .=", ";
		}
		$value['quality'] = (float) $value['quality'] > 0 ? (float) $value['quality'] : 0.86;
		$value['width'] = (int) $value['width'] > 0 ? (int) $value['width'] : 80;
		$value['height'] = (int) $value['height'] > 0 ? (int) $value['height'] : 80;

		if ($value['form'])
		{
			$form_thumb['code'] = $key;
			$form_thumb['width'] = $value['width'];
			$form_thumb['height'] = $value['height'];
		}

		switch ($value['type'])
		{
			case 'crop':

				$res = " '{$key}' : {quality: {$value['quality']}, width:{$value['width']}, height:{$value['height']}, preview: true";

				break;
			case 'side':

				$res = " '{$key}' : {quality: {$value['quality']},maxWidth:{$value['width']}, maxHeight:{$value['height']}, preview: false";

				break;
			case 'stretch':

				$res = " '{$key}' : {quality: {$value['quality']},width:{$value['width']}, height:{$value['height']}, preview: false";

				break;
			default:

				$res = " '{$key}' :{quality: {$value['quality']} ";

				break;
		}


		if (is_array($value['watermark']))
		{
			$value['watermark']['src'] = $value['watermark']['src'] == 'cfg' || empty($value['watermark']['src'])
					? $cfg['fileAPI']['watermark_src'] : $value['watermark']['src'];

			if (!in_array($value['watermark']['pos'], $array_pos))
			{
				$value['watermark']['pos'] = 'BOTTOM_RIGHT';
			}

			$value['watermark']['x'] = (int) $value['watermark']['x'] ? (int) $value['watermark']['x'] : 15;
			$value['watermark']['y'] = (int) $value['watermark']['y'] ? (int) $value['watermark']['y'] : 15;

			if (!empty($res))
			{
				$res .=", ";
			}
			$res .= "overlay: [{ x: {$value['watermark']['x']}, y: {$value['watermark']['y']}, src: '{$value['watermark']['src']}', rel: FileAPI.Image.{$value['watermark']['pos']} }]";
		}

		$out .= $res."}";
	}
	return array("{".$out."}", $form_thumb);
}

function get_fileAPI_form($param)
{
	global $L, $cfg, $sys;

	// parametr data
	if (!parse_fileAPI_param($param))
	{
		throw new Exception('Error: There are no parameters');
	}

	if (empty($param['indf']) || empty($param['area']))
	{
		throw new Exception('Warning: Missing required parameter (indf or  area)');
	}

	$preset_name = $param['preset'] ? $param['preset'] : 'main';

	$preset = load_fileAPI_preset($preset_name);



	// переопределение параметров preset из тега вызова формы
	if (isset($param['auto']))
	{
		$preset['autoupload'] = (int) $param['auto'] > 0 ? true : false;
	}

	if (isset($param['accept']))
	{
		$preset['accept'] = !empty($param['accept']) ? $param['accept'] : $preset['accept'];
	}
	if (isset($param['maxfiles']))
	{
		$preset['maxFiles'] = (int) $param['maxfiles'] > 0 ? $param['maxfiles'] : $preset['maxFiles'];
	}

	if (isset($param['dnd']))
	{
		$preset['dnd'] = (int) $param['dnd'] > 0 ? true : false;
	}


	// кол. загр. файлов
	$info_loaded = get_count_fileAPI_files($param);

	//accept
	if (!empty($preset['accept']) && $preset['accept'] !== 'all')
	{
		$arraccept = explode(',', $preset['accept']);
		if (count($arraccept) > 0)
		{
			array_walk($arraccept, function(&$item) {
				return $item .='/*';
			});
			$preset['accept'] = implode(',', $arraccept);
		}
	}

	//template
	if (isset($param['accept']))
	{
		$preset['tpl'] = !empty($param['tpl']) ? $param['tpl'] : $preset['tpl'];
	}

	$tpl = empty($preset['tpl']) ? 'fileAPI.form.main' : $preset['tpl'];
	$t = new XTemplate(cot_tplfile($tpl));

	// подготовка данных о трансформации изображений
	if (is_array($preset['imagetransform']) && count($preset['imagetransform']) > 0)
	{
		list($imageTransform, $form_thumb) = img_transform_fileAPI_preset_parse($preset['imagetransform'], $t);
	}

	if ($form_thumb['code'] == 'original')
	{
		$form_thumb['code'] = '';
	}

	$preset['data'] = array('area' => $param['area'], 'cat' => $param['cat'], 'indf' => $param['indf'],
		'x' => $sys['xk'],'thumb_fld' => $form_thumb['code']);

	$preset['actionurl'] = cot_url('fileAPI', 'm=loader', '', true);
	$preset['countloadedfiles'] = (int) $info_loaded['count_files'];
	$preset['maxfiles'] = (int) $preset['maxfiles'] > 0 ? (int) $preset['maxfiles'] : 1000000000000;
	$preset['currentfiles'] = $preset['maxfiles'] - $preset['countloadedfiles'];
	$preset['elementurl'] = cot_url('fileAPI', 'm=element', '', true);

	$t->assign(array(
		"PRESET" => json_encode($preset, JSON_FORCE_OBJECT),
		"IMAGE_TRANSFORM" => $imageTransform,
		"DND" => (bool) $preset['dnd'] ? true : false,
		"DISPLAY" => get_fileAPI_files($param, $form_thumb['code']),

		//"GET_FILE_URL" => cot_url('fileAPI', 'm=element', '', true),
		//"ACTION" => cot_url('fileAPI', 'm=loader', '', true),
		//"FILES_COUNT" => (int) $info_loaded['count_files'],
		//"DATA" => "{".$data.",x:'".cot::$sys['xk']."'}",
		//"DATA_URL" => $data_url."&thumb_fld=".$form_thumb['code'],

		// preset tags
//		"PREVIEW_WIDTH" => $form_thumb['width'],
//		"PREVIEW_HEIGHT" => $form_thumb['height'],
//		"ACCEPT" => $preset['accept'],
//		"AUTOLOAD" => (bool) $preset['autoUpload'] ? 'true' : 'false',
//
//		"MULTIPLE" => (bool) $preset['multiple'] ? 'true' : 'false',
//		"MAX_FILES" => (int) $preset['maxFiles'] > 0 ? (int) $preset['maxFiles'] : 1000000000000,
//		"MAX_FILE_SIZE" => (int) $preset['maxFileSize'] > 0 ? (int) $preset['maxFileSize'] : 20,
//		"TIME_VIEW_ERROR" => (int) $preset['timeViewError'] > 0 ? (int) $preset['timeViewError'] : 3000,
//		"WATERMARK" => (bool) $preset['watermark'] ? 'true' : 'false',

	));

	$t->parse('MAIN');
	return $t->text('MAIN');
}

function get_count_fileAPI_files($param)
{
	global $db, $db_fileAPI;

	$count = $db->query("SELECT COUNT(*) FROM $db_fileAPI WHERE fa_area = '{$param['area']}' AND fa_cat = '{$param['cat']}'  AND fa_indf = '{$param['indf']}' ")->fetchColumn();
	$res = array(
		'count_files' => $count
	);
	return $res;
}

function get_fileAPI_files_loop_data($param, &$ids, &$data, $where)
{
	global $cfg, $usr, $db, $db_fileAPI;

	if (count($ids) > 0)
	{
		$sql = $db->query("SELECT * FROM $db_fileAPI WHERE $where fa_area = '{$param['area']}' AND fa_indf IN (".implode(',', $ids).") ORDER BY fa_id ASC ");

		if ($sql->rowCount())
		{

			while ($row = $sql->fetch())
			{
				$data[$row['fa_indf']][] = $row;
			}
		}
		else
		{
			$data = false;
		}
	}

	unset($ids);
}

function get_fileAPI_files($param, $thumb_dir = '', $last_id = false, $tpl = 'fileAPI.display.line')
{
	global $cfg, $usr, $db, $db_fileAPI, $fileAPI_loop_ids, $fileAPI_loop_data;

	if (!is_array($param))
	{
		parse_fileAPI_param($param);
	}

	$file_data = false;
	$view_all = false;
	$where = '';
	$view_block = '';

	switch ($param['type'])
	{
		case 'image':

			$where = " fa_mime = '".$param['type']."' AND ";
			$view_block = '.IMG';
			break;
		case 'file':

			$where = " fa_mime != 'image' AND ";
			$view_block = '.FILE';
			break;
		case 'all':
			$i = array();
			$i['IMG'] = $i['FILE'] = 0;
			$view_all = true;
			break;
		default:
			break;
	}

	// Режим loop для списков
	if ($param['loop'])
	{
		if (!isset($fileAPI_loop_data[$param['area']]) && $fileAPI_loop_ids[$param['area']])
		{
			// выборка данных прикрепленных файлах в списке сущностей
			get_fileAPI_files_loop_data($param, $fileAPI_loop_ids[$param['area']], $fileAPI_loop_data[$param['area']], $where);
		}

		if (is_array($fileAPI_loop_data[$param['area']][$param['indf']]))
		{
			//Берем данные о прикрепленных файлах к текущей сущности
			$file_data = $fileAPI_loop_data[$param['area']][$param['indf']];
		}
		else
		{
			// нет прикрепленных файлов
			return;
		}
	}
	else
	{
		if (!$last_id)
		{
			// выбор одного файла
			$sql = $db->query("SELECT * FROM $db_fileAPI WHERE $where fa_area = '{$param['area']}' AND fa_cat = '{$param['cat']}'  AND fa_indf = '{$param['indf']}' ORDER BY fa_id ASC ");
		}
		else
		{
			// выбор всех файлов
			$sql = $db->query("SELECT * FROM $db_fileAPI WHERE  fa_id = ? ", $last_id);
		}
		$file_data = $sql->fetchAll();
	}

	$t = new XTemplate(cot_tplfile($tpl));


	if (count($file_data) == 0)
	{
		$t->parse("MAIN");
		return $t->text("MAIN");
	}

	foreach ($file_data as $row)
	{
		$file_path = $cfg['fileAPI']['dir'].$row['fa_area'].'/'.(!empty($row['fa_cat']) ? $row['fa_cat'].'/'
					: '');

		$ext_thumb = $row['fa_extension'];
		if (!empty($row['fa_prefix']) && !empty($thumb_dir))
		{
			$arr = unserialize($row['fa_prefix']);

			if ($arr)
			{
				foreach ($arr as $value)
				{
					if ($value[0] == $thumb_dir && $value[1])
					{
						$ext_thumb = $value[1];
					}
				}
			}
		}

		$add_indf = ($row['fa_cat'] == 'fileapi_prepare' ) ? $row['fa_indf'].'/' : '';

		$filetype = $row['fa_mime'] == 'image' ? 'IMG' : 'FILE';
		$t->assign(array(
			"TYPE" => $filetype,
			"ID" => $row['fa_id'],
			"SRC" => $file_path.$add_indf.($thumb_dir ? $thumb_dir.'/' : '').$row['fa_file'].'.'.$ext_thumb,
			"ORIG_URL" => $file_path.$add_indf.$row['fa_file'].'.'.$row['fa_extension'],
			"NAME" => $row['fa_file'].'.'.$row['fa_extension'],
			"DESC" => $row['fa_desc'],
			"TITLE" => !empty($row['fa_desc']) ? $row['fa_desc'] : $row['fa_file'].'.'.$row['fa_extension'],
			"SIZE" => cot_build_filesize($row['fa_size'], 1),
			"EXT" => $row['fa_extension'],
			"NAME_EDIT_URL" => cot_url('fileAPI', 'm=editname&a=form&id='.$row['fa_id'], '', true),
		));

		if ($view_all)
		{
			$i[$filetype] ++;
			$t->parse("MAIN.".$filetype.".ROW");
		}
		else
		{
			$t->parse("MAIN".$view_block.".ROW");
		}
	}

	if ($last_id > 0)
	{
		return $t->text("MAIN".$view_block.".ROW");
	}

	if ($view_all)
	{
		if ($i['IMG'] > 0) $t->parse("MAIN.IMG");
		if ($i['FILE'] > 0) $t->parse("MAIN.FILE");

		$t->assign(array(
			"IMAGES" => $t->text("MAIN.IMG"),
			"FILES" => $t->text("MAIN.FILE")
		));
		$t->parse("MAIN.VIEW");
		return $t->text("MAIN.VIEW");
	}

	$t->parse("MAIN".$view_block);
	return $t->text("MAIN".$view_block);
}

function parse_fileAPI_param(&$param)
{
	$m = array();

	// уже массив
	if (is_array($param))
	{
		return true;
	}

	//если не строка или нет параметров, то не парсим
	if (!is_string($param) || empty($param))
	{
		return false;
	}

	preg_match_all('/\s*([\w\.\-]+)\s*:\s*([\w\.\-\$]+)\s*?/', mb_strtolower($param), $m);

	$param = array_combine($m[1], $m[2]);

	array_walk($param, function(&$item, $key) {

		if (in_array($key, cot::$cfg['fileAPI']['const_param']))
		{
			if (mb_strpos($item, '$') === 0)
			{

				$body_var = mb_substr($item, 1, mb_strlen($item) - 1);

				$arg = explode('.', $body_var);

				$count_arr = count($arg);

				if ($count_arr > 1)
				{
					// array
					global ${$arg[0]};

					$arr_main = ${$arg[0]};

					switch ($count_arr)
					{
						case 2:
							if (!is_array($arr_main[$arg[1]]))
							{
								$item = $arr_main[$arg[1]];
							}
							else
							{
								throw new Exception('Warning: '.$item.' is an array.');
							}

							break;
						case 3:
							if (!is_array($arr_main[$arg[1]][$arg[2]]))
							{
								$item = $arr_main[$arg[1]][$arg[2]];
							}
							else
							{
								throw new Exception('Warning: '.$item.' is an array.');
							}
							break;

						default:

							throw new Exception('Warning: '.$item.' option is not supported.');

							break;
					}
				}
				else
				{
					// var
					global ${$body_var};

					if (!is_array(${$body_var}))
					{
						$item = (string) ${$body_var};
					}
					else
					{
						throw new Exception('Warning: '.$item.' is an array.');
					}
				}
			}
		}
		else
		{
			throw new Exception('Warning: '.$key.' option is not supported.');
		}
	});

	return true;
}

function check_fileAPI_file($path, $name, $ext, $info)
{
	global $L, $cfg;
	if ($cfg['fileAPI']['filecheck'])
	{
		require './datas/mimetype.php';
		$fcheck = FALSE;
		if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif')))
		{
			$img_size = @getimagesize($path);
			switch ($ext)
			{
				case 'gif':
					$fcheck = isset($img_size['mime']) && $img_size['mime'] == 'image/gif';
					break;

				case 'png':
					$fcheck = isset($img_size['mime']) && $img_size['mime'] == 'image/png';
					break;

				default:
					$fcheck = isset($img_size['mime']) && $img_size['mime'] == 'image/jpeg';
					break;
			}
			$fcheck = $fcheck !== FALSE;
		}
		else
		{
			if (!empty($mime_type[$ext]))
			{
				foreach ($mime_type[$ext] as $mime)
				{
					$content = file_get_contents($path, 0, NULL, $mime[3], $mime[4]);
					$content = ($mime[2]) ? bin2hex($content) : $content;
					$mime[1] = ($mime[2]) ? strtolower($mime[1]) : $mime[1];
					$i++;
					if ($content == $mime[1])
					{
						$fcheck = TRUE;
						break;
					}
				}
			}
			else
			{
				$fcheck = ($cfg['fileAPI']['nomimepass']) ? 1 : 2;
				cot_log(sprintf($L['fileAPI_filechecknomime'], $name, $info), 'sec');
			}
		}
		if (!$fcheck)
		{
			cot_log(sprintf($L['fileAPI_filecheckfail'], $name, $info), 'sec');
		}
	}
	else
	{
		$fcheck = true;
	}

	return($fcheck);
}

function delete_fileAPI_file($id)
{
	global $cfg, $db, $db_fileAPI;

	if ($id > 0)
	{
		$file = $db->query("SELECT * FROM $db_fileAPI WHERE  fa_id = ? ", $id)->fetch();

		if (empty($file['fa_file']))
		{
			return false;
		}

		$file_path = $cfg['fileAPI']['dir'].(!empty($file['fa_area']) ? $file['fa_area'].'/' : '').(!empty($file['fa_cat'])
					? $file['fa_cat'].'/' : '').($file['fa_cat'] == 'fileapi_prepare' ? $file['fa_indf'].'/' : '');

		if (!empty($file['fa_prefix']))
		{
			$arr = unserialize($file['fa_prefix']);

			foreach ($arr as $value)
			{
				if ($value[0] && $value[1])
				{
					$file_ = $file_path.$value[0].'/'.$file['fa_file'].'.'.$value[1];
					if (file_exists($file_)) @unlink($file_);
				}
			}
		}

		$file = $file_path.'/'.$file['fa_file'].'.'.$file['fa_extension'];
		if (file_exists($file)) @unlink($file);

		$db->delete($db_fileAPI, 'fa_id='.$id);

		return true;
	}
}

function delete_all_fileAPI_file($area, $indf, $cat = '')
{
	global $cfg, $db, $db_fileAPI;

	$area = mb_strtolower($area);
	$indf = mb_strtolower($indf);
	$cat = mb_strtolower($cat);

	$sql = $db->query("SELECT * FROM $db_fileAPI WHERE  fa_area = '{$area}' AND fa_indf = '{$indf}' AND fa_cat = '{$cat}' ");

	if ($sql->rowCount() > 0)
	{
		$file_path = $cfg['fileAPI']['dir'].$area.'/'.(!empty($cat) ? $cat.'/' : '');

		while ($row = $sql->fetch())
		{
			$file = $file_path.$row['fa_file'].'.'.$row['fa_extension'];

			if (file_exists($file))
			{
				@unlink($file);
			}

			if (!empty($row['fa_prefix']))
			{
				$arr = unserialize($row['fa_prefix']);

				foreach ($arr as $value)
				{
					if ($value[0] && $value[1])
					{
						$file_ = $file_path.$value[0].'/'.$row['fa_file'].'.'.$value[1];

						if (file_exists($file_))
						{
							@unlink($file_);
						}
					}
				}
			}
		}

		return $db->delete($db_fileAPI, " fa_area = '{$area}' AND fa_indf = '{$indf}' AND fa_cat = '{$cat}' ");
	}

	return false;
}

// перенос файлов из временной папки и модификация параметров в записях в базы данных
function modify_fileAPI_prepare($area, $indf, $cat)
{
	global $db_fileAPI, $usr, $cfg;

	$area = mb_strtolower($area);
	$indf = mb_strtolower($indf);
	$cat = mb_strtolower($cat);

	// есть данные
	if (isset($_SESSION['fileAPI']['prepare'][$area]) && $_SESSION['fileAPI']['prepare'][$area] == cot::$usr['id'])
	{

		$sql = cot::$db->query("SELECT * FROM $db_fileAPI WHERE fa_area = '{$area}' AND fa_cat = 'fileapi_prepare'  AND fa_indf = '{$usr['id']}' ORDER BY fa_id ASC ");

		$file_path = $cfg['fileAPI']['dir'].$area.'/fileapi_prepare/'.$usr['id'].'/';
		$file_newpath = $cfg['fileAPI']['dir'].$area.'/'.(!empty($cat) ? $cat.'/' : '');

		if (!is_dir($file_newpath))
		{
			if (!@mkdir($file_newpath, $cfg['dir_perms']))
			{
				return false;
			}
		}

		while ($row = $sql->fetch())
		{
			$file = $file_path.$row['fa_file'].'.'.$row['fa_extension'];
			$newfile = $file_newpath.$row['fa_file'].'_'.$indf.'_'.$row['fa_userid'].'.'.$row['fa_extension'];

			if (file_exists($file))
			{
				if (copy($file, $newfile))
				{
					@unlink($file);
				}
			}

			if (!empty($row['fa_prefix']))
			{
				$arr = unserialize($row['fa_prefix']);

				foreach ($arr as $value)
				{
					if ($value[0] && $value[1])
					{

						$file_ = $file_path.$value[0].'/'.$row['fa_file'].'.'.$value[1];
						$new_newpath_ = $file_newpath.$value[0].'/';
						$newfile_ = $new_newpath_.$row['fa_file'].'_'.$indf.'_'.$row['fa_userid'].'.'.$value[1];

						if (!is_dir($new_newpath_))
						{
							if (!@mkdir($new_newpath_, $cfg['dir_perms']))
							{
								return false;
							}
						}

						if (file_exists($file_))
						{
							if (@copy($file_, $newfile_))
							{
								@unlink($file_);
							}
						}
					}
				}
			}
		}

		$postfix = '_'.$indf.'_'.cot::$usr['id'];

		if (cot::$db->query("UPDATE $db_fileAPI SET fa_indf = '{$indf}', fa_cat = '{$cat}', fa_file = CONCAT(`fa_file`, '{$postfix}')  WHERE  fa_area = '{$area}' AND fa_cat = 'fileapi_prepare'  AND fa_indf = '{$usr['id']}' "))
		{
			unset($_SESSION['fileAPI']['prepare'][$area]);

			if (is_dir($file_path))
			{
				cot_rmdir($file_path);
			}

			return true;
		}

		return false;
	}
}
