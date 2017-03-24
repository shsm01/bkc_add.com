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
$p=$arResult['PROPERTIES'];
?>						
						<!-- school tabs -->
                        <div class="school-tabs">
						<a class="school-tabs-value" href="#">Контакты</a>
                            <ul>
                                <li class="active"><a href="#">Контакты</a></li>
                                <li><a href="#">О школе</a></li>
                                <li><a href="#">Директор школы</a></li>
                                <li><a href="#">День открытых дверей</a></li>
                            </ul>
                        </div>
                        <!-- school tabs END -->

                        <!-- school tabs container -->
                        <div class="school-tabs-container">

                            <!-- school tabs content -->
                            <div class="school-tabs-content active">
                                <div class="school-info">
									<div class="detail">
										<div class="detail-inner">
											<?if ($p['address']['VALUE']):?>
											<div class="detail-row">
												<div class="detail-row-name">Адрес</div>
												<div class="detail-row-value">
													<?=$p['address']['VALUE']?>
													<div class="school-link-map"><a href="/local/windows/school.php?ID=<?=$arResult['ID']?>" class="window-link">Как добраться</a></div>
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

                                    <div class="school-info-map">
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
                                                    iconImageHref: '/local/layout/images/map-icon-<?=(($metro[$p['metro']['VALUE']]['st']['UF_COLOR'])?$metro[$p['metro']['VALUE']]['st']['UF_COLOR']:'none')?>-big.png',
                                                    iconImageSize: [74, 57],
                                                    iconImageOffset: [-23, -57]
                                                });
                                                myMap.geoObjects.add(myPlacemark);
                                                myMap.setCenter([<?=$p['coords']['VALUE']/*$coords[1]?>, <?=$coords[0]*/?>]);
                                            }
                                        </script>
                                    </div>
<?//=$p['map_route']['~VALUE']['TEXT']?>
<?endif;?>
                                </div>
                            </div>
                            <!-- school tabs content END -->

                            <!-- school tabs content -->
                            <div class="school-tabs-content">
	<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
                            </div>
                            <!-- school tabs content END -->

                            <!-- school tabs content -->
                            <div class="school-tabs-content">
                                <div class="director">
<?
$pic=CFile::GetFileArray($p['dir_photo']['VALUE']);
?>
									<div class="director-photo"><img src="<?=$pic['SRC']?>" alt="" /></div>
                                    <div class="director-text">
<?=$p['dir']['~VALUE']['TEXT']?>
<?if ($p['dir_name']['VALUE']):?>
<p><strong><?=$p['dir_name']['VALUE']?></strong><br />Директор школы</p>
<?endif;?>
									</div>
                                </div>
                            </div>
                            <!-- school tabs content END -->

                            <!-- school tabs content -->
                            <div class="school-tabs-content">

								<!-- openday -->
                                <div class="openday">
<?
$filter=Array('IBLOCK_ID'=>9,'PROPERTY_school'=>$arResult['ID']);
$open_day=CIBlockElement::GetList(array('SORT'=>'ASC'),$filter);
if ($day_res=$open_day->GetNextElement()):
?>
                                    <div class="openday-text">
