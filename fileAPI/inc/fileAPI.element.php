<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('fileAPI', 'module');

$id = cot_import('id', 'P', 'INT');
$param['area'] = cot_import('area', 'P', 'ALP');
$param['cat'] = cot_import('cat', 'P', 'ALP');
$param['indf'] = cot_import('indf', 'P', 'ALP');
$thumb_fld = cot_import('thumb_fld', 'P', 'ALP');

$act = cot_import('act', 'P', 'ALP');

if ($id > 0 && $act == 'view')
{
	cot_sendheaders();
	echo get_fileAPI_files($param, $thumb_fld, $id);
}

if ($id > 0 && $act == 'delete')
{
	if (delete_fileAPI_file($id))
	{
		echo 'delete';
	}
}

exit();
