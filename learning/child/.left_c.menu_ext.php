<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;


$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"],
        "IBLOCK_TYPE" => "edu",
        "IBLOCK_ID" => "19",
        //"SECTION_URL" => "/children/#CODE#/",
        "CACHE_TIME" => "3600" ,
		"DEPTH_LEVEL"=>'4'
    )
);
          //var_Dump($aMenuLinksExt);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>