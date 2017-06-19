<?php


	if(rex::isBackend()) {
		// BACKEND
		rex_view::addJsFile($this->getAssetsUrl('js/jsrsasign.min.js'));
		// set api url
		$url = rex::getServer().'slimdaxo/token';
		rex_view::setJsProperty('slimdaxo_token', base64_encode($url));
	} else {
		// FRONTEND
	}
