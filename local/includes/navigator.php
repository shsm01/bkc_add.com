<?
if (CModule::IncludeModule("iblock")):?>
<?
require(".lang-codes.php");

foreach($curs as $k=>$v)
  $curs_id[]=$v["BID"];

$res = CIBlock::GetList(
    Array(), 
    Array(
        "ID"=>$curs_id
    ), false
);

$curs = array();

while($ar_res = $res->Fetch())
{
    $curs[$ar_res["ID"]]["DESC"] = $ar_res; 
}

  //получаем базовые иблоки
  $arFilter = Array('IBLOCK_ID'=>array(16,19,20,21,22,23), 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>1);
  $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
  $gr=array();


  while ($ar=$db_list->GetNext(true,false)){

     if ($ar['CODE'] == 'programs') {
         $ar['CODE'] = 'english';
//        echo $ar['CODE']."<br />";
     }
  
    $gr[$ar['CODE']][]=$ar;
  }

?>
                <!-- navigator -->
                <div class="navigator">
                    <div class="navigator-title">Навигатор по самым интересным<br />программам и курсам</div>
                    <!-- navigator container -->
                    <div class="navigator-container">
                        <!-- navigator langs -->
                        <div class="navigator-langs">
                            <div class="navigator-langs-list">
=

<?

$arr_lvl2=array();
//$arr_lvl2_elem=array();
$act=0;
// print_r($lang_cl);

