<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"],
        "IBLOCK_TYPE" => "edu",
        "IBLOCK_ID" => "16",
        //"SECTION_URL" => "/adult/#CODE#/",
        "CACHE_TIME" => "3600",
		    "DEPTH_LEVEL"=>'4'
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>