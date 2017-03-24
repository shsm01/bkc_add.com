<?
/**
 * Here stored actions defenitions
 *
 * Aviable action params:
 *
 *  TYPE:  optional
 *      Now aviable only "CHAIN" - chain of actions.
 *
 *  NAME:  required.
 *      The name of action. Name will be seen by user.
 *
 *  ACTIONS: array (for TYPE = CHAIN only) required.
 *      List of another actions ids from this list witch will be executed in same order
 *
 *  START_COMMAND_TEMPLATE:  (for TYPE != CHAIN) required
 *       Command template, to execute. In this template aviable anchors:
 *       ##USER_PARAMS:PARAM_NAME## - show dialog to user, and ask them to enter param PARAM_NAME
 *       ##SERVER_PARAMS:PARAM_NAME## - Get param PARAM_NAME from server params (now aviable only ip|hostname)
 *       ##INPUT_PARAMS:PARAM_NAME## - results taken from results of previous actions calling.
 *          It usefull only if action takes part in actionschain, and one of previous action returns param PARAM_NAME
 *
 * USER_PARAMS: array optional
 *      Params wich we must to ask to user. Aviable params:
 *      NAME:  required. Param name. User will see it as param name in dialog window.
 *		TYPE:  required. Aviable: STRING, PASSWORD, DROPDOWN, CHECKBOX
 *		REQUIRED:  (Y|N) optional. If user must obligatory to fill this field.
 *      VERIFY_TWICE  (Y|N) optional. If user must confirm param. Password for example.
 *
 *      ASYNC  (Y|N) optional. If command must be executed async asynchronously
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$connection = \Bitrix\Main\Application::getConnection();

$actionsDefinitions = array(

	"NEW_SERVER_CHAIN" => array(
		"TYPE" => "CHAIN",
		"NAME" =>Loc::getMessage("SCALE_ADEF_NEW_SERVER_CHAIN"),
		"ACTIONS" => array(
			"GET_CURRENT_KEY",
			"COPY_KEY_TO_SERVER",
			"ADD_SERVER",
			"MONITORING_UPDATE"
		),
		"PAGE_REFRESH" => "Y"
	),

	"GET_CURRENT_KEY" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a key -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_GET_CURRENT_KEY"),
	),

	"COPY_KEY_TO_SERVER" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a copy -i ##USER_PARAMS:SERVER_IP## -k ##INPUT_PARAMS:sshkey## -p ##USER_PARAMS:ROOT_PASSWD## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_COPY_KEY_TO_SERVER"),
		"USER_PARAMS" => array(
			"SERVER_IP" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NET_ADDRESS"),
				"TYPE" => "STRING",
				"REQUIRED" => "Y",
			),
			"ROOT_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_ROOT_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y"
			)
		)
	),

	"ADD_SERVER" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a add -i ##USER_PARAMS:SERVER_IP## -H ##USER_PARAMS:HOSTNAME## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_ADD_SERVER"),
		"USER_PARAMS" => array(
			"SERVER_IP" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NET_ADDRESS"),
				"TYPE" => "STRING",
				"REQUIRED" => "Y"
			),
			"HOSTNAME" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_HOSTNAME"),
				"TYPE" => "STRING",
				"REQUIRED" => "Y"
			)
		)
	),

	"CREATE_PULL" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a create -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_CREATE_PULL"),
		"PAGE_REFRESH" => "Y"
	),


	"DEL_SERVER" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a del -H ##SERVER_PARAMS:hostname## -i ##SERVER_PARAMS:ip## -o json",
		"NAME" =>Loc::getMessage("SCALE_ADEF_DEL_SERVER"),
		"PAGE_REFRESH" => "Y"
	),

	"CHANGE_PASSWD" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a pw -i ##SERVER_PARAMS:ip## -p ##USER_PARAMS:OLD_PASSWD## -P ##USER_PARAMS:NEW_PASSWD## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_NAME"),
		"USER_PARAMS" => array(
			"OLD_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_OLD_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y"
			),
			"NEW_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NEW_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y",
				"VERIFY_TWICE" => "Y"
			)
		)
	),

	"CHANGE_PASSWD_FIRST" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a pw -i ##USER_PARAMS:SERVER_IP## -p ##USER_PARAMS:OLD_PASSWD## -P ##USER_PARAMS:NEW_PASSWD## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_NAME"),
		"USER_PARAMS" => array(
			"SERVER_IP" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NET_ADDRESS"),
				"TYPE" => "STRING"
			),
			"OLD_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_OLD_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y"
			),
			"NEW_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NEW_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y",
				"VERIFY_TWICE" => "Y"
			)
		)
	),

	"MONITORING_ENABLE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-monitor -a enable -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MONITORING_ENABLE"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"CONDITION" => array(
			"COMMAND" => "sudo -u root /opt/webdir/bin/bx-monitor -o json",
			"PARAMS" => array( "monitor:monitoring_status", "===", "'disable'")
		)
	),

	"MONITORING_DISABLE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-monitor -a disable -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MONITORING_DISABLE"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"CONDITION" => array(
			"COMMAND" => "sudo -u root /opt/webdir/bin/bx-monitor -o json",
			"PARAMS" => array( "monitor:monitoring_status", "===", "'enable'")
		)
	),

	"MONITORING_UPDATE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-monitor -a update -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MONITORING_UPDATE")
	),

	"MYSQL_ADD_SLAVE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-mysql -a slave -s ##SERVER_PARAMS:hostname## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MYSQL_ADD_SLAVE"),
		"ASYNC" => "Y",
		"BACKUP_ALERT" => "Y",
		"PAGE_REFRESH" => "Y",
		"MODIFYERS" => array(
			"\\Bitrix\\Scale\\ActionModifyer::mysqlAddSlave",
			"\\Bitrix\\Scale\\ActionModifyer::checkExtraDbExist",
		)
	),

	"MYSQL_CHANGE_MASTER" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-mysql -a master -s ##SERVER_PARAMS:hostname## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MYSQL_CHANGE_MASTER"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"BACKUP_ALERT" => "Y",
		"MODIFYERS" => array(
			"\\Bitrix\\Scale\\ActionModifyer::checkExtraDbExist",
		)
	),

	"MYSQL_DEL_SLAVE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-mysql -a remove -s ##SERVER_PARAMS:hostname## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_MYSQL_DEL_SLAVE"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"BACKUP_ALERT" => "Y",
		"MODIFYERS" => array(
			"\\Bitrix\\Scale\\ActionModifyer::checkExtraDbExist",
		)
	),

	"MEMCACHED_ADD_ROLE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-mc -o json -a create -s ##SERVER_PARAMS:hostname##",
		"NAME" => Loc::getMessage("SCALE_ADEF_MEMCACHED_ADD_ROLE"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y"
	),

	"MEMCACHED_DEL_ROLE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-mc -o json -a remove -s ##SERVER_PARAMS:hostname##",
		"NAME" => Loc::getMessage("SCALE_ADEF_MEMCACHED_DEL_ROLE"),
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y"
	),

	"SET_EMAIL_SETTINGS" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -o json -a email".
			" --smtphost=##USER_PARAMS:SMTP_HOST##".
			" --smtpport=##USER_PARAMS:SMTP_PORT##".
			" --smtpuser='##USER_PARAMS:SMTP_USER##'".
			" --email='##USER_PARAMS:EMAIL##'".
			" --site='##USER_PARAMS:SITE_NAME_CONF##'".
			" ##USER_PARAMS:SMTPTLS##".
			" --password=##USER_PARAMS:USER_PASSWORD## ",
		"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL"),
		"PAGE_REFRESH" => "Y",
		"USER_PARAMS" => array(
			"SITE_NAME" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SITE"),
				"TYPE" => "TEXT"
			),
			"SITE_NAME_CONF" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SITE_NAME_CONF"),
				"TYPE" => "TEXT"
			),
			"SMTP_HOST" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SMTP_HOST"),
				"TYPE" => "STRING"
			),
			"SMTP_PORT" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SMTP_PORT"),
				"TYPE" => "STRING"
			),
			"SMTP_USER" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SMTP_USER"),
				"TYPE" => "STRING",
			),
			"USER_PASSWORD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_USER_PASSWORD"),
				"TYPE" => "PASSWORD",
				"VERIFY_TWICE" => "Y"
			),
			"EMAIL" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_EMAIL"),
				"TYPE" => "STRING",
			),
			"SMTPTLS" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SET_EMAIL_SMTPTLS"),
				"TYPE" => "CHECKBOX",
				"CHECKED" => "N",
				"STRING" => "--smtptls"
			)
		)
	),

	"CRON_SET" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -s ##VM_SITE_ID## -a cron --enable",
		"NAME" => Loc::getMessage("SCALE_ADEF_CRON_SET"),
		"PAGE_REFRESH" => "Y"
	),

	"CRON_UNSET" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -s ##VM_SITE_ID## -a cron --disable",
		"NAME" => Loc::getMessage("SCALE_ADEF_CRON_UNSET"),
		"PAGE_REFRESH" => "Y"
	),

	"HTTP_OFF" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -s ##VM_SITE_ID## -a https --enable",
		"NAME" => Loc::getMessage("SCALE_ADEF_HTTP_OFF"),
		"PAGE_REFRESH" => "Y"
	),

	"HTTP_ON" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -s ##VM_SITE_ID## -a https --disable",
		"NAME" => Loc::getMessage("SCALE_ADEF_HTTP_ON"),
		"PAGE_REFRESH" => "Y"
	),

	"REBOOT" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a bx_reboot -H ##SERVER_PARAMS:hostname## -o json",
		"ASYNC" => "Y",
		"NAME" => Loc::getMessage("SCALE_ADEF_REBOOT")
	),

	"UPDATE_BVM" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a bx_update -H ##SERVER_PARAMS:hostname## -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"NAME" => Loc::getMessage("SCALE_ADEF_BVM_UPDATE")
	),

	"UPDATE_ALL_BVMS" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a bx_update -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"NAME" => Loc::getMessage("SCALE_ADEF_BVM_UPDATE")
	),

	"CHANGE_PASSWD_BITRIX" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a bx_passwd -u bitrix -H ##SERVER_PARAMS:hostname## -P ##USER_PARAMS:NEW_PASSWD## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_CHANGE_PASSWD_BITRIX"),
		"USER_PARAMS" => array(
			"NEW_PASSWD" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CHPASS_UP_NEW_PASS"),
				"TYPE" => "PASSWORD",
				"REQUIRED" => "Y",
				"VERIFY_TWICE" => "Y"
			)
		)
	),

	"SITE_ADD" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites".
			" -o json".
			" -a create".
			" -s ##USER_PARAMS:SITE_NAME##".
			" -t link".
			" --kernel_site ##CODE_PARAMS:KERNEL_SITE##".
			" --kernel_root ##CODE_PARAMS:KERNEL_ROOT##".
/*			" -d ##USER_PARAMS:DB_NAME##".
			" -u ##USER_PARAMS:DB_USERNAME##".
			" -p ##USER_PARAMS:DB_USERPASS##".*/
			" -r ##USER_PARAMS:SITE_PATH##",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"USER_PARAMS" => array(
			"SITE_NAME" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD_NAME"),
				"TYPE" => "STRING",
				"REQUIRED" => "Y"
			),
