<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=forums.posts.delete.done,forums.functions.prunetopics
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

if ($p > 0 && !empty($s))
{
	//удаление поста
	delete_all_fileAPI_file('forum', $p, $s);
}

if (!$p && !empty($section) && $q > 0)
{
	// удаление топика
	$sql_file = $db->query("SELECT fp_id FROM $db_forum_posts WHERE fp_topicid = ? AND fp_cat = ? ", array(
		$q, $section));

	$post_ids = array();
	while ($row_file = $sql_file->fetch())
	{
		$post_ids[] = $row_file['fp_id'];
	}

	if (count($post_ids) > 0)
	{
		foreach ($post_ids as $fkey => $fvalue)
		{
			delete_all_fileAPI_file('forum', $fvalue, $section);
		}
	}
}