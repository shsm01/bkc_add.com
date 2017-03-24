<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;



$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",

    Array(
        "ID" => $_REQUEST["ELEMENT_ID"], 
        "IBLOCK_TYPE" => "edu", 
        "IBLOCK_ID" => "21",
	// "SECTION_URL" => "/international/#CODE#/",
        "CACHE_TIME" => "3600" ,
	"DEPTH_LEVEL"=>'3'//глубина вложенности =1 для корневых, =2 для первого уровня вложенности и т.д.
    	)
);

$menu=array();
$d_l=0;
$add=0;

foreach($aMenuLinksExt as $k=>$v): //$k - links of first level, $v - links of english

	if($add==0):
		if ($v['1']=='/exams/english/')
		$d_l=$v['3']['DEPTH_LEVEL']+1;
	
	else if ($d_l>0 && $v['3']['DEPTH_LEVEL']<$d_l){ 
		foreach($aMenuLinks as $k1=>$v1) {
			
			$v1[3]=$aMenuLinksExt[$k-1][3];
			$menu[]=$v1;
			$add=1;
		//	print_r($v1);
		//	print_r($menu);
		}
	//unset($aMenuLinks);
	}
endif;
$menu[]=$v;
endforeach;
$aMenuLinks =$menu;

//print_r($menu);
//$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);


?>
