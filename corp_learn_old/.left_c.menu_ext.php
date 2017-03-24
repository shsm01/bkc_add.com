<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*
global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["ELEMENT_ID"],
        "IBLOCK_TYPE" => "edu",
        "IBLOCK_ID" => "23",
        //"SECTION_URL" => "/corporate/#CODE#/",
        "CACHE_TIME" => "3600" ,
		"DEPTH_LEVEL"=>'4'
    )
);
*/

/*
$menu=array();			
$d_l=0;			
$add=0;			
		
foreach($aMenuLinksExt as $k=>$v):			
			
	if($add==0):			
		if ($v['1']=='/corp_learn/english/')			
			$d_l=$v['3']['DEPTH_LEVEL']+1;			
			
		else if ($d_l>0 && $v['3']['DEPTH_LEVEL']<$d_l) {			
			foreach($aMenuLinks as $k1=>$v1) {			
				$v1[3]=$aMenuLinksExt[$k+1][3];			
				$menu[]=$v1;			
				$add=1;		
			}
		}
	endif;
	$menu[]=$v;
endforeach;
$aMenuLinks =$menu;
*/

// $aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
// $page = $APPLICATION->GetCurUri();
// echo $page;
?>
