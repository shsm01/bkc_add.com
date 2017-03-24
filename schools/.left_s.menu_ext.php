<?
$aMenuLinks = Array(
);
CModule::IncludeModule("iblock");

$arFilter = Array("IBLOCK_ID"=>11, 'CODE'=>$_REQUEST['SECTION_CODE'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter);
$ob = $res->GetNext();
if(is_array($ob)):


$arFilter = Array("IBLOCK_ID"=>13, 'PROPERTY_school'=>$ob['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1));
$new = $res->GetNext();
if (is_array($new))
	$aMenuLinks[]=Array(
		"Новости", 
		"/schools/".$_REQUEST['SECTION_CODE']."/news/", 
		Array(), 
		Array(), 
		"" 
	);

$arFilter = Array("IBLOCK_ID"=>28, 'PROPERTY_school'=>$ob['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1));
$new = $res->GetNext();
if (is_array($new))
	$aMenuLinks[]=Array(
		"Расписание", 
		"/schools/".$_REQUEST['SECTION_CODE']."/schedule/", 
		Array(), 
		Array(), 
		"" 
	);


$arFilter = Array("IBLOCK_ID"=>14, 'PROPERTY_school'=>$ob['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1));
$new = $res->GetNext();
if (is_array($new))
	$aMenuLinks[]=Array(
		"Преподаватели", 
		"/schools/".$_REQUEST['SECTION_CODE']."/teachers/", 
		Array(), 
		Array(), 
		"" 
	);

$arFilter = Array("IBLOCK_ID"=>15, 'PROPERTY_school'=>$ob['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1));
$new = $res->GetNext();
if (is_array($new))
	$aMenuLinks[]=Array(
		"Отзывы", 
		"/schools/".$_REQUEST['SECTION_CODE']."/reviews/", 
		Array(), 
		Array(), 
		"" 
	);

if (is_array($new))
	$aMenuLinks[]=Array(
		"Контакты школы", 
		"/schools/".$_REQUEST['SECTION_CODE']."/contacts/", 
		Array(), 
		Array(), 
		"" 
	);

endif;

?>