<?php


	$content = '';


	$path = rex_path::addon('slimdaxo', 'setup/.htaccess');
	$htaccess_str = rex_file::get($path);

	$content .=
		'<div class="container-fluid">
			<div class="col-xs-12"><h3>Token</h3></div>
			<div class="col-xs-10"><pre id="token" style="white-space: pre-wrap; word-break: normal;"></pre></div>
			<div class="col-xs-2"><button type="button" id="gettoken">Get the Token</button></div>

			<div class="col-xs-12"><h3>Expires</h3></div>
			<div class="col-xs-10"><pre id="expires" style="white-space: pre-wrap; word-break: normal;"></pre></div>
		</div>';


	$fragment = new rex_fragment();
	$fragment->setVar('title', $this->i18n('slimdaxo_demo'));
	$fragment->setVar('body', $content, false);
	echo $fragment->parse('core/page/section.php');

?>

<script type="text/javascript">

	(function () {
		"use strict";

		var App = App || {};

		App.init = function () {
			this.token_url 	= rex.slimdaxo_token; // b64utos(App.token)
			this.hash 		= null;
		}

		var gettoken = document.getElementById('gettoken');
		gettoken.addEventListener('click', function(e){
			e.preventDefault();
			App.gettoken();
		}, false);

		App.gettoken = function () {
			reqwest({
				url: b64utos(App.token_url),
				method: 'post',
				success: function (res) {
					$('#token').text(res.token);
					$('#expires').text(res.expires);
				}
			});
		};


		if (typeof rex.slimdaxo_token !== "undefined" && rex.slimdaxo_token != "") {
			App.init();
		}
	})();


</script>
