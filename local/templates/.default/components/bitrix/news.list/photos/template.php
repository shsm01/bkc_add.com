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
<?
$sec=GetIBlockSection($arResult["ITEMS"][0]['IBLOCK_SECTION_ID']);
?>
<?
print($sec['DESCRIPTION']);
?>

                        <!-- gallery -->
                        <div class="gallery">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
if (is_array($arItem["PREVIEW_PICTURE"])):
$arItem["PREVIEW_PICTURE"]=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"],array("width" => 270, "height" => 180),BX_RESIZE_IMAGE_EXACT,true);
if (!$arItem["PREVIEW_PICTURE"]['SRC'])$arItem["PREVIEW_PICTURE"]['SRC']=$arItem["PREVIEW_PICTURE"]['src'];
endif;
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                            <div class="gallery-item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" rel="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" 						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" /></a></div>


<?endforeach;?>
                        </div>
                        <!-- gallery END -->

                        <!-- item gallery -->
                        <div class="item-gallery">
                            <div class="item-gallery-container">
                                <div class="item-gallery-load"><img src="/local/layout/images/blank.gif" alt="" /></div>
                                 <div class="item-gallery-title"><?=$sec['NAME']?></div>
                                <div class="item-gallery-text"><?//=$sec['DESCRIPTION']?></div>
                                 <div class="item-gallery-big">
                                    <strong>
                                        <img src="/local/layout/images/blank.gif" alt="" />
                                        <a href="#" class="item-gallery-prev"><span></span></a>
                                        <a href="#" class="item-gallery-next"><span></span></a>
                                    </strong>
                                    <div class="item-gallery-loading"></div>
                                </div>
                                <div class="item-gallery-content">
                                    <div class="item-gallery-list"></div>
                                    <a href="#" class="item-gallery-list-prev"><span></span></a>
                                    <a href="#" class="item-gallery-list-next"><span></span></a>
                                </div>
                            </div>
                            <a href="#" class="item-gallery-close">закрыть</a>
                        </div>
                        <!-- item gallery END -->

