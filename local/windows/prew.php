<?
//print_r($_COOKIE);	
//unset($_SESSION["prew"]);
if (!isset($_SESSION["prew"])) {?>
        <a href="#" class="warning-link"></a>
        <div class="warning-content">
            <div class="warning">
                <div class="warning-logo"><img src="/local/layout/images/logo.png" alt="" width="282" height="120" /></div>
                <h1>Уважаемый посетитель сайта ВКС International House!</h1>
                <p>Последние несколько месяцев мы занимались улучшением и доработкой нашего сайта и теперь готовы представить вам результаты наших усилий.</p>
                <p>Вы попали в число тех посетилей, которым посчастливилось первым увидеть новую версию.</p>
                <p>Мы хотели бы попросить вас помочь нам: если вы найдете какую-либо ошибку или у вас есть пожелания о том, как можно улучшить работу сайта - напишите, пожалуйста, нам.</p>
                <p>Мы добавили специальную форму, в которую Вы можете отправить все сообщения.</p>
                <div class="warning-close"><a href="#">Открыть новую версию сайта</a></div>
            </div>
        </div>

<?
$_SESSION["prew"]='111';
}

?>
	<div id="top_alert" class="alert_expanded">
		<div id="col_alert_btn" class="collapse_alert">
			<p class="link_alert_collapse uns">
				СВЕРНУТЬ
			</p>
		</div>
		<div id="exp_alert_btn" class="expand_alert">
			<p  class="link_alert_expand uns">
				РАЗВЕРНУТЬ
			</p>
		</div>
		<div class="info_alert_block">
			<p class="text_alert">
				<span class="uns">Нашли ошибку?</span>
				<br>
				<span class="uns">Есть пожелание?</span>
				<br>
				<a class="window-link link_alert_show_modal uns" href="/local/windows/error.php">Напишите нам!</a>
			</p>
		</div>
	</div>
	<script type="text/javascript">

		//закрытие блока при клике за его областью:
		$(document).click(function(event) {
			if ($(event.target).closest("#top_alert").length)
			return;
				$(".collapse_alert").hide(); //прячем кнопку свернуть
                	        $("#top_alert").removeClass('alert_expanded');//удаляем класс
                       		$("#top_alert").addClass('alert_collapsed');//заменяем класс
                        	$(".expand_alert").show();//показываем кнопку развернуть
				event.stopPropagation();			
		});

		$(document).ready(function () {

			var alert_timer;

			alert_timer = setTimeout(function () {//если кнопка свернуть не была нажата...
                               	$(".collapse_alert").hide(); //прячем кнопку свернуть
                                $("#top_alert").removeClass('alert_expanded');//удаляем развернутый стиль
                                $("#top_alert").addClass('alert_collapsed');//добавляем свернутый стиль
                                $(".expand_alert").show();//показываем кнопку развернуть
                        }, 5000); //...по истечению 5 сек.

                        $(".collapse_alert").click(function() { //кнопка свернуть                              
				$(".collapse_alert").hide(); //прячем кнопку свернуть
                                $("#top_alert").removeClass('alert_expanded');//удаляем развернутый стиль
                                $("#top_alert").toggleClass('alert_collapsed');//добавляем свернутый стиль
                                $(".expand_alert").show();//показываем кнопку развернуть
			});
			
//			var alert_timer_after_opened;

			$(".expand_alert").click(function() {//кнопка развернуть
				$(".expand_alert").hide();//прячем кнопку развернуть
				$("#top_alert").removeClass('alert_collapsed');//удаляем свернутый стиль
				$("#top_alert").toggleClass('alert_expanded');//добавляем развернутый стиль
				$(".collapse_alert").show();//показываем кнопку свернуть
/*
				//автоматически сворачиваем алерт, если кнопка свернуть не нажата:
				alert_timer_after_opened = setTimeout(function(){//если кнопка свернуть не нажата
                                        $(".collapse_alert").hide(); //прячем кнопку свернуть
                                        $("#top_alert").removeClass('alert_expanded');//удаляем развернутый стиль
                                        $("#top_alert").addClass('alert_collapsed');//добавляем свернутый стиль
                                        $(".expand_alert").show();//показываем кнопку развернуть
                                }, 5000);
                                return false;
*/		
			});			
		});
	</script>
       	<!-- 
		<a href="/local/windows/error.php" class="suggest-link window-link">Нашли ошибку?<br />Есть пожелание?<br> Напишите нам!</a>
	-->
