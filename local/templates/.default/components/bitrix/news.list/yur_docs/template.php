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

                        <!-- diplomas -->
                        <div class="diplomas diplomas-2">						
		<?
		$cell = 0;
		foreach($arResult["ITEMS"] as $arElement):
		?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
                            <div class="diplomas-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>"><a href="<?if(is_array($arElement["DETAIL_PICTURE"]))print($arElement["DETAIL_PICTURE"]['SRC']);?>"><img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement['NAME']?>" /></a></div>


<?		endforeach; // foreach($arResult["ITEMS"] as $arElement):
		?>
                        </div>
                        <!-- diplomas END -->



<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
