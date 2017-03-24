
					</div>
				</div>
				<!-- content END -->

			</div>
			<!-- container END -->

			<!-- subscribe -->
			<div class="subscribe">
				<div class="subscribe-inner">
					<div class="subscribe-title">Будьте в курсе новостей и акций</div>
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
			<!-- subscribe END -->

			<footer>
				<div class="footer-inner">

					<!-- footer content -->
					<div class="footer-content">
						<?include($_SERVER['DOCUMENT_ROOT'].'/local/includes/bottom_menu.php')?>

						<div class="footer-contacts">
							<?$APPLICATION->IncludeFile("/local/includes/f.contacts.php",Array(),Array("MODE"=>"text"));?>
						</div>
					</div>
					<!-- footer content END -->

					<!-- footer links -->
					<div class="footer-links">
						<?$APPLICATION->IncludeFile("/local/includes/f.info.php",Array(),Array("MODE"=>"text"));?>
					</div>
					<!-- footer links END -->

				</div>
			</footer>

		</div>
		<!-- wrapper END -->

	</body>
</html>