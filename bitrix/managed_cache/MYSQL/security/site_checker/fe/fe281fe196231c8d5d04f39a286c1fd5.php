<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001489679068';
$dateexpire = '001492271068';
$ser_content = 'a:2:{s:7:"CONTENT";s:0:"";s:4:"VARS";a:2:{s:7:"results";a:12:{i:0;a:5:{s:5:"title";s:105:"Ограничен список потенциально опасных расширений файлов";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:377:"Текущий список расширений файлов, которые считаются потенциально опасными, не содержит всех рекомендованных значений. Список расширений исполняемых файлов всегда должен находится в актуальном состоянии";s:14:"recommendation";s:264:"Вы всегда можете изменить список расширений исполняемых файлов в настройках сайта: <a href="/bitrix/admin/settings.php?mid=fileman" target="_blank">Управление структурой</a>";s:15:"additional_info";s:344:"Текущие: php,php3,php4,php5,php6,phtml,pl,asp,aspx,cgi,exe,ico,shtm,shtml<br>
Рекомендованные (без учета настроек вашего сервера): php,php3,php4,php5,php6,phtml,pl,asp,aspx,cgi,dll,exe,ico,shtm,shtml,fcg,fcgi,fpl,asmx,pht,py,psp<br>
Отсутствующие: dll,fcg,fcgi,fpl,asmx,pht,py,psp";}i:1;a:5:{s:5:"title";s:128:"Уровень безопасности административной группы не является повышенным";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:182:"Пониженный уровень безопасности административной группы может значительно помочь злоумышленнику";s:14:"recommendation";s:337:"Ужесточить <a href="/bitrix/admin/group_edit.php?ID=1&tabControl_active_tab=edit2"  target="_blank">политики безопасности административной</a> группы или выбрать предопределенную настройку уровня безопасности "Повышенный".";s:15:"additional_info";s:0:"";}i:2;a:5:{s:5:"title";s:61:"Включен расширенный вывод ошибок";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:126:"Расширенный вывод ошибок может раскрыть важную информацию о ресурсе";s:14:"recommendation";s:63:"Выключить в файле настроек .settings.php";s:15:"additional_info";s:0:"";}i:3;a:5:{s:5:"title";s:102:"Пароль к БД не содержит спецсимволов(знаков препинания)";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:138:"Пароль слишком прост, что повышает риск взлома учетной записи в базе данных";s:14:"recommendation";s:57:"Добавить спецсимволов в пароль";s:15:"additional_info";s:0:"";}i:4;a:5:{s:5:"title";s:77:"Используется опасная/устаревшая версия PHP";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:881:"Использование опасных/устаревших версий PHP может служить как источником многих атак на сам интерпретатор (например, выполнение произвольного кода в версии 5.3.9) так и подспорьем для уязвимостей в коде проекта.<br>
К примеру, не правильная работа mbstring может привести к так называемой "Invalid Byte Sequence Attack" в абсолютно безобидном на первый взгляд коде, а отсутствие фильтрации null-byte в паттерне регулярных выражений к выполнению произвольного кода при малейшей неосторожности разработчика.";s:14:"recommendation";s:100:"Необходимо обновить php до последней стабильной версии.";s:15:"additional_info";s:117:"Текущая версия: 5.3.10-precise1<br>Минимально-рекомендуемая: 5.4.45/5.5.29/5.6.13";}i:5;a:5:{s:5:"title";s:77:"Используются устаревшие модули платформы";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:55:"Доступны новые версии модулей";s:14:"recommendation";s:275:"Рекомендуется своевременно обновлять модули платформы, установить рекомендуемые обновления: <a href="/bitrix/admin/update_system.php" target="_blank">Обновление платформы</a>";s:15:"additional_info";s:154:"Модули для которых доступны обновления:<br>search<br />
vote<br />
sale<br />
currency<br />
socialservices<br />
report";}i:6;a:5:{s:5:"title";s:141:"У некоторых пользователей административной группы установлен слабый пароль";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:303:"Привилегированные пользователи системы должны использовать сильный пароль, состоящий из букв разного регистра, цифр и знаков препинания, длиной не менее 8 символов.";s:14:"recommendation";s:109:"Пользователям необходимо установить более надежный пароль";s:15:"additional_info";s:97:"Пользователи:<br><a href="/bitrix/admin/user_edit.php?ID=1" target="_blank">admin<a/>";}i:7;a:5:{s:5:"title";s:119:"Временные файлы хранятся в пределах корневой директории проекта";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:271:"Хранение временных файлов, создаваемых при использовании CTempFile, в пределах корневой директории проекта не рекомендовано и несет с собой ряд рисков.";s:14:"recommendation";s:884:"Необходимо определить константу "BX_TEMPORARY_FILES_DIRECTORY" в "bitrix/php_interface/dbconn.php" с указанием необходимого пути.<br>
Выполните следующие шаги:<br>
1. Выберите директорию вне корня проекта. Например, это может быть "/home/bitrix/tmp/www"<br>
2. Создайте ее. Для этого выполните следующую комманду:
<pre>
mkdir -p -m 700 /полный/путь/к/директории
</pre>
3. В файле "bitrix/php_interface/dbconn.php" определите соответствующую константу, что бы система начала использовать эту директорию:
<pre>
define("BX_TEMPORARY_FILES_DIRECTORY", "/полный/путь/к/директории");
</pre>";s:15:"additional_info";s:69:"Текущая директория: /web/bkcb/new1.bkc.ru/upload/tmp";}i:8;a:5:{s:5:"title";s:113:"Разрешено отображение сайта во фрейме с произвольного домена";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:307:"Запрет отображения фреймов сайта со сторонних доменов способен предотвратить целый класс атак, таких как <a href="https://www.owasp.org/index.php/Clickjacking" target="_blank">Clickjacking</a>, Framesniffing и т.д.";s:14:"recommendation";s:1875:"Скорее всего, вам будет достаточно разрешения на просмотр сайта в фреймах только на страницах текущего сайта.
Сделать это достаточно просто, достаточно добавить заголовок ответа "X-Frame-Options: SAMEORIGIN" в конфигурации вашего frontend-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Frame-Options SAMEORIGIN;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Frame-Options SAMEORIGIN
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:2190:"Адрес: <a href="http://new1.bkc.ru/" target="_blank">http://new1.bkc.ru/</a><br>Запрос/Ответ: <pre>GET / HTTP/1.1
host: new1.bkc.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx
Date: Thu, 26 Jan 2017 05:48:01 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.3.10-precise1
P3P: policyref=&quot;/bitrix/p3p.xml&quot;, CP=&quot;NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA&quot;
X-Powered-CMS: Bitrix Site Manager (323d9e901c504531224754445d586447)
Set-Cookie: PHPSESSID=ksnls3061r3ctpqtqbuif3phj7; expires=Fri, 27-Jan-2017 05:47:59 GMT; path=/; HttpOnly
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

