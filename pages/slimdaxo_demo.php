<?php


	$content = '';


	$path = rex_path::addon('slimdaxo', 'setup/.htaccess');
	$htaccess_str = rex_file::get($path);

	$content .=
	'<div class="container-fluid">
		<div class="col-xs-12"><h3>Token</h3></div>
		<div class="col-xs-12 col-sm-9">
			<pre id="token" style="white-space: pre-wrap; word-break: normal;"></pre>
			<h3>Expires</h3>
			<pre id="expires" style="white-space: pre-wrap; word-break: normal;"></pre>
		</div>
		<div class="col-xs-12 col-sm-3">
			<button type="button" class="btn btn-block btn-primary" id="gettoken">Get the Token</button>
		</div>
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
			this.token = rex.slimdaxo_token; // b64utos(App.token)
			this.hash  = rex.slimdaxo_hash;
		}

		var gettoken = document.getElementById('gettoken');
		gettoken.addEventListener('click', function(e){
			e.preventDefault();
			App.gettoken();
		}, false);

		App.gettoken = function () {
			reqwest({
				url: b64utos(App.token),
				method: 'post',
				data: { hash: App.hash },
				success: function (res) {
					$('#token').text(res.token);
					$('#expires').text(res.expires);
				}
			});
		};


		if (
			(typeof rex.slimdaxo_token !== "undefined" && rex.slimdaxo_token != "")
			&& (typeof rex.slimdaxo_hash !== "undefined" && rex.slimdaxo_hash != "")
		) {
			App.init();
		}
	})();


</script>
