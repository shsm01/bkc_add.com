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
?>

<? if (!empty($arResult['ITEMS'])){?>

    <? foreach ($arResult['ITEMS'] as $key => $arItem){

        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);

        $productTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
            : $arItem['NAME']
        );
        $imgTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
            : $arItem['NAME']
        );
        $site=str_replace('http://','',$arItem['PROPERTIES']['site']['VALUE']);?>

            <!-- subcategory -->
            <div class="subcategory" id="<?=$strMainID?>">
                <div class="subcategory-content">
                    <h2><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$productTitle?></a></h2>
                    <p><?=$arItem['PREVIEW_TEXT']?></p>
                    <?if ($arItem['PROPERTIES']['len']['VALUE']):?>
                        <p><strong>Длительность курса</strong><br /><?=$arItem['PROPERTIES']['len']['VALUE']?></p>
                     <?endif;?>

                    <? if (is_array($arItem['PROPERTIES']['level']['VALUE']) && count($arItem['PROPERTIES']['level']['VALUE'])>0){
                        print('
                        <p><strong>Уровень</strong><br />
                        ');
                        $els='';
                        foreach($arItem['PROPERTIES']['level']['VALUE'] as $v){
                            $el=GetIBlockElement($v);
                            $els.=$el['NAME'] .' ('.$el['PROPERTIES']['type']['VALUE'].')<br>';
                        }
                        print($els.'
                        </p>
                        ');
                    }?>

                </div>

                <div class="subcategory-price">
                    <?if(is_array($arItem["PROPERTIES"]['price_all']['VALUE']))echo implode("<br>",$arItem["PROPERTIES"]['price_all']['VALUE']);
                        elseif ($arItem["PROPERTIES"]['price']['VALUE'])
                            echo $arItem["PROPERTIES"]['price']['VALUE'].'<span class="rouble">i</span>';
                        ?> <!-- <span class="rouble">i</span> -->
                </div>
            </div>
        <? if ($arItem['PROPERTIES']['dates']['VALUE']['TEXT']!=''){?>
            <table class='program-detail-description-table'>
                <tr>
                    <th><b>Даты</b></th>
                    <th><b>Дни / Время</b></th>
                    <th><b>Статус группы</b></th>
                    <th><b>Первый платёж</b></th>
                    <th><b>Второй платёж (ранняя оплата)</b></th>
                    <th><b>Второй платёж</b></th>
                    <th><b>Регистрационный сбор</b></th>
                </tr>
                <tr>
                    <td><?=$arItem['PROPERTIES']['dates']['VALUE']['TEXT']?></td>
                    <td><?=$arItem['PROPERTIES']['daytime']['VALUE']['TEXT']?></td>
                    <td><?=$arItem['PROPERTIES']['group_status']['VALUE']?></td>
                    <td><?=$arItem['PROPERTIES']['first_payment']['VALUE']?> рублей</td>
                    <td><?=$arItem['PROPERTIES']['second_payment_early']['VALUE']['TEXT']?></td>
                    <td><?=$arItem['PROPERTIES']['second_payment']['VALUE']?> рублей</td>
                    <td><?=$arItem['PROPERTIES']['registation_payment']['VALUE']?> фунтов</td>
                </tr>
            </table>
        <?}?>
            <!-- subcategory END -->

  <? } ?>

<? } ?>
<?=$arResult['DESCRIPTION'];?>

<style>
table.program-detail-description-table{
    width:100%;
    position: relative;
    top:-25px;
}

table.program-detail-description-table th,
table.program-detail-description-table td{
    text-align: center;
    padding: 5px;
    border:1px solid #e9ecf0;
    vertical-align: middle;
}
</style>

                       <!-- order -->
