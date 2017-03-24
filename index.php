<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Курсы английского языка в Москве - Курсы иностранных языков в школе ВКС");
?>

				<!-- main -->
				<div class="main">
<?
$list_bann=GetIBlockElementList(43,false,array('SORT'=>'ASC'));
while($bann=$list_bann->GetNextElement()):
$b_f=$bann->GetFields();
$pic=CFile::GetFileArray($b_f['PREVIEW_PICTURE']);
$b_p=$bann->GetProperties();
$logo='';
if ($b_p['logo']['VALUE']) 
$logo=CFile::GetFileArray($b_p['logo']['VALUE']);
?>
					<div class="main-banner-<?=$b_p['num']['VALUE']?>" style="background-image:url(<?=$pic['SRC']?>)">
						<div class="main-banner-title"><?=$b_f['NAME']?></div>
						<?if (is_array($logo)):?>
						<div class="main-banner-logo" style="background-image:url(<?=$logo['SRC']?>)"></div>
						<?endif;?>
						<div class="main-banner-text">
							<?=$b_f['PREVIEW_TEXT']?>
						</div>
						<a href="<?=$b_p['link']['VALUE']?>" class="main-banner-link"><?=$b_p['name_button']['VALUE']?></a>
					</div>
<?
endwhile;
?>

				</div>
				<!-- main END -->

				<?$APPLICATION->IncludeFile("/local/includes/mobile_navig.php",Array(),Array("MODE"=>"php"));?>
				<?$APPLICATION->IncludeFile("/local/includes/navigator.php",Array(),Array("MODE"=>"php"));?>

				<!-- main advertising -->
				<div class="main-advertising">
					<h2>Акции</h2>
					<div class="main-advertising-cols">
						<div class="main-advertising-col">
							<div class="main-advertising-img"><a href="#"><img src="/local/layout/files/main-advertising-1.jpg" alt="" /></a></div>
							<div class="main-advertising-title"><a href="#">Двухдневный тренинг по французской фонетике</a></div>
							<div class="main-advertising-anonce">Французский язык красивый, мелодичный и его невозможно перепутать ни с одним другим языком. И это, в первую очередь, благодаря его фонетике, то есть произношению. Если вы любите говорить на французском, так как любим мы, то приглашаем вас на двухдневный тренинг по французской фонетике.</div>
							<div class="main-advertising-date">31 мая 2016</div>
						</div>
						<div class="main-advertising-col">
							<div class="main-advertising-img"><a href="#"><img src="/local/layout/files/main-advertising-2.jpg" alt="" /></a></div>
							<div class="main-advertising-title"><a href="#">Черная пятница! 35% скидка на летнюю британскую школу</a></div>
							<div class="main-advertising-anonce">Черная пятница! Только один день !  Не упустите шанс подарить незабываемое лето своим детям и сэкономить свой бюджет! 35% СКИДКА - максимальная выгода!</div>
							<div class="main-advertising-date">31 мая 2016</div>
						</div>
					</div>
					<div class="main-advertising-ctrl"></div>
					<a href="/discounts/" class="btn-more">Больше Акций</a>
				</div>
				<!-- main advertising END -->

				<!-- main news -->
				<div class="main-news">
					<h2>Новости</h2>
					<?$APPLICATION->IncludeComponent(
						"bitrix:news.list", 
						"main_news_bkc", 
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
							"IBLOCK_ID" => "5",
							"IBLOCK_TYPE" => "press_center",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"INCLUDE_SUBSECTIONS" => "Y",
							"MESSAGE_404" => "",
							"NEWS_COUNT" => "4",
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
							"SORT_BY1" => "SORT",
							"SORT_BY2" => "SORT",
							"SORT_ORDER1" => "DESC",
							"SORT_ORDER2" => "DESC",
							"COMPONENT_TEMPLATE" => "main_news_bkc"
						),
						false
					);?>
					<a href="/press-center/news/" class="btn-more">Больше новостей</a>
				</div>
				<!-- main news END -->

				<!-- main subscribe -->
				<div class="main-subscribe">
					<div class="subscribe-inner">
						<div class="subscribe-title">Хотите быть в курсе новостей и акций?</div>
						<div class="subscribe-text">Подписывайтесь на нашу рассылку. Вас ждет много интересного!</div>
						 <?$APPLICATION->IncludeComponent(
							"bitrix:subscribe.form", 
							"template1", 
							array(
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"PAGE" => "#SITE_DIR#subscribe/index.php",
								"SHOW_HIDDEN" => "N",
								"USE_PERSONALIZATION" => "N",
								"COMPONENT_TEMPLATE" => "template1"
							),
							false
						);?>
					</div>
				</div>
				<!-- main subscribe END -->
			</div>
			<!-- container END -->

			<!-- main map -->
			<div class="main-map">
				<h2><a href="/map/">Школы</a> иностранных языков ВКС в Москве и Московской области</h2>
				<div class="main-map-hint">(цвет меток соответствует линиям метро)</div>
				<div class="main-map-container">
					<?$APPLICATION->IncludeFile("/local/includes/main.map.php",Array(),Array("MODE"=>"php"));?>
				</div>
			</div>
			<!-- main map END -->

			<!-- container -->
			<div class="container">

				<!-- main bottom -->
				<div class="main-bottom">
					<div class="main-bottom-item">
						<h2>Курсы иностранных языков в Москве</h2>
						<p>Сеть компаний ВКС-IH была основана в далеком 1992 году, и с тех пор она не уступает своего места лидера в сфере курсов иностранных языков в Москве и Московской области.</p>
						<p>Чем же мы отличаемся от конкурентов? Все дело в применении уникальной коммуникативной методики, которая делает процесс обучения настолько естественным, что знания усваиваются намного быстрее и легче. И, конечно же, наши преподаватели - это исключительно профессионалы высочайшего класса.</p>
					</div>
					<div class="main-bottom-item">
						<h2>Курсы английского от&nbsp;международных школ</h2>
						<p>Мы строго контролируем качество проводимых занятий на курсах английского и других иностранных языков. Следим за профессионализмом преподавателей, в этом нам помогают специалисты из IHWO (International House World Organization). Это международная сеть школ по изучению языков. ВКС-IH стала ее членом еще в 1995 году.</p>
						<p>Сеть IHWO существует уже больше пятидесяти лет, и за это время с ней стали сотрудничать больше, чем 150 именитых языковых школ во многих странах мира. Такую популярность International House смогла заслужить постоянно совершенствуемыми методами обучения, современным пособиям и отбору лучших преподавателей.</p>
					</div>
					<div class="main-bottom-item">
						<h2>Преподаватели на курсах английского языка</h2>
						<p>Наши педагоги принимают активное участие в составлении книг и других учебных пособий. К слову сказать, именно специалисты ВКС-IH разрабатывали такие учебники как: Language to Go, Headway и Cutting Edge, которые признаны наиболее эффективными во многих странах мира.</p>
						<p>При школах ВКС-IH у нас есть собственный центр для обучения преподавателей иностранных языков. Прошедшие в нем подготовку учителя становятся обладателями таких престижных сертификатов, как DELTA и CELTA. Это красноречиво свидетельствует о высоком уровне их знаний и, соответственно, эффективном преподавании.</p>
					</div>
				</div>
				<!-- main bottom END -->

			<?$APPLICATION->IncludeFile("/local/includes/main.text.php",Array(),Array("MODE"=>"text"));?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
