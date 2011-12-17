<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

// TODO, is this needed...?
// is this global...? what if we include this files
// from a function...?
global $astman;

// Don't bother uninstalling feature codes, now module_uninstall does it

// remove all D-N-D options in effect on extensions
if ($astman) {
	$astman->database_deltree('DND');
} else {
	fatal("Cannot connect to Asterisk Manager with ".$amp_conf["AMPMGRUSER"]."/".$amp_conf["AMPMGRPASS"]);
}

?>
