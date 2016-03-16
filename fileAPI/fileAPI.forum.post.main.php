<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=forums.posts.main
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


$sql_forums_file_API = $db->query("SELECT p.*, u.* $join_columns
	FROM $db_forum_posts AS p LEFT JOIN $db_users AS u ON u.user_id=p.fp_posterid $join_condition
	WHERE " . implode(' AND ', $where) . $orderlimit);

//сохраняем id идентификаторов постов в топике
foreach ($sql_forums_file_API->fetchAll() as $value)
{
	$fileAPI_loop_ids['forum'][] = $value['fp_id'];
}

unset($sql_forums_file_API);



