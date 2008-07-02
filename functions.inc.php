<?php

function donotdisturb_get_config($engine) {
	$modulename = 'donotdisturb';
	
	// This generates the dialplan
	global $ext;  
	switch($engine) {
		case "asterisk":

			// If Using DND then set this so AGI scripts can determine
			//
			if ($amp_conf['USEDEVSTATE']) {
				$ext->addGlobal('DNDDEVSTATE','TRUE');
			}

			if (is_array($featurelist = featurecodes_getModuleFeatures($modulename))) {
				foreach($featurelist as $item) {
					$featurename = $item['featurename'];
					$fname = $modulename.'_'.$featurename;
					if (function_exists($fname)) {
						$fcc = new featurecode($modulename, $featurename);
						$fc = $fcc->getCodeActive();
						unset($fcc);
						
						if ($fc != '')
							$fname($fc);
					} else {
						$ext->add('from-internal-additional', 'debug', '', new ext_noop($modulename.": No func $fname"));
						var_dump($item);
					}	
				}
			}
		break;
	}
}

function donotdisturb_dnd_on($c) {
	global $ext;
	global $amp_conf;

	$id = "app-dnd-on"; // The context to be included

	$ext->addInclude('from-internal-additional', $id); // Add the include from from-internal

	$ext->add($id, $c, '', new ext_answer('')); // $cmd,1,Answer
	$ext->add($id, $c, '', new ext_wait('1')); // $cmd,n,Wait(1)
	$ext->add($id, $c, '', new ext_macro('user-callerid')); // $cmd,n,Macro(user-callerid)
	$ext->add($id, $c, '', new ext_setvar('DB(DND/${AMPUSER})', 'YES')); // $cmd,n,Set(...=YES)
	if ($amp_conf['USEDEVSTATE']) {
		$ext->add($id, $c, '', new ext_setvar('DEVSTATE(Custom:DND${AMPUSER})', 'BUSY')); // $cmd,n,Set(...=YES)
	}
	$ext->add($id, $c, '', new ext_playback('do-not-disturb&activated')); // $cmd,n,Playback(...)
	$ext->add($id, $c, '', new ext_macro('hangupcall')); // $cmd,n,Macro(user-callerid)
}
		
function donotdisturb_dnd_off($c) {
	global $ext;
	global $amp_conf;

	$id = "app-dnd-off"; // The context to be included

	$ext->addInclude('from-internal-additional', $id); // Add the include from from-internal

	$ext->add($id, $c, '', new ext_answer('')); // $cmd,1,Answer
	$ext->add($id, $c, '', new ext_wait('1')); // $cmd,n,Wait(1)
	$ext->add($id, $c, '', new ext_macro('user-callerid')); // $cmd,n,Macro(user-callerid)
	$ext->add($id, $c, '', new ext_dbdel('DND/${AMPUSER}')); // $cmd,n,DBdel(..)
	if ($amp_conf['USEDEVSTATE']) {
		$ext->add($id, $c, '', new ext_setvar('DEVSTATE(Custom:DND${AMPUSER})', 'NOT_INUSE')); // $cmd,n,Set(...=YES)
	}
	$ext->add($id, $c, '', new ext_playback('do-not-disturb&de-activated')); // $cmd,n,Playback(...)
	$ext->add($id, $c, '', new ext_macro('hangupcall')); // $cmd,n,Macro(user-callerid)
}

function donotdisturb_dnd_toggle($c) {
	global $ext;
	global $amp_conf;

	$id = "app-dnd-toggle"; // The context to be included
	$ext->addInclude('from-internal-additional', $id); // Add the include from from-internal

	$ext->add($id, $c, '', new ext_answer(''));
	$ext->add($id, $c, '', new ext_wait('1'));
	$ext->add($id, $c, '', new ext_macro('user-callerid'));

	$ext->add($id, $c, '', new ext_gotoif('$["${DB(DND/${AMPUSER})}" = ""]', 'activate', 'deactivate'));

	$ext->add($id, $c, 'activate', new ext_setvar('DB(DND/${AMPUSER})', 'YES'));
	if ($amp_conf['USEDEVSTATE']) {
		$ext->add($id, $c, '', new ext_setvar('DEVSTATE(Custom:DND${AMPUSER})', 'BUSY'));
	}
	$ext->add($id, $c, '', new ext_playback('do-not-disturb&activated'));
	$ext->add($id, $c, '', new ext_macro('hangupcall'));

	$ext->add($id, $c, 'deactivate', new ext_dbdel('DND/${AMPUSER}'));
	if ($amp_conf['USEDEVSTATE']) {
		$ext->add($id, $c, '', new ext_setvar('DEVSTATE(Custom:DND${AMPUSER})', 'NOT_INUSE'));
	}
	$ext->add($id, $c, '', new ext_playback('do-not-disturb&de-activated'));
	$ext->add($id, $c, '', new ext_macro('hangupcall'));
}

?>
