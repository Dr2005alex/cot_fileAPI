<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=fileAPI.delete.element.done
  [END_COT_EXT]
  ==================== */
/**
 * @package fileAPI
 * @author Dr2005alex
 * @copyright Copyright (c) 2016 Dr2005alex http://mycotonti.ru
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');

if ($param['mode'] == 'avatar' && $param['cat'] == 'avatar' && (int)$param['indf'] > 0)
{

	$db->update(cot::$db_x.'users',array('user_fileAPI_avatar' => ''),'user_id = '.(int)$param['indf']);

}

if ($param['mode'] == 'photo' && $param['cat'] == 'photo' && (int)$param['indf'] > 0)
{

	$db->update(cot::$db_x.'users',array('user_fileAPI_photo' => ''),'user_id = '.(int)$param['indf']);

}
