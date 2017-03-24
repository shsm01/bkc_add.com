<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Курс");

?><?$APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"course_det", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_ELEMENT_CHAIN" => "Y",//Добавить элемент в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "Y",//Добавить разделы в цепочку навигации
		"AJAX_MODE" => "N",//Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",//Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",//Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",//Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",//Включить подгрузку стилей
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",//учитывать права доступа
		"CACHE_TIME" => "36000000",//показывать количество элементов в разделе
		"CACHE_TYPE" => "A",//тип кеширования
		"CHECK_DATES" => "Y",//Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",//URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_BOTTOM_PAGER" => "Y",//Выводить под списком
		"DISPLAY_DATE" => "Y",//Выводить дату элемента
		"DISPLAY_NAME" => "Y",//Выводить название элемента
		"DISPLAY_PICTURE" => "Y",//Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "Y",//Выводить текст анонса
		"DISPLAY_TOP_PAGER" => "N",//Выводить над списком
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],//Код элемента
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],//элемент
		"FIELD_CODE" => array(//Поля
			0 => "",
			1 => "",
		),
		"IBLOCK_ID" => "21",//инфоблок
		"IBLOCK_TYPE" => "edu",//тип инфоблока
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",//Включить инфоблок в цепочку навигации
		"MESSAGE_404" => "",//Сообщение для показа (по умолчанию из компонента)
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",//Включить обработку ссылок
		"PAGER_SHOW_ALL" => "N",//Показывать ссылку "Все"
		"PAGER_TEMPLATE" => ".default",//Шаблон постраничной навигации
		"PAGER_TITLE" => "Страница",//Название категорий
		"PROPERTY_CODE" => array(//Свойства
			0 => "year",
			1 => "len",
			2 => "day",
			3 => "int",
			4 => "hours",
			5 => "mesto2",
			6 => "nagr",
			7 => "price",
			8 => "uch",
			9 => "cel",
			10 => "",
		),
		"SET_BROWSER_TITLE" => "Y",//Устанавливать заголовок окна браузера
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",//Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "Y",//Устанавливать описание страницы
		"SET_META_KEYWORDS" => "Y",//Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",//Устанавливать статус 404
		"SET_TITLE" => "Y",//Устанавливать заголовок страницы
		"SHOW_404" => "N",//Показ специальной страницы
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "course_det"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
