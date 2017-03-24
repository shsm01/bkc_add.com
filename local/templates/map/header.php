<?require(dirname(__FILE__)."/../.default/header.php");?><body class="page-list">
<?$APPLICATION->ShowPanel()?>
<?include($_SERVER['DOCUMENT_ROOT'].'/local/windows/prew.php');?>
<?//$APPLICATION->IncludeFile("/local/includes/err_link.php",Array(),Array("MODE"=>"php"));?>
 		<!-- wrapper -->
		<div class="wrapper">

			<header>
				<div class="header-inner">
					<div class="header-left">
						<a href="#" onclick='alert("Функционал в разработке");return false;' class="header-user"><span>Личный кабинет</span></a>

						<div class="header-social">
							<?$APPLICATION->IncludeFile("/local/includes/h.social.php",Array(),Array("MODE"=>"text"));?>
						</div>

						<div class="logo"><a href="/"><img src="/local/layout/images/logo.png" alt="" width="282" height="120" /></a></div>
					</div>

					<div class="header-right">
						<div class="header-contacts">
							<?$APPLICATION->IncludeFile("/local/includes/h.contacts.php",Array(),Array("MODE"=>"text"));?>
						</div>
						<a href="/local/windows/order.php" class="header-link-order window-link">Заявка на обучение</a>
						<a href="/quiz/" class="header-link-test">Пройти онлайн-тест</a>
					</div>

					<div class="header-center"><img src="/local/layout/images/N1.png" alt="" width="370" height="167" /></div>
				</div>
			</header>

            <a href="#" class="nav-menu-mobile-link"></a>
            <div class="nav-menu-mobile">
                <div class="nav-menu-mobile-level-1"></div>
                <div class="nav-menu-mobile-level-2"></div>
                <div class="nav-menu-mobile-level-3"></div>
            </div>

			<!-- nav -->
			<div class="nav">
				<div class="nav-inner">
					<?$APPLICATION->IncludeFile("/local/includes/h.menu.top.php",Array(),Array("MODE"=>"text"));?>
				</div>
			</div>

			<!-- container -->
			<div class="container">

				<!-- left -->
				<div class="left">
					<?/*$APPLICATION->IncludeComponent("bitrix:menu", "vertical_multilevel", Array(
						"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"MAX_LEVEL" => "4",	// Уровень вложенности меню
							"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
								0 => "",
							),
							"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
							"MENU_CACHE_TYPE" => "N",	// Тип кеширования
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
						),
						false
					);*/?>
				</div>
				<!-- left END -->

				<!-- content -->
				<div class="content">
					<div class="content-wrap">

						<h1>Школы иностранных языков ВКС в Москве и Московской области</h1>
						<div class="school-list-hint">(цвет меток соответствует линиям метро)</div>

						<div class="schools-view">
							<ul>
								<li><a href="#"><span class="schools-view-1"></span>На карте</a></li>
								<li><a href="#"><span class="schools-view-2"></span>На схеме метро</a></li>
								<li class="active"><a href="#"><span class="schools-view-3"></span>Списком</a></li>
							</ul>
                            <a href="/local/windows/open_school.php" class="schools-open window-link">Открой свою школу</a>
							</div>

					</div>
				</div>
				<!-- content END -->

			</div>
			<!-- container END -->

			<!-- schools tabs -->
			<div class="schools-tabs">

				<!-- schools tab -->
				<div class="schools-tab">

					<div id="map"></div>
					<script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
					<script>

						var schools = [
<?
$color=array(
"red"=>"1",
"green"=>"2",
"blue"=>"3",
"blue"=>"4",
"brown"=>"5",
"orange"=>"6",
"purple"=>"7",
"yellow"=>"8",
"grey"=>"9",
"lime"=>"10",
"teal"=>"11",
"blue-grey"=>"12",
);
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
$arFilter = Array("IBLOCK_ID"=>11, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
CModule::IncludeModule("iblock");
$res = CIBlockElement::GetList(Array(), $arFilter, false);
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
$arProp=$ob->GetProperties();

$mmm=GetIBlockElement($arProp['metro']['VALUE']);
$rsSections = CIBlockSection::GetList(Array('SORT'=>'ASC'), 
Array(
	'IBLOCK_ID'=>$mmm['IBLOCK_ID'],
	'ID'=>$mmm['IBLOCK_SECTION_ID']
),
false, 
array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
);
$st = $rsSections->Fetch();
$coords=explode(',',$arProp['coords']['VALUE']);
?>
										[<?=$coords[1].','.$coords[0]?>,		  '/map/metro.php?id=<?=$arFields['ID']?>', '<?=str_replace("'",'"',$arFields['NAME'])?>',  '<?=$st['UF_COLOR']?$st['UF_COLOR']:'none'?>'],
<?
}
?>
									  ];

						ymaps.ready(init);

						var myMap;

						function init() {
							myMap = new ymaps.Map('map', {
								center: [55.755768, 37.617671],
								zoom: 10,
								controls: []
							});

							myMap.controls.add('zoomControl', {position: {left: 'auto', right: 10, top: 108}});
							myMap.behaviors.disable('scrollZoom');

							var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
								'<div class="popover">' +
									'<a class="close" href="#"></a>' +
									'$[[options.contentLayout]]' +
								'</div>', {
									build: function() {
										this.constructor.superclass.build.call(this);
										this._$element = $('.popover', this.getParentElement());
										this.applyElementOffset();
										this._$element.find('.close')
											.on('click', $.proxy(this.onCloseClick, this));
									},

									clear: function() {
										this._$element.find('.close')
											.off('click');
										this.constructor.superclass.clear.call(this);
									},

									onSublayoutSizeChange: function() {
										MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);
										if (!this._isElement(this._$element)) {
											return;
										}
										this.applyElementOffset();
										this.events.fire('shapechange');
									},

									applyElementOffset: function() {
										this._$element.css({
											left: 33,
											top: -76
									});
								},

								onCloseClick: function(e) {
									e.preventDefault();
									this.events.fire('userclose');
								},

								getShape: function () {
									if (!this._isElement(this._$element)) {
										return MyBalloonLayout.superclass.getShape.call(this);
									}

									var position = this._$element.position();

									return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
										[position.left, position.top], [
											position.left + this._$element[0].offsetWidth,
											position.top + this._$element[0].offsetHeight
										]
									]));
								},

								_isElement: function(element) {
									return element && element[0];
								}
							});

							var MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
								'$[properties.balloonContent]'
							);

							for (var i = 0; i < schools.length; i++) {
								var curItem = schools[i];
								var myPlacemark = new ymaps.Placemark([curItem[1], curItem[0]], {
									hintContent: curItem[3],
									balloonLink: curItem[2],
									balloonContent: '<div class="popup"><h3>Идет загрузка данных...</h3></div>'
								}, {
									balloonShadow: false,
									balloonLayout: MyBalloonLayout,
									balloonContentLayout: MyBalloonContentLayout,
									hideIconOnBalloonOpen: false,
									balloonPanelMaxMapArea: 0,
									iconLayout: 'default#image',
									iconImageHref: '/local/layout/images/map-icon-' + curItem[4] + '.png',
									iconImageSize: [49, 37],
									iconImageOffset: [-16, -37]
								});
								myPlacemark.events.add('balloonopen', function(e) {
									var curPlacemark = e.get('target');
									$.ajax({
										type: 'POST',
										url: curPlacemark.properties.get('balloonLink'),
										dataType: 'html',
										cache: false
									}).done(function(html) {
										curPlacemark.properties.set('balloonContent', html);
									});
								});
								myMap.geoObjects.add(myPlacemark);
							}
						}
					</script>
				</div>
				<!-- schools tab END -->

				<!-- schools tab -->
				<div class="schools-tab">

					<!-- metro -->
					<div id="bkc_map">
						<a id="bkc_altufievo" href="/schools/vks-altufevo/"></a>
						<a id="bkc_zelenograd" href="/schools/vks-zelenograd/"></a>
						<a id="bkc_himki" href="/schools/vks-khimki/"></a>
						<a id="bkc_rechnoy" href="/schools/vks-rechnoy-vokzal/"></a>
						<a id="bkc_petrovskorazumovskaya" href="/schools/vks-petrovsko-razumovskaya/"></a>
						<a id="bkc_strogino" href="/schools/vks-strogino/"></a>
						<a id="bkc_octoberpole" href="/schools/vks-oktyabrskoe-pole/"></a>
						<a id="bkc_sokolniki" href="/schools/vks-sokolniki/"></a>
						<a id="bkc_partizanskaya" href="/schools/vks-partizanskaya/"></a>
						<a id="bkc_prospektmira" href="/schools/vks-prospekt-mira/"></a>
						<a id="bkc_polezhaevskaya" href="/schools/vks-polezhaevskaya/"></a>
						<a id="bkc_chistye" href="/schools/vks-chistye-prudy/"></a>
						<a id="bkc_krylatskoe" href="/schools/vks-krylatskoe/"></a>
						<a id="bkc_ohotnyi" class="facebox" href="/schools/vks-globus-okhotnyy-ryad/"></a>
						<a id="bkc_novogireevo" href="/schools/vks-perovo/"></a>
						<a id="bkc_novokosino" href="/schools/vks-novokosino/"></a>
						<a id="bkc_kuntsevskaya" href="/schools/vks-kuntsevskaya/"></a>
						<a id="bkc_zhulebino" href="/schools/vks-zhulebino/"></a>
						<a id="bkc_univercity" href="/schools/vks-universitet/"></a>
						<a id="bkc_academic" href="/schools/vks-akademicheskaya/"></a>
						<a id="bkc_kashirskaya" href="/schools/vks-kashirskaya/"></a>
						<a id="bkc_prazhskaya" href="/schools/vks-prazhskaya/"></a>
						<a id="bkc_troitsk" href="/schools/vks-troitsk/"></a>
						<a id="bkc_podolsk" href="/schools/vks-podolsk/"></a>
						<a id="bkc_kantemirovskaya" href="/schools/vks-kashirskaya/"></a>
						<a id="bkc_semenovskaya" href="/schools/vks-partizanskaya/"></a>
						<a id="bkc_belyaevo" href="/schools/vks-belyaevo/"></a>
						<a id="bkc_yugo_zapadnaya" href="/schools/vks-yugo-zapadnaya/"></a>
						<a id="kievskaya" href="/schools/vks-kievskaya/"></a>
						<a id="uzhnoe_butovo" href="/schools/vks-yuzhnoe-butovo/"></a>
						<a id="krasnayapresen" href="/schools/vks-krasnaya-presnya/"></a>
						<a id="bkc_voikovskaya" href="/schools/vks-voykovskaya/"></a>
						<a id="perovo" href="/schools/vks-perovo/"></a>
						<a id="zvetnoy_bulvar" href="/schools/vks-petrovskiy-bulvar/"></a>
						<a id="bkc_puchkinskaya" href="/schools/vks-petrovskiy-bulvar/"></a>
						<a id="bkc_lermontovskiy" href="/schools/vks-zhulebino/"></a>
						<a id="bkc_frunzenskaya" href="/schools/vks-frunzenskaya/"></a>
						<a id="bkc_trubnaya" href="/schools/vks-petrovskiy-bulvar/"></a>
						<a id="bkc_tverskaya" href="/schools/vks-tverskaya/"></a>
						<a id="bkc_teatralnaya" href="/schools/international-academic-programmes-centre/"></a>
						<a id="bkc_bibirevo" href="/schools/vks-altufevo/"></a>
						<a id="bkc_lubjanka" href="/schools/vks-chistye-prudy/"></a>
						<a id="pavshinskaya_poima" href="/schools/vks-pavshinskaya-poyma/"></a>
						<a id="krasnogorsk" href="/schools/vks-pavshinskaya-poyma/"></a>
						<a id="alekseevskaya" href="/schools/vks-alekseevskaya/"></a>
						<a id="bratislavskaya" href="/schools/vks-bratislavskaya/"></a>
						<a id="maryino" href="/schools/vks-bratislavskaya/"></a>
						<a id="lyublino" href="/schools/vks-bratislavskaya/"></a>
					</div>
					<!-- metro END -->

					<!-- container -->
					<div class="container">
						<!-- content -->
						<div class="content">
							<div class="content-wrap">

								<h2>Рекомендуемые школы</h2>
							</div>
						</div>
						<!-- content END -->

					</div>
					<!-- container END -->

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
						<?
							$metro_lines = array();
							
							$sections = CIBlockSection::GetList(
									Array('SORT'=>'ASC'), 
									Array('IBLOCK_ID'=>12),
									false, 
									array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_*")
								);
							while($object = $sections->GetNext()){
								$metro_lines[$object['ID']] = $object;
							}
							
							$arFilter = Array("IBLOCK_ID"=>12, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
							$res = CIBlockElement::GetList(Array(), $arFilter);
							$metro = array();
							while($ob = $res->GetNextElement()){
								$arFields = $ob->GetFields();
								$metro[$arFields['ID']] = $arFields;
							}
							
							$arSelect = Array('ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_PAGE_URL');
							$arFilter = Array("IBLOCK_ID"=>11, "ACTIVE"=>"Y", 'PROPERTY_vip' => '57');
							$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
							while($arItem = $res->GetNextElement()){
								$school = $arItem->GetFields();
								$school['PROPERTIES'] = $arItem->GetProperties();
								?>
								<tr>
									<td>
										<p><a href="<?=$school['DETAIL_PAGE_URL']?>"><?=$school['NAME']?></a></p>
										<?if ($school['PREVIEW_TEXT']):?><p><?=$school['PREVIEW_TEXT']?></p><?endif;?>
									</td>
									<td><span class="metro-text-<?= $metro_lines[$metro[$school['PROPERTIES']['metro']['VALUE']] ['IBLOCK_SECTION_ID'] ]['UF_COLOR']?>"><?=$metro[$school['PROPERTIES']['metro']['VALUE']]['NAME']?></span></td>
									<td><?=$school['PROPERTIES']['address']['VALUE']?></td>
									<td><?=implode('<br>',$school['PROPERTIES']['tel']['VALUE'])?></td>
									<td>
										<div class="schedule">
										<?foreach($school['PROPERTIES']['work']['~VALUE'] as $k=>$v):
										?>
											<div class="schedule-row">
												<div class="schedule-row-name"><?=$v?></div>
												<div class="schedule-row-value"><?=$school['PROPERTIES']['work']['~DESCRIPTION'][$k]?></div>
											</div>
										<?endforeach;?>
										</div>
									</td>
								</tr>
								<?
							}
						?>
						</tbody>
					</table>

				</div>
				<!-- schools tab END -->

				<!-- schools tab -->
				<div class="schools-tab active">
					<?$APPLICATION->IncludeComponent("bitrix:news.list", "school", Array(
						"ACTIVE_DATE_FORMAT" => "j F Y",	// Формат показа даты
							"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
							"AJAX_MODE" => "N",	// Включить режим AJAX
							"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
							"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
							"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
							"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
							"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
							"CACHE_GROUPS" => "Y",	// Учитывать права доступа
							"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
							"CACHE_TYPE" => "A",	// Тип кеширования
							"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
							"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
							"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
							"DISPLAY_DATE" => "Y",	// Выводить дату элемента
							"DISPLAY_NAME" => "Y",	// Выводить название элемента
							"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
							"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
							"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
							"FIELD_CODE" => array(	// Поля
								0 => "",
								1 => "",
							),
							"FILTER_NAME" => "",	// Фильтр
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
							"IBLOCK_ID" => "11",	// Код информационного блока
							"IBLOCK_TYPE" => "school",	// Тип информационного блока (используется только для проверки)
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
							"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
							"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
							"NEWS_COUNT" => "1000",	// Количество новостей на странице
							"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
							"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
							"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
							"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
							"PAGER_TEMPLATE" => "bkc",	// Шаблон постраничной навигации
							"PAGER_TITLE" => "Новости",	// Название категорий
							"PARENT_SECTION" => "",	// ID раздела
							"PARENT_SECTION_CODE" => "",	// Код раздела
							"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
							"PROPERTY_CODE" => array(	// Свойства
								0 => "address",
								1 => "work",
								2 => "dir",
								3 => "tel",
								4 => "preview_text_en",
								5 => "course",
								6 => "detail_text_en",
								7 => "vk",
								8 => "ln",
								9 => "ok",
								10 => "fb",
								11 => "state",
								12 => "country",
								13 => "now",
								14 => "school",
								15 => "",
							),
							"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
							"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
							"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
							"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
							"SET_STATUS_404" => "N",	// Устанавливать статус 404
							"SET_TITLE" => "N",	// Устанавливать заголовок страницы
							"SHOW_404" => "N",	// Показ специальной страницы
							"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
							"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
							"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
							"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
							"COMPONENT_TEMPLATE" => "reviews"
						),
						false
					);?>
					<!-- container -->
					<div class="container">
						<!-- content -->
						<div class="content">
							<div class="content-wrap">