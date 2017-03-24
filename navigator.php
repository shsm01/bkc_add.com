<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (CModule::IncludeModule("iblock")):?>
<?
$lang_cl=array(
'kursy-angliyskogo-yazyka'=>'01', 
'kursy-nemetskogo-yazyka'=>'02',
'kursy-frantsuzskogo-yazyka'=>'03',
'kursy-italyanskogo-yazyka'=>'04',
'kursy-ispanskogo-yazyka'=>'05',
'kursy-kitayskogo-yazyka'=>'06',
'kursy-yaponskogo-yazyka'=>'07',
'kursy-cheshskogo-yazyka'=>'08',
'kursy-arabskogo-yazyka'=>'09',
'kursy-portugalskogo-yazyka'=>'10',
'kursy-grecheskogo-yazyka'=>'11',
'russian-course'=>'12',
);
$progr=array(
'Летние программы'=>'01',
'Экспресс программы'=>'02',
'Академический английский'=>'03',
'Интенсивные курсы'=>'04',
'Однодневные тренинги'=>'05',
'Общий курс для взрослых'=>'06',
'Деловой английский для взрослых'=>'07',
'Разговорные курсы и клубы'=>'08',
'Международные программы'=>'09',
'Индивидуальное обучение'=>'10',
'Обучение по Skype'=>'11',
'Английский по доступным ценам'=>'12',
);

$curs=array(
'16'=>array('NAME'=>'Курсы для&nbsp;взрослых','class'=>'1'),
'19'=>array('NAME'=>'Курсы&nbsp;для&nbsp;детей и&nbsp;подростков','class'=>'2'),
'20'=>array('NAME'=>'Курсы для преподавателей','class'=>'3'),
'21'=>array('NAME'=>'Международные экзамены','class'=>'4'),
'22'=>array('NAME'=>'Обучение за рубежом','class'=>'5'),
'23'=>array('NAME'=>'Корпоративное обучение','class'=>'6'),

);
foreach($curs as $k=>$v)
$curs[$k]['DESC']=GetIBlock($k);

  $arFilter = Array('IBLOCK_ID'=>array(16,19,20,21,22,23), 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>1);
  $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
$gr=array();
while ($ar=$db_list->GetNext(true,false))
$gr[$ar['CODE']][]=$ar;
?>
                <!-- navigator -->
                <div class="navigator">
                    <div class="navigator-title">Навигатор по самым интересным<br />программам и курсам</div>
                    <!-- navigator container -->
                    <div class="navigator-container">
                        <!-- navigator langs -->
                        <div class="navigator-langs">
                            <div class="navigator-langs-list">
                                <ul>

