<?php
defined('COT_CODE') or die('Wrong URL');

$R['fapi_userimg_avatar'] = '<img src="{$src}" alt=\'{$alt}\' class="avatar" />';
$R['fapi_userimg_photo'] = '<img src="{$src}" alt=\'{$alt}\' class="photo" />';

$R['fapi_userimg_default_avatar'] = '<img src="modules/fileAPI/img/unknown.png" alt="'.$L['Avatar'].'" class="avatar" />';
$R['fapi_userimg_default_photo'] = '<img src="modules/fileAPI/img/unknown.png" alt="'.$L['Photo'].'" class="photo" />';

$R['fapi_page_avatar'] = '<img src="{$src}" alt=\'{$alt}\' class="page_avatar img-responsive" />';

//$R['fapi_page_avatar'] = '<img src="plugins/lazyload/img/gray.gif"  alt="{$alt}" data-original ="{$src}" class="page_avatar img-responsive" />';
$R['fapi_page_editor_link_img'] = '<li><a href="javascript:void(null)" class="fapi_editor_link" data=\'{$data}\' data-link = "1">{$title}</a></li>';
$R['fapi_page_editor_img'] = '<li><a href="javascript:void(null)" class="fapi_editor_link" data=\'{$data}\' >{$title}</a></li>';
$R['fapi_page_editor_link_file'] = '<li><a href="javascript:void(null)" class="fapi_editor_link" data=\'{$data}\' >{$title}</a></li>';