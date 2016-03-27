<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=page.edit.delete.done
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

if($rpage['page_id'] > 0)
{
	delete_all_fileAPI_file('page', $rpage['page_id'], $rpage['page_cat']);

	delete_all_fileAPI_file('page_avatar', $rpage['page_id'], $rpage['page_cat']);
}


