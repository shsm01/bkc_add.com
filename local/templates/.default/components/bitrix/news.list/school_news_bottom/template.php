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
                        <!-- school news -->
                        <div class="school-news">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                            <div class="school-news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <div class="school-news-title"><a href="<?echo str_replace('/schools/','/schools/'.$_REQUEST['SECTION_CODE'].'/',$arItem["DETAIL_PAGE_URL"])?>"><?echo $arItem["NAME"]?></a></div>
                                <div class="school-news-anonce"><?echo $arItem["PREVIEW_TEXT"];?></div>
                                <!-- <div class="school-news-tag"><a href="#">/ Летние курсы</a></div> -->
                            </div>

	
<?endforeach;?>
                        </div>
                        <!-- school news END -->
