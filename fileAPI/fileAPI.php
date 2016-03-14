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


// Self requirements
require_once cot_incfile('fileAPI', 'module');

$m = !$m ? 'main' : $m;


if (in_array($m, array('main', 'element', 'loader')))
{
	require_once cot_incfile('fileAPI', 'module', $m);
}
else
{
	// Error page
	cot_die_message(404);
	exit;
}


