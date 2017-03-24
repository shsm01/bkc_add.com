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
<style>
/*
th{
background:#EEE;
}
p{
margin-top:3px;
}
*/
</style>
<table>
<thead>
<tr>
	<th>Дата и время</th>
	<th>Тема выступления и мероприятие</th>
	<th>Место проведения</th>
	<th>Тренер</th>
</tr>
</thead>
<tbody>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

$ddd=explode('.',$arItem['PROPERTIES']['date']['VALUE']);
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

print('
<tr id="'.$this->GetEditAreaId($arItem['ID']).'">
');
?>
	<td><div class="event-date"><span><?=$ddd[0]?></span> <?=$ddd[1]?><strong><?=$arItem['PROPERTIES']['time']['VALUE']?></strong></div></td>
	<td><?=$arItem['PROPERTIES']['theme']['~VALUE']['TEXT']?></td>
	<td><?=$arItem['PROPERTIES']['mesto']['~VALUE']['TEXT']?></td>
	<td><?=$arItem['PROPERTIES']['trainer']['VALUE']?></td>
</tr>


	
<?endforeach;?>
</tbody>
</table>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
