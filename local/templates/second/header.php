<?require(dirname(__FILE__)."/../.default/header.php");?><body>
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
			<!-- nav END -->
			<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bkc", Array(
				"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
					"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
					"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
				),
				false
			);?>

			<!-- container -->
			<div class="container">

				<!-- left -->
				<div class="left">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "vertical_multilevel", Array(
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
				);?>
				</div>
				<!-- left END -->

				<!-- right -->
				<div class="right">
					<div class="right-banner"><a href="#"><img src="/local/layout/files/right.jpg" alt="" width="235" height="190" /></a></div>

					<!-- right events -->
					<div class="right-events">
						<div class="right-events-title">Акции и скидки</div>
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list", 
							"news_bkc_right", 
							array(
								"ACTIVE_DATE_FORMAT" => "j F Y",
								"ADD_SECTIONS_CHAIN" => "Y",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"CACHE_FILTER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "36000000",
								"CACHE_TYPE" => "A",
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"DISPLAY_DATE" => "Y",
								"DISPLAY_NAME" => "Y",
								"DISPLAY_PICTURE" => "Y",
								"DISPLAY_PREVIEW_TEXT" => "Y",
								"DISPLAY_TOP_PAGER" => "N",
								"FIELD_CODE" => array(
									0 => "",
									1 => "",
								),
								"FILTER_NAME" => "",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"IBLOCK_ID" => "6",
								"IBLOCK_TYPE" => "press_center",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"INCLUDE_SUBSECTIONS" => "Y",
								"MESSAGE_404" => "",
								"NEWS_COUNT" => "3",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_TEMPLATE" => "bkc",
								"PAGER_TITLE" => "Новости",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"PREVIEW_TRUNCATE_LEN" => "",
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "",
								),
								"SET_BROWSER_TITLE" => "N",
								"SET_LAST_MODIFIED" => "N",
								"SET_META_DESCRIPTION" => "N",
								"SET_META_KEYWORDS" => "N",
								"SET_STATUS_404" => "N",
								"SET_TITLE" => "N",
								"SHOW_404" => "N",
								"SORT_BY1" => "ACTIVE_FROM",
								"SORT_BY2" => "SORT",
								"SORT_ORDER1" => "DESC",
								"SORT_ORDER2" => "ASC",
								"COMPONENT_TEMPLATE" => "news_bkc_right"
							),
							false
						);?>
						<a href="/press-center/shares/" class="right-event-all">Все акции</a>
					</div>
					<!-- right events END -->

					<!-- right events -->
					<div class="right-events">
						<div class="right-news-title">Новости</div>
						<?$APPLICATION->IncludeComponent("bitrix:news.list", "news_bkc_right", Array(
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
								"IBLOCK_ID" => "5",	// Код информационного блока
								"IBLOCK_TYPE" => "press_center",	// Тип информационного блока (используется только для проверки)
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
								"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
								"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
								"NEWS_COUNT" => "3",	// Количество новостей на странице
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
									0 => "",
									1 => "",
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
								"COMPONENT_TEMPLATE" => "news_bkc"
							),
							false
						);?>
						<a href="/press-center/news/" class="right-event-all">Все новости</a>
					</div>
					<!-- right events END -->
				</div>
				<!-- right -->

				<!-- content -->
				<div class="content">
					<div class="content-wrap">
						<h1><?$APPLICATION->ShowTitle()?></h1>