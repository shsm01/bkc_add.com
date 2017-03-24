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
                        <!-- press list -->
                        <div class="press-list">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                            <!-- press item -->
                            <div class="press-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arItem['PROPERTIES']['link']['VALUE']):?>
                                <div class="press-item-title"><a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>"><?=$arItem['NAME']?></a> <a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>" target="_blank"><img src="/local/layout/images/link.png" alt="" width="17" height="17" /></a></div>
			<?else:?>
                                    <div class="press-item-title"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?endif;?>

                                <div class="press-item-anonce"><?echo $arItem["PREVIEW_TEXT"]?></div>
                                <div class="press-item-source"><?=$arItem['PROPERTIES']['name_comp']['VALUE']?></div>
                            </div>
                            <!-- press item END -->

	
<?endforeach;?>
                        </div>
                        <!-- press list end-->

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
