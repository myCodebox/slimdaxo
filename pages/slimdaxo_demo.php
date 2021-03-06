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
			<h3>Hash</h3>
			<pre id="hash" style="white-space: pre-wrap; word-break: normal;"></pre>
		</div>
		<div class="col-xs-12 col-sm-3">
			<button type="button" class="btn btn-block btn-primary" id="gettoken">Get the Token</button>
		</div>
		<div class="col-xs-12"><hr /></div>
		<div class="col-xs-12 col-sm-3 col-sm-offset-9">
			<button type="button" class="btn btn-block btn-primary" id="testtoken">Test the Token</button>
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
			this.token = rex.slimdaxo_path; // b64utos(App.token)
			this.hash  = rex.slimdaxo_hash;
		}

		App.decodeToken = function(jwt){
			var a = jwt.split(".");
			return  b64utos(a[1]);
		}
		App.setJwt = function(token){
			this.jwt = token;
			// this.claim = this.decodeToken(token);
		}

		var gettoken = document.getElementById('gettoken');
		gettoken.addEventListener('click', function(e){
			e.preventDefault();
			App.gettoken();
		}, false);

		App.gettoken = function () {
			reqwest({
				url: b64utos(App.token)+'/token',
				method: 'post',
				data: { hash: App.hash },
				success: function (res) {
					App.setJwt(res.token);
					$('#token').text(res.token);
					$('#expires').text(res.expires);
					$('#hash').text(b64utos(res.hash));
				}
			});
		};

		var testtoken = document.getElementById('testtoken');
		testtoken.addEventListener('click', function(e){
			e.preventDefault();
			App.testtoken();
		}, false);

		App.testtoken = function () {
			reqwest({
				url: b64utos(App.token)+'/test',
				method: 'post',
				contentType: 'application/json',
				headers: {'Authorization':'Bearer '+App.jwt},
				success: function (res) {
					// $('.data_code').text(res.code);
					console.log('OK');
				},
				error: function (err) {
					// $('.data_code').text(err.status+' '+err.statusText);
					// $('.data').text('');
					console.log('NOK');
				}
			});
		};

		if (
			(typeof rex.slimdaxo_path !== "undefined" && rex.slimdaxo_path != "")
			&& (typeof rex.slimdaxo_hash !== "undefined" && rex.slimdaxo_hash != "")
		) {
			App.init();
		}
	})();
</script>
