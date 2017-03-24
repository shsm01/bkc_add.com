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

			<!-- container -->
			<div class="container container-test">

				<!-- content -->
				<div class="content">
					<div class="content-wrap">
