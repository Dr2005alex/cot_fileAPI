<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=page.add.add.done
  [END_COT_EXT]
  ==================== */
/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('fileAPI', 'module');

if($id > 0)
{
	modify_fileAPI_prepare('page', $id, $rpage['page_cat']);
}


