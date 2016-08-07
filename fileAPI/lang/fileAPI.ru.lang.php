<?PHP

/**
 * Plugin Info
 */
$L['info_name'] = 'FileAPI';
$L['info_desc'] = 'Загрузка файлов и изображений. Обработка изображений на стороне пользователя';
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

/**
 * Preset
 */
$L['fileAPI_preset'] = 'Пресет';
$L['fileAPI_preset_title'] = 'Пресеты fileAPI';
$L['fileAPI_preset_add'] = 'Создать новый пресет';
$L['fileAPI_preset_list'] = 'Показать список пресетов';
$L['fileAPI_preset_main_setup_form'] = 'Основные настройки формы';
$L['fileAPI_preset_name'] = 'Имя пресета';
$L['fileAPI_preset_name_info'] = 'Имя должно быть в нижнем регистре и состоять из латинских букв. Допустим знак подчеркивания';
$L['fileAPI_preset_autoload'] = 'Автозагрузка файлов';
$L['fileAPI_preset_dnd_info'] = 'Включить поддержку выбора файлов путем перетаскивания.';
$L['fileAPI_preset_multiple'] = 'Множественный выбор';
$L['fileAPI_preset_multiple_info'] = 'Включить множественный выбор файлов.';
$L['fileAPI_preset_maxfiles'] = 'Количество файлов';
$L['fileAPI_preset_maxfiles_info'] = 'Максимальное количество прикрепляемых файлов. Изображения + файлы.';
$L['fileAPI_preset_accept'] = 'Фильтр типов файлов для загрузки';
$L['fileAPI_preset_accept_info'] = 'При открытии окна выбора будут отображаться только данный тип файлов.
					Через запятую, если несколько. (image, audio, video, application)  Оставить пустым для отключения фильтра.';
$L['fileAPI_preset_max_file_size'] = 'Максимальный размер одного файла';
$L['fileAPI_preset_max_file_size_info'] = 'Максимально допустимый размер одного загружаемого файла.';
$L['fileAPI_preset_time_error'] = 'Время отображения ошибки';
$L['fileAPI_preset_time_error_info'] = 'Время отображения ошибки в мс.';
$L['fileAPI_preset_tpl'] = 'Tpl файл формы';
$L['fileAPI_preset_cropper'] = 'Включить возможность редактирования изображения (cropper)';
$L['fileAPI_preset_mode'] = 'Режим';
$L['fileAPI_preset_preview_set'] = 'Настройки превью';
$L['fileAPI_preset_orig_set'] = 'Настройки оригинального изображения';
$L['fileAPI_preset_preview_name'] = 'Имя превью';
$L['fileAPI_preset_preview_add'] = 'Добавить превью';
$L['fileAPI_preset_preview_form'] = 'Использовать как превью в форме';
$L['fileAPI_preset_param'] = 'Параметры';
$L['fileAPI_preset_watermark'] = 'Водяной знак';
$L['fileAPI_preset_height'] = 'Высота';
$L['fileAPI_preset_width'] = 'Ширина';
$L['fileAPI_preset_watermark_on'] = 'Накладывать водяной знак';
$L['fileAPI_preset_watermark_src'] = 'Путь к водяному знаку';
$L['fileAPI_preset_watermark_pos'] = 'Позиция водяного знака';
$L['fileAPI_preset_watermark_x'] = 'Отступ водяного знака по оси X';
$L['fileAPI_preset_watermark_y'] = 'Отступ водяного знака по оси Y';
$L['fileAPI_preset_framing'] = 'Режим кадрирования';
$L['fileAPI_preset_quality'] = 'Качество изображения';
$L['fileAPI_preset_convert'] = 'Преобразовать в';
$L['fileAPI_preset_mode_value'] = array('Загрузка аватара пользователя', 'Загрузка фото пользователя','Загрузка аватара страницы');

$L['fileAPI_user_avatar_convert'] = 'Конвертировать старые аватарки из плагина userimages';
$L['fileAPI_user_avatar_convert_title'] = 'Конвертировать';
$L['fileAPI_user_avatar_find_files'] = array('файл','файла','файлов');
$L['fileAPI_user_avatar_find'] = 'Найдено';
$L['fileAPI_user_avatar_nofind'] = 'Файлы не обнаружены ';
$L['fileAPI_user_avatar_convert_comlete'] = 'Перенесено %1$s, осталось %2$s';
$L['fileAPI_comlete'] = 'Скрипт завершил свою работу успешно.';

// controller js
$L['fileAPI_controller_txt'] = array(
	'process' => 'в обработке',
	'select_done' => ', готов к загрузке',
	'maxfiles_limit' => ', Достигнуто максимальное кол. загружаемых файлов',
	'small_img' => 'Изображение должно быть не меньше',
	'error_img' => 'Файл не является изображением'
	);

/*errors*/

$L['fileAPI_upload_file_error_ext'] = 'Файлы с расширением <span class="lblext">.%1$s</span> запрещены.';
$L['fileAPI_filechecknomime'] = 'Внимание: не найден MIME-тип для файла %1$s. Параметры: %2$s';
$L['fileAPI_filecheckfail'] = 'Внимание: ошибка расширения файла %1$s. Параметры: %2$s';
$L['fileAPI_filemimemissing'] = 'Ошибка загрузки: отсутствует MIME-тип для расширения %1$s';
$L['fileAPI_filenotvalid'] = 'Ошибка проверки %1$s-файла';
$L['fileAPI_file_exists'] = 'Ошибка загрузки: файл с таким именем уже существует';
$L['fileAPI_preset_name_empty'] = 'Пустое имя пресета';
$L['fileAPI_preset_name_exist'] = 'Пресет с таким именем уже существует';
$L['fileAPI_preset_preview_name_empty'] = 'Пустое имя превью';
$L['fileAPI_preset_preview_name_exist'] = 'Обнаружено дублирование имени превью';

$L['fileAPI_drop_file_here'] = 'Бросайте файл сюда';
$L['fileAPI_not_support'] = 'Увы, ваш браузер не поддерживает html5 и flash';
$L['fileAPI_downloading_file_is_not_posible'] = 'Загрузка файлов невозможна';
$L['fileAPI_select_file'] = 'Выбрать файл';
$L['fileAPI_download_file'] = 'Загрузить';
$L['fileAPI_drag_file_here'] = 'или перетяните сюда файлы';

$L['fileAPI_insert_img'] = 'Вставить картинку';
$L['fileAPI_insert_link_img'] = 'Вставить превью';
$L['fileAPI_insert_link'] = 'Вставить ссылку на файл';

 /*Setup*/

$L['cfg_filecheck'] = 'Проверка файлов';
$L['cfg_filecheck_hint'] = 'Проверять загружаемые файлы (&laquo;'.$L['PFS'].'&raquo; и профиль) на соответствие их формата используемому расширению. Рекомендуется включить в целях безопасности.';
$L['cfg_nomimepass'] = 'Игнорировать MIME-типы';
$L['cfg_nomimepass_hint'] = 'Разрешить закачку файлов, MIME-тип которых не указан в конфигурации.';
$L['cfg_dir'] = 'Путь к хранилищу файлов';
$L['cfg_lightcase'] = 'Использовать Lightcase для изображений';
$L['cfg_lightcase_hint'] = '<a href="http://cornel.bopp-art.com/lightcase/#demo" target="_blank">Lightcase demo</a>';
$L['cfg_watermark_src'] = 'Путь к изображению водяного знака';
$L['cfg_watermark'] = 'Включить наложение водяного знака';
$L['cfg_chunk_size'] = 'Размер чанка при загрузке больших файлов в Mb';
