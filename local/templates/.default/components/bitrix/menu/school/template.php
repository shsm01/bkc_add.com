<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
CModule::IncludeModule("iblock");
$arFilter = Array('IBLOCK_ID'=>11, 'ACTIVE'=>'Y','CODE'=>$_REQUEST['SECTION_CODE']);
  $db_list = CIBlockElement::GetList(Array("SORT"=>'ASC'), $arFilter);
  $sec = $db_list->GetNext();
?>
					<a href="#" class="left-menu-mobile"></a>
                    <div class="left-menu-wrap">
                        <div class="left-menu">
                            <ul>
<li class="<?if (strpos($APPLICATION->GetCurPage(),'/schedule/')===false && strpos($APPLICATION->GetCurPage(),'/news/')===false && strpos($APPLICATION->GetCurPage(),'/teachers/')===false && strpos($APPLICATION->GetCurPage(),'/reviews/')===false && strpos($APPLICATION->GetCurPage(),'/contacts/')===false):?>open active<?else:?>open<?endif?>"><a href="/schools/<?=$_REQUEST['SECTION_CODE']?>/"><div><?=$sec['NAME']?></div></a>
				<ul>
<?if (!empty($arResult)):?>
<?
function sel2($arr,$id,$lvl){
$ss=true;
for ($i=$id;$i<count($arr);$i++)
if ($arr[$i]['SELECTED'] && $arr[$i]['DEPTH_LEVEL']>$lvl){$ss=false;break;}
return $ss;
}

$select=0;
$previousLevel = 0;
foreach($arResult as $k=>$arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="<?if ($arItem["SELECTED"]) if (sel2($arResult,$k,$arItem["DEPTH_LEVEL"])):?>open active<?else:?>open<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a>
				<ul>
		<?else:?>
			<li class="<?if ($arItem["SELECTED"]) if (sel2($arResult,$k,$arItem["DEPTH_LEVEL"])):?>open active<?else:?>open<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a></li>
			<?else:?>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><div><?=$arItem["TEXT"]?></div></a></li>
			<?else:?>
				<li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><div><?=$arItem["TEXT"]?></div></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
<?endif?>								
								</ul>

								</li>
                            </ul>
                        </div>
                    </div>