<?	$day=$day_res->GetFields();
	$day_p=$day_res->GetProperties();
	$time=time();
	$id_date=-1;
	$now=$time;

	foreach($day_p['date']['VALUE'] as $k=>$v)
	{
		if (MakeTimeStamp($v, "DD.MM.YYYY")-$time && $now>MakeTimeStamp($v, "DD.MM.YYYY")-$time)
		{
			$now=MakeTimeStamp($v, "DD.MM.YYYY")-$time;
			$id_date=$k;
		}
	}

	if ($id_date>-1){
	$ddd=explode('.',$day_p['date']['VALUE'][$id_date]);
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


										<div class="openday-title"><a href="<?=$arResult['DETAIL_PAGE_URL']?>"><?=$arResult['NAME']?></a></div>
                                        <div class="openday-anonce"><?=$day['PREVIEW_TEXT']?></div>
                                    </div>
                                    <div class="openday-date"><span><?=$ddd[0]?></span> <?=$ddd[1]?> <strong><?=$day_p['time']['VALUE']?></strong></div>
<?endif;?>
								</div>
                                <!-- openday END -->

                            </div>
                            <!-- school tabs content END -->

                        </div>
                        <!-- school tabs container END -->




<?
$id=$arResult['ID'];
// var_dump($id);
$filter=Array('IBLOCK_ID'=>28,
'PROPERTY_school'=>$id
/*array(
'LOGIC'=>'OR',
'PROPERTY_course'=>$id,
'PROPERTY_course2'=>$id,
'PROPERTY_course3'=>$id,
'PROPERTY_course4'=>$id,
'PROPERTY_course5'=>$id,
'PROPERTY_course6'=>$id,
)*/);
$res=CIBlockElement::GetList(array('SORT'=>'ASC'),$filter);
$rasp=array();
while ($ob=$res->GetNextElement()):
  $f = $ob->GetFields();
  $p = $ob->GetProperties();
  
  //var_dump($f);
  
  $course=-1;
  //for($i = 1; $i <= 6; $i++) if($p['course'.$i]['VALUE'])  echo "<pre>"; var_dump($p['course'.$i]['VALUE']); echo "</pre>";

  if ($p['course']['VALUE'])
    $course=$p['course']['VALUE'];
  if ($p['course2']['VALUE'])
    $course=$p['course2']['VALUE'];
  if ($p['course3']['VALUE'])
    $course=$p['course3']['VALUE'];
  if ($p['course4']['VALUE'])
    $course=$p['course4']['VALUE'];
  if ($p['course5']['VALUE'])
    $course=$p['course5']['VALUE'];
  if ($p['course6']['VALUE'])
    $course=$p['course6']['VALUE'];
  $rasp[$course][]=array('p'=>$p,'f'=>$f);
endwhile;
?>

                        <div class="school-banners">
                            <div class="main-banner-3">
                                <div class="main-banner-title">Горящие<br />группы месяца!</div>
                                <div class="main-banner-text">Открыт набор в ГОРЯЩИЕ этого месяца!</div>
                                <a href="#" class="main-banner-link">Заказать</a>
                            </div>
                            <div class="main-banner-5">
                                <div class="main-banner-title">4 стратегии экономии<br />от ВКС-IH</div>
                                <div class="main-banner-text">Изучайте иностранные языки прямо в офисе!</div>
                                <a href="#" class="main-banner-link">Заказать</a>
                            </div>
                        </div>

                        <h2>Горящие группы</h2>


<?foreach ($rasp as $course=>$r):
  $cour_el=GetIBlockElement($course);
  
  /*
  var_dump( $rasp);
  
  $nav = CIBlockSection::GetNavChain(false, $cour_el['IBLOCK_SECTION_ID']); 
  while($nv = $nav->Fetch()){
    var_Dump($nv);
  } 
  */
 
  $cour_sec=GetIBlockSection($cour_el['IBLOCK_SECTION_ID']);
  $ar_cour=array();
  $ar_cour[]=$cour_sec;
  $i=1;
  while(($cour_sec['DEPTH_LEVEL']>1)&&$i<5){
  $cour_sec=GetIBlockSection($cour_sec['IBLOCK_SECTION_ID']);
  $ar_cour[]=$cour_sec;
  $i++;
  }
  
  $str_cour='<span></span>'.$cour_el['NAME'];
  //var_dump($ar_cour);
  foreach($ar_cour as $cour)
    $str_cour='<span></span>'.$cour['NAME'].$str_cour;
  $str_cour=$cour['IBLOCK_NAME'].$str_cour;
?>
                        <div class="hot-courses"><?=$str_cour?></div>


						<!-- timetable list -->
                        <div class="timetable-list timetable-list-school">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Уровень</th>
                                        <th data-orderable="false">Дни недели</th>
                                        <th>Время</th>
                                        <th>Дата старта</th>
                                        <th>Стоимость</th>
                                        <th data-orderable="false"></th>
                                    </tr>
                                </thead>
                                <tbody>

<?
foreach($r as $r_val):
$p=$r_val['p'];
$f=$r_val['f'];

$lvl=GetIBlockElement($p['level']['VALUE']);
?>									<tr>
                                        <td><a href="<?=$cour_el['DETAIL_PAGE_URL']//$lvl['DETAIL_PAGE_URL']?>"><?=$lvl['NAME']?></a></td>
                                        <td>
                                            <div class="timetable-week">
<?
$arr_w=array(
1=>'Пн',
2=>'Вт',
3=>'Ср',
4=>'Чт',
5=>'Пт',
6=>'Сб',
7=>'Вс'
);

for($i=1;$i<=5;$i++)
print('
												<div class="timetable-week-day'.
(
(in_array($arr_w[$i],$p['days']['VALUE']))
	?
	' active'
	:
	''
)
.
'">'.$arr_w[$i].'</div>
');

?>
<?

for($i=6;$i<=7;$i++)
print('
												<div class="timetable-week-day timetable-weekend-day'.(
												(in_array($arr_w[$i],$p['days']['VALUE']))
												?' active':'').'">'.$arr_w[$i].'</div>
');
?>
                                            </div>
                                        </td>
                                        <td><?=$p['time']['VALUE']?></td>
                                        <td><?=$p['date']['VALUE']?></td>
                                        <td><?=(
										($p['price_full']['VALUE'])
										?
											$p['price_full']['VALUE']
										:
											$p['price']['VALUE'].'<span class="rouble">i</span>/мес')?></td>
                                        <td><a href="/local/windows/order_group.php?id=<?=$f['ID']?>" class="btn window-link">Записаться</a></div></td>
<?
?>
                                    </tr>
<?endforeach;?>





                                </tbody>
                            </table>
                        </div>
                        <!-- timetable list END -->

<?endforeach;?>