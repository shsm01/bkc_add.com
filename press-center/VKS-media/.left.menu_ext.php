<?
// ןנטלונ פאיכא .left.menu_ext.php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"], 
        "IBLOCK_TYPE" => "press_center", 
        "IBLOCK_ID" => "10", 
        "SECTION_URL" => "/press-center/VKS-media/#CODE#/", 
        "CACHE_TIME" => "3600" 
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>

