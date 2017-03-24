<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
if (is_array($arItem["PREVIEW_PICTURE"])):
if ($arItem["PREVIEW_PICTURE"]["WIDTH"]>170 && $arItem["PREVIEW_PICTURE"]["HEIGHT"]>170){
	$w=170;
	$h=170;
}elseif($arItem["PREVIEW_PICTURE"]["WIDTH"]<=170){
	$w=$arItem["PREVIEW_PICTURE"]["WIDTH"];
	$h=$arItem["PREVIEW_PICTURE"]["WIDTH"];
}else{
	$w=$arItem["PREVIEW_PICTURE"]["HEIGHT"];
	$h=$arItem["PREVIEW_PICTURE"]["HEIGHT"];
}

if($arItem["PREVIEW_PICTURE"]["WIDTH"]<=170 && $arItem["PREVIEW_PICTURE"]["WIDTH"]<$w){
	$w=$arItem["PREVIEW_PICTURE"]["WIDTH"];
	$h=$arItem["PREVIEW_PICTURE"]["WIDTH"];
}
if($arItem["PREVIEW_PICTURE"]["HEIGHT"]<=170 && $arItem["PREVIEW_PICTURE"]["HEIGHT"]<$h){
	$w=$arItem["PREVIEW_PICTURE"]["HEIGHT"];
	$h=$arItem["PREVIEW_PICTURE"]["HEIGHT"];
}


	$arItem["PREVIEW_PICTURE"]=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>$w, 'height'=>$h), BX_RESIZE_IMAGE_EXACT, true);
	if (!$arItem["PREVIEW_PICTURE"]['SRC'])
	$arItem["PREVIEW_PICTURE"]['SRC']=$arItem["PREVIEW_PICTURE"]['src'];
endif;
	?>
                            <!-- news item -->
                            <div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<div class="news-item-preview"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						/></a></div>
			<?else:?>
				<img
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					/>
			<?endif;?>
		<?endif?>
                                <div class="news-item-text">
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <div class="news-item-title"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
									<div class="news-item-title"><?echo $arItem["NAME"]?></div>
			<?endif;?>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                    <div class="news-item-anonce"><?echo $arItem["PREVIEW_TEXT"];?></div>
		<?endif;?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                    <div class="news-item-date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
		<?endif?>
                                </div>
                            </div>
                            <!-- news item END -->

	
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
