<?php


	if(rex::isBackend()) {
		// BACKEND
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/7.2.1/jsrsasign-all-min.js");
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/reqwest/2.0.5/reqwest.min.js");
		// set api url
		$url = rex::getServer().'slimdaxo/token';
		rex_view::setJsProperty('slimdaxo_token', base64_encode(rtrim($url)));
	} else {
		// FRONTEND
	}
