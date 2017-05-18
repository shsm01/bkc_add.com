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
if(0){
?>

                        <!-- filter -->
<!-- 
						<div class="filter">
                            <form action="#" method="post">
                                <div class="filter-content">
                                    <div class="filter-row">
                                        <div class="form-row form-row-filter-3">
                                            <div class="form-label">Уровень языка</div>
                                            <div class="form-field">
                                                <div class="form-select">
                                                    <select name="level">
                                                        <option value="1">Intermediate</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row form-row-filter-3">
                                            <div class="form-label">Цель изучения</div>
                                            <div class="form-field">
                                                <div class="form-select">
                                                    <select name="target">
                                                        <option value="1">Для маркетологов</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row form-row-filter-3">
                                            <div class="form-label">Степень нагрузки</div>
                                            <div class="form-field">
                                                <div class="form-select">
                                                    <select name="intension">
                                                        <option value="1">Обычные курсы</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filter-row">
                                        <div class="form-row form-row-filter-2">
                                            <div class="form-label">Дни занятий</div>
                                            <div class="form-field">
                                                <div class="form-radios">
                                                    <div class="form-radio"><span><input type="radio" name="days" value="1" checked="checked" /></span>Любое</div>
                                                    <div class="form-radio"><span><input type="radio" name="days" value="2" /></span>Будни</div>
                                                    <div class="form-radio"><span><input type="radio" name="days" value="3" /></span>Выходные</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row form-row-filter-2">
                                            <div class="form-label">Место занятий</div>
                                            <div class="form-field">
                                                <div class="form-select">
                                                    <select name="place">
                                                        <option value="1">Очно в Москве и области</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter-ctrl">
                                    <div class="filter-view"><a href="#" data-alttext="Развернуть фильтр">Свернуть фильтр</a></div>
                                    <div class="form-submit"><input type="submit" value="Применить" /></div>
                                    <div class="form-reset"><input type="reset" value="Сбросить" /></div>
                                </div>
                            </form>
                        </div>
 -->
						<!-- filter END -->
<?}?>
                        <!-- categories -->
                        <div class="categories">


<?
/*
$arProp = CIBlock::GetPagePropertyList();

   foreach($arProp as $key=>$value)
    	echo '+++++++++++++ section'.$key.'+++++++++++++'.$value;

// $arProp = $APPLICATION->ShowProperty("page_title");

$arProp = $APPLICATION->GetPageProperty();

 echo '+++++++++++++ section ShowProperty #2'.$arProp;
*/



$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

// echo '+++++++++++++ section ShowProperty #2';
// var_dump ($arResult);

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<?
$i=1;
		foreach ($arResult['SECTIONS'] as &$arSection)
			{
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

				if (false === $arSection['PICTURE'])
					$arSection['PICTURE'] = array(
						'SRC' => $arCurView['EMPTY_IMG'],
						'ALT' => (
							'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
							? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
							: $arSection["NAME"]
						),
						'TITLE' => (
							'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
							? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
							: $arSection["NAME"]
						)
					);
				?>
                            <div class="category category-<?=(($i<9)?'0'.$i:$i)?>" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
                                <?if($arSection['PICTURE']){?><img src="<?=$arSection['PICTURE']["SRC"]?>" alt="<?=$arSection['PICTURE']["ALT"]?>" title="<?=$arSection['PICTURE']["TITLE"]?>" /><?}?>
                                <div class="category-title"><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a></div>
								                <div class="category-text"><?=$arSection['UF_PREVIEW_DESC'] ? $arSection['UF_PREVIEW_DESC'] : $arSection['DESCRIPTION']////?></div>
                            </div>

<?
	$i++;
}
			unset($arSection);
}

?>
</div>
<?=$arResult['SECTION']['DESCRIPTION'];?>
