<?php

	// CONFIG
	if (!$this->hasConfig('slimdaxo_secretKey')) {
		// SecretKey for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
		$secretKey = base64_encode(openssl_random_pseudo_bytes(64));
		$this->setConfig('slimdaxo_secretKey', $secretKey);
	}

	// CACHE
	rex_delete_cache();
