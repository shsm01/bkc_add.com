<?
if (CModule::IncludeModule("iblock")):
	require($_SERVER["DOCUMENT_ROOT"]."/local/includes/.lang-codes.php");

?>
<ul class="nav-menu">
	<?
$section_code_bid=-1;
/*if ($_REQUEST['SECTION_CODE']):
		$arFilter = Array('CODE'=>$_REQUEST['SECTION_CODE']);
		$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
		$sec=$db_list->GetNext();
		$section_code_bid=$sec['IBLOCK_ID'];
endif;
*/
	foreach($curs as $nav=>$cur):

		if(strpos($APPLICATION->GetCurPage(),'/'.$cur['sect'].'/')!==false)$section_code_bid=$cur['BID'];

		$arIBlock = GetIBlock($cur['BID']);

                if ($cur['BID'] == 23):
//                   var_dump ($arIBlock);
                   $arIBlock['LIST_PAGE_URL'] .= "advantages/";
//                   echo $arIBlock['LIST_PAGE_URL']."  ". $cur['NAME'];

		endif;

//		print_r($arIBlock['LIST_PAGE_URL']);
		$arFilter = Array('IBLOCK_ID'=>$cur['BID'], 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>1);
		$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
		$act=0;
		$arr_lvl=array();
		$class_bid='';
		if ($cur['BID']==$section_code_bid)$class_bid=' active';
		if ($db_list->result->num_rows<=0):
			print('
			<li class="nav-menu-with-submenu'.$class_bid.'">
			<a href="'.$arIBlock['LIST_PAGE_URL'].'"><span class="nav-menu-'.$nav.'"></span>'.$cur['NAME'].'</a>
			</li>
			');
			continue;
		endif;
	?>
			<li class="nav-menu-with-submenu<?=$class_bid?>">
				<a href="<?=$arIBlock['LIST_PAGE_URL']?>"><span class="nav-menu-<?=$nav?>"></span><?=$cur['NAME']?></a>

				<!-- submenu -->
				<div class="submenu">
					<!-- submenu langs -->
					<div class="submenu-langs">
						<div class="submenu-langs-list">
							<ul>
<?
	while($ar = $db_list->GetNext()){
	$arFilter_el = Array('IBLOCK_ID'=>$ar['IBLOCK_ID'], 'ACTIVE'=>'Y','SECTION_ID'=>$ar['ID'],'INCLUDE_SUBSECTIONS'=>'Y');
	$el_res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter_el, false, Array("nPageSize"=>1));
		if ($el= $el_res->GetNext()){
			$arr_lvl[] = $ar['ID'];
			if($act==0)print('<li class="active"><a href="'.$ar['SECTION_PAGE_URL'].'" class="submenu-lang-'.$lang_cl[$ar['CODE']].'">'.$ar['NAME'].'</a></li>');
			else print('<li><a href="'.$ar['SECTION_PAGE_URL'].'" class="submenu-lang-'.$lang_cl[$ar['CODE']].'">'.$ar['NAME'].'</a></li>');
			$act = 1;
		}
	}

//Получим элементы из разделов 1 уровня (если есть, например у преподавателей)
	$arFilter = Array('IBLOCK_ID'=>$cur['BID'], 'ACTIVE'=>'Y','SECTION_ID'=>$arr_lvl);
	$db_list = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
	$arr_lvl2_elem = array();
//	print_r($arFilter);
//	print_r($db_list);
	while($ar = $db_list->GetNext()){
		$arr_lvl2_elem[$ar['IBLOCK_SECTION_ID']][]=$ar;
	}

//Разделы 2 уровня	
	$arFilter = Array('IBLOCK_ID'=>$cur['BID'], 'GLOBAL_ACTIVE'=>'Y','DEPTH_LEVEL'=>2);
	$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
	$act2 = 0;
	$arr_lvl2 = array();
	while($ar = $db_list->GetNext()){
		$arr_lvl2[$ar['IBLOCK_SECTION_ID']][]=$ar;
	}

?>
							</ul>
						</div>
						<a href="#" class="submenu-langs-prev disabled"></a>
						<a href="#" class="submenu-langs-next disabled"></a>
					</div>
					<!-- submenu langs END -->

					<!-- submenu tabs -->
					<div class="submenu-tabs">
<?
	$act3 = 0;
	foreach($arr_lvl as $v){
		if ($act3==0)
			print('
									<!-- submenu tab -->
									<div class="submenu-tab active">');
		else
			print('
									<!-- submenu tab -->
									<div class="submenu-tab">');
			print('
										<!-- submenu info -->
										<div class="submenu-info">
											<div class="submenu-info-cols">');
//Если есть разделы, выводим разделы, иначе пробуем курсы
if (count($arr_lvl2[$v])>0):
	$act3 = 1;
	$col = array();
	$i = 0;
	foreach($arr_lvl2[$v] as $v2){
		$i++;
		$class='03';
		foreach($progr as $k=>$v3)
			if (strpos($v2['NAME'],$k)!==false){$class=$v3;break;}
				$col[$i%3].='<div class="submenu-info-item"><a href="'.$v2['SECTION_PAGE_URL'].'"><span><img src="/local/layout/images/lang-icon-'.$class.'.png" alt="" width="40" height="40" /><img src="/local/layout/images/lang-icon-'.$class.'-a.png" alt="" width="40" height="40" />'.$v2['NAME'].'</span></a></div>';
	}
else:
	$act3 = 1;
	$col = array();
	$i = 0;
	foreach($arr_lvl2_elem[$v] as $v2){
		$i++;
		$class='03';
		foreach($progr as $k=>$v3)
			if (strpos($v2['NAME'],$k)!==false){$class=$v3;break;}
				$col[$i%3].='<div class="submenu-info-item"><a href="'.$v2['DETAIL_PAGE_URL'].'"><span><img src="/local/layout/images/lang-icon-'.$class.'.png" alt="" width="40" height="40" />'.$v2['NAME'].'</span></a></div>';
	}
endif;
	foreach($col as $v3)
		print('<div class="submenu-info-col">'.$v3.'</div>');
?>
						</div>
					</div>
					<!-- submenu info END -->
<?/*
					<!-- submenu banners -->
					<div class="submenu-banners">
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
					<!-- submenu banners END -->
*/?>
				</div>
				<!-- submenu tab END -->


<?}?>
			</div>
			<!-- submenu tabs END -->
		</div>
		<!-- submenu END -->

	</li>
<?
endforeach;
?>

</ul>
<?endif;?>