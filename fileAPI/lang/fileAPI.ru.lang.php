<?PHP

/**
 * Plugin Info
 */
$L['info_name'] = 'FileAPI';
$L['info_desc'] = 'Загрузка файлов и изображений.Обработка изображений на стороне пользователя';
$L['info_notes'] = '';


/**
 * Titles
 */
$L['fileAPI_add_files'] = 'Добавить файл';
$L['fileAPI_upload_dnd_files_hint'] = 'Перетащите сюда файлы или кликните';
$L['fileAPI_upload_files_hint'] = 'Нажмите добавить файлы для добавления в очередь';
$L['fileAPI_upload_file'] = 'Загрузить';
$L['fileAPI_upload_file_reset'] = 'Сбросить';
$L['fileAPI_upload_file_abort'] = 'Остановить';
$L['fileAPI_upload_delete_file_conf'] = 'Удалить файл';


/*errors*/

$L['fileAPI_upload_file_error_ext'] = 'Файлы с расширением <span class="lblext">.%1$s</span> запрещены.';



$L['fileAPI_filechecknomime'] = 'Внимание: не найден MIME-тип для файла %1$s. Параметры: %2$s';
$L['fileAPI_filecheckfail'] = 'Внимание: ошибка расширения файла %1$s. Параметры: %2$s';
$L['fileAPI_filemimemissing'] = 'Ошибка загрузки: отсутствует MIME-тип для расширения %1$s';
$L['fileAPI_filenotvalid'] = 'Ошибка проверки %1$s-файла';
$L['fileAPI_file_exists'] = 'Ошибка загрузки: файл с таким именем уже существует';


 /*Setup*/

$L['cfg_filecheck'] = 'Проверка файлов';
$L['cfg_filecheck_hint'] = 'Проверять загружаемые файлы (&laquo;'.$L['PFS'].'&raquo; и профиль) на соответствие их формата используемому расширению. Рекомендуется включить в целях безопасности.';
$L['cfg_nomimepass'] = 'Игнорировать MIME-типы';
$L['cfg_nomimepass_hint'] = 'Разрешить закачку файлов, MIME-тип которых не указан в конфигурации.';
$L['cfg_dir'] = 'Путь к хранилищу файлов';
$L['cfg_lightcase'] = 'Использовать Lightcase для изображений';
$L['cfg_lightcase_hint'] = '<a href="http://cornel.bopp-art.com/lightcase/#demo" target="_blank">Lightcase demo</a>';