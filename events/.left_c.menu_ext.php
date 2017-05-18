<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;


$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"", 

	array(
		//"ID" => $_REQUEST["ELEMENT_ID"],
		//"IBLOCK_TYPE" => "edu",
		//"IBLOCK_ID" => "20",
		//"SECTION_URL" => "/learning/teachers/c/#CODE#/",
		//"CACHE_TIME" => "3600",
		//"DEPTH_LEVEL" => "4",
		//"IS_SEF" => "N",
		//"CACHE_TYPE" => "A"
	
	)
	
);

// var_dump($aMenuLinks);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>
