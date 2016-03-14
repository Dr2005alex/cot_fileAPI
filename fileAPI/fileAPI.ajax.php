<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=ajax
  [END_COT_EXT]
  ==================== */
/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */
defined('COT_CODE') or die('Wrong URL');

$inc = cot_import('inc', 'G', 'ALP');

if (in_array($inc, array('loader', 'element')))
{

	require_once cot_incfile('fileAPI', 'plug', $inc);
}
else
{

	exit();
}

