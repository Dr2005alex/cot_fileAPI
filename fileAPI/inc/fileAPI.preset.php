<?php
defined('COT_CODE') or die('Wrong URL');

/* === Hook === */
foreach (cot_getextplugins('fileAPI.preset') as $pl)
{
	include $pl;
}
/* ===== */

$fileAPI_preset['main'] = array(
	'AutoUpload' => false, // автоматическая загрузка файлов на сервер. true - да, false - нет
	'DnD' => true, // включить поддержку Drag & Drop (Выбор файлов путем перетаскивания)
	'Multiple' => true, // включить множественный выбор файлов
	'MaxFiles' => 20, // максимальное количество прикрепляемых файлов
	'Accept' => '',// фильтр выбора файлов в форме загрузки. Через запятую, если несколько. (image, audio, video, application) Оставить пустым для отключения
	'MaxFileSize' => 20, // Максимальный размер файла для загрузки а Mb
	'TimeViewError' => 3000, //Время отображения ошибки в мс.
	'Tpl' => '', //tpl файл формы
	'ImageTransform' => array(
		/*
		 * ИЗМЕНЕНИЕ РАЗМЕРОВ ИЗОБРАЖЕНИЙ ИЛИ НАРЕЗКА ПРЕВЬЮ К ОРИГИНАЛУ
		 *
		 * thumb - имя превью
		 * 		width - ширина в px
		 * 		height - высота в px
		 * 		type - режим обработки.(crop, side, stretch)
		 * 				crop - обрезание под задданный размер.
		 * 				side - обрезание по максимальной стороне.(по ширине или высоте)
		 * 				stretch - растягивание изображения до заданных размеров.
		 *		quality - качество изображения по умолчанию 0.86
		 * 		watermark - параметры наложения водяного знака.
		 * 				src - полный путь до изображения водяного знака в png формате.
		 * 				Или указать значение 'cfg' - путь будет взят из настроек модуля.
		 * 				pos - позиция водяного знака на изображении
		 * 				Зарезервированные позиции:
		 * 					TOP_LEFT,TOP_CENTER,TOP_RIGHT
		 * 					CENTER_LEFT,CENTER_CENTER,CENTER_RIGHT
		 * 					BOTTOM_LEFT,BOTTOM_CENTER,BOTTOM_RIGHT
		 *				x - отступ от края по оси X
		 *				y - отступ от края по оси Y
		 *		form - указывает на то, что это изображение будет выводится в форме загрузки как превью. true/false
		 */
		'thumb' => array(
			'width' => '80px',
			'height' => '80px',
			'type' => 'crop',
			'quality' => '0.86',
			'form' => true,
			'watemark' => false
		),
		'original' => array(
			'quality' => '0.86',
			'watermark' => array('src' => 'cfg', 'pos' => 'BOTTOM_RIGHT', 'x' => 15, 'y' => 15)
		),
	)
);

$fileAPI_preset['avatar'] = array(
	'AutoUpload' => false, // автоматическая загрузка файлов на сервер. true - да, false - нет
	'DnD' => false, // включить поддержку Drag & Drop (Выбор файлов путем перетаскивания)
	'Multiple' => false, // включить множественный выбор файлов
	'MaxFiles' => 1, // максимальное количество прикрепляемых файлов
	'Accept' => 'image',// фильтр выбора файлов в форме загрузки. Через запятую, если несколько. (image, audio, video, application) Оставить пустым для отключения
	'MaxFileSize' => 20, // Максимальный размер файла для загрузки а Mb
	'TimeViewError' => 3000, //Время отображения ошибки в мс.
	'Tpl' => 'fileAPI.form.avatar', //tpl файл формы
	'Mode'	=> 'avatar',
	'ImageTransform' => array(
		'original' => array(
			'width' => '80px',
			'height' => '80px',
			'type' => 'side', //при использовании cropper обязательно side
			'typeimage' => 'image/png',
			'quality' => '0.86',
			'form' => true,
			'avatar' => true,
			'watemark' => false
		)
	)
);

$fileAPI_preset['photo'] = array(
	'AutoUpload' => false, // автоматическая загрузка файлов на сервер. true - да, false - нет
	'DnD' => false, // включить поддержку Drag & Drop (Выбор файлов путем перетаскивания)
	'Multiple' => false, // включить множественный выбор файлов
	'MaxFiles' => 1, // максимальное количество прикрепляемых файлов
	'Accept' => 'image',// фильтр выбора файлов в форме загрузки. Через запятую, если несколько. (image, audio, video, application) Оставить пустым для отключения
	'MaxFileSize' => 20, // Максимальный размер файла для загрузки а Mb
	'TimeViewError' => 3000, //Время отображения ошибки в мс.
	'Tpl' => 'fileAPI.form.avatar', //tpl файл формы
	'Mode'	=> 'photo',
	'ImageTransform' => array(
		'original' => array(
			'width' => '300px',
			'height' => '200px',
			'type' => 'side', //при использовании cropper обязательно side
			'typeimage' => 'image/png',
			'quality' => '0.86',
			'form' => true,
			'avatar' => true,
			'watemark' => false
		)
	)
);

$fileAPI_preset['page_avatar'] = array(
	'AutoUpload' => false, // автоматическая загрузка файлов на сервер. true - да, false - нет
	'DnD' => false, // включить поддержку Drag & Drop (Выбор файлов путем перетаскивания)
	'Multiple' => false, // включить множественный выбор файлов
	'MaxFiles' => 1, // максимальное количество прикрепляемых файлов
	'Accept' => 'image',// фильтр выбора файлов в форме загрузки. Через запятую, если несколько. (image, audio, video, application) Оставить пустым для отключения
	'MaxFileSize' => 20, // Максимальный размер файла для загрузки а Mb
	'TimeViewError' => 3000, //Время отображения ошибки в мс.
	'Tpl' => 'fileAPI.form.avatar', //tpl файл формы
	'Mode'	=> 'page_avatar',
	'ImageTransform' => array(
		'original' => array(
			'width' => '620px',
			'height' => '100px',
			'type' => 'side', //при использовании cropper обязательно side
			'typeimage' => 'image/png',
			'quality' => '0.86',
			'form' => true,
			'avatar' => true,
			'watemark' => false
		)
	)
);
