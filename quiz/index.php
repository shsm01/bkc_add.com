<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Oнлайн тестирование");
@session_start();
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('html, body').animate({ scrollTop: $('.container-test').offset().top }, 100);
	});
//-->
</script>

<?
$langs = array( "1"=>array("Английский","01"), "2"=>array("Немецкий","02"), "3"=>array("Французский","03"), "5"=>array("Испанский","05"), "6"=>array("Итальянский","04"), 
                "7"=>array("Греческий","11"), "9"=>array("Китайский","06"), "10"=>array("Японский","07"), "11"=>array("Русский", "12"),"14"=>array("Английский","01"),  ); //потом возможно нужно будет заменить на инфоблок


$step = IntVal($_GET["step"]);

if(!$step || $step == 1){
  require("inc/main.php");
}elseif($step == 2){
  require("inc/personal.php");
}elseif($step == 3){
  require("inc/quiz.php");
}elseif($step == 4){
  require("inc/final.php");
}elseif($step == 5){
  require("inc/end.php");
}


?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>