/*			"DB_NAME" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD_DB_NAME"),
				"TYPE" => "STRING"
			),
			"DB_USERNAME" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD_DB_USERNAME"),
				"TYPE" => "STRING"
			),
			"DB_USERPASS" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD_DB_USERPASS"),
				"TYPE" => "PASSWORD",
				"VERIFY_TWICE" => "Y"
			),*/
			"SITE_PATH" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SITE_ADD_SITE_PATH"),
				"TYPE" => "STRING"
			)
		),
		"CODE_PARAMS" => array(
			"KERNEL_ROOT" => 'return \Bitrix\Scale\SitesData::getKernelRoot();',
			"KERNEL_SITE" => 'return \Bitrix\Scale\SitesData::getKernelSite();',
		)
	),

	"SITE_DEL" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_SITE_DEL"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -o json -a delete -s ##VM_SITE_ID##",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y"
	),

	"APACHE_ADD_ROLE" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_APACHE_ADD_ROLE"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -H ##SERVER_PARAMS:hostname## -a web --enable  -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y"
	),

	"APACHE_DEL_ROLE" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_APACHE_DEL_ROLE"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sites -H ##SERVER_PARAMS:hostname## -a web --disable  -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y"
	),

	"SPHINX_ADD_ROLE" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_SPHINX_ADD_ROLE"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sphinx -a create -s ##SERVER_PARAMS:hostname## --dbname ##CODE_PARAMS:DB_NAME## ##USER_PARAMS:INDEX## -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"USER_PARAMS" => array(
			"INDEX" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_SPHINX_ADD_ROLE_INDEX"),
				"TYPE" => "CHECKBOX",
				"CHECKED" => "N",
				"STRING" => "--reindex"
			),
		),
		"CODE_PARAMS" => array(
			"DB_NAME" => 'return \Bitrix\Main\Application::getConnection()->getDbName();'
		)
	),

	"SPHINX_DEL_ROLE" => array(
		"NAME" => Loc::getMessage("SCALE_ADEF_SPHINX_DEL_ROLE"),
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/bx-sphinx -a remove -s ##SERVER_PARAMS:hostname## --dbname ##CODE_PARAMS:DB_NAME## -o json",
		"ASYNC" => "Y",
		"PAGE_REFRESH" => "Y",
		"CODE_PARAMS" => array(
			"DB_NAME" => 'return \Bitrix\Main\Application::getConnection()->getDbName();'
		)
	),

	"CREATE_PULL_NET_IFACE" => array(
		"START_COMMAND_TEMPLATE" => "sudo -u root /opt/webdir/bin/wrapper_ansible_conf -a create -I ##USER_PARAMS:NET_IFACE## -o json",
		"NAME" => Loc::getMessage("SCALE_ADEF_CREATE_PULL"),
		"PAGE_REFRESH" => "Y",
		"USER_PARAMS" => array(
			"NET_IFACE" => array(
				"NAME" => Loc::getMessage("SCALE_ADEF_CREATE_PULL_NET_IFACE"),
				"TYPE" => "DROPDOWN",
				"VALUES" => \Bitrix\Scale\Helper::getNetworkInterfaces()
			)
		)
	)
);
?>