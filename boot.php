<?php

	if(rex::isBackend()) {
		// BACKEND
		slimdaxo::setAuthJsData(false);

		// backend demo stuff
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/7.2.1/jsrsasign-all-min.js");
		rex_view::addJsFile("https://cdnjs.cloudflare.com/ajax/libs/reqwest/2.0.5/reqwest.min.js");
	} else {
		// FRONTEND
		rex_extension::register('YCOM_AUTH_LOGIN', function (rex_extension_point $ep){
			slimdaxo::setAuthJsData(true);
		});
	}
