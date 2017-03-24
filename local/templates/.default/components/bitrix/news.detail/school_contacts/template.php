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
$p=$arResult['PROPERTIES'];
?>
                        <div class="detail">
                            <div class="detail-inner">
								<?if ($p['address']['VALUE']):?>
								<div class="detail-row">
                                    <div class="detail-row-name">Адрес</div>
                                    <div class="detail-row-value">
                                        <?=$p['address']['VALUE']?>
                                        <div class="school-link-map"><a href="#map">Как добраться</a></div>
                                    </div>
                                </div>
								<?endif;?>

								<?if ($p['tel']['VALUE']):?>
                                <div class="detail-row">
                                    <div class="detail-row-name">Телефоны</div>
                                    <div class="detail-row-value"><?$tel=str_replace(') ',') <strong>',str_replace(', ','</strong>, ',implode(', ',$p['tel']['VALUE']))).'</strong>';
									$c1=substr_count($tel,'<strong>');
									$c2=substr_count($tel,'</strong>');
									if ($c1==$c2)print($tel);else print(implode(', ',$p['tel']['VALUE']));
									?></div>
									<?//print_r($p['tel']['VALUE']);?>
                                </div>
								<?endif;?>

								<?if ($p['email']['VALUE']):?>
                                <div class="detail-row">
                                    <div class="detail-row-name">Email</div>
                                    <div class="detail-row-value"><a href="mailto:<?=$p['email']['VALUE']?>"><?=$p['email']['VALUE']?></a></div>
                                </div>
								<?endif;?>

								<?if ($p['work']['VALUE']):?>
                                <div class="detail-row">
                                    <div class="detail-row-name">График&nbsp;работы</div>
                                    <div class="detail-row-value">
                                        <div class="schedule">
										<?foreach($p['work']['~VALUE'] as $k=>$v):?>
                                            <div class="schedule-row">
                                                <div class="schedule-row-name"><?=$v?></div>
                                                <div class="schedule-row-value"><?=$p['work']['~DESCRIPTION'][$k]?></div>
                                            </div>
										<?endforeach;?>
                                        </div>
                                    </div>
                                </div>
								<?endif;?>
                            </div>
                            <div class="school-feedback"><a href="/local/windows/feedback.php?id=<?=$arResult['ID']?>" class="window-link">Обратная связь</a></div>
                        </div>

<?if ($p['coords']['VALUE']):?>
<?
$coords=explode(',',$p['coords']['VALUE']);

$arFilter = Array("IBLOCK_ID"=>12, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", 'ID'=>$p['metro']['VALUE']);
$res = CIBlockElement::GetList(Array(), $arFilter);
$metro=array();
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
$metro[$arFields['ID']]['f']=$arFields;
	$rsSections = CIBlockSection::GetList(Array('SORT'=>'ASC'), 
	Array('IBLOCK_ID'=>$arFields['IBLOCK_ID'],'ID'=>$arFields['IBLOCK_SECTION_ID']),
	false, 
	array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
	);
	$metro[$arFields['ID']]['st'] = $rsSections->Fetch();

}


?>
						<!-- detail map -->
                        <div class="detail-map">
                            <h2>Как добраться</h2>
                            <div id="map"></div>
                            <script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
                            <script>
                                ymaps.ready(init);

                                var myMap;

                                function init() {
                                    myMap = new ymaps.Map('map', {
                                        center: [55.755768, 37.617671],
                                        zoom: 16,
                                        controls: ['zoomControl']
                                    });

                                    myMap.behaviors.disable('scrollZoom');

                                    myPlacemark = new ymaps.Placemark([<?=$p['coords']['VALUE']/*$coords[1]?>, <?=$coords[0]*/?>], {}, {
                                        iconLayout: 'default#image',
                                        iconImageHref: '/local/layout/images/map-icon-<?=(($metro[$p['metro']['VALUE']]['st']['UF_COLOR'])?$metro[$p['metro']['VALUE']]['st']['UF_COLOR']:'none')?>.png',
                                        iconImageSize: [49, 37],
                                        iconImageOffset: [-16, -37]
                                    });
                                    myMap.geoObjects.add(myPlacemark);
                                    myMap.setCenter([<?=$p['coords']['VALUE']/*$coords[1]?>, <?=$coords[0]*/?>]);
                                }
                            </script>
                        </div>
                        <!-- detail map END -->
<?=$p['map_route']['~VALUE']['TEXT']?>
<?endif;?>