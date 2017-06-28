<?php


	class slimdaxo
	{


		public static function setAuthJsData($debug = false)
		{
			// set token url
			$url = rex::getServer().'slimdaxo';
			rex_view::setJsProperty('slimdaxo_path', base64_encode(rtrim($url)));

			// set user hash
			if ($ycom_user = rex_ycom_auth::getUser()) {
				$hash = json_encode([
					'uid' => $ycom_user->getId(),
					'key' => $ycom_user->getValue('activation_key'),
					'typ' => 'frontend'
				]);
				rex_view::setJsProperty('slimdaxo_hash', base64_encode(rtrim($hash)) );
			}

			if(rex::isBackend() && $rex_user = rex::getUser()) {
				$hash = json_encode([
					'uid' => $rex_user->getId(),
					'key' => md5('Backend Demo'),
					'typ' => 'backend'
				]);
				rex_view::setJsProperty('slimdaxo_hash', base64_encode(rtrim($hash)) );
			}

			// show debug
			if($debug) {
				echo '<pre>';
				print_r(rex_view::getJsProperties());
				echo '</pre>';
			}
		}


		public static function testUser($arr = null)
		{
			if( is_array($arr) && count($arr) > 0 ) {
				$sql = rex_sql::factory();
				$sql->setDebug(false);
				$sql->setTable(rex::getTablePrefix().'ycom_user');
				$sql->setWhere( ['id' => $arr['uid'], 'activation_key' => $arr['key'], 'status' => 1]);
				$sql->select();
				if($sql->getRows() || $arr['typ'] == 'backend') {
					return true;
				}
			}

			return false;
		}


	}