foreach($gr as $code=>$lang)://языки вывод флага и наименования начало
if ($act++==0)
print('
                                    <div class="navigator-langs-list-item active"><a href="#" class="navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></div>
');
else
print('
                                    <div class="navigator-langs-list-item"><a href="#" class="navigator-lang-'.$lang_cl[$code].'">'.$lang[0]['NAME'].'</a></div>
');

$arr_ID=array();


foreach($lang as $v_lang){

// var_dump($lang);
// echo "++++++++++++";

  $arr_ID[$v_lang['IBLOCK_ID']][]=$v_lang['ID'];
//  print_r($v_lang['ID'].' - '.$v_lang['NAME'].' - '.$v_lang['IBLOCK_ID'].', ');
//  echo "++++++++++++";
}
// print_r($arr_ID);
// var_dump($arr_ID[0][0]);
// var_dump($curs);
// echo "++++++++++++";

		foreach($curs as $BID=>$vvvv):
		  $arFilter = Array('IBLOCK_ID'=>$BID, 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>2,'SECTION_ID'=>$arr_ID[$BID]);
		  $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);

		  while($ar = $db_list->GetNext())
		  {
//			  print($ar['IBLOCK_ID'].', ');
			$arr_lvl2[$code][$ar['IBLOCK_ID']][]=$ar;
//      var_dump($arr_lvl2);
// echo "++++++++++++";

		  }

		  $arFilter = Array('IBLOCK_ID'=>$BID, 'ACTIVE'=>'Y','SECTION_ID'=>$arr_ID[$BID]);
		  $db_list = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
		  while($ar = $db_list->GetNext())
		  {
//			  print($ar['IBLOCK_ID'].', ');
			$arr_lvl2[$code][$ar['IBLOCK_ID']][]=$ar;
//      var_dump($arr_lvl2);


		  }

		endforeach;

// echo "<p>dcsdfsdfsdfsdfsdfsdf</p>";


endforeach;//языки вывод конец (здесь же получили разделы второго уровня)
//print_r($arr_lvl2_elem);
?>
==
                            </div>
                            <a href="#" class="navigator-langs-prev"></a>
                            <a href="#" class="navigator-langs-next"></a>
                        </div>
                        <!-- navigator langs END -->

                        <!-- navigator tabs -->
                        <div class="navigator-tabs">

<?$l_act=0;?>

<?foreach($arr_lvl2 as $code=>$lvl2)://Начало вывода табов языковых?>
<?
// var_dump($lvl2);
// echo "++++++++++++";
?>

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
	<?
	$l2_act=0;
//	 var_dump($lvl3);
  foreach($lvl2 as $BID=>$lvl3)://Начало вывода разделов

// echo($l2_act);
  ?>
  <?if ($l2_act==0):?>
                  <div class="navigator-sections-current"><?=$curs[$BID]["DESC"]['NAME']?></div>
									<ul>
										<li class="active"><a href="#"><?=$curs[$BID]["DESC"]['NAME']?></a></li>
	<?else:?>
										<li><a href="#"><?=$curs[$BID]["DESC"]['NAME']?></a></li>
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
										<h2><?=$curs[$BID]["DESC"]['NAME']?></h2>
										<?
										if (strpos('<p>',$curs[$BID]['DESC']['DESCRIPTION'])!==false)
										print($curs[$BID]['DESC']['DESCRIPTION']);
										else
										print('<p>'.$curs[$BID]['DESC']['DESCRIPTION'].'</p>');
										?>



                                            <div class="navigator-info-cols">
		<?
		$cols_3=array();
		$i=0;
		foreach($lvl3 as $v_l3):
			$i++;
			$class='03';
			foreach($progr as $k=>$v3)
				if (strpos($v_l3['NAME'],$k)!==false){$class=$v3;break;}

//Проверка это курс или раздел (для преподавателей)
if (strlen($v_l3['DETAIL_PAGE_URL'])>0):
			$cols_3[$i%2].='
                                                    <div class="navigator-info-item">
                                                        <div><a href="'.$v_l3['DETAIL_PAGE_URL'].'"><span>'.$v_l3['NAME'].'</span></a></div>
                                                    </div>
		
			';

else:
	//$res=CIBlockSection::GetList(array('SORT'=>'ASC','ID'=>'ASC'),array('IBLOCK_ID'=>$v_l3['IBLOCK_ID'],'ID'=>$_REQUEST['SECTION_CODE']));
	//$sec=$res->GetNext();

	$res=CIBlockElement::GetList(
	array('SORT'=>'ASC'),
	array('IBLOCK_ID'=>$v_l3['IBLOCK_ID'],'SECTION_ID'=>$v_l3['ID'])
	);
	$content='';
	while($el=$res->GetNext()):

    $pos = strpos($el['DETAIL_PAGE_URL'], "/languages/english/") ;

          if ( $pos !== false ) {
             $pieces = explode("/", $el['DETAIL_PAGE_URL']);
             $pieces[1] = "learn_english"; 
             array_splice($pieces,2,1);
             $el['DETAIL_PAGE_URL'] = implode("/", $pieces);
          }


                

		$content.='
																		<li><a href="'.$el['DETAIL_PAGE_URL'].'">'.$el['NAME'].'</a></li>
		';
	endwhile;

	if ($content==''):
		$res=CIBlockSection::GetList(
		array('SORT'=>'ASC','ID'=>'ASC'),
		array('IBLOCK_ID'=>$v_l3['IBLOCK_ID'],'SECTION_ID'=>$v_l3['ID'])
		);
		$content='';
		while($el=$res->GetNext()):
		$content.='
																		<li><a href="'.$el['SECTION_PAGE_URL'].'">'.$el['NAME'].'</a></li>
		';
		endwhile;

	endif;
				$cols_3[$i%2].='
														<div class="navigator-info-item">
															<div class="navigator-info-item-title"><a href="#">
															<img src="/local/layout/images/lang-icon-'.$class.'.png" alt="" width="40" height="40" /><img src="/local/layout/images/mobile-lang-icon-'.$class.'-a.png" alt="" width="60" height="60" />

															<span>'.$v_l3['NAME'].'</span></a></div>
															<div class="navigator-info-item-detail">
																<ul>
																	'.$content.'
																</ul>
																<a href="#" class="navigator-info-item-detail-close"></a>
															</div>
														</div>
			
				';
endif;
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
                                            <?if(0){?><div class="navigator-info-cols-ctrl"></div><?}?>

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


