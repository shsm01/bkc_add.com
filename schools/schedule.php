<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Расписание курсов");
$arFilter = Array("IBLOCK_ID"=>11, 'CODE'=>$_REQUEST['SECTION_CODE'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter);
$ob = $res->GetNext();

//$arrFilter=Array('PROPERTY_school'=>$ob['ID']);
?><?

$id=$arResult['ID'];
$filter=Array('IBLOCK_ID'=>28,
'PROPERTY_school'=>$ob['ID']
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
$f=$ob->GetFields();
$p=$ob->GetProperties();
$course=-1;
if ($p['course']['VALUE'])$course=$p['course']['VALUE'];
if ($p['course2']['VALUE'])$course=$p['course2']['VALUE'];
if ($p['course3']['VALUE'])$course=$p['course3']['VALUE'];
if ($p['course4']['VALUE'])$course=$p['course4']['VALUE'];
if ($p['course5']['VALUE'])$course=$p['course5']['VALUE'];
if ($p['course6']['VALUE'])$course=$p['course6']['VALUE'];
$rasp[$course][]=array('p'=>$p,'f'=>$f);

endwhile;
?>

<?foreach ($rasp as $course=>$r):
$ar_cour=array();
$cour_el=GetIBlockElement($course);
$cour_sec=GetIBlockSection($cour_el['IBLOCK_SECTION_ID']);
$ar_cour[]=$cour_sec;
$i=1;
while(($cour_sec['DEPTH_LEVEL']>1)&&$i<5){
$cour_sec=GetIBlockSection($cour_sec['IBLOCK_SECTION_ID']);
$ar_cour[]=$cour_sec;
$i++;
}

$str_cour='<span></span>'.$cour_el['NAME'];
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





<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>