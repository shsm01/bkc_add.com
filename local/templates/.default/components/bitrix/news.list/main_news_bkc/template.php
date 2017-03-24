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
					<div class="main-news-cols">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                            <!-- news item -->
                            <div class="main-news-col" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <div class="main-news-title"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
									<div class="main-news-title"><?echo $arItem["NAME"]?></div>
			<?endif;?>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                    <div class="main-news-anonce"><?echo $arItem["PREVIEW_TEXT"];?></div>
		<?endif;?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                    <div class="main-news-date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
		<?endif?>
                            </div>
                            <!-- news item END -->


<?endforeach;?>
                        <div class="main-news-ctrl"></div>

                    </div>
