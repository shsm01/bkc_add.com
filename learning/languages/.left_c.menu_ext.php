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


foreach ($aMenuLinksExt as $key => $value) {

    $pos = strpos($aMenuLinksExt[$key][1], "/languages/english/") ;

    if ( $pos !== false ) {
        $pieces = explode("/", $aMenuLinksExt[$key][1]);
        $pieces[1] = "learn_english"; 
        array_splice($pieces,2,1);
        $aMenuLinksExt[$key][1] = implode("/", $pieces);
    }
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

// var_dump($aMenuLinksExt);
// $aMenuLinks = array_merge($aMenuLinksExt);
?>