<?php


	if(rex::isBackend()) {
		// BACKEND
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/7.2.1/jsrsasign-all-min.js");
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/reqwest/2.0.5/reqwest.min.js");
		slimdaxo::setAuthJsData(false);
	} else {
		// FRONTEND
		rex_extension::register('YCOM_AUTH_LOGIN', function (rex_extension_point $ep) {
			slimdaxo::setAuthJsData(true);
		});
	}




/*
	if(rex::isBackend()) {
		// BACKEND
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/7.2.1/jsrsasign-all-min.js");
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/reqwest/2.0.5/reqwest.min.js");
		// set api url
		$url = rex::getServer().'slimdaxo/token';
		rex_view::setJsProperty('slimdaxo_token', base64_encode(rtrim($url)));
	} else {
		// FRONTEND
		// $ycom_user = rex_ycom_auth::getUser();
		// echo '<pre>';
		// print_r($ycom_user);
		// echo '</pre>';
	}

	rex_extension::register('PACKAGES_INCLUDED', function (rex_extension_point $ep) {
		rex_view::setJsProperty('user', slimdaxo_user::getUser() );
    });

	// // set api url
	// $url = rex::getServer().'slimdaxo/token';
	// rex_view::setJsProperty('slimdaxo_token', base64_encode(rtrim($url)));
	// rex_view::setJsProperty('user', slimdaxo_user::getUser() );
	//
	echo '<pre>';
	print_r(rex_view::getJsProperties());
	echo '</pre>';
*/
