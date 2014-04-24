<?php
	$link = mysql_connect('localhost', 'root', '');
	if (!$link) {
		die('Not connected : ' . mysql_error());
	}

	// make bankcruptcy the current db
	$db_selected = mysql_select_db('bankcruptcy', $link);
	if (!$db_selected) {
		die ('Can\'t use bankcruptcy : ' . mysql_error());
	}
?>