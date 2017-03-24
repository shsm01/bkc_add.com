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
<!-- opendays -->
<div class='opendays'>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
$sch=GetIBlockElement($arItem['PROPERTIES']['school']['VALUE']);
$time=time();
$id_date=-1;
$now=$time;
foreach($arItem['PROPERTIES']['date']['VALUE'] as $k=>$v)
{
	if (MakeTimeStamp($v, "DD.MM.YYYY")-$time && $now>MakeTimeStamp($v, "DD.MM.YYYY")-$time)
	{
		$now=MakeTimeStamp($v, "DD.MM.YYYY")-$time;
		$id_date=$k;
	}
}

if ($id_date>-1){
$ddd=explode('.',$arItem['PROPERTIES']['date']['VALUE'][$id_date]);
$mmm=Array(
'1'=>'января',	
'2'=>'февраля',	
'3'=>'марта',	
'4'=>'апреля',	
'5'=>'мая',	
'6'=>'июня',	
'7'=>'июля',	
'8'=>'августа',	
'9'=>'сентября',	
'10'=>'октября',	
'11'=>'ноября',	
'12'=>'декабря',	
);
$ddd[1]=$mmm[$ddd[1]*1];
}
?>
	<!-- openday -->
	<div class="openday" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="openday-text">
			<div class="openday-title"><a href="<?=$sch['DETAIL_PAGE_URL']?>"><?=$sch['NAME']?></a></div>
			<div class="openday-anonce"><?=$arItem['PREVIEW_TEXT']?></div>
		</div>
		<div class="openday-date"><span><?=$ddd[0]?></span> <?=$ddd[1]?> <strong><?=$arItem['PROPERTIES']['time']['VALUE']?></strong></div>
	</div>
	<!-- openday END -->




	
<?endforeach;?>
</div>
<!-- opendays END -->

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
