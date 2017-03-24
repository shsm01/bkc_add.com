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
if (!empty($arResult['ITEMS']))
{
?>
<!-- partners -->
<div class="partners">
<?
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$productTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $arItem['NAME']
	);
	$imgTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $arItem['NAME']
	);
$site=str_replace('http://','',$arItem['PROPERTIES']['site']['VALUE']);
?>
	<div class="partner" id="<?=$strMainID?>">
		<?if(strlen($site)>0):?>
		<div class="partner-logo"><a target="_blank" href="<?='http://'.$site?>"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$imgTitle?>" /></a></div>
		<div class="partner-name"><?=$productTitle?></div>
		<div class="partner-link"><a target="_blank" href="<?='http://'.$site?>"><?=$site?></a></div>
		<?else:?>
		<div class="partner-logo"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$imgTitle?>" /></div>
		<div class="partner-name"><?=$productTitle?></div>
		<div class="partner-link"></div>
		<?endif;?>

	</div>
<?}?>
</div>
<!-- partners END -->
<?}?>