<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О центре");

if (!$_REQUEST['SECTION_CODE']):
//		$res=CIBlockSection::GetList(array('SORT'=>'ASC','ID'=>'ASC'),array('IBLOCK_ID'=>20));
//		$sec=$res->GetNext();
//		header('location:./'.$sec['CODE'].'/');
?>

<p>
В Москве на базе образовательной компании BKC-International House с 1996 года действует Международный Центр подготовки преподавателей английского языка как иностранного (<a style="font-weight:bold;" href="http://bkcih-moscow.com/training/celta.html" alt="">BKC-IH Moscow Teacher Training Centre</a>). Центр был основан при поддержке крупнейшей Международной Лингвистической Организации Internation House (UK), которая является автором коммуникативной методики, завоевавшей признание во всем мире.
</p>

<p>В 1997 году компании <span style="font-weight:bold;">BKC-International House</span> была официально признана Кембриджским университетом (<a href="http://www.cambridgeenglish.org" alt="">Cambridge English Language Asessment</a>) как Центр подготовки преподавателей английского языка как иностранного, что дало право проводить в Москве курсы для преподавателей английского языка <span style="font-weight:bold"><a href="http://www.bkcih-moscow.com/training_n/celta" alt="">Cambridge CELTA</a></span> (Certificate in Teaching English to Speakers of Other Languages) и Cambridge Delta (Diploma in Teaching English to Speakers of Other Languages).</p>

<p>На сегодняшний день <span style="font-weight:bold;">BKC-IH Moscow Teacher Training Centre</span> - это единственный в России Центр, предлагающий широкий спектр курсов и семинаров для преподавателей английского языка, среди которых Кембриджские программы, курсы <a href="http://ihworld.com" alt="">International House World Organisation</a>, а также тренинги и семинароы, разработанные специалистами Центра.</p>

<p>Одним из важных направлений деятельности Центра является поддержание и повышение качества преподавания иностранных языков внутри компании путем организации и проведения регулярных методических тренингов, семинаров и мастер-классов.</p>

<p>Деятельность Центра координирует DOS (Директор по образованию). В течение учебного года для проведения различных тренинговых программ приезжают специалисты в области преподавания английского как иностранного - TEFL (Teaching English as a Foreign Language). Также на протяжении нескольких лет Центр занимается подготовкой тренеров для проведения курсов.</p>

<?
else:

if (CModule::IncludeModule("iblock")):

$res=CIBlockSection::GetList(array('SORT'=>'ASC','ID'=>'ASC'),array('IBLOCK_ID'=>20,'CODE'=>$_REQUEST['SECTION_CODE']));
$sec=$res->GetNext();

$res=CIBlockElement::GetList(
array('SORT'=>'ASC'),
array('IBLOCK_ID'=>20,'SECTION_ID'=>$sec['ID'])
);
if (!($el=$res->GetNext())):

?><?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "courses", Array(
	"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
		"IBLOCK_ID" => "20",	// Инфоблок
		"IBLOCK_TYPE" => "edu",	// Тип инфоблока
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],	// Код раздела
		"SECTION_FIELDS" => array(	// Поля разделов
			0 => "",
			1 => "",
		),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SECTION_USER_FIELDS" => array(	// Свойства разделов
			0 => "UF_PREVIEW_DESC",
			1 => "",
		),
		"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
		"TOP_DEPTH" => "5",	// Максимальная отображаемая глубина разделов
		"VIEW_MODE" => "LINE",	// Вид списка подразделов
	),
	false
);?><br>
<?else:
?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"courses_list_elem", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "20",
		"IBLOCK_TYPE" => "edu",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PROPERTY_CODE" => array(
			0 => "year",
			1 => "len",
			2 => "int",
			3 => "hours",
			4 => "mesto",
			5 => "title",
			6 => "menu_name",
			7 => "h1",
			8 => "br_name",
			9 => "nagr",
			10 => "price_all",
			11 => "uch",
			12 => "photos",
			13 => "cel",
			14 => "price",
			15 => "level",
			16 => "day",
			17 => "mesto2",
			18 => "",
		),
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "courses_list_elem"
	),
	false
);?>
<?
endif;
endif;
?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
