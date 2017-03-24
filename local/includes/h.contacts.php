<a href="/map/" class="header-address"><span>Адреса школ</span></a>
<a href="#" class="header-phone"><span><em>+7 495</em> 737-52-25</span></a>
<div class="header-callback">
	<a href="#" class="header-callback-close"></a>
	<div class="header-callback-content">
		<div class="header-callback-text">Оставьте свой номер телефона и мы перезвоним вам в ближайшее время</div>
		<form action="/local/windows/callback.php" method="post" onsubmit="$.ajax({type: 'POST',url: $(this).attr('action'),data: $(this).serialize(),dataType: 'html',}).done(function(html) {
		$('.header-callback-content').html('<div style=\'color:white;margin-top:20px;\'>'+html+'</div>');
		});return false;">
			<div class="form-input"><input type="text" name="phone" class="required maskPhone" /></div>
			<div class="form-submit window-link"><input type="submit" value="ок" /></div>
		</form>
	</div>
</div>
