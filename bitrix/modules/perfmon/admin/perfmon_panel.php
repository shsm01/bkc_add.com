<?
define("BX_SESSION_ID_CHANGE", false);
define("PERFMON_STOP", true);
if(isset($_REQUEST["test"]) && $_REQUEST["test"] === "Y")
{
	define("NOT_CHECK_PERMISSIONS", true);
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	/** @global CMain $APPLICATION */
	/** @global CDatabase $DB */
	/** @global CUser $USER */
	IncludeModuleLangFile(__FILE__);
	if(
		$_REQUEST["last"] === "Y"
		&& isset($_SESSION["PERFMON_TIMES"])
		&& is_array($_SESSION["PERFMON_TIMES"])
		&& count($_SESSION["PERFMON_TIMES"]) > 0
		&& check_bitrix_sessid()
		&& $APPLICATION->GetGroupRight("perfmon") >= "W"
	)
	{
		$sec_per_page = number_format(array_sum($_SESSION["PERFMON_TIMES"])/doubleval(count($_SESSION["PERFMON_TIMES"])), 4, ".", " ");
		COption::SetOptionString("perfmon", "mark_php_page_time", $sec_per_page);
		$result = number_format(doubleval(count($_SESSION["PERFMON_TIMES"]))/array_sum($_SESSION["PERFMON_TIMES"]), 2, ".", " ");
		COption::SetOptionString("perfmon", "mark_php_page_rate", $result);
		COption::SetOptionString("perfmon", "mark_php_page_date", ConvertTimeStamp(false, "FULL"));

		if (CModule::IncludeModule('perfmon'))
		{
			$ACCELERATOR_ENABLED = "N";
			foreach(CPerfomanceMeasure::GetAllAccelerators() as $accel)
			{
				if ($accel->IsWorking())
				{
					$ACCELERATOR_ENABLED = "Y";
				}
			}

			CPerfomanceHistory::Add($a=array(
				"TOTAL_MARK" => round(doubleval(count($_SESSION["PERFMON_TIMES"]))/array_sum($_SESSION["PERFMON_TIMES"]), 2),
				"ACCELERATOR_ENABLED" => $ACCELERATOR_ENABLED,
			));
		}
		?><script>
			BX('mark_result_in_note').innerHTML = '<b><?echo GetMessage("PERFMON_PANEL_MARK_RESULT", array("#result#" => $result)), "<span class=\"required\"><sup>1</sup></span>"?></b>';
			BX('page_rate_result').innerHTML = '<b><?echo $result?></b>';
			BX('page_time_result').innerHTML = '<?echo $sec_per_page?>';
			BX('tab_cont_perfomance').innerHTML = '<?echo GetMessage("PERFMON_PANEL_PERF_NAME")." (".$result.")"?>';
			jsUtils.FindChildObject(BX('perfomance'), 'div', 'adm-detail-title', true).innerHTML = '<?echo GetMessage("PERFMON_PANEL_PERF_TITLE2", array("#TOTAL_MARK_DATE#" => COption::GetOptionString("perfmon", "mark_php_page_date"), "#TOTAL_MARK_VALUE#" => $result));?>';
		</script><?
	}
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
	$_SESSION["PERFMON_TIMES"][] = $main_exec_time;
	die();
}
elseif(isset($_REQUEST["test"]) && $_REQUEST["test"] === "cluster")
{
	define("PUBLIC_AJAX_MODE", true);
	define("BX_SECURITY_SHOW_MESSAGE", true);
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	/** @global CMain $APPLICATION */
	/** @global CDatabase $DB */
	/** @global CUser $USER */
	IncludeModuleLangFile(__FILE__);
	if(
		check_bitrix_sessid()
		&& $APPLICATION->GetGroupRight("perfmon") >= "W"
		&& CModule::IncludeModule('perfmon')
	)
	{
		$threads_step = intval($_GET["threads_step"]);
		if($threads_step <= 0)
			$threads_step = 0;

		$threads_from = intval($_GET["threads_from"]);
		if($threads_from <= 0)
			$threads_from = 1;

		$threads_to = intval($_GET["threads_to"]);
		if($threads_to < $threads_from)
			$threads_to = $threads_from + $threads_step;

		$threads_duration = intval($_GET["threads_duration"]);
		if($threads_duration <= 0)
			$threads_duration = 10;

		$match = array();
		if(
			preg_match("/^http:\\/\\/([0-9a-zA-Z-_.]+)\\/?\$/", $_GET["server_name"], $match)
			|| preg_match("/^([0-9a-zA-Z-_.]+)\\/?\$/", $_GET["server_name"], $match)
		)
		{
			$server_name = $match[1];
			$server_port = 80;
		}
		elseif(
			preg_match("/^https:\\/\\/([0-9a-zA-Z-_.]+)\\/?\$/", $_GET["server_name"], $match)
		)
		{
			$server_name = $match[1];
			$server_port = 443;
		}
		elseif(
			preg_match("/^([0-9a-zA-Z-_.]+):(\\d+)\\/?\$/", $_GET["server_name"], $match)
		)
		{
			$server_name = $match[1];
			$server_port = $match[2];
		}
		else
		{
			ShowError(GetMessage("PERFMON_PANEL_WRONG_SERVER_NAME"));
			require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
			die();
		}

		if(strlen($_GET["server_url"]) > 0)
			$server_url = $_GET["server_url"];
		else
			$server_url = '/bitrix/admin/perfmon_panel.php?test=Y&show_page_exec_time=Y&show_sql_stat=N';

		if(strpos($server_url, "show_page_exec_time=Y") === false)
		{
			if(strpos($server_url, "?") === false)
				$server_url .= "?";
			$server_url .= '&show_page_exec_time=Y&show_sql_stat=N';
		}

		$bFinish = false;
		$threads = intval($_GET["threads"]);
		if($threads == 0)
		{
			//First clear old data
			$ob = new CPerfCluster;
			$ob->Truncate();
			//Timemark
			$_SESSION["treads_test_end"] = time() + $threads_duration*60;
			//Save options
			COption::SetOptionInt("perfmon", "test_threads_from", $threads_from);
			COption::SetOptionInt("perfmon", "test_threads_to", $threads_to);
			COption::SetOptionInt("perfmon", "test_threads_step", $threads_step);
			COption::SetOptionString("perfmon", "test_server_name", $_GET["server_name"]);
			COption::SetOptionString("perfmon", "test_server_url", $_GET["server_url"]);
			COption::SetOptionInt("perfmon", "test_threads_duration", $threads_duration);
			?><script>
				BX('threads_from').value = <?echo $threads_from?>;
				BX('threads_to').value = <?echo $threads_to?>;
				BX('threads_step').value = <?echo $threads_step?>;
				BX('server_name').value = '<?echo CUtil::JSEscape($_GET["server_name"])?>';
				BX('server_url').value = '<?echo CUtil::JSEscape($_GET["server_url"])?>';
				BX('threads_duration').value = <?echo $threads_duration?>;
				ThreadsUpdateImage('img_PAGES_PER_SECOND', <?echo $threads_from?>, <?echo $threads_to?>);
				ThreadsUpdateImage('img_PAGE_EXEC_TIME', <?echo $threads_from?>, <?echo $threads_to?>);
				ThreadsTest(<?echo $threads_from?>);
			</script><?
		}
		elseif(time() > $_SESSION["treads_test_end"]) //Finished
		{
			?><script>
				ThreadsStop();
			</script><?
			$bFinish = true;
		}
		else
		{
			$ob = new CPerfCluster;
			$ob->Measure(
				$server_name,
				$server_port,
				$server_url,
				$threads
			);
			$threads = $threads + $threads_step;
			if($threads > $threads_to)
				$threads = $threads_to;
			?><script>
				ThreadsUpdateImage('img_PAGES_PER_SECOND', <?echo $threads_from?>, <?echo $threads_to?>);
				ThreadsUpdateImage('img_PAGE_EXEC_TIME', <?echo $threads_from?>, <?echo $threads_to?>);
				ThreadsTest(<?echo $threads?>);
			</script><?
		}
		?>
			<div style="text-align:center;">
			&nbsp;
			<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
			<tr class="heading">
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_NN")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_CONCURRENCY")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_HITS")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_ERRORS")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGES_PER_SECOND")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGE_EXEC_TIME")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGE_RESP_TIME")?></td>
			</tr>
			<?
			$i = 0;
			$cData = new CPerfCluster;
			$rsData = $cData->GetList(array("ID" => "ASC"));
			while($ar = $rsData->Fetch()):
				$i++;
			?>
			<tr>
				<td class="bx-digit-cell"><?echo $i?></td>
				<td class="bx-digit-cell"><?echo intval($ar["THREADS"])?></td>
				<td class="bx-digit-cell"><?echo intval($ar["HITS"])?></td>
				<td class="bx-digit-cell"><?echo intval($ar["ERRORS"])?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGES_PER_SECOND"], 2, ".", " ")?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGE_EXEC_TIME"], 6, ".", " ")?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGE_RESP_TIME"], 6, ".", " ")?></td>
			</tr>
			<?endwhile;?>
			<?if(!$bFinish):?>
			<tr>
				<td colspan="7" id="measure_message"><?echo GetMessage("PERFMON_PANEL_MEASURE")?></td>
			</tr>
			<?endif;?>
			</table>
			</div>
		<?
	}
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
	die();
}
elseif(isset($_REQUEST["test"]) && $_REQUEST["test"] === "session" && isset($_REQUEST["last"]) && $_REQUEST["last"] === "Y")
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
	/** @global CMain $APPLICATION */
	/** @global CDatabase $DB */
	/** @global CUser $USER */
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");
	IncludeModuleLangFile(__FILE__);

	if(
		check_bitrix_sessid()
		&& $APPLICATION->GetGroupRight("perfmon") >= "W"
	)
	{
		if(
			COption::GetOptionString("security", "session", "N") === "Y"
			&& CModule::IncludeModule("security")
		)
		{
			$result = GetMessage("PERFMON_PANEL_SESSION_ERR")."<span class=\"required\"><sup>3</sup>";
			COption::SetOptionString("perfmon", "mark_php_session_time_value", -1);
			?><script>
				BX('session_time_result').innerHTML = '<?echo $result?>';
			</script><?
		}
		elseif(
			isset($_SESSION["PERFMON_SESSION_START"])
			&& is_array($_SESSION["PERFMON_SESSION_START"])
			&& count($_SESSION["PERFMON_SESSION_START"]) > 0
		)
		{
			$result = number_format(array_sum($_SESSION["PERFMON_SESSION_START"])/doubleval(count($_SESSION["PERFMON_SESSION_START"])), 4, ".", " ");
			COption::SetOptionString("perfmon", "mark_php_session_time_value", $result);
			?><script>
				BX('session_time_result').innerHTML = '<?echo $result?>';
			</script><?
		}
	}
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_js.php");
	die();
}
elseif(isset($_REQUEST["test"]) && $_REQUEST["test"] === "session")
{
	$s = microtime();
	session_start();
	$e = microtime();

	list($s_sec, $s_usec) = explode(" ", $s);
	list($e_sec, $e_usec) = explode(" ", $e);

	$t = $e_sec + $e_usec - $s_sec - $s_usec;

	if(isset($_SESSION["PERFMON_SESSION_START"]) && is_array($_SESSION["PERFMON_SESSION_START"]))
		$_SESSION["PERFMON_SESSION_START"][] = $t;

	die();
}
elseif(isset($_REQUEST["test"]))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
	/** @global CMain $APPLICATION */
	/** @global CDatabase $DB */
	/** @global CUser $USER */
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/perfmon/include.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/perfmon/prolog.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");

	IncludeModuleLangFile(__FILE__);

	if(check_bitrix_sessid() && $APPLICATION->GetGroupRight("perfmon") >= "W")
	{
		switch($_REQUEST["test"])
		{
		case "cpu":
			COption::SetOptionString("perfmon", "mark_php_cpu_value", number_format(CPerfomanceMeasure::GetPHPCPUMark(), 1, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_php_cpu_value");
			break;
		case "files":
			COption::SetOptionString("perfmon", "mark_php_files_value", number_format(CPerfomanceMeasure::GetPHPFilesMark(), 1, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_php_files_value");
			break;
		case "mail":
			COption::SetOptionString("perfmon", "mark_php_mail_value", number_format(CPerfomanceMeasure::GetPHPMailMark(), 4, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_php_mail_value");
			break;
		case "db_insert":
			COption::SetOptionString("perfmon", "mark_db_insert_value", number_format(CPerfomanceMeasure::GetDBMark("insert"), 0, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_db_insert_value");
			break;
		case "db_read":
			COption::SetOptionString("perfmon", "mark_db_read_value", number_format(CPerfomanceMeasure::GetDBMark("read"), 0, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_db_read_value");
			break;
		case "db_update":
			COption::SetOptionString("perfmon", "mark_db_update_value", number_format(CPerfomanceMeasure::GetDBMark("update"), 0, ".", " "));
			echo COption::GetOptionString("perfmon", "mark_db_update_value");
			break;
		case "php":
			$bPHPIsGood = version_compare(phpversion(), "5.1.0", ">=");

			if($bPHPIsGood)
			{
				if(strlen(ini_get('open_basedir')))
					$bPHPIsGood = false;
			}

			if($bPHPIsGood)
			{
				$size = CPerfAccel::unformat(ini_get('realpath_cache_size'));
				if($size < 4*1024*1024)
					$bPHPIsGood = false;
			}

			if($bPHPIsGood)
			{
				$bPHPIsGood = false;
				foreach(CPerfomanceMeasure::GetAllAccelerators() as $accel)
				{
					if ($accel->IsWorking())
					{
						$bPHPIsGood = true;
					}
				}
			}

			if($bPHPIsGood)
			{
				echo GetMessage("PERFMON_PANEL_MARK_PHP_IS_GOOD");
				COption::SetOptionString("perfmon", "mark_php_is_good", "Y");
			}
			else
			{
				echo "<span class=\"errortext\">".GetMessage("PERFMON_PANEL_MARK_PHP_IS_NO_GOOD")."</span>";
				COption::SetOptionString("perfmon", "mark_php_is_good", "N");
			}
			break;
		case "monitor":
			if($duration > 0)
			{
				CPerfomanceKeeper::SetActive($duration > 0, time() + $duration);
			}
			elseif($action == "stop")
			{
				CPerfomanceKeeper::SetActive(false);
			}

			if(CPerfomanceKeeper::IsActive())
			{
				$end_time = COption::GetOptionInt("perfmon", "end_time");
				if(time() > $end_time)
				{
					CPerfomanceKeeper::SetActive(false);
					if(COption::GetOptionString("perfmon", "total_mark_value", "") == "measure")
						COption::SetOptionString("perfmon", "total_mark_value", "calc");
				}
			}

			$cData = new CPerfomanceHit;
			$rsData = $cData->GetList(array("IS_ADMIN" => "DESC"), array("=IS_ADMIN" => "N"), true, false, array("IS_ADMIN", "COUNT", "SUM_PAGE_TIME", "AVG_PAGE_TIME"));
			$arTotalPage = $rsData->Fetch();

			if(($action == "stop") || (COption::GetOptionString("perfmon", "total_mark_value") == "calc"))
			{
				if($arTotalPage["AVG_PAGE_TIME"] > 0)
					COption::SetOptionString("perfmon", "total_mark_value", number_format(1/$arTotalPage["AVG_PAGE_TIME"], 2));
				else
					COption::SetOptionString("perfmon", "total_mark_value", "N/A");
				COption::SetOptionString("perfmon", "total_mark_hits", intval($arTotalPage["COUNT"]));
				COption::SetOptionString("perfmon", "total_mark_time", ConvertTimeStamp(false, "FULL"));
			}

			if(CPerfomanceKeeper::IsActive() || $duration > 0):
				$interval = COption::GetOptionInt("perfmon", "end_time") - time();
				if($interval < 0)
					$interval = 0;
				$hours = intval($interval / 3600);
				$interval -= $hours * 3600;
				$minutes = intval($interval / 60 );
				$interval -= $minutes * 60;
				$seconds = intval($interval);
				echo GetMessage("PERFMON_PANEL_MINUTES", array("#HOURS#" => $hours, "#MINUTES#" => $minutes, "#SECONDS#" => $seconds));?><br>
				<?echo GetMessage("PERFMON_PANEL_TEST_PROGRESS", array("#HITS#" => intval($arTotalPage["COUNT"])));?><br>
				<input type="button" value="<?echo GetMessage("PERFMON_PANEL_BTN_STOP")?>" OnClick="javascript:StopTest()">
				<script>
					setTimeout("ShowDev()", 3000);
				</script>
			<?else:
				?>
				<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
				<tr class="heading">
					<td width="40%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_SCRIPT_NAME")?></td>
					<td width="0%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_WARNINGS"),"<span class=\"required\"><sup>2</sup></span>"?></td>
					<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_PERCENT")?></td>
					<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_COUNT")?></td>
					<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_AVG_PAGE_TIME")?></td>
				</tr>
				<?
				$cData = new CPerfomanceHit;
				$rsData = $cData->GetList(array("SUM_PAGE_TIME" => "DESC"), array("=IS_ADMIN" => "N"), true, false, array("SCRIPT_NAME", "COUNT", "SUM_PAGE_TIME", "AVG_PAGE_TIME"));
				$i = 20;
				while(($ar = $rsData->Fetch()) && ($i > 0)):
					$ar["PERCENT"] = $ar["SUM_PAGE_TIME"] / $arTotalPage["SUM_PAGE_TIME"] * 100;
					$i--;
				?>
					<tr>
						<td><a href="perfmon_hit_list.php?lang=<?echo LANGUAGE_ID?>&amp;set_filter=Y&amp;find_script_name=<?echo urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"]))?>"><?echo $ar["SCRIPT_NAME"]?></a></td>
						<td class="bx-digit-cell" id="err_count_<?echo $i?>"><?
							$rsHit = CPerfomanceHit::GetList(array("COUNT" => "DESC"), array(
								'=SCRIPT_NAME' => $ar["SCRIPT_NAME"],
								'=IS_ADMIN' => 'N',
								'=CACHE_TYPE' => 'Y',
								'>MENU_RECALC' => 0,
							), true, array(), array('COUNT'));
							if(($arHit = $rsHit->Fetch()) && ($arHit["COUNT"] >= $ar["COUNT"])):
								$err_count = 1;
								$sHint = '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN1").'</b> '.GetMessage("PERFMON_PANEL_DEV_WARN1_DESC").'</td></tr>';
							else:
								$err_count = 0;
								$sHint = "";
							endif;

							$arComps = array();
							if($ar["COUNT"] > 1)
							{
								$rsHit = CPerfomanceComponent::GetList(array("COUNT" => "DESC"), array(
									'=HIT_SCRIPT_NAME' => $ar["SCRIPT_NAME"],
									'=HIT_IS_ADMIN' => 'N',
									'=HIT_CACHE_TYPE' => 'Y',
									'>QUERIES' => 0,
								), true, array(), array('COMPONENT_NAME', 'COUNT'));

								while($arHit = $rsHit->Fetch())
								{
									if($arHit["COUNT"] >= $ar["COUNT"])
										$arComps[] = htmlspecialcharsbx($arHit["COMPONENT_NAME"]);
								}
							}

							if(count($arComps))
							{
								$err_count++;
								$sHint .= '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN2").' '.GetMessage("PERFMON_PANEL_DEV_WARN2_DESC").'</b> <ul style="font-size:100%">';
								foreach($arComps as $component_name)
									$sHint .= '<li><a href="perfmon_comp_list.php?lang='.LANGUAGE_ID.'&amp;set_filter=Y&amp;find_hit_script_name='.urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"])).'&amp;find_component_name='.urlencode($component_name).'">'.$component_name.'</a></li>';
								$sHint .= '</ul></td></tr>';
							}

							$rsHit = CPerfomanceComponent::GetList(array("COUNT" => "DESC"), array(
								'=HIT_SCRIPT_NAME' => $ar["SCRIPT_NAME"],
								'=HIT_IS_ADMIN' => 'N',
								'=HIT_CACHE_TYPE' => 'Y',
								'>CACHE_SIZE' => 1024*1024,
							), true, array(), array('COMPONENT_NAME', 'MAX_CACHE_SIZE'));

							$bFirst = true;
							while($arHit = $rsHit->Fetch())
							{
								if($bFirst)
								{
									$err_count++;
									$sHint .= '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN3").'</b> '.GetMessage("PERFMON_PANEL_DEV_WARN3_DESC").'<ul style="font-size:100%">';
									$bFirst = false;
								}
								$sHint .= '<li>'.CFile::FormatSize($arHit["MAX_CACHE_SIZE"], 0).' <a href="perfmon_comp_list.php?lang='.LANGUAGE_ID.'&amp;set_filter=Y&amp;find_hit_script_name='.urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"])).'&amp;find_component_name='.urlencode(htmlspecialcharsbx($arHit["COMPONENT_NAME"])).'">'.htmlspecialcharsbx($arHit["COMPONENT_NAME"]).'</a></li>';
							}

							if(!$bFirst)
								$sHint .= '</ul></td></tr>';

							?>
							<?if($err_count):?>
								<a href="javascript:void(0)" id="a_err_count_<?echo $i?>"><?echo $err_count?></a>
								<script>
								window.structHint<?echo "err_count_".$i?> = new BXHint(
									'<?echo CUtil::JSEscape('<table cellspacing="0" border="0" style="font-size:100%">'.$sHint.'</table>')?>',
									BX('<?echo "a_err_count_".$i?>'), {width:false, show_on_click:true}
								);
								</script>
							<?else:?>
								&nbsp;
							<?endif;?>
						</td>
						<td class="bx-digit-cell"><?echo number_format($ar["PERCENT"], 2)?>%</td>
						<td class="bx-digit-cell"><?echo number_format($ar["COUNT"], 0, ".", " ")?></td>
						<td class="bx-digit-cell"><?echo number_format($ar["AVG_PAGE_TIME"], 4, ".", " ")?></td>
					</tr>
				<?endwhile;?>
				</table>
				<br />
				<a href="perfmon_hit_grouped.php?find_is_admin=N&amp;set_filter=Y&amp;lang=<?echo LANGUAGE_ID?>"><?echo GetMessage("PERFMON_PANEL_DEV_GROUPED_HIT_LIST")?></a>
				<script>
					CloseWaitWindow();
					BX('calc').disabled = false;
					jsUtils.FindChildObject(BX('dev'), 'div', 'adm-detail-title', true).innerHTML = '<?echo
						GetMessage("PERFMON_PANEL_DEV_TITLE2", array(
							"#mark_value#" => COption::GetOptionString("perfmon", "total_mark_value"),
							"#hits#" => COption::GetOptionString("perfmon", "total_mark_hits"),
							"#duration#" => COption::GetOptionString("perfmon", "total_mark_duration"),
							"#mark_time#" => COption::GetOptionString("perfmon", "total_mark_time"),
						));?>';
					BX('tab_cont_dev').innerHTML = '<?echo GetMessage("PERFMON_PANEL_DEV_NAME")." (".COption::GetOptionString("perfmon", "total_mark_value").")";?>';
				</script>
			<?endif;
			break;
		default:
			echo '&nbsp;';
		}
	}
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_js.php");
	die();
}
else
{

define("ADMIN_MODULE_NAME", "perfmon");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
/** @global CMain $APPLICATION */
/** @global CDatabase $DB */
/** @global CUser $USER */
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/perfmon/include.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/perfmon/prolog.php");
IncludeModuleLangFile(__FILE__);

$RIGHT = $APPLICATION->GetGroupRight("perfmon");
if($RIGHT < "R")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

$bSessionDB = COption::GetOptionString("security", "session", "N") === "Y" && CModule::IncludeModule("security");
$mark_value = COption::GetOptionString("perfmon", "mark_php_page_rate", "");
$mark_date  = COption::GetOptionString("perfmon", "mark_php_page_date", "");

if($REQUEST_METHOD == "POST" && ($calc.$total_calc!="") && $RIGHT >= "W" && check_bitrix_sessid())
{
	COption::RemoveOption("perfmon", "mark_php_cpu_value");
	COption::RemoveOption("perfmon", "mark_php_files_value");
	COption::RemoveOption("perfmon", "mark_php_mail_value");
	COption::RemoveOption("perfmon", "mark_php_session_time_value");
	COption::RemoveOption("perfmon", "mark_php_is_good");
	COption::RemoveOption("perfmon", "mark_db_insert_value");
	COption::RemoveOption("perfmon", "mark_db_read_value");
	COption::RemoveOption("perfmon", "mark_db_update_value");

	if(strlen($total_calc))
	{
		CPerfomanceComponent::Clear();
		CPerfomanceSQL::Clear();
		CPerfomanceHit::Clear();
		CPerfomanceError::Clear();
		CPerfomanceCache::Clear();
		COption::SetOptionString("perfmon", "total_mark_value", "measure");
		COption::SetOptionInt("perfmon", "total_mark_duration", $total_duration);
		COption::RemoveOption("perfmon", "total_mark_hits");
		COption::RemoveOption("perfmon", "total_mark_time");
	}
	else
	{
//		COption::RemoveOption("perfmon", "total_mark_value");
//		COption::RemoveOption("perfmon", "total_mark_duration");
	}

	COption::SetOptionString("perfmon", "mark_php_page_rate", "measure");
	COption::SetOptionString("perfmon", "mark_php_page_time", "measure");
	$_SESSION["PERFMON_TIMES"] = array();
	$_SESSION["PERFMON_SESSION_START"] = array();

	LocalRedirect("perfmon_panel.php?lang=".LANGUAGE_ID);
}

$bComponentCache = COption::GetOptionString("main", "component_cache_on", "Y")=="Y";

$arModulesInstalled = array();
$rsModules = CModule::GetDropDownList();
while($arModule = $rsModules->Fetch())
{
	$arModulesInstalled[] = $arModule["REFERENCE_ID"];
}

$statistic_path = IsModuleInstalled('statistic')
	&& (COption::GetOptionString("statistic", "SAVE_PATH_DATA") == "Y");

$search_is_ok = IsModuleInstalled('search')
	&& (COption::GetOptionString("search", "use_stemming")=="Y")
	&& (COption::GetOptionString("search", "use_tf_cache")=="Y");

if(CModule::IncludeModule('advertising') && COption::GetOptionString('advertising', 'DONT_FIX_BANNER_SHOWS')!=="Y")
{
	$rsBanners = CAdvBanner::GetList($by, $order, array("FIX_SHOW" => "Y"), $is_filtered, "N");
	if($rsBanners->Fetch())
		$adv_banners_fix_shows = true;
	else
		$adv_banners_fix_shows = false;
}
else
{
	$adv_banners_fix_shows = false;
}

$arConstants = array(
	"CACHED_b_forum_filter",
	"CACHED_b_forum2site",
	"CACHED_b_forum_perms",
	"CACHED_b_forum_smile",
	"CACHED_b_forum_user",
	"CACHED_b_forum_group",
	"CACHED_b_forum",
	"CACHED_b_iblock_property_enum",
	"CACHED_b_iblock_type",
	"CACHED_b_iblock",
	"CACHED_b_lang",
	"CACHED_b_option",
	"CACHED_b_lang_domain",
	"CACHED_b_site_template",
	"CACHED_b_event",
	"CACHED_b_agent",
	"CACHED_b_user_field",
	"CACHED_b_task",
	"CACHED_b_task_operation",
	"CACHED_b_search_tags",
	"CACHED_b_search_tags_len",
	"CACHED_b_sec_iprule",
	"CACHED_b_sec_filter_mask",
	"CACHED_b_sec_redirect_url",
	"CACHED_b_sonet_group_subjects",
	"CACHED_b_vote_question",
);
foreach($arConstants as $i => $constant)
{
	if(!defined($constant))
		unset($arConstants[$i]);
	elseif(constant($constant)!==false)
		unset($arConstants[$i]);
}
$bManagedCache = count($arConstants) <= 0;

$arEncodedModules = array();
foreach($arModulesInstalled as $module_id)
{
	$file_name = $_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/".$module_id."/include.php";
	if(file_exists($file_name) && is_file($file_name))
	{
		$fp = fopen($file_name, "rb");
		$sign = fread($fp, 4);
		if($sign == "Zend")
			$arEncodedModules[] = $module_id;
		fclose($fp);
	}
}
$bEncodedModules = count($arEncodedModules) <= 0;

if($DB->type == "MYSQL")
{
	$db_last_optimize = COption::GetOptionInt("main", "LAST_DB_OPTIMIZATION_TIME", 0);
	$bOptimized = $db_last_optimize >= (time() - 31*24*3600);
}
else
{
	$bOptimized = true;
}

$bOptimal = $bComponentCache
	&& $bManagedCache
	&& $bEncodedModules
	&& $bOptimized
;

if($bOptimal)
{
	if(COption::GetOptionString("perfmon", "bitrix_optimal", "-") !== "Y")
		COption::SetOptionString("perfmon", "bitrix_optimal", "Y");
}
else
{
	if(COption::GetOptionString("perfmon", "bitrix_optimal", "-") !== "N")
		COption::SetOptionString("perfmon", "bitrix_optimal", "N");
}

$cData = new CPerfomanceHit;
$rsData = $cData->GetList(array("IS_ADMIN" => "DESC"), array("=IS_ADMIN" => "N"), true, false, array("IS_ADMIN", "COUNT", "SUM_PAGE_TIME", "AVG_PAGE_TIME"));
$arTotalPage = $rsData->Fetch();

if(COption::GetOptionString("perfmon", "total_mark_value") == "calc" && $arTotalPage)
{
	COption::SetOptionString("perfmon", "total_mark_value", number_format(1/$arTotalPage["AVG_PAGE_TIME"], 2));
	COption::SetOptionString("perfmon", "total_mark_hits", intval($arTotalPage["COUNT"]));
	COption::SetOptionString("perfmon", "total_mark_time", ConvertTimeStamp(false, "FULL"));
}

$APPLICATION->SetTitle(GetMessage("PERFMON_PANEL_TITLE"));

$aTabs = array(
	array(
		"DIV" => "perfomance",
		"TAB" => GetMessage("PERFMON_PANEL_PERF_NAME").(
			strlen($mark_value) && $mark_value != "measure"?
			" (".$mark_value.")":
			""
		),
		"ICON" => "main_user_edit",
		"TITLE" => (
			strlen($mark_value) && $mark_value != "measure"?
			GetMessage("PERFMON_PANEL_PERF_TITLE2", array("#TOTAL_MARK_DATE#" => $mark_date, "#TOTAL_MARK_VALUE#" => $mark_value)):
			GetMessage("PERFMON_PANEL_PERF_TITLE1")
		),
	),
	array(
		"DIV" => "bitrix",
		"TAB" => GetMessage("PERFMON_PANEL_BITRIX_NAME").(
			COption::GetOptionString("perfmon", "bitrix_optimal", "-") === "Y"?
			" (".GetMessage("PERFMON_PANEL_MARK_PHP_IS_GOOD").")":
			" (".GetMessage("PERFMON_PANEL_MARK_PHP_IS_NO_GOOD").")"
		),
		"ICON" => "main_user_edit",
		"TITLE" => GetMessage("PERFMON_PANEL_BITRIX_TITLE"),
	),
	array(
		"DIV" => "dev",
		"TAB" => GetMessage("PERFMON_PANEL_DEV_NAME").(
			strlen(COption::GetOptionString("perfmon", "total_mark_time", "")) > 0?
			" (".COption::GetOptionString("perfmon", "total_mark_value").")":
			""
		),
		"ICON" => "main_user_edit",
		"TITLE" => (
			strlen(COption::GetOptionString("perfmon", "total_mark_time", "")) > 0?
			GetMessage("PERFMON_PANEL_DEV_TITLE2", array(
				"#mark_value#" => COption::GetOptionString("perfmon", "total_mark_value"),
				"#hits#" => COption::GetOptionString("perfmon", "total_mark_hits"),
				"#duration#" => COption::GetOptionString("perfmon", "total_mark_duration"),
				"#mark_time#" => COption::GetOptionString("perfmon", "total_mark_time"),
			)):
			GetMessage("PERFMON_PANEL_DEV_TITLE1")
		),
	),
	array(
		"DIV" => "cluster",
		"TAB" => GetMessage("PERFMON_PANEL_CLUSTER_TAB"),
		"ICON" => "main_user_edit",
		"TITLE" => GetMessage("PERFMON_PANEL_CLUSTER_TAB_TITLE"),
	),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>

<script>
var page_rate_count = 10;
var session_count = <?echo $bSessionDB? '1': '10'?>;
var duration = <?echo CPerfomanceKeeper::IsActive()? 0: intval(COption::GetOptionInt("perfmon", "total_mark_duration", 0))?>;

function StopTest()
{

	CHttpRequest.Action = function(result)
	{
		BX('dev_table').innerHTML = result;
		CloseWaitWindow();
	};

	CHttpRequest.Send('perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=monitor&action=stop');
}

function ShowBitrix()
{
	tabControl.SelectTab('bitrix');
	setTimeout("ShowDev()", 1500);
}

function ShowDev()
{
	tabControl.SelectTab('dev');

	CHttpRequest.Action = function(result)
	{
		BX('dev_table').innerHTML = result;
	};

	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=monitor';
	if(duration > 0)
	{
		url += '&duration='+duration;
		duration = 0;
	}

	ShowWaitWindow();
	CHttpRequest.Send(url);
}

function MeasureAll()
{
	setTimeout("CPUMeasure()", 200);
}

function PageRate()
{
	CHttpRequest.Action = function(result)
	{
		BX('page_rate_result_hidden').innerHTML = result;
		if(page_rate_count > 0)
		{
			setTimeout("PageRate()", 200);
		}
		else
		{
			CloseWaitWindow();
			<?if(COption::GetOptionString("perfmon", "total_mark_value") == "measure" && !CPerfomanceKeeper::IsActive()):?>
			setTimeout("ShowBitrix()", 1500);
			<?endif?>
		}
	};

	if(page_rate_count == 10)
	{
		ShowWaitWindow();
		BX('page_rate_result').innerHTML = '<b><?echo GetMessage("PERFMON_PANEL_MEASURE")?></b>'
	}

	page_rate_count--;

	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=Y';
	if(page_rate_count == 0)
		url += '&last=Y';

	CHttpRequest.Send(url);
}
function CPUMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_php_cpu_value_result').innerHTML = result;
		setTimeout("FilesMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_php_cpu_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=cpu';
	CHttpRequest.Send(url);
}
function FilesMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_php_files_value_result').innerHTML = result;
		setTimeout("MailMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_php_files_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=files';
	CHttpRequest.Send(url);
}
function MailMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_php_mail_value_result').innerHTML = result;
		setTimeout("SessionMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_php_mail_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=mail';
	CHttpRequest.Send(url);
}
function SessionMeasure()
{
	CHttpRequest.Action = function(result)
	{
		BX('session_time_result_hidden').innerHTML = result;
		if(session_count > 0)
			setTimeout("SessionMeasure()", 200);
		else
		{
			CloseWaitWindow();
			setTimeout("PHPMeasure()", 200);
		}
	};

	if(session_count == 10)
	{
		ShowWaitWindow();
		BX('session_time_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>'
	}

	session_count--;

	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=session';
	if(session_count == 0)
		url += '&last=Y';

	CHttpRequest.Send(url);
}
function PHPMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_php_is_good_result').innerHTML = result;
		setTimeout("DBInsertMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_php_is_good_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=php';
	CHttpRequest.Send(url);
}
function DBInsertMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_db_insert_value_result').innerHTML = result;
		setTimeout("DBReadMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_db_insert_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=db_insert';
	CHttpRequest.Send(url);
}
function DBReadMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_db_read_value_result').innerHTML = result;
		setTimeout("DBUpdateMeasure()", 200);
	};
	ShowWaitWindow();
	BX('mark_db_read_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=db_read';
	CHttpRequest.Send(url);
}
function DBUpdateMeasure()
{
	CHttpRequest.Action = function(result)
	{
		CloseWaitWindow();
		BX('mark_db_update_value_result').innerHTML = result;
		setTimeout("PageRate()", 200);
	};
	ShowWaitWindow();
	BX('mark_db_update_value_result').innerHTML = '<?echo GetMessage("PERFMON_PANEL_MEASURE")?>';
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=db_update';
	CHttpRequest.Send(url);
}
var threads_running = false;
function ThreadsStop()
{
	var measure_message = BX('measure_message');
	if(measure_message)
		measure_message.innerHTML = '<?echo GetMessage("PERFMON_PANEL_CLUSTER_STOPPED")?>';
	var threads_button = BX('threads_button');
	threads_button.value = '<?echo GetMessage("PERFMON_PANEL_CLUSTER_START")?>';
	threads_button.disabled = false;
	BX('threads_from').disabled = false;
	BX('threads_to').disabled = false;
	BX('threads_step').disabled = false;
	BX('server_name').disabled = false;
	BX('server_url').disabled = false;
	BX('threads_duration').disabled = false;
	threads_running = false;
	CloseWaitWindow();
}
function ThreadsTest(threads)
{
	var url = 'perfmon_panel.php?lang=<?echo LANGUAGE_ID?>&<?echo bitrix_sessid_get()?>&test=cluster';
	url += '&threads_from=' + parseInt(BX('threads_from').value);
	url += '&threads_to=' + parseInt(BX('threads_to').value);
	url += '&threads_step=' + parseInt(BX('threads_step').value);
	url += '&server_name=' + BX('server_name').value;
	url += '&server_url=' + BX.util.urlencode(BX('server_url').value);
	url += '&threads_duration=' + parseInt(BX('threads_duration').value);
	if(threads)
	{
		url += '&threads='+threads;
	}
	else
	{
		var threads_button = BX('threads_button');
		if(!threads_running)
		{
			ShowWaitWindow();
			threads_running = true;
			threads_button.value = '<?echo GetMessage("PERFMON_PANEL_CLUSTER_STOP")?>';
			BX('threads_from').disabled = true;
			BX('threads_to').disabled = true;
			BX('threads_step').disabled = true;
			BX('server_name').disabled = true;
			BX('server_url').disabled = true;
			BX('threads_duration').disabled = true;
		}
		else
		{
			threads_running = false;
			threads_button.value = '<?echo GetMessage("PERFMON_PANEL_CLUSTER_WAIT")?>';
			threads_button.disabled = true;
		}
	}

	if(threads_running)
	{
		CHttpRequest.Action = function(result)
		{
			BX('threads_result').innerHTML = result;
			if(!threads_running)
				ThreadsStop();
		};
		CHttpRequest.Send(url);
	}
}
function ThreadsUpdateImage(id, threads_from, threads_to)
{
	var img = BX.findChild(BX(id), {'tag':'IMG'},true);
	if(img)
	{
		var src = img.src;

		src = src.replace(/rand=.*?&/, 'rand=' + Math.random() + '&');

		if(src.search('&threads_from=') == -1)
			src += '&threads_from=' + threads_from;
		else
			src = src.replace(/&threads_from=[0-9]+/, '&threads_from=' + threads_from);

		if(src.search('&threads_to=') == -1)
			src += '&threads_to=' + threads_to;
		else
			src = src.replace(/&threads_to=[0-9]+/, '&threads_to=' + threads_to);

		img.src = src;

		img.style.display = 'block';
	}
}
</script>

<?echo BeginNote()?>
<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>"  ENCTYPE="multipart/form-data" name="post_form1">

<p id="mark_result_in_note" style="font-size:200%"><b>
<?
$mark_value = COption::GetOptionString("perfmon", "mark_php_page_rate", "");
if($mark_value == "" || $mark_value == "measure")
	echo GetMessage("PERFMON_PANEL_MARK_NO_RESULT");
else
	echo GetMessage("PERFMON_PANEL_MARK_RESULT", array("#result#" => $mark_value))."<span class=\"required\"><sup>1</sup></span>";
?>
</b></p>
<p>
	<?echo bitrix_sessid_post();?>
	<input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
	<input type="submit" name="total_calc" value="<?echo GetMessage("PERFMON_PANEL_BTN_START")?>" <?if($RIGHT < "W") echo "disabled"?>>
	&nbsp;<select name="total_duration">
		<?
			$total_duration = COption::GetOptionInt("perfmon", "total_mark_duration");
			if($total_duration <= 0) $total_duration = 300;
		?>
		<option value="60" <?if($total_duration==60) echo "selected"?>><?echo GetMessage("PERFMON_PANEL_INTERVAL_60_SEC")?></option>
		<option value="300" <?if($total_duration==300) echo "selected"?>><?echo GetMessage("PERFMON_PANEL_INTERVAL_300_SEC")?></option>
		<option value="600" <?if($total_duration==600) echo "selected"?>><?echo GetMessage("PERFMON_PANEL_INTERVAL_600_SEC")?></option>
		<option value="1800" <?if($total_duration==1800) echo "selected"?>><?echo GetMessage("PERFMON_PANEL_INTERVAL_1800_SEC")?></option>
		<option value="3600" <?if($total_duration==3600) echo "selected"?>><?echo GetMessage("PERFMON_PANEL_INTERVAL_3600_SEC")?></option>
	</select>
</p>
<?echo GetMessage("PERFMON_PANEL_TOP_NOTE");?>
</form>
<?echo EndNote()?>

<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>"  ENCTYPE="multipart/form-data" name="post_form">
<?$tabControl->Begin();?>
<?$tabControl->BeginNextTab();?>
	<tr>
		<td>
		<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
		<tr class="heading">
			<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_PERF_PARAMETER")?></td>
			<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_PERF_SCORE")?></td>
			<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_PERF_SAMPLE")?></td>
			<td width="40%" align="center"><?echo GetMessage("PERFMON_PANEL_PERF_VALUE")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_page_rate", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_PAGE_RATE")?></td>
			<?if($mark_value == "measure"):?>
				<td class="bx-digit-cell"><b>
					<script>setTimeout('MeasureAll();', 500);</script>
					<div id="page_rate_result_hidden" style="display:none"></div>
					<div id="page_rate_result"><?echo GetMessage("PERFMON_PANEL_MEASURE")?></div>
				</b></td>
			<?elseif(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell"><b><?echo $mark_value?></b></td>
			<?else:?>
				<td class="bx-digit-cell"><b><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></b></td>
			<?endif?>
			<td class="bx-digit-cell">30</td>
			<td>&nbsp;</td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_page_time", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_PAGE_TIME")?></td>
			<?if($mark_value == "measure"):?>
				<td class="bx-digit-cell" id="page_time_result"><?echo GetMessage("PERFMON_PANEL_MEASURE")?></td>
			<?elseif(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="page_time_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="page_time_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">0.0330</td>
			<td><?echo GetMessage("PERFMON_PANEL_PAGE_TIME_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_cpu_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_CPU")?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_php_cpu_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_php_cpu_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">9.0</td>
			<td><?echo GetMessage("PERFMON_PANEL_CPU_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_files_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_FILES")?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_php_files_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_php_files_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">10 000</td>
			<td><?echo GetMessage("PERFMON_PANEL_FILES_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_mail_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_MAIL")?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_php_mail_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_php_mail_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">0.0100</td>
			<td><?echo GetMessage("PERFMON_PANEL_MAIL_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_session_time_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_SESSION")?><div id="session_time_result_hidden" style="display:none"></div></td>
			<?if($mark_value == -1):?>
				<td class="bx-digit-cell" id="session_time_result"><?echo GetMessage("PERFMON_PANEL_SESSION_ERR")?><span class="required"><sup>3</sup></td>
			<?elseif(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="session_time_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="session_time_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">0.0002</td>
			<td><?echo GetMessage("PERFMON_PANEL_SESSION_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_php_is_good", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_PHP")?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_php_is_good_result"><?echo ($mark_value == "N"? "<span class=\"errortext\">".GetMessage("PERFMON_PANEL_MARK_PHP_IS_NO_GOOD")."</span>": GetMessage("PERFMON_PANEL_MARK_PHP_IS_GOOD"))?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_php_is_good_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_MARK_PHP_IS_GOOD")?></td>
			<td><a href="perfmon_php.php?lang=<?echo LANGUAGE_ID?>"><?echo GetMessage("PERFMON_PANEL_PHP_REC")?></a></td>
		</tr>
		<?
		if($DB->type == "MYSQL")
			$db_type = "MySQL";
		elseif($DB->type == "ORACLE")
			$db_type = "Oracle";
		else
			$db_type = "MS SQL";

		$mark_value = COption::GetOptionString("perfmon", "mark_db_insert_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_MARK_DB_INSERT_VALUE", array("#database_type#" => $db_type))?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_db_insert_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_db_insert_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">5 600</td>
			<td><?echo GetMessage("PERFMON_PANEL_MARK_DB_INSERT_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_db_read_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_MARK_DB_READ_VALUE", array("#database_type#" => $db_type))?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_db_read_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_db_read_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">7 800</td>
			<td><?echo GetMessage("PERFMON_PANEL_MARK_DB_READ_UNITS")?></td>
		</tr>
		<?
		$mark_value = COption::GetOptionString("perfmon", "mark_db_update_value", "");
		?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_MARK_DB_UPDATE_VALUE", array("#database_type#" => $db_type))?></td>
			<?if(strlen($mark_value) > 0):?>
				<td class="bx-digit-cell" id="mark_db_update_value_result"><?echo $mark_value?></td>
			<?else:?>
				<td class="bx-digit-cell" id="mark_db_update_value_result"><?echo GetMessage("PERFMON_PANEL_UNKNOWN")?></td>
			<?endif?>
			<td class="bx-digit-cell">5 800</td>
			<td><?echo GetMessage("PERFMON_PANEL_MARK_DB_UPDATE_UNITS")?></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
	<br>
	<?echo bitrix_sessid_post();?>
	<input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
	<input type="submit" name="calc" id="calc" value="<?echo GetMessage("PERFMON_PANEL_BTN_TEST")?>" <?if($RIGHT < "W" || COption::GetOptionString("perfmon", "total_mark_value") == "measure") echo "disabled"?> class="adm-btn-save">
		</td>
	</tr>
<?$tabControl->BeginNextTab();?>
	<tr>
		<td>
		<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
		<tr class="heading">
			<td width="40%" align="center"><?echo GetMessage("PERFMON_PANEL_BITRIX_PARAMETER")?></td>
			<td width="30%" align="center"><?echo GetMessage("PERFMON_PANEL_BITRIX_VALUE")?></td>
			<td width="30%" align="center"><?echo GetMessage("PERFMON_PANEL_BITRIX_RECOMMENDATION")?></td>
		</tr>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_COMPONENT_CACHE")?></td>
			<?if($bComponentCache):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_COMPONENT_CACHE_ON")?></td>
				<td>&nbsp;</td>
			<?else:?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_COMPONENT_CACHE_OFF")?></td>
				<td><a href="cache.php?lang=<?echo LANGUAGE_ID?>"><?echo GetMessage("PERFMON_PANEL_COMPONENT_CACHE_REC")?></a></td>
			<?endif?>
		</tr>
		<?if(IsModuleInstalled('statistic')):?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_STAT_SAVE_PATH")?></td>
			<?if($statistic_path):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_STAT_SAVE_PATH_ON")?></td>
				<td><a href="settings.php?lang=<?echo LANGUAGE_ID?>&amp;mid=statistic&amp;tabControl_active_tab=edit2&amp;back_url_settings=<?echo urlencode($APPLICATION->GetCurPageParam("tabControl_active_tab=bitrix", array("tabControl_active_tab")))?>"><?echo GetMessage("PERFMON_PANEL_STAT_SAVE_PATH_REC")?></a></td>
			<?else:?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_STAT_SAVE_PATH_OFF")?></td>
				<td>&nbsp;</td>
			<?endif?>
		</tr>
		<?endif?>
		<?if(IsModuleInstalled('advertising')):?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_ADV_BANNERS_FIX_SHOWS")?></td>
			<?if($adv_banners_fix_shows):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_ADV_BANNERS_FIX_SHOWS_ON")?></td>
				<td><a href="settings.php?lang=<?echo LANGUAGE_ID?>&amp;mid=advertising&amp;back_url_settings=<?echo urlencode($APPLICATION->GetCurPageParam("tabControl_active_tab=bitrix", array("tabControl_active_tab")))?>"><?echo GetMessage("PERFMON_PANEL_ADV_BANNERS_FIX_SHOWS_REC")?></a></td>
			<?else:?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_ADV_BANNERS_FIX_SHOWS_OFF")?></td>
				<td>&nbsp;</td>
			<?endif?>
		</tr>
		<?endif?>
		<?if(IsModuleInstalled('search')):?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_SEARCH_STEM")?></td>
			<?if($search_is_ok):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_SEARCH_STEM_ON")?></td>
				<td>&nbsp;</td>
			<?else:?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_SEARCH_STEM_OFF")?></td>
				<td><a href="settings.php?lang=<?echo LANGUAGE_ID?>&amp;mid=search&amp;back_url_settings=<?echo urlencode($APPLICATION->GetCurPageParam("tabControl_active_tab=bitrix", array("tabControl_active_tab")))?>"><?echo GetMessage("PERFMON_PANEL_SEARCH_STEM_REC")?></a></td>
			<?endif?>
		</tr>
		<?endif?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_CACHE_STORAGE")?></td>
			<?
			$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_UNKNOWN");
			switch(\Bitrix\Main\Data\Cache::getCacheEngineType())
			{
			case "cacheenginememcache":
				$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_MEMCACHE");
				break;
			case "cacheengineapc":
				$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_APC");
				break;
			case "cacheenginexcache":
				$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_XCACHE");
				break;
			case "cacheenginefiles":
				$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_FILES");
				break;
			case "cacheenginememcachecluster":
				$cache_type = GetMessage("PERFMON_PANEL_CACHE_STORAGE_CLUSTER");
				break;
			default:
				$cache_type = \Bitrix\Main\Data\Cache::getCacheEngineType();
				break;
			}
			?>
			<td class="bx-digit-cell"><?echo $cache_type?></td>
			<td><?echo GetMessage("PERFMON_PANEL_CACHE_STORAGE_REC");?></td>
		</tr>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_MANAGED_CACHE")?></td>
			<?if($bManagedCache):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_MANAGED_CACHE_ON")?></td>
				<td>&nbsp;</td>
			<?else:?>
				<td class="bx-digit-cell"><a href="javascript:void()" OnClick="BX('managed_cache_details').style.display='block';return false;"><?echo GetMessage("PERFMON_PANEL_MANAGED_CACHE_OFF")?></a><div id="managed_cache_details" style="display:none"><?echo implode("<br>", $arConstants)?></div></td>
				<td><?echo GetMessage("PERFMON_PANEL_MANAGED_CACHE_REC", array(
					"#file#" => (
						IsModuleInstalled('fileman') && ($USER->CanDoOperation('fileman_admin_files') || $USER->CanDoOperation('fileman_edit_existent_files'))?
						"<a href=\"".'/bitrix/admin/fileman_file_edit.php?lang='.LANGUAGE_ID.'&amp;full_src=Y&amp;path='.urlencode(BX_PERSONAL_ROOT.'/php_interface/dbconn.php').'&amp;back_url='.urlencode('/bitrix/admin/security_panel.php?lang='.LANGUAGE_ID)."\">dbconn.php</a>":
						"dbconn.php"
					),
				));?>
				</td>
			<?endif?>
		</tr>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_ENC_MODULES")?></td>
			<?if($bEncodedModules):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_ENC_MODULES_OFF")?></td>
				<td>&nbsp;</td>
			<?else:?>
				<td class="bx-digit-cell"><a href="javascript:void()" OnClick="BX('encoded_modules_details').style.display='block';return false;"><?echo GetMessage("PERFMON_PANEL_ENC_MODULES_ON")?></a><div id="encoded_modules_details" style="display:none"><?echo implode("<br>", $arEncodedModules)?></div></td>
				<td><?echo GetMessage("PERFMON_PANEL_ENC_MODULES_REC");?></td>
			<?endif?>
		</tr>
		<?if($DB->type == "MYSQL"):?>
		<tr>
			<td nowrap><?echo GetMessage("PERFMON_PANEL_DB_OPTIMIZE")?></td>
			<?if($bOptimized):?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_DB_OPTIMIZE_IS_OK")?></td>
				<td>&nbsp;</td>
			<?else:?>
				<td class="bx-digit-cell"><?echo GetMessage("PERFMON_PANEL_DB_OPTIMIZE_NEEDED")?></td>
				<td><a href="repair_db.php?lang=<?echo LANGUAGE_ID?>&amp;optimize_tables=Y"><?echo GetMessage("PERFMON_PANEL_DB_OPTIMIZE_REC")?></a></td>
			<?endif?>
		</tr>
		<?endif?>
		</table>
		</td>
	</tr>
<?$tabControl->BeginNextTab();
	if(COption::GetOptionString("perfmon", "total_mark_value") == "measure" && CPerfomanceKeeper::IsActive()):?>
	<script>setTimeout('ShowDev();', 200);</script>
	<?endif;
?>
	<tr>
		<td id="dev_table">
		<?if(COption::GetOptionString("perfmon", "total_mark_value") == "measure"):?>
			<?
			if(CPerfomanceKeeper::IsActive())
				$interval = COption::GetOptionInt("perfmon", "end_time") - time();
			else
				$internal = COption::GetOptionInt("perfmon", "total_mark_duration");
			$hours = intval($interval / 3600);
			$interval -= $hours * 3600;
			$minutes = intval($interval / 60 );
			$interval -= $minutes * 60;
			$seconds = intval($interval);
			echo GetMessage("PERFMON_PANEL_MINUTES", array("#HOURS#" => $hours, "#MINUTES#" => $minutes, "#SECONDS#" => $seconds));
			?>
		<?else:?>
			<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
			<tr class="heading">
				<td width="40%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_SCRIPT_NAME")?></td>
				<td width="0%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_WARNINGS"),"<span class=\"required\"><sup>2</sup></span>"?></td>
				<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_PERCENT")?></td>
				<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_COUNT")?></td>
				<td width="20%" align="center"><?echo GetMessage("PERFMON_PANEL_DEV_AVG_PAGE_TIME")?></td>
			</tr>
			<?
			$cData = new CPerfomanceHit;
			$rsData = $cData->GetList(array("SUM_PAGE_TIME" => "DESC"), array("=IS_ADMIN" => "N"), true, false, array("SCRIPT_NAME", "COUNT", "SUM_PAGE_TIME", "AVG_PAGE_TIME"));
			$i = 20;
			while(($ar = $rsData->Fetch()) && ($i > 0)):
				$ar["PERCENT"] = $ar["SUM_PAGE_TIME"] / $arTotalPage["SUM_PAGE_TIME"] * 100;
				$i--;
			?>
			<tr>
				<td><a href="perfmon_hit_list.php?lang=<?echo LANGUAGE_ID?>&amp;set_filter=Y&amp;find_script_name=<?echo urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"]))?>"><?echo $ar["SCRIPT_NAME"]?></a></td>
				<td class="bx-digit-cell" id="err_count_<?echo $i?>"><?
					$rsHit = CPerfomanceHit::GetList(array("COUNT" => "DESC"), array(
						'=SCRIPT_NAME' => $ar["SCRIPT_NAME"],
						'=IS_ADMIN' => 'N',
						'=CACHE_TYPE' => 'Y',
						'>MENU_RECALC' => 0,
					), true, array(), array('COUNT'));
					if(($arHit = $rsHit->Fetch()) && ($arHit["COUNT"] >= $ar["COUNT"])):
						$err_count = 1;
						$sHint = '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN1").'</b> '.GetMessage("PERFMON_PANEL_DEV_WARN1_DESC").'</td></tr>';
					else:
						$err_count = 0;
						$sHint = "";
					endif;

					$arComps = array();
					if($ar["COUNT"] > 1)
					{
						$rsHit = CPerfomanceComponent::GetList(array("COUNT" => "DESC"), array(
							'=HIT_SCRIPT_NAME' => $ar["SCRIPT_NAME"],
							'=HIT_IS_ADMIN' => 'N',
							'=HIT_CACHE_TYPE' => 'Y',
							'>QUERIES' => 0,
						), true, array(), array('COMPONENT_NAME', 'COUNT'));

						while($arHit = $rsHit->Fetch())
						{
							if($arHit["COUNT"] >= $ar["COUNT"])
								$arComps[] = htmlspecialcharsbx($arHit["COMPONENT_NAME"]);
						}
					}

					if(count($arComps))
					{
						$err_count++;
						$sHint .= '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN2").' '.GetMessage("PERFMON_PANEL_DEV_WARN2_DESC").'</b> <ul style="font-size:100%">';
						foreach($arComps as $component_name)
							$sHint .= '<li><a href="perfmon_comp_list.php?lang='.LANGUAGE_ID.'&amp;set_filter=Y&amp;find_hit_script_name='.urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"])).'&amp;find_component_name='.urlencode($component_name).'">'.$component_name.'</a></li>';
						$sHint .= '</ul></td></tr>';
					}

					$rsHit = CPerfomanceComponent::GetList(array("COUNT" => "DESC"), array(
						'=HIT_SCRIPT_NAME' => $ar["SCRIPT_NAME"],
						'=HIT_IS_ADMIN' => 'N',
						'=HIT_CACHE_TYPE' => 'Y',
						'>CACHE_SIZE' => 1024*1024,
					), true, array(), array('COMPONENT_NAME', 'MAX_CACHE_SIZE'));

					$bFirst = true;
					while($arHit = $rsHit->Fetch())
					{
						if($bFirst)
						{
							$err_count++;
							$sHint .= '<tr><td nowrap><b>'.GetMessage("PERFMON_PANEL_DEV_WARN3").'</b> '.GetMessage("PERFMON_PANEL_DEV_WARN3_DESC").'<ul style="font-size:100%">';
							$bFirst = false;
						}
						$sHint .= '<li>'.CFile::FormatSize($arHit["MAX_CACHE_SIZE"], 0).' <a href="perfmon_comp_list.php?lang='.LANGUAGE_ID.'&amp;set_filter=Y&amp;find_hit_script_name='.urlencode(htmlspecialcharsbx($ar["SCRIPT_NAME"])).'&amp;find_component_name='.urlencode(htmlspecialcharsbx($arHit["COMPONENT_NAME"])).'">'.htmlspecialcharsbx($arHit["COMPONENT_NAME"]).'</a></li>';
					}

					if(!$bFirst)
						$sHint .= '</ul></td></tr>';

					?>
					<?if($err_count):?>
						<a href="javascript:void(0)" id="a_err_count_<?echo $i?>"><?echo $err_count?></a>
						<script>
						window.structHint<?echo "err_count_".$i?> = new BXHint(
							'<?echo CUtil::JSEscape('<table cellspacing="0" border="0" style="font-size:100%">'.$sHint.'</table>')?>',
							BX('<?echo "a_err_count_".$i?>'), {width:false, show_on_click:true}
						);
						</script>
					<?else:?>
						&nbsp;
					<?endif;?>
				</td>
				<td class="bx-digit-cell"><?echo number_format($ar["PERCENT"], 2)?>%</td>
				<td class="bx-digit-cell"><?echo number_format($ar["COUNT"], 0, ".", " ")?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["AVG_PAGE_TIME"], 4, ".", " ")?></td>
			</tr>
			<?endwhile;?>
			</table>
			<br />
			<a href="perfmon_hit_grouped.php?find_is_admin=N&amp;set_filter=Y&amp;lang=<?echo LANGUAGE_ID?>"><?echo GetMessage("PERFMON_PANEL_DEV_GROUPED_HIT_LIST")?></a>
		<?endif?>
		</td>
	</tr>
<?$tabControl->BeginNextTab();
	?>
	<tr>
		<td nowrap width="40%"><?echo GetMessage("PERFMON_PANEL_CLUSTER_THREADS_FROM")?></td>
		<td width="60%"><input type="text" size="3" value="<?echo COption::GetOptionInt("perfmon", "test_threads_from")?>" id="threads_from"></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("PERFMON_PANEL_CLUSTER_THREADS_TO")?></td>
		<td><input type="text" size="3" value="<?echo COption::GetOptionInt("perfmon", "test_threads_to")?>" id="threads_to"></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("PERFMON_PANEL_CLUSTER_THREADS_STEP")?></td>
		<td><input type="text" size="3" value="<?echo COption::GetOptionInt("perfmon", "test_threads_step")?>" id="threads_step"></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("PERFMON_PANEL_CLUSTER_SERVER_NAME")?></td>
		<td><input type="text" size="35" value="<?echo htmlspecialcharsbx(COption::GetOptionString("perfmon", "test_server_name"))?>" id="server_name"></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("PERFMON_PANEL_CLUSTER_SERVER_URL")?></td>
		<td><input type="text" size="35" value="<?echo htmlspecialcharsbx(COption::GetOptionString("perfmon", "test_server_url"))?>" id="server_url"></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("PERFMON_PANEL_CLUSTER_THREADS_DURATION")?></td>
		<td><input type="text" size="3" value="<?echo COption::GetOptionInt("perfmon", "test_threads_duration")?>" id="threads_duration"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="button" id="threads_button" value="<?echo GetMessage("PERFMON_PANEL_CLUSTER_START")?>" onclick="ThreadsTest()"></td>
	</tr>
	<tr class="heading">
		<td colspan="2"><?echo GetMessage("PERFMON_PANEL_CLUSTER_RESULTS")?></td>
	</tr>

	<tr>
		<td id="threads_result" class="adm-detail-valign-top">
			<div style="text-align:center;">
			&nbsp;
			<table border="0" cellpadding="0" cellspacing="0" class="internal" width="100%">
			<tr class="heading">
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_NN")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_CONCURRENCY")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_HITS")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_ERRORS")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGES_PER_SECOND")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGE_EXEC_TIME")?></td>
				<td align="center"><?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGE_RESP_TIME")?></td>
			</tr>
			<?
			$i = 0;
			$cData = new CPerfCluster;
			$rsData = $cData->GetList(array("ID" => "ASC"));
			while($ar = $rsData->Fetch()):
				$i++;
			?>
			<tr>
				<td class="bx-digit-cell"><?echo $i?></td>
				<td class="bx-digit-cell"><?echo intval($ar["THREADS"])?></td>
				<td class="bx-digit-cell"><?echo intval($ar["HITS"])?></td>
				<td class="bx-digit-cell"><?echo intval($ar["ERRORS"])?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGES_PER_SECOND"], 2, ".", " ")?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGE_EXEC_TIME"], 6, ".", " ")?></td>
				<td class="bx-digit-cell"><?echo number_format($ar["PAGE_RESP_TIME"], 6, ".", " ")?></td>
			</tr>
			<?endwhile;?>
			<?if($i==0):?>
			<tr>
				<td colspan="7"><?echo GetMessage('admin_lib_no_data')?></td>
			</tr>
			<?endif;?>
			</table>
			</div>
		</td><?$width = 400; $height = 200;?>
		<td width="<?echo $width?>" align="center" class="adm-detail-valign-top">
			<div id="img_PAGES_PER_SECOND">
			<?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGES_PER_SECOND")?><br>
			<img class="graph" src="/bitrix/admin/perfmon_cluster_graph.php?rand=<?=rand()?>&amp;find_data_type=PAGES_PER_SECOND&amp;width=<?echo $width?>&amp;height=<?echo $height?>&amp;lang=<?echo LANGUAGE_ID?>" width="<?echo $width?>" height="<?echo $height?>">
			</div>
			<br />
			<div id="img_PAGE_EXEC_TIME">
			<?echo GetMessage("PERFMON_PANEL_CLUSTER_PAGE_TIME")?><br>
			<img class="graph" src="/bitrix/admin/perfmon_cluster_graph.php?rand=<?=rand()?>&amp;find_data_type=PAGE_EXEC_TIME&amp;width=<?echo $width?>&amp;height=<?echo $height?>&amp;lang=<?echo LANGUAGE_ID?>" width="<?echo $width?>" height="<?echo $height?>">
			</div>
		</td>
	</tr>
<?$tabControl->End();?>
</form>

<?
echo
	BeginNote()
	,GetMessage("PERFMON_PANEL_REFERENCE_CONFIGURATION", array("<ul>" => "<ul style=\"font-size:100%\">"))
	,EndNote()
	,BeginNote()
	,"<span class=\"required\"><sup>1</sup></span>", GetMessage("PERFMON_PANEL_MARK_NOTE"), "<br>"
	,"<span class=\"required\"><sup>2</sup></span>", GetMessage("PERFMON_PANEL_WARN_NOTE"), "<br>"
	,GetMessage("PERFMON_PANEL_WARN_NOTE_1"), "<br>"
	,GetMessage("PERFMON_PANEL_WARN_NOTE_2"), "<br>"
	,GetMessage("PERFMON_PANEL_WARN_NOTE_3"), "<br>"
	,"<span class=\"required\"><sup>3</sup></span>", GetMessage("PERFMON_PANEL_SESSION_NOTE"), "<br>"
	,EndNote();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
}
?>