<!--
						<div class="order course-order">
                            <h2>Заказать курс</h2>
                            <div class="order-text">Оставьте заявку, и наши специалисты свяжутся с вами в ближайшее время</div>
                            <form action="#" method="post">
                                <div class="form-row">
                                    <div class="form-label">Ваше ФИО <span>*</span></div>
                                    <div class="form-field">
                                        <div class="form-input"><input type="text" name="name" value="" class="required" /></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Ваш телефон <span>*</span></div>
                                    <div class="form-field">
                                        <div class="form-input"><input type="text" name="phone" value="" class="required maskPhone" /></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Ваш email</div>
                                    <div class="form-field">
                                        <div class="form-input"><input type="text" name="email" value="" class="email" /></div>
                                    </div>
                                </div>

                                <div class="order-select-langs">
                                    <div class="order-select-lang" data-value="1" data-title="Английский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий английский"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Английский для начинающих"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Деловой английский"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Однодневные тренинги"></div>
                                        <div class="order-select-lang-course" data-value="6" data-title="Разговорные клубы"></div>
                                        <div class="order-select-lang-course" data-value="7" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="8" data-title="Доступный английский летом"></div>
                                        <div class="order-select-lang-course" data-value="9" data-title="Международные программы в Москве"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="2" data-title="Немецкий">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Международные экзамены"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Разговорный курс"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Деловой курс"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="6" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="7" data-title="Разговорные клубы"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="3" data-title="Французский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Разговорный курс"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Деловой курс"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="6" data-title="Подготовка к международным экзаменам"></div>
                                        <div class="order-select-lang-course" data-value="7" data-title="Разговорные клубы"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="4" data-title="Итальянский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Разговорный"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Деловой итальянский"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="6" data-title="Подготовка к экзамену CILS"></div>
                                        <div class="order-select-lang-course" data-value="7" data-title="Разговорные клубы"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="5" data-title="Испанский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Разговорный курс"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Подготовка к экзамену DELE"></div>
                                        <div class="order-select-lang-course" data-value="6" data-title="Разговорные клубы"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="6" data-title="Китайский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Разговорный курс"></div>
                                        <div class="order-select-lang-course" data-value="3" data-title="Деловой курс"></div>
                                        <div class="order-select-lang-course" data-value="4" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="5" data-title="Подготовка к экзамену HSK"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="7" data-title="Японский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="1" data-title="Индивидуальное обучение"></div>
                                        <div class="order-select-lang-course" data-value="1" data-title="Деловой японский"></div>
                                        <div class="order-select-lang-course" data-value="1" data-title="Интенсивные курсы"></div>
                                        <div class="order-select-lang-course" data-value="1" data-title="Подготовка к экзамену JLPT"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="8" data-title="Чешский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="9" data-title="Арабский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="10" data-title="Португальский">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="11" data-title="Греческий">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                        <div class="order-select-lang-course" data-value="2" data-title="Индивидуальное обучение"></div>
                                    </div>
                                    <div class="order-select-lang" data-value="12" data-title="Russian">
                                        <div class="order-select-lang-course" data-value="1" data-title="Общий курс"></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Язык</div>
                                    <div class="form-field">
                                        <div class="form-select">
                                            <select name="language" class="order-language">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Курс</div>
                                    <div class="form-field">
                                        <div class="form-select">
                                            <select name="course" class="order-course">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Желаемые дни занятий</div>
                                    <div class="form-field">
                                        <div class="form-radios form-radios-3">
                                            <div class="form-radio"><span><input type="radio" name="days" value="1" checked="checked" /></span>Любое</div>
                                            <div class="form-radio"><span><input type="radio" name="days" value="2" /></span>Будни</div>
                                            <div class="form-radio"><span><input type="radio" name="days" value="3" /></span>Выходные</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Удобное время занятий</div>
                                    <div class="form-field">
                                        <div class="form-radios form-radios-4">
                                            <div class="form-radio"><span><input type="radio" name="time" value="1" checked="checked" /></span>Любое</div>
                                            <div class="form-radio"><span><input type="radio" name="time" value="2" /></span>Утро</div>
                                            <div class="form-radio"><span><input type="radio" name="time" value="3" /></span>День</div>
                                            <div class="form-radio"><span><input type="radio" name="time" value="4" /></span>Вечер</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-label">Желаемое место занятий</div>
                                    <div class="form-field">
                                        <div class="form-select">
                                            <select name="place">
                                                <option value="1">На территории клиента</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-submit"><input type="submit" value="Подать заявку" /></div>
                            </form>
                        </div>
 -->
						<!-- order END -->
