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

                        <div class="video-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
<?
$path_vid=substr($arItem['PREVIEW_TEXT'],strpos($arItem['PREVIEW_TEXT'],'src="')+5);
$path_vid=substr($path_vid,0,strpos($path_vid,'"'));
?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
//	print_r($arItem['PREVIEW_TEXT']);
	?>
                            <div class="video-item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$path_vid?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" 						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" /></a></div>


<?endforeach;?>
                        </div>
                        <!-- gallery END -->

                        <!-- item gallery -->
                        <div class="item-gallery">
                            <div class="item-gallery-container">
                                <div class="item-gallery-load"><img src="/local/layout/images/blank.gif" alt="" /></div>
                                <div class="item-gallery-title"><?=$sec['NAME']?></div>
                                <div class="item-gallery-text"><?=$sec['DESCRIPTION']?></div>
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

