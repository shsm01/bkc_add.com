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

function EditData ($DATA) {// конвертирует формат даты с 04.11.2008 в 04 Ноября, 2008
	$MES = array( 
		"01" => "Января", 
		"02" => "Февраля", 
		"03" => "Марта", 
		"04" => "Апреля", 
		"05" => "Мая", 
		"06" => "Июня", 
		"07" => "Июля", 
		"08" => "Августа", 
		"09" => "Сентября", 
		"10" => "Октября", 
		"11" => "Ноября", 
		"12" => "Декабря"
	);
	$arData = explode(".", $DATA); 
	$d = ($arData[0] < 10) ? substr($arData[0], 1) : $arData[0];

	$newData = $d." ".$MES[$arData[1]]." ".$arData[2]; 
	return $newData;
}

?>
<div class="videos">
<?foreach($arResult["SECTIONS"] as $arSection):
	if (is_array($arSection["PICTURE"])){
		$arSection["PICTURE"] = CFile::ResizeImageGet($arSection["PICTURE"], array("width" => 570, "height" => 380), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		if (!$arSection["PICTURE"]['SRC']) $arSection["PICTURE"]['SRC'] = $arSection["PICTURE"]['src'];
	}
?>

	<div class="video-item-img"><img src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>" /></div>
	<div class="video-item-title"><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a></div>
	<? if($arSection['DESCRIPTION']){?>
		<div class="video-item-anonce"><?=$arSection['DESCRIPTION']?></div>
	<?}?>
	<div class="video-item-date"><?=EditData($arSection['DATE_CREATE']);?></div>

<?endforeach?>
</div>