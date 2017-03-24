<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")):
 if ($_REQUEST['name']):
foreach($_REQUEST as $k=>$v)
$_REQUEST[$k]=strip_tags($v);

	$el = new CIBlockElement;
	$PROP = array();
	$state='';
	$PROP["tel"] = $_REQUEST['phone'];
	$PROP["email"] = $_REQUEST['email'];
	$PROP["lang"] = $_REQUEST['language'];
	$PROP["day"] = $_REQUEST['days'];
	$PROP["time"] = $_REQUEST['time'];
	$PROP["mesto"] = $_REQUEST['place'];


	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID"	=> false,
		"IBLOCK_ID"				=> 29,
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
    <p>Ваша заявка принята.<br> Мы с Вами свяжемся в ближайшее время.</p>
    <a href="#" class="btn">закрыть</a>
</div>		
		');
		$files=false;
		CEvent::SendImmediate(
            55, //почтовое событие 
            "s1", //EMAIL 
            array(
				"FIO"=>$_REQUEST['name'],
				"PHONE"=> $_REQUEST['phone'],
				"EMAIL"=>$_REQUEST['email'],
				"LANG"=> $_REQUEST['language'],
				"DAY"=>$_REQUEST['days'],
				"TIME"=>$_REQUEST['time'],
				"MESTO"=>$_REQUEST['place'],
            ), //параметры
            "N", //продублировать всем исходящим 
            28, //шаблон
			$files
        ); 
	};
else:?>
		<div class="window-order">
    <div class="order">
        <h2>Заявка на обучение</h2>
        <div class="order-text">Интересно отметить, что имидж абстрактен. Рекламная акция, как принято считать, актаульна как никогда. А вот по мнению аналитиков селекция бренда настроено позитивно.</div>
        <form action="/local/windows/order.php" method="post">
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