&lt;!DOCTYPE html&gt;
&lt;html&gt;
	&lt;head&gt;
		&lt;meta charset=&quot;utf-8&quot; /&gt;
		&lt;title&gt;Курсы английского языка в Москве - Курсы иностранных языков в школе ВКС&lt;/title&gt;
		
		&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;
&lt;link href=&quot;/bitrix/cache/css/s1/main/page_62e708a23b73c4faf976529da869e675/page_62e708a23b73c4faf976529da869e675.css?1482689175364&quot; type=&quot;text/css&quot;  rel=&quot;stylesheet&quot; /&gt;
&lt;link href=&quot;/bitrix/cache/css/s1/main/template_cff723a5ca50d0d33c67e5f3eec86d1b/template_cff723a5ca50d0d33c67e5f3eec86d1b.css?14826891752253&quot; type=&quot;text/css&quot;  data-template-style=&quot;true&quot;  rel=&quot;stylesheet&quot; /&gt;
&lt;script type=&quot;text/javascript&quot;&gt;var _ba = _ba || []; _ba.push([&quot;aid&quot;, &quot;323d9e901c504531224754445d586447&quot;]); _ba.push([&quot;host&quot;, &quot;new1.bkc.ru&quot;]); (function() {var ba = document.createElement(&quot;script&quot;); ba.type = &quot;text/javascript&quot;; ba.async = true;ba.src = (document.location.protocol == &quot;https:&quot; ? &quot;https://&quot; : &quot;http://&quot;) + &quot;bitrix.info/ba.js&quot;;var s = document.getElemen
----------Only 1Kb of body shown----------<pre>";}i:9;a:5:{s:5:"title";s:68:"Разрешено чтение файлов по URL (URL wrappers)";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:256:"Если эта, сомнительная, возможность PHP не требуется - рекомендуется отключить, т.к. она может стать отправной точкой для различного типа атак";s:14:"recommendation";s:89:"Необходимо в настройках php указать:<br>allow_url_fopen = Off";s:15:"additional_info";s:0:"";}i:10;a:5:{s:5:"title";s:77:"Почтовые сообщения содержат UID PHP процесса";s:8:"critical";s:3:"LOW";s:6:"detail";s:356:"В каждом отправляемом письме добавляется заголовок X-PHP-Originating-Script, который содержит UID и имя скрипта отправляющего письмо. Это позволяет злоумышленнику узнать от какого пользователя работает PHP.";s:14:"recommendation";s:91:"Необходимо в настройках php указать:<br>mail.add_x_header = Off";s:15:"additional_info";s:0:"";}i:11;a:5:{s:5:"title";s:44:"Включен Automatic MIME Type Detection";s:8:"critical";s:3:"LOW";s:6:"detail";s:248:"По умолчанию в Internet Explorer/FlashPlayer включен автоматический mime-сниффинг, что может служить источником XSS нападения или раскрытия информации.";s:14:"recommendation";s:1752:"Скорее всего, вам не нужна эта функция, поэтому её можно безболезненно отключить, добавив заголовок ответа "X-Content-Type-Options: nosniff" в конфигурации вашего веб-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Content-Type-Options nosniff;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Content-Type-Options nosniff
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:1743:"Адрес: <a href="http://new1.bkc.ru/bitrix/js/main/core/core.js?rnd=0.726919383438" target="_blank">http://new1.bkc.ru/bitrix/js/main/core/core.js?rnd=0.726919383438</a><br>Запрос/Ответ: <pre>GET /bitrix/js/main/core/core.js?rnd=0.726919383438 HTTP/1.1
host: new1.bkc.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx
Date: Thu, 26 Jan 2017 05:47:57 GMT
Content-Type: application/javascript
Content-Length: 117883
Connection: keep-alive
Last-Modified: Mon, 09 Jan 2017 13:18:25 GMT
ETag: &quot;d8ae87-1cc7b-545a933e48083&quot;
Accept-Ranges: bytes

/**********************************************************************/
/*********** Bitrix JS Core library ver 0.9.0 beta ********************/
/**********************************************************************/

;(function(window){

if (!!window.BX &amp;&amp; !!window.BX.extend)
	return;

var _bxtmp;
if (!!window.BX)
{
	_bxtmp = window.BX;
}

window.BX = function(node, bCache)
{
	if (BX.type.isNotEmptyString(node))
	{
		var ob;

		if (!!bCache &amp;&amp; null != NODECACHE[node])
			ob = NODECACHE[node];
		ob = ob || document.getElementById(node);
		if (!!bCache)
			NODECACHE[node] = ob;

		return ob;
	}
	else if (BX.type.isDomNode(node))
		return node;
	else if (BX.type.isFunction(node))
		return BX.ready(node);

	return null;
};

BX.debugEnableFlag = true;

// language utility
BX.message = function(mess)
{
	if (BX.type.isString(mess))
	{
		if (typeof BX.message[mess] == &quot;undefined&quot;)
		{
			BX.onCustomEvent(&quot;onBXMessageNotFound&quot;, [mess]);
			if (typeof BX.message[mess] == &quot;undefined&quot;)
			{
				BX.debug(&quot;message undef
----------Only 1Kb of body shown----------<pre>";}}s:9:"test_date";s:10:"26.01.2017";}}';
return true;
?>