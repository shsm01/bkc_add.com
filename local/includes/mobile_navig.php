<?
if (CModule::IncludeModule("iblock") && 0):?>
<?
require(".lang-codes.php");
foreach($curs as $k=>$v)
$curs[$k]['DESC']=GetIBlock($k);

  $arFilter = Array('IBLOCK_ID'=>array(16,19,20,21,22,23), 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>1);
  $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
$gr=array();
while ($ar=$db_list->GetNext(true,false))
$gr[$ar['CODE']][]=$ar;
//print_r($gr);
?>
            <!-- mobile navigator -->
            <div class="mobile-navigator">
                <a href="#" class="mobile-navigator-link"></a>
                <div class="mobile-navigator-container">
                    <!-- mobile navigator langs -->
                    <div class="mobile-navigator-langs">
                        <div class="mobile-navigator-langs-list">
                            <ul>
<?
$arr_lvl2=array();
//$arr_lvl2_elem=array();
$act=0;
foreach($gr as $code=>$lang)://языки вывод начало
if ($act==0)
print('
                                    <li class="active"><a href="'.$lang[0]['SECTION_PAGE_URL'].'" class="mobile-navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></li>
');
else
print('
                                    <li><a href="'.$lang[0]['SECTION_PAGE_URL'].'" class="mobile-navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></li>
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
//			  print($ar['IBLOCK_ID'].', ');
			$arr_lvl2[$code][$ar['IBLOCK_ID']][]=$ar;
		  }

		  $arFilter = Array('IBLOCK_ID'=>$BID, 'ACTIVE'=>'Y','SECTION_ID'=>$arr_ID[$BID]);
		  $db_list = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
		  while($ar = $db_list->GetNext())
		  {
//			  print($ar['IBLOCK_ID'].', ');
			$arr_lvl2[$code][$ar['IBLOCK_ID']][]=$ar;
		  }

		endforeach;
endforeach;//языки вывод конец (здесь же получили разделы второго уровня)
//print_r($arr_lvl2_elem);
?>
                            </ul>
                        </div>
                    </div>
                    <!-- mobile navigator langs END -->

                    <!-- mobile navigator info tabs -->
                    <div class="mobile-navigator-info-tabs">

                        <!-- mobile navigator info tab -->
                        <div class="mobile-navigator-info-tab active">
                            <!-- mobile navigator info -->
                            <div class="mobile-navigator-info">
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-01"></strong><span>Летние программы 2016</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-02"></strong><span>Экспресс программы 2016</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-03"></strong><span>Академический английский</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-04"></strong><span>Интенсивные курсы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-05"></strong><span>Однодневные тренинги</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-06"></strong><span>Общий курс для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-07"></strong><span>Деловой английский для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-08"></strong><span>Разговорные курсы и клубы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-09"></strong><span>Международные программы в Москве</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-10"></strong><span>Индивидуальное обучение</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-11"></strong><span>Обучение по Skype</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-12"></strong><span>Английский по доступным ценам</span></a></div>
                            </div>
                            <!-- mobile navigator info END -->
                        </div>
                        <!-- mobile navigator info tab END -->

                        <!-- mobile navigator info tab -->
                        <div class="mobile-navigator-info-tab">
                            <!-- mobile navigator info -->
                            <div class="mobile-navigator-info">
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-07"></strong><span>Деловой английский для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-08"></strong><span>Разговорные курсы и клубы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-09"></strong><span>Международные программы в Москве</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-10"></strong><span>Индивидуальное обучение</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-11"></strong><span>Обучение по Skype</span></a></div>
                            </div>
                            <!-- mobile navigator info END -->
                        </div>
                        <!-- mobile navigator info tab END -->

                        <!-- mobile navigator info tab -->
                        <div class="mobile-navigator-info-tab">
                            <!-- mobile navigator info -->
                            <div class="mobile-navigator-info">
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-03"></strong><span>Академический английский</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-04"></strong><span>Интенсивные курсы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-05"></strong><span>Однодневные тренинги</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-06"></strong><span>Общий курс для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-07"></strong><span>Деловой английский для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-08"></strong><span>Разговорные курсы и клубы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-09"></strong><span>Международные программы в Москве</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-10"></strong><span>Индивидуальное обучение</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-11"></strong><span>Обучение по Skype</span></a></div>
                            </div>
                            <!-- mobile navigator info END -->
                        </div>
                        <!-- mobile navigator info tab END -->

                        <!-- mobile navigator info tab -->
                        <div class="mobile-navigator-info-tab">
                            <!-- mobile navigator info -->
                            <div class="mobile-navigator-info">
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-02"></strong><span>Экспресс программы 2016</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-03"></strong><span>Академический английский</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-04"></strong><span>Интенсивные курсы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-05"></strong><span>Однодневные тренинги</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-06"></strong><span>Общий курс для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-07"></strong><span>Деловой английский для взрослых</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-08"></strong><span>Разговорные курсы и клубы</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-09"></strong><span>Международные программы в Москве</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-10"></strong><span>Индивидуальное обучение</span></a></div>
                                <div class="mobile-navigator-info-item"><a href="#"><strong class="mobile-navigator-info-item-11"></strong><span>Обучение по Skype</span></a></div>
                            </div>
                            <!-- mobile navigator info END -->
                        </div>
                        <!-- mobile navigator info tab END -->

                    </div>
                    <!-- mobile navigator info tabs END -->
                </div>
            </div>
            <!-- mobile navigator END -->
<?
endif;?>