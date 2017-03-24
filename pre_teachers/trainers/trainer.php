<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
$prep=GetIBlockElement($_REQUEST['id']);
$prep["PREVIEW_PICTURE"]=CFile::GetFileArray($prep["PREVIEW_PICTURE"]);
?>
<div class="window-teacher">
    <div class="window-teacher-inner">
<?
if (is_array($prep["PREVIEW_PICTURE"])):
if ($prep["PREVIEW_PICTURE"]["WIDTH"]>170 && $prep["PREVIEW_PICTURE"]["HEIGHT"]>170){
	$w=170;
	$h=170;
}elseif($prep["PREVIEW_PICTURE"]["WIDTH"]<=170){
	$w=$prep["PREVIEW_PICTURE"]["WIDTH"];
	$h=$prep["PREVIEW_PICTURE"]["WIDTH"];
}else{
	$w=$prep["PREVIEW_PICTURE"]["HEIGHT"];
	$h=$prep["PREVIEW_PICTURE"]["HEIGHT"];
}

if($prep["PREVIEW_PICTURE"]["WIDTH"]<=170 && $prep["PREVIEW_PICTURE"]["WIDTH"]<$w){
	$w=$prep["PREVIEW_PICTURE"]["WIDTH"];
	$h=$prep["PREVIEW_PICTURE"]["WIDTH"];
}
if($prep["PREVIEW_PICTURE"]["HEIGHT"]<=170 && $prep["PREVIEW_PICTURE"]["HEIGHT"]<$h){
	$w=$prep["PREVIEW_PICTURE"]["HEIGHT"];
	$h=$prep["PREVIEW_PICTURE"]["HEIGHT"];
}


	$prep["PREVIEW_PICTURE"]=CFile::ResizeImageGet($prep["PREVIEW_PICTURE"], array('width'=>$w, 'height'=>$h), BX_RESIZE_IMAGE_EXACT, true);
	if (!$prep["PREVIEW_PICTURE"]['SRC'])
	$prep["PREVIEW_PICTURE"]['SRC']=$prep["PREVIEW_PICTURE"]['src'];
endif;
	?>
                            <!-- teacher -->
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($prep["PREVIEW_PICTURE"])):?>
		<div class="window-teacher-photo"><img
						src="<?=$prep["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$prep["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$prep["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$prep["NAME"]?>"
						title="<?=$prep["NAME"]?>"
						/></div>
		<?endif?>
        <div class="window-teacher-text">
            <div class="window-teacher-name"><strong><?=$prep['NAME']?>,</strong> <?=$prep['PROPERTIES']['country']['VALUE']?></div>
            <div class="window-teacher-name-eng"><?if ($prep['PROPERTIES']['name_en']['VALUE']) echo $prep['PROPERTIES']['name_en']['VALUE']?></div>

            <div class="teacher-details">
			<?if ($prep['PROPERTIES']['obr']['VALUE']):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Образование и квалификация</div>
                    <div class="teacher-details-value"><strong><?=$prep['PROPERTIES']['obr']['VALUE']?></strong></div>
                </div>
			<?endif;?>
			<?if (is_array($prep['PROPERTIES']['courses']['VALUE']) && count($prep['PROPERTIES']['courses']['VALUE'])>0):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Ведет курсы</div>
                    <div class="teacher-details-value">
					<?
					$curs=array();
					foreach($prep['PROPERTIES']['courses']['VALUE'] as $k=>$v){
					
					$c=GetIBlockElement($v);
					$curs[]='<a href="'.$c['DETAIL_PAGE_URL'].'">'.(($c['PROPERTIES']['trainer_name']['VALUE'])?$c['PROPERTIES']['trainer_name']['VALUE']:$c['NAME']).'</a>';
					}
					print(implode(', ',$curs));
					?>
					</div>
                </div>
			<?endif;?>
            </div>
			<?=$prep['PREVIEW_TEXT']?>
        </div>
    </div>
</div>