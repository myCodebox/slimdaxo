<script type="text/javascript">

	(function () {
		"use strict";

		var App = App || {};

		App.init = function () {
			this.token = rex.slimdaxo_token; // b64utos(App.token)
		}

		if (typeof rex.slimdaxo_token !== "undefined" && rex.slimdaxo_token != "") {
			App.init();
		}
	})();


</script>

<?php


	$content = '';


	$path = rex_path::addon('slimdaxo', 'setup/.htaccess');
	$htaccess_str = rex_file::get($path);

	$content .= '<div class="container-fluid">
			<div class="col-xs-12">
				<h3>Token</h3>
				<pre id="token"></pre>
			</div>
		</div>';


	$fragment = new rex_fragment();
	$fragment->setVar('title', $this->i18n('slimdaxo_demo'));
	$fragment->setVar('body', $content, false);
	echo $fragment->parse('core/page/section.php');
