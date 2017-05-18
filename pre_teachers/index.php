<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if (!$_REQUEST['SECTION_CODE']):
//$APPLICATION->SetTitle("");
$GLOBALS['arrFilter']=array("SECTION_ID" => 519);
?>

<?
$APPLICATION->IncludeComponent("bitrix:news.list", "text_page" , Array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "55",
		"IBLOCK_TYPE" => "edu",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => "text_page"
//		"COMPONENT_TEMPLATE" => "news_bkc"
	),
	false
);
?>

<?
else:

$APPLICATION->SetTitle("Программы центра");

if (CModule::IncludeModule("iblock")):

$res=CIBlockSection::GetList(array('SORT'=>'ASC','ID'=>'ASC'),array('IBLOCK_ID'=>20,'CODE'=>$_REQUEST['SECTION_CODE']));
$sec=$res->GetNext();

$res=CIBlockElement::GetList(
array('SORT'=>'ASC'),
array('IBLOCK_ID'=>20,'SECTION_ID'=>$sec['ID'])
);
if (!($el=$res->GetNext())):

?><?
echo "bitrix:catalog.section.list -> courses"."<br>";

$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "courses", Array(
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
 <?
echo "bitrix:catalog.section -> programs_list_elem"."<br>";

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"programs_list_elem", 
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
			0 => "menu_name",
			1 => "br_name",
			2 => "title",
			3 => "h1",
			4 => "trainer_name",
			5 => "year",
			6 => "level",
			7 => "cel",
			8 => "nagr",
			9 => "len",
			10 => "hours",
			11 => "int",
			12 => "uch",
			13 => "mesto",
			14 => "price_all",
			15 => "photos",
			16 => "price",
			17 => "dates",
//			17 => "dd_dd",
			18 => "daytime",
			19 => "group_status",
			20 => "first_payment",
			21 => "second_payment_early",
			22 => "second_payment",
			23 => "registation_payment",
			24 => "day",
			25 => "mesto2",
			26 => "",
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
		"COMPONENT_TEMPLATE" => "programs_list_elem",
//		"COMPONENT_TEMPLATE" => "courses_list_elem",
		"HIDE_NOT_AVAILABLE" => "N",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"CONVERT_CURRENCY" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD"
	),
	false
);?>
<?
endif;
endif;
?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
