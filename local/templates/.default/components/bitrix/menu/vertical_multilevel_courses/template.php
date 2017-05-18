<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?// var_dump ($arResult);?>

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

  if ($arResult[$k]["LINK"] == '/pre_teachers/comment/') {
     $arResult[$k]["IS_PARENT"] = TRUE;
     $arResult[$k]["DEPTH_LEVEL"] = 1;
//     echo $arResult[$k]["TEXT"];
//     echo $arResult[$k]["IS_PARENT"]." +++++++++++ ";
//     echo $arResult[$k]["PERMISSION"]." ";
  }

  if (($arResult[$k]["LINK"] == '/pre_teachers/comment/review_celta/') || ($arResult[$k]["LINK"] == '/pre_teachers/comment/review_tkt/')) {
     $arResult[$k]["DEPTH_LEVEL"] = 5;
//     echo $arResult[$k]["TEXT"]."<br>";
//     echo $arResult[$k]["DEPTH_LEVEL"]."<br>";
/*
     if ($arResult[$k]["SELECTED"]) {
       echo "++++++".$arResult[$k]["SELECTED"]."SELECTED"."<br>";
//       echo "PERMISSION-".$arResult[$k]["PERMISSION"];
    } else {
       echo "++++++".$arResult[$k]["SELECTED"]."NOT SELECTED"."<br>";

    } 
*/
  }

}


foreach($arResult as $k=>$arItem)
  if (isset($arItem['PARAMS']['NO_LANG'])){
    $lang_show = false;
    break;
  }

/*
$arResult[5]['IS_PARENT'] = TRUE;
$arResult[6]['DEPTH_LEVEL'] = 2;
$arResult[7]['DEPTH_LEVEL'] = 2;


var_dump($arResult);
*/



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
  
    	foreach($lang_cl as $c=>$v) {

             $c_new[$v] = "/".$c."/";

//            echo $c_new."<br>";

    	}

// var_dump($c_new);

  
  foreach($arResult as $k=>$arItem):
    if ($arItem["DEPTH_LEVEL"]==1):
    	$ccc='';
    	$arResult[$k]['VIEW']=0;


// var_dump($arResult[$k]['LINK']);

//     	foreach($lang_cl as $c=>$v)
     	foreach($lang_cl01 as $c=>$v)

//        $c = "/".$c."/";
//        echo $c." ".$arItem['LINK']."<br>";
// echo "++++++++++++ strpos = ".strpos($arItem['LINK'],$c)."++++++++++++";

// echo $c."  ".$ccc." LINK = ".$arItem['LINK']."<br>";
//        echo $arItem['LINK']."<br>"; 
//        $pieces = explode("/", $arItem['LINK']);
//        echo "-2  ".$pieces[count($pieces)-2]." ".$c." ".$v;
//        echo $arItem['LINK']."<br>";
/*
        var_dump($pieces);

        if ($pieces[count($pieces)-2] == $c) {
           echo "POPALAS Padla!";
        }

*/    


// $tmp_str = $arResult[$k]['LINK'];
// $pieces = explode("/", $tmp_str);
// echo $pieces[count($pieces)-2]." ";

// $c_new = $v;
// echo $c_new."<br>";

      	if (strpos($arItem['LINK'],$c)!==false){
          $ccc=$v;
//          echo $c." ".$ccc." ".$k." ".$arItem['LINK']."<br>";
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
<?if (($arItem["DEPTH_LEVEL"] == 1) || ($arItem["DEPTH_LEVEL"] == 5))continue;?>
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

	<?elseif ($arItem["DEPTH_LEVEL"] != 5):?>
<!-- Выводим все не дочерние пункты -->
		<?if ($arItem["PERMISSION"] > "D"):?>
                    <? // if ($arItem["DEPTH_LEVEL"] != 5):?>

				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?if ($arItem['DEPTH_LEVEL']==2):?><!-- <span class="course-menu-icon-<?=$ccc;?>"></span> -->
        <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>.png">
        <img width="40" height="40" alt="" src="/local/layout/images/lang-icon-<?=$ccc;?>-a.png">
				<?endif;?><?=$arItem["TEXT"]?></div></a></li>
                    <?// endif;?>

<? // TO DO else: echo $arItem["TEXT"]." PERMISSION > D ".$arItem['DEPTH_LEVEL']; endif ?>

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
  <? elseif ($arItem["DEPTH_LEVEL"] == 5): ?>
  <ul>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a></li>
  </ul>
  <?endif?>
<?endforeach?>

                            </ul>
                        </div>
                    </div>

<?endif?>