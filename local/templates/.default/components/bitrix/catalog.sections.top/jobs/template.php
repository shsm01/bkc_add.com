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
$sch=array();

foreach($arResult["SECTIONS"] as $arSection):?>
                        <h2><?=$arSection["NAME"]?></h2>

                        <!-- vacancies -->
                        <div class="vacancies">
		<?
		$cell = 0;
		foreach($arSection["ITEMS"] as $arElement):
			if (!count($sch[$arElement['PROPERTIES']['school']['VALUE']]))
				$sch[$arElement['PROPERTIES']['school']['VALUE']]=GetIBlockElement($arElement['PROPERTIES']['school']['VALUE']);
		?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="vacancy"  id="<?=$this->GetEditAreaId($arElement['ID']);?>">
			<h3><a href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=$arElement['NAME']?></a></h3>
			<?if ($arElement['PROPERTIES']['zp']['VALUE']):?>
			<p>Заработная плата: <strong><?=str_replace('руб','<span class="rouble">i</span>',$arElement['PROPERTIES']['zp']['VALUE'])?></strong></p>
			<?endif;?>
			<p><?=$arElement['PROPERTIES']['city']['VALUE']?><?if ($arElement['PROPERTIES']['metro']['VALUE']) {echo ', м. '.$arElement['PROPERTIES']['metro']['VALUE'];}?><?if ($arElement['PROPERTIES']['school']['VALUE']):?>, <a href="#"><?=$sch[$arElement['PROPERTIES']['school']['VALUE']]['NAME']?></a><?endif;?></p>
		</div>


<?		endforeach; // foreach($arResult["ITEMS"] as $arElement):
		?>
                        </div>
                        <!-- vacancies END -->
<?endforeach?>
