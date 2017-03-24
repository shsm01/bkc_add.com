<?
if (CModule::IncludeModule("iblock")):?>
<?
$lang_pic='london';
$p=$APPLICATION->GetCurPage();
$b_arr=array(16,19,23,21,22,20);
$bid=0;
if (strpos('/abroad/',$p)!==false)$bid=22;
if (strpos('/adult/',$p)!==false)$bid=16;
if (strpos('/children/',$p)!==false)$bid=19;
if (strpos('/corporate/',$p)!==false)$bid=23;
if (strpos('/international/',$p)!==false)$bid=21;
if (strpos('/teachers/',$p)!==false)$bid=20;

if($bid!=0)$b_arr=$bid;

	if ($_REQUEST['SECTION_CODE']):
		$sec_res=CIBlockSection::GetList(array(),array('IBLOCK_ID'=>$b_arr,'CODE'=>$_REQUEST['SECTION_CODE']));
		$sec=$sec_res->GetNext();
		while($sec['DEPTH_LEVEL']>1):
			$sec_res=CIBlockSection::GetList(array(),array('ID'=>$sec['IBLOCK_SECTION_ID']));
			$sec=$sec_res->GetNext();
		endwhile;
	endif;
	if ($sec['CODE']=='kursy-angliyskogo-yazyka')$lang_pic='london';
	if ($sec['CODE']=='kursy-nemetskogo-yazyka')$lang_pic='berlin';
	if ($sec['CODE']=='kursy-frantsuzskogo-yazyka')$lang_pic='paris';
	if ($sec['CODE']=='kursy-ispanskogo-yazyka')$lang_pic='barcelona';
	if ($sec['CODE']=='kursy-italyanskogo-yazyka')$lang_pic='rome';
	if ($sec['CODE']=='kursy-cheshskogo-yazyka')$lang_pic='prague';
	if ($sec['CODE']=='kursy-arabskogo-yazyka')$lang_pic='dubai';
	if ($sec['CODE']=='kursy-yaponskogo-yazyka')$lang_pic='tokyo';
endif;
?>