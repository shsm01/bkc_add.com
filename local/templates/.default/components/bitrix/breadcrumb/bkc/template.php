<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}

$strReturn .= '<div class="breadcrumbs"><a href="/">Школа иностранных языков</a>';
$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	if ($arResult[$index]["LINK"]=='/')continue;
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="breadcrumbs_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');
	$arrow = ($index > 0? '<span></span>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					'.$title.'
				</a>
			';
	}
	else
	{
		$strReturn .= '
				'.$arrow.'
				'.$title.'
			';
	}
}

$strReturn .= '</div>';

return $strReturn;
