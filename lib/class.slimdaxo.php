<?php


	class slimdaxo
	{


		public function setAuthJsData($debug = false)
		{
			// set token url
			$url = rex::getServer().'slimdaxo/token';
			rex_view::setJsProperty('slimdaxo_token', base64_encode(rtrim($url)));

			// set user hash
			if ($ycom_user = rex_ycom_auth::getUser()) {
				$hash = json_encode([
					'uid' => $ycom_user->getId(),
					'key' => $ycom_user->getValue('activation_key'),
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


	}
