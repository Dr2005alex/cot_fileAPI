<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=page.list.before_loop
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

//сохраняем id идентификаторов страниц в списке
foreach ($sqllist_rowset as $value)
{
	$fileAPI_loop_ids['page'][] = $value['page_id'];
	$fileAPI_loop_ids['page_avatar'][] = $value['page_id'];
}



