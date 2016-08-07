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
	//перенесем файлы и добавим категорию
	modify_fileAPI_prepare('page', $id, $rpage['page_cat']);
	modify_fileAPI_prepare('page_avatar', $id, $rpage['page_cat']);
	modify_fileAPI_prepare('page_editor', $id, $rpage['page_cat']);

	// изменяем url вставленных ссылок/изображений/файлов в тексте
	$parsed_text = parser_url_fileAPI_prepare($rpage['page_text'],$id, $rpage['page_cat']);
	$db->update($db_pages, array("page_text" => $parsed_text), "page_id='".(int)$id."'");

}


