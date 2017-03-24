<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	$color = array(
		"red"=>"1",
		"green"=>"2",
		"blue"=>"3",
		"blue"=>"4",
		"brown"=>"5",
		"orange"=>"6",
		"purple"=>"7",
		"yellow"=>"8",
		"grey"=>"9",
		"lime"=>"10",
		"teal"=>"11",
		"blue-grey"=>"12",
	);
	$el = GetIBlockElement($_REQUEST['id']);
	
	//подключаем модуль инфоблок для работы с классом CIBlockSection
	if(CModule::IncludeModule("iblock")):
		$uf_arresult = CIBlockSection::GetList(Array("SORT"=>"­­ASC"), 
		Array("IBLOCK_ID" => 11, "ID" => $el['IBLOCK_SECTION_ID']));#el[]), false, $uf_name);
		if($uf_value = $uf_arresult->GetNext()):
			if(strlen($uf_value["UF_PAGE_LINK"]) > 0): //проверяем что поле заполнено
				$arItem["LINK"] = $uf_value["UF_PAGE_LINK"]; //подменяем ссылку и используем её в дальнейшем
			endif;
		endif;
	endif;

	if($el['PROPERTIES']['metro']['VALUE']){
		$mmm = GetIBlockElement($el['PROPERTIES']['metro']['VALUE']);
		$rsSections = CIBlockSection::GetList(
			Array('SORT'=>'ASC'), 
			Array('IBLOCK_ID'=>$mmm['IBLOCK_ID'],'ID'=>$mmm['IBLOCK_SECTION_ID']),
			false, 
			array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
		);
		$st = $rsSections->Fetch();

		//$st=GetIBlockSection($mmm['IBLOCK_SECTION_ID']);
		$mmm2 = array();
		$st2 = array();
		foreach($el['PROPERTIES']['metro2']['VALUE'] as $k=>$v){
			$mst=GetIBlockElement($v);
			$mmm2[]=$mst;
			$rsSections = CIBlockSection::GetList(
				Array('SORT'=>'ASC'), 
				Array('IBLOCK_ID'=>$mst['IBLOCK_ID'],'ID'=>$mst['IBLOCK_SECTION_ID']),
				false, 
				array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
			);
			$st2[] = $rsSections->Fetch();
		}
	}
	if( is_array( $el['PROPERTIES']['tel']['VALUE'] ) ){
		$el['PROPERTIES']['tel']['REAL'] = implode(', ', $el['PROPERTIES']['tel']['VALUE']);
	} else{
		$el['PROPERTIES']['tel']['REAL'] = $el['PROPERTIES']['tel']['VALUE'];
	}
?>

<div class="popup">
	<h3><?=$el['NAME']?></h3>
	<div class="popup-stations">
	<?if($el['PROPERTIES']['metro']['VALUE']){?>
		<div class="popup-station">
			<div class="popup-station-number metro-bg-<?=$st['UF_COLOR']?>"><?=$color[$st['UF_COLOR']]?></div>
			<div class="popup-station-title metro-text-<?=$st['UF_COLOR']?>"><?=$st['NAME']?></div>
			<div class="popup-station-text"><?=$mmm['NAME']?></div>
		</div>
		<?foreach($mmm2 as $k=>$v):?>
		<div class="popup-station">
			<div class="popup-station-number metro-bg-<?=$st2[$k]['UF_COLOR']?>"><?=$color[$st2[$k]['UF_COLOR']]?></div>
			<div class="popup-station-title metro-text-<?=$st2[$k]['UF_COLOR']?>"><?=$st2[$k]['NAME']?></div>
			<div class="popup-station-text"><?=$v['NAME']?></div>
		</div>
		<?endforeach;?>
	<?}?>
	</div>
	<div class="popup-address"><?=$el['PROPERTIES']['address']['VALUE']?></div>
	<div class="popup-phone"><?=$el['PROPERTIES']['tel']['REAL'];?></div>
	<hr />
	<div class="schedule">
	<?foreach($el['PROPERTIES']['work']['~VALUE'] as $k=>$v):?>
		<div class="schedule-row">
			<div class="schedule-row-name"><?=$v?></div>
			<div class="schedule-row-value"><?=$el['PROPERTIES']['work']['~DESCRIPTION'][$k]?></div>
		</div>
	<?endforeach;?>
	</div>
	<a href="<?=$el['DETAIL_PAGE_URL']?>" class="popup-btn">подробнее</a>
</div>