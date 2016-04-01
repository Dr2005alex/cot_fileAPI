<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('extrafields');

cot_extrafield_add(cot::$db_x.'users', 'fileAPI_avatar', 'input');
cot_extrafield_add(cot::$db_x.'users', 'fileAPI_photo', 'input');

