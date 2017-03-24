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
<?foreach($arResult["SECTIONS"] as $arSection){?>
                        <h2><?=$arSection["NAME"]?></h2>

                        <!-- diplomas -->
                        <div class="diplomas diplomas-2">						
		<?
		$cell = 0;
		foreach($arSection["ITEMS"] as $arElement){
		?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
		$ppic = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"]["ID"], array('width'=>110, 'height'=>10050), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    ?>
                            <div class="diplomas-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>"><a href="<?if(is_array($arElement["DETAIL_PICTURE"])) print($arElement["DETAIL_PICTURE"]['SRC']);?>"><img src="<?=$ppic["src"]?>" height="<?=$ppic["height"]?>" width="<?=$ppic["width"]?>" alt="<?=$arElement['NAME']?>" /></a></div>


<?	} // foreach($arResult["ITEMS"] as $arElement):
		?>
                        </div>
                        <!-- diplomas END -->
<?}?>
