<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/exams/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$4&ELEMENT_CODE=\$5&\$6",
		"ID" => "",
		"PATH" => "/exams/detail.php",
	),
	array(
		"CONDITION" => "#^/exams/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$3&SECTION_CODE=\$4",
		"ID" => "",
		"PATH" => "/exams/index.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/pre_teachers/detail.php",
	),
	array(
		"CONDITION" => "#^/corp_learn/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/corp_learn/detail.php",
	),
	array(
		"CONDITION" => "#^/languages/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/learning/languages/detail.php",
	),
	array(
		"CONDITION" => "#^/learn_english/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/learn_english/detail.php",
	),
	array(
		"CONDITION" => "#^/press-center/VKS-media/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&ELEMENT_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/press-center/VKS-media/detail.php",
	),
	array(
		"CONDITION" => "#^/abroad/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/abroad/detail.php",
	),
	array(
		"CONDITION" => "#^/exams/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$3&\$2",
		"ID" => "",
		"PATH" => "/exams/index.php",
	),
	array(
		"CONDITION" => "#^/child/([0-9,a-z,-]+)/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/learning/child/detail.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers_test/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/pre_teachers_test/index.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/pre_teachers/index.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/news/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&NEWS_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/schools/news_det.php",
	),
	array(
		"CONDITION" => "#^/video-lessons/videogalery/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/video-lessons/videogalery/detail.php",
	),
	array(
		"CONDITION" => "#^/video-lessons/photogalery/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/video-lessons/photogalery/detail.php",
	),

	array(
		"CONDITION" => "#^/corp_learn/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/corp_learn/index.php",
	),

	array(
		"CONDITION" => "#^/languages/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$1&&SECTION_CODE=\$2",
		"ID" => "",
		"PATH" => "/learning/languages/index.php",
	),

	array(
		"CONDITION" => "#^/learn_english/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$1&&SECTION_CODE=\$2",
		"ID" => "",
		"PATH" => "/learn_english/index.php",
	),

	array(
		"CONDITION" => "#^/about_bkc/career/vacancy/([0-9,a-z,-]+)/#",
		"RULE" => "&ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/about_bkc/career/vacancy/detail.php",
	),
	array(
		"CONDITION" => "#^/press-center/VKS-media/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/press-center/VKS-media/index.php",
	),
	array(
		"CONDITION" => "#^/abroad/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=1&SECTION_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/abroad/index.php",
	),
	array(
		"CONDITION" => "#^/child/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&PRE_SECTION_CODE=\$1&SECTION_CODE=\$2&ELEMENT_CODE=\$3&\$4",
		"ID" => "",
		"PATH" => "/learning/child/index.php",
	),
	array(
		"CONDITION" => "#^/exams/([0-9,a-z,-]+)/([0-9,a-z,-]+)/#",
		"RULE" => "&LANG=\$1&SECTION_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/exams/index.php",
	),
	array(
		"CONDITION" => "#^/press-center/shares/([0-9,a-z,-]+)/#",
		"RULE" => "&ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/press-center/shares/detail.php",
	),
	array(
		"CONDITION" => "#^/press-center/news/([0-9,a-z,-]+)/#",
		"RULE" => "&ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/press-center/news/detail.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers/news/([0-9,a-z,-]+)/#",
		"RULE" => "&NEWS_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/pre_teachers/news/news_det.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers_test/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/pre_teachers_test/index.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/schedule/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/schedule.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/contacts/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/contacts.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/teachers/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/teachers.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/reviews/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/reviews.php",
	),
	array(
		"CONDITION" => "#^/pre_teachers/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/pre_teachers/index.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/news/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/news.php",
	),
	array(
		"CONDITION" => "#^/our-teachers/([0-9,a-z,-]+)/#",
		"RULE" => "&ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/our-teachers/detail.php",
	),
	array(
		"CONDITION" => "#^/corp_learn/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/corp_learn/index.php",
	),

	array(
		"CONDITION" => "#^/languages/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/learning/languages/index.php",
	),

	array(
		"CONDITION" => "#^/learn_english/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/learn_english/index.php",
	),

	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/schools/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/schools/index.php",
	),
	array(
		"CONDITION" => "#^/abroad/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/abroad/index.php",
	),
	array(
		"CONDITION" => "#^/exams/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/exams/index.php",
	),
	array(
		"CONDITION" => "#^/child/([0-9,a-z,-]+)/#",
		"RULE" => "&SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/learning/child/index.php",
	),
	array(
		"CONDITION" => "#^/map/([0-9,a-z,-]+)/#",
		"RULE" => "&ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/map/detail.php",
	),
	array(
		"CONDITION" => "#^/languages/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/learning/languages/index.php",
	),
	array(
		"CONDITION" => "#^/child/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/learning/child/index.php",
	),
);

?>