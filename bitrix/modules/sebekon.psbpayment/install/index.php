<?
IncludeModuleLangFile(__FILE__);
Class sebekon_psbpayment extends CModule
{
	const MODULE_ID = 'sebekon.psbpayment';
	var $MODULE_ID = 'sebekon.psbpayment'; 
	
	const IBLOCK_CODE = 'sebekon_psbpayment';
	const EVENT_TYPE = 'SEBEKON_PSBPAYMENT_EVENT';
	
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("sebekon.psbpayment_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("sebekon.psbpayment_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("sebekon.psbpayment_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("sebekon.psbpayment_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		//RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CSebekonPsbpayment', 'OnBuildGlobalMenu');
		
		
		if(!CModule::IncludeModule('sale')) {
			//self::IBLOCK_CODE
			
			$sites = array();
			$rsSites = CSite::GetList($by = 'sort', $order = 'asc', array('ACTIVE' => 'Y'));
			while($arSite = $rsSites->Fetch()) {
				$sites[] = $arSite['ID'];
			}
			
			CModule::IncludeModule('iblock');
			
			// find iblock type
			if(!$arIblockType = CIBlockType::GetList(array('ID'), array('ID' => self::IBLOCK_CODE))->Fetch()) {
				// iblock type
				$arFields = array(
					'ID' => self::IBLOCK_CODE,
					'SECTIONS' => 'N',
					'IN_RSS' => 'N',
					'SORT' => 100,
					'LANG' => array(
						'ru' => array(
							'NAME' => GetMessage(self::MODULE_ID ."_IBLOCK_TYPE_NAME"),
							'ELEMENT_NAME' => GetMessage(self::MODULE_ID ."_IBLOCK_TYPE_ELEMENT_NAME")
						),
						'en'=> array(
							'NAME' => GetMessage(self::MODULE_ID ."_IBLOCK_TYPE_NAME_EN"),
							'ELEMENT_NAME' => GetMessage(self::MODULE_ID ."_IBLOCK_TYPE_ELEMENT_NAME_EN")
						)
					)
				);
				$obBlocktype = new CIBlockType;
				if(!$res = $obBlocktype->Add($arFields)) {
					return false;
				}
			}
			if(!$arIblock = CIBlock::GetList(array('ID'), array('CODE' => self::IBLOCK_CODE, 'IBLOCK_TYPE_ID' => self::IBLOCK_CODE))->Fetch()) {
				// iblock
				$ib = new CIBlock;
				$arFields = array(
					'ACTIVE' => 'Y',
					'NAME' => GetMessage(self::MODULE_ID ."_IBLOCK_NAME"),
					'CODE' => self::IBLOCK_CODE,
					'LIST_PAGE_URL' => '',
					'DETAIL_PAGE_URL' => '',
					'IBLOCK_TYPE_ID' => self::IBLOCK_CODE,
					'SITE_ID' => $sites,
					'SORT' => 100,
					'INDEX_ELEMENT' => 'N',
					'VERSION' => 2,
					'PICTURE' => '',
					'DESCRIPTION' => '',
					'DESCRIPTION_TYPE' => 'html',
					'WORKFLOW' => 'N',
					'GROUP_ID' => array(
						'2' => 'R'
					)
				);
				if(!$iblockId = $ib->Add($arFields)) {
					return false;
				}
				
				
				
				// Properties
				$arAllProperties = array(
					'CARD_NUMBER' => array(
						'PROPERTY_TYPE' 	=> 'S',
						'WITH_DESCRIPTION'	=> 'N',
						'MULTIPLE' 			=> 'N'
					),
					'ORDER_SUM' => array(
						'PROPERTY_TYPE' 	=> 'S',
						'WITH_DESCRIPTION'	=> 'N',
						'MULTIPLE' 			=> 'N'
					),
					'ORDER_STATUS' => array(
						'PROPERTY_TYPE' 	=> 'L',
						'WITH_DESCRIPTION'	=> 'N',
						'MULTIPLE' 			=> 'N',
						'VALUES' 			=> array(
							array(
								'VALUE' 	=> GetMessage(self::MODULE_ID . '_PROPERTY_ORDER_STATUS_VAL_1'),
								'DEF' 		=> 'Y',
								'SORT' 		=> '10',
								'XML_ID' 	=> 1
							),
							array(
								'VALUE' 	=> GetMessage(self::MODULE_ID . '_PROPERTY_ORDER_STATUS_VAL_2'),
								'DEF' 		=> 'N',
								'SORT' 		=> '20',
								'XML_ID' 	=> 2
							),
							array(
								'VALUE' 	=> GetMessage(self::MODULE_ID . '_PROPERTY_ORDER_STATUS_VAL_3'),
								'DEF' 		=> 'N',
								'SORT' 		=> '30',
								'XML_ID' 	=> 3
							),
						)
					),
				);
				$sort = 100;
				
				$arFormFields = array(
					array(
						'NAME' => 'ACTIVE',
						'TITLE' =>  GetMessage(self::MODULE_ID . '_IBLOCK_ELEMENT_FIELDS_ACTIVE'),
					),
					array(
						'NAME' => 'NAME',
						'TITLE' =>  GetMessage(self::MODULE_ID . '_IBLOCK_ELEMENT_FIELDS_NAME'),
					),
					array(
						'NAME' => 'CODE',
						'TITLE' =>  GetMessage(self::MODULE_ID . '_IBLOCK_ELEMENT_FIELDS_CODE'),
					),
					array(
						'NAME' => 'DETAIL_TEXT',
						'TITLE' =>  GetMessage(self::MODULE_ID . '_IBLOCK_ELEMENT_FIELDS_DETAIL_TEXT'),
					),
				);
				
				foreach($arAllProperties as $code => $data) {
					if(!$property = CIBlockProperty::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => $iblockId, 'CODE' => $code))->Fetch()) {		
						$ibp = new CIBlockProperty;
						$arFields = array(
							'NAME' 				=> GetMessage(self::MODULE_ID . '_PROPERTY_' . $code . "_NAME"),
							'ACTIVE' 			=> 'Y',
							'SORT' 				=> $sort,
							'CODE' 				=> $code,
							'PROPERTY_TYPE' 	=> $data['PROPERTY_TYPE'],
							'WITH_DESCRIPTION' 	=> $data['WITH_DESCRIPTION'],
							'MULTIPLE' 			=> $data['MULTIPLE'],
							'IBLOCK_ID' 		=> $iblockId
						);
						
						if(!empty($data['VALUES'])) {
							$arFields['VALUES'] = $data['VALUES'];
						}
						
						$propID = $ibp->Add($arFields);
						$arFormFields[] = array(
							'NAME' => 'PROPERTY_' . $propID,
							'TITLE' =>  GetMessage(self::MODULE_ID . '_PROPERTY_' . $code . "_NAME"),
						);
						$sort += 10;
					}
				}

			}
			
			
			// add form setting
			$tabs = array(
				array(
					'CODE' 		=> 'edit1',
					'TITLE' 	=> GetMessage(self::MODULE_ID . '_IBLOCK_ELEMENT_NAME'),
					'FIELDS' 	=> $arFormFields,
				)
			);

			$tabs_string = ''; 
			foreach($tabs as $tab) { 
				$tabs_string .= $tab['CODE'] . '--#--' . $tab['TITLE'] . '--,--'; 
				foreach($tab['FIELDS'] as $field) { 
					$tabs_string .= $field['NAME'] . '--#--' . $field['TITLE']; 
					if (end($tab['FIELDS']) == $field) { 
						$tabs_string .= '--;--'; 
						continue; 
					} 
					$tabs_string .= '--,--'; 
				} 
			} 


			$arOptions = array(
				array(
					'c' => 'form',
					'n' => 'form_element_' . $iblockId,
					'd' => 'Y',
					'v' => array(
						'tabs' => $tabs_string,
					),
				)
			);
			CUserOptions::SetOptionsFromArray($arOptions);
			
			
			// event type
			$rsET = CEventType::GetList(array("TYPE_ID" => self::EVENT_TYPE));
			if(!$arET = $rsET->Fetch()) {
				// create event type (ru)
				$et = new CEventType;
				$et->Add(array(
					"LID"           => "ru",
					"EVENT_NAME"    => self::EVENT_TYPE,
					"NAME"          => GetMessage(self::MODULE_ID . '_EVENT_TYPE_NAME'),
					"DESCRIPTION"   => GetMessage(self::MODULE_ID . '_EVENT_TYPE_DESC')
				));
				// create event type (en)
				$et = new CEventType;
				$et->Add(array(
					"LID"           => "en",
					"EVENT_NAME"    => self::EVENT_TYPE,
					"NAME"          => GetMessage(self::MODULE_ID . '_EVENT_TYPE_NAME_EN'),
					"DESCRIPTION"   => GetMessage(self::MODULE_ID . '_EVENT_TYPE_DESC_EN')
				));
			}	
				
			$rsMess = CEventMessage::GetList($by = 'id', $order = 'asc', array('TYPE_ID' => self::EVENT_TYPE));
			//$rsSites = CSite::GetList($by = "sort", $order = "desc", array("DEF" => "Y"));
			if((!$arMess = $rsMess->Fetch())) {	
				// create mail template
				$arrEventTemplate["ACTIVE"] = "Y";
				$arrEventTemplate["EVENT_NAME"] = self::EVENT_TYPE;
				$arrEventTemplate["LID"] = $sites;
				$arrEventTemplate["EMAIL_FROM"] = "#DEFAULT_EMAIL_FROM#";
				$arrEventTemplate["EMAIL_TO"] = "#DEFAULT_EMAIL_FROM#";
				$arrEventTemplate["SUBJECT"] = GetMessage(self::MODULE_ID . '_LETTER_TITLE');
				$arrEventTemplate["BODY_TYPE"] = "html";
				$arrEventTemplate["MESSAGE"] = GetMessage(self::MODULE_ID . '_LETTER_MESSAGE');

				$emess = new CEventMessage;
				$emess->Add($arrEventTemplate);
			}
			
		}
		
		
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		//UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CSebekonPsbpayment', 'OnBuildGlobalMenu');
		
		if(!CModule::IncludeModule('sale')) {
			
			CModule::IncludeModule('iblock');
			
			// delete form settings
			if($arIblock = CIBlock::GetList(array('ID' => 'DESC'), array('CODE' => self::IBLOCK_CODE, 'IBLOCK_TYPE_ID' => self::IBLOCK_CODE))->Fetch()) {
				CUserOptions::DeleteOptionsByName('form', 'form_element_' . $arIblock['ID']);
			}
			
			CIBlockType::Delete(self::IBLOCK_CODE);
		
			$rsMess = CEventMessage::GetList($by = 'id', $order = 'desc', array('TYPE_ID' => self::EVENT_TYPE));
			while($arMess = $rsMess->Fetch()) {
				CEventMessage::Delete($arMess['ID']);
			}
			// Delete event type
			$rsET = CEventType::GetList(array("TYPE_ID" => self::EVENT_TYPE));
			if($arET = $rsET->Fetch()) {
				$et = new CEventType;
				$et->Delete(self::EVENT_TYPE);
			}
		}
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item,
					'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.self::MODULE_ID.'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
		
		if(CModule::IncludeModule('sale')) {
		
			if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/sale_payment'))
			{
				if ($dir = opendir($p))
				{
					while (false !== $item = readdir($dir))
					{
						if ($item == '..' || $item == '.')
							continue;
						CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment/'.$item, $ReWrite = True, $Recursive = True);
					}
					closedir($dir);
				}
			}
		}
		return true;
	}

	function UnInstallFiles()
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/sale_payment'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/php_interface/include/sale_payment/'.$item.'/'.$item0);
					}
					closedir($dir0);
					rmdir($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/sale_payment/'.$item.'/');
				}
				closedir($dir);
			}
		}
		
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
