<?


class LS
{
	static function preparePhone($phone)
	{
		$phone = str_replace("+", "", $phone);
		$phone = str_replace(" ", "", $phone);
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace("-", "", $phone);
		return $phone;
	}

	static function toLog($str)
	{
		$file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/tmplog.txt");
		$file .= "\n\r".$str;
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/tmplog.txt", $file);
	}

	static function formatNum($num)
	{
		return number_format($num, 2, ',', ' ');
	}

	static function formatRating($num)
	{
		return (!$num)? '0.0': number_format($num, 1, '.', ' ');
	}

	static function toSession($item, $session_name)
	{
		$deff = $_SESSION[$session_name];
		if($deff)
		{
			$deff = explode(";", $deff);
			$deff[] = $item;
		}
		else
		{
			$deff = array($item);
		}
		$deff = implode(';', $deff);
		$_SESSION[$session_name] = $deff;
	}

	static function inSession($item, $session_name)
	{
		$deff = $_SESSION[$session_name];
		$res = false;
		if($deff)
		{
			$deff = explode(";", $deff);
			if(in_array($item, $deff))
			{
				$res = true;
			}
		}
		return $res;
	}

	static function countSession($session_name)
	{
		$deff = $_SESSION[$session_name];
		$res = 0;
		if($deff)
		{
			$deff = explode(";", $deff);
			$res = count($deff);
		}
		return $res;
	}

	static function delSession($item, $session_name)
	{
		if(!self::inSession($item, $session_name))
		{
			return false;
		}
		$deff = $_SESSION[$session_name];
		$deff = explode(";", $deff);
		$tmp = array();
		foreach($deff as $d)
		{
			if($d != $item)
			{
				$tmp[] = $d;
			}
		}
		$deff = $tmp;
		$deff = implode(';', $deff);
		$_SESSION[$session_name] = $deff;
	}

	static function getSession($session_name)
	{
		$deff = $_SESSION[$session_name];
		$deff = explode(";", $deff);
		$tmp = array();
		foreach($deff as $d)
		{
			if(trim($d))
			{
				$tmp[] = $d;
			}
		}
		return $tmp;
	}

	static function getPrice($ID)
	{		return CCatalogProduct::GetOptimalPrice($ID);	}

	static function addToBasket($id, $cnt = 1)
	{
		return Add2BasketByProductID(intval($id), $cnt);
	}

	static function getBasket()
	{
		$arBasketItems = array();
		$dbBasketItems = CSaleBasket::GetList(
       		array(
               	"NAME" => "ASC",
                "ID" => "ASC"
            ),
	        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
        	false,
    	    false,
	        array("ID", "CALLBACK_FUNC", "MODULE",
              "PRODUCT_ID", "QUANTITY", "DELAY",
              "CAN_BUY", "PRICE", "WEIGHT")
    	);
    	$sum = 0;
    	$productIDs = array();
    	$productSUM = array();
		while ($arItems = $dbBasketItems->Fetch())
		{
		    if (strlen($arItems["CALLBACK_FUNC"]) > 0)
		    {
        		CSaleBasket::UpdatePrice($arItems["ID"],
                                 $arItems["CALLBACK_FUNC"],
                                 $arItems["MODULE"],
                                 $arItems["PRODUCT_ID"],
                                 $arItems["QUANTITY"]);
		        $arItems = CSaleBasket::GetByID($arItems["ID"]);
		    }
		    $sum += $arItems["PRICE"]*$arItems["QUANTITY"];
		    $productIDs[] = $arItems["PRODUCT_ID"];
		    $productSUM[$arItems["PRODUCT_ID"]*1] = $arItems;

		    $arBasketItems[$arItems["PRODUCT_ID"]*1] = $arItems;
		}
		$discount = 0;
		if(count($productIDs))
		{
			$rsProducts = CIBlockElement::GetList(Array("ID"=>"ASC"), Array("ID"=>$productIDs), false, false, Array("ID", "NAME", "CATALOG_GROUP_2"));
			while($arProduct = $rsProducts->Fetch())
			{
				if(is_array($productSUM[$arProduct["ID"]*1]))
				{
					if($arProduct["CATALOG_PRICE_2"]*1 != $productSUM[$arProduct["ID"]*1]["PRICE"]*1)
					{
						$discount += ($arProduct["CATALOG_PRICE_2"]*1 - $productSUM[$arProduct["ID"]*1]["PRICE"]*1)*$productSUM[$arProduct["ID"]*1]["QUANTITY"]*1;
					}
				}
				$arBasketItems[$arProduct["ID"]*1]["PICTURE"] = $preview;
				$arBasketItems[$arProduct["ID"]*1]["PRODUCT_NAME"] = $arProduct["NAME"];
			}
		}

		return Array("ITEMS" => $arBasketItems, "SUM" => $sum, "DISCOUNT" => $discount);
	}

