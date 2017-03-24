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


						<div class="teachers">
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
                            <!-- teacher -->
                            <div class="teacher" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                                <div class="teacher-photo">
				<a  href="trainer.php?id=<?=$arItem["ID"]?>" class="window-link"><img
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						/></a></div>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <div class="teacher-name"><a href="trainer.php?id=<?=$arItem["ID"]?>" class="window-link"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
									<div class="teacher-name"><?echo $arItem["NAME"]?></div>
			<?endif;?>
		<?endif;?>
		<?//print_r($arItem['PROPERTIES']['name_en']);?>
                                <div class="teacher-name-en"><?=$arItem['PROPERTIES']['name_en']['VALUE']?></div>
                                <div class="teacher-where"><?=$arItem['PROPERTIES']['obr']['VALUE']?></div>

                            </div>
                            <!-- news item END -->

	
<?endforeach;?>
                        </div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
