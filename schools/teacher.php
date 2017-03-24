<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
$prep=GetIBlockElement($_REQUEST['id']);
$prep["DETAIL_PICTURE"]=CFile::GetFileArray($prep["DETAIL_PICTURE"]);
?>
<div class="window-teacher">
    <div class="window-teacher-inner">
<?
if (is_array($prep["DETAIL_PICTURE"])):
if ($prep["DETAIL_PICTURE"]["WIDTH"]>170 && $prep["DETAIL_PICTURE"]["HEIGHT"]>170){
	$w=170;
	$h=170;
}elseif($prep["DETAIL_PICTURE"]["WIDTH"]<=170){
	$w=$prep["DETAIL_PICTURE"]["WIDTH"];
	$h=$prep["DETAIL_PICTURE"]["WIDTH"];
}else{
	$w=$prep["DETAIL_PICTURE"]["HEIGHT"];
	$h=$prep["DETAIL_PICTURE"]["HEIGHT"];
}

if($prep["DETAIL_PICTURE"]["WIDTH"]<=170 && $prep["DETAIL_PICTURE"]["WIDTH"]<$w){
	$w=$prep["DETAIL_PICTURE"]["WIDTH"];
	$h=$prep["DETAIL_PICTURE"]["WIDTH"];
}
if($prep["DETAIL_PICTURE"]["HEIGHT"]<=170 && $prep["DETAIL_PICTURE"]["HEIGHT"]<$h){
	$w=$prep["DETAIL_PICTURE"]["HEIGHT"];
	$h=$prep["DETAIL_PICTURE"]["HEIGHT"];
}


	$prep["DETAIL_PICTURE"]=CFile::ResizeImageGet($prep["DETAIL_PICTURE"], array('width'=>$w, 'height'=>$h), BX_RESIZE_IMAGE_EXACT, true);
	if (!$prep["DETAIL_PICTURE"]['SRC'])
	$prep["DETAIL_PICTURE"]['SRC']=$prep["DETAIL_PICTURE"]['src'];
endif;
	?>
                            <!-- teacher -->
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($prep["DETAIL_PICTURE"])):?>
		<div class="window-teacher-photo"><img
						src="<?=$prep["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$prep["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$prep["DETAIL_PICTURE"]["HEIGHT"]?>"
						alt="<?=$prep["NAME"]?>"
						title="<?=$prep["NAME"]?>"
						/></div>
		<?endif?>
        <div class="window-teacher-text">
            <div class="window-teacher-name"><strong><?=$prep['NAME']?>,</strong> <?=$prep['PROPERTIES']['country']['VALUE']?></div>
            <div class="window-teacher-name-eng"><?=$prep['PROPERTIES']['name_en']['VALUE']?></div>

            <div class="teacher-details">
			<?if ($prep['PROPERTIES']['obr']['VALUE']):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Образование и квалификация</div>
                    <div class="teacher-details-value"><strong><?=$prep['PROPERTIES']['obr']['VALUE']?></strong></div>
                </div>
			<?endif;?>
			<?if (count($prep['PROPERTIES']['school']['VALUE'])>0):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Преподает в школах</div>
                    <div class="teacher-details-value">
					<?
					$sch=array();
					foreach($prep['PROPERTIES']['school']['VALUE'] as $v){
					$s=GetIBlockElement($v);
					$sch[]='<a href="'.$s['DETAIL_PAGE_URL'].'">'.$s['NAME'].'</a>';
					}
					print(explode(', ',$sch));
					?>
					</div>
                </div>
			<?endif;?>
			<?if (count($prep['PROPERTIES']['curs']['VALUE'])>0):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Ведет курсы</div>
                    <div class="teacher-details-value">
					<?
					
					$curs=array();
					foreach($prep['PROPERTIES']['curs']['VALUE'] as $v){
					$c=GetIBlockElement($v);
					$curs[]='<a href="'.$c['DETAIL_PAGE_URL'].'">'.$c['NAME'].'</a>';
					}
					print(explode(', ',$curs));
					?>
					</div>
                </div>
			<?endif;?>
			<?if ($prep['PROPERTIES']['vk']['VALUE'] || $prep['PROPERTIES']['fb']['VALUE'] || $prep['PROPERTIES']['ok']['VALUE'] || $prep['PROPERTIES']['ln']['VALUE']):?>
                <div class="teacher-details-row">
                    <div class="teacher-details-name">Социальные аккаунты</div>
                    <div class="teacher-details-value">
                        <?if ($prep['PROPERTIES']['vk']['VALUE']):?><a href="<?=$prep['PROPERTIES']['vk']['VALUE']?>" class="teacher-details-social teacher-details-social-1"></a><?endif;?>
                        <?if($prep['PROPERTIES']['fb']['VALUE']):?><a href="<?=$prep['PROPERTIES']['fb']['VALUE']?>" class="teacher-details-social teacher-details-social-2"></a><?endif;?>
                        <?if($prep['PROPERTIES']['ok']['VALUE']):?><a href="<?=$prep['PROPERTIES']['ok']['VALUE']?>" class="teacher-details-social teacher-details-social-3"></a><?endif;?>
                        <?if($prep['PROPERTIES']['ln']['VALUE']):?><a href="<?=$prep['PROPERTIES']['ln']['VALUE']?>" class="teacher-details-social teacher-details-social-4"></a><?endif;?>
                    </div>
                </div>
			<?endif;?>
            </div>
			<?=$prep['DETAIL_TEXT']?>
            
			<?if (count($prep['PROPERTIES']['links']['~VALUE'])>0):?>
            <h4>Внешние ссылки</h4>
            <ul>
<?					foreach($prep['PROPERTIES']['links']['~VALUE'] as $k=>$v){
					print('<li><a href="'.$v.'">'.$prep['PROPERTIES']['links']['~DESCRIPTION'][$k].'</a></li>');
					}
?>
				<!-- <li><a href="#">ВКС Кунцево</a></li>
                <li><a href="#">ВКС Полежаевская</a></li>
                <li><a href="#">Курсы английского для взрослых</a></li>
                <li><a href="#">Деловой английский</a></li>
                <li><a href="#">Летние программы 2016</a></li>
 -->            </ul>
			<?endif;?>
        </div>
    </div>
</div>