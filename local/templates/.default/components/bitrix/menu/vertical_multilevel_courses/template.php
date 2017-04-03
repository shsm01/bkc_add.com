<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>

                    <div class="course-menu-parent">
<?
	require($_SERVER["DOCUMENT_ROOT"]."/local/includes/.lang-codes.php");

$main='';

$main_0='';
$lev_0='english';

$lang_show=true;


foreach($arResult as $k=>$arItem){
  if(CSite::InDir($arItem["LINK"]))
    $arResult[$k]["SELECTED"] = true;
}


foreach($arResult as $k=>$arItem)
  if (isset($arItem['PARAMS']['NO_LANG'])){
    $lang_show = false;
    break;
  }

// var_dump($arResult);


$second='';

if ($lang_show):
  
  //Показывать английский когда не задан язык.
  $show_lang_eng=1;
  foreach($arResult as $k=>$arItem)

    if ($arItem['SELECTED']){//strpos($arItem['LINK'],'/c/')!==false && 
      $show_lang_eng=0;
      break;
    }
  if ($show_lang_eng == 1){
    foreach($arResult as $k=>$arItem)
    if (strpos($arItem['LINK'],'/english/')!==false ){
      $arResult[$k]['SELECTED']='1';
      //var_dump($arResult[$k]['SELECTED']);
      break;
    }
  }
  
  
  foreach($arResult as $k=>$arItem):
    if ($arItem["DEPTH_LEVEL"]==1):
    	$ccc='';
    	$arResult[$k]['VIEW']=0;
    	foreach($lang_cl as $c=>$v)
      	if (strpos($arItem['LINK'],$c)!==false){
          $ccc=$v;
          $arResult[$k]['VIEW']=1;
          break;
        }	
    
    	if (strpos($arItem['LINK'],$lev_0)!==false){$arResult[$k]['VIEW']=1;$main_0='
    						<a href="'.$arItem['LINK'].'" class="course-menu-parent-link course-menu-parent-link-'.$ccc.'">'.$arItem['TEXT'].'</a>	
    	';}
    	
    if ($arResult[$k]['VIEW']==0)continue;
    	if ($arItem['SELECTED']):
    	$main.='
    						<a href="'.$arItem['LINK'].'" class="course-menu-parent-link course-menu-parent-link-'.$ccc.'">'.$arItem['TEXT'].'</a>
    	';
    	else:
    	$second.='
                                <li><a href="'.$arItem['LINK'].'" class="course-menu-parent-other-'.$ccc.'">'.$arItem['TEXT'].'</a></li>
    	';
    	endif;
    endif;
  endforeach;
  
  if ($main=='')$main=$main_0;
  ?>
  						<?=$main?>
                          <ul>
  						<?=$second?>
  						</ul>
<?endif;?>
                    </div>
                    
                    
                    
                    <div class="course-menu-wrap">
                        <div class="course-menu">
                            <ul>
<?
function sel($arr,$id,$lvl){
  $ss=true;
  for ($i=$id;$i<count($arr);$i++)
    if ($arr[$i]['SELECTED'] && $arr[$i]['DEPTH_LEVEL']>$lvl){
      $ss=false;
      break;
    }
  return $ss;
}

$select=0;
$previousLevel = 0;
$show=0;
$course_show_menu=0;
foreach($arResult as $k=>$arItem):?>
<?
  if (($arItem["DEPTH_LEVEL"] == 1) && ($arItem["SELECTED"]))
    $show=1; 
  elseif(($arItem["DEPTH_LEVEL"] == 1)&& !($arItem["SELECTED"])) 
    $show=0;
  if ($show==0)continue;
?>
<?if ($arItem["DEPTH_LEVEL"] == 1)continue;?>
<?
	$ccc='03';
	foreach($progr as $c=>$v){
	 if (strpos($arItem['TEXT'],$c)!==false){
    $ccc=$v;
    break;
   }
	}
?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
<?$course_show_menu=1;?>
	<?if ($arItem["IS_PARENT"]):?>

			<li class="<?if ($arItem["SELECTED"]) if (sel($arResult,$k,$arItem["DEPTH_LEVEL"])):?>open active<?else:?>open<?endif?>"><a href="<?=$arItem["LINK"]?>"><div <?//=$arItem['DEPTH_LEVEL']?>><?if ($arItem['DEPTH_LEVEL']==2):?>
			
			<!-- <span class="course-menu-icon-<?=$ccc;?>"></span> -->
      <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>.png">
      <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>-a.png">
			
			<?endif;?><?=$arItem["TEXT"]?></div></a>
				<ul>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?if ($arItem['DEPTH_LEVEL']==2):?><!-- <span class="course-menu-icon-<?=$ccc;?>"></span> -->
        <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>.png">
        <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>-a.png">
				<?endif;?><?=$arItem["TEXT"]?></div></a></li>

		<?else:?>

				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><div>
				<?if ($arItem['DEPTH_LEVEL']==2):?><!-- <span class="course-menu-icon-<?=$ccc;?>"></span> -->
					<img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>.png">
					<img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>-a.png">
					<?endif;?>
					<?=$arItem["TEXT"]?>
				</div></a></li>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 2)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-2) );?>
<?endif?>
<?if ($course_show_menu==1):?>
           </ul>
           </div>
        </div>

            <br><br>

    <div class="course-menu-wrap">
    <div class="course-menu">
    <ul>

<?endif;?>
					<?/*Выводим меню раздела*/?>
<?foreach($arResult as $k=>$arItem):?>
<?if (($arItem["DEPTH_LEVEL"] == 1) && ($arItem["VIEW"]==0)):?>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a></li>

	<?endif?>
<?endforeach?>

                            </ul>
                        </div>
                    </div>

<?endif?>