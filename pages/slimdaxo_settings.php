<?php


	$content = '';


	$path = rex_path::addon('slimdaxo', 'setup/.htaccess');
	$htaccess_str = rex_file::get($path);


	$content .=
	'<div class="container-fluid">
		<div class="col-xs-12">
			<h3>Slimdaxo SecretKey</h3>
		</div>
		<div class="col-xs-12 col-sm-9">
			<pre style="white-space: pre-wrap; word-break: normal;">'.$this->getConfig('slimdaxo_secretKey').'</pre>
		</div>
		<div class="col-xs-12 col-sm-3">
			<button class="btn btn-block btn-primary" type="button">Neuen SecretKey</button>
			<p class="text-danger">Button funktioniert noch nicht</p>
		</div>
		<div class="col-xs-12"><hr /></div>
	</div>';


	$content .=
	'<div class="container-fluid">
		<div class="col-xs-12">
			<h3>.htaccess Datei setzen</h3>
			<p>Das Addon "Slimdaxo" benötigt eine .htaccess Datei im Root Ordner. Es wird automatisch geprüft ob eine .htaccess Datei vorhanden ist und derpassende Button eingebunden. Folgende möglichkeiten gibt es:</p>
			<ol>
				<li>Keine .htaccess gefunden: <strong>Neu schreiben</strong></li>
				<li>.htaccess gefunden: <strong>Überschreiben *</strong></li>
				<li>.htaccess von YRewrite gefunden: <strong>Zeile einfügen</strong></li>
			</ol>
			<p>'.slimdaxo_htaccess::getOutput().'</p>
			<p>* Sollte eine andere .htaccess bereits vorhanden sein, wird diese ersetzt und ist nicht wiederherstellbar.</p>
			<hr />
			<h3>.htaccess Datei aus dem Setup Ordner</h3>
			<pre>'.htmlspecialchars($htaccess_str).'</pre>
		</div>
	</div>';


	$fragment = new rex_fragment();
	$fragment->setVar('title', $this->i18n('slimdaxo_settings'));
	$fragment->setVar('body', $content, false);
	echo $fragment->parse('core/page/section.php');
