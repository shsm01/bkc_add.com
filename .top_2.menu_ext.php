<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinks = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"], 
        "IBLOCK_TYPE" => "edu", 
        "IBLOCK_ID" => "16", 
        "SECTION_URL" => "/learning/adult/c/#CODE#/", 
        "CACHE_TIME" => "3600" ,
		"DEPTH_LEVEL"=>'1'
    )
);

?>