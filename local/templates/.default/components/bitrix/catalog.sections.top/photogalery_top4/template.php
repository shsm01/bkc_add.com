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
function EditData ($DATA) // конвертирует формат даты с 04.11.2008 в 04 Ноября, 2008
{
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
                        <!-- photo galleries -->
                        <div class="photo-galleries">
<?foreach($arResult["SECTIONS"] as $arSection):?>
                            <div class="photo-galleries-item">
                                <a href="<?=$arSection['SECTION_PAGE_URL']?>">
                                    <div class="photo-galleries-item-preview"><img src="<?=$arSection['PICTURE']['SRC']?>" alt="" /></div>
                                    <div class="photo-galleries-item-name"><?=$arSection['NAME']?></div>
                                    <div class="photo-galleries-item-anonce"><?=$arSection['DESCRIPTION']?></div>
                                    <div class="photo-galleries-item-date"><?=EditData($arSection['DATE_CREATE']);?></div>
                                </a>
                            </div>
<?endforeach?>
                        <!-- <a href="/video-lessons/photogalery/" class="btn-more">Еще фотогалереи</a> -->
                        </div>
                        <!-- photo galleries END -->
