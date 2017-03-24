<h3><a href="#">Контакты</a></h3>
<div class="footer-phones"><span>+7 (495)</span> 737-52-25<br /><span>+7 (495)</span> 258-00-04</div>
<a href="#" class="footer-callback">Обратный звонок</a>
<div class="footer-callback-window">
	<div class="footer-callback-content">
		<div class="footer-callback-text">Оставьте свой номер телефона и мы перезвоним вам в ближайшее время</div>
		<form action="/local/windows/callback.php" method="post" onsubmit="$.ajax({type: 'POST',url: $(this).attr('action'),data: $(this).serialize(),dataType: 'html',}).done(function(html) {
		$('.footer-callback-content').html('<div style=\'color:white;margin-top:20px;\'>'+html+'</div>');
});return false;">
			<div class="form-input"><input type="text" name="phone" class="required maskPhone" /></div>
			<div class="form-submit"><input type="submit" value="ок" /></div>
		</form>
	</div>
</div>
<div class="footer-email"><a href="mailto:info@bkc.ru">info@bkc.ru</a></div>
<div class="footer-social">
	<?$APPLICATION->IncludeFile("/local/includes/h.social.php",Array(),Array("MODE"=>"text"));?>
</div>
