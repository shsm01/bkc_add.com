<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

					<a href="#" class="left-menu-mobile"></a>
                    <div class="left-menu-wrap">
                        <div class="left-menu">
                            <ul>
                                <!-- <li class="open active">
                                    <a href="#"><div>� ��������</div></a>
                                    <ul>
                                        <li><a href="#"><div>������ � ������������� ��������</div></a></li>
                                        <li><a href="#"><div>�������� � �������</div></a></li>
                                        <li><a href="#"><div>���������� ���������������</div></a></li>
                                        <li><a href="#"><div>���� �������</div></a></li>
                                        <li><a href="#"><div>������� � ���-IH</div></a></li>
                                        <li><a href="#"><div>��������</div></a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><div>��� �������� ������</div></a></li>
                                <li><a href="#"><div>�������� ��������</div></a></li>
                                <li><a href="#"><div>���� �������������</div></a></li>
                                <li><a href="#"><div>������ ��������� �&nbsp;��������</div></a></li>
                                <li><a href="#"><div>����� ������ �&nbsp;�����������</div></a></li>
                                <li><a href="#"><div>�����-�����</div></a></li>
 -->
<?
function sel($arr,$id,$lvl){
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
			<li class="<?if ($arItem["SELECTED"]) if (sel($arResult,$k,$arItem["DEPTH_LEVEL"])):?>open active<?else:?>open<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a>
				<ul>
		<?else:?>
			<li class="<?if ($arItem["SELECTED"]) if (sel($arResult,$k,$arItem["DEPTH_LEVEL"])):?>open active<?else:?>open<?endif?>"><a href="<?=$arItem["LINK"]?>"><div><?=$arItem["TEXT"]?></div></a>
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

                            </ul>
                        </div>
                    </div>
<?endif?>