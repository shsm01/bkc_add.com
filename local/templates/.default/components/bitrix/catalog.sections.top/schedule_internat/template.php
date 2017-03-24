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
<style>
/*th {
background:#CCC;
}*/
</style>

<?
$sch=array();
$c=0;
foreach($arResult["SECTIONS"] as $arSection):?>
                        <!-- exam schedule -->
                        <div class="exam-schedule<?if ($c==0):?> open<?endif; $c++;?>">
                            <a href="#" class="exam-schedule-header">
                                <div class="exam-schedule-title"><?=$arSection["NAME"]?></div>
                                <div class="exam-schedule-ctrl"><span>Развернуть</span><span>Свернуть</span></div>
                            </a>
                        
                            <div class="exam-schedule-content">

                        <table>
		<tr>
			<th data-orderable="false">Стоимость экзамена (руб)</th>
			<th data-orderable="false">Сроки регистрации</th>
			<th data-orderable="false">Дата проведения письменного модуля</th>
			<th data-orderable="false">Дата проведения устного модуля</th>
			<th data-orderable="false">Сроки получения расписания&nbsp;<span class="footnote-link">**</span></th>
			<th data-orderable="false">Примерная дата публикации результатов&nbsp;<span class="footnote-link">***</span></th>
			<th data-orderable="false">Примерная дата получения сертификата&nbsp;<span class="footnote-link">****</span></th>
		</tr>
<?
		$cell = 0;
		foreach($arSection["ITEMS"] as $arElement):
print('
		<tr>
');
		foreach($arElement['PROPERTIES'] as $k=>$v)
			if (($v['VALUE']=='') || ($v['VALUE']=='-'))
			print('
														<td style="text-align:center">—</td>
			');
			else
			print('
						<td>'.$v['VALUE'].'</td>
						');
print('
		</tr>
');

		endforeach; // foreach($arResult["ITEMS"] as $arElement):
		?>
		</table>
                            </div>
                        </div>
                        <!-- exam schedule END -->
<?endforeach?>

                        <div class="footnotes">
                            <div class="footnote">
                                <div class="footnote-number">*</div>
                                Внимание! Устный модуль экзамена может быть проведен в любую из дат, указанных в столбце «Дата устного модуля». Дата (единая для всех зарегистрированных на данный экзамен Кандидатов) устанавливается строго Кембриджским центром. Просим Кандидатов учитывать данный факт при выборе даты экзамена и спланировать свое рабочее время так, чтобы быть готовым прийти на устный модуль в любой из указанных дней.
                            </div>
                            <div class="footnote">
                                <div class="footnote-number">**</div>
                                Если вы не получили расписание после указанной даты, пожалуйста, свяжитесь с нами по электронной почте (<a href="#">exams@bkc.ru</a>), обязательно указав в письме название экзамена, фамилию и имя кандидата, или по телефону (495) 604-45-84.
                            </div>
                            <div class="footnote">
                                <div class="footnote-number">***</div>
                                Результаты экзаменов (кроме YLE, TKT) публикуются на сайте <a href="#">https://candidates.cambridgeenglish.org</a>. Инструкции о том, как с ними познакомиться, высылаются Кандидатам вместе с расписанием. Результаты по телефону или по факсу не сообщаются.
                            </div>
                            <div class="footnote">
                                <div class="footnote-number">****</div>
                                О наличии сертификатов в Центре Кандидаты узнают из электронной рассылки. Сертификат выдается кандидату или лицу, указанному плательщиком при регистрации, при предъявлении паспорта. Возможно получение сертификата по доверенности. Кандидатам, проживающим за пределами Москвы и Московской области, сертификат высылается по почте.
                            </div>
                        </div>
