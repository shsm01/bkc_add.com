<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	/** @var array $arParams */
	/** @var array $arResult */
	/** @global CMain $APPLICATION */
	/** @global CUser $USER */
	/** @global CDatabase $DB */
	/** @var CBitrixComponentTemplate $this */
	/** @var string $templateName */
	/** @var string $templateFile */
	/** @var string $templateFolder */
	/** @var string $componentPath */
	/** @var CBitrixComponent $component */

	$this->setFrameMode(true);

	$arFilter = Array("IBLOCK_ID"=>12, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter);
	$metro=array();
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		$metro[$arFields['ID']]['f']=$arFields;
		$rsSections = CIBlockSection::GetList(Array('SORT'=>'ASC'), 
		Array('IBLOCK_ID'=>$arFields['IBLOCK_ID'],'ID'=>$arFields['IBLOCK_SECTION_ID']),
		false, 
		array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
		);
		$metro[$arFields['ID']]['st'] = $rsSections->Fetch();
	}

?>

                    <table class="school-list">
                        <thead>
                            <tr>
                                <th class="school-list-col-1">Название школы</th>
                                <th class="school-list-col-2">Метро</th>
                                <th class="school-list-col-1">Адрес</th>
                                <th class="school-list-col-2" data-orderable="false">Телефоны</th>
                                <th class="school-list-col-2" data-orderable="false">График работы</th>
                            </tr>
                        </thead>

                        <tbody>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
                            <tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <td>
                                    <p><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></p>
                                    <?if ($arItem['PREVIEW_TEXT']):?><p><?=$arItem['PREVIEW_TEXT']?></p><?endif;?>
                                </td>
                                <td><span class="metro-text-<?=$metro[$arItem['PROPERTIES']['metro']['VALUE']]['st']['UF_COLOR']?>"><?=$metro[$arItem['PROPERTIES']['metro']['VALUE']]['f']['NAME']?></span></td>
                                <td><?=$arItem['PROPERTIES']['address']['VALUE']?></td>
                                <td><?=implode('<br>',$arItem['PROPERTIES']['tel']['VALUE'])?></td>
                                <td>
                                    <div class="schedule">
									<?foreach($arItem['PROPERTIES']['work']['~VALUE'] as $k=>$v):
									?>
                                        <div class="schedule-row">
                                            <div class="schedule-row-name"><?=$v?></div>
                                            <div class="schedule-row-value"><?=$arItem['PROPERTIES']['work']['~DESCRIPTION'][$k]?></div>
                                        </div>
									<?endforeach;?>
									</div>
                                </td>
                            </tr>


<?endforeach;?>

</table>

<?/*if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;*/?>