<?
$arr_lvl2=array();
$act=0;
foreach($gr as $code=>$lang)://языки вывод начало
if ($act==0)
print('
                                    <li class="active"><a href="#" class="navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></li>
');
else
print('
                                    <li><a href="#" class="navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></li>
');
$act=1;
$arr_ID=array();
foreach($lang as $v_lang){
$arr_ID[$v_lang['IBLOCK_ID']][]=$v_lang['ID'];
//print_r($v_lang['ID'].' - '.$v_lang['NAME'].' - '.$v_lang['IBLOCK_ID'].', ');
}
//print_r($arr_ID);
		foreach($curs as $BID=>$vvvv):
		  $arFilter = Array('IBLOCK_ID'=>$BID, 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>2,'SECTION_ID'=>$arr_ID[$BID]);
		  $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
		  while($ar = $db_list->GetNext())
		  {
			  print($ar['IBLOCK_ID'].', ');
			$arr_lvl2[$code][$ar['IBLOCK_ID']][]=$ar;
		  }
		endforeach;
endforeach;//языки вывод конец (здесь же получили разделы второго уровня)
?>
                                </ul>
                            </div>
                            <a href="#" class="navigator-langs-prev"></a>
                            <a href="#" class="navigator-langs-next"></a>
                        </div>
                        <!-- navigator langs END -->

                        <!-- navigator tabs -->
                        <div class="navigator-tabs">
<?$l_act=0;?>
<?foreach($arr_lvl2 as $code=>$lvl2)://Начало вывода табов языковых?>
	<?if ($l_act==0):?>
							<!-- navigator tab -->
							<div class="navigator-tab active">
	<?else:?>
							<!-- navigator tab -->
							<div class="navigator-tab">
	<?endif;
	$l_act=1;
	?>
								<!-- navigator sections -->
								<div class="navigator-sections">
									<ul>
	<?
	$l2_act=0;
	foreach($lvl2 as $BID=>$lvl3)://Начало вывода разделов?>
	<?=$BID.', '?>
	<?if ($l2_act==0):?>
										<li class="active"><a href="#"><?=$curs[$BID]['NAME']?></a></li>
	<?else:?>
										<li><a href="#"><?=$curs[$BID]['NAME']?></a></li>
	<?endif;
	$l2_act=1;?>
	<?endforeach;//Конец вывода разделов?>
									</ul>
								</div>
								<!-- navigator sections END -->
                                <!-- navigator sections tabs -->
                                <div class="navigator-sections-tabs">
	<?
	$l2_act=0;
	foreach($lvl2 as $BID=>$lvl3)://Начало вывода разделов tabs?>
	<?if ($l2_act==0):?>
									<!-- navigator sections tab -->
                                    <div class="navigator-sections-tab active">
	<?else:?>
									<!-- navigator sections tab -->
                                    <div class="navigator-sections-tab">
	<?endif;
	$l2_act=1;?>

                                        <!-- navigator info -->
                                        <div class="navigator-info">
										<h2><?=$curs[$BID]['NAME']?></h2>
										<?print_r($curs[$BID]['DESC']['DESCRIPTION']);?>



                                            <div class="navigator-info-cols">
		<?
		$cols_3=array();
		$i=0;
		foreach($lvl3 as $v_l3):
			$i++;
			$class='';
			foreach($progr as $k=>$v3)
				if (strpos($v_l3['NAME'],$k)!==false){$class=$v3;break;}

			$cols_3[$i%2].='
                                                    <div class="navigator-info-item">
                                                        <div class="navigator-info-item-title"><a href="#"><strong class="navigator-info-item-'.$class.'"></strong><span>'.$v_l3['NAME'].'</span></a></div>
                                                        <div class="navigator-info-item-detail">
                                                            <ul>
                                                                <li><a href="#">Тут будут в будущем курсы</a></li>
                                                            </ul>
                                                            <a href="#" class="navigator-info-item-detail-close"></a>
                                                        </div>
                                                    </div>
		
			';
		endforeach;
		foreach($cols_3 as $col)
		print('
												<div class="navigator-info-col">
'.$col.'
												</div>
		
		');
		?>

												

                                            </div>
											<!-- cols END -->

                                        </div>
                                        <!-- navigator info END -->

                                        <!-- order -->
                                        <div class="order">
                                            <h2>Сложно выбрать?</h2>
                                            <div class="order-text">Оставьте заявку, и наши специалисты помогут найти максимально подходящий для вас курс!</div>
                                            <form action="#" method="post">
                                                <div class="form-row">
                                                    <div class="form-label">Ваш телефон</div>
                                                    <div class="form-field">
                                                        <div class="form-input"><input type="text" name="phone" value="" class="required maskPhone" /></div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-label">Уровень языка</div>
                                                    <div class="form-field">
                                                        <div class="form-select">
                                                            <select name="level" data-placeholder="Уровень языка" class="required">
                                                                <option value=""></option>
                                                                <option value="1">Начинающий</option>
                                                                <option value="2">Средний</option>
                                                                <option value="3">Высокий</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-label">Удобное время занятий</div>
                                                    <div class="form-field">
                                                        <div class="form-radios">
                                                            <div class="form-radio"><span><input type="radio" name="time" value="1" checked="checked" /></span>Любое</div>
                                                            <div class="form-radio"><span><input type="radio" name="time" value="2" /></span>Утро</div>
                                                            <div class="form-radio"><span><input type="radio" name="time" value="3" /></span>День</div>
                                                            <div class="form-radio"><span><input type="radio" name="time" value="4" /></span>Вечер</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-submit"><input type="submit" value="Подать заявку" /></div>
                                            </form>
                                        </div>
                                        <!-- order END -->

                                        <!-- navigator banners -->
                                        <div class="navigator-banners">
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
                                        <!-- navigator banners END -->
                                    </div>
                                    <!-- navigator sections tab END -->



	<?endforeach;//Конец вывода разделов tabs?>
                                </div>
                                <!-- navigator sections tabs END -->

                            </div>
                            <!-- navigator tab END -->

<?endforeach;//Конец вывода табов языковых?>
                        </div>
                        <!-- navigator tabs END -->

                    </div>
                    <!-- navigator container END -->
                </div>
                <!-- navigator END -->

<?endif;//includemodule?>


