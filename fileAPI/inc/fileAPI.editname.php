<?php
defined('COT_CODE') or die('Wrong URL');

$a = cot_import('a', 'G', 'ALP');
$id = cot_import('id', 'G', 'INT');
$api_name = cot_import('api_name', 'P', 'TXT');
$api_id = cot_import('api_id', 'P', 'INT');
cot_sendheaders();


if ($a == 'form' && $id > 0 && COT_AJAX)
{
	require_once cot_incfile('forms');

	$t = new XTemplate(cot_tplfile(array('fileAPI', 'edit', 'name')));

	$data = $db->query("SELECT fa_userid, fa_desc, fa_file FROM $db_fileAPI WHERE  fa_id = ? ", $id)->fetch();

	if ($data['fa_userid'] == $usr['id'] || $usr['isadmin'])
	{
		$name = (!empty($data['fa_desc'])) ? $data['fa_desc'] : $data['fa_file'];
		$t->assign(array(
			"ID" => $id,
			"INPUT_NAME" => cot_inputbox('text', 'api_name', $name, ' id="api_name_'.$id.'"'),
			"INPUT_ID" => cot_inputbox('hidden', 'api_id', $id),
			"ACTION" => cot_url('fileAPI', 'm=editname&a=save&id='.$id.'&x='.$sys['xk'], '', true),
		));

		$t->parse('MAIN');
		$t->out('MAIN');

	}
	exit;
}

if ($a == 'save' && $id > 0 && $api_id == $id && COT_AJAX)
{
	$data = $db->query("SELECT fa_userid, fa_desc, fa_file FROM $db_fileAPI WHERE  fa_id = ? ", $id)->fetch();
	if ($data['fa_userid'] == $usr['id'] || $usr['isadmin'])
	{

		if (!empty($api_name))
		{
			$db->update($db_fileAPI, array('fa_desc' => $api_name), 'fa_id = '.$id);
			$data['fa_desc'] = $api_name;
		}

		$t = new XTemplate(cot_tplfile(array('fileAPI', 'edit', 'name')));
		$t->assign(array(
			"TITLE" => !empty($data['fa_desc']) ? $data['fa_desc'] : $data['fa_file'],
			"NAME_EDIT_URL" => cot_url('fileAPI', 'm=editname&a=form&id='.$id, '', true),
			"ID" => $id
		));
		$t->parse('MAIN.DONE');
		$t->out('MAIN.DONE');
	}
	exit;
}