	static function getProps($person_type)
	{
		$db_props = CSaleOrderProps::GetList(
			array("SORT" => "ASC"),
			array(
            	"PERSON_TYPE_ID" => $person_type,
                "ACTIVE" => "Y"
            ),
	        false,
	        false,
	        array()
	    );
	    $result = array();
	    while($arProp = $db_props->GetNext())
	    {
	    	$result[$arProp["CODE"]] = $arProp;
	 	}
	 	return $result;
	}

	static function getDelivery($ID)
	{
		$rsDelivery = CSaleDelivery::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), Array("ACTIVE"=>"Y", "ID"=>$ID));
        $arDelivery = $rsDelivery->GetNext();
        return ($arDelivery)? $arDelivery: false;
	}

	static function checkAuthorize($ucache)
	{
		global $USER, $APPLICATION;
		if(CModule::IncludeModule('iblock') && strlen($ucache) > 0 && !$USER->IsAuthorized())
		{			$rsUser = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>"50", "PROPERTY_CACHE"=>$ucache), false, false, Array("ID", "PROPERTY_USER_ID"));
			$arUser = $rsUser->Fetch();
			if($arUser["PROPERTY_USER_ID_VALUE"]*1 > 0)
			{				$USER->Authorize($arUser["PROPERTY_USER_ID_VALUE"]);			}		}	}

	//добавляем заказ
	static function addOrder($props, $payment=4, $delivery=4)
	{
		global $USER, $APPLICATION;
		//если пользователь заполнил свои данные и не авторизован, то регистрируем его
		if(!$USER->IsAuthorized())
		{
			$email = $props["EMAIL"];
			$fio = $props["FIO"];

			$user=false;
			$filter = Array("EMAIL"=> $email);
			$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
			$arUser = array();
			while($arUser = $rsUsers->GetNext())
			{
				$user = true;
			}
			if(!$user)
			{
				//если с таким мылом нет юзера
				$pass=rand(111111111, 999999999);
				COption::SetOptionString("main","captcha_registration","N");
				$arUserResult = $USER->Register($email, $fio, "", $pass, $pass, $email);
				COption::SetOptionString("main","captcha_registration","Y");

				$cl_user = new CUser;
				$fields = Array(
					"PERSONAL_PHONE"               => $props["PHONE"],
				);
				$cl_user->Update($USER->GetID(), $fields);
			}else{
				$USER->Authorize($user);
			}
		}

		$arBasketItems = self::getBasket();

		$html = array();
		$pnum = 1;
		foreach($arBasketItems["ITEMS"] as $item)
		{
			$html[] = $pnum.". ".$item["PRODUCT_NAME"]." на сумму ".($item["QUANTITY"]*$item["PRICE"])." руб.";
			$pnum++;
		}
		$html = implode("<br>", $html);

		//проверка доставки
		$arDelivery = self::getDelivery($delivery);

		$arFields = array(
			"LID" => SITE_ID,
			"PERSON_TYPE_ID" => '2',
			"PAYED" => "N",
			"CANCELED" => "N",
			"STATUS_ID" => "N",
			"PRICE" => $arBasketItems["SUM"],
			"CURRENCY" => "RUB",
			"PRICE_DELIVERY"=>$arDelivery["PRICE"],
			"USER_ID" => IntVal($USER->GetID()),
			"DELIVERY_ID" => $arDelivery["ID"],
			"PAY_SYSTEM_ID" => $payment,
			"DISCOUNT_VALUE" => 0,
			"USER_DESCRIPTION" => "",
		);

		$ORDER_ID = CSaleOrder::Add($arFields);
		$ORDER_ID = IntVal($ORDER_ID);

		if($ORDER_ID <= 0)
		{
			if($ex = $APPLICATION->GetException())
				echo $ex->GetString();
		}
		else
		{
			CSaleBasket::OrderBasket($ORDER_ID, CSaleBasket::GetBasketUserID(), SITE_ID); //привязываем товары к заказу

			//определяем свойства заказа
			$db_props = self::getProps('2');
			foreach($props as $code => $val)
			{
				if(is_array($val))
				{
					$tmp_props = CSaleOrderProps::GetList(
				        array("SORT" => "ASC"),
				        array(
                			"ACTIVE" => "Y",
                			"CODE" => $code
			            ),
				        false,
				        false,
				        array()
				    );
					if($arTmpProp = $tmp_props->GetNext())
					{
						$db_vars = CSaleOrderPropsVariant::GetList(($by="SORT"), ($order="ASC"), Array("ORDER_PROPS_ID"=>$arTmpProp["ID"]));
						$arPropVariant = array();
				        while ($vars = $db_vars->Fetch())
						{
							$arPropVariant[$vars["VALUE"]] = $vars;
						}
						$mean = array();
						foreach($val as $vv)
						{
							$mean[] = $arPropVariant[$vv]["NAME"];
						}
						$val = implode('; ', $mean);
					}
				}
				$arFields = array(
					"ORDER_ID" => $ORDER_ID,
					"NAME" => $db_props[$code]["NAME"],
					"ORDER_PROPS_ID" => $db_props[$code]["ID"],
					"VALUE" => $val
				);
				CSaleOrderPropsValue::Add($arFields);
			}
			//добавляем ФИО
			$val = $props["FIO"];
			if($user)
			{
				$val = $arUser["LAST_NAME"]." ".$arUser["NAME"]." ".$arUser["SECOND_NAME"];
			}
			$arFields = array(
				"ORDER_ID" => $ORDER_ID,
				"NAME" => $db_props["FIO"]["NAME"],
				"ORDER_PROPS_ID" => $db_props["FIO"]["ID"],
				"VALUE" => $val
			);
			CSaleOrderPropsValue::Add($arFields);

			$cache = md5($USER->GetID().time());
			$el = new CIBlockElement();
			$PROP = array();
			$PROP[328] = $USER->GetID();
			$PROP[330] = $cache;

			$arUFields = array(
				"ACTIVE"=>"Y",
				"NAME"=>$USER->GetID().$cache,
				"PROPERTY_VALUES" => $PROP,
				"IBLOCK_ID"      => 50
			);

			if($el->Add($arUFields))
			{
				$paylink = '<a href="http://'.$_SERVER['HTTP_HOST'].'/psbank/?ORDER_ID='.$ORDER_ID.'&ucache='.$cache.'">Оплатить</a>';

				//отправляем письмо
				$arEventFields = array(
					"ORDER_ID" => $ORDER_ID,
					"PRICE" => self::formatNum($arBasketItems["SUM"]*1+$arDelivery["PRICE"]*1)." руб",
					"ORDER_DATE" => date("d.m.Y"),
					"ORDER_USER" => $val,
					"ORDER_LIST" => $html,
					"EMAIL" => $props["EMAIL"],
					"PAY_LINK" => $paylink

				);
				CEvent::Send("NEW_ORDER", SITE_ID, $arEventFields);
			}
		}
		return ($ORDER_ID*1 > 0)? $ORDER_ID: false;
	}


}

?>