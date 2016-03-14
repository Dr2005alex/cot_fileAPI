<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.config.edit.first
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');

//коррекция не правильного пути
if ($a == 'update' && !empty($_POST))
{

	$_param = &$_POST['dir'];

	if (empty($_param))
	{

		$_param .= $optionslist['dir']['config_default'];
	}
	else
	{

		$_corr_l = mb_strlen($_param);
		$_res = substr($_param, $_corr_l - 1);

		if ($_res !== '/')
		{
			$_param .= '/';
		}
	}
}

