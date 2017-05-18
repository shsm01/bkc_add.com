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
//        "IBLOCK_ID" => "52",
        // "SECTION_URL" => "/adult/#CODE#/",
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


// Add item from new info block
/*
$aMenuLinksExt01 = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"],
        "IBLOCK_TYPE" => "edu",
        "IBLOCK_ID" => "52",
        //"SECTION_URL" => "/adult/#CODE#/",
        "CACHE_TIME" => "3600",
		    "DEPTH_LEVEL"=>'4'
    )
);


foreach ($aMenuLinksExt01 as $key => $value) {
   $aMenuLinksExt01[$key][3]['DEPTH_LEVEL'] = '2';
}
*/
// Change URL for menu from old info block
/*
$count = 0;
	
foreach ($aMenuLinksExt as $key => $value) {

    $pos = strpos($aMenuLinksExt[$key][1], "/languages/english/") ;

    if ( $pos !== false ) {
        $count++;
        $pieces = explode("/", $aMenuLinksExt[$key][1]);
        $pieces[1] = "learn_english"; 
        array_splice($pieces,2,1);
        $aMenuLinksExt[$key][1] = implode("/", $pieces);
    }
}

// Delete old item from old menu 
$count_arr = count($aMenuLinksExt);
$tmp_arr = array_slice ( $aMenuLinksExt , 0, 1);
$tmp_arr_01 = array_slice ( $aMenuLinksExt , $count, $count_arr);

// Merge all items
$aMenuLinks = array_merge($tmp_arr, $aMenuLinksExt01, $tmp_arr_01);
*/
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

// var_dump($aMenuLinksExt);
// $aMenuLinks = array_merge($aMenuLinksExt);
?>