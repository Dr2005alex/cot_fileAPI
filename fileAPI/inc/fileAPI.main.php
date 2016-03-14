<?php

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('fileAPI', 'a');
cot_block($usr['auth_read']);

require_once $cfg['system_dir'] . '/header.php';

$t = new XTemplate(cot_tplfile(array('fileAPI')));


$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';
