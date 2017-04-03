<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name'] && $_REQUEST['phone'] && $_REQUEST['email']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);

$course_id = intval($_REQUEST['course']);
$course=GetIBlockElement($_REQUEST['course']);
$lang_res=CIBlockSection::GetList(array('SORT'=>'ASC'),Array('IBLOCK_ID'=>$course['IBLOCK_ID'],'ID'=>$course['IBLOCK_SECTION_ID']));
$lang=$lang_res->GetNext();
while($lang['DEPTH_LEVEL']>1)
{
	$lang_res=CIBlockSection::GetList(array('SORT'=>'ASC'),Array('IBLOCK_ID'=>$course['IBLOCK_ID'],'ID'=>$lang['IBLOCK_SECTION_ID']));
	$lang=$lang_res->GetNext();

}
	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["lang"] = $lang['NAME'];
	$PROP["day"] = $_REQUEST['days'];
	$PROP["time"] = $_REQUEST['time'];
	$PROP["mesto"] = $_REQUEST['place'];
	$PROP["level"] = $_REQUEST['level'];
	$PROP["course"] = $course['NAME'];
	$PROP["type"] = $course['IBLOCK_NAME'];

	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 38,
		"ACTIVE_FROM"			=> ConvertTimeStamp(time(),"FULL"),
		"NAME"						=> $_REQUEST['name'],
		"PROPERTY_VALUES"	=> $PROP,
		"PREVIEW_TEXT"			=> '',
		"DETAIL_TEXT"			=> '',
		"ACTIVE"					=> "Y",
	);

	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
		print('
<div class="window-success">
    <h1>Спасибо!</h1>
    <p>Ваша заявка принята. <br>Мы с Вами свяжемся в ближайшее время.</p>
    <a href="#" class="btn">закрыть</a>
</div>
');

		//оформляем заказ для оплаты
		$arPrice = LS::getPrice($course_id);
		if(is_array($arPrice) && count($arPrice) > 0)
		{
			LS::addToBasket($course_id);
			$props = array(
				"FIO" => $_REQUEST['name'],
				"PHONE" => $_REQUEST['phone'],
				"EMAIL" => $_REQUEST['email']
			);
			LS::addOrder($props);
		}

		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие
            "s1", //EMAIL
            array(
				"FIO"=>$_REQUEST['name'],
				"PHONE"=> $_REQUEST['phone'],
				"EMAIL"=>$_REQUEST['email'],
				"LANG"=> $lang['NAME'],
				"DAY"=>$_REQUEST['days'],
				"TIME"=>$_REQUEST['time'],
				"MESTO"=>$_REQUEST['place'],
				"LEVEL" => $_REQUEST['level'],
				"COURSE" => $course['NAME'],
				"TYPE" => $course['IBLOCK_NAME'],
            ), //параметры
            "N", //продублировать всем исходящим
            31, //шаблон
			$files
        );
	};
else:?>
<?
//print_r($_REQUEST);
$course=GetIBlockElement($_REQUEST['id']);
$level='<select name="level"><option value="Не определен">Не определен';
if (is_array($course['PROPERTIES']['level']['VALUE']) && count($course['PROPERTIES']['level']['VALUE'])>0){
$els='';
foreach($course['PROPERTIES']['level']['VALUE'] as $v){
$el=GetIBlockElement($v);
$els.='<option value="'.$el['NAME'] .' ('.$el['PROPERTIES']['type']['VALUE'].')">'.$el['NAME'] .' ('.$el['PROPERTIES']['type']['VALUE'].')';
}
$level.=$els.'</select>';
}

?>
		<div class="window-order">
    <div class="order course-order">
        <h2>Заказать курс</h2>
        <div class="order-text">Оставьте заявку, и наши специалисты свяжутся с вами в ближайшее время</div>
        <form action="/local/windows/order_course.php" method="post">
		<input type="hidden" name="course" value="<?=$_REQUEST['id']?>">
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
                <div class="form-label">Ваш email <span>*</span></div>
                <div class="form-field">
                    <div class="form-input"><input type="text" name="email" value="" class="email" /></div>
                </div>
            </div>
<?if ($level):?>
			<div class="form-row">
                <div class="form-label">Уровень языка</div>
                <div class="form-field">
                    <div class="form-select">
<?=$level?>
                    </div>
                </div>
            </div>
<?endif;?>
            <!-- <div class="order-select-langs">
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
 -->
<?/*?>
			<div class="form-row">
                <div class="form-label">Язык</div>
                <div class="form-field">
                    <div class="form-select">
                        <select name="language" class="_order-language">
						<?
						$res=GetIBlockElementList(30);
						while($lang=$res->GetNext())
						print('
                                <option value="'.$lang['NAME'].'">'.$lang['NAME'].'</option>
						');
						?>
                        </select>
                    </div>
                </div>
            </div>
<?*/?>
            <div class="order-full">
                <!-- <div class="form-row">
                    <div class="form-label">Курс</div>
                    <div class="form-field">
                        <div class="form-select">
                            <select name="course" class="order-course">
                            </select>
                        </div>
                    </div>
                </div>
 -->
                <div class="form-row">
                    <div class="form-label">Желаемые дни занятий</div>
                    <div class="form-field">
                        <div class="form-radios form-radios-3">
                            <div class="form-radio"><span><input type="radio" name="days" value="Любое" checked="checked" /></span>Любое</div>
                            <div class="form-radio"><span><input type="radio" name="days" value="Будни" /></span>Будни</div>
                            <div class="form-radio"><span><input type="radio" name="days" value="Выходные" /></span>Выходные</div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Удобное время занятий</div>
                    <div class="form-field">
                        <div class="form-radios form-radios-4">
                            <div class="form-radio"><span><input type="radio" name="time" value="Любое" checked="checked" /></span>Любое</div>
                            <div class="form-radio"><span><input type="radio" name="time" value="Утро" /></span>Утро</div>
                            <div class="form-radio"><span><input type="radio" name="time" value="День" /></span>День</div>
                            <div class="form-radio"><span><input type="radio" name="time" value="Вечер" /></span>Вечер</div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Желаемое место занятий</div>
                    <div class="form-field">
                        <div class="form-select">
                            <select name="place">
                                <option value="На территории клиента">На территории клиента</option>
                                <option value="В школе">В школе</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-full-link">
                <a href="#" data-alttext="Скрыть Дополнительные опции"><span>Показать Дополнительные опции</span></a>
            </div>

            <div class="form-submit"><input type="submit" value="Подать заявку" /></div>
        </form>
    </div>
</div>
<?
 endif;

endif;
?>