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
if (is_array($arItem["DETAIL_PICTURE"])){
    if ($arItem["DETAIL_PICTURE"]["WIDTH"]>170 && $arItem["DETAIL_PICTURE"]["HEIGHT"]>170){
    	$w=170;
    	$h=170;
    }elseif($arItem["DETAIL_PICTURE"]["WIDTH"]<=170){
    	$w=$arItem["DETAIL_PICTURE"]["WIDTH"];
    	$h=$arItem["DETAIL_PICTURE"]["WIDTH"];
    }else{
    	$w=$arItem["DETAIL_PICTURE"]["HEIGHT"];
    	$h=$arItem["DETAIL_PICTURE"]["HEIGHT"];
    }

    if($arItem["DETAIL_PICTURE"]["WIDTH"]<=170 && $arItem["DETAIL_PICTURE"]["WIDTH"]<$w){
    	$w=$arItem["DETAIL_PICTURE"]["WIDTH"];
    	$h=$arItem["DETAIL_PICTURE"]["WIDTH"];
    }
    if($arItem["DETAIL_PICTURE"]["HEIGHT"]<=170 && $arItem["DETAIL_PICTURE"]["HEIGHT"]<$h){
    	$w=$arItem["DETAIL_PICTURE"]["HEIGHT"];
    	$h=$arItem["DETAIL_PICTURE"]["HEIGHT"];
    }


	$arItem["DETAIL_PICTURE"]=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width'=>$w, 'height'=>$h), BX_RESIZE_IMAGE_EXACT, true);
	if (!$arItem["DETAIL_PICTURE"]['SRC'])
	 $arItem["DETAIL_PICTURE"]['SRC']=$arItem["DETAIL_PICTURE"]['src'];
}else{
	$arItem["DETAIL_PICTURE"]['SRC']='/local/layout/images/teacher-'.(($arItem['PROPERTIES']['male']['VALUE']=='Æ')?'f':'m').'.png';
	$arItem["DETAIL_PICTURE"]['WIDTH']='170';
	$arItem["DETAIL_PICTURE"]['HEIGHT']='170';
	$arItem["DETAIL_PICTURE"]["ALT"]=str_replace('"','',$arItem["NAME"]);
	$arItem["DETAIL_PICTURE"]["TITLE"]=str_replace('"','',$arItem["NAME"]);
}
	?>
                            <!-- teacher -->
                            <div class="teacher" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["DETAIL_PICTURE"])):?>
                                <div class="teacher-photo">
									<a  href="/schools/teacher.php?id=<?=$arItem["ID"]?>" class="window-link"><img
						src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$arItem["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["DETAIL_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arItem["DETAIL_PICTURE"]["TITLE"]?>"
						/></a></div>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <div class="teacher-name"><a href="/schools/teacher.php?id=<?=$arItem["ID"]?>" class="window-link"><?echo $arItem["NAME"]?></a></div>
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
