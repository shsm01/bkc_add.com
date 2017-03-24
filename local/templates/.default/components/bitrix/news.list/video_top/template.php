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
?>
<div class="videos">

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
$sec=GetIBlockSection($arItem['IBLOCK_SECTION_ID']);

$path_vid=substr($arItem['PREVIEW_TEXT'],strpos($arItem['PREVIEW_TEXT'],'src="')+5);
$path_vid=substr($path_vid,0,strpos($path_vid,'"'));
?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
//	print_r($arItem['PREVIEW_TEXT']);
	?>

	<div class="video-item-play"  id="<?=$this->GetEditAreaId($arItem['ID']);?>"><iframe src="<?=$path_vid?>" frameborder="0" allowfullscreen></iframe></div>
	<div class="video-item-title"><a href="<?=$sec['SECTION_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
	<div class="video-item-anonce"><?=$arItem['DETAIL_TEXT']?></div>
	<div class="video-item-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>


<?endforeach;?>
</div>
