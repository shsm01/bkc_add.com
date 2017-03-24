<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Методические дни");
?>
			<!-- subscribe -->
Подпишитесь на нашу ежемесячную рассылку, чтобы узнать о дате следующего семинара: 
			<div class="subscribe subscribe-teacher">
				<div class="subscribe-inner">
					<div class="subscribe-title">Подпишитесь на нашу ежемесячную рассылку,<br />чтобы узнать о дате следующего семинара</div>
 <?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "free_seminars", Array(
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"PAGE" => "#SITE_DIR#subscribe/index.php",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
		"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
		"USE_PERSONALIZATION" => "N",	// Определять подписку текущего пользователя
		"COMPONENT_TEMPLATE" => "template1"
	),
	false
);?>
				</div>
			</div>
			<!-- subscribe END -->

<p>
	 Центр подготовки преподавателей ВКС-IH Moscow приглашает учителей английского языка школ, колледжей, вузов принять участие в Методическом дне. Методический день включает 2 семинара, на которых вы сможете обсудить актуальные проблемы методики преподавания с ведущими методистами Центра и коллегами. Методические семинары Центра подготовки преподавателей бесплатны для посещения, однако необходима регистрация.
</p>
<p>
	 Преподавателям, посетившим оба семинара, выдается сертификат, подтверждающий участие в мероприятии.
</p>
                        <div class="method-status">
                            <div class="method-status-date">18 апреля 2014 / 18:30</div>
                            <div class="method-status-link">Регистрация закрыта</div>
                        </div>

 
                         <h2>CLIL (Content and Language Integrated Learning) for juniors and teens</h2>
                        <p>Learning a subject in a foreign language is becoming a popular trend, but not all schools need this as a core programme. However, CLIL elements integrated properly in regular English classes can motivate students and therefore help them learn more effectively. My talk is going to briefly introduce the main principles of CLIL methodology for those who are new to it, and then show ways of implementing CLIL for increasing YLs' motivation in the context of general English courses.</p>
                        <p><em><strong>Ведущий:</strong> Ольга Гончарова (CELTA, DELTA, CELTA Assessor, COLT, Cambridge Examiner), тренер Центра.</em></p>
                        <h2>An introdaction to the Cambridge English: First and First for Schools update for 2015</h2>
                        <p>A Chinese proverb says, “When the winds of change blow, some people build walls and others build windmills”. Yes, there have been more updates to one of the most popular exams but there is no need to panic; in fact, there are all the reasons to be enthusiastic and embrace this change. In our session we will</p>
                        <ul>
                            <li>analyse the update to Cambridge English: First and First for Schools for 2015 providing a brief rationale for the revision</li>
                            <li>outline the new structure of the exam, focusing on the papers that have undergone the biggest change</li>
                            <li>highlight continuity and teaching implications.</li>
                        </ul>
                        <p><em><strong>Ведущий:</strong> Татьяна Половинкина завуч по Кембриджским экзаменам BKC-IH Moscow</em></p>


 <br>
 <br>
<p>
	 Участие в семинаре бесплатно.
</p>
<p>
	 * семинары проводятся на английском языке
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>