<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */
defined('COT_CODE') or die('Wrong URL');

// Environment setup
define('COT_FILEAPI', true);
$env['location'] = 'fileAPI';

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('fileAPI', 'a');
cot_block($usr['auth_read']);

// Self requirements
require_once cot_incfile('fileAPI', 'module');

$m = !$m ? 'main' : $m;


if (in_array($m, array('main', 'element', 'loader','editname')))
{
	require_once cot_incfile('fileAPI', 'module', $m);
}
else
{
	// Error page
	cot_die_message(404);
	exit;
}


