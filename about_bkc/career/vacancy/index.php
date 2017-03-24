<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
?><p><strong>Не нашли свою вакансию? Хотите у нас работать?</strong><br>Напишите нам! Расскажите о себе и работе своей мечты, и мы обязательно с Вами свяжемся!
<br>Ждем Ваше резюме по адресу: <a class="color_text" href="mailto:jobs@bkc.ru">jobs@bkc.ru</a></p>
<?$APPLICATION->IncludeComponent("bitrix:catalog.sections.top", "jobs", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "N",	// Выводить кнопку сравнения
		"ELEMENT_COUNT" => "100",	// Максимальное количество элементов, выводимых в каждом разделе
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки элементов
		"FILTER_NAME" => "arrFilter",	// Имя массива со значениями фильтра для фильтрации элементов
		"IBLOCK_ID" => "3",	// Инфоблок
		"IBLOCK_TYPE" => "about",	// Тип инфоблока
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов, выводимых в одной строке таблицы
		"PRICE_CODE" => "",	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => "",	// Характеристики товара
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"PROPERTY_CODE" => array(	// Свойства
			0 => "city",
			1 => "zp",
			2 => "metro",
			3 => "",
		),
		"SECTION_COUNT" => "200",	// Максимальное количество выводимых разделов
		"SECTION_FIELDS" => array(	// Поля разделов
			0 => "",
			1 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_SORT_FIELD" => "sort",	// По какому полю сортируем разделы
		"SECTION_SORT_ORDER" => "asc",	// Порядок сортировки разделов
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SECTION_USER_FIELDS" => array(	// Свойства разделов
			0 => "",
			1 => "",
		),
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>